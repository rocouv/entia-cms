<x-dashboard-layout title="Nuevo servicio">
    <section class="mb-8">
        <p class="text-label-sm uppercase tracking-[0.2em] text-on-surface-variant">Servicios</p>
        <h1 class="mt-2 text-headline-lg text-primary">Crear servicio</h1>
        <p class="mt-2 max-w-2xl text-body-md text-on-surface-variant">
            Define descripcion, publicacion, categoria e imagen del servicio.
        </p>
    </section>

    @include('dashboard.services._form', [
        'action' => route('dashboard.services.store'),
        'method' => 'POST',
        'submitLabel' => 'Crear servicio',
    ])
</x-dashboard-layout>
