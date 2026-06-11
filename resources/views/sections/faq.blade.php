<section class="bg-{{ $settings['background_color'] ?? 'white' }} py-3xl">
    <div class="mx-auto max-w-3xl px-6">
        @if($content['title'] ?? false)
            <h2 class="text-center text-headline-lg font-bold">{{ $content['title'] }}</h2>
        @endif
        @if($content['items'] ?? false)
            <div class="mt-10 space-y-4">
                @foreach($content['items'] as $item)
                    <details class="group rounded-xl border border-outline-variant bg-surface">
                        <summary class="flex cursor-pointer items-center justify-between px-6 py-4 text-body-md font-semibold">
                            {{ $item['question'] ?? '' }}
                            <span class="material-symbols-outlined transition group-open:rotate-180">expand_more</span>
                        </summary>
                        @if($item['answer'] ?? false)
                            <div class="border-t border-outline-variant px-6 py-4 text-body-md text-on-surface-variant">
                                {{ $item['answer'] }}
                            </div>
                        @endif
                    </details>
                @endforeach
            </div>
        @endif
    </div>
</section>
