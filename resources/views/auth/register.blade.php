<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Santri Baru - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-chalimi-gradient min-h-screen flex items-center justify-center p-4">
    
    <!-- Decorative Orbs -->
    <div class="blur-orb blur-orb-green w-96 h-96 top-0 left-0 animate-pulse"></div>
    <div class="blur-orb blur-orb-emerald w-96 h-96 bottom-0 right-0 animate-pulse" style="animation-duration: 4s"></div>

    <div class="glass-panel w-full max-w-md p-8 relative z-10 animate-fade-in-up">
        
        <div class="text-center mb-8">
            <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg border border-white/30 overflow-hidden p-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Al-Chalimi" class="w-full h-full object-contain">
            </div>
            <h1 class="text-2xl font-bold text-chalimi-900 tracking-tight">Pendaftaran Akun Wali</h1>
            <p class="text-chalimi-700 text-sm mt-1">SIM PP Tahfidzul Quran Al-Chalimi</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-chalimi-800 mb-1">Nama Lengkap Wali</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="glass-input w-full placeholder-chalimi-500/50" placeholder="Contoh: Bpk. Ahmad">
                @error('name') <span class="text-xs text-red-600 mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-chalimi-800 mb-1">Nomor WhatsApp</label>
                <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required
                    class="glass-input w-full placeholder-chalimi-500/50" placeholder="081234567890">
                @error('phone') <span class="text-xs text-red-600 mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-chalimi-800 mb-1">Password</label>
                <input id="password" type="password" name="password" required
                    class="glass-input w-full" placeholder="••••••••">
                @error('password') <span class="text-xs text-red-600 mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-chalimi-800 mb-1">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="glass-input w-full" placeholder="••••••••">
            </div>

            <button type="submit" class="w-full btn-chalimi text-lg py-3 shadow-xl transform active:scale-95 transition-transform mt-4">
                Daftar Sekarang
            </button>
        </form>

        <div class="mt-8 text-center border-t border-chalimi-200 pt-6">
            <p class="text-sm text-chalimi-800">Sudah punya akun?</p>
            <a href="{{ route('login') }}" class="inline-block mt-2 text-sm font-bold text-chalimi-700 hover:text-chalimi-900 hover:underline">
                Masuk di sini
            </a>
        </div>
    </div>

</body>
</html>
