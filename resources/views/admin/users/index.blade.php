@extends('layouts.app')

@section('content')
    <div class="mb-6 flex justify-between items-center animate-fade-in-up">
        <div>
            <h2 class="text-2xl font-bold text-chalimi-900">Manajemen Pengguna</h2>
            <p class="text-chalimi-600 text-sm">Kelola akun Admin, Ustadz, Pengurus, dan Wali Santri.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn-chalimi shadow-lg shadow-emerald-500/30">
            + Tambah Pengguna Baru
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="glass-panel p-4 mb-6 animate-fade-in-up" style="animation-delay: 0.1s">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." 
                    class="w-full glass-input placeholder-chalimi-400">
            </div>
            <div class="w-full md:w-48">
                <select name="role" class="w-full glass-input text-chalimi-800" onchange="this.form.submit()">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="ustadz" {{ request('role') == 'ustadz' ? 'selected' : '' }}>Ustadz</option>
                    <option value="pengurus" {{ request('role') == 'pengurus' ? 'selected' : '' }}>Pengurus</option>
                    <option value="wali_santri" {{ request('role') == 'wali_santri' ? 'selected' : '' }}>Wali Santri</option>
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
                        <th class="p-4 font-semibold">Nama Pengguna</th>
                        <th class="p-4 font-semibold">Email & Kontak</th>
                        <th class="p-4 font-semibold">Role</th>
                        <th class="p-4 font-semibold">Terdaftar</th>
                        <th class="p-4 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-chalimi-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-white/30 transition-colors">
                            <td class="p-4 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-chalimi-200 flex items-center justify-center overflow-hidden">
                                     <img src="{{ $user->photo ? asset('storage/'.$user->photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=009b77&color=fff' }}" class="w-full h-full object-cover">
                                </div>
                                <span class="font-bold text-chalimi-900">{{ $user->name }}</span>
                            </td>
                            <td class="p-4">
                                <p class="text-sm font-semibold text-chalimi-800">{{ $user->email }}</p>
                                <p class="text-xs text-chalimi-500">{{ $user->phone ?? '-' }}</p>
                            </td>
                            <td class="p-4">
                                @php
                                    $roleColor = match($user->role) {
                                        'admin' => 'bg-red-100 text-red-700',
                                        'ustadz' => 'bg-emerald-100 text-emerald-700',
                                        'pengurus' => 'bg-blue-100 text-blue-700',
                                        'wali_santri' => 'bg-orange-100 text-orange-700',
                                        default => 'bg-gray-100 text-gray-700'
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $roleColor }}">
                                    {{ str_replace('_', ' ', $user->role) }}
                                </span>
                            </td>
                            <td class="p-4 text-xs text-chalimi-600">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td class="p-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="p-2 rounded-lg bg-yellow-50 text-yellow-600 hover:bg-yellow-100" title="Edit">✏️</a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus user ini? Tindakan ini tidak dapat dibatalkan.')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100" title="Hapus">🗑️</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-chalimi-500">
                                Tidak ada data pengguna ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-chalimi-100">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
@endsection
