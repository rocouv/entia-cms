<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-surface font-sans text-on-surface antialiased">
        <nav class="fixed inset-x-0 top-0 z-50 border-b border-outline-variant bg-surface">
            <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-6">
                <a href="/" class="text-headline-lg font-black text-primary">Entia</a>
                <div class="hidden items-center gap-8 text-body-md md:flex">
                    <a href="/" class="border-b-2 border-primary pb-1 font-bold text-primary">Inicio</a>
                    <span class="text-on-surface-variant">Servicios</span>
                    <span class="text-on-surface-variant">Proyectos</span>
                    <span class="text-on-surface-variant">Contacto</span>
                </div>
                <a href="{{ route('login') }}" class="rounded bg-primary px-6 py-2 text-label-md text-on-primary transition hover:opacity-80">Dashboard</a>
            </div>
        </nav>

        <main class="pt-16">
            <section class="relative overflow-hidden bg-white py-3xl lg:py-[120px]">
                <div class="wireframe-pattern absolute inset-0 opacity-50"></div>
                <div class="relative z-10 mx-auto flex max-w-7xl flex-col items-center px-6 text-center">
                    <div class="mb-4 inline-block rounded-full bg-secondary-container px-3 py-1 text-label-sm text-on-secondary-container">
                        CMS LARAVEL MONOSITIO
                    </div>
                    <h1 class="max-w-4xl text-headline-xl text-primary sm:text-[56px] sm:leading-[64px]">
                        Base estructurada para sitios autoadministrables con precision y claridad.
                    </h1>
                    <p class="mt-6 max-w-2xl text-body-lg text-on-surface-variant">
                        Entia combina Laravel, Blade, TailwindCSS y SQLite para construir sitios personalizados, editables y faciles de mantener para cada cliente.
                    </p>
                    <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-8 py-4 text-label-md text-on-primary transition hover:opacity-90">
                            Acceder al dashboard
                            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                        </a>
                        <a href="/dashboard" class="inline-flex items-center justify-center rounded-lg border border-outline-variant bg-white px-8 py-4 text-label-md text-primary transition hover:bg-surface-container-low">
                            Ver panel protegido
                        </a>
                    </div>
                </div>
            </section>

            <section class="bg-surface-container-lowest py-3xl">
                <div class="mx-auto max-w-7xl px-6">
                    <div class="mb-12 flex flex-col justify-between gap-4 md:flex-row md:items-end">
                        <div class="max-w-xl">
                            <h2 class="text-headline-lg text-primary">Infraestructura del MVP</h2>
                            <p class="mt-2 text-body-md text-on-surface-variant">Modulos principales listos para crecer sin perder una arquitectura Laravel MVC simple.</p>
                        </div>
                        <span class="text-label-md text-primary">Blade + TailwindCSS + Pest</span>
                    </div>

                    <div class="grid gap-6 md:grid-cols-3">
                        <article class="border border-outline-variant bg-white p-8 transition hover:border-primary">
                            <div class="mb-8 flex size-12 items-center justify-center rounded bg-surface-container-high">
                                <span class="material-symbols-outlined text-primary">dashboard</span>
                            </div>
                            <h3 class="text-headline-md text-primary">Panel administrativo</h3>
                            <p class="mt-4 text-body-sm text-on-surface-variant">Login manual, dashboard protegido, roles administrador/editor y base para gestion editorial.</p>
                        </article>

                        <article class="border border-outline-variant bg-white p-8 transition hover:border-primary">
                            <div class="mb-8 flex size-12 items-center justify-center rounded bg-surface-container-high">
                                <span class="material-symbols-outlined text-primary">view_quilt</span>
                            </div>
                            <h3 class="text-headline-md text-primary">Contenido dinamico</h3>
                            <p class="mt-4 text-body-sm text-on-surface-variant">Paginas administrables, secciones JSON, servicios, proyectos, categorias y media basica.</p>
                        </article>

                        <article class="border border-outline-variant bg-white p-8 transition hover:border-primary">
                            <div class="mb-8 flex size-12 items-center justify-center rounded bg-surface-container-high">
                                <span class="material-symbols-outlined text-primary">mail</span>
                            </div>
                            <h3 class="text-headline-md text-primary">Contacto con Resend</h3>
                            <p class="mt-4 text-body-sm text-on-surface-variant">Formulario publico con validacion server-side, honeypot y rate limiting sin guardar leads.</p>
                        </article>
                    </div>
                </div>
            </section>

            <section class="border-y border-outline-variant bg-white py-3xl">
                <div class="mx-auto grid max-w-7xl gap-12 px-6 lg:grid-cols-2 lg:items-center">
                    <div class="order-2 aspect-[4/3] rounded-lg border border-outline-variant bg-surface-container-low wireframe-pattern lg:order-1"></div>
                    <div class="order-1 lg:order-2">
                        <span class="mb-2 block text-label-md uppercase tracking-[0.2em] text-primary">Filosofia</span>
                        <h2 class="text-headline-xl text-primary">Construido para editar contenido sin complejidad innecesaria.</h2>
                        <p class="mt-6 text-body-md text-on-surface-variant">
                            El sistema prioriza estructura, jerarquia y flujos claros. Cada instalacion vive en el dominio real del cliente, sin multisitio ni SPA en el MVP.
                        </p>
                        <div class="mt-8 grid grid-cols-2 gap-6">
                            <div>
                                <p class="text-headline-md text-primary">1 sitio</p>
                                <p class="text-body-sm text-on-surface-variant">por instalacion</p>
                            </div>
                            <div>
                                <p class="text-headline-md text-primary">SQLite</p>
                                <p class="text-body-sm text-on-surface-variant">por default MVP</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-primary py-3xl text-on-primary">
                <div class="mx-auto max-w-7xl px-6 text-center">
                    <h2 class="text-headline-xl">Listo para continuar con Semana 2.</h2>
                    <p class="mx-auto mt-4 max-w-2xl text-body-lg opacity-80">El siguiente bloque construye configuracion general, usuarios editores y media basica.</p>
                </div>
            </section>
        </main>

        <footer class="border-t border-outline-variant bg-surface-container-lowest">
            <div class="mx-auto flex max-w-7xl flex-col justify-between gap-8 px-6 py-12 md:flex-row">
                <div class="max-w-xs">
                    <p class="text-headline-md text-primary">Entia</p>
                    <p class="mt-3 text-body-sm text-on-surface-variant">CMS Laravel de alta utilidad para sitios administrables personalizados.</p>
                </div>
                <div class="grid gap-8 text-body-sm text-on-surface-variant sm:grid-cols-3">
                    <div class="grid gap-2">
                        <span class="text-label-md text-primary">Producto</span>
                        <span>Paginas</span>
                        <span>Secciones</span>
                        <span>Media</span>
                    </div>
                    <div class="grid gap-2">
                        <span class="text-label-md text-primary">Modulos</span>
                        <span>Servicios</span>
                        <span>Proyectos</span>
                        <span>Contacto</span>
                    </div>
                    <div class="grid gap-2">
                        <span class="text-label-md text-primary">Sistema</span>
                        <span>Roles</span>
                        <span>SQLite</span>
                        <span>Resend</span>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
