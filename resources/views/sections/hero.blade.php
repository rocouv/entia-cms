@php
    $imageSettings = $content['image_settings'] ?? [];
    $imageOpacity = max(0, min(100, (int) ($imageSettings['opacity'] ?? 100))) / 100;
    $imagePosition = in_array($imageSettings['object_position'] ?? null, ['left top', 'center top', 'right top', 'left center', 'center center', 'right center', 'left bottom', 'center bottom', 'right bottom'], true) ? $imageSettings['object_position'] : 'center center';
    $imageFit = in_array($imageSettings['fit'] ?? null, ['cover', 'contain', 'fill', 'none'], true) ? $imageSettings['fit'] : 'cover';
    $overlayOpacity = max(0, min(100, (int) ($content['overlay_opacity'] ?? 40))) / 100;
@endphp

<section class="relative overflow-hidden bg-{{ $settings['background_color'] ?? 'white' }} py-3xl lg:py-[120px]">
    @if($content['image'] ?? false)
        <div class="absolute inset-0">
            <img src="{{ asset('storage/' . $content['image']) }}" alt="" class="h-full w-full" style="opacity: {{ $imageOpacity }}; object-fit: {{ $imageFit }}; object-position: {{ $imagePosition }};">
            <div class="absolute inset-0 bg-black" style="opacity: {{ $overlayOpacity }};"></div>
        </div>
    @endif
    <div class="relative mx-auto max-w-7xl px-6 text-center">
        <h1 class="text-display-md font-black tracking-tight {{ $content['image'] ?? false ? 'text-white' : 'text-on-surface' }} md:text-display-xl">
            {{ $content['title'] ?? '' }}
        </h1>
        @if($content['subtitle'] ?? false)
            <p class="mx-auto mt-6 max-w-2xl text-body-lg {{ $content['image'] ?? false ? 'text-white/80' : 'text-on-surface-variant' }}">
                {{ $content['subtitle'] }}
            </p>
        @endif
        @if($content['button_text'] ?? false)
            <a href="{{ $content['button_url'] ?? '#' }}" class="mt-8 inline-block rounded bg-primary px-8 py-3 text-label-md text-on-primary transition hover:opacity-80">
                {{ $content['button_text'] }}
            </a>
        @endif
    </div>
</section>
