@props([
    'field',
])

@if($field->action->index())
    <span {{ $attributes }}>
        {{-- Index excerpt --}}
        {{ Str::words(
             str_replace('&nbsp;', ' ', strip_tags($field->value)),
            config('lean.fields.textarea.index_excerpt_words'),
            '...'
        ) }}
    </span>
@elseif($field->action->show())
    <div x-data="{ expanded: {{ $field->expanded ? 'true' : 'false' }} }">
        <template x-if="expanded">
            <p {{ $attributes }}>
                {{ $field->value }}
            </p>
        </template>
        <div>
            <a x-show="! expanded" @click="expanded = true" href="#">Expand</a>
            <a x-show="expanded" @click="expanded = false" href="#">Collapse</a>
        </div>
    </div>
@elseif($field->action->write())
    <textarea
        wire:ignore {{-- To prevent size resetting upon value change. --}}
        id="{{ $field->name }}"
        @if(! $field->isEnabled()) disabled @endif
        class="form-textarea"
        {{ $attributes }}
    >{{ $field->value }}</textarea>
@endif
