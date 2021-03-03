@php($tag = $attributes->get('href') ? 'a' : 'button')
@php($attributes = $tag === 'a' ? $attributes : $attributes->merge(['type' => 'button']))

<button
    type="button"
    class="focus:outline-none focus:bg-gray-100 w-full text-left bg-white hover:bg-gray-100 hover:text-gray-900 py-2.5 px-4 text-gray-700 text-sm"
    {{ $attributes }}
>
    {{ $slot }}
</button>
