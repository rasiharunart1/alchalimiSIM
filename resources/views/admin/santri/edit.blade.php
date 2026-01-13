@extends('layouts.app')

@section('content')
    <div class="mb-6 animate-fade-in-up">
        <a href="{{ route('admin.santri.index') }}" class="text-chalimi-600 hover:text-chalimi-800 mb-2 inline-block">← Kembali ke Data Santri</a>
        <h2 class="text-2xl font-bold text-chalimi-900">Edit Data Santri</h2>
    </div>

    <div class="glass-panel p-8 max-w-4xl mx-auto animate-fade-in-up" style="animation-delay: 0.1s">
        <form action="{{ route('admin.santri.update', $santri) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Section: Data Identitas -->
            <div>
                <h3 class="text-lg font-bold text-chalimi-800 mb-4 border-b border-gray-200 pb-2">Identitas Santri</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-chalimi-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $santri->nama_lengkap) }}" required class="w-full glass-input">
                        @error('nama_lengkap') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-chalimi-700 mb-1">Nama Panggilan</label>
                        <input type="text" name="nama_panggilan" value="{{ old('nama_panggilan', $santri->nama_panggilan) }}" class="w-full glass-input">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-chalimi-700 mb-1">Nomor Induk Santri (NIS)</label>
                        <input type="text" name="nis" value="{{ old('nis', $santri->nis) }}" required class="w-full glass-input">
                        @error('nis') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-chalimi-700 mb-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin" required class="w-full glass-input">
                            <option value="L" {{ old('jenis_kelamin', $santri->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $santri->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-chalimi-700 mb-1">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $santri->tempat_lahir) }}" required class="w-full glass-input">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-chalimi-700 mb-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $santri->tanggal_lahir->format('Y-m-d')) }}" required class="w-full glass-input">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-chalimi-700 mb-1">Alamat Lengkap</label>
                        <textarea name="alamat" rows="2" required class="w-full glass-input">{{ old('alamat', $santri->alamat) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Section: Data Akademik & Wali -->
            <div class="pt-4">
                <h3 class="text-lg font-bold text-chalimi-800 mb-4 border-b border-gray-200 pb-2">Akademik & Wali</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-chalimi-700 mb-1">Status Santri</label>
                        <select name="status" required class="w-full glass-input">
                            <option value="aktif" {{ old('status', $santri->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="alumni" {{ old('status', $santri->status) == 'alumni' ? 'selected' : '' }}>Alumni</option>
                            <option value="keluar" {{ old('status', $santri->status) == 'keluar' ? 'selected' : '' }}>Keluar</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-chalimi-700 mb-1">Wali Santri</label>
                        <select name="wali_id" required class="w-full glass-input">
                            @foreach($walis as $wali)
                                <option value="{{ $wali->id }}" {{ old('wali_id', $santri->wali_id) == $wali->id ? 'selected' : '' }}>
                                    {{ $wali->name }} ({{ $wali->phone }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-chalimi-700 mb-1">Update Foto (Opsional)</label>
                        <div class="flex items-center gap-4">
                            @if($santri->foto)
                                <img src="{{ asset('storage/'.$santri->foto) }}" class="w-16 h-16 rounded-full object-cover border-2 border-chalimi-200">
                            @endif
                            <input type="file" name="foto" accept="image/*" class="w-full glass-input file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-chalimi-50 file:text-chalimi-700 hover:file:bg-chalimi-100">
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-6 flex justify-end gap-3">
                <a href="{{ route('admin.santri.index') }}" class="btn-glass bg-white/50 text-chalimi-700">Batal</a>
                <button type="submit" class="btn-chalimi shadow-lg shadow-emerald-500/30">
                    Update Data
                </button>
            </div>
        </form>
    </div>
@endsection
