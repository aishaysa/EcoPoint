<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LOGIN ADMIN
    |--------------------------------------------------------------------------
    */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $user = User::where('email', $credentials['email'])
            ->where('role_id', 1)
            ->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user, $request->has('remember'));

            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password admin salah.',
        ])->onlyInput('email');
    }

    /*
    |--------------------------------------------------------------------------
    | LUPA PASSWORD ADMIN
    |--------------------------------------------------------------------------
    */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $admin = User::where('email', $request->email)
            ->where('role_id', 1)
            ->first();

        if (!$admin) {
            return back()->withErrors([
                'email' => 'Email tersebut bukan email admin.',
            ]);
        }

        $status = Password::sendResetLink([
            'email' => $request->email,
        ]);

        return $status === Password::RESET_LINK_SENT
            ? back()->with([
                'status' => 'Link reset password telah dikirim ke email Anda!',
            ])
            : back()->withErrors([
                'email' => 'Gagal mengirim link reset password.',
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | HALAMAN RESET PASSWORD
    |--------------------------------------------------------------------------
    */
    public function showResetForm(Request $request, $token)
    {
        return view('admin.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | PROSES RESET PASSWORD
    |--------------------------------------------------------------------------
    */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $admin = User::where('email', $request->email)
            ->where('role_id', 1)
            ->first();

        if (!$admin) {
            return back()->withErrors([
                'email' => 'Akun tersebut bukan akun admin.',
            ]);
        }

        $status = Password::reset(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()
                ->route('admin.login')
                ->with('status', 'Password berhasil direset! Silakan login.')
            : back()->withErrors([
                'email' => 'Token reset tidak valid atau sudah kadaluarsa.',
            ]);
    }
}