<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $metaTitle ?? $siteSettings?->meta_title ?? $siteSettings?->site_name ?? config('app.name') }}</title>
        @if($metaDescription ?? $siteSettings?->meta_description ?? false)
            <meta name="description" content="{{ $metaDescription ?? $siteSettings->meta_description }}">
        @endif
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-surface font-sans text-on-surface antialiased">
        <nav class="fixed inset-x-0 top-0 z-50 border-b border-outline-variant bg-surface/95 backdrop-blur">
            <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-6">
                <a href="/" class="text-headline-lg font-black text-primary">{{ $siteSettings?->site_name ?? config('app.name') }}</a>
                <div class="hidden items-center gap-8 text-body-md md:flex">
                    @foreach($navigationPages as $navPage)
                        <a href="{{ $navPage->is_home ? '/' : '/' . $navPage->slug }}"
                           class="{{ request()->is($navPage->is_home ? '/' : $navPage->slug) ? 'border-b-2 border-primary pb-1 font-bold text-primary' : 'text-on-surface-variant hover:text-primary' }}">
                            {{ $navPage->navigation_label ?? $navPage->title }}
                        </a>
                    @endforeach
                </div>
                @auth
                    <a href="{{ route('dashboard') }}" class="rounded bg-primary px-6 py-2 text-label-md text-on-primary transition hover:opacity-80">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="rounded bg-primary px-6 py-2 text-label-md text-on-primary transition hover:opacity-80">Dashboard</a>
                @endauth
            </div>
        </nav>

        <main class="pt-16">
            {{ $slot }}
        </main>

        <footer class="border-t border-outline-variant bg-surface-container-lowest">
            <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-6 px-6 py-10 md:flex-row">
                <div class="flex flex-col gap-2 text-center md:text-left">
                    <span class="text-headline-sm font-bold text-primary">{{ $siteSettings?->site_name ?? config('app.name') }}</span>
                    @if($siteSettings?->tagline)
                        <span class="text-body-md text-on-surface-variant">{{ $siteSettings->tagline }}</span>
                    @endif
                </div>
                <div class="flex flex-col items-center gap-4 text-body-sm text-on-surface-variant md:items-end">
                    @if($siteSettings?->contact_email)
                        <a href="mailto:{{ $siteSettings->contact_email }}" class="hover:text-primary">{{ $siteSettings->contact_email }}</a>
                    @endif
                    @if($siteSettings?->contact_phone)
                        <span>{{ $siteSettings->contact_phone }}</span>
                    @endif
                    <span>&copy; {{ date('Y') }} {{ $siteSettings?->site_name ?? config('app.name') }}.</span>
                </div>
            </div>
        </footer>
    </body>
</html>
