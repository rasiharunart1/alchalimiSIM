@extends('layouts.app')

@section('content')
    <div class="mb-6 animate-fade-in-up">
        <a href="{{ route('admin.santri.index') }}" class="text-chalimi-600 hover:text-chalimi-800 mb-2 inline-block">← Kembali ke Data Santri</a>
        <h2 class="text-2xl font-bold text-chalimi-900">Tambah Santri Baru</h2>
    </div>

    <div class="glass-panel p-8 max-w-4xl mx-auto animate-fade-in-up" style="animation-delay: 0.1s">
        <form action="{{ route('admin.santri.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <!-- Section: Data Identitas -->
            <div>
                <h3 class="text-lg font-bold text-chalimi-800 mb-4 border-b border-gray-200 pb-2">Identitas Santri</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-chalimi-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="w-full glass-input">
                        @error('nama_lengkap') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-chalimi-700 mb-1">Nama Panggilan</label>
                        <input type="text" name="nama_panggilan" value="{{ old('nama_panggilan') }}" class="w-full glass-input">
                        @error('nama_panggilan') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-chalimi-700 mb-1">Nomor Induk Santri (NIS)</label>
                        <input type="text" name="nis" value="{{ old('nis') }}" required class="w-full glass-input">
                        @error('nis') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-chalimi-700 mb-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin" required class="w-full glass-input">
                            <option value="">Pilih...</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-chalimi-700 mb-1">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required class="w-full glass-input">
                        @error('tempat_lahir') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-chalimi-700 mb-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required class="w-full glass-input">
                        @error('tanggal_lahir') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-chalimi-700 mb-1">Alamat Lengkap</label>
                        <textarea name="alamat" rows="2" required class="w-full glass-input">{{ old('alamat') }}</textarea>
                        @error('alamat') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Section: Data Akademik & Wali -->
            <div class="pt-4">
                <h3 class="text-lg font-bold text-chalimi-800 mb-4 border-b border-gray-200 pb-2">Akademik & Wali</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-chalimi-700 mb-1">Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk') }}" required class="w-full glass-input">
                        @error('tanggal_masuk') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-chalimi-700 mb-1">Sekolah Asal</label>
                        <input type="text" name="sekolah_asal" value="{{ old('sekolah_asal') }}" class="w-full glass-input">
                        @error('sekolah_asal') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-chalimi-700 mb-1">Wali Santri (User Account)</label>
                        <select name="wali_id" required class="w-full glass-input">
                            <option value="">Pilih Akun Wali...</option>
                            @foreach($walis as $wali)
                                <option value="{{ $wali->id }}" {{ old('wali_id') == $wali->id ? 'selected' : '' }}>
                                    {{ $wali->name }} ({{ $wali->phone }})
                                </option>
                            @endforeach
                        </select>
                        @error('wali_id') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        <p class="text-xs text-chalimi-500 mt-1">Pastikan akun wali sudah dibuat terlebih dahulu di menu manajemen user.</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-chalimi-700 mb-1">Foto Santri (Opsional)</label>
                        <input type="file" name="foto" accept="image/*" class="w-full glass-input file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-chalimi-50 file:text-chalimi-700 hover:file:bg-chalimi-100">
                        @error('foto') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="pt-6 flex justify-end gap-3">
                <a href="{{ route('admin.santri.index') }}" class="btn-glass bg-white/50 text-chalimi-700">Batal</a>
                <button type="submit" class="btn-chalimi shadow-lg shadow-emerald-500/30">
                    Simpan Data Santri
                </button>
            </div>
        </form>
    </div>
@endsection
