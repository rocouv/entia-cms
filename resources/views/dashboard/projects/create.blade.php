<x-dashboard-layout title="Nuevo proyecto">
    <section class="mb-8">
        <p class="text-label-sm uppercase tracking-[0.2em] text-on-surface-variant">Proyectos</p>
        <h1 class="mt-2 text-headline-lg text-primary">Crear proyecto</h1>
        <p class="mt-2 max-w-2xl text-body-md text-on-surface-variant">
            Define descripcion, cliente, categoria, estado e imagen del proyecto.
        </p>
    </section>

    @include('dashboard.projects._form', [
        'action' => route('dashboard.projects.store'),
        'method' => 'POST',
        'submitLabel' => 'Crear proyecto',
    ])
</x-dashboard-layout>
