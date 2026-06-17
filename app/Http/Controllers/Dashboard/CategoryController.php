<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreCategoryRequest;
use App\Http\Requests\Dashboard\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Site;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $site = $this->siteFor(auth()->user());

        return view('dashboard.categories.index', [
            'categories' => Category::query()
                ->withCount(['services', 'projects'])
                ->whereBelongsTo($site)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('dashboard.categories.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::query()->create([
            ...$this->attributesFrom($request->validated(), $request->boolean(...)),
            'site_id' => $this->siteFor($request->user())->id,
        ]);

        return to_route('dashboard.categories.index')->with('status', 'Categoria creada correctamente.');
    }

    public function edit(Category $category): View
    {
        $this->ensureCategoryBelongsToCurrentSite($category, auth()->user());

        return view('dashboard.categories.edit', [
            'category' => $category,
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $this->ensureCategoryBelongsToCurrentSite($category, $request->user());
        $category->update($this->attributesFrom($request->validated(), $request->boolean(...)));

        return to_route('dashboard.categories.index')->with('status', 'Categoria actualizada correctamente.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $this->ensureCategoryBelongsToCurrentSite($category, auth()->user());
        $category->delete();

        return to_route('dashboard.categories.index')->with('status', 'Categoria eliminada correctamente.');
    }

    /**
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function attributesFrom(array $validated, callable $boolean): array
    {
        return [
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'] ?? null,
            'sort_order' => $validated['sort_order'],
            'is_active' => $boolean('is_active'),
        ];
    }

    private function siteFor(User $user): Site
    {
        if ($user->site_id) {
            return Site::query()->findOrFail($user->site_id);
        }

        return Site::query()->firstOrFail();
    }

    private function ensureCategoryBelongsToCurrentSite(Category $category, User $user): void
    {
        abort_unless($category->site_id === $this->siteFor($user)->id, 404);
    }
}
