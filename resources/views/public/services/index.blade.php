<x-layouts.public title="Servicios" meta-description="Servicios publicados del sitio.">
    <section class="bg-surface-container-lowest py-3xl">
        <div class="mx-auto max-w-7xl px-6">
            <div class="max-w-3xl">
                <p class="text-label-sm uppercase tracking-[0.2em] text-on-surface-variant">Servicios</p>
                <h1 class="mt-3 text-headline-xl text-primary">Servicios</h1>
                <p class="mt-4 text-body-lg text-on-surface-variant">
                    Soluciones publicadas desde el panel administrativo del sitio.
                </p>
            </div>
        </div>
    </section>

    <section class="bg-surface py-3xl">
        <div class="mx-auto max-w-7xl px-6">
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse($services as $service)
                    <article class="flex h-full flex-col border border-outline-variant bg-surface-container-lowest">
                        @if($service->imageUrl())
                            <img src="{{ $service->imageUrl() }}" alt="{{ $service->title }}" class="h-48 w-full object-cover">
                        @endif
                        <div class="flex flex-1 flex-col p-6">
                            @if($service->category)
                                <p class="text-label-sm uppercase tracking-wider text-on-surface-variant">{{ $service->category->name }}</p>
                            @endif
                            <h2 class="mt-2 text-headline-md text-primary">{{ $service->title }}</h2>
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
                    <div class="border border-dashed border-outline-variant bg-surface-container-lowest p-10 text-center text-body-md text-on-surface-variant md:col-span-2 lg:col-span-3">
                        Todavia no hay servicios publicados.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</x-layouts.public>
