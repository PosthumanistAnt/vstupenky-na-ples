@props([
    'field',
])

@if($field->action->index())
    <span {{ $attributes }}>
        {{-- Index excerpt --}}
        {{ Str::words(
             str_replace('&nbsp;', ' ', strip_tags($field->value)),
            Lean::config('fields.textarea.index_excerpt_words'),
            '...'
        ) }}
    </span>
@elseif($field->action->show())
    <div x-data="{ expanded: {{ $field->expanded ? 'true' : 'false' }} }">
        <template x-if="expanded">
            <div {{ $attributes }} class="prose">
                {{ $field->value }}
            </div>
        </template>
        <div>
            <a class="styled" x-show="! expanded" @click="expanded = true" href="#">
                {{ gloss('lean::fields.textarea.expand') }}
            </a>
            <a class="styled" x-show="expanded" @click="expanded = false" href="#">
                {{ gloss('lean::fields.textarea.collapse') }}
            </a>
        </div>
    </div>
@elseif($field->action->write())
    <textarea
        wire:ignore {{-- To prevent size resetting upon value change. --}}
        id="{{ $field->id($_instance) }}"
        @if(! $field->isEnabled()) disabled @endif
        class="form-textarea"
        {{ $attributes }}
    >{{ $field->value }}</textarea>
@endif
