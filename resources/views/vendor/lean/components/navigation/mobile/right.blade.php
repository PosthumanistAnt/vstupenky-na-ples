@foreach(Lean::resources() as $alias => $resource)
    <x-lean::navigation.mobile.link
        :icon="$resource::icon()"
        :href="route('lean.resource.index', $alias)"
    />
@endforeach
