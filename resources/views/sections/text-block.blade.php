<section class="bg-{{ $settings['background_color'] ?? 'white' }} py-3xl">
    <div class="mx-auto max-w-7xl px-6">
        <div class="max-w-5xl">
        @if($content['title'] ?? false)
            <h2 class="text-headline-xl font-bold">{{ $content['title'] }}</h2>
        @endif
        @if($content['body'] ?? false)
            <div class="mt-6 max-w-none text-body-lg text-on-surface-variant">
                {{ $content['body'] }}
            </div>
        @endif
        </div>
    </div>
</section>
