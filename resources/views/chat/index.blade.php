@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="glass-panel p-6">
        <h2 class="text-2xl font-bold text-white mb-2">Pesan & Chat</h2>
        <p class="text-chalimi-200">Mulai percakapan dengan sesama wali santri, ustadz, atau pengurus.</p>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <!-- Sidebar Contact List (Mobile Friendly) -->
        <div class="glass-panel p-4 md:col-span-1 h-fit">
            <h3 class="font-bold text-white mb-4 px-2">Daftar Kontak</h3>
            <div class="space-y-2">
                @foreach($users as $user)
                    <a href="{{ route('messages.show', $user->id) }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/10 transition group">
                        <div class="relative">
                            <img src="{{ $user->photo ? asset('storage/'.$user->photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=0D9488&color=fff' }}" 
                                class="w-10 h-10 rounded-full object-cover border border-white/20">
                            <!-- Online Status Indicator -->
                            @if($user->isOnline())
                                <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-chalimi-800 rounded-full" title="Online"></div>
                            @endif
                        </div>
                        <div class="flex-1 overflow-hidden">
                            <h4 class="text-white font-medium text-sm truncate group-hover:text-chalimi-300 transition">{{ $user->name }}</h4>
                            <p class="text-xs text-chalimi-400 truncate">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Initial Placeholder State -->
        <div class="glass-panel p-10 md:col-span-2 flex flex-col items-center justify-center text-center min-h-[400px]">
            <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mb-4">
                <i class="fa-regular fa-paper-plane text-3xl text-chalimi-400"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Pilih kontak untuk mulai chat</h3>
            <p class="text-chalimi-300 max-w-sm">Anda dapat berdiskusi secara pribadi dengan aman di sini.</p>
        </div>
    </div>
</div>
@endsection
