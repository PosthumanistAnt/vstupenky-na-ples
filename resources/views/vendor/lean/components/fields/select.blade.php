@props([
    'field',
])

@if($field->action->read())
    <span {{ $attributes }}>
        {{ $field->value }}
    </span>
@elseif($field->action->write())
    <select
        id="{{ $field->name }}"
        value="{{ $field->value }}"
        @if($field->isRequired()) required @endif
        @if($field->isOptional()) optional @endif
        @if(! $field->isEnabled()) disabled="true" @endif
        class="form-input @if($field->hasErrors()) invalid @endif"
        {{ $attributes }}
    >
        @if ($placeholder = $field->placeholder)
            <option
                @if(! $placeholder['enabled'])
                    disabled
                @endif
                value="{{ $placeholder['value'] }}"
            >{{ $placeholder['text'] }}</option>
        @endif

        @foreach($field->options as $key => $value)
            <option value="{{ $key }}">{{ $value }}</option>
        @endforeach
    </select>
@endif
