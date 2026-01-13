@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto animate-fade-in-up">
        
        <div class="mb-6 flex justify-between items-center print:hidden">
            <a href="{{ route('admin.pembayaran.index') }}" class="text-chalimi-600 hover:text-chalimi-800">← Kembali</a>
            <button onclick="window.print()" class="btn-chalimi flex items-center gap-2">
                <span>🖨️</span> Cetak Bukti
            </button>
        </div>

        <div class="bg-white p-10 rounded-2xl shadow-xl border border-gray-100 relative overflow-hidden print:shadow-none print:border-0">
            <!-- Watermark -->
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-[0.03]">
                <div class="text-[200px]">🕌</div>
            </div>

            <!-- Header Invoice -->
            <div class="flex justify-between items-start border-b-2 border-chalimi-600 pb-6 mb-8 relative z-10">
                <div>
                    <h1 class="text-3xl font-bold text-chalimi-800">KWITANSI PEMBAYARAN</h1>
                    <p class="text-chalimi-600 font-medium mt-1">PP Tahfidzul Quran Al-Chalimi</p>
                    <p class="text-sm text-gray-500 mt-2">Jl. Pesantren No. 123, Kota Santri</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">No. Referensi</p>
                    <p class="font-mono font-bold text-xl text-gray-800">#TRX-{{ str_pad($pembayaran->id, 6, '0', STR_PAD_LEFT) }}</p>
                    <p class="text-sm text-gray-500 mt-2">Tanggal</p>
                    <p class="font-medium text-gray-800">{{ $pembayaran->tanggal_bayar->format('d F Y') }}</p>
                </div>
            </div>

            <!-- Details -->
            <div class="grid grid-cols-2 gap-8 mb-8 relative z-10">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Diterima Dari</p>
                    <h3 class="text-xl font-bold text-gray-900 mt-1">{{ $pembayaran->santri->nama_lengkap }}</h3>
                    <p class="text-gray-600">NIS: {{ $pembayaran->santri->nis }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Metode Pembayaran</p>
                    <h3 class="text-xl font-bold text-gray-900 mt-1">{{ ucfirst($pembayaran->metode) }}</h3>
                    <p class="text-gray-600">Admin: {{ $pembayaran->recordedBy->name ?? 'Verifikasi Pending' }}</p>
                </div>
            </div>

            <!-- Payment Item -->
            <div class="bg-chalimi-50 rounded-lg p-6 mb-8 border border-chalimi-100 relative z-10">
                <div class="flex justify-between items-center mb-2">
                    <span class="font-bold text-chalimi-800 text-lg uppercase bg-white px-3 py-1 rounded border border-chalimi-200">
                        {{ $pembayaran->jenis }}
                    </span>
                    <span class="font-mono font-bold text-2xl text-chalimi-900">
                        Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                    </span>
                </div>
                <p class="text-gray-600 italic border-t border-chalimi-200 mt-3 pt-3">
                    "{{ $pembayaran->keterangan ?: 'Pembayaran sekolah santri' }}"
                </p>
            </div>

            <!-- Footer -->
            <div class="flex justify-between items-end relative z-10 mt-12">
                <div class="text-xs text-gray-400">
                    <p>Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
                    <p>Simpan bukti pembayaran ini sebagai arsip.</p>
                </div>
                <div class="text-center">
                    <p class="text-sm font-bold text-gray-800 mb-16">Penerima,</p>
                    <p class="font-medium text-gray-600 border-t border-gray-400 px-8 pt-1">
                        {{ $pembayaran->recordedBy->name ?? 'Sistem / Wali' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
