<section class="bg-{{ $settings['background_color'] ?? 'surface-container-lowest' }} py-3xl">
    <div class="mx-auto max-w-3xl px-6 text-center">
        @if($content['title'] ?? false)
            <h2 class="text-headline-lg font-bold">{{ $content['title'] }}</h2>
        @endif
        @if($content['body'] ?? false)
            <p class="mt-4 text-body-lg text-on-surface-variant">{{ $content['body'] }}</p>
        @endif
        @if($content['show_form'] ?? false)
            <p class="mt-8 text-body-md text-on-surface-variant">El formulario de contacto estara disponible proximamente.</p>
        @endif
    </div>
</section>
