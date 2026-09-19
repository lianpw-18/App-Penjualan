<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    


    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Tampilan login khusus Kasir & Admin POS
     */
    public function showAdminLoginForm()
    {
        return view('auth.login-admin');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {
        // 1. Akun Admin/Kasir khusus (admin@gmail.com atau role admin/kasir/kepala toko)
        // Selalu diarahkan langsung ke Dashboard Kasir / POS
        if ($user->email === 'admin@gmail.com' || in_array($user->role->role ?? '', ['admin', 'kasir', 'kepala toko'])) {
            session()->forget('url.intended');
            return redirect()->route('dashboard');
        }

        // 2. Semua akun pelanggan lain diarahkan masuk ke Dashboard Pelanggan
        return redirect()->intended(route('customer.pesanan'));
    }
}
