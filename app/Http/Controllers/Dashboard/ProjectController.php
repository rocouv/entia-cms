<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreProjectRequest;
use App\Http\Requests\Dashboard\UpdateProjectRequest;
use App\Models\Category;
use App\Models\Media;
use App\Models\Project;
use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $site = $this->siteFor(auth()->user());

        return view('dashboard.projects.index', [
            'projects' => Project::query()
                ->with('category')
                ->whereBelongsTo($site)
                ->orderBy('sort_order')
                ->orderBy('title')
                ->get(),
        ]);
    }

    public function create(): View
    {
        $site = $this->siteFor(auth()->user());

        return view('dashboard.projects.create', [
            'categories' => $this->categoriesFor($site),
            'imageMedia' => $this->imageMediaFor($site),
        ]);
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        Project::query()->create([
            ...$this->attributesFrom($request->validated(), $request->boolean(...)),
            'site_id' => $this->siteFor($request->user())->id,
        ]);

        return to_route('dashboard.projects.index')->with('status', 'Proyecto creado correctamente.');
    }

    public function edit(Project $project): View
    {
        $site = $this->siteFor(auth()->user());
        $this->ensureProjectBelongsToCurrentSite($project, auth()->user());

        return view('dashboard.projects.edit', [
            'project' => $project,
            'categories' => $this->categoriesFor($site),
            'imageMedia' => $this->imageMediaFor($site),
        ]);
    }

    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $this->ensureProjectBelongsToCurrentSite($project, $request->user());
        $project->update($this->attributesFrom($request->validated(), $request->boolean(...)));

        return to_route('dashboard.projects.index')->with('status', 'Proyecto actualizado correctamente.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->ensureProjectBelongsToCurrentSite($project, auth()->user());
        $project->delete();

        return to_route('dashboard.projects.index')->with('status', 'Proyecto eliminado correctamente.');
    }

    /**
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function attributesFrom(array $validated, callable $boolean): array
    {
        return [
            'category_id' => $validated['category_id'] ?? null,
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'client_name' => $validated['client_name'] ?? null,
            'excerpt' => $validated['excerpt'] ?? null,
            'body' => $validated['body'] ?? null,
            'image_path' => $validated['image_path'] ?? null,
            'is_published' => $boolean('is_published'),
            'is_featured' => $boolean('is_featured'),
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

    /**
     * @return Collection<int, Category>
     */
    private function categoriesFor(Site $site): Collection
    {
        return Category::query()
            ->whereBelongsTo($site)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }

    /**
     * @return Collection<int, Media>
     */
    private function imageMediaFor(Site $site): Collection
    {
        return Media::query()
            ->whereBelongsTo($site)
            ->where('mime_type', 'like', 'image/%')
            ->latest()
            ->get();
    }

    private function ensureProjectBelongsToCurrentSite(Project $project, User $user): void
    {
        abort_unless($project->site_id === $this->siteFor($user)->id, 404);
    }
}
