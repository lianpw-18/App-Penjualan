<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\PenjualanBarang;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PembelianBarang;
use Illuminate\Support\Facades\Log;

class LaporanPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil filter tanggal jika ada
        $tanggalMulai    = $request->input('tanggal_mulai');
        $tanggalSelesai  = $request->input('tanggal_selesai');

        // Query produk yang pernah terjual pada periode filter
        $produkQuery = PenjualanBarang::query();

        if ($tanggalMulai && $tanggalSelesai) {
            $produkQuery->whereHas('penjualan', function ($q) use ($tanggalMulai, $tanggalSelesai) {
                $q->whereBetween('tgl_transaksi', [$tanggalMulai, $tanggalSelesai]);
            });
        }

        $produkList = $produkQuery->select('id', 'nm_produk')->distinct()->get();

        return view('laporan-penjualan.index', [
            'produkList' => $produkList
        ]);
    }

    /**
     * Display a Fetch Data
     */
    public function getDataPenjualan(Request $request)
    {
        try {
            $tanggalMulai    = $request->input('tanggal_mulai');
            $tanggalSelesai  = $request->input('tanggal_selesai');
            $namaProduk      = $request->input('produk_id'); // UBAH: Sekarang menerima nama produk

            $reportSales = Penjualan::query();

            if ($tanggalMulai && $tanggalSelesai) {
                $reportSales->whereBetween('tgl_transaksi', [$tanggalMulai, $tanggalSelesai]);
            }

            // PERBAIKAN: Filter berdasarkan nama produk
            if ($namaProduk) {
                $reportSales->whereHas('detailPenjualans', function ($q) use ($namaProduk) {
                    $q->where('nm_produk', $namaProduk);
                });
                
                // Coba juga dengan relasi detailPenjualan (singular) jika ada
                $reportSales->orWhereHas('detailPenjualan', function ($q) use ($namaProduk) {
                    $q->where('nm_produk', $namaProduk);
                });
            }

            // Coba kedua nama relasi yang mungkin ada
            $data = $reportSales->with(['detailPenjualans', 'detailPenjualan'])
                ->orderBy('tgl_transaksi', 'desc')
                ->get();

            // Debug: Log jumlah data yang ditemukan
            Log::info('Jumlah data penjualan ditemukan: ' . $data->count());
            Log::info('Filter nama produk: ' . $namaProduk);

            if ($data->count() > 0) {
                Log::info('Sample data:', $data->first()->toArray());
            }

            // Transform data untuk frontend
            $transformedData = $data->map(function ($item) use ($namaProduk) {
                // Cek relasi mana yang ada
                $details = $item->detailPenjualans ?? $item->detailPenjualan ?? collect();

                if (!$details instanceof \Illuminate\Database\Eloquent\Collection) {
                    $details = collect($details);
                }

                // PERBAIKAN: Filter detail berdasarkan nama produk jika diperlukan
                if ($namaProduk) {
                    $details = $details->filter(function ($detail) use ($namaProduk) {
                        return $detail->nm_produk == $namaProduk;
                    });
                }

                // Debug: Log detail data
                if ($details->count() > 0) {
                    Log::info('Detail for penjualan ' . $item->id . ':', $details->toArray());
                }

                // Skip transaksi yang tidak memiliki detail produk yang sesuai filter
                if ($namaProduk && $details->count() == 0) {
                    return null;
                }

                // Hitung total diskon dan PPN dengan berbagai kemungkinan struktur data
                $totalDiskon = 0;
                $totalPPN = 0;

                foreach ($details as $detail) {
                    // Cek berbagai kemungkinan nama field diskon
                    $diskonValue = $detail->diskon ?? $detail->discount ?? $detail->total_diskon ?? 0;
                    $ppnValue = $detail->ppn ?? $detail->tax ?? $detail->total_ppn ?? 0;
                    $qty = $detail->quantity ?? $detail->qty ?? 1;

                    $totalDiskon += $diskonValue * $qty;
                    $totalPPN += $ppnValue * $qty;

                    // Debug log per item
                    Log::info("Detail item - Diskon: $diskonValue, PPN: $ppnValue, Qty: $qty");
                }

                // Jika tidak ada di detail, cek di header penjualan
                if ($totalDiskon == 0) {
                    $totalDiskon = $item->diskon ?? $item->total_diskon ?? 0;
                }

                if ($totalPPN == 0) {
                    $totalPPN = $item->ppn ?? $item->total_ppn ?? 0;
                }

                // Return data yang sudah di-transform
                return [
                    'id' => $item->id,
                    'tgl_transaksi' => $item->tgl_transaksi ? $item->tgl_transaksi->format('Y-m-d') : null,
                    'created_at' => $item->created_at ? $item->created_at->toISOString() : null,
                    'kd_pembelian' => $item->kd_pembelian_barang ?? $item->kd_pembelian ?? 'N/A',
                    'sub_total' => $item->sub_total ?? 0,
                    'jumlah_pembayaran' => $item->jumlah_pembayaran ?? 0,
                    'uang_kembalian' => $item->uang_kembalian ?? 0,
                    'total_diskon' => $totalDiskon,
                    'total_ppn' => $totalPPN,
                    'detail_penjualans' => $details->map(function ($detail) {
                        return [
                            'produk_id' => $detail->produk_id ?? $detail->id ?? null,
                            'nm_produk' => $detail->nm_produk ?? $detail->nama_produk ?? 'Produk',
                            'quantity' => $detail->quantity ?? $detail->qty ?? 0,
                            'harga' => $detail->harga ?? $detail->price ?? 0,
                            'diskon' => $detail->diskon ?? $detail->discount ?? 0,
                            'ppn' => $detail->ppn ?? $detail->tax ?? 0,
                        ];
                    })->toArray(),
                    'debug_info' => [
                        'detail_count' => $details->count(),
                        'calculated_diskon' => $totalDiskon,
                        'calculated_ppn' => $totalPPN,
                        'header_diskon' => $item->diskon ?? 0,
                        'header_ppn' => $item->ppn ?? 0,
                        'filtered_by_produk' => $namaProduk ? true : false
                    ]
                ];
            })->filter(); // Hapus item null dari hasil filter

            return response()->json($transformedData->values()); // Reset array keys
        } catch (\Exception $e) {
            Log::error('Error in getDataPenjualan: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'error' => true,
                'message' => 'Terjadi kesalahan saat mengambil data: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    public function getPenjualanBarang()
    {
        try {
            $penjualanbarang = PenjualanBarang::select('id', 'nm_produk')->get();
            return response()->json($penjualanbarang);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Display Print Laporan Penjualan/Sales Report
     */
    public function printLaporanPenjualan(Request $request)
    {
        try {
            $tanggalMulai    = $request->input('tanggal_mulai');
            $tanggalSelesai  = $request->input('tanggal_selesai');
            $namaProduk      = $request->input('produk_id'); // UBAH: Sekarang menerima nama produk

            $reportSales = Penjualan::query();

            if ($tanggalMulai && $tanggalSelesai) {
                $reportSales->whereBetween('tgl_transaksi', [$tanggalMulai, $tanggalSelesai]);
            }

            // PERBAIKAN: Filter berdasarkan nama produk untuk print PDF
            if ($namaProduk) {
                $reportSales->whereHas('detailPenjualans', function ($q) use ($namaProduk) {
                    $q->where('nm_produk', $namaProduk);
                });
                
                // Coba juga dengan relasi detailPenjualan (singular) jika ada
                $reportSales->orWhereHas('detailPenjualan', function ($q) use ($namaProduk) {
                    $q->where('nm_produk', $namaProduk);
                });
            }

            // Coba kedua nama relasi yang mungkin ada
            $data = $reportSales->with(['detailPenjualans', 'detailPenjualan'])
                ->orderBy('tgl_transaksi', 'desc')
                ->get();

            // PERBAIKAN: Terapkan logika perhitungan yang SAMA dengan frontend JavaScript
            $transformedData = $data->map(function ($item) use ($namaProduk) {
                // Cek relasi mana yang ada - sama seperti di getDataPenjualan
                $details = $item->detailPenjualans ?? $item->detailPenjualan ?? collect();

                if (!$details instanceof \Illuminate\Database\Eloquent\Collection) {
                    $details = collect($details);
                }

                // Filter detail berdasarkan nama produk jika diperlukan - sama seperti di frontend
                if ($namaProduk) {
                    $details = $details->filter(function ($detail) use ($namaProduk) {
                        return $detail->nm_produk == $namaProduk;
                    });
                }

                // Skip transaksi yang tidak memiliki detail produk yang sesuai filter
                if ($namaProduk && $details->count() == 0) {
                    return null;
                }

                // PERBAIKAN: Gunakan logika perhitungan yang SAMA dengan frontend JavaScript
                $totalDiskon = 0;
                $totalPPN = 0;

                foreach ($details as $detail) {
                    // Gunakan field mapping yang sama dengan frontend
                    $diskonValue = $detail->diskon ?? $detail->discount ?? $detail->total_diskon ?? 0;
                    $ppnValue = $detail->ppn ?? $detail->tax ?? $detail->total_ppn ?? 0;
                    $qty = $detail->quantity ?? $detail->qty ?? 1;

                    $totalDiskon += $diskonValue * $qty;
                    $totalPPN += $ppnValue * $qty;
                }

                // Jika tidak ada di detail, cek di header penjualan - sama seperti frontend
                if ($totalDiskon == 0) {
                    $totalDiskon = $item->diskon ?? $item->total_diskon ?? 0;
                }

                if ($totalPPN == 0) {
                    $totalPPN = $item->ppn ?? $item->total_ppn ?? 0;
                }

                // Set calculated values ke item untuk digunakan di template
                $item->calculated_total_diskon = $totalDiskon;
                $item->calculated_total_ppn = $totalPPN;
                $item->detailPenjualans = $details; // Update dengan detail yang sudah difilter

                return $item;
            })->filter(); // Hapus item null

            // Reset collection keys
            $data = $transformedData->values();

            // PERBAIKAN: Nama produk filter untuk header PDF
            $namaProdukFilter = $namaProduk;

            $pdf  = new Dompdf();
            $html = view('laporan-penjualan/print-penjualan', compact('data', 'tanggalMulai', 'tanggalSelesai', 'namaProdukFilter'));
            $pdf->loadHtml($html);
            $pdf->setPaper('A4', 'landscape');
            $pdf->render();
            $pdf->stream('print-penjualan.pdf', ['Attachment' => false]);
        } catch (\Exception $e) {
            Log::error('Error in printLaporanPenjualan: ' . $e->getMessage());
            return back()->with('error', 'Gagal generate PDF: ' . $e->getMessage());
        }
    }
}