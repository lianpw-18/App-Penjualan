<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\PenjualanBarang;
use App\Models\SettingPenjualan;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Display public landing & catalog page for Gamis & Busana Muslim
     */
    public function index(Request $request)
    {
        $search = $request->input('q');
        $kategoriId = $request->input('kategori');
        $sortBy = $request->input('sort', 'latest');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        // Query visible products
        $query = PenjualanBarang::query()
            ->visible()
            ->with(['kategori', 'satuan']);

        // Search by name or description
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nm_barang', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('kd_penjualan_barang', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if (!empty($kategoriId) && $kategoriId !== 'all') {
            $query->where('kategori_id', $kategoriId);
        }

        // Filter by price
        if (!empty($minPrice)) {
            $query->where('harga_jual', '>=', (float)$minPrice);
        }
        if (!empty($maxPrice)) {
            $query->where('harga_jual', '<=', (float)$maxPrice);
        }

        // Sorting
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('harga_jual', 'asc');
                break;
            case 'price_high':
                $query->orderBy('harga_jual', 'desc');
                break;
            case 'popular':
            case 'stock':
                $query->orderBy('stok', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('nm_barang', 'asc');
                break;
            case 'latest':
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Kategori::all();
        $setting = SettingPenjualan::first();

        // Featured products (top available stock / latest)
        $featuredProducts = PenjualanBarang::visible()
            ->with(['kategori', 'satuan'])
            ->where('stok', '>', 0)
            ->orderBy('stok', 'desc')
            ->take(8)
            ->get();

        // Total statistics for hero
        $totalProducts = PenjualanBarang::visible()->count();
        $totalStock = PenjualanBarang::visible()->sum('stok');

        return view('landing.index', compact(
            'products',
            'categories',
            'setting',
            'featuredProducts',
            'search',
            'kategoriId',
            'sortBy',
            'totalProducts',
            'totalStock'
        ));
    }

    /**
     * Return single product details as JSON (for Quick View Modal) or view
     */
    public function show($id, Request $request)
    {
        $product = PenjualanBarang::visible()
            ->with(['kategori', 'satuan'])
            ->findOrFail($id);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $product->id,
                    'kd_penjualan_barang' => $product->kd_penjualan_barang,
                    'nm_barang' => $product->nm_barang,
                    'deskripsi' => $product->deskripsi,
                    'stok' => $product->stok,
                    'harga_jual' => $product->harga_jual,
                    'formatted_harga_jual' => $product->formatted_harga_jual,
                    'diskon_persen' => $product->diskon_persen,
                    'nominal_diskon' => $product->nominal_diskon,
                    'harga_setelah_diskon' => $product->harga_setelah_diskon,
                    'formatted_harga_setelah_diskon' => $product->formatted_harga_setelah_diskon,
                    'ppn_persen' => $product->ppn_persen,
                    'harga_final' => $product->harga_final,
                    'formatted_harga_final' => $product->formatted_harga_final,
                    'kategori' => $product->kategori ? $product->kategori->kategori : 'Umum',
                    'satuan' => $product->satuan ? $product->satuan->satuan : 'Pcs',
                    'status_stok' => $product->status_stok,
                ]
            ]);
        }

        // Related products
        $relatedProducts = PenjualanBarang::visible()
            ->where('id', '!=', $id)
            ->where('kategori_id', $product->kategori_id)
            ->take(4)
            ->get();

        return view('landing.detail', compact('product', 'relatedProducts'));
    }

    /**
     * API for live search / filtering
     */
    public function apiProducts(Request $request)
    {
        $query = PenjualanBarang::visible()->with(['kategori', 'satuan']);

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('nm_barang', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori') && $request->kategori !== 'all') {
            $query->where('kategori_id', $request->kategori);
        }

        $products = $query->take(20)->get();

        return response()->json([
            'success' => true,
            'count' => $products->count(),
            'data' => $products
        ]);
    }
}
