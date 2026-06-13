<?php

namespace App\Models;

use Database\Factories\SiteSettingFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['site_id', 'site_name', 'tagline', 'contact_email', 'contact_phone', 'address', 'meta_title', 'meta_description', 'social_links', 'theme'])]
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
        ];
    }

    /**
     * @return BelongsTo<Site, $this>
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
