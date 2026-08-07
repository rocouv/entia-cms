<label class="grid gap-2 sm:col-span-2">
    <span class="text-label-md text-on-surface">Titulo principal</span>
    <input name="content[title]" value="{{ data_get($content, 'title') }}" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
    @error('content.title') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
</label>

@include('dashboard.sections.fields.image-options', [
    'fieldPrefix' => 'content[image_settings]',
    'imageValues' => data_get($content, 'image_settings', []),
])

<label class="grid gap-2">
    <span class="text-label-md text-on-surface">Opacidad de superposicion (%)</span>
    <input name="content[overlay_opacity]" type="number" value="{{ data_get($content, 'overlay_opacity', 40) }}" min="0" max="100" step="1" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
    @error('content.overlay_opacity') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
</label>

<label class="grid gap-2 sm:col-span-2">
    <span class="text-label-md text-on-surface">Subtitulo</span>
    <input name="content[subtitle]" value="{{ data_get($content, 'subtitle') }}" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
    @error('content.subtitle') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
</label>

<label class="grid gap-2 sm:col-span-2">
    <span class="text-label-md text-on-surface">Imagen de fondo</span>
    <input name="content[image]" value="{{ data_get($content, 'image') }}" placeholder="media/imagen.jpg" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
    @error('content.image') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
</label>

<label class="grid gap-2">
    <span class="text-label-md text-on-surface">Texto del boton</span>
    <input name="content[button_text]" value="{{ data_get($content, 'button_text') }}" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
    @error('content.button_text') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
</label>

<label class="grid gap-2">
    <span class="text-label-md text-on-surface">URL del boton</span>
    <input name="content[button_url]" value="{{ data_get($content, 'button_url') }}" placeholder="/contacto" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
    @error('content.button_url') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
</label>
