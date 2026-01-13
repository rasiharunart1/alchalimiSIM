@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-end">
        <div>
            <h2 class="text-2xl font-bold text-white">Manajemen Tagihan</h2>
            <p class="text-chalimi-200">Kelola tagihan SPP dan pembayaran santri lainnya.</p>
        </div>
        <a href="{{ route('pengurus.tagihan.create') }}" class="px-5 py-2.5 bg-chalimi-600 hover:bg-chalimi-700 text-white rounded-xl shadow-lg shadow-chalimi-600/20 font-bold transition flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Buat Tagihan Baru
        </a>
    </div>

    <!-- Stats and Filters -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="glass-panel p-6 bg-gradient-to-br from-red-900/40 to-transparent border-red-500/20">
            <h4 class="text-chalimi-200 text-sm font-medium mb-1">Total Piutang (Belum Lunas)</h4>
            <p class="text-3xl font-bold text-white">Rp {{ number_format($totalBelumLunas, 0, ',', '.') }}</p>
        </div>
        
        <div class="md:col-span-2 glass-panel p-4 flex items-center gap-4">
            <form action="{{ route('pengurus.tagihan.index') }}" method="GET" class="flex-1 flex gap-4">
                <select name="status" class="glass-input w-40" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="belum_lunas" {{ request('status') == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                    <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                </select>
                <div class="relative flex-1">
                    <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-chalimi-400"></i>
                    <input type="text" name="role_search" value="{{ request('role_search') }}" placeholder="Cari Nama / NIS..." class="glass-input w-full pl-10">
                </div>
            </form>
        </div>
    </div>

    <!-- List -->
    <div class="glass-panel overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/10 bg-black/20 text-left">
                        <th class="px-6 py-4 text-xs font-bold text-chalimi-300 uppercase">Periode</th>
                        <th class="px-6 py-4 text-xs font-bold text-chalimi-300 uppercase">Santri</th>
                        <th class="px-6 py-4 text-xs font-bold text-chalimi-300 uppercase">Jenis</th>
                        <th class="px-6 py-4 text-xs font-bold text-chalimi-300 uppercase">Jumlah</th>
                        <th class="px-6 py-4 text-xs font-bold text-chalimi-300 uppercase">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-chalimi-300 uppercase text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($tagihans as $tagihan)
                    <tr class="hover:bg-white/5 transition">
                        <td class="px-6 py-4 text-sm text-gray-300">
                             {{ \Carbon\Carbon::parse($tagihan->bulan)->translatedFormat('F Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-white font-bold text-sm">{{ $tagihan->santri->nama_lengkap }}</p>
                            <p class="text-xs text-chalimi-400">{{ $tagihan->santri->nis }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs font-bold bg-white/10 text-chalimi-200 uppercase">
                                {{ $tagihan->jenis }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-mono text-white">
                            Rp {{ number_format($tagihan->jumlah, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($tagihan->status == 'lunas')
                                <span class="px-2 py-1 rounded-full text-xs font-bold bg-green-500/20 text-green-300 border border-green-500/30">
                                    <i class="fa-solid fa-check mr-1"></i> Lunas
                                </span>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs font-bold bg-red-500/20 text-red-300 border border-red-500/30">
                                    Belum Lunas
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                             @if($tagihan->status == 'belum_lunas')
                                <form action="{{ route('pengurus.tagihan.destroy', $tagihan) }}" method="POST" onsubmit="return confirm('Hapus tagihan ini?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-red-500/20 text-red-400 hover:bg-red-500 hover:text-white transition flex items-center justify-center">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </form>
                             @else
                                <span class="text-xs text-gray-500 italic">Terkunci</span>
                             @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-chalimi-400">
                            <i class="fa-regular fa-folder-open text-3xl mb-2 block"></i>
                            Belum ada data tagihan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($tagihans->hasPages())
            <div class="px-6 py-4 border-t border-white/10">
                {{ $tagihans->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
