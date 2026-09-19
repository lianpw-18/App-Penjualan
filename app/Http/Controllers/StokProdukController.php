<?php
namespace App\Http\Controllers;
use Dompdf\Dompdf;
use App\Models\PenjualanBarang;
use App\Models\PembelianBarang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kategori; // Tambahkan ini
use App\Models\Satuan;   // Tambahkan ini

class StokProdukController extends Controller
{
    public function index()
    {
        return view('stok-produk.index');
    }
    
    public function getDataStok(Request $request)
    {
        $selectedOption = $request->input('opsi');
        $jenisStok = $request->input('jenis_stok', 'semua');
        $stokData = [];
        
        // Ambil data pembelian jika diperlukan
        if ($jenisStok == 'pembelian' || $jenisStok == 'semua') {
            $pembelianQuery = PembelianBarang::with(['kategori', 'satuan']);
            
            if ($selectedOption == 'minimum') {
                $pembelianQuery->where('stok', '<=', 10);
            } elseif ($selectedOption == 'stok-habis') {
                $pembelianQuery->where('stok', 0);
            }
            
            $pembelianBarangs = $pembelianQuery->get();
            
            foreach ($pembelianBarangs as $barang) {
                // Perbaikan: Pastikan relasi kategori ada
                $kategori = '-';
                if ($barang->kategori) {
                    $kategori = $barang->kategori->nm_kategori;
                } else {
                    // Fallback: Query manual jika relasi tidak bekerja
                    $kategoriData = Kategori::find($barang->kategori_id);
                    if ($kategoriData) {
                        $kategori = $kategoriData->nm_kategori;
                    }
                }
                
                $stokData[] = [
                    'id' => $barang->id,
                    'kd_barang' => $barang->kd_pembelian_barang,
                    'nm_barang' => $barang->nm_barang,
                    'kategori' => $kategori, // Gunakan variabel $kategori yang sudah diperbaiki
                    'satuan' => $barang->satuan->nm_satuan ?? '-',
                    'stok' => $barang->stok,
                    'harga_beli' => $barang->harga_beli,
                    'harga_jual' => $barang->harga_jual,
                    'jenis' => 'Pembelian',
                    'deskripsi' => $barang->deskripsi
                ];
            }
        }
        
        // Ambil data penjualan jika diperlukan
        if ($jenisStok == 'penjualan' || $jenisStok == 'semua') {
            $penjualanQuery = PenjualanBarang::with(['kategori', 'satuan']);
            
            if ($selectedOption == 'minimum') {
                $penjualanQuery->where('stok', '<=', 10);
            } elseif ($selectedOption == 'stok-habis') {
                $penjualanQuery->where('stok', 0);
            }
            
            $penjualanBarangs = $penjualanQuery->get();
            
            foreach ($penjualanBarangs as $barang) {
                // Perbaikan: Pastikan relasi kategori ada
                $kategori = '-';
                if ($barang->kategori) {
                    $kategori = $barang->kategori->nm_kategori;
                } else {
                    // Fallback: Query manual jika relasi tidak bekerja
                    $kategoriData = Kategori::find($barang->kategori_id);
                    if ($kategoriData) {
                        $kategori = $kategoriData->nm_kategori;
                    }
                }
                
                $stokData[] = [
                    'id' => $barang->id,
                    'kd_barang' => $barang->kd_penjualan_barang,
                    'nm_barang' => $barang->nm_barang,
                    'kategori' => $kategori, // Gunakan variabel $kategori yang sudah diperbaiki
                    'satuan' => $barang->satuan->nm_satuan ?? '-',
                    'stok' => $barang->stok,
                    'harga_beli' => $barang->harga_beli,
                    'harga_jual' => $barang->harga_jual,
                    'jenis' => 'Penjualan',
                    'deskripsi' => $barang->deskripsi
                ];
            }
        }
        
        // Urutkan berdasarkan nama barang
        usort($stokData, function($a, $b) {
            return strcmp($a['nm_barang'], $b['nm_barang']);
        });
        
        return response()->json($stokData);
    }
    
    /**
     * Print Stok Produk Report 
     */
    public function printLaporanStok(Request $request)
    {
        $selectedOption = $request->input('opsi');
        $jenisStok = $request->input('jenis_stok', 'semua');
        
        $stokData = [];
        
        // Ambil data pembelian jika diperlukan
        if ($jenisStok == 'pembelian' || $jenisStok == 'semua') {
            $pembelianQuery = PembelianBarang::with(['kategori', 'satuan']);
            
            if ($selectedOption == 'minimum') {
                $pembelianQuery->where('stok', '<=', 10);
            } elseif ($selectedOption == 'stok-habis') {
                $pembelianQuery->where('stok', 0);
            }
            
            $pembelianBarangs = $pembelianQuery->get();
            
            foreach ($pembelianBarangs as $barang) {
                // Perbaikan: Pastikan relasi kategori ada
                $kategori = '-';
                if ($barang->kategori) {
                    $kategori = $barang->kategori->nm_kategori;
                } else {
                    // Fallback: Query manual jika relasi tidak bekerja
                    $kategoriData = Kategori::find($barang->kategori_id);
                    if ($kategoriData) {
                        $kategori = $kategoriData->nm_kategori;
                    }
                }
                
                $stokData[] = [
                    'id' => $barang->id,
                    'kd_barang' => $barang->kd_pembelian_barang,
                    'nm_barang' => $barang->nm_barang,
                    'kategori' => $kategori, // Gunakan variabel $kategori yang sudah diperbaiki
                    'satuan' => $barang->satuan->nm_satuan ?? '-',
                    'stok' => $barang->stok,
                    'harga_beli' => $barang->harga_beli,
                    'harga_jual' => $barang->harga_jual,
                    'jenis' => 'Pembelian',
                    'deskripsi' => $barang->deskripsi
                ];
            }
        }
        
        // Ambil data penjualan jika diperlukan
        if ($jenisStok == 'penjualan' || $jenisStok == 'semua') {
            $penjualanQuery = PenjualanBarang::with(['kategori', 'satuan']);
            
            if ($selectedOption == 'minimum') {
                $penjualanQuery->where('stok', '<=', 10);
            } elseif ($selectedOption == 'stok-habis') {
                $penjualanQuery->where('stok', 0);
            }
            
            $penjualanBarangs = $penjualanQuery->get();
            
            foreach ($penjualanBarangs as $barang) {
                // Perbaikan: Pastikan relasi kategori ada
                $kategori = '-';
                if ($barang->kategori) {
                    $kategori = $barang->kategori->nm_kategori;
                } else {
                    // Fallback: Query manual jika relasi tidak bekerja
                    $kategoriData = Kategori::find($barang->kategori_id);
                    if ($kategoriData) {
                        $kategori = $kategoriData->nm_kategori;
                    }
                }
                
                $stokData[] = [
                    'id' => $barang->id,
                    'kd_barang' => $barang->kd_penjualan_barang,
                    'nm_barang' => $barang->nm_barang,
                    'kategori' => $kategori, // Gunakan variabel $kategori yang sudah diperbaiki
                    'satuan' => $barang->satuan->nm_satuan ?? '-',
                    'stok' => $barang->stok,
                    'harga_beli' => $barang->harga_beli,
                    'harga_jual' => $barang->harga_jual,
                    'jenis' => 'Penjualan',
                    'deskripsi' => $barang->deskripsi
                ];
            }
        }
        
        // Urutkan berdasarkan nama barang
        usort($stokData, function($a, $b) {
            return strcmp($a['nm_barang'], $b['nm_barang']);
        });
        
        $pdf = new Dompdf();
        $html = view('/stok-produk/laporan-stok', compact('stokData', 'selectedOption', 'jenisStok'))->render();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        $pdf->stream('laporan-stok.pdf', ['Attachment' => false]);
    }
}