@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-end">
        <div>
            <h2 class="text-3xl font-bold text-white">Unit Usaha Al-Chalimi</h2>
            <p class="text-chalimi-200">Belanja berkah, dukung kemandirian ekonomi pondok pesantren.</p>
        </div>
        @if(auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('admin.unit-usaha.create') }}" class="btn-chalimi">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Produk
            </a>
        @endif
    </div>

    <!-- Products Grid - Updated to match landing page style -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
        <div class="glass-panel overflow-hidden group flex flex-col h-full">
            
            @if(auth()->check() && auth()->user()->role === 'admin')
                <div class="absolute top-2 left-2 z-10 flex gap-2">
                    <a href="{{ route('admin.unit-usaha.edit', $product) }}" class="w-8 h-8 rounded-full bg-white/20 backdrop-blur hover:bg-white/40 flex items-center justify-center text-white transition">
                        <i class="fa-solid fa-pen text-xs"></i>
                    </a>
                    <form action="{{ route('admin.unit-usaha.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-8 h-8 rounded-full bg-red-500/80 backdrop-blur hover:bg-red-600 flex items-center justify-center text-white transition">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </form>
                </div>
            @endif
            
            <div class="relative bg-chalimi-800/50">
                @if($product->instagram_url)
                    <div class="w-full flex items-center justify-center">
                        <blockquote class="instagram-media" data-instgrm-permalink="{{ $product->instagram_url }}" data-instgrm-version="14" style="width: 100%; border:0; margin:0; padding:0;">
                            <div style="padding:16px;"> 
                                <a href="{{ $product->instagram_url }}" target="_blank" style="color: #666; font-family: sans-serif; font-size: 14px; text-decoration: none;">Loading Instagram...</a>
                            </div>
                        </blockquote>
                    </div>
                @elseif($product->image)
                    <div class="h-64 overflow-hidden">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="flex items-center justify-center h-64 text-chalimi-200">
                        <i class="fa-solid fa-store text-4xl opacity-20"></i>
                    </div>
                @endif
                
                @if($product->status !== 'available')
                    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-10">
                        <span class="px-4 py-2 bg-red-500 text-white text-xs font-bold rounded-full uppercase tracking-widest">
                            {{ $product->status === 'out_of_stock' ? 'Habis' : 'Tutup' }}
                        </span>
                    </div>
                @endif
            </div>
            
            <div class="p-6 space-y-4 flex flex-col flex-grow">
                <div class="space-y-1">
                    <h3 class="text-xl font-bold text-chalimi-900 line-clamp-1">{{ $product->name }}</h3>
                    <p class="text-chalimi-600 text-sm line-clamp-2">{{ $product->description }}</p>
                </div>
                
                <div class="flex items-center justify-between pt-2 mt-auto">
                    @if($product->show_price)
                        <span class="text-2xl font-black text-chalimi-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    @else
                        <span class="text-sm font-bold text-chalimi-600 italic">Tanyakan Harga</span>
                    @endif
                    <a href="https://wa.me/{{ $product->contact_number }}?text=Halo,%20saya%20tertarik%20dengan%20produk%20{{ urlencode($product->name) }}{{ !$product->show_price ? '.%20Boleh%20tahu%20harganya?' : '' }}" 
                       target="_blank"
                       class="w-12 h-12 bg-emerald-500 hover:bg-emerald-400 text-white rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20 transition-all transform hover:scale-110 active:scale-95">
                        <i class="fa-brands fa-whatsapp text-xl"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection