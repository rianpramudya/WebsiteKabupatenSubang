<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | Controller ini menangani autentikasi pengguna dan redirect
    | ke halaman yang sesuai. Trait AuthenticatesUsers menyediakan
    | fungsionalitas yang diperlukan, termasuk proteksi brute force.
    |
    */

    use AuthenticatesUsers;

    /**
     * Ke mana pengguna akan diarahkan setelah login.
     * Logika kustom di metode authenticated() akan menimpa ini.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Buat instance controller baru.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Menampilkan form login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Mengkustomisasi field username untuk login.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Dipanggil setelah pengguna berhasil diautentikasi.
     * Logika ini akan mengarahkan pengguna berdasarkan role mereka.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->hasRole('super-admin')) {
            return redirect()->intended(route('dashboard'));
        }

        // ======================================================================
        // PERBAIKAN: Tambahkan logika redirect untuk admin perangkat daerah
        // ======================================================================
        if ($user->hasRole('admin-perangkat-daerah') && $user->perangkatDaerah) {
            return redirect()->intended(route('perangkat.show', ['perangkatDaerah' => $user->perangkatDaerah->slug]));
        }

        if ($user->hasRole('admin-kecamatan') && $user->kecamatan) {
            return redirect()->intended(route('kecamatan.show', ['kecamatan' => $user->kecamatan->slug]));
        }

        // Jika ada kasus lain, arahkan ke home
        return redirect()->intended($this->redirectTo);
    }
}
