@php
    $items = collect(data_get($content, 'items', []))->values();
    $rows = max($items->count(), 3);
    $availableIcons = [
        'accessibility', 'analytics', 'anchor', 'apps', 'architecture', 'attach_money',
        'auto_awesome', 'balance', 'bolt', 'build', 'calendar_month', 'campaign',
        'chat', 'check_circle', 'code', 'design_services', 'eco', 'email', 'event',
        'explore', 'favorite', 'flag', 'groups', 'handshake', 'headset_mic', 'home',
        'insights', 'language', 'lightbulb', 'lock', 'mail', 'mark_email_read',
        'monitoring', 'palette', 'psychology', 'query_stats', 'rocket_launch', 'route',
        'school', 'search', 'settings', 'speed', 'star', 'strategy', 'support_agent',
        'target', 'thumb_up', 'trending_up', 'tune', 'verified', 'visibility', 'web',
        'work', 'workspace_premium',
    ];
@endphp

<label class="grid gap-2 sm:col-span-2">
    <span class="text-label-md text-on-surface">Titulo</span>
    <input name="content[title]" value="{{ data_get($content, 'title') }}" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
    @error('content.title') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
</label>

<div class="grid gap-4 sm:col-span-2">
    <div>
        <p class="text-label-md text-on-surface">Tarjetas</p>
        <p class="mt-1 text-body-sm text-on-surface-variant">Empieza con tres tarjetas y agrega mas cuando lo necesites. Busca cualquier icono Material por nombre.</p>
    </div>

    <div id="cards-fields" class="grid gap-4">
    @for ($index = 0; $index < $rows; $index++)
        @php
            $item = $items->get($index, []);
            $itemTitle = is_array($item) ? data_get($item, 'title') : $item;
        @endphp
        @php
            $itemIcon = is_array($item) ? data_get($item, 'icon') : null;
        @endphp
        <div data-card-field class="relative grid gap-3 rounded border border-outline-variant bg-surface-container-lowest p-4 pr-14 sm:grid-cols-3">
            <button type="button" data-remove-card class="absolute right-3 top-3 rounded p-1 text-on-surface-variant transition hover:bg-error-container hover:text-error" aria-label="Eliminar tarjeta">
                <span class="material-symbols-outlined text-[20px]">delete</span>
            </button>
            <label class="grid gap-2">
                <span class="text-label-sm text-on-surface-variant">Icono</span>
                <div class="flex items-center gap-2">
                    <span class="flex size-10 shrink-0 items-center justify-center rounded border border-outline-variant bg-surface-container text-primary" @if(! $itemIcon) hidden @endif>
                        <span data-icon-preview class="material-symbols-outlined relative -top-px text-xl leading-none">{{ $itemIcon }}</span>
                    </span>
                    <input name="content[items][{{ $index }}][icon]" data-field="icon" list="material-icons-list" value="{{ $itemIcon }}" placeholder="Buscar icono" class="h-10 min-w-0 flex-1 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                </div>
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

    <button type="button" id="add-card-field" class="inline-flex w-fit items-center gap-2 rounded border border-outline-variant bg-surface-container-lowest px-4 py-2 text-label-md text-primary transition hover:border-primary">
        <span class="material-symbols-outlined text-[18px]">add</span>
        Agregar tarjeta
    </button>
</div>

<template id="card-field-template">
    <div data-card-field class="relative grid gap-3 rounded border border-outline-variant bg-surface-container-lowest p-4 pr-14 sm:grid-cols-3">
        <button type="button" data-remove-card class="absolute right-3 top-3 rounded p-1 text-on-surface-variant transition hover:bg-error-container hover:text-error" aria-label="Eliminar tarjeta">
            <span class="material-symbols-outlined text-[20px]">delete</span>
        </button>
        <label class="grid gap-2">
            <span class="text-label-sm text-on-surface-variant">Icono</span>
            <div class="flex items-center gap-2">
                <span class="flex size-10 shrink-0 items-center justify-center rounded border border-outline-variant bg-surface-container text-primary" hidden>
                    <span data-icon-preview class="material-symbols-outlined relative -top-px text-xl leading-none"></span>
                </span>
                <input data-field="icon" list="material-icons-list" placeholder="Buscar icono" class="h-10 min-w-0 flex-1 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
            </div>
        </label>
        <label class="grid gap-2">
            <span class="text-label-sm text-on-surface-variant">Titulo</span>
            <input data-field="title" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
        </label>
        <label class="grid gap-2">
            <span class="text-label-sm text-on-surface-variant">Descripcion</span>
            <input data-field="description" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
        </label>
    </div>
</template>

<datalist id="material-icons-list">
    @foreach($availableIcons as $icon)
        <option value="{{ $icon }}">{{ str_replace('_', ' ', str($icon)->title()) }}</option>
    @endforeach
</datalist>

@push('scripts')
    <script>
        document.getElementById('add-card-field')?.addEventListener('click', () => {
            const fields = document.getElementById('cards-fields');
            const template = document.getElementById('card-field-template');
            const card = template.content.cloneNode(true);

            fields.appendChild(card);
            renumberCards();
        });

        const fields = document.getElementById('cards-fields');

        function renumberCards() {
            fields?.querySelectorAll('[data-card-field]').forEach((card, index) => {
                card.querySelectorAll('[data-field]').forEach((input) => {
                    input.name = `content[items][${index}][${input.dataset.field}]`;
                });
            });
        }

        function updateIconPreview(card) {
            const select = card.querySelector('[data-field="icon"]');
            const preview = card.querySelector('[data-icon-preview]');

            if (!select || !preview) {
                return;
            }

            preview.textContent = select.value;
            preview.parentElement.hidden = !select.value;
        }

        fields?.querySelectorAll('[data-card-field]').forEach((card) => {
            updateIconPreview(card);
        });

        fields?.addEventListener('change', (event) => {
            if (event.target.matches('[data-field="icon"]')) {
                updateIconPreview(event.target.closest('[data-card-field]'));
            }
        });

        fields?.addEventListener('click', (event) => {
            if (event.target.closest('[data-remove-card]')) {
                event.target.closest('[data-card-field]').remove();
                renumberCards();
            }
        });

        fetch('https://fonts.google.com/metadata/icons')
            .then((response) => response.json())
            .then((catalog) => {
                const iconList = document.getElementById('material-icons-list');

                catalog.icons?.forEach((icon) => {
                    if (!iconList.querySelector(`option[value="${CSS.escape(icon.name)}"]`)) {
                        const option = document.createElement('option');
                        option.value = icon.name;
                        option.textContent = icon.name.replaceAll('_', ' ');
                        iconList.appendChild(option);
                    }
                });
            })
            .catch(() => {
                // Las sugerencias locales siguen disponibles si el catalogo no carga.
            });

        renumberCards();
    </script>
@endpush
