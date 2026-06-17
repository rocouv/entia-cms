<label class="grid gap-2 sm:col-span-2">
    <span class="text-label-md text-on-surface">Titulo</span>
    <input name="content[title]" value="{{ data_get($content, 'title') }}" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
    @error('content.title') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
</label>

<label class="grid gap-2">
    <span class="text-label-md text-on-surface">ID de categoria</span>
    <input name="content[category_id]" type="number" min="1" value="{{ data_get($content, 'category_id') }}" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
    @error('content.category_id') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
</label>

<label class="grid gap-2">
    <span class="text-label-md text-on-surface">Limite</span>
    <input name="content[limit]" type="number" min="1" max="24" value="{{ data_get($content, 'limit') }}" placeholder="6" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
    @error('content.limit') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
</label>
