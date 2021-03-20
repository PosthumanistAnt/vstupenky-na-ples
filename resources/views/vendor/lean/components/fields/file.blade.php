@props([
    'field',
])

@if($field->action->read())
    {{ $field->displayValue }}
@elseif($field->action->write())
    <div
        x-data="{
            deleted: $wire.entangle('{{ 'fieldMetadata.' . $field->name . '.deleted' }}'),
            color() {
                return this.deleted ? ' text-red-600 ' : ' text-gray-700 '
            }
        }"
    >
        <div x-show="! deleted">
            @if(! $field->deleted)
                <div>
                    @if($field->value && $field->action->edit() && $field->hasStoredValue)
                        <div class="text-sm text-gray-600 mb-2">
                        Current:
                            {{ $field->displayValue }}
                        </div>
                    @endif
                    <input
                        id="{{ $field->id($_instance) }}"
                        type="file"
                        @if(! $field->isEnabled()) disabled @endif
                        class="form-input"
                        {{ $attributes }}
                    >
                </div>
            @endif
        </div>
        @if($field->action->edit() && $field->hasStoredValue && $field->isEnabled())
            <label class="flex items-center mt-2">
                <span x-bind:class="color() + `
                    text-sm mr-1
                `">Delete?</span>
                <input x-model="deleted" x-bind:class="color() + 'form-checkbox'" type="checkbox">
            </label>
        @endif
    </div>
@endif
