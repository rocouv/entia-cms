<?php

namespace App\Http\Requests\Dashboard;

use App\Models\Role;
use App\Models\SiteSetting;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSiteSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole(Role::ADMINISTRADOR) === true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $rules = [
            'client_name' => ['required', 'string', 'max:255'],
            'client_legal_name' => ['nullable', 'string', 'max:255'],
            'client_contact_email' => ['nullable', 'email', 'max:255'],
            'client_contact_phone' => ['nullable', 'string', 'max:50'],
            'site_name' => ['required', 'string', 'max:255'],
            'domain' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:1000'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'theme' => ['nullable', 'array'],
            'theme.font_family' => ['nullable', Rule::in(array_keys(SiteSetting::FONT_FAMILIES))],
        ];

        foreach (array_keys(SiteSetting::THEME_DEFAULTS) as $themeKey) {
            if ($themeKey === 'font_family') {
                continue;
            }

            $rules["theme.{$themeKey}"] = ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'];
        }

        return $rules;
    }
}
