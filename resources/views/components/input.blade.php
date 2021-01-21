@props([
    'for',
    'type',
    'placeholder',
    'height'
])
<div class="h-{{ $height }} xl:flex xl:items-center xl:justify-between">
    <input class="
    @if ($errors->has($type))
        bg-blue-400 bg-opacity-20
    @else
        bg-transparent
    @endif
    focus:outline-none p-2 placeholder-gray-700 w-full xl:w-2/3 h-3/5 xl:h-full text-xl xl:text-3xl tracking-widest focus:border-t-4 focus:border-l-4 focus:border-blue-300" 
    placeholder="{{ $placeholder }}" type="{{ $type }}" wire:model.debounce.1000ms="{{ $for }}" name="{{ $for }}">
    @error($for)
        <p class="bg-red-600 text-white text-xl w-full xl:w-1/3 h-2/5 xl:h-full text-center flex items-center justify-center font-bold tracking-widest px-2"> {{ $errors->first($for) }} </p>
    @enderror


</div>