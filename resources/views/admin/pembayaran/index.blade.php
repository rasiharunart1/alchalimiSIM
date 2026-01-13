@extends('layouts.app')

@section('content')
    <div class="mb-6 flex justify-between items-center animate-fade-in-up">
        <div>
            <h2 class="text-2xl font-bold text-chalimi-900">Data Pembayaran</h2>
            <p class="text-chalimi-600 text-sm">Kelola riwayat pembayaran SPP, DPP, dan lainnya.</p>
        </div>
        <a href="{{ route('admin.pembayaran.create') }}" class="btn-chalimi shadow-lg shadow-emerald-500/30">
            + Catat Pembayaran
        </a>
    </div>

    <!-- Filter -->
    <div class="glass-panel p-4 mb-6 animate-fade-in-up" style="animation-delay: 0.1s">
        <form action="{{ route('admin.pembayaran.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari santri..." 
                    class="w-full glass-input placeholder-chalimi-400">
            </div>
            <div class="w-full md:w-48">
                <select name="jenis" class="w-full glass-input text-chalimi-800" onchange="this.form.submit()">
                    <option value="">Semua Jenis</option>
                    <option value="spp" {{ request('jenis') == 'spp' ? 'selected' : '' }}>SPP</option>
                    <option value="dpp" {{ request('jenis') == 'dpp' ? 'selected' : '' }}>DPP</option>
                    <option value="seragam" {{ request('jenis') == 'seragam' ? 'selected' : '' }}>Seragam</option>
                    <option value="lainnya" {{ request('jenis') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>
            <button type="submit" class="btn-glass bg-chalimi-600 text-white hover:bg-chalimi-700">
                🔍 Filter
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="glass-panel overflow-hidden animate-fade-in-up" style="animation-delay: 0.2s">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-chalimi-900/5 text-chalimi-900 border-b border-chalimi-200">
                        <th class="p-4 font-semibold">Tanggal</th>
                        <th class="p-4 font-semibold">Santri</th>
                        <th class="p-4 font-semibold">Jenis & Keterangan</th>
                        <th class="p-4 font-semibold">Jumlah</th>
                        <th class="p-4 font-semibold">Metode</th>
                        <th class="p-4 font-semibold">Admin</th>
                        <th class="p-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-chalimi-100">
                    @forelse($pembayarans as $bayar)
                        <tr class="hover:bg-white/30 transition-colors">
                            <td class="p-4 text-chalimi-700 font-mono text-sm">
                                {{ $bayar->tanggal_bayar->format('d/m/Y') }}
                            </td>
                            <td class="p-4">
                                <span class="font-bold text-chalimi-900 block">{{ $bayar->santri->nama_lengkap }}</span>
                                <span class="text-xs text-chalimi-500">{{ $bayar->santri->nis }}</span>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded text-xs font-bold uppercase bg-chalimi-100 text-chalimi-700 border border-chalimi-200">
                                    {{ $bayar->jenis }}
                                </span>
                                <span class="block text-xs text-chalimi-600 mt-1">{{ $bayar->keterangan ?? '-' }}</span>
                            </td>
                            <td class="p-4 font-bold text-chalimi-800">
                                Rp {{ number_format($bayar->jumlah, 0, ',', '.') }}
                            </td>
                            <td class="p-4 text-sm">
                                {{ ucfirst($bayar->metode) }}
                            </td>
                            <td class="p-4 text-xs text-chalimi-500">
                                {{ $bayar->recordedBy->name ?? 'Auto / Wali' }}
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('admin.pembayaran.show', $bayar) }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                                    🖨️ Invoice
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-chalimi-500">
                                Belum ada data pembayaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-chalimi-100">
            {{ $pembayarans->withQueryString()->links() }}
        </div>
    </div>
@endsection
