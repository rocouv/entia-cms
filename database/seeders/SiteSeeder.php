<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Site;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $client = Client::query()->updateOrCreate(
            ['name' => env('ENTIA_CLIENT_NAME', 'Cliente Entia')],
            [
                'legal_name' => env('ENTIA_CLIENT_LEGAL_NAME'),
                'contact_email' => env('ENTIA_CLIENT_EMAIL'),
                'contact_phone' => env('ENTIA_CLIENT_PHONE'),
            ],
        );

        $site = Site::query()->updateOrCreate(
            ['client_id' => $client->id],
            [
                'name' => env('ENTIA_SITE_NAME', 'Entia'),
                'domain' => env('ENTIA_SITE_DOMAIN'),
                'is_active' => true,
            ],
        );

        $site->settings()->updateOrCreate(
            ['site_id' => $site->id],
            [
                'site_name' => env('ENTIA_SITE_NAME', 'Entia'),
                'tagline' => env('ENTIA_SITE_TAGLINE', 'Sitio administrable con Entia CMS'),
                'contact_email' => env('ENTIA_SITE_CONTACT_EMAIL'),
                'contact_phone' => env('ENTIA_SITE_CONTACT_PHONE'),
                'address' => env('ENTIA_SITE_ADDRESS'),
                'meta_title' => env('ENTIA_SITE_META_TITLE', env('ENTIA_SITE_NAME', 'Entia')),
                'meta_description' => env('ENTIA_SITE_META_DESCRIPTION'),
                'social_links' => [],
                'theme' => SiteSetting::THEME_DEFAULTS,
            ],
        );
    }
}
