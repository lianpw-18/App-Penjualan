<?php

namespace App\Http\Controllers;

use App\Models\PenjualanBarang;
use App\Models\Satuan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Imports\PenjualanBarangsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PenjualanBarangController extends Controller
{
    public function index()
    {
        return view('penjualan-barang.index', [
            'kategories' => Kategori::orderBy('id', 'DESC')->get(),
            'satuans'    => Satuan::all()
        ]);
    }

    public function getDataPenjualanBarang(Request $request)
    {
        $query = PenjualanBarang::with(['kategori', 'satuan'])
                    ->where('is_hidden', false); // Hanya tampilkan produk yang tidak disembunyikan

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nm_barang', 'LIKE', '%' . $search . '%')
                  ->orWhere('kd_penjualan_barang', 'LIKE', '%' . $search . '%')
                  ->orWhere('deskripsi', 'LIKE', '%' . $search . '%');
            });
        }

        $data = $query->orderBy('id', 'DESC')->get();
        
        return response()->json([
            'success' => true,
            'data'    => view('penjualan-barang.list-produk', compact('data'))->render()
        ]);
    }

    // Method untuk menampilkan produk tersembunyi
    public function hiddenProducts()
    {
        $data = PenjualanBarang::with(['kategori', 'satuan'])
                    ->where('is_hidden', true)
                    ->orderBy('id', 'DESC')
                    ->get();
        
        return response()->json([
            'success' => true,
            'data'    => view('penjualan-barang.list-hidden-produk', compact('data'))->render()
        ]);
    }

    public function create()
    {
        return view('penjualan-barang.create', [
            'kategories' => Kategori::all(),
            'satuans' => Satuan::all()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nm_barang'         => 'required',
            'deskripsi'         => 'required',
            'kategori_id'       => 'required',
            'satuan_id'         => 'required',
            'harga_jual'        => 'required|numeric',
            'harga_beli'        => 'required|numeric',
            'stok'              => 'required|numeric',
            'diskon_persen'     => 'nullable|numeric|min:0|max:100',
            'ppn_persen'        => 'nullable|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $kd_barang = 'PRD-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

        $barang = PenjualanBarang::create([
            'kd_penjualan_barang' => $kd_barang,
            'nm_barang'         => $request->nm_barang,
            'deskripsi'         => $request->deskripsi,
            'stok'              => $request->stok,
            'harga_beli'        => $request->harga_beli,
            'harga_jual'        => $request->harga_jual,
            'diskon_persen'     => $request->diskon_persen ?? 0,
            'ppn_persen'        => $request->ppn_persen ?? 11,
            'kategori_id'       => $request->kategori_id,
            'satuan_id'         => $request->satuan_id,
            'user_id'           => auth()->user()->id,
            'is_hidden'         => false, // Default tidak disembunyikan
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan!',
            'data'    => $barang
        ]);
    }

    public function show($id)
{
    try {
        // DEBUG: Log ID yang diterima
        Log::info('PenjualanBarangController@show called with ID: ' . $id);
        
        // Ambil data dengan relasi kategori dan satuan - PASTIKAN RELASI DIMUAT
        $penjualanBarang = PenjualanBarang::with(['kategori', 'satuan'])->findOrFail($id);
        
        // DEBUG: Log data yang ditemukan
        Log::info('Data found:', [
            'id' => $penjualanBarang->id,
            'nama' => $penjualanBarang->nm_barang,
            'kategori_id' => $penjualanBarang->kategori_id,
            'satuan_id' => $penjualanBarang->satuan_id,
            'has_kategori' => $penjualanBarang->kategori ? true : false,
            'has_satuan' => $penjualanBarang->satuan ? true : false
        ]);
        
        // DEBUG: Log relasi kategori
        if ($penjualanBarang->kategori) {
            Log::info('Kategori data:', [
                'id' => $penjualanBarang->kategori->id,
                'nama_kategori' => $penjualanBarang->kategori->nama_kategori ?? 'FIELD NAMA_KATEGORI NULL'
            ]);
        } else {
            Log::warning('Kategori tidak ditemukan untuk kategori_id: ' . $penjualanBarang->kategori_id);
        }
        
        // DEBUG: Log relasi satuan
        if ($penjualanBarang->satuan) {
            Log::info('Satuan data:', [
                'id' => $penjualanBarang->satuan->id,
                'nama_satuan' => $penjualanBarang->satuan->nama_satuan ?? 'FIELD NAMA_SATUAN NULL'
            ]);
        } else {
            Log::warning('Satuan tidak ditemukan untuk satuan_id: ' . $penjualanBarang->satuan_id);
        }
        
        // Persiapkan response dengan berbagai kemungkinan field name
        $responseData = [
            'success' => true,
            'kd_penjualan_barang' => $penjualanBarang->kd_penjualan_barang ?? '',
            'nm_barang' => $penjualanBarang->nm_barang ?? '',
            'deskripsi' => $penjualanBarang->deskripsi ?? '',
            'harga_beli' => $penjualanBarang->harga_beli ?? 0,
            'harga_jual' => $penjualanBarang->harga_jual ?? 0,
            'stok' => $penjualanBarang->stok ?? 0,
            'diskon_persen' => $penjualanBarang->diskon_persen ?? 0,
            'ppn_persen' => $penjualanBarang->ppn_persen ?? 0,
            'kategori_id' => $penjualanBarang->kategori_id,
            'satuan_id' => $penjualanBarang->satuan_id,
        ];
        
        // Handle kategori dengan berbagai kemungkinan field name
        if ($penjualanBarang->kategori) {
            $kategori = $penjualanBarang->kategori;
            $responseData['kategori'] = [
                'id' => $kategori->id,
                'nama_kategori' => $kategori->nama_kategori ?? $kategori->name ?? $kategori->kategori ?? 'Nama kategori tidak ditemukan'
            ];
        } else {
            // Coba ambil manual jika relasi gagal
            $kategoriManual = \App\Models\Kategori::find($penjualanBarang->kategori_id);
            if ($kategoriManual) {
                $responseData['kategori'] = [
                    'id' => $kategoriManual->id,
                    'nama_kategori' => $kategoriManual->nama_kategori ?? $kategoriManual->name ?? $kategoriManual->kategori ?? 'Nama kategori tidak ditemukan'
                ];
            } else {
                $responseData['kategori'] = [
                    'id' => $penjualanBarang->kategori_id,
                    'nama_kategori' => 'Kategori tidak ditemukan (ID: ' . $penjualanBarang->kategori_id . ')'
                ];
            }
        }
        
        // Handle satuan dengan berbagai kemungkinan field name  
        if ($penjualanBarang->satuan) {
            $satuan = $penjualanBarang->satuan;
            $responseData['satuan'] = [
                'id' => $satuan->id,
                'nama_satuan' => $satuan->nama_satuan ?? $satuan->name ?? $satuan->satuan ?? 'Nama satuan tidak ditemukan'
            ];
        } else {
            // Coba ambil manual jika relasi gagal
            $satuanManual = \App\Models\Satuan::find($penjualanBarang->satuan_id);
            if ($satuanManual) {
                $responseData['satuan'] = [
                    'id' => $satuanManual->id,
                    'nama_satuan' => $satuanManual->nama_satuan ?? $satuanManual->name ?? $satuanManual->satuan ?? 'Nama satuan tidak ditemukan'
                ];
            } else {
                $responseData['satuan'] = [
                    'id' => $penjualanBarang->satuan_id,
                    'nama_satuan' => 'Satuan tidak ditemukan (ID: ' . $penjualanBarang->satuan_id . ')'
                ];
            }
        }
        
        // Tambahkan timestamps
        $responseData['created_at'] = $penjualanBarang->created_at;
        $responseData['updated_at'] = $penjualanBarang->updated_at;
        $responseData['is_hidden'] = $penjualanBarang->is_hidden ?? false;
        
        // DEBUG: Log final response
        Log::info('Final response data:', $responseData);
        
        return response()->json($responseData, 200);
        
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        Log::error('Model not found for ID: ' . $id);
        return response()->json([
            'success' => false,
            'message' => 'Data penjualan barang tidak ditemukan'
        ], 404);
        
    } catch (\Exception $e) {
        // Log error untuk debugging
        Log::error('Error in PenjualanBarangController@show: ' . $e->getMessage(), [
            'id' => $id,
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat mengambil data: ' . $e->getMessage()
        ], 500);
    }
}

    public function edit($id)
    {
        $barang = PenjualanBarang::findOrFail($id);
        return view('penjualan-barang.edit', [
            'barang' => $barang,
            'kategories' => Kategori::all(),
            'satuans' => Satuan::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        $barang = PenjualanBarang::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nm_barang'         => 'required',
            'deskripsi'         => 'required',
            'kategori_id'       => 'required',
            'satuan_id'         => 'required',
            'harga_jual'        => 'required|numeric',
            'harga_beli'        => 'required|numeric',
            'stok'              => 'required|numeric',
            'diskon_persen'     => 'nullable|numeric|min:0|max:100',
            'ppn_persen'        => 'nullable|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $barang->update([
            'nm_barang'         => $request->nm_barang,
            'deskripsi'         => $request->deskripsi,
            'stok'              => $request->stok,
            'harga_beli'        => $request->harga_beli,
            'harga_jual'        => $request->harga_jual,
            'diskon_persen'     => $request->diskon_persen ?? 0,
            'ppn_persen'        => $request->ppn_persen ?? 11,
            'kategori_id'       => $request->kategori_id,
            'satuan_id'         => $request->satuan_id,
            'user_id'           => auth()->user()->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diupdate!',
            'data'    => $barang
        ]);
    }

    public function destroy($id)
    {
        try {
            // Gunakan ID asli, bukan kd_penjualan_barang
            $barang = PenjualanBarang::where('id', $id)->first();
            
            if (!$barang) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan!'
                ], 404);
            }

            // Cek apakah produk memiliki histori transaksi
            // Untuk sementara kita set false dulu untuk testing
            $hasTransaction = false; 

            // Uncomment dan sesuaikan jika ada tabel transaksi
            // $hasTransaction = DB::table('penjualans')
            //     ->where('penjualan_barang_id', $id)
            //     ->exists();
            
            if ($hasTransaction) {
                // Sembunyikan produk jika ada histori transaksi
                $barang->update(['is_hidden' => true]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Produk disembunyikan karena memiliki histori transaksi!',
                    'action' => 'hidden'
                ]);
            } else {
                // Hapus permanen jika tidak ada histori
                $barang->delete();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil dihapus!',
                    'action' => 'deleted'
                ]);
            }
            
        } catch (\Exception $e) {
            Log::error('Error deleting penjualan barang: ' . $e->getMessage(), [
                'id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }

    // Method untuk mengembalikan produk tersembunyi
    public function restore($id)
    {
        try {
            $barang = PenjualanBarang::where('id', $id)->first();
            
            if (!$barang) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan!'
                ], 404);
            }
            
            $barang->update(['is_hidden' => false]);
            
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dikembalikan!'
            ]);
        } catch (\Exception $e) {
            Log::error('Error restoring penjualan barang: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengembalikan produk: ' . $e->getMessage()
            ], 500);
        }
    }

    // Method untuk hapus permanen produk tersembunyi
    public function forceDelete($id)
    {
        try {
            $barang = PenjualanBarang::where('id', $id)->first();
            
            if (!$barang) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan!'
                ], 404);
            }
            
            $barang->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dihapus permanen!'
            ]);
        } catch (\Exception $e) {
            Log::error('Error force deleting penjualan barang: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus produk: ' . $e->getMessage()
            ], 500);
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        Excel::import(new PenjualanBarangsImport, $request->file('file'));

        return redirect()->route('penjualan-barang.index')->with('success', 'Data berhasil diimport!');
    }

    public function getDetailPenjualanBarang($id)
    {
        $barang = PenjualanBarang::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'stok' => $barang->stok,
                'harga_jual' => $barang->harga_jual,
                'harga_beli' => $barang->harga_beli,
                'diskon_persen' => $barang->diskon_persen,
                'ppn_persen' => $barang->ppn_persen,
            ]
        ]);
    }
}