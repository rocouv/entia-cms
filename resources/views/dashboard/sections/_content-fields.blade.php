@php
    $selectedType = $selectedType ?? 'hero';
    $content = old('content', $content ?? []);
@endphp

<div class="grid gap-5 p-6 sm:grid-cols-2">
    <label class="grid gap-2 sm:col-span-2">
        <span class="text-label-md text-on-surface">Tipo</span>
        <select name="type" required data-section-type class="h-10 rounded border border-outline-variant bg-surface px-3 text-body-md outline-none transition focus:border-primary">
            @foreach ($types as $value => $label)
                <option value="{{ $value }}" @selected($selectedType === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('type') <span class="text-body-sm text-error">{{ $message }}</span> @enderror
    </label>

    @foreach (array_keys($types) as $type)
        <fieldset data-section-fields="{{ $type }}" class="grid gap-5 sm:col-span-2 sm:grid-cols-2" @if ($selectedType !== $type) hidden disabled @endif>
            @include("dashboard.sections.fields.{$type}", ['content' => $content, 'imageMedia' => $imageMedia])
        </fieldset>
    @endforeach
</div>
