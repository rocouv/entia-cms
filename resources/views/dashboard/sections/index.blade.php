<x-dashboard-layout title="Secciones">
    <section class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-label-sm uppercase tracking-[0.2em] text-on-surface-variant">{{ $page->title }}</p>
            <h1 class="mt-2 text-headline-lg text-primary">Secciones</h1>
            <p class="mt-2 max-w-2xl text-body-md text-on-surface-variant">
                Organiza los bloques de contenido de la pagina. El orden determina como se muestran en el sitio.
            </p>
        </div>

        <a href="{{ route('dashboard.sections.create', $page) }}" class="inline-flex h-11 items-center justify-center gap-2 rounded bg-primary px-5 text-label-md text-on-primary transition hover:opacity-90">
            <span class="material-symbols-outlined text-[18px]">add_circle</span>
            Nueva seccion
        </a>
    </section>

    @if (session('status'))
        <div class="mb-6 border border-outline-variant bg-surface-container-lowest px-6 py-4 text-body-sm text-primary">
            {{ session('status') }}
        </div>
    @endif

    <section class="overflow-hidden border border-outline-variant bg-surface-container-lowest">
        <div class="border-b border-outline-variant bg-surface-container-low px-6 py-4">
            <h2 class="text-headline-md text-primary">Estructura de {{ $page->title }}</h2>
            <p class="mt-1 text-body-sm text-on-surface-variant">Ordenadas por posicion manual.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-outline-variant text-left text-body-sm">
                <thead class="bg-surface-container">
                    <tr>
                        <th class="px-6 py-3 font-semibold text-on-surface">Seccion</th>
                        <th class="px-6 py-3 font-semibold text-on-surface">Tipo</th>
                        <th class="px-6 py-3 font-semibold text-on-surface">Estado</th>
                        <th class="px-6 py-3 font-semibold text-on-surface">Orden</th>
                        <th class="px-6 py-3 text-right font-semibold text-on-surface">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse ($sections as $section)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-primary">{{ data_get($section->content, 'title', 'Sin titulo') }}</div>
                                @if (data_get($section->content, 'body'))
                                    <p class="mt-1 line-clamp-1 text-on-surface-variant">{{ data_get($section->content, 'body') }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-on-surface-variant">{{ $section->typeLabel() }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex rounded px-3 py-1 text-label-sm {{ $section->is_visible ? 'bg-secondary-container text-on-secondary-container' : 'bg-surface-container-high text-on-surface-variant' }}">
                                    {{ $section->is_visible ? 'Visible' : 'Oculta' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-on-surface-variant">{{ $section->sort_order }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('dashboard.sections.edit', [$page, $section]) }}" class="inline-flex h-9 items-center justify-center rounded border border-outline-variant px-3 text-label-md text-primary transition hover:bg-surface-container-low">
                                        Editar
                                    </a>
                                    <form method="POST" action="{{ route('dashboard.sections.destroy', [$page, $section]) }}">
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
                                Todavia no hay secciones para esta pagina.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <a href="{{ route('dashboard.pages.index') }}" class="mt-6 inline-flex text-label-md text-primary hover:underline">Volver a paginas</a>
</x-dashboard-layout>
