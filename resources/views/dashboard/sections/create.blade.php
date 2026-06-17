<x-dashboard-layout title="Nueva seccion">
    <section class="mb-8">
        <p class="text-label-sm uppercase tracking-[0.2em] text-on-surface-variant">{{ $page->title }}</p>
        <h1 class="mt-2 text-headline-lg text-primary">Crear seccion</h1>
        <p class="mt-2 max-w-2xl text-body-md text-on-surface-variant">
            Elige el tipo de bloque y completa solo los campos necesarios para ese contenido.
        </p>
    </section>

    <form method="POST" action="{{ route('dashboard.sections.store', $page) }}" class="grid gap-6 lg:grid-cols-3">
        @csrf

        <div class="space-y-6 lg:col-span-2">
            <section class="border border-outline-variant bg-surface-container-lowest">
                <div class="border-b border-outline-variant bg-surface-container-low px-6 py-4">
                    <h2 class="text-headline-md text-primary">Contenido</h2>
                </div>

                @include('dashboard.sections._content-fields', [
                    'content' => [],
                    'selectedType' => old('type', 'hero'),
                ])
            </section>
        </div>

        <aside class="space-y-6">
            <div class="border border-outline-variant bg-surface-container-lowest p-6">
                <p class="text-label-sm uppercase tracking-wider text-on-surface-variant">Estado</p>
                <label class="mt-4 flex items-center gap-3">
                    <input name="is_visible" type="checkbox" value="1" @checked(old('is_visible', true)) class="size-4 rounded border-outline-variant text-primary focus:ring-primary focus:ring-offset-0">
                    <span class="text-body-sm text-on-surface-variant">Visible</span>
                </label>
            </div>

            <div class="border border-outline-variant bg-surface-container-lowest p-6">
                <p class="text-label-sm uppercase tracking-wider text-on-surface-variant">Orden y ajustes</p>
                <div class="mt-4 grid gap-4">
                    <label class="grid gap-2">
                        <span class="text-label-md text-on-surface">Orden</span>
                        <input name="sort_order" type="number" min="0" value="{{ old('sort_order', 0) }}" required class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                        @error('sort_order') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                    </label>
                    <label class="grid gap-2">
                        <span class="text-label-md text-on-surface">Variante</span>
                        <input name="variant" value="{{ old('variant') }}" placeholder="default" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                        @error('variant') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                    </label>
                    <label class="grid gap-2">
                        <span class="text-label-md text-on-surface">Espaciado</span>
                        <input name="spacing" value="{{ old('spacing') }}" placeholder="normal" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                        @error('spacing') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                    </label>
                </div>
            </div>

            <div class="border border-outline-variant bg-surface-container-lowest p-6">
                <button type="submit" class="flex h-11 w-full items-center justify-center gap-2 rounded bg-primary px-5 text-label-md text-on-primary transition hover:opacity-90">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Crear seccion
                </button>
                <a href="{{ route('dashboard.sections.index', $page) }}" class="mt-3 flex h-11 w-full items-center justify-center rounded border border-outline-variant text-label-md text-primary transition hover:bg-surface-container-low">
                    Cancelar
                </a>
            </div>
        </aside>
    </form>

    @include('dashboard.sections._content-fields-script')
</x-dashboard-layout>
