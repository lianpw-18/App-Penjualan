<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kas;
use App\Models\Supplier;
use App\Models\ProdukMasuk;
use App\Models\PembelianBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdukMasukController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        $pembelianBarang = PembelianBarang::with(['kategori', 'satuan'])->orderBy('created_at', 'DESC')->get();
        
        // Debug - hapus setelah berhasil
        // dd('Suppliers:', $suppliers->toArray(), 'Pembelian Barang:', $pembelianBarang->toArray());
        
        return view('produk-masuk.index', [
            'suppliers' => $suppliers,
            'pembelianBarang' => $pembelianBarang
        ]);
    }

    public function getDataProdukMasuk()
    {
        try {
            $produkMasuk = ProdukMasuk::with('supplier')->orderBy('id', 'DESC')->get();

            // Debug - hapus setelah berhasil
            // dd('Data produk masuk:', $produkMasuk->toArray());

            // Return data dalam format JSON langsung, bukan render view
            return response()->json([
                'success' => true,
                'data'    => $produkMasuk
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    public function store(Request $request)
    {
        // Debug - hapus setelah berhasil
        // dd('Request data:', $request->all());
        
        try {
            $validator = Validator::make($request->all(), [
                'pembelian_barang_id' => 'required|exists:pembelian_barangs,id',
                'tgl_masuk'          => 'required|date',
                'stok_masuk'         => 'required|integer|min:1',
                'supplier_id'        => 'required|exists:suppliers,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Ambil data pembelian barang
            $pembelianBarang = PembelianBarang::findOrFail($request->pembelian_barang_id);

            // Generate kode transaksi
            $kd_transaksi = 'PRD-IN-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

            // Hitung total harga
            $total_harga = $request->stok_masuk * $pembelianBarang->harga_beli;
            
            // Validasi agar tidak melebihi batas DECIMAL(8,2) = 999,999.99
            if ($total_harga > 999999.99) {
                return response()->json([
                    'success' => false,
                    'message' => 'Total harga terlalu besar. Maksimal Rp 999,999.99. Kurangi stok masuk atau gunakan harga beli yang lebih kecil.'
                ], 422);
            }

            // Simpan produk masuk
            $produkMasuk = ProdukMasuk::create([
                'kd_transaksi' => $kd_transaksi,
                'nm_produk'    => $pembelianBarang->nm_barang,
                'tgl_masuk'    => $request->tgl_masuk,
                'stok_masuk'   => $request->stok_masuk,
                'harga_beli'   => $pembelianBarang->harga_beli,
                'total_harga'  => $total_harga,
                'user_id'      => auth()->id(),
                'supplier_id'  => $request->supplier_id
            ]);

            // Update kas dan stok
            $this->updateKas($total_harga);
            $this->updateStokPembelianBarang($pembelianBarang->id, $request->stok_masuk);

            return response()->json([
                'success' => true,
                'message' => 'Data produk masuk berhasil disimpan',
                'data'    => $produkMasuk
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Method untuk mendapatkan detail pembelian barang (untuk autocomplete/select)
    public function getPembelianBarangDetail($id)
    {
        $pembelianBarang = PembelianBarang::with(['kategori', 'satuan'])->find($id);

        if (!$pembelianBarang) {
            return response()->json(['message' => 'Pembelian barang tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id'          => $pembelianBarang->id,
                'nm_barang'   => $pembelianBarang->nm_barang,
                'deskripsi'   => $pembelianBarang->deskripsi,
                'stok'        => $pembelianBarang->stok,
                'harga_beli'  => $pembelianBarang->harga_beli,
                'harga_jual'  => $pembelianBarang->harga_jual,
                'kategori'    => $pembelianBarang->kategori->nama ?? null,
                'satuan'      => $pembelianBarang->satuan->nama ?? null
            ]
        ]);
    }

    private function updateKas($pengeluaran)
    {
        $tanggalHariIni = Carbon::now()->toDateString();
        $hariSebelumnya = Carbon::yesterday()->toDateString();

        $kasHariIni = Kas::firstOrCreate(['tanggal' => $tanggalHariIni], [
            'pemasukan' => 0,
            'pengeluaran' => 0,
            'saldo' => 0
        ]);

        if ($kasHariIni->wasRecentlyCreated) {
            $kasKemarin = Kas::where('tanggal', $hariSebelumnya)->first();
            if ($kasKemarin) {
                $kasHariIni->saldo = $kasKemarin->saldo;
            }
        }

        $kasHariIni->pengeluaran += $pengeluaran;
        $kasHariIni->saldo -= $pengeluaran;
        $kasHariIni->save();
    }

    private function updateStokPembelianBarang($pembelianBarangId, $stokMasuk)
    {
        $pembelianBarang = PembelianBarang::find($pembelianBarangId);
        
        if ($pembelianBarang) {
            $pembelianBarang->stok += $stokMasuk;
            $pembelianBarang->save();
        }
    }

    public function destroy($id)
    {
        try {
            $produkMasuk = ProdukMasuk::findOrFail($id);
            $produkMasuk->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data produk masuk berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data'
            ], 500);
        }
    }
}