<x-dashboard-layout title="Nuevo editor" :breadcrumbs="[
    ['label' => 'Usuarios', 'url' => route('dashboard.users.index')],
    ['label' => 'Nuevo editor'],
]">
    <section class="mb-8">
        <p class="text-label-sm uppercase tracking-[0.2em] text-on-surface-variant">Usuarios</p>
        <h1 class="mt-2 text-headline-lg text-primary">Crear editor</h1>
        <p class="mt-2 max-w-2xl text-body-md text-on-surface-variant">
            Los editores pueden acceder al dashboard y gestionar contenido, pero no usuarios ni configuracion critica.
        </p>
    </section>

    <form method="POST" action="{{ route('dashboard.users.store') }}" class="grid gap-6 lg:grid-cols-3">
        @csrf

        <section class="border border-outline-variant bg-surface-container-lowest lg:col-span-2">
            <div class="border-b border-outline-variant bg-surface-container-low px-6 py-4">
                <h2 class="text-headline-md text-primary">Datos de acceso</h2>
                <p class="mt-1 text-body-sm text-on-surface-variant">Usa un correo unico y una contrasena inicial segura.</p>
            </div>

            <div class="grid gap-5 p-6 sm:grid-cols-2">
                <label class="grid gap-2 sm:col-span-2">
                    <span class="text-label-md text-on-surface">Nombre</span>
                    <input name="name" value="{{ old('name') }}" required class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                    @error('name') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                </label>

                <label class="grid gap-2 sm:col-span-2">
                    <span class="text-label-md text-on-surface">Correo</span>
                    <input name="email" type="email" value="{{ old('email') }}" required class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                    @error('email') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                </label>

                <label class="grid gap-2">
                    <span class="text-label-md text-on-surface">Contrasena</span>
                    <input name="password" type="password" required class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                    @error('password') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                </label>

                <label class="grid gap-2">
                    <span class="text-label-md text-on-surface">Confirmar contrasena</span>
                    <input name="password_confirmation" type="password" required class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                </label>
            </div>
        </section>

        <aside class="space-y-6">
            <div class="border border-outline-variant bg-surface-container-lowest p-6">
                <p class="text-label-sm uppercase tracking-wider text-on-surface-variant">Rol asignado</p>
                <p class="mt-2 text-headline-md text-primary">Editor</p>
                <p class="mt-3 text-body-sm text-on-surface-variant">El rol se asigna automaticamente para evitar cambios de permisos accidentales.</p>
            </div>

            <div class="border border-outline-variant bg-surface-container-lowest p-6">
                <button type="submit" class="flex h-11 w-full items-center justify-center gap-2 rounded bg-primary px-5 text-label-md text-on-primary transition hover:opacity-90">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Crear editor
                </button>
                <a href="{{ route('dashboard.users.index') }}" class="mt-3 flex h-11 w-full items-center justify-center rounded border border-outline-variant text-label-md text-primary transition hover:bg-surface-container-low">
                    Cancelar
                </a>
            </div>
        </aside>
    </form>
</x-dashboard-layout>
