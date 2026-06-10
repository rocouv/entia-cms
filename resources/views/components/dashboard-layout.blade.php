@props(['title' => 'Dashboard'])

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
        <div class="min-h-screen lg:flex">
            <aside class="border-b border-outline-variant bg-surface-container-low px-4 py-4 lg:fixed lg:inset-y-0 lg:left-0 lg:z-40 lg:w-[260px] lg:border-b-0 lg:border-r">
                <a href="{{ route('dashboard') }}" class="block text-headline-md font-bold text-primary">Entia CMS</a>
                <p class="text-label-sm text-on-surface-variant">Admin Console</p>

                <nav class="mt-8 grid gap-1 text-body-sm font-medium">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded bg-secondary-container px-4 py-2.5 font-semibold text-on-secondary-container transition hover:bg-surface-container-high">
                        <span class="material-symbols-outlined text-[20px]">dashboard</span>
                        Dashboard
                    </a>
                    <span class="flex items-center gap-3 rounded px-4 py-2.5 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">settings</span>
                        Configuracion
                    </span>
                    <span class="flex items-center gap-3 rounded px-4 py-2.5 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">description</span>
                        Paginas
                    </span>
                    <span class="flex items-center gap-3 rounded px-4 py-2.5 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">view_quilt</span>
                        Secciones
                    </span>
                    <span class="flex items-center gap-3 rounded px-4 py-2.5 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">image</span>
                        Media
                    </span>
                    <span class="flex items-center gap-3 rounded px-4 py-2.5 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">build</span>
                        Servicios
                    </span>
                    <span class="flex items-center gap-3 rounded px-4 py-2.5 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">business_center</span>
                        Proyectos
                    </span>
                    <span class="flex items-center gap-3 rounded px-4 py-2.5 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">group</span>
                        Usuarios
                    </span>
                </nav>

                <div class="mt-8 border-t border-outline-variant pt-4">
                    <a href="/" class="flex items-center justify-center gap-2 rounded bg-primary px-4 py-2.5 text-label-md text-on-primary transition hover:opacity-90">
                        <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                        Ver sitio
                    </a>
                </div>
            </aside>

            <div class="flex-1 lg:ml-[260px]">
                <header class="sticky top-0 z-30 flex min-h-16 flex-col gap-4 border-b border-outline-variant bg-surface px-6 py-4 sm:flex-row sm:items-center sm:justify-between lg:h-16 lg:py-0">
                    <div>
                        <p class="text-label-sm text-on-surface-variant">Admin / <span class="font-bold text-primary">{{ $title }}</span></p>
                        <p class="text-body-sm text-on-surface-variant">Sesion activa como {{ auth()->user()->name }}</p>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        <label class="relative hidden md:block">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">search</span>
                            <input type="search" placeholder="Buscar contenido..." class="h-10 w-64 rounded border border-outline-variant bg-surface-container px-10 text-body-sm text-on-surface outline-none transition placeholder:text-on-surface-variant/70 focus:border-primary">
                        </label>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="inline-flex h-10 items-center justify-center gap-2 rounded border border-outline-variant bg-surface-container-lowest px-4 text-label-md text-primary transition hover:border-primary hover:bg-surface-container-low">
                                <span class="material-symbols-outlined text-[18px]">logout</span>
                                Cerrar sesion
                            </button>
                        </form>
                    </div>
                </header>

                <main class="mx-auto max-w-7xl px-6 py-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
