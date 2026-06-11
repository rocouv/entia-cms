<section class="bg-{{ $settings['background_color'] ?? 'white' }} py-3xl">
    <div class="mx-auto max-w-7xl px-6">
        @if($content['title'] ?? false)
            <h2 class="text-center text-headline-lg font-bold">{{ $content['title'] }}</h2>
        @endif
        @if($content['images'] ?? false)
            <div class="mt-10 grid gap-6 md:grid-cols-3">
                @foreach($content['images'] as $image)
                    <div class="overflow-hidden rounded-xl shadow-sm">
                        <img src="{{ asset('storage/' . ($image['url'] ?? $image)) }}" alt="{{ $image['alt'] ?? '' }}" class="h-64 w-full object-cover transition duration-300 hover:scale-105">
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
