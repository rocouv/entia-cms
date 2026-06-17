@php
    $metaTitle = $service->meta_title ?? $service->title;
    $metaDescription = $service->meta_description ?? $service->excerpt;
@endphp

<x-layouts.public :title="$metaTitle" :meta-description="$metaDescription">
    <article>
        <section class="bg-surface-container-lowest py-3xl">
            <div class="mx-auto grid max-w-7xl gap-10 px-6 lg:grid-cols-[1fr_420px] lg:items-center">
                <div>
                    <p class="text-label-sm uppercase tracking-[0.2em] text-on-surface-variant">
                        {{ $service->category?->name ?? 'Servicio' }}
                    </p>
                    <h1 class="mt-3 text-headline-xl text-primary">{{ $service->title }}</h1>
                    @if($service->excerpt)
                        <p class="mt-5 max-w-3xl text-body-lg text-on-surface-variant">{{ $service->excerpt }}</p>
                    @endif
                </div>

                @if($service->imageUrl())
                    <img src="{{ $service->imageUrl() }}" alt="{{ $service->title }}" class="h-80 w-full object-cover">
                @endif
            </div>
        </section>

        <section class="bg-surface py-3xl">
            <div class="mx-auto max-w-4xl px-6">
                @if($service->body)
                    <div class="space-y-5 text-body-lg leading-8 text-on-surface-variant">
                        {!! nl2br(e($service->body)) !!}
                    </div>
                @else
                    <p class="text-body-lg text-on-surface-variant">Este servicio aun no tiene descripcion extendida.</p>
                @endif

                <div class="mt-10">
                    <a href="{{ route('services.index') }}" class="inline-flex h-11 items-center justify-center rounded border border-outline-variant px-6 text-label-md text-primary transition hover:bg-surface-container-low">
                        Volver a servicios
                    </a>
                </div>
            </div>
        </section>
    </article>
</x-layouts.public>
