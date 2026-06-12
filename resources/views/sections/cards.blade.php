<section class="bg-{{ $settings['background_color'] ?? 'surface-container-lowest' }} py-3xl">
    <div class="mx-auto max-w-7xl px-6">
        @if($content['title'] ?? false)
            <h2 class="text-center text-headline-lg font-bold">{{ $content['title'] }}</h2>
        @endif
        @if($content['items'] ?? false)
            <div class="mt-10 grid gap-8 {{ count($content['items']) <= 2 ? 'md:grid-cols-2' : 'md:grid-cols-3' }}">
                @foreach($content['items'] as $item)
                    @php
                        $itemIcon = is_array($item) ? ($item['icon'] ?? null) : null;
                        $itemTitle = is_array($item) ? ($item['title'] ?? null) : $item;
                        $itemDescription = is_array($item) ? ($item['description'] ?? null) : null;
                    @endphp
                    <div class="rounded-xl border border-outline-variant bg-surface p-8 text-center shadow-sm transition hover:shadow-md">
                        @if($itemIcon)
                            <span class="material-symbols-outlined mb-4 text-4xl text-primary">{{ $itemIcon }}</span>
                        @endif
                        @if($itemTitle)
                            <h3 class="text-headline-sm font-bold">{{ $itemTitle }}</h3>
                        @endif
                        @if($itemDescription)
                            <p class="mt-3 text-body-md text-on-surface-variant">{{ $itemDescription }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
