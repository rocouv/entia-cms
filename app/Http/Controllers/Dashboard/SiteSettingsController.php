<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UpdateSiteSettingsRequest;
use App\Models\Site;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SiteSettingsController extends Controller
{
    public function edit(): View
    {
        return view('dashboard.settings.edit', [
            'site' => $this->site(),
        ]);
    }

    public function update(UpdateSiteSettingsRequest $request): RedirectResponse
    {
        $site = $this->site();
        $validated = $request->validated();

        $site->client->update([
            'name' => $validated['client_name'],
            'legal_name' => $validated['client_legal_name'],
            'contact_email' => $validated['client_contact_email'],
            'contact_phone' => $validated['client_contact_phone'],
        ]);

        $site->update([
            'name' => $validated['site_name'],
            'domain' => $validated['domain'],
            'is_active' => $request->boolean('is_active'),
        ]);

        $site->settings()->update([
            'site_name' => $validated['site_name'],
            'tagline' => $validated['tagline'],
            'contact_email' => $validated['contact_email'],
            'contact_phone' => $validated['contact_phone'],
            'address' => $validated['address'],
            'meta_title' => $validated['meta_title'],
            'meta_description' => $validated['meta_description'],
            'theme' => $this->themeFrom($site->settings->theme ?? [], $validated['theme'] ?? []),
        ]);

        return to_route('dashboard.settings.edit')->with('status', 'Configuracion del sitio actualizada.');
    }

    private function site(): Site
    {
        return Site::query()
            ->with(['client', 'settings'])
            ->firstOrFail();
    }

    /**
     * @param  array<string, string>  $current
     * @param  array<string, string>  $validated
     * @return array<string, string>
     */
    private function themeFrom(array $current, array $validated): array
    {
        return array_intersect_key(
            array_replace(SiteSetting::THEME_DEFAULTS, $current, $validated),
            SiteSetting::THEME_DEFAULTS,
        );
    }
}
