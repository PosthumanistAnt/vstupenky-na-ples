@props([
    'item',
])

<a href="{{ $item->link }}"
    @if($item->active)
        class="transition border-brand-600 flex items-center pl-4 py-2 bg-brand-50 dark:bg-brand-900 text-brand-600 dark:text-brand-200 group border-l-4"
    @else
        class="transition border-transparent flex items-center pl-4 py-2 text-gray-600 dark:text-gray-400 hover:text-brand-900 dark:hover:text-brand-300 group border-l-4"
    @endif

    @if($item->external) data-turbolink="false" @endif

    {{ $attributes->merge($item->attributes) }}
>
    @svg($item->icon, ['class' => 'mr-4 h-6 w-6 text-brand-400 group-hover:text-brand-600 dark:group-hover:text-brand-300 transition'])

    {{ $item->label }}
</a>
