@extends('layouts.app')

@section('content')
    <div class="mb-6 flex justify-between items-center animate-fade-in-up">
        <div>
            <h2 class="text-2xl font-bold text-chalimi-900">Data Hafalan</h2>
            <p class="text-chalimi-600 text-sm">Monitoring setoran dan muraja'ah santri.</p>
        </div>
        <a href="{{ route($routePrefix.'.create') }}" class="btn-chalimi shadow-lg shadow-emerald-500/30">
            + Input Hafalan
        </a>
    </div>

    <!-- Filter -->
    <div class="glass-panel p-4 mb-6 animate-fade-in-up" style="animation-delay: 0.1s">
        <form action="{{ route($routePrefix.'.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama santri..." 
                    class="w-full glass-input placeholder-chalimi-400">
            </div>
            <div class="w-full md:w-32">
                <input type="number" name="juz" value="{{ request('juz') }}" placeholder="Juz..." class="w-full glass-input">
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
                        <th class="p-4 font-semibold">Hafalan</th>
                        <th class="p-4 font-semibold">Status & Nilai</th>
                        <th class="p-4 font-semibold">Penguji</th>
                        <th class="p-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-chalimi-100">
                    @forelse($hafalans as $hafalan)
                        <tr class="hover:bg-white/30 transition-colors">
                            <td class="p-4 text-sm text-chalimi-700 font-mono">
                                {{ $hafalan->tanggal->format('d/m/Y') }}
                            </td>
                            <td class="p-4">
                                <span class="font-bold text-chalimi-900 block">{{ $hafalan->santri->nama_lengkap }}</span>
                                <span class="text-xs text-chalimi-500">{{ $hafalan->santri->nis }}</span>
                            </td>
                            <td class="p-4">
                                <div class="font-semibold text-chalimi-800">Juz {{ $hafalan->juz }} - {{ $hafalan->surah }}</div>
                                <div class="text-xs text-chalimi-600">Ayat {{ $hafalan->ayat_mulai }} - {{ $hafalan->ayat_selesai }}</div>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded text-xs font-bold uppercase 
                                    {{ $hafalan->status == 'lulus' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ ucfirst($hafalan->status) }}
                                </span>
                                @if($hafalan->nilai)
                                    <span class="ml-2 font-mono font-bold text-chalimi-800">{{ $hafalan->nilai }}</span>
                                @endif
                            </td>
                            <td class="p-4 text-xs text-chalimi-500">
                                {{ $hafalan->ustadz->name }}
                            </td>
                            <td class="p-4 text-right flex justify-end gap-2">
                                <a href="{{ route($routePrefix.'.edit', $hafalan) }}" class="p-1 px-2 rounded bg-yellow-50 text-yellow-600 hover:bg-yellow-100 text-xs">✏️</a>
                                @if(auth()->user()->role === 'admin')
                                    <form action="{{ route('admin.hafalan.destroy', $hafalan) }}" method="POST" onsubmit="return confirm('Hapus data hafalan ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1 px-2 rounded bg-red-50 text-red-600 hover:bg-red-100 text-xs">🗑️</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-chalimi-500">
                                Belum ada data hafalan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-chalimi-100">
            {{ $hafalans->withQueryString()->links() }}
        </div>
    </div>
@endsection
