@foreach(Lean::pages() as $alias => $page)
    <x-lean::navigation.mobile.link
        :icon="$page::icon()"
        :href="route('lean.page', $alias)"
    />
@endforeach
