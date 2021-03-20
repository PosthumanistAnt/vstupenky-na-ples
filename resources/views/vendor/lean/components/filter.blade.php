@props([
    'filter',
    'class',
])

@php($attributes = $attributes->merge($filter->getAttributes()))

<div class="{{ $class }}">
    @if($inline = $filter->render($attributes))
        {!! $inline !!}
    @else
        <x-dynamic-component
            :component="$filter->getComponent()"
            :filter="$filter"
            :attributes="$attributes"
        />
    @endif
</div>
