@extends('layouts.app')

@section('content')
    <div class="mb-6 animate-fade-in-up">
        <a href="{{ route('users.index') }}" class="text-chalimi-600 hover:text-chalimi-800 mb-2 inline-block">← Kembali ke Manajemen User</a>
        <h2 class="text-2xl font-bold text-chalimi-900">Edit Pengguna: {{ $user->name }}</h2>
    </div>

    <div class="glass-panel p-8 max-w-3xl mx-auto animate-fade-in-up" style="animation-delay: 0.1s">
        <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="flex items-center gap-4 mb-6">
                <!-- Avatar Preview (Read Only here, edit in profile) -->
                <div class="w-16 h-16 rounded-full overflow-hidden bg-gray-200">
                     <img src="{{ $user->photo ? asset('storage/'.$user->photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=009b77&color=fff' }}" class="w-full h-full object-cover">
                </div>
                <div>
                     <p class="text-sm text-chalimi-500">Edit informasi akun pengguna.</p>
                     <p class="text-xs text-gray-400">Foto profil hanya bisa diubah oleh pengguna sendiri.</p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-chalimi-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full glass-input">
                @error('name') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-chalimi-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full glass-input">
                    @error('email') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-chalimi-700 mb-1">Nomor Telepon (Opsional)</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full glass-input">
                    @error('phone') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-chalimi-700 mb-1">Role / Peran</label>
                @if($user->id === auth()->id())
                     <input type="text" value="{{ ucfirst($user->role) }}" disabled class="w-full glass-input bg-gray-100 text-gray-500 cursor-not-allowed">
                     <input type="hidden" name="role" value="{{ $user->role }}">
                     <p class="text-xs text-amber-600 mt-1">Anda tidak dapat mengubah role akun sendiri.</p>
                @else
                    <select name="role" class="w-full glass-input text-chalimi-800" required>
                        <option value="ustadz" {{ old('role', $user->role) == 'ustadz' ? 'selected' : '' }}>Ustadz (Guru Hafalan)</option>
                        <option value="pengurus" {{ old('role', $user->role) == 'pengurus' ? 'selected' : '' }}>Pengurus (Humas/Keuangan)</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin Pondok</option>
                        <option value="wali_santri" {{ old('role', $user->role) == 'wali_santri' ? 'selected' : '' }}>Wali Santri</option>
                    </select>
                @endif
                @error('role') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="border-t border-chalimi-100 my-4 pt-4">
                <h4 class="font-bold text-chalimi-800 mb-2">Ubah Password (Opsional)</h4>
                <p class="text-xs text-chalimi-500 mb-4">Kosongkan jika tidak ingin mengubah password.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-chalimi-700 mb-1">Password Baru</label>
                        <input type="password" name="password" class="w-full glass-input" placeholder="********">
                        @error('password') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-chalimi-700 mb-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="w-full glass-input" placeholder="********">
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('users.index') }}" class="px-6 py-2 rounded-xl text-chalimi-600 hover:bg-chalimi-50 transition">Batal</a>
                <button type="submit" class="btn-chalimi shadow-lg shadow-emerald-500/30">
                    💾 Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
