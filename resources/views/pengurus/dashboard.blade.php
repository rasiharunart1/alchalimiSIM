@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-white">Dashboard Keuangan</h1>
                <p class="text-chalimi-200">Ringkasan keuangan pesantren Al-Chalimi.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('pengurus.tagihan.create') }}" class="btn-secondary">
                    <i class="fa-solid fa-plus mr-1"></i> Buat Tagihan
                </a>
                <a href="{{ route('pengurus.pembayaran.create') }}" class="btn-chalimi shadow-lg shadow-chalimi-600/30">
                    <i class="fa-solid fa-cash-register mr-1"></i> Input Pembayaran
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in-up">
            <!-- Pemasukan Hari Ini -->
            <div class="glass-panel p-6 bg-gradient-to-br from-green-900/40 to-transparent border-green-500/20">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-green-300 text-sm font-medium mb-1">Pemasukan Hari Ini</p>
                        <h3 class="text-3xl font-bold text-white">Rp {{ number_format($pemasukanHariIni, 0, ',', '.') }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-green-500/20 flex items-center justify-center text-green-400">
                        <i class="fa-solid fa-calendar-day"></i>
                    </div>
                </div>
                <div class="w-full bg-white/10 h-1 rounded-full overflow-hidden">
                    <div class="bg-green-500 h-full w-[0%] animate-pulse" style="width: 100%"></div>
                </div>
            </div>

            <!-- Pemasukan Bulan Ini -->
            <div class="glass-panel p-6 bg-gradient-to-br from-blue-900/40 to-transparent border-blue-500/20">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-blue-300 text-sm font-medium mb-1">Pemasukan Bulan Ini</p>
                        <h3 class="text-3xl font-bold text-white">Rp {{ number_format($pemasukanBulanIni, 0, ',', '.') }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-xs text-blue-200 mt-2">
                    <span class="px-1.5 py-0.5 rounded bg-blue-500/20">Tunai: Rp {{ number_format($metodeStats['tunai'] ?? 0, 0, ',', '.') }}</span>
                    <span class="px-1.5 py-0.5 rounded bg-blue-500/20">Transfer: Rp {{ number_format($metodeStats['transfer'] ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Total Piutang -->
            <div class="glass-panel p-6 bg-gradient-to-br from-red-900/40 to-transparent border-red-500/20">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-red-300 text-sm font-medium mb-1">Total Piutang (Belum Lunas)</p>
                        <h3 class="text-3xl font-bold text-white">Rp {{ number_format($totalPiutang, 0, ',', '.') }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-red-500/20 flex items-center justify-center text-red-400">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                    </div>
                </div>
                <a href="{{ route('pengurus.tagihan.index') }}" class="text-xs text-red-200 hover:text-white flex items-center gap-1 transition">
                    Lihat detail tagihan <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="glass-panel p-6 animate-fade-in-up" style="animation-delay: 0.1s">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-white">Transaksi Terakhir</h3>
                <a href="{{ route('pengurus.pembayaran.index') }}" class="text-sm text-chalimi-300 hover:text-white transition">Lihat Semua</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs text-chalimi-400 border-b border-white/10">
                            <th class="pb-3 pl-2">Santri</th>
                            <th class="pb-3">Jenis</th>
                            <th class="pb-3">Tanggal</th>
                            <th class="pb-3">Nominal</th>
                            <th class="pb-3 text-center">Status</th>
                            <th class="pb-3 text-right pr-2">Metode</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($recentPembayarans as $pembayaran)
                            <tr class="group hover:bg-white/5 transition border-b border-white/5 last:border-0 relative">
                                <td class="py-3 pl-2">
                                    <p class="font-bold text-white">{{ $pembayaran->santri->nama_lengkap }}</p>
                                    <p class="text-xs text-chalimi-400">{{ $pembayaran->santri->nis }}</p>
                                </td>
                                <td class="py-3 text-chalimi-200 uppercase text-xs font-bold">{{ $pembayaran->jenis }}</td>
                                <td class="py-3 text-gray-300">{{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->translatedFormat('d M Y') }}</td>
                                <td class="py-3 text-white font-mono font-medium">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                                <td class="py-3 px-2">
                                     @if($pembayaran->status == 'pending')
                                         <span class="inline-block px-1.5 py-0.5 rounded-full bg-yellow-500/20 text-yellow-400 text-[9px] font-bold uppercase">Pending</span>
                                     @elseif($pembayaran->status == 'konfirmasi')
                                         <span class="inline-block px-1.5 py-0.5 rounded-full bg-green-500/20 text-green-400 text-[9px] font-bold uppercase">Berhasil</span>
                                     @else
                                         <span class="inline-block px-1.5 py-0.5 rounded-full bg-red-500/20 text-red-400 text-[9px] font-bold uppercase">Ditolak</span>
                                     @endif
                                </td>
                                <td class="py-3 text-right pr-2">
                                    <span class="px-2 py-1 rounded text-[10px] font-bold uppercase {{ $pembayaran->metode == 'tunai' ? 'bg-green-500/20 text-green-300' : 'bg-blue-500/20 text-blue-300' }}">
                                        {{ $pembayaran->metode }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-400 text-sm">Belum ada transaksi pembayaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
