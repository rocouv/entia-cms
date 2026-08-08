<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Project;
use App\Models\Service;
use App\Models\Site;
use Illuminate\View\View;

class PublicController extends Controller
{
    public function home(): View
    {
        $page = Page::where('is_home', true)
            ->where('is_published', true)
            ->with(['sections' => fn ($q) => $q->where('is_visible', true)->orderBy('sort_order')])
            ->firstOrFail();

        return view('public.page', compact('page'));
    }

    public function show(string $slug): View
    {
        $page = Page::where('slug', $slug)
            ->where('is_published', true)
            ->with(['sections' => fn ($q) => $q->where('is_visible', true)->orderBy('sort_order')])
            ->firstOrFail();

        return view('public.page', compact('page'));
    }

    public function services(): View
    {
        $site = Site::query()->with('settings')->firstOrFail();
        $services = Service::query()
            ->with('category')
            ->where('is_published', true)
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return view('public.services.index', compact('site', 'services'));
    }

    public function service(string $slug): View
    {
        $service = Service::query()
            ->with('category')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('public.services.show', compact('service'));
    }

    public function projects(): View
    {
        $site = Site::query()->with('settings')->firstOrFail();
        $projects = Project::query()
            ->with('category')
            ->where('is_published', true)
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return view('public.projects.index', compact('site', 'projects'));
    }

    public function project(string $slug): View
    {
        $project = Project::query()
            ->with('category')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('public.projects.show', compact('project'));
    }
}
