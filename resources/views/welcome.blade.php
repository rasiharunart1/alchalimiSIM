@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="animate-fade-in-up mt-8">
        <div class="flex flex-col md:flex-row items-center gap-10">
            <div class="md:w-1/2 space-y-6">
                <span class="inline-block px-4 py-1 rounded-full bg-chalimi-100 text-chalimi-700 text-xs font-bold border border-chalimi-200">
                    PP Tahfidzul Quran Al Chalimi
                </span>
                <h1 class="text-5xl md:text-7xl font-bold text-chalimi-900 leading-tight">
                    {{ \App\Models\Setting::get('welcome_title', 'Membangun Generasi') }} <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-chalimi-600 to-emerald-400">
                        {{ \App\Models\Setting::get('welcome_subtitle', "Qur'ani & Berakhlak") }}
                    </span>
                </h1>
                <p class="text-lg text-chalimi-800/80 leading-relaxed max-w-lg">
                    {{ \App\Models\Setting::get('welcome_description', 'Sistem terintegrasi untuk memantau hafalan santri, administrasi, dan perkembangan akhlak secara real-time dan transparan.') }}
                </p>
                <div class="flex gap-4 pt-4">
                    <a href="{{ route('register') }}" class="px-8 py-3 bg-chalimi-600 text-white rounded-xl font-semibold shadow-lg shadow-chalimi-600/30 hover:scale-105 transition transform">
                        Daftar Santri Baru
                    </a>
                    <a href="#unit-usaha" class="px-8 py-3 glass-panel text-chalimi-700 rounded-xl font-semibold hover:bg-white/80 transition inline-block text-center border-white/50 border">
                        Explore Unit Usaha
                    </a>
                </div>
            </div>
            
            <div class="md:w-1/2 flex justify-center relative">
                <div class="absolute -z-10 w-64 h-64 bg-chalimi-300/30 rounded-full blur-3xl -top-10 -right-10"></div>
                <div class="absolute -z-10 w-64 h-64 bg-emerald-300/20 rounded-full blur-3xl -bottom-10 -left-10"></div>
                
                <div class="relative w-full max-w-md glass-panel rounded-[2.5rem] p-8 flex items-center justify-center border-2 border-white/50 shadow-2xl overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-tr from-chalimi-500/10 to-transparent group-hover:scale-110 transition-transform duration-700"></div>
                    <i class="fa-solid fa-mosque text-[10rem] text-chalimi-600/10 absolute top-4 right-4"></i>
                    
                    <div class="relative z-10 w-full space-y-3">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                            <p class="text-[10px] text-chalimi-600 font-black uppercase tracking-widest">Update Terkini</p>
                        </div>

                        @php $bubbleThreads = $recentThreads->take(3); $icons = ['fa-bullhorn','fa-star','fa-newspaper']; @endphp
                        @forelse($bubbleThreads as $index => $thread)
                        <a href="{{ route('threads.show', $thread) }}" 
                           class="glass-panel p-4 rounded-2xl flex items-center gap-3 animate-float hover:bg-white/70 transition duration-300 group/item" 
                           style="animation-delay: {{ $index * 0.4 }}s; display:flex;">
                            <div class="w-10 h-10 bg-chalimi-100 rounded-full flex items-center justify-center text-chalimi-600 shadow-inner flex-shrink-0">
                                <i class="fa-solid {{ $icons[$index % 3] }} text-sm"></i>
                            </div>
                            <div class="text-left flex-1 min-w-0">
                                <p class="text-[9px] text-chalimi-500 font-bold uppercase tracking-wider">{{ $thread->category }} &middot; {{ $thread->created_at->diffForHumans() }}</p>
                                <p class="font-bold text-xs text-chalimi-900 truncate group-hover/item:text-chalimi-600 transition">{{ $thread->title }}</p>
                            </div>
                            <i class="fa-solid fa-chevron-right text-[10px] text-chalimi-400 group-hover/item:translate-x-1 transition-transform flex-shrink-0"></i>
                        </a>
                        @empty
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-chalimi-50 rounded-full flex items-center justify-center text-chalimi-300 mx-auto mb-4">
                                    <i class="fa-solid fa-moon text-3xl"></i>
                                </div>
                                <p class="text-chalimi-600 font-medium text-sm">Belum ada update terbaru</p>
                            </div>
                        @endforelse

                        @if($recentThreads->count() > 0)
                        <div class="text-center pt-2">
                            <a href="{{ route('threads.index') }}" class="text-[10px] font-bold text-chalimi-500 hover:text-chalimi-700 transition uppercase tracking-widest">
                                Lihat semua forum &rarr;
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Glassmorphism Divider -->
        <div class="mt-24 h-px w-full bg-gradient-to-r from-transparent via-white/20 to-transparent backdrop-blur-sm"></div>

        <!-- Section: Unit Usaha -->
        <div id="unit-usaha" class="mt-24 space-y-12">
            <div class="text-center space-y-2">
                <h2 class="text-3xl md:text-5xl font-bold text-chalimi-900">Unit Usaha</h2>
                <p class="text-chalimi-600 max-w-2xl mx-auto italic">Dukung kemandirian pondok dengan berbelanja di unit usaha resmi Al Chalimi.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($unitUsahas as $unit)
                <div class="glass-panel overflow-hidden group flex flex-col h-full">
                    <div class="relative bg-chalimi-800/50">
                        @if($unit->instagram_url)
                            <div class="w-full flex items-center justify-center">
                                <blockquote class="instagram-media" data-instgrm-permalink="{{ $unit->instagram_url }}" data-instgrm-version="14" style="width: 100%; border:0; margin:0; padding:0;">
                                    <div style="padding:16px;"> 
                                        <a href="{{ $unit->instagram_url }}" target="_blank" style="color: #666; font-family: sans-serif; font-size: 14px; text-decoration: none;">Loading Instagram...</a>
                                    </div>
                                </blockquote>
                            </div>
                        @elseif($unit->image)
                            <div class="h-64 overflow-hidden">
                                <img src="{{ asset('storage/' . $unit->image) }}" alt="{{ $unit->name }}" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="flex items-center justify-center h-64 text-chalimi-200">
                                <i class="fa-solid fa-store text-4xl opacity-20"></i>
                            </div>
                        @endif
                        
                        @if($unit->status !== 'available')
                            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-10">
                                <span class="px-4 py-2 bg-red-500 text-white text-xs font-bold rounded-full uppercase tracking-widest">
                                    {{ $unit->status === 'out_of_stock' ? 'Habis' : 'Tutup' }}
                                </span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-6 space-y-4 flex flex-col flex-grow">
                        <div class="space-y-1">
                            <h3 class="text-xl font-bold text-chalimi-900 line-clamp-1">{{ $unit->name }}</h3>
                            <p class="text-chalimi-600 text-sm line-clamp-2">{{ $unit->description }}</p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-2 mt-auto">
                            @if($unit->show_price)
                                <span class="text-2xl font-black text-chalimi-900">Rp {{ number_format($unit->price, 0, ',', '.') }}</span>
                            @else
                                <span class="text-sm font-bold text-chalimi-600 italic">Tanyakan Harga</span>
                            @endif
                            <a href="https://wa.me/{{ $unit->contact_number }}?text=Halo,%20saya%20tertarik%20dengan%20produk%20{{ urlencode($unit->name) }}{{ !$unit->show_price ? '.%20Boleh%20tahu%20harganya?' : '' }}" 
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

        <!-- Glassmorphism Divider -->
        <div class="mt-32 h-px w-full bg-gradient-to-r from-transparent via-white/20 to-transparent backdrop-blur-sm"></div>

        <!-- Section: Galeri -->
        <div class="mt-32 bg-chalimi-900 -mx-4 md:-mx-12 px-4 md:px-12 py-24 rounded-[3rem] text-white">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
                <!--<div>-->
                <!--     <h2 class="text-4xl font-bold text-white">Galeri Pesantren</h2>-->
                <!--     <p class="text-chalimi-300 mt-2">Momen Berharga & Dokumentasi Kegiatan Santri</p>-->
                <!--</div>-->
                <div class="text-center space-y-2">
                <h2 class="text-3xl md:text-5xl font-bold text-chalimi-900">Galeri Pesantren</h2>
                <p class="text-chalimi-600 max-w-2xl mx-auto italic">Momen Berharga & Dokumentasi Kegiatan Santri.</p>
            </div>
                <div class="flex gap-2">
                     <span class="w-12 h-1 bg-chalimi-600 rounded-full"></span>
                     <span class="w-4 h-1 bg-white/20 rounded-full"></span>
                </div>
            </div>

            @php
                $isManualGallery = count($galleryItems) > 0 && isset($galleryItems[0]['is_manual']);
            @endphp

            @if($isManualGallery)
                <div class="flex gap-6 overflow-x-auto pb-8 scrollbar-hide snap-x">
                    @foreach($galleryItems as $item)
                        <div class="min-w-[326px] max-w-[400px] snap-center bg-white rounded-2xl overflow-hidden shadow-xl">
                            <blockquote class="instagram-media" data-instgrm-permalink="{{ $item['permalink'] }}" data-instgrm-version="14" style="background:#FFF; border:0; border-radius:12px; margin: 1px; width:calc(100% - 2px);">
                                <div style="padding:16px;">
                                    <a href="{{ $item['permalink'] }}" target="_blank" style="background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;">
                                        <p style="color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px;">Loading post from Instagram...</p>
                                    </a>
                                </div>
                            </blockquote>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    @forelse($galleryItems as $index => $item)
                        <div class="aspect-square rounded-2xl overflow-hidden relative group cursor-pointer {{ $index == 0 ? 'md:col-span-2 md:row-span-2' : '' }}">
                            @php
                                $isThread = $item instanceof \App\Models\Thread;
                                $imgUrl = $isThread ? ($item->image ? asset('storage/'.$item->image) : null) : ($item['media_url'] ?? null);
                                $permalink = $isThread ? route('threads.show', $item) : ($item['permalink'] ?? '#');
                                $caption = $isThread ? $item->title : ($item['caption'] ?? 'Instagram Post');
                            @endphp
                            @if($imgUrl)
                                <img src="{{ $imgUrl }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700" alt="Galeri" referrerpolicy="no-referrer">
                            @else
                                <div class="w-full h-full bg-chalimi-800 flex items-center justify-center">
                                    <i class="fa-brands fa-instagram text-4xl text-white/20"></i>
                                </div>
                            @endif
                            <a href="{{ $permalink }}" target="_blank" class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-6">
                                <p class="text-white font-bold text-sm line-clamp-2">{{ $caption }}</p>
                                <p class="text-xs text-chalimi-300">
                                    {{ $isThread ? 'View Thread' : 'View on Instagram' }}
                                </p>
                            </a>
                        </div>
                    @empty
                        @for($i = 1; $i <= 5; $i++)
                            <div class="aspect-square rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-white/20">
                                <i class="fa-solid fa-image text-3xl"></i>
                            </div>
                        @endfor
                    @endforelse
                </div>
            @endif
            
            <div class="mt-12 text-center">
                 @if($igUsername)
                 <a href="https://instagram.com/{{ $igUsername }}" target="_blank" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-tr from-yellow-400 via-pink-500 to-purple-600 text-white rounded-xl font-bold shadow-lg hover:scale-105 transition transform">
                     <i class="fa-brands fa-instagram text-xl"></i> Lihat Selengkapnya di &#64;{{ $igUsername }}
                 </a>
                 @else
                 <p class="text-chalimi-400 text-sm">Follow Instagram kami untuk update harian.</p>
                 @endif
            </div>
        </div>

    </section>

    <style>
        .truncate-2-lines {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
    </style>
@endsection