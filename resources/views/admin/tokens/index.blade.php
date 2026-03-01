@extends('layouts.app')

@section('content')
    <div class="mb-6 flex justify-between items-center animate-fade-in-up">
        <div>
            <h2 class="text-2xl font-bold text-chalimi-900">Token Registrasi Alumni</h2>
            <p class="text-chalimi-600 text-sm">Generate token unik untuk pendaftaran mandiri alumni.</p>
        </div>
        <form action="{{ route('admin.tokens.store') }}" method="POST">
            @csrf
            <button type="submit" class="btn-chalimi shadow-lg shadow-emerald-500/30">
                + Generate Token Baru
            </button>
        </form>
    </div>

    <!-- Data Table -->
    <div class="glass-panel overflow-hidden animate-fade-in-up" style="animation-delay: 0.1s">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-chalimi-900/5 text-chalimi-900 border-b border-chalimi-200">
                        <th class="p-4 font-semibold">Kode Token</th>
                        <th class="p-4 font-semibold">Status</th>
                        <th class="p-4 font-semibold">Digunakan Oleh</th>
                        <th class="p-4 font-semibold">Tgl Dibuat</th>
                        <th class="p-4 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-chalimi-100">
                    @forelse($tokens as $token)
                        <tr class="hover:bg-white/30 transition-colors">
                            <td class="p-4">
                                <span class="font-mono font-bold text-lg text-chalimi-900 bg-white/50 px-3 py-1 rounded border border-chalimi-200">
                                    {{ $token->token }}
                                </span>
                            </td>
                            <td class="p-4">
                                @if($token->is_used)
                                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-gray-100 text-gray-600">Terpakai</span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-emerald-100 text-emerald-700">Tersedia</span>
                                @endif
                            </td>
                            <td class="p-4">
                                @if($token->is_used && $token->user)
                                    <div class="flex items-center gap-2">
                                        <span class="font-semibold text-chalimi-800">{{ $token->user->name }}</span>
                                    </div>
                                @else
                                    <span class="text-xs text-chalimi-400">-</span>
                                @endif
                            </td>
                            <td class="p-4 text-xs text-chalimi-600">
                                {{ $token->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="p-4">
                                @if(!$token->is_used)
                                    <form action="{{ route('admin.tokens.destroy', $token) }}" method="POST" onsubmit="return confirm('Hapus token ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100" title="Hapus">🗑️</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-chalimi-500">
                                Belum ada token yang dibuat. Klik tombol di atas untuk membuat token pertama.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-chalimi-100">
            {{ $tokens->links() }}
        </div>
    </div>

    <!-- Info Box -->
    <div class="mt-6 p-4 rounded-xl bg-blue-50 border border-blue-100 flex gap-4 items-start animate-fade-in-up" style="animation-delay: 0.2s">
        <div class="text-blue-500 text-xl font-bold mt-0.5">ℹ️</div>
        <div>
            <h4 class="font-bold text-blue-900 text-sm">Cara Kerja Token:</h4>
            <ul class="text-xs text-blue-800 mt-1 space-y-1 list-disc ml-4">
                <li>Satu token hanya berlaku untuk <strong>satu kali pendaftaran</strong>.</li>
                <li>Setelah pendaftaran berhasil, token akan otomatis terkoneksi dengan akun alumni tersebut.</li>
                <li>Berikan kode token ini secara privat kepada alumni yang ingin mendaftar.</li>
            </ul>
        </div>
    </div>
@endsection
