@extends('layouts.app')

@section('content')
    <div class="mb-6 animate-fade-in-up">
        <a href="{{ route($routePrefix.'.index') }}" class="text-chalimi-600 hover:text-chalimi-800 mb-2 inline-block">← Kembali ke Data Hafalan</a>
        <h2 class="text-2xl font-bold text-chalimi-900">Edit Data Hafalan</h2>
    </div>

    <div class="glass-panel p-8 max-w-3xl mx-auto animate-fade-in-up" style="animation-delay: 0.1s">
        <form action="{{ route($routePrefix.'.update', $hafalan) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-medium text-chalimi-700 mb-1">Nama Santri</label>
                <select name="santri_id" required class="w-full glass-input bg-gray-100 cursor-not-allowed" readonly>
                    <option value="{{ $hafalan->santri_id }}" selected>
                        {{ $hafalan->santri->nis }} - {{ $hafalan->santri->nama_lengkap }}
                    </option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Santri tidak dapat diubah saat edit.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-chalimi-700 mb-1">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $hafalan->tanggal->format('Y-m-d')) }}" required class="w-full glass-input">
                </div>
                <div>
                    <label class="block text-sm font-medium text-chalimi-700 mb-1">Juz</label>
                    <input type="number" name="juz" min="1" max="30" value="{{ old('juz', $hafalan->juz) }}" required class="w-full glass-input">
                </div>
                <div>
                    <label class="block text-sm font-medium text-chalimi-700 mb-1">Halaman</label>
                    <input type="number" name="halaman" min="1" max="20" value="{{ old('halaman', $hafalan->halaman) }}" required class="w-full glass-input">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-chalimi-700 mb-1">Nama Surah</label>
                <input type="text" name="surah" value="{{ old('surah', $hafalan->surah) }}" required class="w-full glass-input">
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-chalimi-700 mb-1">Ayat Mulai</label>
                    <input type="text" name="ayat_mulai" value="{{ old('ayat_mulai', $hafalan->ayat_mulai) }}" required class="w-full glass-input">
                </div>
                <div>
                    <label class="block text-sm font-medium text-chalimi-700 mb-1">Ayat Selesai</label>
                    <input type="text" name="ayat_selesai" value="{{ old('ayat_selesai', $hafalan->ayat_selesai) }}" required class="w-full glass-input">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-chalimi-700 mb-1">Status Hafalan</label>
                    <select name="status" required class="w-full glass-input">
                        <option value="setoran" {{ old('status', $hafalan->status) == 'setoran' ? 'selected' : '' }}>Ziyadah (Setoran Baru)</option>
                        <option value="murajaah" {{ old('status', $hafalan->status) == 'murajaah' ? 'selected' : '' }}>Muraja'ah (Mengulang)</option>
                        <option value="lulus" {{ old('status', $hafalan->status) == 'lulus' ? 'selected' : '' }}>Lulus Ujian (Tasmi')</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-chalimi-700 mb-1">Nilai (Opsional)</label>
                    <input type="number" name="nilai" min="0" max="100" value="{{ old('nilai', $hafalan->nilai) }}" class="w-full glass-input">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-chalimi-700 mb-1">Catatan Ustadz</label>
                <textarea name="catatan" rows="3" class="w-full glass-input">{{ old('catatan', $hafalan->catatan) }}</textarea>
            </div>

            <div class="pt-6 flex justify-end gap-3 border-t border-chalimi-100">
                <a href="{{ route($routePrefix.'.index') }}" class="btn-glass bg-white/50 text-chalimi-700">Batal</a>
                <button type="submit" class="btn-chalimi shadow-lg shadow-emerald-500/30">
                    Update Hafalan
                </button>
            </div>
        </form>
    </div>
@endsection
