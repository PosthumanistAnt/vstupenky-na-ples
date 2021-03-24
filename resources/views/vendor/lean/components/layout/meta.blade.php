<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

@foreach(Lean::config('graphics.meta') as $size => $type)
    <link rel="{{ $type }}" sizes="{{ $size }}" href="{{ Lean::icon($size) }}">
@endforeach

@if($favicon = Lean::config('graphics.favicon'))
<link rel="icon" href="{{ asset($favicon) }}" sizes="any" type="image/svg+xml">
@endif

<meta name="theme-color" content="{{ Lean::themeRGB() }}">

<title>{{ $title ?? '' }} | {{ Lean::name() }}</title>
