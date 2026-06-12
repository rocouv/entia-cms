<x-dashboard-layout title="Dashboard">
    <section class="mb-8 overflow-hidden border border-outline-variant bg-surface-container-lowest">
        <div class="grid gap-8 p-6 lg:grid-cols-[1fr_320px] lg:p-8">
            <div>
                <p class="text-label-sm uppercase tracking-[0.2em] text-on-surface-variant">Panel administrativo</p>
                <h1 class="mt-3 text-headline-xl text-primary">Bienvenido, {{ auth()->user()->name }}.</h1>
                <p class="mt-3 max-w-4xl text-body-lg text-on-surface-variant">
                    Revisa el estado editorial del sitio, continua el contenido reciente y accede a las acciones principales del CMS.
                </p>

                <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('dashboard.pages.create') }}" class="inline-flex h-11 items-center justify-center gap-2 rounded bg-primary px-5 text-label-md text-on-primary transition hover:opacity-90">
                        <span class="material-symbols-outlined text-[18px]">add_circle</span>
                        Nueva pagina
                    </a>
                    <a href="/" class="inline-flex h-11 items-center justify-center gap-2 rounded border border-outline-variant bg-surface px-5 text-label-md text-primary transition hover:bg-surface-container-low">
                        <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                        Ver sitio publico
                    </a>
                </div>
            </div>

            <!--<aside class="border border-outline-variant bg-surface p-5">
                <p class="text-label-sm uppercase tracking-wider text-on-surface-variant">Sesion actual</p>
                <div class="mt-4 flex items-center gap-3">
                    <span class="flex size-11 items-center justify-center rounded bg-secondary-container text-on-secondary-container">
                        <span class="material-symbols-outlined">admin_panel_settings</span>
                    </span>
                    <div>
                        <p class="text-headline-md text-primary">{{ auth()->user()->role->name }}</p>
                        <p class="text-body-sm text-on-surface-variant">Rol activo</p>
                    </div>
                </div>
            </aside>-->
        </div>
    </section>

    <section class="mb-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <article class="border border-outline-variant bg-surface-container-lowest p-6">
            <div class="flex items-center justify-between gap-4">
                <p class="text-label-sm uppercase tracking-wider text-on-surface-variant">Paginas</p>
                <span class="material-symbols-outlined text-on-primary-container">description</span>
            </div>
            <p class="mt-4 text-headline-xl text-primary">{{ $stats['pages'] }}</p>
            <p class="mt-1 text-body-sm text-on-surface-variant">{{ $stats['publishedPages'] }} publicadas</p>
        </article>

        <article class="border border-outline-variant bg-surface-container-lowest p-6">
            <div class="flex items-center justify-between gap-4">
                <p class="text-label-sm uppercase tracking-wider text-on-surface-variant">Secciones</p>
                <span class="material-symbols-outlined text-on-primary-container">view_quilt</span>
            </div>
            <p class="mt-4 text-headline-xl text-primary">{{ $stats['sections'] }}</p>
            <p class="mt-1 text-body-sm text-on-surface-variant">{{ $stats['visibleSections'] }} visibles</p>
        </article>

        <article class="border border-outline-variant bg-surface-container-lowest p-6">
            <div class="flex items-center justify-between gap-4">
                <p class="text-label-sm uppercase tracking-wider text-on-surface-variant">Media</p>
                <span class="material-symbols-outlined text-on-primary-container">image</span>
            </div>
            <p class="mt-4 text-headline-xl text-primary">{{ $stats['media'] }}</p>
            <p class="mt-1 text-body-sm text-on-surface-variant">archivos disponibles</p>
        </article>

        <article class="border border-outline-variant bg-surface-container-lowest p-6">
            <div class="flex items-center justify-between gap-4">
                <p class="text-label-sm uppercase tracking-wider text-on-surface-variant">Publicacion</p>
                <span class="material-symbols-outlined text-on-primary-container">public</span>
            </div>
            <p class="mt-4 text-headline-xl text-primary">{{ $stats['pages'] > 0 ? round(($stats['publishedPages'] / $stats['pages']) * 100) : 0 }}%</p>
            <p class="mt-1 text-body-sm text-on-surface-variant">paginas publicadas</p>
        </article>
    </section>

    <section class="grid gap-6 lg:grid-cols-3">
        <div class="overflow-hidden border border-outline-variant bg-surface-container-lowest lg:col-span-2">
            <div class="border-b border-outline-variant bg-surface-container-low px-6 py-4">
                <h2 class="text-headline-md text-primary">Paginas recientes</h2>
                <p class="mt-1 text-body-sm text-on-surface-variant">Contenido editado recientemente y su estado de publicacion.</p>
            </div>

            <div class="divide-y divide-outline-variant">
                @forelse ($recentPages as $page)
                    <article class="flex flex-col gap-4 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-label-lg text-primary">{{ $page->title }}</h3>
                            <p class="mt-1 text-body-sm text-on-surface-variant">/{{ $page->slug }} &middot; {{ $page->sections_count }} secciones</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="inline-flex rounded px-3 py-1 text-label-sm {{ $page->is_published ? 'bg-secondary-container text-on-secondary-container' : 'bg-surface-container-high text-on-surface-variant' }}">
                                {{ $page->is_published ? 'Publicada' : 'Borrador' }}
                            </span>
                            <a href="{{ route('dashboard.pages.edit', $page) }}" class="text-label-md text-primary hover:underline">Editar</a>
                        </div>
                    </article>
                @empty
                    <div class="px-6 py-12 text-center text-on-surface-variant">
                        Todavia no hay paginas. Crea la home para iniciar el sitio.
                    </div>
                @endforelse
            </div>
        </div>

        <aside class="space-y-6">
            <section class="border border-outline-variant bg-surface-container-lowest">
                <div class="border-b border-outline-variant bg-surface-container-low px-6 py-4">
                    <h2 class="text-headline-md text-primary">Acciones rapidas</h2>
                </div>
                <div class="grid gap-3 p-6">
                    <a href="{{ route('dashboard.pages.index') }}" class="flex h-11 items-center justify-center gap-2 rounded border border-outline-variant text-label-md text-primary transition hover:bg-surface-container-low">
                        <span class="material-symbols-outlined text-[18px]">description</span>
                        Gestionar paginas
                    </a>
                    <a href="{{ route('dashboard.media.create') }}" class="flex h-11 items-center justify-center gap-2 rounded border border-outline-variant text-label-md text-primary transition hover:bg-surface-container-low">
                        <span class="material-symbols-outlined text-[18px]">cloud_upload</span>
                        Subir media
                    </a>
                </div>
            </section>

            <section class="border border-outline-variant bg-surface-container-lowest p-6">
                <p class="text-label-sm uppercase tracking-wider text-on-surface-variant">Media reciente</p>
                <div class="mt-4 space-y-3">
                    @forelse ($recentMedia as $item)
                        <a href="{{ $item->url() }}" target="_blank" class="flex items-center gap-3 text-body-sm text-on-surface-variant transition hover:text-primary">
                            <span class="material-symbols-outlined text-[20px]">{{ $item->isImage() ? 'image' : 'description' }}</span>
                            <span class="truncate">{{ $item->original_name }}</span>
                        </a>
                    @empty
                        <p class="text-body-sm text-on-surface-variant">No hay archivos subidos.</p>
                    @endforelse
                </div>
            </section>
        </aside>
    </section>
</x-dashboard-layout>
