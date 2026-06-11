<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreMediaRequest;
use App\Models\Media;
use App\Models\Site;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function index(): View
    {
        $site = $this->siteFor(auth()->user());

        return view('dashboard.media.index', [
            'media' => Media::query()
                ->with('user')
                ->whereBelongsTo($site)
                ->latest()
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('dashboard.media.create');
    }

    public function store(StoreMediaRequest $request): RedirectResponse
    {
        $file = $request->file('file');
        $path = $file->store('media', 'public');

        Media::query()->create([
            'site_id' => $this->siteFor($request->user())->id,
            'user_id' => $request->user()->id,
            'disk' => 'public',
            'path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType() ?: 'application/octet-stream',
            'size' => $file->getSize() ?: 0,
            'alt_text' => $request->validated('alt_text'),
        ]);

        return to_route('dashboard.media.index')->with('status', 'Archivo subido correctamente.');
    }

    public function destroy(Media $media): RedirectResponse
    {
        Storage::disk($media->disk)->delete($media->path);
        $media->delete();

        return to_route('dashboard.media.index')->with('status', 'Archivo eliminado correctamente.');
    }

    private function siteFor(User $user): Site
    {
        if ($user->site_id) {
            return Site::query()->findOrFail($user->site_id);
        }

        return Site::query()->firstOrFail();
    }
}
