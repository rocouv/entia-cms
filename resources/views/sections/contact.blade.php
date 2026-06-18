<section class="bg-{{ $settings['background_color'] ?? 'surface-container-lowest' }} py-3xl">
    <div class="mx-auto max-w-5xl px-6">
        <div class="mx-auto max-w-5xl text-center">
            @if($content['title'] ?? false)
                <h2 class="text-headline-lg font-bold">{{ $content['title'] }}</h2>
            @endif
            @if($content['body'] ?? false)
                <p class="mt-4 max-w-none text-body-lg leading-relaxed text-on-surface-variant">{{ $content['body'] }}</p>
            @endif
        </div>

        @if($content['show_form'] ?? false)
            <form method="POST" action="{{ route('contact.store') }}" class="mt-10 rounded-2xl border border-outline-variant bg-surface p-6 text-left shadow-sm">
                @csrf

                @if(session('status'))
                    <div class="mb-6 rounded-lg border border-primary/30 bg-primary/10 px-4 py-3 text-body-sm text-primary">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="hidden" aria-hidden="true">
                    <label for="contact-website">Sitio web</label>
                    <input id="contact-website" name="website" tabindex="-1" autocomplete="off" value="{{ old('website') }}">
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <label class="grid gap-2">
                        <span class="text-label-md text-on-surface">Nombre</span>
                        <input name="name" value="{{ old('name') }}" required class="h-11 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                        @error('name') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                    </label>

                    <label class="grid gap-2">
                        <span class="text-label-md text-on-surface">Correo</span>
                        <input name="email" type="email" value="{{ old('email') }}" required class="h-11 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                        @error('email') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                    </label>

                    <label class="grid gap-2 sm:col-span-2">
                        <span class="text-label-md text-on-surface">Telefono <span class="font-normal text-on-surface-variant">(opcional)</span></span>
                        <input name="phone" value="{{ old('phone') }}" class="h-11 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
                        @error('phone') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                    </label>

                    <label class="grid gap-2 sm:col-span-2">
                        <span class="text-label-md text-on-surface">Mensaje</span>
                        <textarea name="message" rows="6" required class="rounded border border-outline-variant bg-surface px-3 py-2 text-body-md outline-none transition focus:border-primary">{{ old('message') }}</textarea>
                        @error('message') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
                    </label>
                </div>

                <button type="submit" class="mt-6 rounded bg-primary px-6 py-3 text-label-md font-bold text-on-primary transition hover:opacity-80">
                    Enviar mensaje
                </button>
            </form>
        @endif
    </div>
</section>
