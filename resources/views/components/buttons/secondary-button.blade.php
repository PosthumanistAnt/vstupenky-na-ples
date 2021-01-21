@props(['text'])

<div>
    <button class="p-6 text-4xl xl:text-7xl tracking-widest font-extrabold hover:text-gray-900" wire:click="register"> {{ $text }} </button>
</div>