@php
    $metaTitle = $page->meta_title ?? $page->title;
    $metaDescription = $page->meta_description;
@endphp

<x-layouts.public :title="$metaTitle" :meta-description="$metaDescription">
    @if($page->excerpt)
        <section class="bg-surface-container-lowest py-3xl text-center">
            <div class="mx-auto max-w-3xl px-6">
                <p class="text-body-lg text-on-surface-variant">{{ $page->excerpt }}</p>
            </div>
        </section>
    @endif

    @foreach($page->sections as $section)
        @php
            $viewName = 'sections.' . str_replace('_', '-', $section->type);
        @endphp
        @if(view()->exists($viewName))
            @include($viewName, ['content' => $section->content, 'settings' => $section->settings])
        @else
            @if(config('app.debug'))
                <div class="border border-dashed border-warning mx-6 my-4 rounded-lg p-6 text-center text-warning">
                    Vista no encontrada: <code>{{ $viewName }}</code>
                </div>
            @endif
        @endif
    @endforeach
</x-layouts.public>
