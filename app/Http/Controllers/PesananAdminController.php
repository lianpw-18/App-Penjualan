<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'checkRole:admin,kasir,kepala toko']);
    }

    /**
     * Admin view for all online customer orders
     */
    public function index(Request $request)
    {
        $status = $request->input('status');
        $search = $request->input('q');

        $query = Pesanan::with(['user', 'detailPesanans.penjualanBarang'])
            ->orderBy('id', 'desc');

        if ($status && $status !== 'all') {
            $query->where('status_pesanan', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('no_pesanan', 'like', "%{$search}%")
                  ->orWhere('nama_penerima', 'like', "%{$search}%")
                  ->orWhere('no_telepon', 'like', "%{$search}%")
                  ->orWhere('no_resi', 'like', "%{$search}%");
            });
        }

        $pesanans = $query->paginate(15)->withQueryString();

        // Statistics
        $totalOrders = Pesanan::count();
        $pendingOrders = Pesanan::where('status_pesanan', 'menunggu_pembayaran')->count();
        $processingOrders = Pesanan::where('status_pesanan', 'diproses')->count();
        $shippingOrders = Pesanan::where('status_pesanan', 'dikirim')->count();
        $completedOrders = Pesanan::where('status_pesanan', 'selesai')->count();

        return view('pesanan-admin.index', compact(
            'pesanans',
            'status',
            'search',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'shippingOrders',
            'completedOrders'
        ));
    }

    /**
     * Update order status & resi
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_pesanan' => 'required|in:menunggu_pembayaran,diproses,dikirim,selesai,dibatalkan',
            'no_resi'        => 'nullable|string|max:100',
        ]);

        $pesanan = Pesanan::findOrFail($id);

        $pesanan->status_pesanan = $request->status_pesanan;
        if ($request->filled('no_resi')) {
            $pesanan->no_resi = $request->no_resi;
        }
        if ($request->status_pesanan === 'diproses' && !$pesanan->tgl_pembayaran) {
            $pesanan->tgl_pembayaran = now();
        }

        $pesanan->save();

        return response()->json([
            'success' => true,
            'message' => 'Status pesanan ' . $pesanan->no_pesanan . ' berhasil diperbarui!',
            'data'    => $pesanan
        ]);
    }
}
