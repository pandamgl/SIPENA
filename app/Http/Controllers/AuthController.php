<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    //Menampilkan Form Login
    public function showLogin()
    {
        return view('auth.login');
    }

    //Login
    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $loginType = filter_var($request->input('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $loginType => $request->input('username'),
            'password' => $request->input('password'),
        ];

        $remember = $request->has('remember');

        try {
            if (Auth::attempt($credentials, $remember)) {
                $request->session()->regenerate();

                // Dashboard sesuai role user
                if (Auth::user()->role === 'admin') {
                    return redirect()->intended(route('admin.dashboard'));
                }

                return redirect()->intended(route('user.dashboard'));
            }
        } catch (\RuntimeException $e) {
            // Tangani jika ada data di database yang diisi password polos / belum di-hash dengan Bcrypt
            $user = User::where($loginType, $request->input('username'))->first();
            if ($user && ($user->password === $request->input('password') || $user->plain_password === $request->input('password'))) {
                $user->password = Hash::make($request->input('password'));
                $user->plain_password = $request->input('password');
                $user->save();

                Auth::login($user, $remember);
                $request->session()->regenerate();

                if ($user->role === 'admin') {
                    return redirect()->intended(route('admin.dashboard'));
                }

                return redirect()->intended(route('user.dashboard'));
            }

            return back()->withErrors([
                'username' => 'Format password di database tidak valid. Pastikan password telah di-hash dengan Bcrypt.',
            ])->onlyInput('username');
        }

        return back()->withErrors([
            'username' => 'Username atau password yang dimasukkan salah.',
        ])->onlyInput('username');
    }

    //Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}