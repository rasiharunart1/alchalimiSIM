@extends('layouts.app')

@section('content')
    <div class="mb-6 animate-fade-in-up">
        <a href="{{ route('pembayaran.index') }}" class="text-chalimi-600 hover:text-chalimi-800 mb-2 inline-block">← Kembali ke Data Pembayaran</a>
        <h2 class="text-2xl font-bold text-chalimi-900">Catat Pembayaran Baru</h2>
    </div>

    <div class="glass-panel p-8 max-w-2xl mx-auto animate-fade-in-up" style="animation-delay: 0.1s">
        <form action="{{ route('pembayaran.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <!-- Santri Selection -->
            <div>
                <label class="block text-sm font-medium text-chalimi-700 mb-1">Pilih Santri</label>
                <select name="santri_id" required class="w-full glass-input">
                    <option value="">-- Cari Nama Santri --</option>
                    @foreach($santris as $santri)
                        <option value="{{ $santri->id }}" {{ old('santri_id') == $santri->id ? 'selected' : '' }}>
                            {{ $santri->nis }} - {{ $santri->nama_lengkap }}
                        </option>
                    @endforeach
                </select>
                @error('santri_id') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
            </div>

            <!-- Payment Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-chalimi-700 mb-1">Jenis Pembayaran</label>
                    <select name="jenis" required class="w-full glass-input">
                        <option value="spp" {{ old('jenis') == 'spp' ? 'selected' : '' }}>SPP (Bulanan)</option>
                        <option value="dpp" {{ old('jenis') == 'dpp' ? 'selected' : '' }}>DPP (Uang Pangkal)</option>
                        <option value="seragam" {{ old('jenis') == 'seragam' ? 'selected' : '' }}>Seragam & Kitab</option>
                        <option value="lainnya" {{ old('jenis') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-chalimi-700 mb-1">Tanggal Bayar</label>
                    <input type="date" name="tanggal_bayar" value="{{ old('tanggal_bayar', date('Y-m-d')) }}" required class="w-full glass-input">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-chalimi-700 mb-1">Jumlah Pembayaran (Rp)</label>
                <div class="relative">
                    <span class="absolute left-4 top-3 text-chalimi-600 font-bold">Rp</span>
                    <input type="number" name="jumlah" value="{{ old('jumlah') }}" required min="0" 
                        class="w-full glass-input pl-12 font-mono text-lg font-bold text-chalimi-900">
                </div>
                @error('jumlah') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-chalimi-700 mb-1">Keterangan (Opsional)</label>
                <textarea name="keterangan" rows="2" class="w-full glass-input" placeholder="Contoh: SPP Bulan Januari 2026">{{ old('keterangan') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-chalimi-700 mb-1">Metode Pembayaran</label>
                    <select name="metode" required class="w-full glass-input">
                        <option value="tunai" {{ old('metode') == 'tunai' ? 'selected' : '' }}>Tunai / Cash</option>
                        <option value="transfer" {{ old('metode') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-chalimi-700 mb-1">Bukti Transfer (Jika ada)</label>
                    <input type="file" name="bukti_transfer" accept="image/*" class="w-full glass-input text-sm">
                </div>
            </div>

            <div class="pt-6 flex justify-end gap-3 border-t border-chalimi-100">
                <a href="{{ route('pembayaran.index') }}" class="btn-glass bg-white/50 text-chalimi-700">Batal</a>
                <button type="submit" class="btn-chalimi shadow-lg shadow-emerald-500/30">
                    💾 Simpan Transaksi
                </button>
            </div>
        </form>
    </div>
@endsection
