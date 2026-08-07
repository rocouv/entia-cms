@php
    $fieldPrefix = $fieldPrefix ?? 'content[image]';
    $imageValues = $imageValues ?? [];
    $imagePositions = [
        'left top' => 'Izquierda arriba',
        'center top' => 'Centro arriba',
        'right top' => 'Derecha arriba',
        'left center' => 'Izquierda centro',
        'center center' => 'Centro',
        'right center' => 'Derecha centro',
        'left bottom' => 'Izquierda abajo',
        'center bottom' => 'Centro abajo',
        'right bottom' => 'Derecha abajo',
    ];
@endphp

<div class="grid gap-4 rounded border border-outline-variant bg-surface-container-low p-4 sm:col-span-2">
    <div>
        <p class="text-label-md text-on-surface">Ajustes de imagen</p>
        <p class="mt-1 text-body-sm text-on-surface-variant">Controla transparencia, encuadre y posicion focal.</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-3">
        <label class="grid gap-2">
            <span class="text-label-sm text-on-surface-variant">Alpha / opacidad (%)</span>
            <input type="number" name="{{ $fieldPrefix }}[opacity]" value="{{ data_get($imageValues, 'opacity', 100) }}" min="0" max="100" step="1" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
        </label>

        <label class="grid gap-2">
            <span class="text-label-sm text-on-surface-variant">Posicion</span>
            <select name="{{ $fieldPrefix }}[object_position]" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                @foreach($imagePositions as $value => $label)
                    <option value="{{ $value }}" @selected(data_get($imageValues, 'object_position', 'center center') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </label>

        <label class="grid gap-2">
            <span class="text-label-sm text-on-surface-variant">Ajuste</span>
            <select name="{{ $fieldPrefix }}[fit]" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                <option value="cover" @selected(data_get($imageValues, 'fit', 'cover') === 'cover')>Cubrir (cover)</option>
                <option value="contain" @selected(data_get($imageValues, 'fit') === 'contain')>Contener (contain)</option>
                <option value="fill" @selected(data_get($imageValues, 'fit') === 'fill')>Rellenar (fill)</option>
                <option value="none" @selected(data_get($imageValues, 'fit') === 'none')>Original (none)</option>
            </select>
        </label>
    </div>
</div>
