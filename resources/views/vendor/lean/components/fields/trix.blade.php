@props([
    'field',
])

@php($indexExcerpt = fn($value) => Str::words(
    str_replace('&nbsp;', ' ', strip_tags($value)),
    config('lean.fields.trix.index_excerpt_words'),
    '...'
))

@if($field->action->index())
    <span {{ $attributes }}>
        {{ $indexExcerpt($field->value) }}
    </span>
@elseif($field->action->show())
    <div x-data="{ expanded: {{ $field->expanded ? 'true' : 'false' }} }">
        <template x-if="expanded">
            <div {{ $attributes }}>
                {!! $field->value !!}
            </div>
        </template>
        <div>
            <x-lean::link x-cloak x-show="! expanded" @click="expanded = true" href="#">
                Expand
            </x-lean::link>
            <x-lean::link x-cloak x-show="expanded" @click="expanded = false" href="#">
                Collapse
            </x-lean::link>
        </div>
    </div>
@elseif($field->action->write())
    <div
        x-data="{
            value: @entangle($attributes->wire('model')),
            setValue() { this.$refs.trix.editor.loadHTML(this.value) },
            disable() { this.$refs.trix.contentEditable = false }
        }"
        x-init="
            setValue();
            @if(! $field->isEnabled())
                disable();
            @endif
        "
        @trix-change="value = $event.target.value"
        wire:ignore
    >
        <input id="{{ $field->name }}" type="hidden">
        <trix-editor
            x-ref="trix"
            input="{{ $field->name }}"
            class="form-trix"
            {{ $attributes->whereDoesntStartWith('wire:model') }}
        ></trix-editor>
    </div>
@endif
