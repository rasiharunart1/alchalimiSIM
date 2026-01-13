@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="mb-6 animate-fade-in-up">
        <a href="{{ route('pengurus.pembayaran.index') }}" class="text-chalimi-300 hover:text-white mb-2 inline-flex items-center gap-2 transition">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Data Pembayaran
        </a>
        <h2 class="text-2xl font-bold text-white">Catat Pembayaran Baru</h2>
    </div>

    <div class="glass-panel p-8 animate-fade-in-up" style="animation-delay: 0.1s">
        <!-- Step 1: Select Santri -->
        <form action="{{ route('pengurus.pembayaran.create') }}" method="GET" class="mb-8 border-b border-white/10 pb-8">
            <label class="block text-sm font-medium text-chalimi-300 mb-2">Cari Santri</label>
            <div class="flex gap-4">
                <div class="flex-1 relative">
                    <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-chalimi-400"></i>
                     <select name="santri_id" class="glass-input w-full pl-10" onchange="this.form.submit()">
                        <option value="">-- Pilih Santri --</option>
                        @foreach($santris as $santri)
                            <option value="{{ $santri->id }}" {{ request('santri_id') == $santri->id ? 'selected' : '' }}>
                                {{ $santri->nama_lengkap }} ({{ $santri->nis }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-6 py-2 bg-chalimi-600/50 hover:bg-chalimi-600 text-white rounded-xl transition">
                    Pilih
                </button>
            </div>
        </form>

        @if($selectedSantri)
            <form action="{{ route('pengurus.pembayaran.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 animate-fade-in-up">
                @csrf
                <input type="hidden" name="santri_id" value="{{ $selectedSantri->id }}">

                <!-- Tagihan Selection -->
                <div class="bg-white/5 p-4 rounded-xl border border-white/10">
                    <h4 class="font-bold text-white mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-file-invoice-dollar text-chalimi-400"></i> Pilih Tagihan (Opsional)
                    </h4>
                    
                    @if($unpaidBills->count() > 0)
                        <div class="space-y-2 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($unpaidBills as $bill)
                                <label class="flex items-center gap-4 p-3 rounded-lg border border-white/5 bg-black/20 hover:bg-white/5 cursor-pointer transition group">
                                    <input type="radio" name="tagihan_id" value="{{ $bill->id }}" 
                                        data-jenis="{{ $bill->jenis }}" 
                                        data-jumlah="{{ $bill->jumlah }}"
                                        data-desc="Pembayaran {{ ucfirst($bill->jenis) }} - {{ \Carbon\Carbon::parse($bill->bulan)->translatedFormat('F Y') }}"
                                        class="text-chalimi-500 focus:ring-chalimi-500 bg-black/50 border-white/20"
                                        onchange="autoFillPayment(this)">
                                    <div class="flex-1">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="font-bold text-white text-sm">{{ ucfirst($bill->jenis) }}</span>
                                            <span class="font-mono text-chalimi-300">Rp {{ number_format($bill->jumlah, 0, ',', '.') }}</span>
                                        </div>
                                        <p class="text-xs text-gray-400">Periode: {{ \Carbon\Carbon::parse($bill->bulan)->translatedFormat('F Y') }}</p>
                                    </div>
                                    <span class="px-2 py-1 bg-red-500/20 text-red-300 text-[10px] font-bold rounded uppercase">Belum Lunas</span>
                                </label>
                            @endforeach
                        </div>
                        <button type="button" class="text-xs text-chalimi-400 hover:text-white mt-2 underline" onclick="resetForm()">Reset Pilihan Tagihan</button>
                    @else
                        <p class="text-sm text-gray-400 italic">Tidak ada tagihan tertunggak untuk santri ini.</p>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Jenis Pembayaran -->
                    <div>
                        <label class="block text-sm font-medium text-chalimi-300 mb-1">Jenis Pembayaran</label>
                        <select name="jenis" id="jenis" class="glass-input w-full" required>
                            <option value="spp">SPP Bulanan</option>
                            <option value="dpp">DPP / Uang Masuk</option>
                            <option value="seragam">Seragam & Kitab</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>

                    <!-- Nominal -->
                    <div>
                        <label class="block text-sm font-medium text-chalimi-300 mb-1">Nominal Pembayaran (Rp)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-chalimi-400 font-bold">Rp</span>
                            <input type="number" name="jumlah" id="jumlah" class="glass-input w-full pl-12" required min="0">
                        </div>
                    </div>

                    <!-- Tanggal Bayar -->
                    <div>
                        <label class="block text-sm font-medium text-chalimi-300 mb-1">Tanggal Bayar</label>
                        <input type="date" name="tanggal_bayar" value="{{ date('Y-m-d') }}" class="glass-input w-full" required>
                    </div>

                    <!-- Metode Pembayaran -->
                    <div>
                        <label class="block text-sm font-medium text-chalimi-300 mb-1">Metode Pembayaran</label>
                        <select name="metode" class="glass-input w-full" required>
                            <option value="tunai">Tunai (Cash)</option>
                            <option value="transfer">Transfer Bank</option>
                        </select>
                    </div>

                    <!-- Keterangan -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-chalimi-300 mb-1">Keterangan / Catatan</label>
                        <textarea name="keterangan" id="keterangan" rows="2" class="glass-input w-full" placeholder="Opsional..."></textarea>
                    </div>

                     <!-- Bukti Transfer -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-chalimi-300 mb-1">Bukti Transfer (Jika ada)</label>
                        <input type="file" name="bukti_transfer" accept="image/*" class="w-full glass-input file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-chalimi-600 file:text-white hover:file:bg-chalimi-500">
                    </div>
                </div>

                <div class="pt-6 flex justify-end gap-3 border-t border-white/10">
                    <button type="submit" class="px-8 py-3 bg-green-600 hover:bg-green-500 text-white rounded-xl font-bold shadow-lg shadow-green-600/30 transition flex items-center gap-2">
                        <i class="fa-solid fa-check-circle"></i> Simpan Pembayaran
                    </button>
                </div>
            </form>
        @else
            <div class="text-center py-12 text-chalimi-400">
                <i class="fa-solid fa-user-tag text-4xl mb-3"></i>
                <p>Silakan pilih santri terlebih dahulu untuk mencatat pembayaran.</p>
            </div>
        @endif
    </div>
</div>

<script>
    function autoFillPayment(radio) {
        if(radio.checked) {
            document.getElementById('jenis').value = radio.getAttribute('data-jenis');
            document.getElementById('jumlah').value = radio.getAttribute('data-jumlah');
            document.getElementById('keterangan').value = radio.getAttribute('data-desc');
        }
    }

    function resetForm() {
        const radios = document.getElementsByName('tagihan_id');
        radios.forEach(r => r.checked = false);
        document.getElementById('jumlah').value = '';
        document.getElementById('keterangan').value = '';
    }
</script>
@endsection
