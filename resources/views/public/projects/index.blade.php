<x-layouts.public title="Proyectos" meta-description="Proyectos publicados del sitio.">
    <section class="bg-surface-container-lowest py-3xl">
        <div class="mx-auto max-w-7xl px-6">
            <div class="max-w-none">
                <p class="text-label-sm uppercase tracking-[0.2em] text-on-surface-variant">Proyectos</p>
                <h1 class="mt-3 text-headline-xl text-primary">Proyectos</h1>
                <p class="mt-4 max-w-none text-body-lg leading-relaxed text-on-surface-variant">
                    Conoce una seleccion de proyectos publicados, casos de trabajo y resultados representativos que muestran como se aplican las soluciones en contextos reales.
                </p>
            </div>
        </div>
    </section>

    <section class="bg-surface py-3xl">
        <div class="mx-auto max-w-7xl px-6">
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse($projects as $project)
                    <article class="flex h-full flex-col border border-outline-variant bg-surface-container-lowest">
                        @if($project->imageUrl())
                            <img src="{{ $project->imageUrl() }}" alt="{{ $project->title }}" class="h-56 w-full object-cover">
                        @endif
                        <div class="flex flex-1 flex-col p-6">
                            <div class="flex flex-wrap gap-2 text-label-sm uppercase tracking-wider text-on-surface-variant">
                                @if($project->category)
                                    <span>{{ $project->category->name }}</span>
                                @endif
                                @if($project->client_name)
                                    <span>{{ $project->category ? '·' : '' }} {{ $project->client_name }}</span>
                                @endif
                            </div>
                            <h2 class="mt-2 text-headline-md text-primary">{{ $project->title }}</h2>
                            @if($project->excerpt)
                                <p class="mt-3 flex-1 text-body-md text-on-surface-variant">{{ $project->excerpt }}</p>
                            @endif
                            <a href="{{ route('projects.show', $project->slug) }}" class="mt-6 inline-flex items-center gap-2 text-label-md text-primary hover:underline">
                                Ver proyecto
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="border border-dashed border-outline-variant bg-surface-container-lowest p-10 text-center text-body-md text-on-surface-variant md:col-span-2 lg:col-span-3">
                        Todavia no hay proyectos publicados.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</x-layouts.public>
