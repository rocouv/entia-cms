@php
    $project = $project ?? null;
@endphp

<form method="POST" action="{{ $action }}" class="grid gap-6 lg:grid-cols-3">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <div class="space-y-6 lg:col-span-2">
        <section class="border border-outline-variant bg-surface-container-lowest">
            <div class="border-b border-outline-variant bg-surface-container-low px-6 py-4">
                <h2 class="text-headline-md text-primary">Contenido</h2>
                <p class="mt-1 text-body-sm text-on-surface-variant">El slug se genera desde el titulo si lo dejas vacio.</p>
            </div>

            <div class="grid gap-5 p-6">
                <label class="grid gap-2">
                    <span class="text-label-md text-on-surface">Titulo</span>
                    <input name="title" value="{{ old('title', $project?->title) }}" required class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                    @error('title') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                </label>

                <label class="grid gap-2">
                    <span class="text-label-md text-on-surface">Slug</span>
                    <input name="slug" value="{{ old('slug', $project?->slug) }}" placeholder="campana-lanzamiento" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                    @error('slug') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                </label>

                <label class="grid gap-2">
                    <span class="text-label-md text-on-surface">Cliente</span>
                    <input name="client_name" value="{{ old('client_name', $project?->client_name) }}" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                    @error('client_name') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                </label>

                <label class="grid gap-2">
                    <span class="text-label-md text-on-surface">Extracto</span>
                    <textarea name="excerpt" rows="3" class="rounded border border-outline-variant bg-surface px-3 py-2 text-body-md outline-none transition focus:border-primary">{{ old('excerpt', $project?->excerpt) }}</textarea>
                    @error('excerpt') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                </label>

                <label class="grid gap-2">
                    <span class="text-label-md text-on-surface">Descripcion</span>
                    <textarea name="body" rows="8" class="rounded border border-outline-variant bg-surface px-3 py-2 text-body-md outline-none transition focus:border-primary">{{ old('body', $project?->body) }}</textarea>
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
                    <input name="meta_title" value="{{ old('meta_title', $project?->meta_title) }}" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                    @error('meta_title') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                </label>

                <label class="grid gap-2">
                    <span class="text-label-md text-on-surface">Meta description</span>
                    <textarea name="meta_description" rows="3" class="rounded border border-outline-variant bg-surface px-3 py-2 text-body-md outline-none transition focus:border-primary">{{ old('meta_description', $project?->meta_description) }}</textarea>
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
                    <input name="is_published" type="checkbox" value="1" @checked(old('is_published', $project?->is_published ?? false)) class="size-4 rounded border-outline-variant text-primary focus:ring-primary focus:ring-offset-0">
                    <span class="text-body-sm text-on-surface-variant">Publicado</span>
                </label>
                <label class="flex items-center gap-3">
                    <input name="is_featured" type="checkbox" value="1" @checked(old('is_featured', $project?->is_featured ?? false)) class="size-4 rounded border-outline-variant text-primary focus:ring-primary focus:ring-offset-0">
                    <span class="text-body-sm text-on-surface-variant">Destacado</span>
                </label>
            </div>
        </div>

        <div class="border border-outline-variant bg-surface-container-lowest p-6">
            <p class="text-label-sm uppercase tracking-wider text-on-surface-variant">Organizacion</p>
            <div class="mt-4 grid gap-4">
                <label class="grid gap-2">
                    <span class="text-label-md text-on-surface">Categoria</span>
                    <select name="category_id" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                        <option value="">Sin categoria</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected((string) old('category_id', $project?->category_id) === (string) $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                </label>

                <label class="grid gap-2">
                    <span class="text-label-md text-on-surface">Orden</span>
                    <input name="sort_order" type="number" min="0" value="{{ old('sort_order', $project?->sort_order ?? 0) }}" required class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                    @error('sort_order') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                </label>
            </div>
        </div>

        <div class="border border-outline-variant bg-surface-container-lowest p-6">
            <p class="text-label-sm uppercase tracking-wider text-on-surface-variant">Imagen principal</p>
            <div class="mt-4 grid gap-4">
                <label class="grid gap-2">
                    <span class="text-label-md text-on-surface">Ruta o URL</span>
                    <input name="image_path" list="project-image-media" value="{{ old('image_path', $project?->image_path) }}" placeholder="media/proyecto.jpg" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                    <datalist id="project-image-media">
                        @foreach($imageMedia as $media)
                            <option value="{{ $media->path }}">{{ $media->original_name }}</option>
                        @endforeach
                    </datalist>
                    @error('image_path') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                </label>
            </div>
        </div>

        <div class="border border-outline-variant bg-surface-container-lowest p-6">
            <button type="submit" class="flex h-11 w-full items-center justify-center gap-2 rounded bg-primary px-5 text-label-md text-on-primary transition hover:opacity-90">
                <span class="material-symbols-outlined text-[18px]">save</span>
                {{ $submitLabel }}
            </button>
            <a href="{{ route('dashboard.projects.index') }}" class="mt-3 flex h-11 w-full items-center justify-center rounded border border-outline-variant text-label-md text-primary transition hover:bg-surface-container-low">
                Cancelar
            </a>
        </div>
    </aside>
</form>
