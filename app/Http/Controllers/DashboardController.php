<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Page;
use App\Models\Section;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboard.index', [
            'stats' => [
                'pages' => Page::count(),
                'publishedPages' => Page::where('is_published', true)->count(),
                'sections' => Section::count(),
                'visibleSections' => Section::where('is_visible', true)->count(),
                'media' => Media::count(),
            ],
            'recentPages' => Page::withCount('sections')
                ->latest()
                ->take(4)
                ->get(),
            'recentMedia' => Media::latest()
                ->take(4)
                ->get(),
        ]);
    }
}
