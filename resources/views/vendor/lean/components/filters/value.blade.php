@props([
    'filter',
])

{{-- wire:model.lazy=foo => wire:model.lazy=foo.$key --}}
@php($attributesFor = function (string $key, array $extra = []) use ($attributes) {
    $wireModel = $attributes->wire('model');

    return (new Illuminate\View\ComponentAttributeBag([
        $wireModel->directive => $wireModel->value . '.' . $key
    ]))->merge($attributes->whereDoesntStartWith('wire:model')->getAttributes())->merge($extra);
})

{{-- Operator --}}
<x-lean::elements.searchable-select
    :options="$filter->operators"
    name="{{ $filter->getKey() }}_operator"
    :placeholder="gloss('lean::fields.searchable_select.placeholder', ['resource' => 'operator'])"
    width="w-auto flex-shrink-0"
    {{ $attributesFor('operator', [
        'wire:key' => $filter->getKey() . '_operator'
    ]) }}
/>

{{-- todo here we ideally want to show "Select product" instead of "Select orderProduct" (read the label) --}}

@if($element = $filter->getElement())
    {{-- Value --}}
    @if($element === 'multiselect')
        <x-lean::elements.searchable-multiselect
            wire:key="multiselect"
            :options="$filter->options"
            name="{{ $filter->getKey() }}_value"
            :placeholder="gloss('lean::fields.searchable_select.placeholder', ['resource' => $filter->key])"
            width="flex-1"
            {{ $attributesFor('value', [
                'wire:key' => $filter->getKey() . '_multiselect'
            ]) }}
        />
    @elseif($element === 'select')
        <x-lean::elements.searchable-select
            wire:key="select"
            :options="$filter->options"
            name="{{ $filter->getKey() }}_value"
            :placeholder="gloss('lean::fields.searchable_select.placeholder', ['resource' => $filter->key])"
            width="flex-1"
            {{ $attributesFor('value', [
                'wire:key' => $filter->getKey() . '_select'
            ]) }}
        />
    @else
        <input type="{{ $element }}" class="form-input leading-6 text-sm"
            {{ $attributesFor('value') }}
        >
    @endif
@endif
