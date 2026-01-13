@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-end">
        <div>
            <h2 class="text-3xl font-bold text-white">Unit Usaha Al-Chalimi</h2>
            <p class="text-chalimi-200">Belanja berkah, dukung kemandirian ekonomi pondok pesantren.</p>
        </div>
        @if(auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('unit-usaha.create') }}" class="btn-chalimi">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Produk
            </a>
        @endif
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
        <div class="glass-panel overflow-hidden group relative">
            
            @if(auth()->check() && auth()->user()->role === 'admin')
                <div class="absolute top-2 left-2 z-10 flex gap-2">
                    <a href="{{ route('unit-usaha.edit', $product) }}" class="w-8 h-8 rounded-full bg-white/20 backdrop-blur hover:bg-white/40 flex items-center justify-center text-white transition">
                        <i class="fa-solid fa-pen text-xs"></i>
                    </a>
                    <form action="{{ route('unit-usaha.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-8 h-8 rounded-full bg-red-500/80 backdrop-blur hover:bg-red-600 flex items-center justify-center text-white transition">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </form>
                </div>
            @endif
            <div class="h-48 bg-gray-600 relative overflow-hidden">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                @else
                   <div class="absolute inset-0 bg-chalimi-800 flex items-center justify-center text-white/20 text-5xl">
                        <i class="fa-solid fa-box"></i>
                    </div> 
                @endif
            </div>
            <div class="p-5">
                <h3 class="text-lg font-bold text-white mb-1">{{ $product->name }}</h3>
                <p class="text-chalimi-300 text-sm mb-3 line-clamp-2">{{ $product->description }}</p>
                <div class="flex justify-between items-end">
                    <div>
                        <p class="text-xs text-chalimi-400">Harga</p>
                        <p class="text-xl font-bold text-white">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                    <a href="https://wa.me/{{ $product->contact_number }}?text=Halo,%20saya%20tertarik%20membeli%20{{ $product->name }}" target="_blank" class="w-10 h-10 rounded-full bg-green-500 hover:bg-green-400 flex items-center justify-center text-white transition shadow-lg shadow-green-500/30">
                        <i class="fa-brands fa-whatsapp text-lg"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
