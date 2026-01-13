@extends('layouts.app')

@section('content')
    <div class="animate-fade-in-up">
        
        <!-- Welcome Header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-chalimi-900">Assalamu'alaikum, {{ auth()->user()->name }}</h1>
            <p class="text-chalimi-700 mt-1">Berikut adalah perkembangan putra-putri Anda di Pondok Pesantren.</p>
        </div>

        <!-- Santri List -->
        @forelse($santriList as $santri)
            <div class="glass-panel p-6 mb-8 relative overflow-hidden card-interactive">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-chalimi-100 rounded-full blur-2xl opacity-50"></div>
                
                <div class="flex flex-col md:flex-row gap-6 relative z-10">
                    <!-- Foto Santri -->
                    <div class="flex-shrink-0">
                        <div class="w-24 h-24 md:w-32 md:h-32 rounded-2xl bg-gray-200 border-4 border-white shadow-lg overflow-hidden relative">
                            @if($santri->foto)
                                <img src="{{ asset('storage/'.$santri->foto) }}" alt="{{ $santri->nama_lengkap }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-chalimi-50 text-chalimi-300 text-4xl">
                                    👤
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Info Utama -->
                    <div class="flex-1">
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                            <div>
                                <h2 class="text-2xl font-bold text-chalimi-900">{{ $santri->nama_lengkap }}</h2>
                                <p class="text-chalimi-600 font-medium">NIS: {{ $santri->nis }} • Kelas: {{ $santri->kelas ?? 'Tahfidz 1' }}</p>
                                
                                <div class="mt-4 flex flex-wrap gap-2">
                                    <span class="status-badge bg-green-100 text-green-700 border-green-200">
                                        ✅ Status: {{ ucfirst($santri->status) }}
                                    </span>
                                    <span class="status-badge bg-blue-100 text-blue-700 border-blue-200">
                                        🎂 {{ $santri->umur }} Tahun
                                    </span>
                                </div>
                            </div>
                            
                            <div class="flex gap-2">
                                <a href="#" class="btn-glass text-sm">Lihat Profil</a>
                            </div>
                        </div>

                        <!-- Highlights Section -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                            <!-- Hafalan Highlight -->
                            <div class="bg-white/40 rounded-xl p-4 border border-white/40">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="text-xl">📖</span>
                                    <h4 class="font-bold text-chalimi-800">Capaian Hafalan</h4>
                                </div>
                                <div class="flex items-end gap-2">
                                    <span class="text-3xl font-bold text-chalimi-600">{{ $santri->progress_hafalan['label'] }}</span>
                                    <span class="text-sm text-chalimi-600 mb-1">Juz Selesai</span>
                                </div>
                                <div class="w-full bg-white/50 h-2 rounded-full mt-2">
                                    <div class="bg-chalimi-500 h-2 rounded-full" style="width: {{ $santri->progress_hafalan['percent'] }}%"></div>
                                </div>
                                <p class="text-[10px] text-chalimi-600 mt-1 text-right">
                                    {{ $santri->progress_hafalan['total_pages'] }} / 604 Halaman
                                </p>
                            </div>

                            <!-- Tagihan Highlight -->
                            <div class="bg-white/40 rounded-xl p-4 border border-white/40">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="text-xl">💳</span>
                                    <h4 class="font-bold text-chalimi-800">Status Keuangan</h4>
                                </div>
                                @if($santri->total_tunggakan > 0)
                                    <p class="text-red-600 font-bold text-lg">Rp {{ number_format($santri->total_tunggakan, 0, ',', '.') }}</p>
                                    <p class="text-xs text-red-500">Total Tunggakan</p>
                                    <a href="{{ route('wali.pembayaran') }}" class="mt-2 text-center block w-full py-1.5 px-3 bg-red-100 text-red-700 rounded-lg text-xs font-bold hover:bg-red-200 transition">
                                        Bayar Sekarang
                                    </a>
                                @else
                                    <p class="text-green-600 font-bold text-lg">Lunas</p>
                                    <p class="text-xs text-green-500">Tidak ada tunggakan</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="glass-panel p-12 text-center">
                <span class="text-4xl block mb-4">📭</span>
                <h3 class="text-xl font-bold text-gray-700">Belum Ada Data Santri</h3>
                <p class="text-gray-500 mt-2">Data putra-putri Anda belum terdaftar di sistem.</p>
                <p class="text-sm text-gray-400 mt-1">Silakan hubungi admin pondok.</p>
            </div>
        @endforelse

    </div>
@endsection
