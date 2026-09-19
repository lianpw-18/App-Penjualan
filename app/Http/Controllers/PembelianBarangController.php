<?php

namespace App\Http\Controllers;

use App\Models\PembelianBarang;
use App\Models\Satuan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Imports\PembelianBarangsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class PembelianBarangController extends Controller
{
    public function index()
    {
        return view('pembelian-barang.index', [
            'kategories' => Kategori::orderBy('id', 'DESC')->get(),
            'satuans'    => Satuan::all()
        ]);
    }

    public function getDataPembelianBarang()
    {
        $data = PembelianBarang::with(['kategori', 'satuan'])->orderBy('id', 'DESC')->get();
        return response()->json([
            'success' => true,
            'data'    => view('pembelian-barang.list-produk', compact('data'))->render()
        ]);
    }

    public function create()
    {
        return view('pembelian-barang.create', [
            'kategories' => Kategori::all(),
            'satuans'    => Satuan::all()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nm_barang'     => 'required',
            'deskripsi'     => 'required',
            'kategori_id'   => 'required',
            'satuan_id'     => 'required',
            'harga_beli'    => 'required|numeric',
            'stok'          => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $kd_barang = 'PB-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

        $barang = PembelianBarang::create([
            'kd_pembelian_barang' => $kd_barang,
            'nm_barang'   => $request->nm_barang,
            'deskripsi'   => $request->deskripsi,
            'stok'        => $request->stok,
            'harga_beli'  => $request->harga_beli,
            'kategori_id' => $request->kategori_id,
            'satuan_id'   => $request->satuan_id,
            'user_id'     => auth()->user()->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan!',
            'data'    => $barang
        ]);
    }

    public function show($id)
    {
        $barang = PembelianBarang::with(['kategori', 'satuan'])->find($id);

        if (!$barang) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
        }

        return response()->json([
            'success' => true,
            'barang' => $barang  // <--- INI, bukan 'data', tapi 'barang'
        ]);
    }



    public function edit($id)
    {
        $barang = PembelianBarang::find($id);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $barang
        ]);
    }


    public function update(Request $request, $id)
    {
        $barang = PembelianBarang::find($id);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!'
            ], 404);
        }

        $request->validate([
            'nm_barang'   => 'required',
            'deskripsi'   => 'required',
            'harga_beli'  => 'required|numeric',
            'stok'        => 'required|integer',
        ]);

        $barang->update([
            'nm_barang'   => $request->nm_barang,
            'deskripsi'   => $request->deskripsi,
            'harga_beli'  => $request->harga_beli,
            'stok'        => $request->stok,
            'user_id'     => auth()->user()->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diupdate!',
            'data' => $barang
        ]);
    }

    public function destroy($id)
    {
        PembelianBarang::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus!'
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        Excel::import(new PembelianBarangsImport, $request->file('file'));

        return redirect()->route('pembelian-barang.index')->with('success', 'Data berhasil diimport!');
    }

    public function getDetailPembelianBarang($id)
    {
        $barang = PembelianBarang::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'stok' => $barang->stok,
                'harga_beli' => $barang->harga_beli,
            ]
        ]);
    }
}
