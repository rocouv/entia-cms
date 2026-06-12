<x-dashboard-layout title="Configuracion">
    <section class="mb-8">
        <h1 class="mt-2 text-headline-lg text-primary">Configuracion general del sitio</h1>
        <p class="mt-2 max-w-2xl text-body-md text-on-surface-variant">
            Administra los datos del cliente, del sitio y la informacion publica principal.
        </p>
    </section>

    @if (session('status'))
        <div class="mb-6 border border-outline-variant bg-surface-container-lowest px-6 py-4 text-body-sm text-primary">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('dashboard.settings.update') }}" class="grid gap-6 lg:grid-cols-3">
        @csrf
        @method('PUT')

        <div class="space-y-6 lg:col-span-2">
            <section class="border border-outline-variant bg-surface-container-lowest">
                <div class="border-b border-outline-variant bg-surface-container-low px-6 py-4">
                    <h2 class="text-headline-md text-primary">Datos del cliente</h2>
                    <p class="mt-1 text-body-sm text-on-surface-variant">Datos del cliente propietario de esta instalacion.</p>
                </div>

                <div class="grid gap-5 p-6 sm:grid-cols-2">
                    <label class="grid gap-2 sm:col-span-2">
                        <span class="text-label-md text-on-surface">Nombre del cliente</span>
                        <input name="client_name" value="{{ old('client_name', $site->client->name) }}" required class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                        @error('client_name') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                    </label>

                    <label class="grid gap-2 sm:col-span-2">
                        <span class="text-label-md text-on-surface">Razon social</span>
                        <input name="client_legal_name" value="{{ old('client_legal_name', $site->client->legal_name) }}" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                        @error('client_legal_name') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                    </label>

                    <label class="grid gap-2">
                        <span class="text-label-md text-on-surface">Correo del cliente</span>
                        <input name="client_contact_email" type="email" value="{{ old('client_contact_email', $site->client->contact_email) }}" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                        @error('client_contact_email') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                    </label>

                    <label class="grid gap-2">
                        <span class="text-label-md text-on-surface">Telefono del cliente</span>
                        <input name="client_contact_phone" value="{{ old('client_contact_phone', $site->client->contact_phone) }}" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                        @error('client_contact_phone') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                    </label>
                </div>
            </section>

            <section class="border border-outline-variant bg-surface-container-lowest">
                <div class="border-b border-outline-variant bg-surface-container-low px-6 py-4">
                    <h2 class="text-headline-md text-primary">Datos del sitio</h2>
                    <p class="mt-1 text-body-sm text-on-surface-variant">Nombre y dominio publico del sitio.</p>
                </div>

                <div class="grid gap-5 p-6 sm:grid-cols-2">
                    <label class="grid gap-2">
                        <span class="text-label-md text-on-surface">Nombre del sitio</span>
                        <input name="site_name" value="{{ old('site_name', $site->name) }}" required class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                        @error('site_name') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                    </label>

                    <label class="grid gap-2">
                        <span class="text-label-md text-on-surface">Dominio</span>
                        <input name="domain" value="{{ old('domain', $site->domain) }}" placeholder="cliente.com" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                        @error('domain') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                    </label>

                    <label class="grid gap-2 sm:col-span-2">
                        <span class="text-label-md text-on-surface">Frase descriptiva</span>
                        <input name="tagline" value="{{ old('tagline', $site->settings->tagline) }}" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                        @error('tagline') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                    </label>

                    <label class="flex items-center gap-3 sm:col-span-2">
                        <input name="is_active" type="checkbox" value="1" @checked(old('is_active', $site->is_active)) class="size-4 rounded border-outline-variant text-primary focus:ring-primary focus:ring-offset-0">
                        <span class="text-body-sm text-on-surface-variant">Sitio activo</span>
                    </label>
                </div>
            </section>

            <section class="border border-outline-variant bg-surface-container-lowest">
                <div class="border-b border-outline-variant bg-surface-container-low px-6 py-4">
                    <h2 class="text-headline-md text-primary">Contacto y SEO</h2>
                    <p class="mt-1 text-body-sm text-on-surface-variant">Informacion de contacto y configuracion SEO del sitio.</p>
                </div>

                <div class="grid gap-5 p-6 sm:grid-cols-2">
                    <label class="grid gap-2">
                        <span class="text-label-md text-on-surface">Correo publico</span>
                        <input name="contact_email" type="email" value="{{ old('contact_email', $site->settings->contact_email) }}" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                        @error('contact_email') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                    </label>

                    <label class="grid gap-2">
                        <span class="text-label-md text-on-surface">Telefono publico</span>
                        <input name="contact_phone" value="{{ old('contact_phone', $site->settings->contact_phone) }}" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                        @error('contact_phone') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                    </label>

                    <label class="grid gap-2 sm:col-span-2">
                        <span class="text-label-md text-on-surface">Direccion</span>
                        <textarea name="address" rows="3" class="rounded border border-outline-variant bg-surface px-3 py-2 text-body-md outline-none transition focus:border-primary">{{ old('address', $site->settings->address) }}</textarea>
                        @error('address') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                    </label>

                    <label class="grid gap-2 sm:col-span-2">
                        <span class="text-label-md text-on-surface">Meta title</span>
                        <input name="meta_title" value="{{ old('meta_title', $site->settings->meta_title) }}" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                        @error('meta_title') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                    </label>

                    <label class="grid gap-2 sm:col-span-2">
                        <span class="text-label-md text-on-surface">Meta description</span>
                        <textarea name="meta_description" rows="3" class="rounded border border-outline-variant bg-surface px-3 py-2 text-body-md outline-none transition focus:border-primary">{{ old('meta_description', $site->settings->meta_description) }}</textarea>
                        @error('meta_description') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                    </label>
                </div>
            </section>

            @php
                $themeDefaults = \App\Models\SiteSetting::THEME_DEFAULTS;
                $theme = array_replace($themeDefaults, $site->settings->theme ?? []);
                $themeGroups = [
                    'Marca' => [
                        'primary' => 'Color principal',
                        'on_primary' => 'Texto sobre principal',
                        'primary_container' => 'Fondo destacado',
                        'on_primary_container' => 'Texto sobre destacado',
                    ],
                    'Secundarios' => [
                        'secondary' => 'Color secundario',
                        'on_secondary' => 'Texto sobre secundario',
                        'secondary_container' => 'Fondo de etiquetas',
                        'on_secondary_container' => 'Texto sobre etiquetas',
                        'tertiary' => 'Color terciario',
                        'on_tertiary' => 'Texto sobre terciario',
                    ],
                    'Superficies' => [
                        'background' => 'Fondo general',
                        'surface' => 'Superficie base',
                        'surface_container_lowest' => 'Contenedor blanco',
                        'surface_container_low' => 'Contenedor bajo',
                        'surface_container' => 'Contenedor medio',
                        'surface_container_high' => 'Contenedor alto',
                        'surface_container_highest' => 'Contenedor maximo',
                    ],
                    'Texto y bordes' => [
                        'on_surface' => 'Texto principal',
                        'on_surface_variant' => 'Texto secundario',
                        'outline' => 'Borde principal',
                        'outline_variant' => 'Borde sutil',
                    ],
                    'Errores' => [
                        'error' => 'Color de error',
                        'on_error' => 'Texto sobre error',
                        'error_container' => 'Fondo de error',
                        'on_error_container' => 'Texto sobre fondo de error',
                    ],
                ];
            @endphp

            <section class="border border-outline-variant bg-surface-container-lowest">
                <div class="border-b border-outline-variant bg-surface-container-low px-6 py-4">
                    <h2 class="text-headline-md text-primary">Tema visual</h2>
                    <p class="mt-1 text-body-sm text-on-surface-variant">Personaliza colores y tipografia del sitio publico y dashboard.</p>
                </div>

                <div class="space-y-8 p-6">
                    <label class="grid gap-2">
                        <span class="text-label-md text-on-surface">Tipografia principal</span>
                        <select name="theme[font_family]" class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                            @foreach(\App\Models\SiteSetting::FONT_FAMILIES as $fontFamily => $fontUrl)
                                <option value="{{ $fontFamily }}" @selected(old('theme.font_family', $theme['font_family']) === $fontFamily)>{{ $fontFamily }}</option>
                            @endforeach
                        </select>
                        @error('theme.font_family') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                    </label>

                    @foreach($themeGroups as $groupTitle => $fields)
                        <div>
                            <h3 class="text-label-sm uppercase tracking-wider text-on-surface-variant">{{ $groupTitle }}</h3>
                            <div class="mt-4 grid gap-5 sm:grid-cols-2">
                                @foreach($fields as $key => $label)
                                    <label class="grid gap-2">
                                        <span class="text-label-md text-on-surface">{{ $label }}</span>
                                        <div class="flex items-center gap-3 rounded border border-outline-variant bg-surface px-3 py-2">
                                            <input type="color" name="theme[{{ $key }}]" value="{{ old('theme.'.$key, $theme[$key]) }}" class="h-8 w-10 rounded border border-outline-variant bg-transparent p-0">
                                            <span class="text-body-sm text-on-surface-variant">{{ old('theme.'.$key, $theme[$key]) }}</span>
                                        </div>
                                        @error('theme.'.$key) <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <div class="rounded border border-outline-variant bg-surface p-6">
                        <p class="text-label-sm uppercase tracking-wider text-on-surface-variant">Vista previa</p>
                        <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center">
                            <span class="inline-flex h-10 items-center justify-center rounded bg-primary px-5 text-label-md text-on-primary">Boton principal</span>
                            <span class="inline-flex rounded bg-secondary-container px-3 py-1 text-label-sm text-on-secondary-container">Etiqueta</span>
                            <span class="text-body-md text-on-surface">Texto principal</span>
                            <span class="text-body-md text-on-surface-variant">Texto secundario</span>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <aside class="space-y-6">
            <div class="border border-outline-variant bg-surface-container-lowest p-6">
                <h2 class="text-headline-md text-primary">Resumen</h2>
                <dl class="mt-5 space-y-4 text-body-sm">
                    <div class="flex justify-between gap-4">
                        <dt class="text-on-surface-variant">Cliente</dt>
                        <dd class="font-semibold text-primary">{{ $site->client->name }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-on-surface-variant">Sitio</dt>
                        <dd class="font-semibold text-primary">{{ $site->name }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-on-surface-variant">Estado</dt>
                        <dd class="font-semibold text-primary">{{ $site->is_active ? 'Activo' : 'Inactivo' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="border border-outline-variant bg-surface-container-lowest p-6">
                <p class="text-label-sm uppercase tracking-wider text-on-surface-variant">Accion</p>
                <button type="submit" class="mt-4 flex h-11 w-full items-center justify-center gap-2 rounded bg-primary px-5 text-label-md text-on-primary transition hover:opacity-90">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Guardar configuracion
                </button>
                <p class="mt-4 text-body-sm text-on-surface-variant">Los cambios se reflejan automaticamente en el sitio publico.</p>
            </div>
        </aside>
    </form>
</x-dashboard-layout>
