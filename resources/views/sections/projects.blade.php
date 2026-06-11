<section class="bg-{{ $settings['background_color'] ?? 'white' }} py-3xl">
    <div class="mx-auto max-w-7xl px-6 text-center">
        @if($content['title'] ?? false)
            <h2 class="text-headline-lg font-bold">{{ $content['title'] }}</h2>
        @endif
        <p class="mt-6 text-body-md text-on-surface-variant">Los proyectos se configuran desde el panel de administracion.</p>
        <a href="{{ route('login') }}" class="mt-6 inline-block rounded bg-primary px-6 py-2 text-label-md text-on-primary transition hover:opacity-80">
            Administrar proyectos
        </a>
    </div>
</section>
