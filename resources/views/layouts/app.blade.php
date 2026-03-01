<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIM Al-Chalimi') }}</title>
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js & Global Styles -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="text-gray-100 min-h-screen flex flex-col">
    
    <!-- NAVIGATION BAR -->
    <nav class="glass-panel fixed w-full z-50 px-6 py-4 flex justify-between items-center top-0 rounded-none border-t-0 border-x-0">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-chalimi-500 to-chalimi-700 rounded-full flex items-center justify-center text-white font-bold shadow-lg overflow-hidden p-1">
                <img src="{{ asset('images/logo.png') }}" class="w-full h-full object-contain" alt="Logo">
            </div>
            <div>
                <h1 class="font-bold text-lg leading-tight text-white">PPTQH AL CHALIMI SOKARAJA TENGAH</h1>
                <p class="text-xs text-chalimi-300 font-medium tracking-wide">Sistem Informasi Manajemen</p>
            </div>
        </div>
        
        <!-- Desktop Menu -->
        <div class="hidden md:flex gap-6 items-center font-medium text-sm">
            @auth
                <!-- Dashboard Link -->
                @php
                    $dashboardRoute = match(auth()->user()->role) {
                        'admin' => 'admin.dashboard',
                        'wali_santri' => 'wali.dashboard',
                        'ustadz' => 'ustadz.dashboard',
                        'pengurus' => 'pengurus.dashboard',
                        'alumni' => 'welcome',
                        default => 'welcome'
                    };
                @endphp
                <a href="{{ route($dashboardRoute) }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-white/10 text-white transition">
                    <i class="fa-solid fa-gauge-high text-chalimi-300"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Notifications -->
                <div class="relative" x-data="{ 
                    open: false, 
                    unreadCount: {{ auth()->user()->unreadNotifications->count() }},
                    notifications: [],
                    async fetchNotifications() {
                        try {
                            const res = await fetch('{{ route('notifications.fetch') }}');
                            const data = await res.json();
                            this.unreadCount = data.unreadCount;
                            this.notifications = data.notifications;
                        } catch (e) {
                            console.error('Notification fetch failed', e);
                        }
                    }
                }" x-init="fetchNotifications(); setInterval(() => fetchNotifications(), 2000)">
                    <button @click="open = !open" class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-white/10 text-white transition relative">
                        <i class="fa-solid fa-bell text-chalimi-300"></i>
                        <template x-if="unreadCount > 0">
                            <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-600 text-[10px] font-bold text-white border-2 border-[#004d40]" x-text="unreadCount">
                            </span>
                        </template>
                    </button>

                    <!-- Notification Dropdown -->
                    <div x-show="open" @click.away="open = false" 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translateY-4"
                        x-transition:enter-end="opacity-100 translateY-0"
                        class="absolute right-0 mt-3 w-80 glass-panel-dark z-50 p-2 border border-white/10 shadow-2xl animate-fade-in-up"
                        x-cloak>
                        <div class="px-3 py-2 border-b border-white/10 flex justify-between items-center">
                            <span class="text-xs font-bold text-white uppercase tracking-wider">Notifikasi</span>
                            <template x-if="unreadCount > 0">
                                <form action="{{ route('notifications.markAllRead') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-[10px] text-chalimi-300 hover:underline">Tandai semua dibaca</button>
                                </form>
                            </template>
                        </div>
                        <div class="max-h-96 overflow-y-auto custom-scrollbar">
                            <template x-for="n in notifications" :key="n.id">
                                <a :href="n.data.url || '#'" class="block p-3 rounded-lg hover:bg-white/5 transition border-b border-white/5 last:border-0" :class="n.read_at ? 'opacity-60' : ''">
                                    <div class="flex gap-3">
                                        <div class="w-8 h-8 rounded-full bg-chalimi-600/20 flex items-center justify-center text-xl shrink-0">
                                            <i class="fa-solid text-sm text-chalimi-400" :class="n.data.icon || 'fa-bell'"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-white" x-text="n.data.title"></p>
                                            <p class="text-[10px] text-gray-400 mt-0.5 line-clamp-2" x-text="n.data.message"></p>
                                            <p class="text-[9px] text-chalimi-500 mt-1 uppercase" x-text="n.created_at_human"></p>
                                        </div>
                                    </div>
                                </a>
                            </template>
                            
                            <div x-show="notifications.length === 0" class="p-8 text-center">
                                <i class="fa-solid fa-bell-slash text-white/20 text-3xl mb-3 block"></i>
                                <p class="text-xs text-gray-400">Belum ada notifikasi baru</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Role Badge -->
                <span class="px-3 py-1 bg-white/10 text-chalimi-200 rounded-full text-xs font-bold border border-white/20 uppercase">
                    {{ str_replace('_', ' ', auth()->user()->role) }}
                </span>

                <div class="flex items-center gap-3 border-l border-white/10 pl-6 cursor-pointer" onclick="window.location='{{ route('profile.edit') }}'">
                    <div class="text-right">
                        <p class="text-xs font-bold text-white hover:text-chalimi-200 transition">{{ auth()->user()->name }}</p>
                        <button type="button" onclick="event.stopPropagation(); openLogoutModal()" class="text-xs text-red-400 hover:text-red-300 hover:underline">Logout</button>
                    </div>
                    <img src="{{ auth()->user()->photo_url }}" class="w-9 h-9 rounded-full shadow-sm hover:scale-110 transition border border-white/20">
                </div>
            @else
                <a href="/" class="hover:text-chalimi-300 transition text-white">Beranda</a>
                <a href="{{ route('unit_usaha.public') }}" class="hover:text-chalimi-300 transition text-white">Unit Usaha</a>
                <a href="{{ route('register') }}" class="px-5 py-2 glass-panel text-white hover:bg-white/10 transition border-white/20 border">
                    Daftar
                </a>
                <a href="{{ route('login') }}" class="px-5 py-2 bg-chalimi-600 hover:bg-chalimi-700 text-white rounded-full transition shadow-lg shadow-chalimi-500/30">
                    Login App
                </a>
            @endauth
        </div>

        <!-- Mobile Menu Button -->
        <button id="mobile-menu-btn" class="md:hidden text-white text-xl">
            <i class="fa-solid fa-bars"></i>
        </button>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="flex-grow pt-24 pb-10 px-4 container mx-auto">
        
        @if(auth()->check() && !request()->routeIs('welcome'))
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Sidebar (Adapted from User Mockup) -->
                <aside id="sidebar-menu" class="w-full md:w-64 glass-panel p-4 flex-col gap-2 h-fit md:sticky md:top-24 hidden md:flex transition-all duration-300">
                    <div class="flex items-center gap-3 p-4 mb-4 border-b border-white/10">
                        <img src="{{ auth()->user()->photo_url }}" class="w-10 h-10 rounded-full object-cover">
                        <div class="overflow-hidden">
                            <h4 class="font-bold text-sm truncate text-white">{{ auth()->user()->name }}</h4>
                            <p class="text-xs text-chalimi-300 truncate">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</p>
                        </div>
                    </div>
                    
                    <!-- Navigation Links based on Role -->
                    <!-- Common Menu for All Roles -->
                    <div class="mb-4 space-y-1">
                        <p class="px-4 text-xs font-bold text-chalimi-400 uppercase opacity-70 mb-2">Menu Utama</p>
                        
                        <!-- Dashboard Link Based on Role -->
                        @php
                            $dashboardRoute = match(auth()->user()->role) {
                                'admin' => 'admin.dashboard',
                                'wali_santri' => 'wali.dashboard',
                                'ustadz' => 'ustadz.dashboard',
                                'pengurus' => 'pengurus.dashboard',
                                default => 'welcome'
                            };
                        @endphp
                        <a href="{{ route($dashboardRoute) }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs($dashboardRoute) ? 'bg-white/10 text-chalimi-300' : 'text-gray-300 hover:bg-white/5' }}">
                            <i class="fa-solid fa-house w-5 text-center"></i> Dashboard
                        </a>

                        <a href="{{ route('threads.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('threads.*') ? 'bg-white/10 text-chalimi-300' : 'text-gray-300 hover:bg-white/5' }}">
                             <i class="fa-solid fa-users-rectangle w-5 text-center"></i> Forum Diskusi
                        </a>
                        
                        <a href="{{ route('unit_usaha.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('unit_usaha.*') || request()->routeIs('unit-usaha.*') ? 'bg-white/10 text-chalimi-300' : 'text-gray-300 hover:bg-white/5' }}">
                             <i class="fa-solid fa-store w-5 text-center"></i> Unit Usaha
                        </a>

                        <a href="{{ route('messages.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('messages.*') ? 'bg-white/10 text-chalimi-300' : 'text-gray-300 hover:bg-white/5' }}">
                             <i class="fa-regular fa-comments w-5 text-center"></i> Pesan / Chat
                        </a>
                    </div>

                    <!-- Role Specific Menus -->
                    @if(auth()->user()->isAdmin())
                        <p class="px-4 text-xs font-bold text-chalimi-400 uppercase opacity-70 mt-4 mb-2">Administrasi</p>
                        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.users.*') ? 'bg-white/10 text-chalimi-300' : 'text-gray-300 hover:bg-white/5' }}">
                            <i class="fa-solid fa-user-gear w-5 text-center"></i> Manajemen User
                        </a>
                        <a href="{{ route('admin.santri.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.santri.*') ? 'bg-white/10 text-chalimi-300' : 'text-gray-300 hover:bg-white/5' }}">
                            <i class="fa-solid fa-users w-5 text-center"></i> Data Santri
                        </a>
                        <a href="{{ route('admin.pembayaran.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.pembayaran.*') ? 'bg-white/10 text-chalimi-300' : 'text-gray-300 hover:bg-white/5' }}">
                            <i class="fa-solid fa-file-invoice-dollar w-5 text-center"></i> Pembayaran
                        </a>
                        <a href="{{ route('admin.hafalan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.hafalan.*') ? 'bg-white/10 text-chalimi-300' : 'text-gray-300 hover:bg-white/5' }}">
                            <i class="fa-solid fa-book-quran w-5 text-center"></i> Hafalan
                        </a>
                        <a href="{{ route('admin.tokens.index') }}" class="flex items-center gap-3 p-3 rounded-lg {{ request()->routeIs('admin.tokens.*') ? 'bg-chalimi-600 text-white shadow-lg' : 'text-chalimi-700 hover:bg-chalimi-50' }} transition">
                            <i class="fa-solid fa-key w-5"></i>
                            <span class="font-medium">Token Alumni</span>
                        </a>
                        <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 p-3 rounded-lg {{ request()->routeIs('admin.settings.*') ? 'bg-chalimi-600 text-white shadow-lg' : 'text-chalimi-700 hover:bg-chalimi-50' }} transition">
                            <i class="fa-solid fa-gears w-5 text-center"></i> Pengaturan
                        </a>
                    @elseif(auth()->user()->isWali())
                        <p class="px-4 text-xs font-bold text-chalimi-400 uppercase opacity-70 mt-4 mb-2">Akademik</p>
                        <a href="{{ route('wali.hafalan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('wali.hafalan') ? 'bg-white/10 text-chalimi-300' : 'text-gray-300 hover:bg-white/5' }}">
                            <i class="fa-solid fa-book-open w-5 text-center"></i> Data Tahfidz
                        </a>
                        <a href="{{ route('wali.pembayaran') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('wali.pembayaran') ? 'bg-white/10 text-chalimi-300' : 'text-gray-300 hover:bg-white/5' }}">
                            <i class="fa-solid fa-file-invoice-dollar w-5 text-center"></i> Tagihan SPP
                        </a>
                    @elseif(auth()->user()->role === 'ustadz')
                        <p class="px-4 text-xs font-bold text-chalimi-400 uppercase opacity-70 mt-4 mb-2">Akademik</p>
                        <a href="{{ route('ustadz.hafalan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('hafalan.*') || request()->routeIs('ustadz.hafalan.*') ? 'bg-white/10 text-chalimi-300' : 'text-gray-300 hover:bg-white/5' }}">
                            <i class="fa-solid fa-book-open w-5 text-center"></i> Input Hafalan
                        </a>
                    @elseif(auth()->user()->role === 'pengurus')
                        <p class="px-4 text-xs font-bold text-chalimi-400 uppercase opacity-70 mt-4 mb-2">Keuangan</p>
                         <a href="{{ route('pengurus.pembayaran.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('pengurus.pembayaran.index') ? 'bg-white/10 text-chalimi-300' : 'text-gray-300 hover:bg-white/5' }}">
                              <i class="fa-solid fa-file-invoice-dollar w-5 text-center"></i> Data Pembayaran
                         </a>
                         <a href="{{ route('pengurus.pembayaran.verifikasi') }}" class="flex items-center justify-between px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('pengurus.pembayaran.verifikasi') ? 'bg-white/10 text-chalimi-300' : 'text-gray-300 hover:bg-white/5' }}">
                              <div class="flex items-center gap-3">
                                  <i class="fa-solid fa-clipboard-check w-5 text-center"></i> Verifikasi
                              </div>
                              @php
                                  $pendingCount = \App\Models\Pembayaran::where('status', 'pending')->count();
                              @endphp
                              @if($pendingCount > 0)
                                  <span class="px-2 py-0.5 bg-red-600 text-white text-[10px] font-bold rounded-full">{{ $pendingCount }}</span>
                              @endif
                         </a>
                         <a href="{{ route('pengurus.laporan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('pengurus.laporan') ? 'bg-white/10 text-chalimi-300' : 'text-gray-300 hover:bg-white/5' }}">
                              <i class="fa-solid fa-file-lines w-5 text-center"></i> Laporan
                         </a>
                    @endif
 
                     <button type="button" onclick="openLogoutModal()" class="w-full mt-2 flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-red-400 hover:bg-white/5 transition">
                         <i class="fa-solid fa-arrow-right-from-bracket w-5"></i> Logout
                     </button>
                 </aside>
 
                 <!-- Specific Page Content -->
                 <div class="flex-1 space-y-6">
                     @if(session('success'))
                         <div class="glass-panel px-6 py-4 bg-green-900/40 border-green-500/30 text-green-300 flex items-center gap-3 animate-fade-in-up">
                             <i class="fa-solid fa-circle-check text-xl"></i> {{ session('success') }}
                         </div>
                     @endif
 
                     @if(session('error'))
                         <div class="glass-panel px-6 py-4 bg-red-900/40 border-red-500/30 text-red-300 flex items-center gap-3 animate-fade-in-up">
                             <i class="fa-solid fa-triangle-exclamation text-xl"></i> {{ session('error') }}
                         </div>
                     @endif
 
                     @yield('content')
                 </div>
             </div>
         @else
             <!-- Public Content (Landing, Login, etc without sidebar) -->
             @yield('content')
         @endif
 
     </main>
 
     <!-- Footer -->
     <footer class="mt-auto py-6 text-center text-sm text-chalimi-300/60 font-medium">
         &copy; {{ date('Y') }} Developed by @rasiharunart. All rights reserved.
     </footer>

     <!-- Mobile Guest Navigation Menu -->
     @guest
     <div id="mobile-guest-nav" class="fixed top-[4.5rem] inset-x-4 glass-panel-dark p-6 hidden flex-col gap-4 md:hidden z-40 border border-white/10 shadow-2xl backdrop-blur-xl rounded-2xl animate-fade-in-up">
        <a href="/" class="flex items-center gap-4 px-4 py-3 rounded-xl text-base font-medium text-gray-100 hover:bg-white/10 transition border border-transparent hover:border-white/5">
            <div class="w-8 h-8 rounded-full bg-chalimi-600/20 flex items-center justify-center text-chalimi-400">
                <i class="fa-solid fa-house"></i>
            </div>
            Beranda
        </a>
        <a href="{{ route('unit_usaha.public') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-base font-medium text-gray-100 hover:bg-white/10 transition border border-transparent hover:border-white/5">
            <div class="w-8 h-8 rounded-full bg-orange-500/20 flex items-center justify-center text-orange-400">
                <i class="fa-solid fa-store"></i>
            </div>
            Unit Usaha
        </a>
        <div class="border-t border-white/10 my-1"></div>
        <a href="{{ route('register') }}" class="flex items-center gap-2 justify-center px-4 py-3 glass-panel text-white rounded-xl text-base font-bold transition border-white/10">
            <i class="fa-solid fa-user-plus"></i> Daftar Akun
        </a>
        <a href="{{ route('login') }}" class="flex items-center gap-2 justify-center px-4 py-3 bg-chalimi-600 hover:bg-chalimi-500 text-white rounded-xl text-base font-bold shadow-lg shadow-chalimi-600/20 transition transform active:scale-95">
            <i class="fa-solid fa-right-to-bracket"></i> Login Aplikasi
        </a>
     </div>
     @endguest

     <!-- Global Logout Form -->
     <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
         @csrf
     </form>

     <!-- Logout Confirmation Modal -->
     <div id="logout-modal" class="fixed inset-0 z-[60] hidden items-center justify-center">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity opacity-0" id="logout-backdrop"></div>
        
        <!-- Modal Content -->
        <div class="relative glass-panel p-6 w-full max-w-sm mx-4 transform scale-95 opacity-0 transition-all duration-300" id="logout-content">
            <div class="text-center">
                <div class="w-16 h-16 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-4 text-red-500 text-2xl">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Konfirmasi Keluar</h3>
                <p class="text-chalimi-200 text-sm mb-6">Apakah Anda yakin ingin mengakhiri sesi ini? Anda harus login kembali untuk mengakses aplikasi.</p>
                
                <div class="flex gap-3 justify-center">
                    <button type="button" onclick="closeLogoutModal()" class="px-5 py-2.5 rounded-xl glass-input text-gray-300 hover:text-white hover:bg-white/10 transition font-medium text-sm">
                        Batal
                    </button>
                    <button type="button" onclick="document.getElementById('logout-form').submit()" class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white shadow-lg shadow-red-600/20 transition font-bold text-sm">
                        Ya, Keluar
                    </button>
                </div>
            </div>
        </div>
     </div>

     <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('mobile-menu-btn');

            const sidebar = document.getElementById('sidebar-menu'); // Auth users
            const guestNav = document.getElementById('mobile-guest-nav'); // Guest users

            if(btn) {
                btn.addEventListener('click', function() {
                    // If sidebar exists (Auth user), toggle it
                    if(sidebar) {
                        sidebar.classList.toggle('hidden');
                        sidebar.classList.toggle('flex');
                    }
                    
                    // If guest nav exists (Guest user), toggle it
                    if(guestNav) {
                        guestNav.classList.toggle('hidden');
                        guestNav.classList.toggle('flex');
                    }
                });
            }
        });

        // Logout Modal Functions
        function openLogoutModal() {
            const modal = document.getElementById('logout-modal');
            const backdrop = document.getElementById('logout-backdrop');
            const content = document.getElementById('logout-content');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Small delay for animation
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeLogoutModal() {
            const modal = document.getElementById('logout-modal');
            const backdrop = document.getElementById('logout-backdrop');
            const content = document.getElementById('logout-content');
            
            backdrop.classList.add('opacity-0');
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 300);
        }
     </script>
     <script async src="https://www.instagram.com/embed.js"></script>
     <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.instgrm) {
                window.instgrm.Embeds.process();
            }
        });
        window.addEventListener('load', function() {
            if (window.instgrm) {
                window.instgrm.Embeds.process();
            }
        });
     </script>
 </body>
</html>
