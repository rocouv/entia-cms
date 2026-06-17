<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreServiceRequest;
use App\Http\Requests\Dashboard\UpdateServiceRequest;
use App\Models\Category;
use App\Models\Media;
use App\Models\Service;
use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $site = $this->siteFor(auth()->user());

        return view('dashboard.services.index', [
            'services' => Service::query()
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

        return view('dashboard.services.create', [
            'categories' => $this->categoriesFor($site),
            'imageMedia' => $this->imageMediaFor($site),
        ]);
    }

    public function store(StoreServiceRequest $request): RedirectResponse
    {
        Service::query()->create([
            ...$this->attributesFrom($request->validated(), $request->boolean(...)),
            'site_id' => $this->siteFor($request->user())->id,
        ]);

        return to_route('dashboard.services.index')->with('status', 'Servicio creado correctamente.');
    }

    public function edit(Service $service): View
    {
        $site = $this->siteFor(auth()->user());
        $this->ensureServiceBelongsToCurrentSite($service, auth()->user());

        return view('dashboard.services.edit', [
            'service' => $service,
            'categories' => $this->categoriesFor($site),
            'imageMedia' => $this->imageMediaFor($site),
        ]);
    }

    public function update(UpdateServiceRequest $request, Service $service): RedirectResponse
    {
        $this->ensureServiceBelongsToCurrentSite($service, $request->user());
        $service->update($this->attributesFrom($request->validated(), $request->boolean(...)));

        return to_route('dashboard.services.index')->with('status', 'Servicio actualizado correctamente.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $this->ensureServiceBelongsToCurrentSite($service, auth()->user());
        $service->delete();

        return to_route('dashboard.services.index')->with('status', 'Servicio eliminado correctamente.');
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

    private function ensureServiceBelongsToCurrentSite(Service $service, User $user): void
    {
        abort_unless($service->site_id === $this->siteFor($user)->id, 404);
    }
}
