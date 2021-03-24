@php($links = Lean::menuLinks())
@foreach(Lean::$mobileMenu['left'] as $link)
    <x-lean::navigation.mobile.link :link="$links[$link]" />
@endforeach
