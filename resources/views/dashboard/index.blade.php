<x-dashboard-layout title="Dashboard">
    <section class="mb-8">
        <h1 class="mt-2 text-headline-lg text-primary">Bienvenido, {{ auth()->user()->name }}.</h1>
        <p class="mt-2 max-w-2xl text-body-md text-on-surface-variant">
            Administra el contenido del sitio desde este panel.
        </p>
    </section>

    <section class="mb-8 grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
        <div class="border border-outline-variant bg-surface-container-lowest p-6 transition hover:border-primary">
            <span class="material-symbols-outlined text-on-primary-container">admin_panel_settings</span>
            <p class="mt-3 text-label-sm uppercase tracking-wider text-on-surface-variant">Rol activo</p>
            <p class="mt-1 text-headline-lg text-primary">{{ auth()->user()->role->name }}</p>
        </div>
        <div class="border border-outline-variant bg-surface-container-lowest p-6 transition hover:border-primary">
            <span class="material-symbols-outlined text-on-primary-container">description</span>
            <p class="mt-3 text-label-sm uppercase tracking-wider text-on-surface-variant">Paginas</p>
            <p class="mt-1 text-headline-lg text-primary">Activo</p>
        </div>
        <div class="border border-outline-variant bg-surface-container-lowest p-6 transition hover:border-primary">
            <span class="material-symbols-outlined text-on-primary-container">view_quilt</span>
            <p class="mt-3 text-label-sm uppercase tracking-wider text-on-surface-variant">Secciones</p>
            <p class="mt-1 text-headline-lg text-primary">Activo</p>
        </div>
        <div class="border border-outline-variant bg-surface-container-lowest p-6 transition hover:border-primary">
            <span class="material-symbols-outlined text-on-primary-container">image</span>
            <p class="mt-3 text-label-sm uppercase tracking-wider text-on-surface-variant">Media</p>
            <p class="mt-1 text-headline-lg text-primary">Activo</p>
        </div>
    </section>

    <section class="grid gap-6 lg:grid-cols-3">
        <div class="border border-outline-variant bg-surface-container-lowest lg:col-span-2">
            <div class="border-b border-outline-variant bg-surface-container-low px-6 py-4">
                <h2 class="text-headline-md text-primary">Acciones rapidas</h2>
            </div>
            <div class="space-y-3 p-6">
                <a href="{{ route('dashboard.pages.create') }}" class="flex h-12 w-full items-center justify-center gap-3 rounded bg-primary text-label-md text-on-primary transition hover:opacity-90">
                    <span class="material-symbols-outlined text-[20px]">add_circle</span>
                    Nueva pagina
                </a>
                <a href="{{ route('dashboard.media.create') }}" class="flex h-12 w-full items-center justify-center gap-3 rounded border border-outline-variant bg-surface-container-lowest text-label-md text-primary transition hover:bg-surface-container-low">
                    <span class="material-symbols-outlined text-[20px]">cloud_upload</span>
                    Subir media
                </a>
                <a href="/" class="flex h-12 w-full items-center justify-center gap-3 rounded border border-outline-variant bg-surface-container-lowest text-label-md text-primary transition hover:bg-surface-container-low">
                    <span class="material-symbols-outlined text-[20px]">open_in_new</span>
                    Ver sitio publico
                </a>
            </div>
        </div>

        <div class="space-y-6">
            <div class="border border-outline-variant bg-surface-container-lowest p-6">
                <p class="text-label-sm uppercase tracking-wider text-on-surface-variant">Paginas</p>
                <p class="mt-2 text-headline-lg text-primary">{{ \App\Models\Page::count() }}</p>
            </div>
            <div class="border border-outline-variant bg-surface-container-lowest p-6">
                <p class="text-label-sm uppercase tracking-wider text-on-surface-variant">Secciones</p>
                <p class="mt-2 text-headline-lg text-primary">{{ \App\Models\Section::count() }}</p>
            </div>
            <div class="border border-outline-variant bg-surface-container-lowest p-6">
                <p class="text-label-sm uppercase tracking-wider text-on-surface-variant">Archivos</p>
                <p class="mt-2 text-headline-lg text-primary">{{ \App\Models\Media::count() }}</p>
            </div>
        </div>
    </section>
</x-dashboard-layout>
