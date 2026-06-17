<x-dashboard-layout title="Editar categoria">
    <section class="mb-8">
        <p class="text-label-sm uppercase tracking-[0.2em] text-on-surface-variant">Categorias</p>
        <h1 class="mt-2 text-headline-lg text-primary">Editar categoria</h1>
        <p class="mt-2 max-w-2xl text-body-md text-on-surface-variant">
            Actualiza nombre, orden y visibilidad de la categoria.
        </p>
    </section>

    @include('dashboard.categories._form', [
        'category' => $category,
        'action' => route('dashboard.categories.update', $category),
        'method' => 'PUT',
        'submitLabel' => 'Guardar cambios',
    ])
</x-dashboard-layout>
