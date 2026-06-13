<?php

namespace App\Providers;

use App\Models\Page;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('components.layouts.public', function ($view) {
            $view->with('siteSettings', SiteSetting::first());
            $view->with('navigationPages', Page::where('is_published', true)
                ->where('show_in_navigation', true)
                ->orderBy('sort_order')
                ->get()
            );
        });

        View::composer('components.dashboard-layout', function ($view): void {
            $view->with('siteSettings', SiteSetting::first());
        });
    }
}
