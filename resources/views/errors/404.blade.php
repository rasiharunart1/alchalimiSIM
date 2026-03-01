@extends('layouts.app')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center p-4">
    <div class="relative w-full max-w-lg text-center">
        <!-- Background Blur Orbs -->
        <div class="absolute -z-10 w-64 h-64 bg-chalimi-500/20 rounded-full blur-3xl -top-20 -left-10"></div>
        <div class="absolute -z-10 w-64 h-64 bg-emerald-500/20 rounded-full blur-3xl -bottom-20 -right-10"></div>
        
        <div class="glass-panel p-12 md:p-16 border-white/50 border-2 overflow-hidden relative group">
            <!-- Animated Background Glow -->
            <div class="absolute inset-0 bg-gradient-to-tr from-chalimi-500/5 to-transparent transition-opacity duration-700 opacity-50 group-hover:opacity-100"></div>

            <div class="relative z-10 space-y-8">
                <!-- 404 Number -->
                <div class="relative">
                    <h1 class="text-[8rem] md:text-[10rem] font-black leading-none text-transparent bg-clip-text bg-gradient-to-b from-white to-white/20 select-none opacity-20">
                        404
                    </h1>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <i class="fa-solid fa-compass-drafting text-6xl text-chalimi-400 animate-bounce"></i>
                    </div>
                </div>

                <div class="space-y-3">
                    <h2 class="text-3xl md:text-4xl font-bold text-white leading-tight">
                        Halaman Tidak Ditemukan
                    </h2>
                    <p class="text-chalimi-200 text-lg max-w-sm mx-auto">
                        Maaf, halaman yang Anda cari tidak tersedia atau telah dipindahkan ke alamat lain.
                    </p>
                </div>

                <div class="pt-6">
                    <a href="/" class="inline-flex items-center gap-3 px-8 py-4 bg-chalimi-600 hover:bg-chalimi-500 text-white rounded-2xl font-bold shadow-xl shadow-chalimi-600/20 transition-all transform hover:scale-105 active:scale-95 group">
                        <i class="fa-solid fa-house group-hover:-translate-x-1 transition-transform"></i>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>

        <!-- Decorative Elements -->
        <div class="mt-8 flex justify-center gap-4 opacity-40">
            <span class="w-12 h-1 bg-chalimi-600 rounded-full"></span>
            <span class="w-4 h-1 bg-white/40 rounded-full"></span>
            <span class="w-4 h-1 bg-white/40 rounded-full"></span>
        </div>
    </div>
</div>
@endsection
