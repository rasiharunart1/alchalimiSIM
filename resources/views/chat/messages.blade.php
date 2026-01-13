@foreach($messages as $message)
    <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start items-end gap-2' }}">
        @if($message->sender_id !== auth()->id())
            <img src="{{ $message->sender->photo ? asset('storage/'.$message->sender->photo) : 'https://ui-avatars.com/api/?name='.urlencode($message->sender->name).'&background=0D9488&color=fff' }}" 
                 class="w-6 h-6 rounded-full object-cover mb-1 shadow-sm">
        @endif
        <div class="max-w-[80%] rounded-2xl px-5 py-3 
            {{ $message->sender_id === auth()->id() 
                ? 'bg-chalimi-600 text-white rounded-br-none' 
                : 'bg-white/10 text-white rounded-bl-none' }}">
            <p class="text-sm font-sans">{{ $message->body }}</p>
            <p class="text-[10px] mt-1 opacity-70 {{ $message->sender_id === auth()->id() ? 'text-chalimi-200' : 'text-gray-400' }} flex justify-end items-center gap-1">
                {{ $message->created_at->format('H:i') }}
                @if($message->sender_id === auth()->id())
                    <i class="fa-solid fa-check-double {{ $message->is_read ? 'text-blue-300' : '' }}"></i>
                @endif
            </p>
        </div>
    </div>
@endforeach

@if($messages->isEmpty())
     <div class="flex-1 flex flex-col items-center justify-center text-chalimi-400 h-full min-h-[200px]">
        <i class="fa-regular fa-comment-dots text-4xl mb-2"></i>
        <p>Belum ada pesan. Sapa sekarang!</p>
     </div>
@endif
