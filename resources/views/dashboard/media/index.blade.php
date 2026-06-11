<x-dashboard-layout title="Media">
    <section class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="mt-2 text-headline-lg text-primary">Media</h1>
            <p class="mt-2 max-w-2xl text-body-md text-on-surface-variant">
                Sube y administra imagenes y PDFs para usarlos en el contenido del sitio.
            </p>
        </div>

        <a href="{{ route('dashboard.media.create') }}" class="inline-flex h-11 items-center justify-center gap-2 rounded bg-primary px-5 text-label-md text-on-primary transition hover:opacity-90">
            <span class="material-symbols-outlined text-[18px]">cloud_upload</span>
            Subir archivo
        </a>
    </section>

    @if (session('status'))
        <div class="mb-6 border border-outline-variant bg-surface-container-lowest px-6 py-4 text-body-sm text-primary">
            {{ session('status') }}
        </div>
    @endif

    <section class="border border-outline-variant bg-surface-container-lowest">
        <div class="border-b border-outline-variant bg-surface-container-low px-6 py-4">
            <h2 class="text-headline-md text-primary">Biblioteca</h2>
            <p class="mt-1 text-body-sm text-on-surface-variant">Archivos disponibles para usar en paginas y secciones.</p>
        </div>

        @if ($media->isNotEmpty())
            <div class="grid gap-5 p-6 sm:grid-cols-2 xl:grid-cols-3">
                @foreach ($media as $item)
                    <article class="overflow-hidden border border-outline-variant bg-surface">
                        <div class="flex aspect-video items-center justify-center bg-surface-container-high">
                            @if ($item->isImage())
                                <img src="{{ $item->url() }}" alt="{{ $item->alt_text ?: $item->original_name }}" class="h-full w-full object-cover">
                            @else
                                <span class="material-symbols-outlined text-[48px] text-on-surface-variant">description</span>
                            @endif
                        </div>

                        <div class="space-y-4 p-5">
                            <div>
                                <h3 class="truncate text-label-lg text-primary">{{ $item->original_name }}</h3>
                                <p class="mt-1 text-body-sm text-on-surface-variant">{{ $item->mime_type }} · {{ number_format($item->size / 1024, 1) }} KB</p>
                            </div>

                            @if ($item->alt_text)
                                <p class="text-body-sm text-on-surface-variant">{{ $item->alt_text }}</p>
                            @endif

                            <div class="flex items-center justify-between gap-3 border-t border-outline-variant pt-4">
                                <a href="{{ $item->url() }}" target="_blank" class="text-label-md text-primary hover:underline">Abrir</a>
                                <form method="POST" action="{{ route('dashboard.media.destroy', $item) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-label-md text-error hover:underline">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="px-6 py-16 text-center">
                <span class="material-symbols-outlined text-[56px] text-on-surface-variant">perm_media</span>
                <h3 class="mt-4 text-headline-md text-primary">Todavia no hay archivos</h3>
                <p class="mx-auto mt-2 max-w-md text-body-md text-on-surface-variant">Sube imagenes o PDFs para dejarlos listos antes de crear paginas y secciones.</p>
                <a href="{{ route('dashboard.media.create') }}" class="mt-6 inline-flex h-11 items-center justify-center rounded bg-primary px-5 text-label-md text-on-primary transition hover:opacity-90">
                    Subir primer archivo
                </a>
            </div>
        @endif
    </section>
</x-dashboard-layout>
