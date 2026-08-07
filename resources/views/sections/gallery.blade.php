<section class="bg-{{ $settings['background_color'] ?? 'white' }} py-3xl">
    <div class="mx-auto max-w-7xl px-6">
        @if($content['title'] ?? false)
            <h2 class="text-center text-headline-lg font-bold">{{ $content['title'] }}</h2>
        @endif
        @if($content['images'] ?? false)
            <div class="mt-10 grid gap-6 md:grid-cols-3">
                @foreach($content['images'] as $image)
                    @php
                        $imageUrl = is_array($image) ? ($image['url'] ?? '') : $image;
                        $imageAlt = is_array($image) ? ($image['alt'] ?? '') : '';
                        $imageSettings = is_array($image) ? ($image['settings'] ?? []) : [];
                        $imageOpacity = max(0, min(100, (int) ($imageSettings['opacity'] ?? 100))) / 100;
                        $imagePosition = in_array($imageSettings['object_position'] ?? null, ['left top', 'center top', 'right top', 'left center', 'center center', 'right center', 'left bottom', 'center bottom', 'right bottom'], true) ? $imageSettings['object_position'] : 'center center';
                        $imageFit = in_array($imageSettings['fit'] ?? null, ['cover', 'contain', 'fill', 'none'], true) ? $imageSettings['fit'] : 'cover';
                    @endphp
                    <div class="overflow-hidden rounded-xl shadow-sm">
                        <img src="{{ asset('storage/' . $imageUrl) }}" alt="{{ $imageAlt }}" class="h-64 w-full transition duration-300 hover:scale-105" style="opacity: {{ $imageOpacity }}; object-fit: {{ $imageFit }}; object-position: {{ $imagePosition }};">
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
