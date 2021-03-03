@props([
    'field',
])

@if(isset($field->renderOverrides[$field->action->type]))
    @php($override = $field->renderOverrides[$field->action->type])
    {!! is_callable($override) ? $override($field, $field->value) : $override !!}
@else
    <x-dynamic-component
        :component="$field->getComponent()"
        :field="$field"
        :attributes="$field->getAttributes()->merge($attributes->getAttributes())"
    />

    @foreach($field::$scripts as $script)
        @once("_lean.script.$script")
            @push('_lean.scripts')
                {!! config("lean.scripts.$script") !!}
            @endpush
        @endonce
    @endforeach

    @foreach($field::$styles as $style)
        @once("_lean.style.$style")
            @push('_lean.styles')
                {!! config("lean.styles.$style") !!}
            @endpush
        @endonce
    @endforeach
@endif
