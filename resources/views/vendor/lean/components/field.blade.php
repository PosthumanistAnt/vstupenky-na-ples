@props([
    'field',
])

@php($attributes = $attributes->merge($field->getAttributes()))

@if($inline = $field->render($attributes))
    {!! $inline !!}
@else
    <x-dynamic-component
        :component="$field->getComponent()"
        :field="$field"
        :attributes="$attributes"
    />

    @foreach($field::$scripts as $script)
        @once("_lean.script.$script")
            @push('_lean.scripts')
                {!! Lean::config("scripts.$script") !!}
            @endpush
        @endonce
    @endforeach

    @foreach($field::$styles as $style)
        @once("_lean.style.$style")
            @push('_lean.styles')
                {!! Lean::config("styles.$style") !!}
            @endpush
        @endonce
    @endforeach
@endif
