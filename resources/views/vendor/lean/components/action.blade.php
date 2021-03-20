@props([
    'resource',
    'action',
    'data' => [],
    'class' => '',
    'refresh' => false,
    'parent' => null,
])

@php($resource ??= $data['resource'] ?? null)

@if($class)
    <div class="{{ $class }}">
@endif

@if($resource)
    @livewire(Lean::getResource($resource)::getAction($action), array_merge([
        'resource' => $resource,
    ], $attributes->getAttributes(), $data))
@else
    @livewire('lean.' . $action, array_merge($attributes->getAttributes(), $data))
@endif

@if($refresh)
    @forgetLastChild($parent ?? $this ?? $_instance)
@endif

@if($class)
    </div>
@endif
