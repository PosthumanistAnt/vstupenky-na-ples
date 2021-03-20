@props([
    'filter',
])

@if($filter->type === 'select')
    <select {!! $attributes !!} class="form-input py-1 text-sm">
        @foreach($filter->options as $value => $name)
            <option value="{{ $value }}">{{ $name }}</option>
        @endforeach
    </select>
@elseif($filter->type === 'searchable')
    <x-lean::elements.searchable-select
        :options="$filter->options"
        :name="$filter->getKey()"
        :placeholder="gloss('lean::filters.select.placeholder', ['label' => lcfirst($filter->getLabel())])"
        {{ $attributes }}
    />
@elseif($filter->type === 'radio')
    <div class="flex items-center">
        @foreach($filter->options as $value => $name)
            <label>
                <input class="form-radio" name="{{ $filter->getKey() }}" value="{{ $value }}">
                <span>{{ $name }}</span>
            </label>
        @endforeach
    </div>
@endif
