@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="glass-panel p-8">
        <h2 class="text-2xl font-bold text-white mb-6">Buat Topik Baru</h2>
        
        <form action="{{ route('threads.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label class="block text-chalimi-200 text-sm font-bold mb-2">Judul Topik</label>
                <input type="text" name="title" class="glass-input w-full text-white placeholder-gray-400" placeholder="Apa yang ingin Anda diskusikan?" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-chalimi-200 text-sm font-bold mb-2">Kategori</label>
                    <select name="category" class="glass-input w-full text-white bg-transparent">
                        <option value="General" class="text-black">General</option>
                        <option value="Parenting" class="text-black">Parenting</option>
                        <option value="Jual Beli" class="text-black">Jual Beli</option>
                        <option value="Pengumuman" class="text-black">Pengumuman (Admin/Ustadz)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-chalimi-200 text-sm font-bold mb-2">Lampiran Gambar (Opsional)</label>
                    <input type="file" name="image" class="glass-input w-full text-white file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-chalimi-500 file:text-white hover:file:bg-chalimi-600">
                </div>
            </div>

            <div>
                <label class="block text-chalimi-200 text-sm font-bold mb-2">Instagram Post URL (Embedded - Opsional)</label>
                <input type="url" name="instagram_url" class="glass-input w-full text-white placeholder-gray-400" placeholder="https://www.instagram.com/p/...">
                <p class="text-[10px] text-chalimi-400 mt-1 italic">*Jika diisi, konten IG akan ditampilkan secara otomatis.</p>
            </div>

            <div>
                <label class="block text-chalimi-200 text-sm font-bold mb-2">Isi Diskusi</label>
                <textarea name="body" rows="6" class="glass-input w-full text-white placeholder-gray-400" placeholder="Tulis detail diskusi di sini..." required></textarea>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('threads.index') }}" class="px-6 py-2 rounded-xl text-chalimi-200 hover:bg-white/10 transition">Batal</a>
                <button type="submit" class="btn-chalimi">Terbitkan</button>
            </div>
        </form>
    </div>
</div>
@endsection
