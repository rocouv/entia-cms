<label class="grid gap-2 sm:col-span-2">
    <span class="text-label-md text-on-surface">Titulo</span>
    <input name="content[title]" value="{{ data_get($content, 'title') }}" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
    @error('content.title') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
</label>

<label class="grid gap-2 sm:col-span-2">
    <span class="text-label-md text-on-surface">Cuerpo</span>
    <textarea name="content[body]" rows="8" class="rounded border border-outline-variant bg-surface px-3 py-2 text-body-md outline-none transition focus:border-primary">{{ data_get($content, 'body') }}</textarea>
    @error('content.body') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
</label>
