@extends('layouts.app')

@section('content')
    <div class="mb-6 animate-fade-in-up">
        <h2 class="text-2xl font-bold text-chalimi-900">Dashboard Ustadz</h2>
        <p class="text-chalimi-600">Selamat datang, {{ auth()->user()->name }}.</p>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 animate-fade-in-up" style="animation-delay: 0.1s">
        <!-- Today's Input -->
        <div class="glass-panel p-6 flex items-center justify-between relative overflow-hidden group">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <i class="fa-solid fa-calendar-day text-6xl text-chalimi-600"></i>
            </div>
            <div>
                <p class="text-sm text-chalimi-600 font-medium">Setoran Hari Ini</p>
                <h3 class="text-3xl font-bold text-chalimi-900 mt-1">{{ $countToday }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-chalimi-100 flex items-center justify-center text-chalimi-600">
                <i class="fa-solid fa-check"></i>
            </div>
        </div>

        <!-- Month's Input -->
        <div class="glass-panel p-6 flex items-center justify-between relative overflow-hidden group">
             <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <i class="fa-solid fa-calendar-days text-6xl text-emerald-600"></i>
            </div>
            <div>
                <p class="text-sm text-chalimi-600 font-medium">Total Bulan Ini</p>
                <h3 class="text-3xl font-bold text-chalimi-900 mt-1">{{ $countMonth }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                <i class="fa-solid fa-chart-line"></i>
            </div>
        </div>

        <!-- Quick Action -->
        <div class="glass-panel p-6 bg-gradient-to-br from-chalimi-600 to-chalimi-800 text-white flex flex-col justify-center items-center text-center relative overflow-hidden group cursor-pointer hover:scale-[1.02] transition-transform" onclick="window.location='{{ route('ustadz.hafalan.create') }}'">
            <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <i class="fa-solid fa-circle-plus text-4xl mb-3 text-chalimi-200 group-hover:text-white transition-colors"></i>
            <h3 class="font-bold text-lg">Input Setoran Baru</h3>
            <p class="text-xs text-chalimi-200 mt-1">Klik di sini untuk input hafalan</p>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="glass-panel p-6 animate-fade-in-up" style="animation-delay: 0.2s">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-chalimi-900 text-lg">Aktivitas Terakhir</h3>
            <a href="{{ route('ustadz.hafalan.index') }}" class="text-sm text-chalimi-600 hover:text-chalimi-800">Lihat Semua →</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-xs text-chalimi-500 border-b border-chalimi-100">
                        <th class="pb-2">Waktu</th>
                        <th class="pb-2">Santri</th>
                        <th class="pb-2">Hafalan</th>
                        <th class="pb-2">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-chalimi-50">
                    @forelse($recentHafalan as $hafalan)
                        <tr class="text-sm group hover:bg-white/40 transition-colors">
                            <td class="py-3 text-chalimi-600">{{ $hafalan->created_at->diffForHumans() }}</td>
                            <td class="py-3 font-medium text-chalimi-900">{{ $hafalan->santri->nama_lengkap }}</td>
                            <td class="py-3">
                                <span class="bg-chalimi-50 text-chalimi-700 px-2 py-0.5 rounded text-xs">
                                    Juz {{ $hafalan->juz }}
                                </span>
                                <span class="text-xs ml-1">{{ $hafalan->surah }} : {{ $hafalan->ayat_mulai }}-{{ $hafalan->ayat_selesai }}</span>
                            </td>
                            <td class="py-3">
                                <span class="text-xs font-bold uppercase {{ $hafalan->status == 'lulus' ? 'text-green-600' : 'text-yellow-600' }}">
                                    {{ $hafalan->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-sm text-chalimi-400">
                                Belum ada aktivitas input hafalan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
