<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreSectionRequest;
use App\Http\Requests\Dashboard\UpdateSectionRequest;
use App\Models\Category;
use App\Models\Media;
use App\Models\Page;
use App\Models\Section;
use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SectionController extends Controller
{
    public function index(Page $page): View
    {
        $this->ensurePageBelongsToCurrentSite($page, auth()->user());

        return view('dashboard.sections.index', [
            'page' => $page,
            'sections' => $page->sections()
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(),
        ]);
    }

    public function create(Page $page): View
    {
        $this->ensurePageBelongsToCurrentSite($page, auth()->user());

        return view('dashboard.sections.create', [
            'page' => $page,
            'types' => Section::TYPES,
            'categories' => $this->categoriesFor(auth()->user()),
            'imageMedia' => $this->imageMediaFor(auth()->user()),
        ]);
    }

    public function store(StoreSectionRequest $request, Page $page): RedirectResponse
    {
        $this->ensurePageBelongsToCurrentSite($page, $request->user());

        $page->sections()->create($this->attributesFrom($request->validated(), $request->boolean(...)));

        return to_route('dashboard.sections.index', $page)->with('status', 'Seccion creada correctamente.');
    }

    public function edit(Page $page, Section $section): View
    {
        $this->ensureSectionBelongsToPage($page, $section, auth()->user());

        return view('dashboard.sections.edit', [
            'page' => $page,
            'section' => $section,
            'types' => Section::TYPES,
            'categories' => $this->categoriesFor(auth()->user()),
            'imageMedia' => $this->imageMediaFor(auth()->user()),
        ]);
    }

    public function update(UpdateSectionRequest $request, Page $page, Section $section): RedirectResponse
    {
        $this->ensureSectionBelongsToPage($page, $section, $request->user());

        $section->update($this->attributesFrom($request->validated(), $request->boolean(...)));

        return to_route('dashboard.sections.index', $page)->with('status', 'Seccion actualizada correctamente.');
    }

    public function destroy(Page $page, Section $section): RedirectResponse
    {
        $this->ensureSectionBelongsToPage($page, $section, auth()->user());
        $section->delete();

        return to_route('dashboard.sections.index', $page)->with('status', 'Seccion eliminada correctamente.');
    }

    /**
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function attributesFrom(array $validated, callable $boolean): array
    {
        return [
            'type' => $validated['type'],
            'content' => $this->contentFrom($validated, $boolean),
            'settings' => [
                'variant' => $validated['variant'] ?? null,
                'spacing' => $validated['spacing'] ?? null,
            ],
            'sort_order' => $validated['sort_order'],
            'is_visible' => $boolean('is_visible'),
        ];
    }

    /**
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function contentFrom(array $validated, callable $boolean): array
    {
        $content = $this->typedContentFrom($validated['type'], $validated['content'] ?? [], $boolean);

        if (array_key_exists('content', $validated)) {
            return $content;
        }

        return $this->legacyContentFrom($validated, $boolean);
    }

    /**
     * @param  array<string, mixed>  $content
     * @return array<string, mixed>
     */
    private function typedContentFrom(string $type, array $content, callable $boolean): array
    {
        $content = match ($type) {
            'hero' => [
                'title' => $content['title'] ?? null,
                'subtitle' => $content['subtitle'] ?? null,
                'image' => $content['image'] ?? null,
                'button_text' => $content['button_text'] ?? null,
                'button_url' => $content['button_url'] ?? null,
            ],
            'text_block' => [
                'title' => $content['title'] ?? null,
                'body' => $content['body'] ?? null,
            ],
            'image_text' => [
                'title' => $content['title'] ?? null,
                'body' => $content['body'] ?? null,
                'image' => $content['image'] ?? null,
                'image_position' => $content['image_position'] ?? null,
            ],
            'cards' => [
                'title' => $content['title'] ?? null,
                'items' => $this->cardItemsFromArray($content['items'] ?? []),
            ],
            'gallery' => [
                'title' => $content['title'] ?? null,
                'images' => $this->galleryItemsFromArray($content['images'] ?? []),
            ],
            'services', 'projects' => [
                'title' => $content['title'] ?? null,
                'category_id' => filled($content['category_id'] ?? null) ? (int) $content['category_id'] : null,
                'limit' => isset($content['limit']) ? (int) $content['limit'] : null,
            ],
            'contact' => [
                'title' => $content['title'] ?? null,
                'body' => $content['body'] ?? null,
                'show_form' => $boolean('content.show_form'),
            ],
            'faq' => [
                'title' => $content['title'] ?? null,
                'items' => $this->faqItemsFromArray($content['items'] ?? []),
            ],
            default => [],
        };

        return $this->filledContent($content);
    }

    /**
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function legacyContentFrom(array $validated, callable $boolean): array
    {
        $items = $this->itemsFrom($validated['type'], $validated['items_text'] ?? null);
        $itemsKey = $validated['type'] === 'gallery' ? 'images' : 'items';

        return $this->filledContent([
            'title' => $validated['content_title'] ?? null,
            'subtitle' => $validated['subtitle'] ?? null,
            'body' => $validated['content_body'] ?? null,
            'image' => $validated['image'] ?? null,
            'image_position' => $validated['image_position'] ?? null,
            'button_text' => $validated['button_text'] ?? null,
            'button_url' => $validated['button_url'] ?? null,
            $itemsKey => $items,
            'category_id' => filled($validated['category_id'] ?? null) ? (int) $validated['category_id'] : null,
            'limit' => isset($validated['limit']) ? (int) $validated['limit'] : null,
            'show_form' => $boolean('show_form'),
        ]);
    }

    /**
     * @param  array<string, mixed>  $content
     * @return array<string, mixed>
     */
    private function filledContent(array $content): array
    {
        return array_filter($content, fn (mixed $value): bool => $value !== null && $value !== [] && $value !== '');
    }

    /**
     * @param  array<int, array<string, string|null>>  $items
     * @return array<int, array<string, string>>
     */
    private function cardItemsFromArray(array $items): array
    {
        return collect($items)
            ->map(fn (array $item): array => array_filter([
                'icon' => $item['icon'] ?? null,
                'title' => $item['title'] ?? null,
                'description' => $item['description'] ?? null,
            ], fn (?string $value): bool => filled($value)))
            ->filter()
            ->values()
            ->all();
    }

    /**
     * @param  array<int|string, array<string, string|null>>  $images
     * @return array<int, array<string, string>>
     */
    private function galleryItemsFromArray(array $images): array
    {
        return collect($images)
            ->filter(function (array $image): bool {
                if (array_key_exists('selected', $image)) {
                    return filter_var($image['selected'], FILTER_VALIDATE_BOOLEAN) && filled($image['url'] ?? null);
                }

                return filled($image['url'] ?? null);
            })
            ->map(fn (array $image): array => array_filter([
                'url' => $image['url'] ?? null,
                'alt' => $image['alt'] ?? null,
            ], fn (?string $value): bool => filled($value)))
            ->values()
            ->all();
    }

    /**
     * @param  array<int, array<string, string|null>>  $items
     * @return array<int, array<string, string>>
     */
    private function faqItemsFromArray(array $items): array
    {
        return collect($items)
            ->map(fn (array $item): array => array_filter([
                'question' => $item['question'] ?? null,
                'answer' => $item['answer'] ?? null,
            ], fn (?string $value): bool => filled($value)))
            ->filter()
            ->values()
            ->all();
    }

    /**
     * @return array<int, mixed>
     */
    private function itemsFrom(string $type, ?string $itemsText): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $itemsText))
            ->map(fn (string $item): string => trim($item))
            ->filter()
            ->map(fn (string $item): mixed => match ($type) {
                'cards' => $this->cardItemFrom($item),
                'faq' => $this->faqItemFrom($item),
                'gallery' => $this->galleryItemFrom($item),
                default => $item,
            })
            ->values()
            ->all();
    }

    /**
     * @return array<string, string>|string
     */
    private function cardItemFrom(string $item): array|string
    {
        if (! str_contains($item, '|')) {
            return $item;
        }

        [$icon, $title, $description] = array_pad(array_map('trim', explode('|', $item, 3)), 3, null);

        return array_filter([
            'icon' => $icon,
            'title' => $title,
            'description' => $description,
        ], fn (?string $value): bool => filled($value));
    }

    /**
     * @return array<string, string>|string
     */
    private function faqItemFrom(string $item): array|string
    {
        if (! str_contains($item, '|')) {
            return $item;
        }

        [$question, $answer] = array_pad(array_map('trim', explode('|', $item, 2)), 2, null);

        return array_filter([
            'question' => $question,
            'answer' => $answer,
        ], fn (?string $value): bool => filled($value));
    }

    /**
     * @return array<string, string>|string
     */
    private function galleryItemFrom(string $item): array|string
    {
        if (! str_contains($item, '|')) {
            return $item;
        }

        [$url, $alt] = array_pad(array_map('trim', explode('|', $item, 2)), 2, null);

        return array_filter([
            'url' => $url,
            'alt' => $alt,
        ], fn (?string $value): bool => filled($value));
    }

    private function siteFor(User $user): Site
    {
        if ($user->site_id) {
            return Site::query()->findOrFail($user->site_id);
        }

        return Site::query()->firstOrFail();
    }

    /**
     * @return Collection<int, Media>
     */
    private function imageMediaFor(User $user): Collection
    {
        return Media::query()
            ->whereBelongsTo($this->siteFor($user))
            ->where('mime_type', 'like', 'image/%')
            ->latest()
            ->get();
    }

    /**
     * @return Collection<int, Category>
     */
    private function categoriesFor(User $user): Collection
    {
        return Category::query()
            ->whereBelongsTo($this->siteFor($user))
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }

    private function ensurePageBelongsToCurrentSite(Page $page, User $user): void
    {
        abort_unless($page->site_id === $this->siteFor($user)->id, 404);
    }

    private function ensureSectionBelongsToPage(Page $page, Section $section, User $user): void
    {
        $this->ensurePageBelongsToCurrentSite($page, $user);
        abort_unless($section->page_id === $page->id, 404);
    }
}
