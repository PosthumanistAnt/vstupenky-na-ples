@props([
    'field',
])

@if($field->action->write())
    <input
        id="{{ $field->name }}"
        type="password"
        value="{{ $field->value }}"
        @if(! $field->isEnabled()) disabled @endif
        class="form-input"
        {{ $attributes }}
    >
@endif
