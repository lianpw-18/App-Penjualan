<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\ProdukMasuk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dompdf\Dompdf;
use Carbon\Carbon;

class LaporanProdukMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('laporan-produk-masuk.index');
    }

    /**
     * Display a Fetch Data
     */
    public function getLaporanProdukMasuk(Request $request)
    {
        $tanggalMulai   = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');

        $query = ProdukMasuk::with('supplier');

        // Perbaikan: Gunakan kondisi yang lebih jelas
        if (!empty($tanggalMulai) && !empty($tanggalSelesai)) {
            // Pastikan format tanggal konsisten
            $tanggalMulai = Carbon::parse($tanggalMulai)->format('Y-m-d');
            $tanggalSelesai = Carbon::parse($tanggalSelesai)->format('Y-m-d');
            
            $query->whereBetween('tgl_masuk', [$tanggalMulai, $tanggalSelesai]);
        } elseif (!empty($tanggalMulai)) {
            // Jika hanya tanggal mulai
            $tanggalMulai = Carbon::parse($tanggalMulai)->format('Y-m-d');
            $query->where('tgl_masuk', '>=', $tanggalMulai);
        } elseif (!empty($tanggalSelesai)) {
            // Jika hanya tanggal selesai
            $tanggalSelesai = Carbon::parse($tanggalSelesai)->format('Y-m-d');
            $query->where('tgl_masuk', '<=', $tanggalSelesai);
        }

        // Tambahkan ordering untuk konsistensi
        $data = $query->orderBy('tgl_masuk', 'DESC')
                     ->orderBy('id', 'DESC')
                     ->get();

        // Debug: Log data untuk troubleshooting
        \Log::info('Laporan PPN Masukan Data:', [
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'count' => $data->count(),
            'data' => $data->toArray()
        ]);

        return response()->json($data);
    }

    /**
     * Display Print Laporan Produk Masuk
     */
    public function printLaporanProdukMasuk(Request $request)
    {
        $tanggalMulai   = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');

        $query = ProdukMasuk::with('supplier');

        if (!empty($tanggalMulai) && !empty($tanggalSelesai)) {
            $tanggalMulai = Carbon::parse($tanggalMulai)->format('Y-m-d');
            $tanggalSelesai = Carbon::parse($tanggalSelesai)->format('Y-m-d');
            
            $query->whereBetween('tgl_masuk', [$tanggalMulai, $tanggalSelesai]);
        } elseif (!empty($tanggalMulai)) {
            $tanggalMulai = Carbon::parse($tanggalMulai)->format('Y-m-d');
            $query->where('tgl_masuk', '>=', $tanggalMulai);
        } elseif (!empty($tanggalSelesai)) {
            $tanggalSelesai = Carbon::parse($tanggalSelesai)->format('Y-m-d');
            $query->where('tgl_masuk', '<=', $tanggalSelesai);
        }

        $data = $query->orderBy('tgl_masuk', 'DESC')
                     ->orderBy('id', 'DESC')
                     ->get();

        $pdf  = new Dompdf();
        $html = view('laporan-produk-masuk.print-produk-masuk', compact('data', 'tanggalMulai', 'tanggalSelesai'))->render();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        $pdf->stream('print-produk-masuk.pdf', ['Attachment' => false]);
    }
}