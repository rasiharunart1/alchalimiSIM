@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-end">
        <div>
            <h2 class="text-2xl font-bold text-white">Verifikasi Pembayaran</h2>
            <p class="text-chalimi-200">Konfirmasi bukti transfer santri yang belum diverifikasi.</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="glass-panel p-6 bg-gradient-to-br from-yellow-900/40 to-transparent border-yellow-500/20">
            <h4 class="text-chalimi-200 text-sm font-medium mb-1">Menunggu Verifikasi</h4>
            <p class="text-3xl font-bold text-white">{{ $pembayarans->total() }} Transaksi</p>
        </div>
    </div>

    <!-- Table -->
    <div class="glass-panel overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/10 bg-black/20 text-left">
                        <th class="px-6 py-4 text-xs font-bold text-chalimi-300 uppercase">Santri & Jenis</th>
                        <th class="px-6 py-4 text-xs font-bold text-chalimi-300 uppercase">Waktu Bayar</th>
                        <th class="px-6 py-4 text-xs font-bold text-chalimi-300 uppercase">Jumlah</th>
                        <th class="px-6 py-4 text-xs font-bold text-chalimi-300 uppercase">Bukti</th>
                        <th class="px-6 py-4 text-xs font-bold text-chalimi-300 uppercase text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($pembayarans as $pembayaran)
                    <tr class="hover:bg-white/5 transition">
                        <td class="px-6 py-4">
                            <p class="text-white font-bold text-sm">{{ $pembayaran->santri->nama_lengkap }}</p>
                            <p class="text-xs text-chalimi-400 uppercase">{{ $pembayaran->jenis }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-300">
                             {{ $pembayaran->created_at->translatedFormat('d F Y') }}
                             <span class="text-xs block text-gray-500">{{ $pembayaran->created_at->diffForHumans() }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm font-mono text-white">
                            Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($pembayaran->bukti_transfer)
                                <button type="button" onclick="showProofModal('{{ asset('storage/' . $pembayaran->bukti_transfer) }}')" class="text-chalimi-400 hover:text-white flex items-center gap-1 text-xs">
                                    <i class="fa-solid fa-image"></i> Lihat Bukti
                                </button>
                            @else
                                <span class="text-red-400 text-xs">Tanpa Bukti</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                             <div class="flex justify-end gap-2">
                                 <!-- Form Konfirmasi -->
                                 <form action="{{ route('pengurus.pembayaran.verifikasi.action', $pembayaran) }}" method="POST">
                                     @csrf
                                     <input type="hidden" name="action" value="konfirmasi">
                                     <button type="submit" onclick="return confirm('Konfirmasi pembayaran ini?')" class="px-3 py-1.5 bg-green-600/20 text-green-400 hover:bg-green-600 hover:text-white rounded-lg text-xs font-bold transition flex items-center gap-1">
                                         <i class="fa-solid fa-check"></i> Konfirmasi
                                     </button>
                                 </form>

                                 <!-- Tombol Tolak (Dgn Modal/Prompt if needed, here we use simple form) -->
                                 <button onclick="rejectPayment({{ $pembayaran->id }})" class="px-3 py-1.5 bg-red-600/20 text-red-400 hover:bg-red-600 hover:text-white rounded-lg text-xs font-bold transition flex items-center gap-1">
                                     <i class="fa-solid fa-times"></i> Tolak
                                 </button>
                             </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-chalimi-400">
                            <i class="fa-regular fa-folder-open text-3xl mb-2 block"></i>
                            Tidak ada pembayaran yang menunggu verifikasi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pembayarans->hasPages())
            <div class="px-6 py-4 border-t border-white/10">
                {{ $pembayarans->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal View Proof -->
<div id="proofModal" class="fixed inset-0 bg-black/90 backdrop-blur-sm z-[9999] hidden items-center justify-center p-4">
    <div class="relative max-w-4xl w-full flex flex-col items-center">
        <button onclick="closeProofModal()" class="absolute -top-12 right-0 text-white hover:text-red-400 transition text-3xl">
            <i class="fa-solid fa-times"></i>
        </button>
        <div class="glass-panel p-2 bg-white/5 overflow-hidden rounded-2xl shadow-2xl">
            <img id="proofImage" src="" class="max-h-[85vh] w-auto rounded-xl object-contain" alt="Bukti Transfer">
        </div>
    </div>
</div>

<!-- Modal Reject -->
<div id="rejectModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-[9999] hidden items-center justify-center p-4">
    <div class="glass-panel max-w-md w-full p-8 space-y-6">
        <div class="text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-exclamation-triangle text-red-600 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-white">Tolak Pembayaran</h3>
            <p class="text-chalimi-300 text-sm mt-2">Berikan alasan penolakan agar wali santri dapat memperbaiki konfirmasinya.</p>
        </div>
        
        <form id="rejectForm" action="" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="action" value="ditolak">
            <div>
                <label class="block text-sm font-medium text-chalimi-300 mb-1">Alasan Penolakan</label>
                <textarea name="keterangan_admin" required class="glass-input w-full" rows="3" placeholder="Contoh: Bukti transfer tidak jelas atau nominal tidak sesuai."></textarea>
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeRejectModal()" class="flex-1 px-6 py-3 bg-white/5 hover:bg-white/10 text-white rounded-xl transition font-bold">Batal</button>
                <button type="submit" class="flex-1 px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl transition font-bold shadow-lg shadow-red-600/20">Tolak Sekarang</button>
            </div>
        </form>
    </div>
</div>

<script>
    function showProofModal(src) {
        const modal = document.getElementById('proofModal');
        const img = document.getElementById('proofImage');
        img.src = src;
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden'; // Prevent scroll
    }

    function closeProofModal() {
        document.getElementById('proofModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function rejectPayment(id) {
        const form = document.getElementById('rejectForm');
        form.action = `/pengurus/verifikasi/${id}`;
        document.getElementById('rejectModal').style.display = 'flex';
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').style.display = 'none';
    }

    // Close on click outside for both modals
    window.onclick = function(event) {
        const proofModal = document.getElementById('proofModal');
        const rejectModal = document.getElementById('rejectModal');
        if (event.target == proofModal) closeProofModal();
        if (event.target == rejectModal) closeRejectModal();
    }
</script>
@endsection
