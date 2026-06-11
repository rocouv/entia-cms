<x-dashboard-layout title="Subir media">
    <section class="mb-8">
        <p class="text-label-sm uppercase tracking-[0.2em] text-on-surface-variant">Media</p>
        <h1 class="mt-2 text-headline-lg text-primary">Subir archivo</h1>
        <p class="mt-2 max-w-2xl text-body-md text-on-surface-variant">
            Usa archivos ligeros y descriptivos. Este MVP acepta imagenes y PDFs de hasta 5 MB.
        </p>
    </section>

    <form method="POST" action="{{ route('dashboard.media.store') }}" enctype="multipart/form-data" class="grid gap-6 lg:grid-cols-3">
        @csrf

        <section class="border border-outline-variant bg-surface-container-lowest lg:col-span-2">
            <div class="border-b border-outline-variant bg-surface-container-low px-6 py-4">
                <h2 class="text-headline-md text-primary">Archivo</h2>
                <p class="mt-1 text-body-sm text-on-surface-variant">El archivo se guardara en `storage/app/public/media`.</p>
            </div>

            <div class="grid gap-5 p-6">
                <label class="grid gap-2">
                    <span class="text-label-md text-on-surface">Archivo</span>
                    <input name="file" type="file" required accept="image/jpeg,image/png,image/webp,image/gif,application/pdf" class="rounded border border-outline-variant bg-surface px-3 py-2 text-body-md outline-none transition file:mr-4 file:rounded file:border-0 file:bg-primary file:px-4 file:py-2 file:text-label-md file:text-on-primary focus:border-primary">
                    @error('file') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                </label>

                <label class="grid gap-2">
                    <span class="text-label-md text-on-surface">Texto alternativo</span>
                    <input name="alt_text" value="{{ old('alt_text') }}" maxlength="255" placeholder="Descripcion breve para accesibilidad" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                    @error('alt_text') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                </label>
            </div>
        </section>

        <aside class="space-y-6">
            <div class="border border-outline-variant bg-surface-container-lowest p-6">
                <p class="text-label-sm uppercase tracking-wider text-on-surface-variant">Formatos</p>
                <ul class="mt-4 space-y-2 text-body-sm text-on-surface-variant">
                    <li>JPG, PNG, WebP o GIF</li>
                    <li>PDF</li>
                    <li>Maximo 5 MB</li>
                </ul>
            </div>

            <div class="border border-outline-variant bg-surface-container-lowest p-6">
                <button type="submit" class="flex h-11 w-full items-center justify-center gap-2 rounded bg-primary px-5 text-label-md text-on-primary transition hover:opacity-90">
                    <span class="material-symbols-outlined text-[18px]">cloud_upload</span>
                    Subir archivo
                </button>
                <a href="{{ route('dashboard.media.index') }}" class="mt-3 flex h-11 w-full items-center justify-center rounded border border-outline-variant text-label-md text-primary transition hover:bg-surface-container-low">
                    Cancelar
                </a>
            </div>
        </aside>
    </form>
</x-dashboard-layout>
