@php($links = Lean::menuLinks())
@foreach(Lean::$mobileMenu['right'] as $item)
    <x-lean::navigation.mobile.link
        :icon="$links[$item]->icon"
        :href="$links[$item]->link"
    />
@endforeach
