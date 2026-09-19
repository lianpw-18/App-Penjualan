<?php

namespace App\Http\Controllers;

use App\Models\PenjualanBarang;
use App\Models\Supplier;
use App\Models\ProdukKeluar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProdukKeluarController extends Controller
{
    public function index()
    {
        return view('produk-keluar.index', [
            'suppliers' => Supplier::all()
        ]);
    }

    /**
     * PERBAIKAN: CEK SUPPLIER_ID DAN MANUAL FETCH
     */
    public function getDataProdukKeluar()
    {
        try {
            $produkKeluars = ProdukKeluar::orderBy('id', 'DESC')->get();

            // MANUAL FETCH SUPPLIER KARENA RELATIONSHIP BERMASALAH
            $produkKeluars->transform(function($item) {
                // CEK SUPPLIER_ID
                if ($item->supplier_id) {
                    $supplier = Supplier::find($item->supplier_id);
                    if ($supplier) {
                        $item->supplier_name = $supplier->supplier;
                        $item->supplier_data = $supplier; // untuk debug
                    } else {
                        $item->supplier_name = 'Supplier Not Found (ID: ' . $item->supplier_id . ')';
                        $item->supplier_data = null;
                    }
                } else {
                    $item->supplier_name = 'No Supplier ID';
                    $item->supplier_data = null;
                }
                
                return $item;
            });

            return response()->json([
                'success' => true,
                'data' => $produkKeluars,
                'debug' => [
                    'total_records' => $produkKeluars->count(),
                    'first_record_supplier_id' => $produkKeluars->first()->supplier_id ?? 'null',
                    'first_record_supplier_name' => $produkKeluars->first()->supplier_name ?? 'null',
                    'all_suppliers' => Supplier::all()->pluck('supplier', 'id')
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    public function getProdukBySupplier(Request $request)
    {
        $produkList = PenjualanBarang::where('stok', '>', 0)->get();
        
        return response()->json([
            'success' => true,
            'data' => $produkList
        ]);
    }

    public function getProdukDetail(Request $request)
    {
        $produk = PenjualanBarang::where('nm_barang', $request->nm_produk)->first();
        
        if($produk) {
            return response()->json([
                'success' => true,
                'stok' => $produk->stok,
                'harga_beli' => $produk->harga_beli
            ]);
        }
        
        return response()->json(['success' => false]);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'supplier_id' => 'required|exists:suppliers,id',
                'nm_produk' => 'required',
                'stok_keluar' => [
                    'required',
                    'numeric',
                    'min:1',
                    function ($attribute, $value, $fail) use ($request) {
                        $produk = PenjualanBarang::where('nm_barang', $request->nm_produk)->first();
                        if ($produk && $value > $produk->stok) {
                            $fail("Stok tidak cukup! Stok tersedia: " . $produk->stok);
                        }
                    },
                ],
                'deskripsi' => 'required',
            ]);

            if($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $produk = PenjualanBarang::where('nm_barang', $request->nm_produk)->first();
            $kd_transaksi = 'PRD-OUT-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

            // PASTIKAN SUPPLIER_ID TERSIMPAN
            $produkKeluar = ProdukKeluar::create([
                'kd_transaksi' => $kd_transaksi,
                'nm_produk' => $request->nm_produk,
                'supplier_id' => (int)$request->supplier_id, // CAST TO INT
                'stok_keluar' => $request->stok_keluar,
                'deskripsi' => $request->deskripsi,
                'harga_beli' => $produk->harga_beli,
                'total_harga' => $request->stok_keluar * $produk->harga_beli,
                'tgl_keluar' => now()->format('Y-m-d'),
                'user_id' => auth()->id(),
            ]);

            if($produkKeluar) {
                $produk->stok -= $request->stok_keluar;
                $produk->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Produk keluar berhasil ditambahkan!',
                'data' => $produkKeluar,
                'debug' => [
                    'supplier_id_saved' => $produkKeluar->supplier_id,
                    'request_supplier_id' => $request->supplier_id
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $produkKeluar = ProdukKeluar::findOrFail($id);
            
            $penjualanBarang = PenjualanBarang::where('nm_barang', $produkKeluar->nm_produk)->first();
            if($penjualanBarang) {
                $penjualanBarang->stok += $produkKeluar->stok_keluar;
                $penjualanBarang->save();
            }

            $produkKeluar->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data'
            ], 500);
        }
    }
}