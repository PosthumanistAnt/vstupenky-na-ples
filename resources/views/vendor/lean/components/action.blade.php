@props([
    'resource',
    'action',
    'data' => [],
    'class' => '',
    'refresh' => false,
    'parent' => null,
])

@php($resource ??= $data['resource'] ?? null)
@php($attributes = collect($attributes->getAttributes())->mapWithKeys(fn ($value, $key) => [Str::camel($key) => $value])->toArray())

@if($class)
    <div class="{{ $class }}">
@endif

@if($resource)
    @livewire(Lean::getResource($resource)::getAction($action), array_merge([
        'resource' => $resource,
    ], $attributes, $data))
@else
    @livewire('lean.' . $action, array_merge($attributes, $data))
@endif

@if($refresh)
    @forgetLastChild($parent ?? (isset($this) ? $this : $_instance) ?? null)
@endif

@if($class)
    </div>
@endif
