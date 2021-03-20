{
    "name": "{{ Lean::config('manifest.name') }}",
    "short_name": "{{ Lean::config('manifest.short_name') }}",
    "description": "{{ Lean::config('manifest.description') }}",

    "icons": {!! json_encode(collect(Lean::config('graphics.manifest'))->map(fn ($path, $icon)
        => [
            'src' => $path ?? Lean::icon($icon),
            'sizes' => $icon,
            'type' => 'image/png',
        ])->values()) !!},

    "scope": "{{ app('router')->getRoutes()->getByName('lean.home')->getPrefix() }}/",
    "start_url": "{{ Lean::$homeUrl }}",
    "display": "{{ Lean::config('manifest.display') }}",

    "theme_color": "{{ Lean::themeRGB() }}",
    "background_color": "#fff"
}
