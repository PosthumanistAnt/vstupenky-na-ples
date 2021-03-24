@php($links = Lean::menuLinks())
@foreach(Lean::$mobileMenu['right'] as $link)
    <x-lean::navigation.mobile.link :link="$links[$link]" />
@endforeach
