<x-dashboard-layout title="Editar usuario">
    <section class="mb-8">
        <p class="text-label-sm uppercase tracking-[0.2em] text-on-surface-variant">Usuarios</p>
        <h1 class="mt-2 text-headline-lg text-primary">Editar usuario</h1>
        <p class="mt-2 max-w-2xl text-body-md text-on-surface-variant">
            Actualiza los datos de acceso del usuario. Deja la contrasena vacia si no quieres cambiarla.
        </p>
    </section>

    <form method="POST" action="{{ route('dashboard.users.update', $user) }}" class="grid gap-6 lg:grid-cols-3">
        @csrf
        @method('PUT')

        <section class="border border-outline-variant bg-surface-container-lowest lg:col-span-2">
            <div class="border-b border-outline-variant bg-surface-container-low px-6 py-4">
                <h2 class="text-headline-md text-primary">Datos de acceso</h2>
                <p class="mt-1 text-body-sm text-on-surface-variant">El rol se muestra como referencia y no se modifica desde esta pantalla.</p>
            </div>

            <div class="grid gap-5 p-6 sm:grid-cols-2">
                <label class="grid gap-2 sm:col-span-2">
                    <span class="text-label-md text-on-surface">Nombre</span>
                    <input name="name" value="{{ old('name', $user->name) }}" required class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                    @error('name') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                </label>

                <label class="grid gap-2 sm:col-span-2">
                    <span class="text-label-md text-on-surface">Correo</span>
                    <input name="email" type="email" value="{{ old('email', $user->email) }}" required class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                    @error('email') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                </label>

                <label class="grid gap-2">
                    <span class="text-label-md text-on-surface">Nueva contrasena</span>
                    <input name="password" type="password" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                    @error('password') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                </label>

                <label class="grid gap-2">
                    <span class="text-label-md text-on-surface">Confirmar contrasena</span>
                    <input name="password_confirmation" type="password" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                </label>
            </div>
        </section>

        <aside class="space-y-6">
            <div class="border border-outline-variant bg-surface-container-lowest p-6">
                <p class="text-label-sm uppercase tracking-wider text-on-surface-variant">Rol</p>
                <p class="mt-2 text-headline-md text-primary">{{ $user->role->name }}</p>
                <p class="mt-3 text-body-sm text-on-surface-variant">La gestion de roles avanzados queda fuera del MVP.</p>
            </div>

            <div class="border border-outline-variant bg-surface-container-lowest p-6">
                <button type="submit" class="flex h-11 w-full items-center justify-center gap-2 rounded bg-primary px-5 text-label-md text-on-primary transition hover:opacity-90">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Guardar cambios
                </button>
                <a href="{{ route('dashboard.users.index') }}" class="mt-3 flex h-11 w-full items-center justify-center rounded border border-outline-variant text-label-md text-primary transition hover:bg-surface-container-low">
                    Cancelar
                </a>
            </div>
        </aside>
    </form>
</x-dashboard-layout>
