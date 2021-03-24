<link rel="stylesheet" href="{{ mix('lean.css', 'vendor/lean') }}">

@livewireStyles

@foreach(Lean::$assets['styles'] as $style)
    {!! Lean::config("styles.$style") !!}
@endforeach

{!! Lean::config('font.tag') !!}

@php($brand = Lean::config('theme'))
<style>
    .lean [x-cloak] {
        display: none;
    }

    .lean {
        --font-family-sans: {!! Lean::config('font.family') !!};

        @foreach([
            '50', '100', '200', '300', '400', '500', '600', '700', '800', '900'
        ] as $shade)
            --color-brand-{{ $shade }}: var(--color-{{ $brand }}-{{ $shade }});
        @endforeach
    }

</style>
