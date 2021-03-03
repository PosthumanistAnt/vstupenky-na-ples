@props([
    'field',
])

@if($field->action->read())
    @if($field->value)
        <x-lean::link href="{{ $field->getLink() }}">
            {{ $field->linkText }}
        </x-lean::link>
    @endif
@else
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
        @foreach($field->getValues() as $key => $value)
            <option value="{{ $key }}">{{ $value }}</option>
        @endforeach
    </select>
@endif
