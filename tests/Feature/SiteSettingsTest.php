<?php

use App\Models\Client;
use App\Models\Role;
use App\Models\Site;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
});

function createSettingsUser(string $roleSlug): User
{
    $role = Role::factory()->create([
        'name' => str($roleSlug)->headline()->toString(),
        'slug' => $roleSlug,
    ]);

    $client = Client::factory()->create();
    $site = Site::factory()->for($client)->create();
    SiteSetting::factory()->for($site)->create();

    return User::factory()->create([
        'role_id' => $role->id,
        'site_id' => $site->id,
    ]);
}

it('redirects guests away from site settings', function () {
    $this->get('/dashboard/settings')
        ->assertRedirect('/login');
});

it('shows site settings to administrators', function () {
    $admin = createSettingsUser(Role::ADMINISTRADOR);

    $this->actingAs($admin)
        ->get('/dashboard/settings')
        ->assertOk()
        ->assertSee('Configuracion general del sitio')
        ->assertSee($admin->site->name);
});

it('blocks editors from site settings', function () {
    $editor = createSettingsUser(Role::EDITOR);

    $this->actingAs($editor)
        ->get('/dashboard/settings')
        ->assertForbidden();
});

it('allows administrators to update site settings', function () {
    $admin = createSettingsUser(Role::ADMINISTRADOR);

    $this->actingAs($admin)
        ->put('/dashboard/settings', [
            'client_name' => 'Cliente Demo',
            'client_legal_name' => 'Cliente Demo SA de CV',
            'client_contact_email' => 'cliente@example.com',
            'client_contact_phone' => '555-0101',
            'site_name' => 'Sitio Demo',
            'domain' => 'cliente.test',
            'is_active' => '1',
            'tagline' => 'Contenido administrable para negocios locales',
            'contact_email' => 'hola@cliente.test',
            'contact_phone' => '555-0202',
            'address' => 'Calle Principal 123',
            'meta_title' => 'Sitio Demo',
            'meta_description' => 'Descripcion publica del sitio demo.',
        ])
        ->assertRedirect('/dashboard/settings')
        ->assertSessionHas('status', 'Configuracion del sitio actualizada.');

    expect($admin->site->fresh())
        ->name->toBe('Sitio Demo')
        ->domain->toBe('cliente.test')
        ->is_active->toBeTrue();

    expect($admin->site->client->fresh())
        ->name->toBe('Cliente Demo')
        ->legal_name->toBe('Cliente Demo SA de CV')
        ->contact_email->toBe('cliente@example.com');

    expect($admin->site->settings->fresh())
        ->site_name->toBe('Sitio Demo')
        ->tagline->toBe('Contenido administrable para negocios locales')
        ->contact_email->toBe('hola@cliente.test')
        ->meta_title->toBe('Sitio Demo');
});

it('allows administrators to update the visual theme', function () {
    $admin = createSettingsUser(Role::ADMINISTRADOR);

    $this->actingAs($admin)
        ->put('/dashboard/settings', [
            'client_name' => 'Diseno Vector',
            'client_legal_name' => null,
            'client_contact_email' => null,
            'client_contact_phone' => null,
            'site_name' => 'Diseno Vector',
            'domain' => 'disenovector.test',
            'is_active' => '1',
            'tagline' => 'Diseno grafico, impresion y soluciones visuales',
            'contact_email' => null,
            'contact_phone' => null,
            'address' => null,
            'meta_title' => 'Diseno Vector',
            'meta_description' => null,
            'theme' => [
                'font_family' => 'Montserrat',
                'background' => '#FFFFFF',
                'surface' => '#FFFFFF',
                'surface_container_lowest' => '#FFFFFF',
                'surface_container_low' => '#FFFFFF',
                'surface_container' => '#FFFFFF',
                'surface_container_high' => '#232323',
                'surface_container_highest' => '#232323',
                'on_surface' => '#232323',
                'on_surface_variant' => '#5E0608',
                'outline' => '#232323',
                'outline_variant' => '#E31B23',
                'primary' => '#E31B23',
                'on_primary' => '#FFFFFF',
                'primary_container' => '#B81414',
                'on_primary_container' => '#FFFFFF',
                'secondary' => '#232323',
                'on_secondary' => '#FFFFFF',
                'secondary_container' => '#5E0608',
                'on_secondary_container' => '#FFFFFF',
                'tertiary' => '#000000',
                'on_tertiary' => '#FFFFFF',
                'tertiary_container' => '#5E0608',
                'on_tertiary_container' => '#FFFFFF',
                'error' => '#E31B23',
                'on_error' => '#FFFFFF',
                'error_container' => '#B81414',
                'on_error_container' => '#FFFFFF',
            ],
        ])
        ->assertRedirect('/dashboard/settings');

    $theme = $admin->site->settings->fresh()->theme;

    expect($theme['font_family'])->toBe('Montserrat')
        ->and($theme['primary'])->toBe('#E31B23')
        ->and($theme['primary_container'])->toBe('#B81414')
        ->and($theme['secondary'])->toBe('#232323')
        ->and($theme['on_surface'])->toBe('#232323');
});
