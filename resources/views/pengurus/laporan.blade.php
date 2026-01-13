@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white">Laporan Keuangan</h1>
            <p class="text-chalimi-200">Rekapitulasi pemasukan dan tunggakan santri.</p>
        </div>
        <div class="flex gap-2 print:hidden">
            <button onclick="window.print()" class="px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white rounded-xl font-bold transition flex items-center gap-2">
                <i class="fa-solid fa-print"></i> Cetak Laporan
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="glass-panel p-6 print:hidden">
        <form action="{{ route('pengurus.laporan') }}" method="GET" class="flex flex-wrap items-end gap-4">
            <div class="space-y-1">
                <label class="text-xs font-bold text-chalimi-300 uppercase">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="glass-input">
            </div>
            <div class="space-y-1">
                <label class="text-xs font-bold text-chalimi-300 uppercase">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="glass-input">
            </div>
            <button type="submit" class="btn-chalimi px-6">
                <i class="fa-solid fa-filter mr-1"></i> Terapkan Filter
            </button>
        </form>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="glass-panel p-6 bg-gradient-to-br from-green-900/40 to-transparent border-green-500/20">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-green-500/20 flex items-center justify-center text-green-400">
                    <i class="fa-solid fa-money-bill-trend-up"></i>
                </div>
                <h4 class="text-green-300 font-bold uppercase text-xs tracking-wider">Total Pemasukan (Periode)</h4>
            </div>
            <p class="text-4xl font-black text-white">Rp {{ number_format($pemasukan, 0, ',', '.') }}</p>
            <p class="text-xs text-green-400 mt-2 italic font-medium">Pembayaran yang telah dikonfirmasi petugas.</p>
        </div>

        <div class="glass-panel p-6 bg-gradient-to-br from-red-900/40 to-transparent border-red-500/20">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-red-500/20 flex items-center justify-center text-red-400">
                    <i class="fa-solid fa-hand-holding-dollar"></i>
                </div>
                <h4 class="text-red-300 font-bold uppercase text-xs tracking-wider">Total Piutang (Sisa)</h4>
            </div>
            <p class="text-4xl font-black text-white">Rp {{ number_format($piutang, 0, ',', '.') }}</p>
            <p class="text-xs text-red-400 mt-2 italic font-medium">Sisa tagihan seluruh santri yang belum lunas.</p>
        </div>
    </div>

    <!-- Detail Table -->
    <div class="glass-panel overflow-hidden">
        <div class="px-6 py-4 border-b border-white/10 bg-white/5">
            <h3 class="font-bold text-white uppercase tracking-widest text-sm">Rincian Transaksi</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-black/20 text-left">
                        <th class="px-6 py-4 text-xs font-bold text-chalimi-300 uppercase">Tgl Bayar</th>
                        <th class="px-6 py-4 text-xs font-bold text-chalimi-300 uppercase">Nama Santri</th>
                        <th class="px-6 py-4 text-xs font-bold text-chalimi-300 uppercase">Jenis</th>
                        <th class="px-6 py-4 text-xs font-bold text-chalimi-300 uppercase">Metode</th>
                        <th class="px-6 py-4 text-xs font-bold text-chalimi-300 uppercase">Petugas</th>
                        <th class="px-6 py-4 text-xs font-bold text-chalimi-300 uppercase text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($pembayarans as $bayar)
                    <tr class="hover:bg-white/5 transition">
                        <td class="px-6 py-4 text-sm text-gray-300">
                            {{ \Carbon\Carbon::parse($bayar->tanggal_bayar)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-white font-bold text-sm">{{ $bayar->santri->nama_lengkap }}</p>
                            <p class="text-xs text-chalimi-400">{{ $bayar->santri->nis }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-[10px] font-bold bg-white/10 text-chalimi-200 uppercase">
                                {{ $bayar->jenis }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-300 capitalize">
                            {{ $bayar->metode }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-400 italic">
                            {{ $bayar->recordedBy->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <p class="text-white font-mono font-bold">
                                Rp {{ number_format($bayar->jumlah, 0, ',', '.') }}
                            </p>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-chalimi-400">
                            <i class="fa-solid fa-receipt text-3xl mb-3 block opacity-20"></i>
                            Tidak ada transaksi untuk periode ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($pembayarans->count() > 0)
                <tfoot class="bg-white/5 border-t-2 border-chalimi-600">
                    <tr>
                        <th colspan="5" class="px-6 py-4 text-right text-sm font-bold text-chalimi-300 uppercase font-mono">Grand Total</th>
                        <th class="px-6 py-4 text-right text-xl font-bold text-white font-mono">
                            Rp {{ number_format($pemasukan, 0, ',', '.') }}
                        </th>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>

<style>
@media print {
    body { background: white !important; color: black !important; }
    .glass-panel { border: 1px solid #eee !important; background: white !important; box-shadow: none !important; }
    .text-white, .text-chalimi-200, .text-chalimi-300, .text-gray-300 { color: black !important; }
    .bg-green-900\/40, .bg-red-900\/40 { background: #f9f9f9 !important; border: 1px solid #ccc !important; }
    th { background: #f2f2f2 !important; color: black !important; }
    .btn-chalimi { display: none; }
}
</style>
@endsection
