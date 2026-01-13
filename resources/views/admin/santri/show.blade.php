@extends('layouts.app')

@section('content')
    <div class="mb-6 animate-fade-in-up">
        <a href="{{ route('admin.santri.index') }}" class="text-chalimi-600 hover:text-chalimi-800 mb-2 inline-block">← Kembali ke Data Santri</a>
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-3xl font-bold text-chalimi-900">{{ $santri->nama_lengkap }}</h2>
                <p class="text-chalimi-600">NIS: {{ $santri->nis }} • <span class="px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-xs font-bold uppercase">{{ $santri->status }}</span></p>
            </div>
            <a href="{{ route('admin.santri.edit', $santri) }}" class="btn-glass bg-yellow-50 text-yellow-700 border-yellow-200">
                ✏️ Edit Data
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in-up" style="animation-delay: 0.1s">
        <!-- Sidebar Profile -->
        <div class="md:col-span-1 space-y-6">
            <div class="glass-panel p-6 text-center">
                <div class="w-40 h-40 mx-auto rounded-2xl bg-gray-200 border-4 border-white shadow-lg overflow-hidden mb-4 relative">
                    @if($santri->foto)
                        <img src="{{ asset('storage/'.$santri->foto) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-chalimi-50 text-5xl">👤</div>
                    @endif
                </div>
                <h3 class="text-xl font-bold text-chalimi-900">{{ $santri->nama_lengkap }}</h3>
                <p class="text-sm text-chalimi-600">{{ $santri->tempat_lahir }}, {{ $santri->tanggal_lahir->format('d M Y') }}</p>
                <div class="mt-4 pt-4 border-t border-gray-100 text-left space-y-2 text-sm">
                    <div>
                        <span class="block text-xs text-gray-500">Nama Wali</span>
                        <span class="font-semibold text-chalimi-800">{{ $santri->wali->name }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-500">Kontak Wali</span>
                        <a href="https://wa.me/{{ $santri->wali->phone }}" target="_blank" class="text-green-600 hover:underline flex items-center gap-1">
                            📱 {{ $santri->wali->phone }}
                        </a>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-500">Alamat</span>
                        <span class="text-gray-700">{{ $santri->alamat }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content (Tabs) -->
        <div class="md:col-span-2 space-y-6">
            
            <!-- Hafalan Card -->
            <div class="glass-panel p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-chalimi-800 flex items-center gap-2">
                        <span>📖</span> Progres Hafalan
                    </h3>
                    <span class="text-2xl font-bold text-chalimi-600">
                        {{ $santri->progress_hafalan['label'] }} / 30 Juz
                        <span class="text-xs font-normal text-gray-500 block text-right">
                            ({{ $santri->progress_hafalan['total_pages'] }} / 604 Halaman)
                        </span>
                    </span>
                </div>
                
                <div class="w-full bg-gray-200 rounded-full h-3 mb-6">
                    <div class="bg-gradient-to-r from-chalimi-400 to-chalimi-600 h-3 rounded-full" style="width: {{ $santri->progress_hafalan['percent'] }}%"></div>
                </div>

                <div class="space-y-3">
                    @forelse($santri->hafalan()->latest()->take(5)->get() as $hafalan)
                        <div class="flex items-center justify-between p-3 rounded-lg bg-white/40 border border-white/40">
                            <div>
                                <p class="font-bold text-chalimi-900">Juz {{ $hafalan->juz }} • {{ $hafalan->surah }}</p>
                                <p class="text-xs text-chalimi-600">Ayat {{ $hafalan->ayat_mulai }} - {{ $hafalan->ayat_selesai }}</p>
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-1 rounded text-xs font-bold {{ $hafalan->status == 'lulus' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ ucfirst($hafalan->status) }}
                                </span>
                                <p class="text-xs text-gray-500 mt-1">{{ $hafalan->tanggal->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 italic py-4">Belum ada riwayat hafalan.</p>
                    @endforelse
                </div>
            </div>

            <!-- Pembayaran Card -->
            <div class="glass-panel p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-chalimi-800 flex items-center gap-2">
                        <span>💳</span> Riwayat Pembayaran Terakhir
                    </h3>
                    <a href="#" class="text-sm text-chalimi-600 hover:underline">Lihat Semua</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-chalimi-500 uppercase bg-chalimi-50/50">
                            <tr>
                                <th class="px-4 py-3 rounded-l-lg">Tanggal</th>
                                <th class="px-4 py-3">Keterangan</th>
                                <th class="px-4 py-3">Jumlah</th>
                                <th class="px-4 py-3 rounded-r-lg">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($santri->pembayaran()->latest()->take(5)->get() as $bayar)
                                <tr class="border-b border-gray-100 last:border-0">
                                    <td class="px-4 py-3">{{ $bayar->tanggal_bayar->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3 font-medium text-chalimi-900">
                                        {{ ucfirst($bayar->jenis) }} 
                                        <span class="text-xs font-normal text-gray-500 block">{{ $bayar->keterangan }}</span>
                                    </td>
                                    <td class="px-4 py-3">Rp {{ number_format($bayar->jumlah, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3">
                                        <span class="text-green-600 font-bold text-xs">✔ Lunas</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-6 text-center text-gray-500 italic">Belum ada riwayat pembayaran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
