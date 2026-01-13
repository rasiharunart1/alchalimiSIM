@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-white">Forum Wali Santri</h2>
            <p class="text-chalimi-200">Diskusi, tanya jawab, dan informasi seputar pondok.</p>
        </div>
        <a href="{{ route('threads.create') }}" class="btn-chalimi shadow-lg shadow-chalimi-500/30">
            <i class="fa-solid fa-plus mr-2"></i> Buat Topik Baru
        </a>
    </div>

    <!-- Filters -->
    <div class="flex gap-2 overflow-x-auto pb-2">
        <a href="{{ route('threads.index') }}" class="px-4 py-2 rounded-full glass-panel text-sm font-semibold {{ !request('category') ? 'bg-chalimi-600 text-white border-none' : 'text-gray-200 hover:bg-white/10' }}">
            Semua
        </a>
        <a href="{{ route('threads.index', ['category' => 'Pengumuman']) }}" class="px-4 py-2 rounded-full glass-panel text-sm font-semibold {{ request('category') == 'Pengumuman' ? 'bg-chalimi-600 text-white border-none' : 'text-gray-200 hover:bg-white/10' }}">
            📢 Pengumuman
        </a>
        <a href="{{ route('threads.index', ['category' => 'Parenting']) }}" class="px-4 py-2 rounded-full glass-panel text-sm font-semibold {{ request('category') == 'Parenting' ? 'bg-chalimi-600 text-white border-none' : 'text-gray-200 hover:bg-white/10' }}">
            👨‍👩‍👧‍👦 Parenting
        </a>
        <a href="{{ route('threads.index', ['category' => 'Jual Beli']) }}" class="px-4 py-2 rounded-full glass-panel text-sm font-semibold {{ request('category') == 'Jual Beli' ? 'bg-chalimi-600 text-white border-none' : 'text-gray-200 hover:bg-white/10' }}">
            🛒 Info Jual Beli
        </a>
    </div>

    <!-- Threads List -->
    <div class="space-y-4">
        @forelse($threads as $thread)
            <div class="glass-panel p-6 hover:bg-white/10 transition duration-200">
                <div class="flex items-start gap-4">
                    <div class="relative">
                        <img src="{{ $thread->user->photo ? asset('storage/'.$thread->user->photo) : 'https://ui-avatars.com/api/?name='.urlencode($thread->user->name).'&background=0D9488&color=fff' }}" 
                            class="w-10 h-10 rounded-full object-cover border border-white/20">
                        @if($thread->user->isOnline())
                            <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-chalimi-900 rounded-full" title="Online"></span>
                        @endif
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2 py-0.5 rounded text-xs font-bold 
                                {{ $thread->category == 'Pengumuman' ? 'bg-red-500/20 text-red-200' : 
                                   ($thread->category == 'Parenting' ? 'bg-blue-500/20 text-blue-200' : 'bg-green-500/20 text-green-200') }}">
                                {{ $thread->category }}
                            </span>
                            <span class="text-xs text-chalimi-300">• {{ $thread->created_at->diffForHumans() }}</span>
                        </div>
                        <a href="{{ route('threads.show', $thread) }}" class="flex flex-col md:flex-row gap-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-white mb-1 hover:text-chalimi-300 transition">{{ $thread->title }}</h3>
                                <p class="text-gray-300 text-sm line-clamp-2">{{ Str::limit($thread->body, 150) }}</p>
                            </div>
                            @if($thread->image)
                                <div class="w-full md:w-32 h-20 rounded-xl overflow-hidden shadow-lg border border-white/20">
                                    <img src="{{ asset('storage/'.$thread->image) }}" class="w-full h-full object-cover">
                                </div>
                            @elseif($thread->instagram_url)
                                <div class="w-full md:w-32 h-20 rounded-xl overflow-hidden shadow-lg border border-white/20 bg-gradient-to-tr from-yellow-400 via-pink-500 to-purple-600 flex items-center justify-center text-white">
                                    <i class="fa-brands fa-instagram text-2xl"></i>
                                </div>
                            @endif
                        </a>
                        <div class="flex items-center gap-4 mt-3 text-sm text-chalimi-200">
                            <span><i class="fa-regular fa-user mr-1"></i> {{ $thread->user->name }}</span>
                            <span><i class="fa-regular fa-comment mr-1"></i> {{ $thread->comments->count() }} Balasan</span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="glass-panel p-8 text-center">
                <i class="fa-regular fa-comments text-4xl text-chalimi-400 mb-4"></i>
                <h3 class="text-xl font-bold text-white">Belum ada diskusi</h3>
                <p class="text-chalimi-200">Jadilah yang pertama membuat topik!</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
