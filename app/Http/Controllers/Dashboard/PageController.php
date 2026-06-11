<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StorePageRequest;
use App\Http\Requests\Dashboard\UpdatePageRequest;
use App\Models\Page;
use App\Models\Site;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        $site = $this->siteFor(auth()->user());

        return view('dashboard.pages.index', [
            'pages' => Page::query()
                ->whereBelongsTo($site)
                ->orderBy('sort_order')
                ->orderBy('title')
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('dashboard.pages.create');
    }

    public function store(StorePageRequest $request): RedirectResponse
    {
        $site = $this->siteFor($request->user());
        $attributes = $this->attributesFrom($request->validated(), $request->boolean(...));

        if ($attributes['is_home']) {
            Page::query()->whereBelongsTo($site)->update(['is_home' => false]);
        }

        Page::query()->create([
            ...$attributes,
            'site_id' => $site->id,
        ]);

        return to_route('dashboard.pages.index')->with('status', 'Pagina creada correctamente.');
    }

    public function edit(Page $page): View
    {
        $this->ensurePageBelongsToCurrentSite($page, auth()->user());

        return view('dashboard.pages.edit', [
            'page' => $page,
        ]);
    }

    public function update(UpdatePageRequest $request, Page $page): RedirectResponse
    {
        $site = $this->siteFor($request->user());
        $this->ensurePageBelongsToCurrentSite($page, $request->user());

        $attributes = $this->attributesFrom($request->validated(), $request->boolean(...));

        if ($attributes['is_home']) {
            Page::query()
                ->whereBelongsTo($site)
                ->whereKeyNot($page->id)
                ->update(['is_home' => false]);
        }

        $page->update($attributes);

        return to_route('dashboard.pages.index')->with('status', 'Pagina actualizada correctamente.');
    }

    public function destroy(Page $page): RedirectResponse
    {
        $this->ensurePageBelongsToCurrentSite($page, auth()->user());
        $page->delete();

        return to_route('dashboard.pages.index')->with('status', 'Pagina eliminada correctamente.');
    }

    /**
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function attributesFrom(array $validated, callable $boolean): array
    {
        return [
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'excerpt' => $validated['excerpt'] ?? null,
            'body' => $validated['body'] ?? null,
            'is_home' => $boolean('is_home'),
            'is_published' => $boolean('is_published'),
            'show_in_navigation' => $boolean('show_in_navigation'),
            'navigation_label' => $validated['navigation_label'] ?? null,
            'sort_order' => $validated['sort_order'],
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
        ];
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
}
