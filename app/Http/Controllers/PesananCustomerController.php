<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananCustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display list of customer's orders
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $status = $request->input('status', 'semua');

        $query = Pesanan::with(['detailPesanans.penjualanBarang'])
            ->where('user_id', $user->id)
            ->orderBy('id', 'desc');

        if ($status && $status !== 'semua') {
            $query->where('status_pesanan', $status);
        }

        $pesanans = $query->paginate(10)->withQueryString();

        // Counts for tab badges
        $countSemua = Pesanan::where('user_id', $user->id)->count();
        $countMenunggu = Pesanan::where('user_id', $user->id)->where('status_pesanan', 'menunggu_pembayaran')->count();
        $countDiproses = Pesanan::where('user_id', $user->id)->where('status_pesanan', 'diproses')->count();
        $countDikirim = Pesanan::where('user_id', $user->id)->where('status_pesanan', 'dikirim')->count();
        $countSelesai = Pesanan::where('user_id', $user->id)->where('status_pesanan', 'selesai')->count();

        return view('customer.pesanan', compact(
            'pesanans',
            'status',
            'countSemua',
            'countMenunggu',
            'countDiproses',
            'countDikirim',
            'countSelesai'
        ));
    }

    /**
     * Show single order details
     */
    public function show($id)
    {
        $user = Auth::user();
        $pesanan = Pesanan::with(['detailPesanans.penjualanBarang'])
            ->where('user_id', $user->id)
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $pesanan
        ]);
    }

    /**
     * AJAX Get Live Courier Tracking Information
     */
    public function tracking($id)
    {
        $user = Auth::user();
        $query = Pesanan::with(['detailPesanans']);

        if ($user && !in_array($user->role_id, [1, 2])) {
            $query->where('user_id', $user->id);
        }

        $pesanan = $query->findOrFail($id);

        return response()->json([
            'success' => true,
            'order' => [
                'id'                  => $pesanan->id,
                'no_pesanan'          => $pesanan->no_pesanan,
                'ekspedisi'           => $pesanan->ekspedisi,
                'layanan_ekspedisi'   => $pesanan->layanan_ekspedisi,
                'no_resi'             => $pesanan->no_resi,
                'nama_penerima'       => $pesanan->nama_penerima,
                'no_telepon'          => $pesanan->no_telepon,
                'alamat_lengkap'      => $pesanan->alamat_lengkap . ($pesanan->kelurahan ? ', Kel. ' . $pesanan->kelurahan : '') . ($pesanan->kecamatan ? ', Kec. ' . $pesanan->kecamatan : '') . ', ' . $pesanan->kota . ', ' . $pesanan->provinsi . ' ' . $pesanan->kode_pos,
                'status_pesanan'      => $pesanan->status_pesanan,
                'status_badge'        => $pesanan->status_badge,
                'estimasi_pengiriman' => $pesanan->estimasi_pengiriman,
                'total_bayar'         => $pesanan->formatted_total_bayar,
                'metode_pembayaran'   => $pesanan->metode_pembayaran_label,
            ],
            'timeline' => $pesanan->getTrackingTimeline(),
        ]);
    }

    /**
     * Display customer profile view
     */
    public function profile()
    {
        $user = Auth::user();

        // Summary statistics for profile banner
        $totalPesanan = Pesanan::where('user_id', $user->id)->count();
        $pesananAktif = Pesanan::where('user_id', $user->id)
            ->whereIn('status_pesanan', ['menunggu_pembayaran', 'diproses', 'dikirim'])
            ->count();
        $pesananSelesai = Pesanan::where('user_id', $user->id)
            ->where('status_pesanan', 'selesai')
            ->count();

        return view('customer.profile', compact(
            'user',
            'totalPesanan',
            'pesananAktif',
            'pesananSelesai'
        ));
    }

    /**
     * Update customer personal details and shipping address
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|max:255|unique:users,email,' . $user->id,
            'no_hp'  => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:1000',
        ], [
            'name.required'  => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique'   => 'Email ini sudah digunakan oleh akun lain.',
        ]);

        $user->update([
            'name'   => $request->name,
            'email'  => $request->email,
            'no_hp'  => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui!');
    }

    /**
     * Update customer password
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required'         => 'Password baru wajib diisi.',
            'password.min'              => 'Password baru minimal 6 karakter.',
            'password.confirmed'        => 'Konfirmasi password baru tidak cocok.',
        ]);

        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.'])->withInput();
        }

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Password Anda berhasil diperbarui!');
    }
}
