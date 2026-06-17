<x-dashboard-layout title="Editar proyecto">
    <section class="mb-8">
        <p class="text-label-sm uppercase tracking-[0.2em] text-on-surface-variant">Proyectos</p>
        <h1 class="mt-2 text-headline-lg text-primary">Editar proyecto</h1>
        <p class="mt-2 max-w-2xl text-body-md text-on-surface-variant">
            Actualiza contenido, cliente, estado publico y SEO del proyecto.
        </p>
    </section>

    @include('dashboard.projects._form', [
        'project' => $project,
        'action' => route('dashboard.projects.update', $project),
        'method' => 'PUT',
        'submitLabel' => 'Guardar cambios',
    ])
</x-dashboard-layout>
