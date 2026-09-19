<?php

namespace App\Http\Controllers;

use App\Models\PembelianBarang;

use App\Models\PenjualanBarang;
use App\Models\ProdukKeluar;
use App\Models\ProdukMasuk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dompdf\Dompdf;

class LaporanProdukKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('laporan-produk-keluar.index');
    }

    /**
     * Display a Fetch Data
     */
    public function getlaporanProdukKeluar(Request $request)
    {
        $tanggalMulai    = $request->input('tanggal_mulai');
        $tanggalSelesai  = $request->input('tanggal_selesai');

        $produkKeluar   = ProdukKeluar::query();

        if($tanggalMulai && $tanggalSelesai){
            $produkKeluar->whereBetween('tgl_keluar', [$tanggalMulai, $tanggalSelesai]);
        }

        $data = $produkKeluar->get();

        if(empty($tanggalMulai) && empty($tanggalSelesai)){
            $data = ProdukKeluar::all();
        }

        return response()->json($data);
    }

    /**
     * Display a specific resource.
     */
    public function show($id)
    {
        $produkKeluar = ProdukKeluar::findOrFail($id);
        return response()->json($produkKeluar);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $produkKeluar = ProdukKeluar::findOrFail($id);

        $produkKeluar->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data produk keluar berhasil diupdate',
            'data' => $produkKeluar
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produkKeluar = ProdukKeluar::findOrFail($id);
        $produkKeluar->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data produk keluar berhasil dihapus'
        ]);
    }

    /**
     * Display Print Laporan Produk Keluar
     */
    public function printLaporanProdukKeluar(Request $request)
    {
        $tanggalMulai    = $request->input('tanggal_mulai');
        $tanggalSelesai  = $request->input('tanggal_selesai');

        $produkKeluar   = ProdukKeluar::query();

        if($tanggalMulai && $tanggalSelesai){
            $produkKeluar->whereBetween('tgl_keluar', [$tanggalMulai, $tanggalSelesai]);
        }

        if($tanggalMulai !== null && $tanggalSelesai !== null) {
            $data = $produkKeluar->get();
        } else {
            $data = ProdukKeluar::all();
        }

        $pdf  = new Dompdf();
        $html = view('laporan-produk-keluar/print-produk-keluar', compact('data', 'tanggalMulai', 'tanggalSelesai'));
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        $pdf->stream('print-produk-keluar.pdf', ['Attachment' => false]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tgl_keluar'    => 'required|date',
            'kd_transaksi'  => 'required|string',
            'nm_produk'     => 'required|string',
            'stok_keluar'   => 'required|integer',
            'harga_beli'    => 'required|numeric',
            'deskripsi'     => 'nullable|string',
        ]);

        // Simpan ke database (ganti sesuai model Anda)
        \App\Models\ProdukKeluar::create([
            'tgl_keluar'    => $request->tgl_keluar,
            'kd_transaksi'  => $request->kd_transaksi,
            'nm_produk'     => $request->nm_produk,
            'stok_keluar'   => $request->stok_keluar,
            'harga_beli'    => $request->harga_beli,
            'deskripsi'     => $request->deskripsi,
        ]);

        return response()->json(['success' => true]);
    }
}
