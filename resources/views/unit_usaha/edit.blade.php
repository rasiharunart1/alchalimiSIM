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

        <form action="{{ route('unit-usaha.update', $unitUsaha) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-chalimi-200 text-sm font-bold mb-2">Nama Produk</label>
                <input type="text" name="name" value="{{ $unitUsaha->name }}" class="glass-input w-full" required>
            </div>

            <div>
                <label class="block text-chalimi-200 text-sm font-bold mb-2">Harga (Rp)</label>
                <input type="number" name="price" value="{{ $unitUsaha->price }}" class="glass-input w-full" required>
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
                <label class="block text-chalimi-200 text-sm font-bold mb-2">Foto Produk (Opsional)</label>
                @if($unitUsaha->image)
                    <div class="mb-2">
                         <img src="{{ asset('storage/' . $unitUsaha->image) }}" class="w-32 h-32 object-cover rounded-lg text-white">
                    </div>
                @endif
                <input type="file" name="image" class="glass-input w-full file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-chalimi-50 file:text-chalimi-700 hover:file:bg-chalimi-100">
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full btn-chalimi">Update Produk</button>
            </div>
        </form>
    </div>
</div>
@endsection
