@props([
    'expanded',
    'name',
])

<div
    @click="expanded = ! expanded"
    class="pl-5 text-xs text-gray-500 group uppercase font-bold tracking-wide flex justify-between items-center cursor-pointer"
    x-ref="toggle"
>
    <span class="transition group-hover:text-gray-700 dark:group-hover:text-gray-400">
        {{ $name }}
    </span>

    <div x-show="expanded" @if(! $expanded) x-cloak @endif>
        @svg('heroicon-s-chevron-down', ['class' => 'h-5 w-5 text-gray-500 transition group-hover:text-gray-700 dark:group-hover:text-gray-400'])
    </div>

    <div x-show="! expanded" @if($expanded) x-cloak @endif>
        @svg('heroicon-s-chevron-up', ['class' => 'h-5 w-5 text-gray-500 transition group-hover:text-gray-700 dark:group-hover:text-gray-400'])
    </div>
</div>
