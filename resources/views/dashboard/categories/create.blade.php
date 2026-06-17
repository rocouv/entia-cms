<x-dashboard-layout title="Nueva categoria">
    <section class="mb-8">
        <p class="text-label-sm uppercase tracking-[0.2em] text-on-surface-variant">Categorias</p>
        <h1 class="mt-2 text-headline-lg text-primary">Crear categoria</h1>
        <p class="mt-2 max-w-2xl text-body-md text-on-surface-variant">
            Define una categoria compartida para agrupar servicios y proyectos.
        </p>
    </section>

    @include('dashboard.categories._form', [
        'action' => route('dashboard.categories.store'),
        'method' => 'POST',
        'submitLabel' => 'Crear categoria',
    ])
</x-dashboard-layout>
