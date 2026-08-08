<?php

namespace App\Models;

use Database\Factories\SiteSettingFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

#[Fillable(['site_id', 'site_name', 'logo_path', 'tagline', 'services_page_title', 'projects_page_title', 'services_description', 'projects_description', 'contact_email', 'contact_phone', 'address', 'meta_title', 'meta_description', 'social_links', 'theme', 'dashboard_theme'])]
class SiteSetting extends Model
{
    /** @use HasFactory<SiteSettingFactory> */
    use HasFactory;

    public const FONT_FAMILIES = [
        'Inter' => 'Inter:wght@400;500;600;700;800;900',
        'Roboto' => 'Roboto:wght@400;500;700',
        'Open Sans' => 'Open+Sans:wght@400;500;600;700',
        'Montserrat' => 'Montserrat:wght@400;500;600;700;800;900',
        'Lato' => 'Lato:wght@400;700',
    ];

    public const FONT_CSS_FAMILIES = [
        'Inter' => "'Inter'",
        'Roboto' => "'Roboto'",
        'Open Sans' => "'Open Sans'",
        'Montserrat' => "'Montserrat'",
        'Lato' => "'Lato'",
    ];

    public const THEME_DEFAULTS = [
        'font_family' => 'Inter',
        'background' => '#f9f9fa',
        'surface' => '#f9f9fa',
        'surface_container_lowest' => '#ffffff',
        'surface_container_low' => '#f3f3f4',
        'surface_container' => '#eeeeef',
        'surface_container_high' => '#e8e8e9',
        'surface_container_highest' => '#e2e2e3',
        'on_surface' => '#1a1c1d',
        'on_surface_variant' => '#47464b',
        'outline' => '#77767b',
        'outline_variant' => '#c8c5cb',
        'primary' => '#000000',
        'on_primary' => '#ffffff',
        'primary_container' => '#1b1b1e',
        'on_primary_container' => '#858387',
        'secondary' => '#5d5e66',
        'on_secondary' => '#ffffff',
        'secondary_container' => '#e3e1ec',
        'on_secondary_container' => '#63646c',
        'tertiary' => '#000000',
        'on_tertiary' => '#ffffff',
        'tertiary_container' => '#1a1c1e',
        'on_tertiary_container' => '#838487',
        'error' => '#ba1a1a',
        'on_error' => '#ffffff',
        'error_container' => '#ffdad6',
        'on_error_container' => '#93000a',
    ];

    public const DASHBOARD_THEME_DEFAULTS = [
        'background' => '#f4f7fb',
        'surface' => '#ffffff',
        'surface_container_lowest' => '#ffffff',
        'surface_container_low' => '#f8fafc',
        'surface_container' => '#f1f5f9',
        'surface_container_high' => '#e7edf5',
        'surface_container_highest' => '#dce5f0',
        'on_surface' => '#172033',
        'on_surface_variant' => '#526176',
        'outline' => '#94a3b8',
        'outline_variant' => '#d5deea',
        'primary' => '#3157d5',
        'on_primary' => '#ffffff',
        'primary_container' => '#e5ebff',
        'on_primary_container' => '#1d3b9a',
        'secondary' => '#526176',
        'on_secondary' => '#ffffff',
        'secondary_container' => '#e6edf7',
        'on_secondary_container' => '#334155',
        'tertiary' => '#3157d5',
        'on_tertiary' => '#ffffff',
        'tertiary_container' => '#e5ebff',
        'on_tertiary_container' => '#1d3b9a',
        'error' => '#ba1a1a',
        'on_error' => '#ffffff',
        'error_container' => '#ffdad6',
        'on_error_container' => '#93000a',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'social_links' => 'array',
            'theme' => 'array',
            'dashboard_theme' => 'array',
        ];
    }

    public function logoUrl(): ?string
    {
        if (! $this->logo_path) {
            return null;
        }

        if (Str::startsWith($this->logo_path, ['http://', 'https://', '/'])) {
            return $this->logo_path;
        }

        return asset('storage/'.ltrim($this->logo_path, '/'));
    }

    /**
     * @return BelongsTo<Site, $this>
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
