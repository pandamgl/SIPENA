<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ProdiUnit;

class AuthController extends Controller
{
    // Menampilkan Form Login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Login
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

    // Menampilkan Form Register
    public function showRegister()
    {
        $prodiList = ProdiUnit::all();
        return view('auth.register', compact('prodiList'));
    }

    // Proses Register
    public function register(Request $request)
    {
        $request->validate([
            'nama' => ['nullable', 'string', 'max:100'],
            'nama_lengkap' => ['nullable', 'string', 'max:100'],
            'nim_nik' => ['required', 'string', 'max:30'],
            'prodi_unit_id' => ['required', 'exists:prodi_unit,id'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'username.unique' => 'Username sudah terdaftar, silakan pilih username lain.',
            'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal terdiri dari 6 karakter.',
            'prodi_unit_id.exists' => 'Pilihan program studi / unit tidak valid.',
        ]);

        $namaLengkap = $request->input('nama') ?: $request->input('nama_lengkap');

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'plain_password' => $request->password,
            'nama_lengkap' => $namaLengkap,
            'nim_nik' => $request->nim_nik,
            'prodi_unit_id' => $request->prodi_unit_id,
            'role' => 'pengaju',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('user.dashboard'));
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}