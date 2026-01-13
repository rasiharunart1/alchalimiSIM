@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <a href="{{ route('threads.index') }}" class="text-chalimi-300 hover:text-white transition flex items-center gap-2 mb-4">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Forum
    </a>

    <!-- Thread Content -->
    <div class="glass-panel p-8">
        <div class="flex justify-between items-start mb-4">
            <h1 class="text-2xl font-bold text-white leading-tight">{{ $thread->title }}</h1>
            <span class="px-3 py-1 rounded text-xs font-bold bg-white/10 text-white">
                {{ $thread->category }}
            </span>
        </div>
        
        <div class="flex items-center gap-3 mb-6 border-b border-white/10 pb-4">
            <div class="relative">
                <img src="{{ $thread->user->photo ? asset('storage/'.$thread->user->photo) : 'https://ui-avatars.com/api/?name='.urlencode($thread->user->name).'&background=0D9488&color=fff' }}" 
                    class="w-12 h-12 rounded-full object-cover border-2 border-white/20">
                @if($thread->user->isOnline())
                    <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-chalimi-900 rounded-full" title="Online"></span>
                @endif
            </div>
            <div>
                <p class="text-white font-semibold">{{ $thread->user->name }}</p>
                <p class="text-xs text-chalimi-300">{{ $thread->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>

        <div class="prose prose-invert max-w-none text-gray-200 mb-8">
            {!! nl2br(e($thread->body)) !!}
        </div>

        @if($thread->image)
            <div class="my-6 rounded-2xl overflow-hidden border border-white/20 shadow-2xl">
                <img src="{{ asset('storage/'.$thread->image) }}" class="w-full h-auto" alt="{{ $thread->title }}">
            </div>
        @endif

        @if($thread->instagram_url)
            <div class="my-6 flex justify-center">
                <blockquote class="instagram-media" data-instgrm-permalink="{{ $thread->instagram_url }}" data-instgrm-version="14" style="background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);">
                </blockquote>
                <script async src="//www.instagram.com/embed.js"></script>
            </div>
        @endif

        <!-- Reply Form -->
        <form action="{{ route('threads.reply', $thread) }}" method="POST" class="mt-8">
            @csrf
            <h3 class="text-lg font-bold text-white mb-4">Balasan</h3>
            <textarea name="body" rows="3" class="glass-input w-full text-white placeholder-gray-400 mb-3" placeholder="Tulis balasan Anda..." required></textarea>
            <div class="text-right">
                <button type="submit" class="px-6 py-2 bg-chalimi-600 hover:bg-chalimi-500 text-white rounded-lg transition">
                    Kirim Balasan
                </button>
            </div>
        </form>
    </div>

    <!-- Comments List -->
    <div class="space-y-4">
        @foreach($thread->comments as $comment)
            <div class="glass-panel p-6 border-l-4 border-chalimi-500">
                <div class="flex items-start gap-4">
                    <div class="relative">
                        <img src="{{ $comment->user->photo ? asset('storage/'.$comment->user->photo) : 'https://ui-avatars.com/api/?name='.urlencode($comment->user->name).'&background=0F766E&color=fff' }}" 
                            class="w-8 h-8 rounded-full object-cover border border-white/20">
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-bold text-white text-sm">{{ $comment->user->name }}</span>
                            <span class="text-xs text-chalimi-400">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-300 text-sm">{!! nl2br(e($comment->body)) !!}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
