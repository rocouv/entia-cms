<x-dashboard-layout title="Editar servicio">
    <section class="mb-8">
        <p class="text-label-sm uppercase tracking-[0.2em] text-on-surface-variant">Servicios</p>
        <h1 class="mt-2 text-headline-lg text-primary">Editar servicio</h1>
        <p class="mt-2 max-w-2xl text-body-md text-on-surface-variant">
            Actualiza contenido, estado publico y SEO del servicio.
        </p>
    </section>

    @include('dashboard.services._form', [
        'service' => $service,
        'action' => route('dashboard.services.update', $service),
        'method' => 'PUT',
        'submitLabel' => 'Guardar cambios',
    ])
</x-dashboard-layout>
