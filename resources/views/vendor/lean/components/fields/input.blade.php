@props([
    'field',
])

@if($field->action->read())
    <span {{ $attributes }}>
        {{ $field->value }}
    </span>
@elseif($field->action->write())
    <input
        id="{{ $field->id($_instance) }}"
        type="{{ $field->type }}"
        value="{{ $field->value }}"
        placeholder="{{ $field->placeholder }}"
        @if($field->isRequired()) required @endif
        @if($field->isOptional()) optional @endif
        @if(! $field->isEnabled()) disabled="true" @endif
        class="form-input @if($field->hasErrors()) invalid @endif"
        {{ $attributes }}
    >
@endif
