@props(['siteSettings' => null])

@php
    $themeDefaults = \App\Models\SiteSetting::THEME_DEFAULTS;
    $theme = array_replace($themeDefaults, $siteSettings?->theme ?? []);

    $fontFamilies = \App\Models\SiteSetting::FONT_FAMILIES;
    $fontCssFamilies = \App\Models\SiteSetting::FONT_CSS_FAMILIES;
    $fontFamily = array_key_exists($theme['font_family'] ?? '', $fontFamilies)
        ? $theme['font_family']
        : $themeDefaults['font_family'];

    $cssVariables = [
        'background' => 'background',
        'surface' => 'surface',
        'surface_container_lowest' => 'surface-container-lowest',
        'surface_container_low' => 'surface-container-low',
        'surface_container' => 'surface-container',
        'surface_container_high' => 'surface-container-high',
        'surface_container_highest' => 'surface-container-highest',
        'on_surface' => 'on-surface',
        'on_surface_variant' => 'on-surface-variant',
        'outline' => 'outline',
        'outline_variant' => 'outline-variant',
        'primary' => 'primary',
        'on_primary' => 'on-primary',
        'primary_container' => 'primary-container',
        'on_primary_container' => 'on-primary-container',
        'secondary' => 'secondary',
        'on_secondary' => 'on-secondary',
        'secondary_container' => 'secondary-container',
        'on_secondary_container' => 'on-secondary-container',
        'tertiary' => 'tertiary',
        'on_tertiary' => 'on-tertiary',
        'tertiary_container' => 'tertiary-container',
        'on_tertiary_container' => 'on-tertiary-container',
        'error' => 'error',
        'on_error' => 'on-error',
        'error_container' => 'error-container',
        'on_error_container' => 'on-error-container',
    ];
@endphp

@if($fontFamily !== 'Inter')
    <link href="https://fonts.googleapis.com/css2?family={{ $fontFamilies[$fontFamily] }}&display=swap" rel="stylesheet">
@endif

<style>
    :root {
        --theme-font-family: {!! $fontCssFamilies[$fontFamily] !!};
        @foreach($cssVariables as $themeKey => $cssVariable)
            --theme-{{ $cssVariable }}: {{ $theme[$themeKey] ?? $themeDefaults[$themeKey] }};
        @endforeach
    }
</style>
