@props(['active' => false, 'icon' => ''])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-3 px-4 py-3 rounded-xl bg-white/20 text-white shadow-lg backdrop-blur-sm border border-white/20 transition-all duration-200'
            : 'flex items-center gap-3 px-4 py-3 rounded-xl text-chalimi-100 hover:bg-white/10 hover:text-white transition-all duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <span class="text-lg opacity-80">
        @if($icon == 'users') 👥
        @elseif($icon == 'credit-card') 💳
        @elseif($icon == 'book-open') 📖
        @elseif($icon == 'home') 🏠
        @elseif($icon == 'book') 📚
        @else {{ $icon }}
        @endif
    </span>
    <span class="font-medium text-sm">{{ $slot }}</span>
</a>
