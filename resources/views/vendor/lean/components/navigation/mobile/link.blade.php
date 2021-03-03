@php($page = $attributes->get('page'))
@php($resource = $attributes->get('resource'))

@props([
    'icon' => $page
        ? Lean::$pages[$page]::icon()
        : ($resource
            ? Lean::$resources[$resource]::icon()
            : 'heroicon-o-ban'),
    'href' => $page
        ? route('lean.page', $page)
        : ($resource
            ? route('lean.resource.index', $resource)
            : '#'),
    'class' => ($attributes->get('active') || (
        ($resource && Lean::isCurrentResource($resource)) ||
        ($page && Lean::isCurrentPage($page))
    ))
        ? 'opacity-90 text-purple-600'
        : 'opacity-30',
])

<a
    class="{{ $class }}"
    href="{{ $href }}"
    {{ $attributes->except(['active', 'page', 'resource']) }}
>
    @if($slot->isNotEmpty())
        {{ $slot }}
    @else
        @svg($icon, ['class' => 'h-6 w-6'])
    @endif
</a>
