@props([
    'text',
    'livewireFunction',
])
<div>
    <button class="p-6 text-5xl xl:text-8xl tracking-widest font-extrabold hover:text-gray-400" wire:click="{{ $livewireFunction }}"> {{ $text }} </button>
</div>