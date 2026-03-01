<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AlumniToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:wali_santri,alumni,admin',
            'auth_code' => 'required_if:role,admin|nullable|string',
            'alumni_token' => 'required_if:role,alumni|nullable|string',
        ]);

        $role = $validated['role'];
        $adminCode = config('app.admin_reg_code');
        $alumniToken = null;

        // 1. Check for Admin registration (Legacy/Secret)
        if (!empty($validated['auth_code'])) {
            $inputCode = trim($validated['auth_code']);
            if ($adminCode && $inputCode === (string)$adminCode) {
                $role = 'admin';
            } else {
                return back()->withErrors(['auth_code' => 'Kode registrasi admin tidak valid.'])->withInput();
            }
        }

        // 2. Check for Alumni registration (Token based)
        if ($role === 'alumni') {
            $alumniToken = AlumniToken::valid()->where('token', $validated['alumni_token'])->first();
            
            if (!$alumniToken) {
                return back()->withErrors(['alumni_token' => 'Token alumni tidak valid atau sudah terpakai.'])->withInput();
            }
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => $role,
        ]);

        // 3. Update Token if alumni
        if ($alumniToken) {
            $alumniToken->update([
                'is_used' => true,
                'used_by' => $user->id
            ]);
        }

        Auth::login($user);

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('success', 'Registrasi Admin berhasil!');
        }

        if ($user->isAlumni()) {
             return redirect()->route('welcome')->with('success', 'Pendaftaran Alumni berhasil! Selamat datang kembali.');
        }

        return redirect()->route('wali.dashboard')->with('success', 'Pendaftaran berhasil! Selamat datang di SIM Al-Chalimi.');
    }
}
