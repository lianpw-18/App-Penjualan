<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\DB;

class LaporanPPnKeseluruhanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('laporan-ppn-keseluruhan.index');
    }

    /**
     * Display a Fetch Data - menggunakan logika yang sama dengan index
     */
    public function getDataArusKas(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');

        // Ambil data dari kedua endpoint yang sama seperti di index
        $ppnKeluarData = $this->getPPNKeluarData($tanggalMulai, $tanggalSelesai);
        $ppnMasukData = $this->getPPNMasukData($tanggalMulai, $tanggalSelesai);

        // Process dan group data berdasarkan tanggal (sama seperti JavaScript di index)
        $dateGroups = [];
        
        // Process PPN Keluar data
        foreach($ppnKeluarData as $item) {
            $tanggal = $item->tgl_keluar;
            if(!isset($dateGroups[$tanggal])) {
                $dateGroups[$tanggal] = [
                    'tanggal' => $tanggal,
                    'ppn_pengeluaran' => 0,
                    'ppn_pemasukan' => 0
                ];
            }
            // PPN Pengeluaran = 11% dari total_harga atau harga_beli
            $amountKeluar = ($item->total_harga && $item->total_harga > 0) ? $item->total_harga : ($item->harga_beli ?? 0);
            $ppnPengeluaran = $amountKeluar * 0.11;
            $dateGroups[$tanggal]['ppn_pengeluaran'] += $ppnPengeluaran;
        }

        // Process PPN Masuk data  
        foreach($ppnMasukData as $item) {
            $tanggal = $item->tgl_masuk;
            if(!isset($dateGroups[$tanggal])) {
                $dateGroups[$tanggal] = [
                    'tanggal' => $tanggal,
                    'ppn_pengeluaran' => 0,
                    'ppn_pemasukan' => 0
                ];
            }
            // PPN Pemasukan = 11% dari total_harga (sama seperti di JavaScript)
            $ppnPemasukan = ($item->total_harga ?? 0) * 0.11;
            $dateGroups[$tanggal]['ppn_pemasukan'] += $ppnPemasukan;
        }

        // Sort by date dan convert to array format yang sesuai dengan JavaScript
        ksort($dateGroups);
        $data = [];
        foreach($dateGroups as $item) {
            $item['selisih'] = $item['ppn_pengeluaran'] - $item['ppn_pemasukan'];
            $data[] = $item;
        }

        return response()->json($data);
    }

    public function printLaporanPPnKeseluruhan(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');

        // Ambil data dari database langsung
        $ppnKeluarData = $this->getPPNKeluarData($tanggalMulai, $tanggalSelesai);
        $ppnMasukData = $this->getPPNMasukData($tanggalMulai, $tanggalSelesai);

        // Process dan group data berdasarkan tanggal
        $dateGroups = [];
        
        // Process PPN Keluar data
        foreach($ppnKeluarData as $item) {
            $tanggal = $item->tgl_keluar;
            if(!isset($dateGroups[$tanggal])) {
                $dateGroups[$tanggal] = [
                    'tanggal' => $tanggal,
                    'ppn_pengeluaran' => 0,
                    'ppn_pemasukan' => 0
                ];
            }
            // PPN Pengeluaran = 11% dari total_harga atau harga_beli
            $amountKeluar = ($item->total_harga && $item->total_harga > 0) ? $item->total_harga : ($item->harga_beli ?? 0);
            $ppnPengeluaran = $amountKeluar * 0.11;
            $dateGroups[$tanggal]['ppn_pengeluaran'] += $ppnPengeluaran;
        }

        // Process PPN Masuk data  
        foreach($ppnMasukData as $item) {
            $tanggal = $item->tgl_masuk;
            if(!isset($dateGroups[$tanggal])) {
                $dateGroups[$tanggal] = [
                    'tanggal' => $tanggal,
                    'ppn_pengeluaran' => 0,
                    'ppn_pemasukan' => 0
                ];
            }
            // PPN Pemasukan = 11% dari total_harga
            $ppnPemasukan = ($item->total_harga ?? 0) * 0.11;
            $dateGroups[$tanggal]['ppn_pemasukan'] += $ppnPemasukan;
        }

        // Sort by date dan convert to collection
        ksort($dateGroups);
        $data = collect(array_values($dateGroups))->map(function($item) {
            $item['selisih'] = $item['ppn_pengeluaran'] - $item['ppn_pemasukan'];
            return (object) $item;
        });

        // Hitung total PPN
        $totalPengeluaran = $data->sum('ppn_pengeluaran');
        $totalPemasukan = $data->sum('ppn_pemasukan');
        $totalSelisih = $totalPengeluaran - $totalPemasukan;

        $pdf = new Dompdf();
        $html = view('laporan-ppn-keseluruhan/print-ppn-keseluruhan', compact(
            'data', 
            'tanggalMulai', 
            'tanggalSelesai',
            'totalPengeluaran',
            'totalPemasukan', 
            'totalSelisih'
        ));
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        $pdf->stream('print-ppn-keseluruhan.pdf', ['Attachment' => false]);
    }

    private function getPPNKeluarData($tanggalMulai, $tanggalSelesai)
    {
        try {
            // Ambil data langsung dari database produk_keluars
            $query = DB::table('produk_keluars')
                ->select('tgl_keluar', 'harga_beli', 'total_harga')
                ->whereNotNull('tgl_keluar')
                ->whereNotNull('harga_beli');
                
            if ($tanggalMulai && $tanggalSelesai) {
                $query->whereBetween('tgl_keluar', [$tanggalMulai, $tanggalSelesai]);
            }
            
            $data = $query->get();
            
            return $data->map(function($item) {
                return (object) [
                    'tgl_keluar'  => $item->tgl_keluar,
                    'harga_beli'  => floatval($item->harga_beli ?? 0),
                    'total_harga' => floatval($item->total_harga ?? $item->harga_beli ?? 0)
                ];
            });
            
        } catch (\Exception $e) {
            // Log error jika perlu
            \Log::error('Error getting PPN Keluar data: ' . $e->getMessage());
            return collect([]);
        }
    }

    private function getPPNMasukData($tanggalMulai, $tanggalSelesai)
    {
        try {
            // Ambil data langsung dari database produk_masuks
            $query = DB::table('produk_masuks')
                ->select('tgl_masuk', 'total_harga')
                ->whereNotNull('tgl_masuk')
                ->whereNotNull('total_harga');
                
            if ($tanggalMulai && $tanggalSelesai) {
                $query->whereBetween('tgl_masuk', [$tanggalMulai, $tanggalSelesai]);
            }
            
            $data = $query->get();
            
            return $data->map(function($item) {
                return (object) [
                    'tgl_masuk' => $item->tgl_masuk,
                    'total_harga' => floatval($item->total_harga ?? 0)
                ];
            });
            
        } catch (\Exception $e) {
            // Log error jika perlu
            \Log::error('Error getting PPN Masuk data: ' . $e->getMessage());
            return collect([]);
        }
    }
}