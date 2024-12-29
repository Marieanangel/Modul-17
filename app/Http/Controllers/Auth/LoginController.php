<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Override fungsi sendFailedLoginResponse untuk pesan error kustom.
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $error = [];

        // Cek apakah email yang dimasukkan ada di database
        $user = User::where('email', $request->email)->first();

        // Tambahkan pesan error untuk email jika tidak ditemukan
        if (!$user) {
            $error['email'] = 'Email yang Anda masukkan salah.';
        }

        // Tambahkan pesan error untuk password jika email ditemukan tapi password salah
        if ($user && !Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $error['password'] = 'Password yang Anda masukkan salah.';
        }

        // Jika email salah, password juga salah (karena user tidak ada), tambahkan pesan error untuk password
        if (!$user && $request->filled('password')) {
            $error['password'] = 'Password yang Anda masukkan salah.';
        }

        return back()->withErrors($error)->onlyInput('email');
    }
}
