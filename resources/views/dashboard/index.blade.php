<x-dashboard-layout title="Dashboard">
    <section class="mb-8">
        <p class="text-label-sm uppercase tracking-[0.2em] text-on-surface-variant">Semana 1 completada</p>
        <h1 class="mt-2 text-headline-lg text-primary">Bienvenido, {{ auth()->user()->name }}.</h1>
        <p class="mt-2 max-w-2xl text-body-md text-on-surface-variant">
            El panel ya protege el acceso administrativo y prepara la base para configuracion, paginas, secciones, media, servicios y proyectos.
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
            <p class="mt-1 text-headline-lg text-primary">Pendiente</p>
        </div>
        <div class="border border-outline-variant bg-surface-container-lowest p-6 transition hover:border-primary">
            <span class="material-symbols-outlined text-on-primary-container">view_quilt</span>
            <p class="mt-3 text-label-sm uppercase tracking-wider text-on-surface-variant">Secciones</p>
            <p class="mt-1 text-headline-lg text-primary">Pendiente</p>
        </div>
        <div class="border border-outline-variant bg-surface-container-lowest p-6 transition hover:border-primary">
            <span class="material-symbols-outlined text-on-primary-container">image</span>
            <p class="mt-3 text-label-sm uppercase tracking-wider text-on-surface-variant">Media</p>
            <p class="mt-1 text-headline-lg text-primary">Pendiente</p>
        </div>
    </section>

    <section class="grid gap-6 lg:grid-cols-3">
        <div class="border border-outline-variant bg-surface-container-lowest lg:col-span-2">
            <div class="flex items-center justify-between border-b border-outline-variant bg-surface-container-low px-6 py-4">
                <h2 class="text-headline-md text-primary">Flujo del MVP</h2>
                <span class="text-label-sm uppercase tracking-wider text-on-surface-variant">Plan vigente</span>
            </div>
            <div class="divide-y divide-outline-variant">
                <div class="flex items-start gap-4 px-6 py-4">
                    <div class="flex size-10 items-center justify-center rounded bg-surface-container-high text-on-surface-variant">1</div>
                    <div>
                        <p class="font-semibold text-primary">Sistema visual aplicado</p>
                        <p class="text-body-sm text-on-surface-variant">Layouts base alineados al wireframe Stitch.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 px-6 py-4">
                    <div class="flex size-10 items-center justify-center rounded bg-surface-container-high text-on-surface-variant">2</div>
                    <div>
                        <p class="font-semibold text-primary">Semana 2</p>
                        <p class="text-body-sm text-on-surface-variant">Configuracion general, usuarios editores y media basica.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 px-6 py-4">
                    <div class="flex size-10 items-center justify-center rounded bg-surface-container-high text-on-surface-variant">3</div>
                    <div>
                        <p class="font-semibold text-primary">Contenido administrable</p>
                        <p class="text-body-sm text-on-surface-variant">Paginas, secciones dinamicas y render publico con Blade.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="border border-outline-variant bg-surface-container-lowest">
                <div class="border-b border-outline-variant bg-surface-container-low px-6 py-4">
                    <h2 class="text-headline-md text-primary">Acciones rapidas</h2>
                </div>
                <div class="space-y-3 p-6">
                    <button class="flex h-12 w-full items-center justify-center gap-3 rounded bg-primary text-label-md text-on-primary transition hover:opacity-90">
                        <span class="material-symbols-outlined text-[20px]">add_circle</span>
                        Nueva pagina
                    </button>
                    <button class="flex h-12 w-full items-center justify-center gap-3 rounded border border-outline-variant bg-surface-container-lowest text-label-md text-primary transition hover:bg-surface-container-low">
                        <span class="material-symbols-outlined text-[20px]">cloud_upload</span>
                        Subir media
                    </button>
                    <a href="/" class="flex h-12 w-full items-center justify-center gap-3 rounded border border-outline-variant bg-surface-container-lowest text-label-md text-primary transition hover:bg-surface-container-low">
                        <span class="material-symbols-outlined text-[20px]">open_in_new</span>
                        Ver sitio publico
                    </a>
                </div>
            </div>

            <div class="border border-outline-variant bg-surface-container-lowest p-6">
                <p class="text-label-sm uppercase tracking-wider text-on-surface-variant">Estado del sistema</p>
                <div class="mt-4 space-y-3 text-body-sm">
                    <div class="flex items-center justify-between">
                        <span>Laravel base</span>
                        <span class="font-semibold text-primary">Activo</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>SQLite</span>
                        <span class="text-on-surface-variant">Configurado</span>
                    </div>
                    <div class="h-2 overflow-hidden rounded-full bg-surface-container-high">
                        <div class="h-full w-1/4 bg-primary"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-dashboard-layout>
