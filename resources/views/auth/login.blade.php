@extends('layouts.app')

@section('content')
<div class="h-[80vh] flex items-center justify-center">
    <div class="glass-panel w-full max-w-md p-8 relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-chalimi-300 rounded-full blur-3xl opacity-50"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-blue-300 rounded-full blur-3xl opacity-50"></div>
        
        <div class="text-center mb-8 relative z-10">
            <div class="w-16 h-16 bg-chalimi-600 rounded-2xl mx-auto flex items-center justify-center text-white text-2xl shadow-lg mb-4">
                <i class="fa-solid fa-user-lock"></i>
            </div>
            <h2 class="text-2xl font-bold text-chalimi-900">Login Aplikasi</h2>
            <p class="text-sm text-chalimi-700">Masuk untuk memantau perkembangan</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5 relative z-10">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-chalimi-800 mb-2">Email / Nomor HP</label>
                <input type="text" name="login" required autofocus class="glass-input w-full px-4 py-3 rounded-xl focus:ring-2 focus:ring-chalimi-400 outline-none transition" placeholder="Contoh: wali@alchalimi.com">
                @error('login')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-chalimi-800 mb-2">Password</label>
                <input type="password" name="password" required class="glass-input w-full px-4 py-3 rounded-xl focus:ring-2 focus:ring-chalimi-400 outline-none transition">
                @error('password')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="remember" class="rounded border-chalimi-300 text-chalimi-600 focus:ring-chalimi-500">
                    <span class="text-chalimi-700">Ingat Saya</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-chalimi-600 hover:underline hover:text-chalimi-800 font-semibold">Lupa Password?</a>
                @endif
            </div>

            <button type="submit" class="w-full py-3 bg-gradient-to-r from-chalimi-600 to-chalimi-500 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:scale-[1.02] transition transform duration-200">
                Masuk Dashboard
            </button>
        </form>
        
        <div class="mt-6 text-center text-sm relative z-10">
            <a href="{{ route('welcome') }}" class="text-chalimi-600 font-semibold hover:underline">← Kembali ke Beranda</a>
        </div>
    </div>
</div>
@endsection
