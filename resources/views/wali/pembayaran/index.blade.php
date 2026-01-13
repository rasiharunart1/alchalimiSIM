@extends('layouts.app')

@section('content')
    <div class="mb-6 animate-fade-in-up">
        <h2 class="text-2xl font-bold text-chalimi-900">Riwayat Pembayaran</h2>
        <p class="text-chalimi-600">Pantau status pembayaran dan upload bukti transfer.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in-up" style="animation-delay: 0.1s">
        <!-- Upload Bukti Transfer Form -->
        <div class="md:col-span-1">
            <div class="glass-panel p-6">
                <h3 class="font-bold text-chalimi-800 mb-4 flex items-center gap-2">
                    <span>📤</span> Konfirmasi Pembayaran
                </h3>
                <p class="text-xs text-gray-500 mb-4">Sudah melakukan transfer? Upload bukti pembayaran Anda di sini untuk diverifikasi admin.</p>
                
                <form action="{{ route('wali.pembayaran.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <input type="hidden" name="jenis" value="lainnya"> <!-- Default pending proper logic -->
                    <input type="hidden" name="metode" value="transfer">

                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-chalimi-700 mb-1">Pilih Tagihan (Opsional)</label>
                        <select id="tagihan_id" name="tagihan_id" class="w-full glass-input text-xs" onchange="updateFormFromTagihan(this)">
                            <option value="">-- Pilih Tagihan --</option>
                            @foreach($unpaidBills as $bill)
                                <option value="{{ $bill->id }}" 
                                        data-jumlah="{{ $bill->jumlah }}" 
                                        data-jenis="{{ $bill->jenis }}"
                                        data-santri="{{ $bill->santri_id }}">
                                    [{{ strtoupper($bill->jenis) }}] {{ \Carbon\Carbon::parse($bill->bulan)->translatedFormat('F Y') }} - {{ $bill->santri->nama_panggilan }} (Rp {{ number_format($bill->jumlah, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-gray-500 mt-1">Pilih untuk otomatis mengisi jumlah & jenis.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-chalimi-700 mb-1">Pilih Santri</label>
                        <select name="santri_id" id="santri_id_select" required class="w-full glass-input text-sm">
                            @foreach(auth()->user()->santri as $santri)
                                <option value="{{ $santri->id }}">{{ $santri->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-chalimi-700 mb-1">Jumlah Transfer (Rp)</label>
                        <input type="number" name="jumlah" id="jumlah_input" required min="0" class="w-full glass-input text-sm font-bold">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-chalimi-700 mb-1">Untuk Pembayaran</label>
                        <select name="jenis" id="jenis_select" required class="w-full glass-input text-sm">
                            <option value="spp">SPP Bulanan</option>
                            <option value="dpp">DPP / Uang Gedung</option>
                            <option value="seragam">Seragam & Kitab</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-chalimi-700 mb-1">Tanggal Transfer</label>
                        <input type="date" name="tanggal_bayar" required value="{{ date('Y-m-d') }}" class="w-full glass-input text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-chalimi-700 mb-1">Bukti Foto / Screenshot</label>
                        <input type="file" name="bukti_transfer" required accept="image/*" class="w-full glass-input text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-chalimi-700 mb-1">Catatan Tambahan</label>
                        <textarea name="keterangan" rows="2" class="w-full glass-input text-sm" placeholder="Contoh: Pembayaran SPP Januari a.n Fulan"></textarea>
                    </div>

                    <button type="submit" class="btn-chalimi w-full text-sm py-2 shadow-md">
                        Kirim Konfirmasi
                    </button>
                    <p class="text-[10px] text-center text-gray-400 mt-2">Data akan diverifikasi oleh Admin/Pengurus.</p>
                </form>
            </div>
        </div>

        <!-- History Table -->
        <div class="md:col-span-2">
            <div class="glass-panel overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-white/30">
                    <h3 class="font-bold text-chalimi-800">Riwayat Transaksi</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-chalimi-500 uppercase bg-chalimi-50/50">
                            <tr>
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3">Keterangan</th>
                                <th class="px-6 py-3">Santri</th>
                                <th class="px-6 py-3 text-right">Jumlah</th>
                                <th class="px-6 py-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pembayarans as $bayar)
                                <tr class="border-b border-gray-100 hover:bg-white/40">
                                    <td class="px-6 py-4">{{ $bayar->tanggal_bayar->format('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-chalimi-900">{{ strtoupper($bayar->jenis) }}</div>
                                        <div class="text-xs text-gray-500">{{ $bayar->keterangan }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-600">{{ $bayar->santri->nama_panggilan }}</td>
                                    <td class="px-6 py-4 text-right font-bold text-chalimi-800">
                                        Rp {{ number_format($bayar->jumlah, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($bayar->status === 'pending')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                ⏳ Pending
                                            </span>
                                        @elseif($bayar->status === 'konfirmasi')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                ✅ Berhasil
                                            </span>
                                        @elseif($bayar->status === 'ditolak')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800" title="{{ $bayar->keterangan }}">
                                                ❌ Ditolak
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                        Belum ada riwayat pembayaran.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-chalimi-100">
                    {{ $pembayarans->links() }}
                </div>
            </div>
        </div>
    </div>
@push('scripts')
<script>
    function updateFormFromTagihan(select) {
        const option = select.options[select.selectedIndex];
        if (select.value) {
            document.getElementById('jumlah_input').value = option.getAttribute('data-jumlah');
            document.getElementById('jenis_select').value = option.getAttribute('data-jenis');
            document.getElementById('santri_id_select').value = option.getAttribute('data-santri');
        }
    }
</script>
@endpush
@endsection
