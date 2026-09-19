<?php
namespace App\Http\Controllers;
use App\Models\Kas;
use App\Models\PembelianBarang;
use App\Models\PenjualanBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalPembelianBarang   = PembelianBarang::count();
        $pemasukanHariIni       = Kas::where('tanggal', Carbon::now()->format('Y-m-d'))->sum('pemasukan');
        $pengeluaranHariIni     = Kas::where('tanggal', Carbon::now()->format('Y-m-d'))->sum('pengeluaran');
        $penjualanHariIni       = Penjualan::where('tgl_transaksi', Carbon::now()->format('Y-m-d'))->sum('sub_total');
        
        // Ambil data stok yang sinkron dengan halaman stok produk
        $stokSummary = $this->getStokSummary();
        
        // Ambil 7 hari terakhir (termasuk hari ini)
        $dates = collect();
        for ($i = 6; $i >= 0; $i--) {
            $dates->push(Carbon::now()->subDays($i)->format('Y-m-d'));
        }
        
        // Query pemasukan & pengeluaran per hari
        $kasPerHari = Kas::selectRaw('tanggal, SUM(pemasukan) as pemasukan, SUM(pengeluaran) as pengeluaran')
            ->whereBetween('tanggal', [
                Carbon::now()->subDays(6)->format('Y-m-d'),
                Carbon::now()->format('Y-m-d')
            ])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get()
            ->keyBy('tanggal');
            
        $chartPemasukanPengeluaran = $dates->map(function ($date) use ($kasPerHari) {
            return [
                'date' => $date,
                'pemasukan' => isset($kasPerHari[$date]) ? (int)$kasPerHari[$date]->pemasukan : 0,
                'pengeluaran' => isset($kasPerHari[$date]) ? (int)$kasPerHari[$date]->pengeluaran : 0,
            ];
        });
        
        // Penjualan harian (sudah benar)
        $chartPenjualanRaw = Penjualan::selectRaw('DATE(tgl_transaksi) as date, SUM(sub_total) as total')
            ->whereBetween('tgl_transaksi', [
                Carbon::now()->subDays(6)->format('Y-m-d'),
                Carbon::now()->format('Y-m-d')
            ])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');
            
        $chartPenjualan = $dates->map(function ($date) use ($chartPenjualanRaw) {
            return (object)[
                'date' => $date,
                'total' => isset($chartPenjualanRaw[$date]) ? (int)$chartPenjualanRaw[$date]->total : 0
            ];
        });
        
        $transaksiHariIni       = Penjualan::where('tgl_transaksi', Carbon::now()->format('Y-m-d'))->count();
        $totalPenjualanBarang   = PenjualanBarang::count();
        
        return view('home', 
        [
            'totalPembelianBarang'=> $totalPembelianBarang,
            'totalPenjualanBarang'=> $totalPenjualanBarang,
            'pemasukanHariIni'   => $pemasukanHariIni,
            'pengeluaranHariIni' => $pengeluaranHariIni,
            'penjualanHariIni'   => $penjualanHariIni,
            'transaksiHariIni'   => $transaksiHariIni,
            'stokSummary'        => $stokSummary,
            'chartPenjualan'     => $chartPenjualan,
            'chartPemasukanPengeluaran' => $chartPemasukanPengeluaran
        ]);
    }
    
    /**
     * Get stock summary data that matches the stok produk page
     *
     * @return array
     */
    private function getStokSummary()
    {
        // Total semua produk dari pembelian dan penjualan
        $totalProdukPembelian = PembelianBarang::count();
        $totalProdukPenjualan = PenjualanBarang::count();
        $totalProduk = $totalProdukPembelian + $totalProdukPenjualan;
        
        // Stok habis (stok = 0) dari pembelian dan penjualan
        $stokHabisPembelian = PembelianBarang::where('stok', 0)->count();
        $stokHabisPenjualan = PenjualanBarang::where('stok', 0)->count();
        $stokHabis = $stokHabisPembelian + $stokHabisPenjualan;
        
        // Stok minimum (stok <= 10 tapi > 0) dari pembelian dan penjualan
        $stokMinimumPembelian = PembelianBarang::where('stok', '<=', 10)
                          ->where('stok', '>', 0)
                          ->count();
        $stokMinimumPenjualan = PenjualanBarang::where('stok', '<=', 10)
                          ->where('stok', '>', 0)
                          ->count();
        $stokMinimum = $stokMinimumPembelian + $stokMinimumPenjualan;
        
        // Stok aman (stok > 10) dari pembelian dan penjualan
        $stokAmanPembelian = PembelianBarang::where('stok', '>', 10)->count();
        $stokAmanPenjualan = PenjualanBarang::where('stok', '>', 10)->count();
        $stokAman = $stokAmanPembelian + $stokAmanPenjualan;
        
        // Produk dengan stok rendah dari pembelian (3 produk pertama)
        $produkStokRendahPembelian = PembelianBarang::where('stok', '<=', 10)
                             ->orderBy('stok', 'asc')
                             ->take(3)
                             ->get()
                             ->map(function($item) {
                                 return [
                                     'id' => $item->id,
                                     'kd_barang' => $item->kd_barang,
                                     'nm_barang' => $item->nm_barang,
                                     'stok' => $item->stok,
                                     'jenis' => 'Pembelian'
                                 ];
                             });
        
        // Produk dengan stok rendah dari penjualan (2 produk pertama)
        $produkStokRendahPenjualan = PenjualanBarang::where('stok', '<=', 10)
                             ->orderBy('stok', 'asc')
                             ->take(2)
                             ->get()
                             ->map(function($item) {
                                 return [
                                     'id' => $item->id,
                                     'kd_barang' => $item->kd_barang,
                                     'nm_barang' => $item->nm_barang,
                                     'stok' => $item->stok,
                                     'jenis' => 'Penjualan'
                                 ];
                             });
        
        // Gabungkan produk stok rendah dari pembelian dan penjualan
        $produkStokRendah = $produkStokRendahPembelian->concat($produkStokRendahPenjualan)
                             ->sortBy('stok')
                             ->values();
        
        return [
            'totalProduk' => $totalProduk,
            'stokHabis' => $stokHabis,
            'stokMinimum' => $stokMinimum,
            'stokAman' => $stokAman,
            'produkStokRendah' => $produkStokRendah
        ];
    }
    
    /**
     * Refresh stock data for AJAX requests
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshStok(Request $request)
    {
        try {
            $filter = $request->input('filter', 'all');
            $stokSummary = $this->getStokSummary();
            
            // Apply filter if needed
            if ($filter !== 'all') {
                $filteredProdukStokRendah = collect($stokSummary['produkStokRendah'])
                    ->where('jenis', ucfirst($filter))
                    ->values();
                    
                $stokSummary['produkStokRendah'] = $filteredProdukStokRendah;
                
                // Also adjust the counts based on filter
                if ($filter === 'pembelian') {
                    $stokSummary['totalProduk'] = PembelianBarang::count();
                    $stokSummary['stokHabis'] = PembelianBarang::where('stok', 0)->count();
                    $stokSummary['stokMinimum'] = PembelianBarang::where('stok', '<=', 10)
                        ->where('stok', '>', 0)
                        ->count();
                    $stokSummary['stokAman'] = PembelianBarang::where('stok', '>', 10)->count();
                } elseif ($filter === 'penjualan') {
                    $stokSummary['totalProduk'] = PenjualanBarang::count();
                    $stokSummary['stokHabis'] = PenjualanBarang::where('stok', 0)->count();
                    $stokSummary['stokMinimum'] = PenjualanBarang::where('stok', '<=', 10)
                        ->where('stok', '>', 0)
                        ->count();
                    $stokSummary['stokAman'] = PenjualanBarang::where('stok', '>', 10)->count();
                }
            }
            
            return response()->json($stokSummary);
        } catch (\Exception $e) {
            \Log::error('Error refreshing stock data: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => 'Gagal memperbarui data stok'
            ], 500);
        }
    }
    
    /**
     * Validate stock data consistency
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateStok()
    {
        try {
            $stokSummary = $this->getStokSummary();
            
            // Check if data is consistent
            $totalCalculated = $stokSummary['stokHabis'] + $stokSummary['stokMinimum'] + $stokSummary['stokAman'];
            $isConsistent = ($totalCalculated == $stokSummary['totalProduk']);
            
            return response()->json([
                'valid' => $isConsistent,
                'expected' => $stokSummary['totalProduk'],
                'calculated' => $totalCalculated
            ]);
        } catch (\Exception $e) {
            \Log::error('Error validating stock data: ' . $e->getMessage());
            return response()->json([
                'valid' => false,
                'message' => 'Gagal memvalidasi data stok'
            ], 500);
        }
    }
    
    /**
     * Get best selling products for dashboard
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBestSellingProducts(Request $request)
    {
        try {
            $days = $request->input('days', 7);
            $startDate = Carbon::now()->subDays($days)->format('Y-m-d');
            $endDate = Carbon::now()->format('Y-m-d');
            
            // Query untuk mendapatkan produk terlaris dari data penjualan
            // Berdasarkan struktur laporan penjualan yang ada
            $bestSellingProducts = DB::select("
                SELECT 
                    dp.nm_produk,
                    SUM(dp.quantity) as total_quantity,
                    COUNT(DISTINCT p.id) as transaction_count
                FROM penjualan p
                JOIN detail_penjualan dp ON p.id = dp.id_penjualan
                WHERE p.tgl_transaksi BETWEEN ? AND ?
                AND dp.nm_produk IS NOT NULL
                AND dp.nm_produk != ''
                GROUP BY dp.nm_produk
                ORDER BY total_quantity DESC
                LIMIT 8
            ", [$startDate, $endDate]);
            
            // Convert to array for consistent JSON response
            $products = array_map(function($product) {
                return [
                    'nm_produk' => $product->nm_produk,
                    'total_quantity' => (int)$product->total_quantity,
                    'transaction_count' => (int)$product->transaction_count
                ];
            }, $bestSellingProducts);
            
            return response()->json($products);
            
        } catch (\Exception $e) {
            \Log::error('Error in getBestSellingProducts: ' . $e->getMessage());
            
            return response()->json([
                'error' => true,
                'message' => 'Gagal mengambil data produk terlaris',
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
    
    /**
     * Alternative method if the above query doesn't work due to table structure
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBestSellingProductsAlternative(Request $request)
    {
        try {
            $days = $request->input('days', 7);
            $startDate = Carbon::now()->subDays($days)->format('Y-m-d');
            $endDate = Carbon::now()->format('Y-m-d');
            
            // Query alternatif menggunakan Eloquent jika ada model relationship
            $penjualanData = Penjualan::with('detailPenjualans')
                ->whereBetween('tgl_transaksi', [$startDate, $endDate])
                ->get();
            
            $productStats = [];
            
            foreach ($penjualanData as $penjualan) {
                if ($penjualan->detailPenjualans) {
                    foreach ($penjualan->detailPenjualans as $detail) {
                        if (!empty($detail->nm_produk)) {
                            $productName = $detail->nm_produk;
                            
                            if (!isset($productStats[$productName])) {
                                $productStats[$productName] = [
                                    'nm_produk' => $productName,
                                    'total_quantity' => 0,
                                    'transaction_count' => 0,
                                    'transaction_ids' => []
                                ];
                            }
                            
                            $productStats[$productName]['total_quantity'] += (int)$detail->quantity;
                            
                            // Count unique transactions
                            if (!in_array($penjualan->id, $productStats[$productName]['transaction_ids'])) {
                                $productStats[$productName]['transaction_ids'][] = $penjualan->id;
                                $productStats[$productName]['transaction_count']++;
                            }
                        }
                    }
                }
            }
            
            // Remove transaction_ids from final result and sort by quantity
            $products = array_values($productStats);
            foreach ($products as &$product) {
                unset($product['transaction_ids']);
            }
            
            // Sort by total_quantity descending
            usort($products, function($a, $b) {
                return $b['total_quantity'] <=> $a['total_quantity'];
            });
            
            // Limit to 8 products
            $products = array_slice($products, 0, 8);
            
            return response()->json($products);
            
        } catch (\Exception $e) {
            \Log::error('Error in getBestSellingProductsAlternative: ' . $e->getMessage());
            
            return response()->json([
                'error' => true,
                'message' => 'Gagal mengambil data produk terlaris',
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
    
    /**
     * Handle logout request
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        // Log the logout activity (optional)
        \Log::info('User logged out: ' . Auth::user()->email ?? 'Unknown');
        
        // Logout the user
        Auth::logout();
        
        // Invalidate the session
        $request->session()->invalidate();
        
        // Regenerate CSRF token
        $request->session()->regenerateToken();
        
        // Redirect to login page with success message
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout dari sistem.');
    }
}