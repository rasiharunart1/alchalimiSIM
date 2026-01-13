@extends('layouts.app')

@section('content')
    <div class="mb-6 animate-fade-in-up">
        <a href="{{ route('users.index') }}" class="text-chalimi-600 hover:text-chalimi-800 mb-2 inline-block">← Kembali ke Manajemen User</a>
        <h2 class="text-2xl font-bold text-chalimi-900">Tambah Pengguna Baru</h2>
    </div>

    <div class="glass-panel p-8 max-w-3xl mx-auto animate-fade-in-up" style="animation-delay: 0.1s">
        <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium text-chalimi-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full glass-input" placeholder="Nama Lengkap">
                @error('name') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-chalimi-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full glass-input" placeholder="email@contoh.com">
                    @error('email') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-chalimi-700 mb-1">Nomor Telepon (Opsional)</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full glass-input" placeholder="08123456789">
                    @error('phone') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-chalimi-700 mb-1">Role / Peran</label>
                <select name="role" class="w-full glass-input text-chalimi-800" required>
                    <option value="">Pilih Role...</option>
                    <option value="ustadz" {{ old('role') == 'ustadz' ? 'selected' : '' }}>Ustadz (Guru Hafalan)</option>
                    <option value="pengurus" {{ old('role') == 'pengurus' ? 'selected' : '' }}>Pengurus (Humas/Keuangan)</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin Pondok</option>
                    <option value="wali_santri" {{ old('role') == 'wali_santri' ? 'selected' : '' }}>Wali Santri</option>
                </select>
                @error('role') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-4 border-b border-chalimi-100 mb-4">
                <div>
                    <label class="block text-sm font-medium text-chalimi-700 mb-1">Password</label>
                    <input type="password" name="password" required class="w-full glass-input" placeholder="Minimal 8 karakter">
                    @error('password') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-chalimi-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required class="w-full glass-input" placeholder="Ulangi password">
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('users.index') }}" class="px-6 py-2 rounded-xl text-chalimi-600 hover:bg-chalimi-50 transition">Batal</a>
                <button type="submit" class="btn-chalimi shadow-lg shadow-emerald-500/30">
                    💾 Simpan Pengguna
                </button>
            </div>
        </form>
    </div>
@endsection
