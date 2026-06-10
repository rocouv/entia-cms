<x-guest-layout title="Acceso administrativo">
    <div class="w-full max-w-[400px] rounded-lg border border-outline-variant bg-surface-container-lowest p-8 shadow-sm">
        <div class="mb-12 flex flex-col items-center text-center">
            <div class="mb-4 flex size-12 items-center justify-center rounded bg-primary text-on-primary">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">account_tree</span>
            </div>
            <h1 class="text-headline-lg text-primary">Entia CMS</h1>
            <p class="text-body-sm text-on-surface-variant">Acceso al panel administrativo</p>
        </div>

        <form method="POST" action="{{ route('login.store') }}" class="space-y-6">
            @csrf

            <div class="space-y-2">
                <label for="email" class="block text-label-md text-on-surface">Correo electronico</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="admin@entia.local"
                    class="h-10 w-full rounded border border-outline-variant bg-surface px-4 text-body-md text-on-surface outline-none transition placeholder:text-on-surface-variant/50 focus:border-primary"
                >
                @error('email')
                    <p class="text-body-sm text-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="password" class="block text-label-md text-on-surface">Contrasena</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="current-password"
                    class="h-10 w-full rounded border border-outline-variant bg-surface px-4 text-body-md text-on-surface outline-none transition focus:border-primary"
                >
                @error('password')
                    <p class="text-body-sm text-error">{{ $message }}</p>
                @enderror
            </div>

            <label class="flex items-center gap-2 text-body-sm text-on-surface-variant">
                <input name="remember" type="checkbox" value="1" class="size-4 rounded border-outline-variant text-primary focus:ring-primary focus:ring-offset-0">
                Mantener sesion iniciada
            </label>

            <button type="submit" class="h-11 w-full rounded bg-primary px-5 text-label-md text-on-primary transition hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 active:scale-[0.98]">
                Entrar al dashboard
            </button>
        </form>

        <div class="mt-8 border-t border-outline-variant pt-6 text-center">
            <p class="text-body-sm text-on-surface-variant">Base local: <span class="font-semibold text-primary">admin@entia.local</span></p>
        </div>
    </div>
</x-guest-layout>
