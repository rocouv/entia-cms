<x-dashboard-layout title="Usuarios">
    <section class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-label-sm uppercase tracking-[0.2em] text-on-surface-variant">Semana 2</p>
            <h1 class="mt-2 text-headline-lg text-primary">Usuarios del dashboard</h1>
            <p class="mt-2 max-w-2xl text-body-md text-on-surface-variant">
                Gestiona los editores que pueden acceder al panel y preparar contenido del sitio.
            </p>
        </div>

        <a href="{{ route('dashboard.users.create') }}" class="inline-flex h-11 items-center justify-center gap-2 rounded bg-primary px-5 text-label-md text-on-primary transition hover:opacity-90">
            <span class="material-symbols-outlined text-[18px]">person_add</span>
            Nuevo editor
        </a>
    </section>

    @if (session('status'))
        <div class="mb-6 border border-outline-variant bg-surface-container-lowest px-6 py-4 text-body-sm text-primary">
            {{ session('status') }}
        </div>
    @endif

    <section class="overflow-hidden border border-outline-variant bg-surface-container-lowest">
        <div class="border-b border-outline-variant bg-surface-container-low px-6 py-4">
            <h2 class="text-headline-md text-primary">Equipo administrativo</h2>
            <p class="mt-1 text-body-sm text-on-surface-variant">Puedes editar la informacion de cualquier usuario. La eliminacion se limita a usuarios editores.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-outline-variant text-left text-body-sm">
                <thead class="bg-surface-container">
                    <tr>
                        <th class="px-6 py-3 font-semibold text-on-surface">Nombre</th>
                        <th class="px-6 py-3 font-semibold text-on-surface">Correo</th>
                        <th class="px-6 py-3 font-semibold text-on-surface">Rol</th>
                        <th class="px-6 py-3 font-semibold text-on-surface">Alta</th>
                        <th class="px-6 py-3 text-right font-semibold text-on-surface">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse ($users as $user)
                        <tr>
                            <td class="px-6 py-4 font-semibold text-primary">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-on-surface-variant">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex rounded bg-secondary-container px-3 py-1 text-label-sm text-on-secondary-container">
                                    {{ $user->role->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-on-surface-variant">{{ $user->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('dashboard.users.edit', $user) }}" class="inline-flex h-9 items-center justify-center rounded border border-outline-variant px-3 text-label-md text-primary transition hover:bg-surface-container-low">
                                        Editar
                                    </a>
                                    @if ($user->hasRole(\App\Models\Role::EDITOR))
                                        <form method="POST" action="{{ route('dashboard.users.destroy', $user) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex h-9 items-center justify-center rounded border border-outline-variant px-3 text-label-md text-error transition hover:bg-error/10">
                                                Eliminar
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-on-surface-variant">Todavia no hay usuarios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-dashboard-layout>
