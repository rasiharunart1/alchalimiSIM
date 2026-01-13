@extends('layouts.app')

@section('content')
    <div class="mb-6 animate-fade-in-up">
        <h2 class="text-2xl font-bold text-chalimi-900">Progres Hafalan Santri</h2>
        <p class="text-chalimi-600">Pantau perkembangan hafalan putra-putri Anda.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-fade-in-up" style="animation-delay: 0.1s">
        @foreach($santris as $santri)
        <div class="glass-panel p-6 relative overflow-hidden">
            <!-- Decorative Background -->
            <div class="absolute -right-12 -top-12 w-48 h-48 bg-chalimi-100 rounded-full blur-3xl opacity-50"></div>

            <div class="flex items-center gap-4 mb-6 relative z-10">
                <div class="w-16 h-16 rounded-full bg-chalimi-200 border-2 border-white flex items-center justify-center text-2xl overflow-hidden">
                    @if($santri->foto)
                        <img src="{{ asset('storage/'.$santri->foto) }}" class="w-full h-full object-cover">
                    @else
                        👤
                    @endif
                </div>
                <div>
                    <h3 class="font-bold text-xl text-chalimi-900">{{ $santri->nama_lengkap }}</h3>
                    <p class="text-sm text-chalimi-600">{{ $santri->nis }}</p>
                </div>
            </div>

            <!-- Total Progress Bar -->
            <div class="mb-8 relative z-10">
                <div class="flex justify-between text-sm mb-2 font-medium">
                    <span class="text-chalimi-700">Total Capaian</span>
                    <span class="text-chalimi-900 font-bold">
                        {{ $santri->progress_hafalan['label'] }} / 30 Juz
                        <span class="text-xs font-normal text-gray-500 block text-right font-normal">
                            ({{ $santri->progress_hafalan['total_pages'] }} / 604 Hal)
                        </span>
                    </span>
                </div>
                <div class="w-full bg-white/50 h-4 rounded-full overflow-hidden border border-white/40">
                    <div class="bg-gradient-to-r from-chalimi-400 to-chalimi-600 h-full rounded-full transition-all duration-1000" style="width: {{ $santri->progress_hafalan['percent'] }}%"></div>
                </div>
            </div>

            <!-- Recent Activity Timeline -->
            <div class="space-y-4 relative z-10">
                <h4 class="font-bold text-chalimi-800 text-sm uppercase tracking-wide border-b border-white/30 pb-2">Aktivitas Terakhir</h4>
                
                @forelse($santri->hafalan->take(5) as $hafalan)
                    <div class="flex gap-4 items-start group">
                        <!-- Date Badge -->
                        <div class="flex-shrink-0 w-12 text-center">
                            <span class="block text-xs font-bold text-chalimi-500">{{ $hafalan->tanggal->format('M') }}</span>
                            <span class="block text-lg font-bold text-chalimi-800 leading-none">{{ $hafalan->tanggal->format('d') }}</span>
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1 bg-white/40 rounded-lg p-3 border border-white/40 hover:bg-white/60 transition-colors">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h5 class="font-bold text-chalimi-900 text-sm">Juz {{ $hafalan->juz }} • {{ $hafalan->surah }}</h5>
                                    <p class="text-xs text-chalimi-600">Ayat {{ $hafalan->ayat_mulai }} - {{ $hafalan->ayat_selesai }}</p>
                                </div>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase 
                                    {{ $hafalan->status == 'lulus' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $hafalan->status }}
                                </span>
                            </div>
                            @if($hafalan->catatan)
                                <p class="text-xs text-gray-500 mt-2 italic border-t border-gray-100 pt-1">"{{ $hafalan->catatan }}"</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-400 text-sm py-4">Belum ada data hafalan tercatat.</p>
                @endforelse
            </div>
            
            <div class="mt-6 text-center">
                <a href="#" class="text-xs font-medium text-chalimi-600 hover:text-chalimi-800 hover:underline">Lihat Riwayat Lengkap →</a>
            </div>
        </div>
        @endforeach
    </div>
@endsection
