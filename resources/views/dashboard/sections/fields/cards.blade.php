@php
    $items = collect(data_get($content, 'items', []))->values();
    $rows = max($items->count(), 3);
@endphp

<label class="grid gap-2 sm:col-span-2">
    <span class="text-label-md text-on-surface">Titulo</span>
    <input name="content[title]" value="{{ data_get($content, 'title') }}" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
    @error('content.title') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
</label>

<div class="grid gap-4 sm:col-span-2">
    <div>
        <p class="text-label-md text-on-surface">Tarjetas</p>
        <p class="mt-1 text-body-sm text-on-surface-variant">Completa solo las filas que necesites.</p>
    </div>

    @for ($index = 0; $index < $rows; $index++)
        @php
            $item = $items->get($index, []);
            $itemTitle = is_array($item) ? data_get($item, 'title') : $item;
        @endphp
        <div class="grid gap-3 rounded border border-outline-variant bg-surface-container-lowest p-4 sm:grid-cols-3">
            <label class="grid gap-2">
                <span class="text-label-sm text-on-surface-variant">Icono</span>
                <input name="content[items][{{ $index }}][icon]" value="{{ is_array($item) ? data_get($item, 'icon') : '' }}" placeholder="bolt" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
            </label>
            <label class="grid gap-2">
                <span class="text-label-sm text-on-surface-variant">Titulo</span>
                <input name="content[items][{{ $index }}][title]" value="{{ $itemTitle }}" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
            </label>
            <label class="grid gap-2">
                <span class="text-label-sm text-on-surface-variant">Descripcion</span>
                <input name="content[items][{{ $index }}][description]" value="{{ is_array($item) ? data_get($item, 'description') : '' }}" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
            </label>
        </div>
    @endfor
</div>
