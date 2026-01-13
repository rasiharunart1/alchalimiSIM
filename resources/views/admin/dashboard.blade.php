@extends('layouts.app')

@section('content')
    <div class="mb-8 animate-fade-in-up">
        <h2 class="text-3xl font-bold text-chalimi-900">Dashboard Admin</h2>
        <p class="text-chalimi-700 mt-1">Ringkasan aktivitas pondok pesantren</p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Card Santri -->
        <div class="glass-panel p-6 flex items-start justify-between relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-chalimi-200 rounded-full opacity-20 group-hover:scale-110 transition-transform"></div>
            <div>
                <p class="text-sm font-medium text-chalimi-600 mb-1">Total Santri Aktif</p>
                <h3 class="text-3xl font-bold text-chalimi-900">{{ $totalSantri ?? 0 }}</h3>
                <div class="mt-4 flex items-center text-xs font-semibold text-green-600 bg-green-100 px-2 py-1 rounded-full w-fit">
                    <span>+5% bulan ini</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-chalimi-100 flex items-center justify-center text-2xl">
                👥
            </div>
        </div>

        <!-- Card Pembayaran -->
        <div class="glass-panel p-6 flex items-start justify-between relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-200 rounded-full opacity-20 group-hover:scale-110 transition-transform"></div>
            <div>
                <p class="text-sm font-medium text-chalimi-600 mb-1">Pemasukan Bulan Ini</p>
                <h3 class="text-3xl font-bold text-chalimi-900">Rp {{ number_format($totalPembayaran ?? 0, 0, ',', '.') }}</h3>
                <div class="mt-4 flex items-center text-xs font-semibold text-blue-600 bg-blue-100 px-2 py-1 rounded-full w-fit">
                    <span>Updated just now</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-2xl">
                💰
            </div>
        </div>

        <!-- Card Hafalan -->
        <div class="glass-panel p-6 flex items-start justify-between relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-purple-200 rounded-full opacity-20 group-hover:scale-110 transition-transform"></div>
            <div>
                <p class="text-sm font-medium text-chalimi-600 mb-1">Santri Khatam</p>
                <h3 class="text-3xl font-bold text-chalimi-900">12</h3>
                <div class="mt-4 flex items-center text-xs font-semibold text-purple-600 bg-purple-100 px-2 py-1 rounded-full w-fit">
                    <span>Tahun Ajaran 2025/2026</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center text-2xl">
                📖
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="glass-panel p-6">
            <h3 class="text-lg font-bold text-chalimi-800 mb-4 border-b border-gray-100 pb-2">Aksi Cepat</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('admin.santri.create') }}" class="btn-glass flex flex-col items-center justify-center p-4 gap-2 text-chalimi-800 hover:bg-chalimi-50">
                    <span class="text-2xl">👤+</span>
                    <span class="text-sm">Tambah Santri</span>
                </a>
                <a href="{{ route('admin.pembayaran.create') }}" class="btn-glass flex flex-col items-center justify-center p-4 gap-2 text-chalimi-800 hover:bg-chalimi-50">
                    <span class="text-2xl">💳+</span>
                    <span class="text-sm">Input Pembayaran</span>
                </a>
            </div>
        </div>

        <div class="glass-panel p-6">
            <h3 class="text-lg font-bold text-chalimi-800 mb-4 border-b border-gray-100 pb-2">Sistem Info</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center text-sm p-3 rounded-lg bg-white/40">
                    <span class="text-gray-600">Versi Sistem</span>
                    <span class="font-mono font-bold text-chalimi-700">v1.0.0</span>
                </div>
                <div class="flex justify-between items-center text-sm p-3 rounded-lg bg-white/40">
                    <span class="text-gray-600">Database Status</span>
                    <span class="text-green-600 font-bold flex items-center gap-1">● Connected</span>
                </div>
            </div>
        </div>
    </div>
@endsection
