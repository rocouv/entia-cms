<section class="bg-{{ $settings['background_color'] ?? 'surface-container-lowest' }} py-3xl">
    <div class="mx-auto max-w-7xl px-6">
        @if($content['title'] ?? false)
            <h2 class="text-center text-headline-lg font-bold">{{ $content['title'] }}</h2>
        @endif
        @if($content['items'] ?? false)
            <div class="mt-10 grid gap-8 {{ count($content['items']) <= 2 ? 'md:grid-cols-2' : 'md:grid-cols-3' }}">
                @foreach($content['items'] as $item)
                    <div class="rounded-xl border border-outline-variant bg-surface p-8 text-center shadow-sm transition hover:shadow-md">
                        @if($item['icon'] ?? false)
                            <span class="material-symbols-outlined mb-4 text-4xl text-primary">{{ $item['icon'] }}</span>
                        @endif
                        @if($item['title'] ?? false)
                            <h3 class="text-headline-sm font-bold">{{ $item['title'] }}</h3>
                        @endif
                        @if($item['description'] ?? false)
                            <p class="mt-3 text-body-md text-on-surface-variant">{{ $item['description'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
