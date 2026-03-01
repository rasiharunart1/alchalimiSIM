@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="glass-panel p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-white">Edit Produk</h2>
            <a href="{{ route('unit_usaha.index') }}" class="text-chalimi-300 hover:text-white transition">
                <i class="fa-solid fa-times text-xl"></i>
            </a>
        </div>

        <form action="{{ route('admin.unit-usaha.update', $unitUsaha) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-chalimi-200 text-sm font-bold mb-2">Nama Produk</label>
                <input type="text" name="name" value="{{ $unitUsaha->name }}" class="glass-input w-full" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
                <div>
                    <label class="block text-chalimi-200 text-sm font-bold mb-2">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ $unitUsaha->price }}" class="glass-input w-full" required>
                </div>
                <div class="flex items-center gap-2 mb-3">
                    <input type="checkbox" name="show_price" id="show_price" {{ $unitUsaha->show_price ? 'checked' : '' }} class="w-5 h-5 accent-chalimi-500">
                    <label for="show_price" class="text-sm text-chalimi-200 font-bold cursor-pointer">Tampilkan Harga</label>
                </div>
            </div>

            <div>
                <label class="block text-chalimi-200 text-sm font-bold mb-2">Deskripsi</label>
                <textarea name="description" rows="3" class="glass-input w-full">{{ $unitUsaha->description }}</textarea>
            </div>
            
            <div>
                <label class="block text-chalimi-200 text-sm font-bold mb-2">Nomor WhatsApp Kontak</label>
                <input type="text" name="contact_number" value="{{ $unitUsaha->contact_number }}" class="glass-input w-full">
            </div>
            
            <div>
                 <label class="block text-chalimi-200 text-sm font-bold mb-2">Status</label>
                 <select name="status" class="glass-input w-full">
                     <option value="available" {{ $unitUsaha->status == 'available' ? 'selected' : '' }} class="text-black">Tersedia</option>
                     <option value="out_of_stock" {{ $unitUsaha->status == 'out_of_stock' ? 'selected' : '' }} class="text-black">Habis</option>
                 </select>
            </div>

            <div>
                <label class="block text-chalimi-200 text-sm font-bold mb-2">Link Postingan Instagram (Rekomendasi)</label>
                <input type="url" name="instagram_url" value="{{ $unitUsaha->instagram_url }}" class="glass-input w-full" placeholder="https://www.instagram.com/p/...">
                <p class="text-xs text-chalimi-400 mt-1">Gunakan link ini untuk tampilan produk yang lebih interaktif dan stabil.</p>
            </div>

            <div>
                <label class="block text-chalimi-200 text-sm font-bold mb-2">Foto Produk (Cadangan)</label>
                @if($unitUsaha->image)
                    <div class="mb-4 flex items-center gap-4 p-4 bg-white/5 rounded-xl border border-white/10">
                         <img src="{{ asset('storage/' . $unitUsaha->image) }}" class="w-24 h-24 object-cover rounded-lg">
                         <div class="flex items-center gap-2">
                             <input type="checkbox" name="remove_image" id="remove_image" class="w-5 h-5 accent-red-500">
                             <label for="remove_image" class="text-sm text-red-400 font-bold cursor-pointer">Hapus Gambar & Gunakan Instagram Saja</label>
                         </div>
                    </div>
                @endif
                <input type="file" name="image" class="glass-input w-full file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-chalimi-50 file:text-chalimi-700 hover:file:bg-chalimi-100">
                <p class="text-xs text-chalimi-400 mt-2 italic">*Upload foto baru akan otomatis menggantikan foto lama.</p>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full btn-chalimi">Update Produk</button>
            </div>
        </form>
    </div>
</div>
@endsection
