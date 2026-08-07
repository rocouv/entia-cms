@php
    $imageSettings = $content['image_settings'] ?? [];
    $imageOpacity = max(0, min(100, (int) ($imageSettings['opacity'] ?? 100))) / 100;
    $imagePosition = in_array($imageSettings['object_position'] ?? null, ['left top', 'center top', 'right top', 'left center', 'center center', 'right center', 'left bottom', 'center bottom', 'right bottom'], true) ? $imageSettings['object_position'] : 'center center';
    $imageFit = in_array($imageSettings['fit'] ?? null, ['cover', 'contain', 'fill', 'none'], true) ? $imageSettings['fit'] : 'cover';
@endphp

<section class="bg-{{ $settings['background_color'] ?? 'white' }} py-3xl">
    <div class="mx-auto flex max-w-7xl flex-col items-center gap-12 px-6 {{ ($content['image_position'] ?? 'left') === 'right' ? 'md:flex-row-reverse' : 'md:flex-row' }}">
        @if($content['image'] ?? false)
            <div class="w-full md:w-1/2">
                <img src="{{ asset('storage/' . $content['image']) }}" alt="" class="rounded-xl shadow-lg" style="opacity: {{ $imageOpacity }}; object-fit: {{ $imageFit }}; object-position: {{ $imagePosition }};">
            </div>
        @endif
        <div class="w-full {{ $content['image'] ?? false ? 'md:w-1/2' : '' }}">
            @if($content['title'] ?? false)
                <h2 class="text-headline-lg font-bold">{{ $content['title'] }}</h2>
            @endif
            @if($content['body'] ?? false)
                <div class="prose prose-lg mt-4 max-w-none">
                    {{ $content['body'] }}
                </div>
            @endif
        </div>
    </div>
</section>
