<x-dashboard-layout title="Categorias">
    <section class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="mt-2 text-headline-lg text-primary">Categorias</h1>
            <p class="mt-2 max-w-2xl text-body-md text-on-surface-variant">
                Organiza servicios y proyectos con categorias compartidas del sitio.
            </p>
        </div>

        <a href="{{ route('dashboard.categories.create') }}" class="inline-flex h-11 items-center justify-center gap-2 rounded bg-primary px-5 text-label-md text-on-primary transition hover:opacity-90">
            <span class="material-symbols-outlined text-[18px]">add_circle</span>
            Nueva categoria
        </a>
    </section>

    @if (session('status'))
        <div class="mb-6 border border-outline-variant bg-surface-container-lowest px-6 py-4 text-body-sm text-primary">
            {{ session('status') }}
        </div>
    @endif

    <section class="overflow-hidden border border-outline-variant bg-surface-container-lowest">
        <div class="border-b border-outline-variant bg-surface-container-low px-6 py-4">
            <h2 class="text-headline-md text-primary">Listado de categorias</h2>
            <p class="mt-1 text-body-sm text-on-surface-variant">Ordenadas por prioridad editorial y nombre.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-outline-variant text-left text-body-sm">
                <thead class="bg-surface-container">
                    <tr>
                        <th class="px-6 py-3 font-semibold text-on-surface">Categoria</th>
                        <th class="px-6 py-3 font-semibold text-on-surface">Slug</th>
                        <th class="px-6 py-3 font-semibold text-on-surface">Contenido</th>
                        <th class="px-6 py-3 font-semibold text-on-surface">Estado</th>
                        <th class="px-6 py-3 text-right font-semibold text-on-surface">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse ($categories as $category)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-primary">{{ $category->name }}</div>
                                @if ($category->description)
                                    <p class="mt-1 max-w-md text-on-surface-variant">{{ $category->description }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-on-surface-variant">{{ $category->slug }}</td>
                            <td class="px-6 py-4 text-on-surface-variant">
                                {{ $category->services_count }} servicios &middot; {{ $category->projects_count }} proyectos
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex rounded px-3 py-1 text-label-sm {{ $category->is_active ? 'bg-secondary-container text-on-secondary-container' : 'bg-surface-container-high text-on-surface-variant' }}">
                                    {{ $category->is_active ? 'Activa' : 'Oculta' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('dashboard.categories.edit', $category) }}" class="inline-flex h-9 items-center justify-center rounded border border-outline-variant px-3 text-label-md text-primary transition hover:bg-surface-container-low">
                                        Editar
                                    </a>
                                    <form method="POST" action="{{ route('dashboard.categories.destroy', $category) }}">
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
                                Todavia no hay categorias. Crea una para organizar servicios y proyectos.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-dashboard-layout>
