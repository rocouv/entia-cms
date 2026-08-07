@php
    $services = App\Models\Service::query()
        ->with('category')
        ->when($content['category_id'] ?? null, fn ($query, $categoryId) => $query->where('category_id', $categoryId))
        ->where('is_published', true)
        ->orderByDesc('is_featured')
        ->orderBy('sort_order')
        ->orderBy('title')
        ->limit($content['limit'] ?? 6)
        ->get();
@endphp

<section class="bg-{{ $settings['background_color'] ?? 'surface-container-lowest' }} py-3xl">
    <div class="mx-auto max-w-7xl px-6">
        @if($content['title'] ?? false)
            <div class="mx-auto max-w-3xl text-center">
                <h2 class="text-headline-lg font-bold text-primary">{{ $content['title'] }}</h2>
            </div>
        @endif

        <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse($services as $service)
                <article class="flex h-full flex-col border border-outline-variant bg-surface-container-lowest">
                @if($service->imageUrl())
                        @php
                            $imageSettings = $service->image_settings ?? [];
                            $imageOpacity = max(0, min(100, (int) ($imageSettings['opacity'] ?? 100))) / 100;
                            $imagePosition = in_array($imageSettings['object_position'] ?? null, ['left top', 'center top', 'right top', 'left center', 'center center', 'right center', 'left bottom', 'center bottom', 'right bottom'], true) ? $imageSettings['object_position'] : 'center center';
                            $imageFit = in_array($imageSettings['fit'] ?? null, ['cover', 'contain', 'fill', 'none'], true) ? $imageSettings['fit'] : 'cover';
                        @endphp
                        <img src="{{ $service->imageUrl() }}" alt="{{ $service->title }}" class="h-48 w-full" style="opacity: {{ $imageOpacity }}; object-fit: {{ $imageFit }}; object-position: {{ $imagePosition }};">
                    @endif
                    <div class="flex flex-1 flex-col p-6">
                        @if($service->category)
                            <p class="text-label-sm uppercase tracking-wider text-on-surface-variant">{{ $service->category->name }}</p>
                        @endif
                        <h3 class="mt-2 text-headline-md text-primary">{{ $service->title }}</h3>
                        @if($service->excerpt)
                            <p class="mt-3 flex-1 text-body-md text-on-surface-variant">{{ $service->excerpt }}</p>
                        @endif
                        <a href="{{ route('services.show', $service->slug) }}" class="mt-6 inline-flex items-center gap-2 text-label-md text-primary hover:underline">
                            Ver servicio
                            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                        </a>
                    </div>
                </article>
            @empty
                <div class="border border-dashed border-outline-variant bg-surface-container-lowest p-8 text-center text-body-md text-on-surface-variant md:col-span-2 lg:col-span-3">
                    Todavia no hay servicios publicados.
                </div>
            @endforelse
        </div>

        <div class="mt-10 text-center">
            <a href="{{ route('services.index') }}" class="inline-flex h-11 items-center justify-center rounded bg-primary px-6 text-label-md text-on-primary transition hover:opacity-90">
                Ver todos los servicios
            </a>
        </div>
    </div>
</section>
