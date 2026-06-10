@props(['title' => config('app.name')])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title }} - {{ config('app.name') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-background font-sans text-on-surface antialiased">
        <main class="flex min-h-screen items-center justify-center px-4 py-12 sm:px-6">
            {{ $slot }}
        </main>

        <footer class="border-t border-outline-variant bg-surface-container-lowest">
            <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-2 px-6 py-4 text-body-sm text-on-surface-variant md:flex-row">
                <span>© {{ date('Y') }} Entia CMS ecosystem.</span>
                <div class="flex gap-6">
                    <span>Privacidad</span>
                    <span>Terminos</span>
                    <span>Soporte</span>
                </div>
            </div>
        </footer>
    </body>
</html>
