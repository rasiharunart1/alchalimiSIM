@extends('layouts.app')

@section('content')
    <div class="mb-6 flex justify-between items-center animate-fade-in-up">
        <div>
            <h2 class="text-2xl font-bold text-chalimi-900">Data Santri</h2>
            <p class="text-chalimi-600 text-sm">Kelola data santri, wali, dan status akademik.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.santri.import.form') }}" class="btn-glass text-chalimi-700 bg-white/40">
                📤 Import CSV
            </a>
            <a href="{{ route('admin.santri.create') }}" class="btn-chalimi shadow-lg shadow-emerald-500/30">
                + Tambah Santri
            </a>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="glass-panel p-4 mb-6 animate-fade-in-up" style="animation-delay: 0.1s">
        <form action="{{ route('admin.santri.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIS..." 
                    class="w-full glass-input placeholder-chalimi-400">
            </div>
            <div class="w-full md:w-48">
                <select name="status" class="w-full glass-input text-chalimi-800" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="alumni" {{ request('status') == 'alumni' ? 'selected' : '' }}>Alumni</option>
                    <option value="keluar" {{ request('status') == 'keluar' ? 'selected' : '' }}>Keluar</option>
                </select>
            </div>
            <button type="submit" class="btn-glass bg-chalimi-600 text-white hover:bg-chalimi-700">
                🔍 Cari
            </button>
        </form>
    </div>

    <!-- Data Table -->
    <div class="glass-panel overflow-hidden animate-fade-in-up" style="animation-delay: 0.2s">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-chalimi-900/5 text-chalimi-900 border-b border-chalimi-200">
                        <th class="p-4 font-semibold">Santri</th>
                        <th class="p-4 font-semibold">NIS</th>
                        <th class="p-4 font-semibold">Wali & Kontak</th>
                        <th class="p-4 font-semibold">Status</th>
                        <th class="p-4 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-chalimi-100">
                    @forelse($santris as $santri)
                        <tr class="hover:bg-white/30 transition-colors">
                            <td class="p-4 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-chalimi-200 flex items-center justify-center text-chalimi-700 overflow-hidden">
                                    @if($santri->foto)
                                        <img src="{{ asset('storage/'.$santri->foto) }}" class="w-full h-full object-cover">
                                    @else
                                        👤
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-bold text-chalimi-900">{{ $santri->nama_lengkap }}</h4>
                                    <span class="text-xs text-chalimi-500">{{ $santri->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }} • {{ $santri->umur }} Th</span>
                                </div>
                            </td>
                            <td class="p-4 text-chalimi-700 font-mono">{{ $santri->nis }}</td>
                            <td class="p-4">
                                <p class="text-sm font-semibold text-chalimi-800">{{ $santri->wali->name }}</p>
                                <p class="text-xs text-chalimi-500">{{ $santri->wali->phone }}</p>
                            </td>
                            <td class="p-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold
                                    {{ $santri->status == 'aktif' ? 'bg-green-100 text-green-700' : 
                                       ($santri->status == 'alumni' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700') }}">
                                    {{ ucfirst($santri->status) }}
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.santri.show', $santri) }}" class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100" title="Lihat Detail">👁️</a>
                                    <a href="{{ route('admin.santri.edit', $santri) }}" class="p-2 rounded-lg bg-yellow-50 text-yellow-600 hover:bg-yellow-100" title="Edit">✏️</a>
                                    <form action="{{ route('admin.santri.destroy', $santri) }}" method="POST" onsubmit="return confirm('Hapus data santri ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100" title="Hapus">🗑️</button>
                                    </form>
                                    @if($santri->status == 'aktif')
                                        <form action="{{ route('admin.santri.graduate', $santri) }}" method="POST" onsubmit="return confirm('Nyatakan santri ini LULUS / KHATAM?')">
                                            @csrf @method('PUT')
                                            <button type="submit" class="p-2 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100" title="Luluskan / Khatam">🎓</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-chalimi-500">
                                Tidak ada data santri ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-chalimi-100">
            {{ $santris->withQueryString()->links() }}
        </div>
    </div>
@endsection
