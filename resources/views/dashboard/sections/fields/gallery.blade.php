@php
    $imageMedia = $imageMedia ?? collect();
    $selectedImages = collect(data_get($content, 'images', data_get($content, 'items', [])))->values();
    $selectedPaths = $selectedImages
        ->map(fn ($image) => is_array($image) ? data_get($image, 'url') : $image)
        ->filter()
        ->values()
        ->all();
    $mediaPaths = $imageMedia->pluck('path')->all();
    $manualImages = $selectedImages
        ->reject(fn ($image) => in_array(is_array($image) ? data_get($image, 'url') : $image, $mediaPaths, true))
        ->values();
    $manualRows = max($manualImages->count(), 2);
@endphp

<label class="grid gap-2 sm:col-span-2">
    <span class="text-label-md text-on-surface">Titulo</span>
    <input name="content[title]" value="{{ data_get($content, 'title') }}" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
    @error('content.title') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
</label>

<div class="grid gap-4 sm:col-span-2">
    <div>
        <p class="text-label-md text-on-surface">Seleccionar imagenes de media</p>
        <p class="mt-1 text-body-sm text-on-surface-variant">Marca las imagenes que quieres mostrar en la galeria.</p>
    </div>

    @if ($imageMedia->isEmpty())
        <p class="rounded border border-outline-variant bg-surface-container-low p-4 text-body-sm text-on-surface-variant">
            Todavia no hay imagenes en media para este sitio.
        </p>
    @else
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($imageMedia as $media)
                <label class="grid cursor-pointer gap-3 rounded border border-outline-variant bg-surface-container-lowest p-3 transition hover:bg-surface-container-low">
                    <input type="hidden" name="content[images][media_{{ $media->id }}][selected]" value="0">
                    <input type="hidden" name="content[images][media_{{ $media->id }}][url]" value="{{ $media->path }}">
                    <input type="hidden" name="content[images][media_{{ $media->id }}][alt]" value="{{ $media->alt_text }}">
                    <img src="{{ $media->url() }}" alt="{{ $media->alt_text }}" class="h-32 w-full rounded object-cover">
                    <span class="flex items-start gap-3 text-body-sm text-on-surface-variant">
                        <input name="content[images][media_{{ $media->id }}][selected]" type="checkbox" value="1" @checked(in_array($media->path, $selectedPaths, true)) class="mt-0.5 size-4 rounded border-outline-variant text-primary focus:ring-primary focus:ring-offset-0">
                        <span>{{ $media->alt_text ?: $media->original_name }}</span>
                    </span>
                </label>
            @endforeach
        </div>
    @endif
</div>

<div class="grid gap-4 sm:col-span-2">
    <div>
        <p class="text-label-md text-on-surface">Imagenes manuales</p>
        <p class="mt-1 text-body-sm text-on-surface-variant">Usa rutas como <code>media/archivo.jpg</code> si la imagen no aparece arriba.</p>
    </div>

    @for ($index = 0; $index < $manualRows; $index++)
        @php
            $image = $manualImages->get($index, []);
            $imageUrl = is_array($image) ? data_get($image, 'url') : $image;
        @endphp
        <div class="grid gap-3 rounded border border-outline-variant bg-surface-container-lowest p-4 sm:grid-cols-2">
            <label class="grid gap-2">
                <span class="text-label-sm text-on-surface-variant">Ruta</span>
                <input name="content[images][manual_{{ $index }}][url]" value="{{ $imageUrl }}" placeholder="media/imagen.jpg" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
            </label>
            <label class="grid gap-2">
                <span class="text-label-sm text-on-surface-variant">Texto alternativo</span>
                <input name="content[images][manual_{{ $index }}][alt]" value="{{ is_array($image) ? data_get($image, 'alt') : '' }}" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
            </label>
        </div>
    @endfor
</div>
