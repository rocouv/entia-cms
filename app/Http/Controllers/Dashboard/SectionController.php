<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreSectionRequest;
use App\Http\Requests\Dashboard\UpdateSectionRequest;
use App\Models\Page;
use App\Models\Section;
use App\Models\Site;
use App\Models\User;
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
        $items = collect(preg_split('/\r\n|\r|\n/', (string) ($validated['items_text'] ?? '')))
            ->map(fn (string $item): string => trim($item))
            ->filter()
            ->values()
            ->all();

        return array_filter([
            'title' => $validated['content_title'] ?? null,
            'subtitle' => $validated['subtitle'] ?? null,
            'body' => $validated['content_body'] ?? null,
            'image' => $validated['image'] ?? null,
            'image_position' => $validated['image_position'] ?? null,
            'button_text' => $validated['button_text'] ?? null,
            'button_url' => $validated['button_url'] ?? null,
            'items' => $items,
            'category_id' => $validated['category_id'] ?? null,
            'limit' => isset($validated['limit']) ? (int) $validated['limit'] : null,
            'show_form' => $boolean('show_form'),
        ], fn (mixed $value): bool => $value !== null && $value !== [] && $value !== '');
    }

    private function siteFor(User $user): Site
    {
        if ($user->site_id) {
            return Site::query()->findOrFail($user->site_id);
        }

        return Site::query()->firstOrFail();
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
