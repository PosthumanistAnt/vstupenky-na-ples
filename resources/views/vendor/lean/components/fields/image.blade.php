@props([
    'field',
])

@if($field->action->index())
    <div class="h-8 flex items-center">
        @foreach($field->getValues() as $image)
            <img src="{{ $image->getThumbnail() }}" class="max-h-8">
        @endforeach
    </div>
@elseif($field->action->show())
    @foreach($field->getValues() as $image)
        <div>
            @if(is_string($image->value))
                <img
                    src="{{ $image->value }}"
                    class="
                        @if(is_string($image->width)) {{ $image->width }} @endif
                        @if(is_string($image->height)) {{ $image->height }} @endif
                    "
                    @if(is_int($image->width)) width="{{ $image->width }}" @endif
                    @if(is_int($image->height)) height="{{ $image->height }}" @endif
                >
            @endif
        </div>
    @endforeach
@else
    <div
        x-data="{
            deleted: @entangle('fieldMetadata.' . $field->name . '.deleted'),
            color() {
                return this.deleted ? ' text-red-600 ' : ' text-gray-700 '
            }
        }"
    >
        <div x-show="! deleted">
            @if(! $field->deleted)
                <div>
                    @foreach($field->getValues() as $image)
                        <img
                            src="{{ $image->getPreview() }}"
                            class="
                                @if(is_string($image->width)) {{ $image->width }} @endif
                                @if(is_string($image->height)) {{ $image->height }} @endif
                            "
                            @if(is_int($image->width)) width="{{ $image->width }}" @endif
                            @if(is_int($image->height)) height="{{ $image->height }}" @endif
                        >
                    @endforeach
                    <input
                        id="{{ $field->name }}"
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
