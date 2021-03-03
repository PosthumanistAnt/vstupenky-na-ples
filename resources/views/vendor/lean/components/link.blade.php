@props([
    'class' => 'font-medium text-purple-800 hover:text-purple-600 focus:outline-none focus:underline transition',
])

<a {{ $attributes }} class="{{ $class }}">
    {{ $slot }}
</a>
