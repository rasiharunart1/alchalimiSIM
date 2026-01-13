@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto h-[calc(100vh-140px)] flex flex-col">
    <!-- Header -->
    <div class="glass-panel p-4 flex items-center gap-4 mb-4">
        <a href="{{ route('messages.index') }}" class="md:hidden text-white hover:text-chalimi-300">
            <i class="fa-solid fa-arrow-left text-xl"></i>
        </a>
        <div class="relative">
            <img src="{{ $user->photo ? asset('storage/'.$user->photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=0D9488&color=fff' }}" 
                class="w-10 h-10 rounded-full object-cover border border-white/20">
            @if($user->isOnline())
                <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-chalimi-900 rounded-full"></span>
            @endif
        </div>
        <div>
            <h2 class="font-bold text-white text-lg">{{ $user->name }}</h2>
            <p class="text-xs text-chalimi-300 flex items-center gap-1">
                @if($user->isOnline())
                    <span class="text-green-400 font-bold">Online</span>
                @else
                    <span class="text-gray-400">Offline • {{ $user->last_seen ? $user->last_seen->diffForHumans() : 'Belum pernah login' }}</span>
                @endif
            </p>
        </div>
    </div>

    <!-- Chat Messages Area -->
    <div id="chat-messages" class="flex-1 glass-panel p-6 overflow-y-auto space-y-4 mb-4 flex flex-col h-full">
        @include('chat.messages')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatContainer = document.getElementById('chat-messages');
            
            // Auto scroll to bottom on load
            chatContainer.scrollTop = chatContainer.scrollHeight;

            setInterval(() => {
                fetch(window.location.href, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    // Check if user is near bottom before replacing to maintain scroll position
                    const isNearBottom = chatContainer.scrollHeight - chatContainer.scrollTop - chatContainer.clientHeight < 100;
                    
                    chatContainer.innerHTML = html;
                    
                    if (isNearBottom) {
                        chatContainer.scrollTop = chatContainer.scrollHeight;
                    }
                });
            }, 3000); // Poll every 3 seconds
        });
    </script>

    <!-- Message Input -->
    <form action="{{ route('messages.store') }}" method="POST" class="glass-panel p-2 flex gap-2">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $user->id }}">
        <input type="text" name="body" class="flex-1 glass-input focus:ring-0" placeholder="Ketik pesan Anda..." required autofocus autocomplete="off">
        <button type="submit" class="w-12 h-12 bg-chalimi-600 hover:bg-chalimi-500 rounded-xl flex items-center justify-center text-white transition shadow-lg shadow-chalimi-600/20">
            <i class="fa-solid fa-paper-plane"></i>
        </button>
    </form>
</div>
@endsection
