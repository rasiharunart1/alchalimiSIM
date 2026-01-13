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
                
                <div class="relative w-full max-w-md aspect-square glass-panel rounded-[2.5rem] p-8 flex items-center justify-center border-2 border-white/50 shadow-2xl overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-tr from-chalimi-500/10 to-transparent group-hover:scale-110 transition-transform duration-700"></div>
                    <i class="fa-solid fa-mosque text-[12rem] text-chalimi-600/10 absolute"></i>
                    
                    <div class="relative z-10 w-full space-y-6">
                        @foreach($recentThreads->where('category', 'Pengumuman')->take(2) as $index => $thread)
                        <div class="glass-panel p-5 rounded-2xl flex items-center gap-4 animate-float" style="animation-delay: {{ $index * 0.5 }}s">
                            <div class="w-12 h-12 bg-chalimi-100 rounded-full flex items-center justify-center text-chalimi-600 shadow-inner">
                                <i class="fa-solid {{ $index % 2 == 0 ? 'fa-bullhorn' : 'fa-check' }}"></i>
                            </div>
                            <div class="text-left flex-1 min-w-0">
                                <p class="text-[10px] text-chalimi-600 font-bold uppercase tracking-wider">Update Terkini</p>
                                <p class="font-bold text-sm text-chalimi-900 truncate">{{ $thread->title }}</p>
                            </div>
                        </div>
                        @endforeach
                        
                        @if($recentThreads->where('category', 'Pengumuman')->count() == 0)
                            <div class="text-center py-10">
                                <div class="w-16 h-16 bg-chalimi-50 rounded-full flex items-center justify-center text-chalimi-300 mx-auto mb-4">
                                    <i class="fa-solid fa-moon text-3xl"></i>
                                </div>
                                <p class="text-chalimi-600 font-medium">Belum ada pengumuman terbaru</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Glassmorphism Divider -->
        <div class="mt-24 h-px w-full bg-gradient-to-r from-transparent via-white/20 to-transparent backdrop-blur-sm"></div>

        <!-- Section: Info Update Terkini (Threads) -->
        <div class="mt-24 space-y-12">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div class="space-y-2">
                    <h2 class="text-3xl font-bold text-chalimi-900">Update Terkini</h2>
                    <p class="text-chalimi-600">Berita, pengumuman, dan aktivitas terbaru di pesantren.</p>
                </div>
                <a href="{{ route('threads.index') }}" class="text-chalimi-600 font-bold hover:text-chalimi-800 flex items-center gap-2 transition group">
                    Lihat Semua Forum <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($recentThreads as $thread)
                <div class="glass-panel flex flex-col rounded-3xl overflow-hidden border-white/50 border hover:shadow-2xl transition duration-500 group h-full">
                    @if($thread->image)
                        <div class="h-48 overflow-hidden relative">
                            <img src="{{ asset('storage/'.$thread->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700" alt="{{ $thread->title }}">
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 bg-white/90 backdrop-blur-md rounded-full text-[10px] font-black uppercase text-chalimi-700 shadow-sm">
                                    {{ $thread->category }}
                                </span>
                            </div>
                        </div>
                    @elseif($thread->instagram_url)
                         <div class="h-64 overflow-hidden relative flex items-center justify-center bg-gray-50 border-b border-white/20">
                            {{-- Placeholder for IG Embed (The actual embed usually needs more height, but we preview it) --}}
                            <div class="text-center p-6 grayscale group-hover:grayscale-0 transition duration-500">
                                <i class="fa-brands fa-instagram text-4xl text-pink-600 mb-2"></i>
                                <p class="text-xs text-gray-500 font-medium">Klik untuk melihat konten Instagram</p>
                            </div>
                            <div class="absolute inset-0 bg-transparent flex items-center justify-center z-10 cursor-pointer" onclick="window.location='{{ route('threads.show', $thread) }}'"></div>
                         </div>
                    @else
                        <div class="h-4 w-full bg-gradient-to-r from-chalimi-500 to-emerald-400"></div>
                    @endif

                    <div class="p-6 flex flex-col flex-1">
                        @if(!$thread->image)
                            <span class="text-[10px] font-black uppercase text-chalimi-500 tracking-widest mb-2">{{ $thread->category }}</span>
                        @endif
                        <h3 class="text-xl font-bold text-chalimi-900 group-hover:text-chalimi-600 transition truncate-2-lines mb-3">
                            <a href="{{ route('threads.show', $thread) }}">{{ $thread->title }}</a>
                        </h3>
                        <p class="text-sm text-chalimi-800/70 line-clamp-3 mb-6 flex-1">
                            {{ Str::limit($thread->body, 120) }}
                        </p>
                        <div class="flex items-center justify-between mt-auto pt-4 border-t border-chalimi-100">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-chalimi-100 flex items-center justify-center text-xs text-chalimi-600 font-bold border-2 border-white shadow-sm">
                                    {{ substr($thread->user->name, 0, 1) }}
                                </div>
                                <span class="text-xs font-medium text-chalimi-700">{{ $thread->user->name }}</span>
                            </div>
                            <span class="text-[10px] text-chalimi-400 font-bold">{{ $thread->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Glassmorphism Divider -->
        <div class="mt-32 h-px w-full bg-gradient-to-r from-transparent via-white/20 to-transparent backdrop-blur-sm"></div>

        <!-- Section: Unit Usaha -->
        <div id="unit-usaha" class="mt-32 space-y-12">
            <div class="text-center space-y-2">
                <h2 class="text-3xl md:text-5xl font-bold text-chalimi-900">Unit Usaha</h2>
                <p class="text-chalimi-600 max-w-2xl mx-auto italic">Dukung kemandirian pondok dengan berbelanja di unit usaha resmi Al Chalimi.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($unitUsahas as $unit)
                <div class="glass-panel p-4 rounded-[2rem] border-white/60 border hover:shadow-xl transition group">
                    <div class="aspect-square rounded-2xl overflow-hidden mb-4 relative shadow-inner">
                        <img src="{{ asset('storage/'.$unit->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700" alt="{{ $unit->name }}">
                        @if($unit->price > 0)
                            <div class="absolute bottom-3 right-3 px-3 py-1 bg-chalimi-600 text-white rounded-lg text-sm font-bold shadow-lg">
                                Rp {{ number_format($unit->price, 0, ',', '.') }}
                            </div>
                        @endif
                    </div>
                    <div class="px-2">
                        <h4 class="font-bold text-chalimi-900 text-lg">{{ $unit->name }}</h4>
                        <p class="text-xs text-chalimi-600 line-clamp-2 mt-1">{{ $unit->description }}</p>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $unit->contact_number) }}" class="mt-4 flex items-center justify-center gap-2 w-full py-2 bg-green-500 hover:bg-green-600 text-white rounded-xl text-sm font-bold transition shadow-md shadow-green-500/20">
                            <i class="fa-brands fa-whatsapp"></i> Hubungi Toko
                        </a>
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
                <div>
                     <h2 class="text-4xl font-bold text-white">Galeri Pesantren</h2>
                     <p class="text-chalimi-300 mt-2">Momen Berharga & Dokumentasi Kegiatan Santri</p>
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
                            <blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="{{ $item['permalink'] }}" data-instgrm-version="14" style="background:#FFF; border:0; border-radius:12px; margin: 1px; width:calc(100% - 2px);">
                                <div style="padding:16px;">
                                    <a href="{{ $item['permalink'] }}" target="_blank" style="background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;">
                                        <p style="color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px;">Loading post from Instagram...</p>
                                    </a>
                                </div>
                            </blockquote>
                        </div>
                    @endforeach
                </div>
                <script async src="https://www.instagram.com/embed.js"></script>
                <script>
                    window.addEventListener('load', function() {
                        if (window.instgrm) {
                            window.instgrm.Embeds.process();
                        }
                    });
                </script>
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

    <!-- Instagram Embed Script -->
    <script async src="//www.instagram.com/embed.js"></script>

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
            50% { transform: translateY(-10px); }
        }
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
    </style>
@endsection
