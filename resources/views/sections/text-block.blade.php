<section class="bg-{{ $settings['background_color'] ?? 'white' }} py-3xl">
    <div class="mx-auto max-w-3xl px-6">
        @if($content['title'] ?? false)
            <h2 class="text-headline-lg font-bold">{{ $content['title'] }}</h2>
        @endif
        @if($content['body'] ?? false)
            <div class="prose prose-lg mt-4 max-w-none">
                {{ $content['body'] }}
            </div>
        @endif
    </div>
</section>
