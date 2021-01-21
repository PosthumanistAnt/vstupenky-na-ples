@props(['text'])

<div>
    <button class="p-6 text-5xl xl:text-8xl tracking-widest font-extrabold hover:text-gray-900" wire:click="login"> {{ $text }} </button>
</div>