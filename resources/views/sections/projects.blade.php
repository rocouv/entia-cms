@php
    $projects = App\Models\Project::query()
        ->with('category')
        ->when($content['category_id'] ?? null, fn ($query, $categoryId) => $query->where('category_id', $categoryId))
        ->where('is_published', true)
        ->orderByDesc('is_featured')
        ->orderBy('sort_order')
        ->orderBy('title')
        ->limit($content['limit'] ?? 6)
        ->get();
@endphp

<section class="bg-{{ $settings['background_color'] ?? 'white' }} py-3xl">
    <div class="mx-auto max-w-7xl px-6">
        @if($content['title'] ?? false)
            <div class="mx-auto max-w-3xl text-center">
                <h2 class="text-headline-lg font-bold text-primary">{{ $content['title'] }}</h2>
            </div>
        @endif

        <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse($projects as $project)
                <article class="flex h-full flex-col overflow-hidden border border-outline-variant bg-surface-container-lowest">
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
                        <h3 class="mt-2 text-headline-md text-primary">{{ $project->title }}</h3>
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
                <div class="border border-dashed border-outline-variant bg-surface-container-lowest p-8 text-center text-body-md text-on-surface-variant md:col-span-2 lg:col-span-3">
                    Todavia no hay proyectos publicados.
                </div>
            @endforelse
        </div>

        <div class="mt-10 text-center">
            <a href="{{ route('projects.index') }}" class="inline-flex h-11 items-center justify-center rounded bg-primary px-6 text-label-md text-on-primary transition hover:opacity-90">
                Ver todos los proyectos
            </a>
        </div>
    </div>
</section>
