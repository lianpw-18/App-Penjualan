<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kas;
use App\Models\PenjualanBarang;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Models\DetailPenjualan;
use App\Models\SettingPenjualan;
use App\Models\Produk;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settingPenjualan = SettingPenjualan::first();

        // Debug: cek apakah data ada
        $penjualanbarangs = penjualanbarang::where('stok', '>', 0)->get();

        // Debug: log untuk melihat data
        Log::info('Data pembelian barangs:', $penjualanbarangs->toArray());

        return view('menu-penjualan.index', [
            'penjualanbarangs'   => $penjualanbarangs,
            'diskon_enabled'    => $settingPenjualan ? $settingPenjualan->diskon_enabled == 1 : false,
            'ppn_enabled'       => $settingPenjualan ? $settingPenjualan->ppn_enabled == 1 : false,
            'diskonPresentase'  => $settingPenjualan ? $settingPenjualan->diskon_presentase : 0,
            'ppnPresentase'     => $settingPenjualan ? $settingPenjualan->ppn_presentase : 0,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            $kd_pembelian = 'INV-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $jumlah_pembayaran = $request->input('jumlah_pembayaran');
            $subTotal = $request->input('sub_total');
            $diskon = $request->input('diskon');
            $ppn = $request->input('ppn');
            $uang_kembalian = $request->input('uang_kembalian');

            $penjualan = new Penjualan();
            $penjualan->kd_pembelian_barang = $kd_pembelian;
            $penjualan->tgl_transaksi = Carbon::now();
            $penjualan->jumlah_pembayaran = $jumlah_pembayaran;
            $penjualan->sub_total = $subTotal;
            $penjualan->uang_kembalian = $uang_kembalian;
            $penjualan->diskon = $diskon;
            $penjualan->ppn = $ppn;
            $penjualan->save();

            // Kas logic
            $hariSebelumnya = Carbon::now()->subDay()->toDateString();
            $tanggalTransaksi = Carbon::now()->toDateString();
            $kasEntry = Kas::where('tanggal', $tanggalTransaksi)->first();
            $kasEntryHariSebelumnya = Kas::where('tanggal', $hariSebelumnya)->first();

            if ($kasEntry) {
                $kasEntry->pemasukan += $jumlah_pembayaran;
                $kasEntry->pengeluaran += $uang_kembalian;
                $kasEntry->saldo += $jumlah_pembayaran - $uang_kembalian;
                $kasEntry->save();
            } else {
                $kasEntry = new Kas();
                $kasEntry->tanggal = $tanggalTransaksi;
                $kasEntry->pemasukan = $jumlah_pembayaran;
                $kasEntry->pengeluaran = $uang_kembalian;

                if ($kasEntryHariSebelumnya) {
                    $kasEntry->saldo = $kasEntryHariSebelumnya->saldo + $jumlah_pembayaran - $uang_kembalian;
                } else {
                    $kasEntry->saldo = $jumlah_pembayaran - $uang_kembalian;
                }

                $kasEntry->save();
            }

            // Process items
            foreach ($request->input('penjualan_item') as $item) {
                $detailPenjualan = new DetailPenjualan();
                $detailPenjualan->nm_produk = $item['nm_PenjualanBarang'];
                $detailPenjualan->harga_produk = $item['harga_PenjualanBarang'];
                $detailPenjualan->quantity = $item['quantity'];
                $detailPenjualan->total_harga_produk = $item['total_harga_PenjualanBarang'];
                $detailPenjualan->penjualan_id = $penjualan->id;
                $detailPenjualan->save();

                // Update stok - HANYA menggunakan nm_barang (kolom yang benar-benar ada)
                $produkStok = penjualanbarang::where('nm_barang', $item['nm_PenjualanBarang'])->first();

                if ($produkStok && $produkStok->stok >= $item['quantity']) {
                    $updateStok = $produkStok->stok - $item['quantity'];
                    $produkStok->update(['stok' => $updateStok]);
                } else {
                    // Log jika stok tidak cukup atau barang tidak ditemukan
                    Log::warning("Stok tidak cukup atau barang tidak ditemukan: " . $item['nm_PenjualanBarang']);
                }
            }

            return response()->json([
                'success' => true,
                'kd_pembelian' => $kd_pembelian,
                'message' => 'Data pembelian berhasil disimpan'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error saving penjualan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAutoCompleteData(Request $request)
    {
        // Hanya gunakan nm_barang yang ada di tabel
        $produk = penjualanbarang::where('nm_barang', $request->nm_barang)->first();

        if ($produk) {
            return response()->json([
                'nm_produk' => $produk->nm_barang,
                'stok' => $produk->stok,
                'harga_jual' => $produk->harga_jual
            ]);
        }

        return response()->json(['error' => 'Produk tidak ditemukan'], 404);
    }
    /**
     * Tampilkan halaman laporan penjualan.
     */
    public function laporanIndex(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai', Carbon::now()->toDateString());
        $tanggalAkhir = $request->input('tanggal_akhir', Carbon::now()->toDateString());

        $penjualans = Penjualan::whereBetween('tgl_transaksi', [$tanggalMulai, $tanggalAkhir])
            ->with('detailPenjualan')
            ->orderBy('tgl_transaksi', 'desc')
            ->get();

        return view('laporan-penjualan.index', [
            'penjualans'    => $penjualans,
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_akhir' => $tanggalAkhir,
        ]);
    }
}
