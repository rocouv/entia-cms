@php
    $category = $category ?? null;
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
                <p class="mt-1 text-body-sm text-on-surface-variant">El slug se genera desde el nombre si lo dejas vacio.</p>
            </div>

            <div class="grid gap-5 p-6">
                <label class="grid gap-2">
                    <span class="text-label-md text-on-surface">Nombre</span>
                    <input name="name" value="{{ old('name', $category?->name) }}" required class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                    @error('name') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                </label>

                <label class="grid gap-2">
                    <span class="text-label-md text-on-surface">Slug</span>
                    <input name="slug" value="{{ old('slug', $category?->slug) }}" placeholder="branding" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                    @error('slug') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                </label>

                <label class="grid gap-2">
                    <span class="text-label-md text-on-surface">Descripcion</span>
                    <textarea name="description" rows="4" class="rounded border border-outline-variant bg-surface px-3 py-2 text-body-md outline-none transition focus:border-primary">{{ old('description', $category?->description) }}</textarea>
                    @error('description') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                </label>
            </div>
        </section>
    </div>

    <aside class="space-y-6">
        <div class="border border-outline-variant bg-surface-container-lowest p-6">
            <p class="text-label-sm uppercase tracking-wider text-on-surface-variant">Estado</p>
            <div class="mt-4 space-y-4">
                <label class="flex items-center gap-3">
                    <input name="is_active" type="checkbox" value="1" @checked(old('is_active', $category?->is_active ?? true)) class="size-4 rounded border-outline-variant text-primary focus:ring-primary focus:ring-offset-0">
                    <span class="text-body-sm text-on-surface-variant">Activa</span>
                </label>
                <label class="grid gap-2">
                    <span class="text-label-md text-on-surface">Orden</span>
                    <input name="sort_order" type="number" min="0" value="{{ old('sort_order', $category?->sort_order ?? 0) }}" required class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                    @error('sort_order') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                </label>
            </div>
        </div>

        <div class="border border-outline-variant bg-surface-container-lowest p-6">
            <button type="submit" class="flex h-11 w-full items-center justify-center gap-2 rounded bg-primary px-5 text-label-md text-on-primary transition hover:opacity-90">
                <span class="material-symbols-outlined text-[18px]">save</span>
                {{ $submitLabel }}
            </button>
            <a href="{{ route('dashboard.categories.index') }}" class="mt-3 flex h-11 w-full items-center justify-center rounded border border-outline-variant text-label-md text-primary transition hover:bg-surface-container-low">
                Cancelar
            </a>
        </div>
    </aside>
</form>
