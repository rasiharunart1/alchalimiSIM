@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="mb-6 animate-fade-in-up">
        <a href="{{ route('pengurus.tagihan.index') }}" class="text-chalimi-300 hover:text-white mb-2 inline-flex items-center gap-2 transition">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Data Tagihan
        </a>
        <h2 class="text-2xl font-bold text-white">Buat Tagihan Baru</h2>
    </div>

    <div class="glass-panel p-8 animate-fade-in-up">
        <form action="{{ route('pengurus.tagihan.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Target Selection -->
            <div>
                <label class="block text-sm font-medium text-chalimi-300 mb-2">Target Tagihan</label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="cursor-pointer">
                        <input type="radio" name="target" value="individual" class="peer sr-only" checked onchange="toggleTarget('individual')">
                        <div class="p-4 rounded-xl border border-white/10 peer-checked:bg-chalimi-600 peer-checked:border-chalimi-500 hover:bg-white/5 transition text-center">
                            <i class="fa-solid fa-user mb-1 block"></i> Per Santri
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="target" value="all" class="peer sr-only" onchange="toggleTarget('all')">
                        <div class="p-4 rounded-xl border border-white/10 peer-checked:bg-chalimi-600 peer-checked:border-chalimi-500 hover:bg-white/5 transition text-center">
                            <i class="fa-solid fa-users mb-1 block"></i> Semua Santri Aktif
                        </div>
                    </label>
                </div>
            </div>

            <!-- Santri Select (Conditional) -->
            <div id="santri-select-container">
                <label class="block text-sm font-medium text-chalimi-300 mb-1">Pilih Santri</label>
                <select name="santri_id" class="glass-input w-full">
                    <option value="">-- Pilih Santri --</option>
                    @foreach($santris as $santri)
                        <option value="{{ $santri->id }}">{{ $santri->nama_lengkap }} ({{ $santri->nis }})</option>
                    @endforeach
                </select>
                @error('santri_id') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-6">
                <!-- Jenis Tagihan -->
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-chalimi-300 mb-1">Jenis Tagihan</label>
                    <select name="jenis" class="glass-input w-full" required>
                        <option value="spp">SPP Bulanan</option>
                        <option value="dpp">DPP / Uang Masuk</option>
                        <option value="seragam">Seragam & Kitab</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <!-- Bulan / Periode -->
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-chalimi-300 mb-1">Periode (Bulan)</label>
                    <input type="month" name="bulan" value="{{ date('Y-m') }}" class="glass-input w-full" required>
                </div>

                <!-- Jumlah -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-chalimi-300 mb-1">Nominal (Rp)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-chalimi-400 font-bold">Rp</span>
                        <input type="number" name="jumlah" class="glass-input w-full pl-12" placeholder="Contoh: 150000" required min="0">
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-white/10 flex justify-end gap-3">
                <button type="submit" class="px-6 py-3 bg-chalimi-600 hover:bg-chalimi-500 text-white rounded-xl font-bold shadow-lg shadow-chalimi-600/30 transition">
                    <i class="fa-solid fa-save mr-2"></i> Simpan Tagihan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleTarget(val) {
        const el = document.getElementById('santri-select-container');
        if (val === 'all') {
            el.style.display = 'none';
        } else {
            el.style.display = 'block';
        }
    }
</script>
@endsection
