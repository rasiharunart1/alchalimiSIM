@extends('layouts.app')

@section('content')
    <div class="mb-8 animate-fade-in-up">
        <h2 class="text-3xl font-bold text-chalimi-900">Dashboard Admin</h2>
        <p class="text-chalimi-700 mt-1">Ringkasan aktivitas pondok pesantren</p>
    </div>

    <!-- Summary Cards Row 1 -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Card Santri -->
        <div class="glass-panel p-6 flex items-start justify-between relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-chalimi-200 rounded-full opacity-20 group-hover:scale-110 transition-transform"></div>
            <div>
                <p class="text-sm font-medium text-chalimi-600 mb-1">Total Santri Aktif</p>
                <h3 class="text-3xl font-bold text-chalimi-900">{{ $totalSantri ?? 0 }}</h3>
                <div class="mt-4 flex items-center text-xs font-semibold text-green-600 bg-green-100 px-2 py-1 rounded-full w-fit">
                    <span>Santri Aktif</span>
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
                    <span>Terverifikasi</span>
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
                <h3 class="text-3xl font-bold text-chalimi-900">{{ $totalKhatam ?? 0 }}</h3>
                <div class="mt-4 flex items-center text-xs font-semibold text-purple-600 bg-purple-100 px-2 py-1 rounded-full w-fit">
                    <span>Total Alumni</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center text-2xl">
                📖
            </div>
        </div>
    </div>

    <!-- Summary Cards Row 2 (New Widgets) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Widget Unit Usaha -->
        <div class="glass-panel p-6 flex items-start justify-between relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-orange-200 rounded-full opacity-20 group-hover:scale-110 transition-transform"></div>
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-orange-100 flex items-center justify-center text-3xl shadow-inner">
                    🏪
                </div>
                <div>
                    <p class="text-sm font-medium text-chalimi-600">Total Unit Usaha</p>
                    <h3 class="text-3xl font-bold text-chalimi-900">{{ $totalUnitUsaha ?? 0 }}</h3>
                    <p class="text-xs text-orange-600 font-bold mt-1 tracking-tight uppercase">Produk & Jasa Aktif</p>
                </div>
            </div>
            <a href="{{ route('unit_usaha.index') }}" class="btn-glass px-4 py-2 text-xs font-bold hover:bg-orange-50 self-center">Kelola</a>
        </div>

        <!-- Widget Progress Hafalan -->
        <div class="glass-panel p-6 flex items-start justify-between relative overflow-hidden group border-l-4 border-emerald-500">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-200 rounded-full opacity-20 group-hover:scale-110 transition-transform"></div>
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center text-3xl shadow-inner">
                    📈
                </div>
                <div>
                    <p class="text-sm font-medium text-chalimi-600">Progress Hafalan</p>
                    <h3 class="text-3xl font-bold text-chalimi-900">{{ $totalHafalanBulanIni ?? 0 }}</h3>
                    <p class="text-xs text-emerald-600 font-bold mt-1 tracking-tight uppercase">Setoran Bulan Ini</p>
                </div>
            </div>
            <a href="{{ route('admin.hafalan.index') }}" class="btn-glass px-4 py-2 text-xs font-bold hover:bg-emerald-50 self-center">Detail</a>
        </div>
    </div>

    <!-- Main Grid Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Santri Ranking Table -->
        <div class="lg:col-span-2 glass-panel p-6">
            <div class="flex items-center justify-between mb-6 pb-2 border-b border-gray-100">
                <h3 class="text-lg font-bold text-chalimi-800 flex items-center gap-2">
                    <span class="text-xl">🏆</span> Peringkat Santri Teraktif
                </h3>
                <span class="text-xs font-bold px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full uppercase">Top 5</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-xs font-bold text-chalimi-500 uppercase tracking-widest border-b border-gray-50">
                            <th class="pb-3 pl-2">Rank</th>
                            <th class="pb-3">Nama Santri</th>
                            <th class="pb-3 text-center">Total Lulus</th>
                            <th class="pb-3 text-right">Progress</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($santriRanking as $index => $santri)
                        <tr class="hover:bg-white/40 transition group">
                            <td class="py-4 pl-2">
                                <div class="w-7 h-7 rounded-full flex items-center justify-center font-bold text-sm {{ $index == 0 ? 'bg-yellow-400 text-white' : ($index == 1 ? 'bg-gray-300 text-white' : ($index == 2 ? 'bg-orange-300 text-white' : 'bg-chalimi-100 text-chalimi-600')) }}">
                                    {{ $index + 1 }}
                                </div>
                            </td>
                            <td class="py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $santri->foto ? asset('storage/'.$santri->foto) : 'https://ui-avatars.com/api/?name='.urlencode($santri->nama_lengkap).'&background=009b77&color=fff' }}" class="w-8 h-8 rounded-full border border-white shadow-sm">
                                    <div>
                                        <p class="text-sm font-bold text-chalimi-900 group-hover:text-chalimi-600 transition">{{ $santri->nama_lengkap }}</p>
                                        <p class="text-[10px] text-gray-500 uppercase font-medium">{{ $santri->nis }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 text-center">
                                <span class="px-2 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-xs font-bold">
                                    {{ $santri->hafalan_count }} Setoran
                                </span>
                            </td>
                            <td class="py-4 text-right">
                                <div class="w-full bg-gray-100 rounded-full h-1.5 max-w-[80px] ml-auto">
                                    <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ min(100, ($santri->hafalan_count / max(1, $santriRanking->max('hafalan_count'))) * 100) }}%"></div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-10 text-center text-gray-400 italic text-sm">Belum ada data setoran.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sidebar Actions & System Info -->
        <div class="space-y-6">
            <div class="glass-panel p-6">
                <h3 class="text-lg font-bold text-chalimi-800 mb-4 border-b border-gray-100 pb-2">Aksi Cepat</h3>
                <div class="grid grid-cols-1 gap-3">
                    <a href="{{ route('admin.santri.create') }}" class="btn-glass flex items-center p-4 gap-4 text-chalimi-800 hover:bg-chalimi-50 group">
                        <span class="text-2xl group-hover:scale-110 transition-transform">👤+</span>
                        <div class="text-left">
                            <p class="text-sm font-bold">Tambah Santri</p>
                            <p class="text-[10px] text-gray-500 uppercase font-medium">Registrasi Data Baru</p>
                        </div>
                    </a>
                    <a href="{{ route('admin.pembayaran.create') }}" class="btn-glass flex items-center p-4 gap-4 text-chalimi-800 hover:bg-chalimi-50 group">
                        <span class="text-2xl group-hover:scale-110 transition-transform">💳+</span>
                        <div class="text-left">
                            <p class="text-sm font-bold">Input Pembayaran</p>
                            <p class="text-[10px] text-gray-500 uppercase font-medium">Rekam Iuran Bulanan</p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="glass-panel p-6">
                <h3 class="text-lg font-bold text-chalimi-800 mb-4 border-b border-gray-100 pb-2">Informasi Sistem</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center text-xs p-3 rounded-lg bg-white/40 border border-white/20">
                        <span class="text-gray-600">Versi Portal</span>
                        <span class="font-mono font-bold text-chalimi-700 bg-white/60 px-2 py-0.5 rounded">v1.1.0-RC</span>
                    </div>
                    <div class="flex justify-between items-center text-xs p-3 rounded-lg bg-white/40 border border-white/20">
                        <span class="text-gray-600">Sinkronisasi DB</span>
                        <span class="text-green-600 font-bold flex items-center gap-2">
                           <span class="relative flex h-2 w-2">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                           </span>
                           Aktif
                        </span>
                    </div>
                    <div class="p-3 bg-chalimi-900 rounded-xl text-white mt-4 shadow-xl shadow-chalimi-900/20">
                        <p class="text-[10px] opacity-70 uppercase font-bold tracking-widest">Pencatatan Hari Ini</p>
                        <p class="text-xs mt-1 font-medium">Laporan harian otomatis akan diperbarui pada pukul 23:59 WIB.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
