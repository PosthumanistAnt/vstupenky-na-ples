@props([
    'field',
])

@if($field->action->write())
    <input
        id="{{ $field->id($_instance) }}"
        type="password"
        value="{{ $field->value }}"
        @if($field->isRequired()) required @endif
        @if($field->isOptional()) optional @endif
        @if(! $field->isEnabled()) disabled="true" @endif
        class="form-input @if($field->hasErrors()) invalid @endif"
        {{ $attributes }}
    >
@endif
