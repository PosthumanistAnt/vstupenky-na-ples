@props([
    'for',
    'type',
    'placeholder',
    'height'
])
<div class="h-{{ $height }} xl:flex xl:items-center xl:justify-between">
    <input class="
    @if ($errors->has($for))
        bg-blue-800 bg-opacity-20
    @else
        bg-transparent
    @endif
    focus:outline-none p-2 placeholder-gray-700 w-full xl:w-2/3 h-1/2 xl:h-full text-xl xl:text-3xl tracking-widest" 
    placeholder="{{ $placeholder }}" type="{{ $type }}" wire:model.lazy="{{ $for }}" name="{{ $for }}">
    @error($for)
        <p class="bg-red-700 text-white text-lg w-full xl:w-1/3 h-1/2 xl:h-full text-center flex items-center justify-center font-bold tracking-widest px-2"> {{ $errors->first($for) }} </p>
    @enderror
</div>