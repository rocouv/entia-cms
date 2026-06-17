<x-dashboard-layout title="Proyectos">
    <section class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="mt-2 text-headline-lg text-primary">Proyectos</h1>
            <p class="mt-2 max-w-2xl text-body-md text-on-surface-variant">
                Administra casos, portafolio o proyectos publicados en el sitio.
            </p>
        </div>

        <a href="{{ route('dashboard.projects.create') }}" class="inline-flex h-11 items-center justify-center gap-2 rounded bg-primary px-5 text-label-md text-on-primary transition hover:opacity-90">
            <span class="material-symbols-outlined text-[18px]">add_circle</span>
            Nuevo proyecto
        </a>
    </section>

    @if (session('status'))
        <div class="mb-6 border border-outline-variant bg-surface-container-lowest px-6 py-4 text-body-sm text-primary">
            {{ session('status') }}
        </div>
    @endif

    <section class="overflow-hidden border border-outline-variant bg-surface-container-lowest">
        <div class="border-b border-outline-variant bg-surface-container-low px-6 py-4">
            <h2 class="text-headline-md text-primary">Listado de proyectos</h2>
            <p class="mt-1 text-body-sm text-on-surface-variant">Ordenados por prioridad editorial y titulo.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-outline-variant text-left text-body-sm">
                <thead class="bg-surface-container">
                    <tr>
                        <th class="px-6 py-3 font-semibold text-on-surface">Proyecto</th>
                        <th class="px-6 py-3 font-semibold text-on-surface">Slug</th>
                        <th class="px-6 py-3 font-semibold text-on-surface">Categoria</th>
                        <th class="px-6 py-3 font-semibold text-on-surface">Estado</th>
                        <th class="px-6 py-3 text-right font-semibold text-on-surface">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse ($projects as $project)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-primary">{{ $project->title }}</div>
                                @if ($project->client_name)
                                    <p class="mt-1 text-on-surface-variant">Cliente: {{ $project->client_name }}</p>
                                @endif
                                @if ($project->is_featured)
                                    <span class="mt-2 inline-flex rounded bg-primary-container px-2 py-0.5 text-label-sm text-on-primary-container">Destacado</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-on-surface-variant">/proyectos/{{ $project->slug }}</td>
                            <td class="px-6 py-4 text-on-surface-variant">{{ $project->category?->name ?? 'Sin categoria' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex rounded px-3 py-1 text-label-sm {{ $project->is_published ? 'bg-secondary-container text-on-secondary-container' : 'bg-surface-container-high text-on-surface-variant' }}">
                                    {{ $project->is_published ? 'Publicado' : 'Borrador' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('dashboard.projects.edit', $project) }}" class="inline-flex h-9 items-center justify-center rounded border border-outline-variant px-3 text-label-md text-primary transition hover:bg-surface-container-low">
                                        Editar
                                    </a>
                                    <form method="POST" action="{{ route('dashboard.projects.destroy', $project) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex h-9 items-center justify-center rounded border border-outline-variant px-3 text-label-md text-error transition hover:bg-error/10">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-on-surface-variant">
                                Todavia no hay proyectos. Crea el primero para activar el listado publico.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-dashboard-layout>
