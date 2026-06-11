<x-dashboard-layout title="Editar pagina">
    <section class="mb-8">
        <p class="text-label-sm uppercase tracking-[0.2em] text-on-surface-variant">Paginas</p>
        <h1 class="mt-2 text-headline-lg text-primary">Editar pagina</h1>
        <p class="mt-2 max-w-2xl text-body-md text-on-surface-variant">
            Actualiza contenido, publicacion, navegacion y SEO basico de la pagina.
        </p>
    </section>

    <form method="POST" action="{{ route('dashboard.pages.update', $page) }}" class="grid gap-6 lg:grid-cols-3">
        @csrf
        @method('PUT')

        <div class="space-y-6 lg:col-span-2">
            <section class="border border-outline-variant bg-surface-container-lowest">
                <div class="border-b border-outline-variant bg-surface-container-low px-6 py-4">
                    <h2 class="text-headline-md text-primary">Contenido</h2>
                    <p class="mt-1 text-body-sm text-on-surface-variant">El slug se normaliza automaticamente a formato URL.</p>
                </div>

                <div class="grid gap-5 p-6">
                    <label class="grid gap-2">
                        <span class="text-label-md text-on-surface">Titulo</span>
                        <input name="title" value="{{ old('title', $page->title) }}" required class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                        @error('title') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                    </label>

                    <label class="grid gap-2">
                        <span class="text-label-md text-on-surface">Slug</span>
                        <input name="slug" value="{{ old('slug', $page->slug) }}" required class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                        @error('slug') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                    </label>

                    <label class="grid gap-2">
                        <span class="text-label-md text-on-surface">Extracto</span>
                        <textarea name="excerpt" rows="3" class="rounded border border-outline-variant bg-surface px-3 py-2 text-body-md outline-none transition focus:border-primary">{{ old('excerpt', $page->excerpt) }}</textarea>
                        @error('excerpt') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                    </label>

                    <label class="grid gap-2">
                        <span class="text-label-md text-on-surface">Contenido base</span>
                        <textarea name="body" rows="8" class="rounded border border-outline-variant bg-surface px-3 py-2 text-body-md outline-none transition focus:border-primary">{{ old('body', $page->body) }}</textarea>
                        @error('body') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                    </label>
                </div>
            </section>

            <section class="border border-outline-variant bg-surface-container-lowest">
                <div class="border-b border-outline-variant bg-surface-container-low px-6 py-4">
                    <h2 class="text-headline-md text-primary">SEO</h2>
                </div>

                <div class="grid gap-5 p-6">
                    <label class="grid gap-2">
                        <span class="text-label-md text-on-surface">Meta title</span>
                        <input name="meta_title" value="{{ old('meta_title', $page->meta_title) }}" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                        @error('meta_title') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                    </label>

                    <label class="grid gap-2">
                        <span class="text-label-md text-on-surface">Meta description</span>
                        <textarea name="meta_description" rows="3" class="rounded border border-outline-variant bg-surface px-3 py-2 text-body-md outline-none transition focus:border-primary">{{ old('meta_description', $page->meta_description) }}</textarea>
                        @error('meta_description') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                    </label>
                </div>
            </section>
        </div>

        <aside class="space-y-6">
            <div class="border border-outline-variant bg-surface-container-lowest p-6">
                <p class="text-label-sm uppercase tracking-wider text-on-surface-variant">Estado</p>
                <div class="mt-4 space-y-4">
                    <label class="flex items-center gap-3">
                        <input name="is_home" type="checkbox" value="1" @checked(old('is_home', $page->is_home)) class="size-4 rounded border-outline-variant text-primary focus:ring-primary focus:ring-offset-0">
                        <span class="text-body-sm text-on-surface-variant">Usar como home</span>
                    </label>
                    <label class="flex items-center gap-3">
                        <input name="is_published" type="checkbox" value="1" @checked(old('is_published', $page->is_published)) class="size-4 rounded border-outline-variant text-primary focus:ring-primary focus:ring-offset-0">
                        <span class="text-body-sm text-on-surface-variant">Publicada</span>
                    </label>
                    <label class="flex items-center gap-3">
                        <input name="show_in_navigation" type="checkbox" value="1" @checked(old('show_in_navigation', $page->show_in_navigation)) class="size-4 rounded border-outline-variant text-primary focus:ring-primary focus:ring-offset-0">
                        <span class="text-body-sm text-on-surface-variant">Mostrar en navegacion</span>
                    </label>
                </div>
            </div>

            <div class="border border-outline-variant bg-surface-container-lowest p-6">
                <p class="text-label-sm uppercase tracking-wider text-on-surface-variant">Navegacion</p>
                <div class="mt-4 grid gap-4">
                    <label class="grid gap-2">
                        <span class="text-label-md text-on-surface">Etiqueta</span>
                        <input name="navigation_label" value="{{ old('navigation_label', $page->navigation_label) }}" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                        @error('navigation_label') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                    </label>
                    <label class="grid gap-2">
                        <span class="text-label-md text-on-surface">Orden</span>
                        <input name="sort_order" type="number" min="0" value="{{ old('sort_order', $page->sort_order) }}" required class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                        @error('sort_order') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                    </label>
                </div>
            </div>

            <div class="border border-outline-variant bg-surface-container-lowest p-6">
                <button type="submit" class="flex h-11 w-full items-center justify-center gap-2 rounded bg-primary px-5 text-label-md text-on-primary transition hover:opacity-90">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Guardar cambios
                </button>
                <a href="{{ route('dashboard.pages.index') }}" class="mt-3 flex h-11 w-full items-center justify-center rounded border border-outline-variant text-label-md text-primary transition hover:bg-surface-container-low">
                    Cancelar
                </a>
            </div>
        </aside>
    </form>
</x-dashboard-layout>
