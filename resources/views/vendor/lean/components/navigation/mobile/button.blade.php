@props([
    'icon' => 'heroicon-o-plus',
    'class' => 'flex justify-center relative',
])

@php($tag = $attributes->get('href') ? 'a' : 'button')

<{{ $tag }}
    type
    class="{{ $class }}" {{ $attributes }}
>
    <div class="bg-brand-600 text-white text-2xl rounded-full w-14 h-14 flex justify-center items-center z-10 bottom-0 absolute">
        @if($slot->isNotEmpty())
            {{ $slot }}
        @else
            @svg($icon, ['class' => 'h-6 w-6'])
        @endif
    </div>
</{{ $tag }}>
