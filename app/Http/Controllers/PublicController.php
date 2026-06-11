<?php

namespace App\Http\Controllers;

use App\Models\Page;
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
}
