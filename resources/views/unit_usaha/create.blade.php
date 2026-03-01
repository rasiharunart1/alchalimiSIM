@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="glass-panel p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-white">Tambah Produk Baru</h2>
            <a href="{{ route('unit_usaha.index') }}" class="text-chalimi-300 hover:text-white transition">
                <i class="fa-solid fa-times text-xl"></i>
            </a>
        </div>

        <form action="{{ route('admin.unit-usaha.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label class="block text-chalimi-200 text-sm font-bold mb-2">Nama Produk</label>
                <input type="text" name="name" class="glass-input w-full" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
                <div>
                    <label class="block text-chalimi-200 text-sm font-bold mb-2">Harga (Rp)</label>
                    <input type="number" name="price" class="glass-input w-full" required>
                </div>
                <div class="flex items-center gap-2 mb-3">
                    <input type="checkbox" name="show_price" id="show_price" checked class="w-5 h-5 accent-chalimi-500">
                    <label for="show_price" class="text-sm text-chalimi-200 font-bold cursor-pointer">Tampilkan Harga</label>
                </div>
            </div>

            <div>
                <label class="block text-chalimi-200 text-sm font-bold mb-2">Deskripsi</label>
                <textarea name="description" rows="3" class="glass-input w-full"></textarea>
            </div>
            
            <div>
                <label class="block text-chalimi-200 text-sm font-bold mb-2">Nomor WhatsApp Kontak</label>
                <input type="text" name="contact_number" class="glass-input w-full" placeholder="62812345678" value="6281234567890">
                <p class="text-xs text-chalimi-400 mt-1">Gunakan format internasional (62...)</p>
            </div>
            
            <div>
                 <label class="block text-chalimi-200 text-sm font-bold mb-2">Status</label>
                 <select name="status" class="glass-input w-full">
                     <option value="available" class="text-black">Tersedia</option>
                     <option value="out_of_stock" class="text-black">Habis</option>
                 </select>
            </div>

            <div>
                <label class="block text-chalimi-200 text-sm font-bold mb-2">Link Postingan Instagram (Rekomendasi)</label>
                <input type="url" name="instagram_url" class="glass-input w-full" placeholder="https://www.instagram.com/p/...">
                <p class="text-xs text-chalimi-400 mt-1">Gunakan link ini untuk tampilan produk yang lebih interaktif dan stabil.</p>
            </div>

            <div>
                <label class="block text-chalimi-200 text-sm font-bold mb-2">Foto Produk (Cadangan)</label>
                <input type="file" name="image" class="glass-input w-full file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-chalimi-50 file:text-chalimi-700 hover:file:bg-chalimi-100">
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full btn-chalimi">Simpan Produk</button>
            </div>
        </form>
    </div>
</div>
@endsection
