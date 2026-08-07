<?php

use App\Models\Page;
use App\Models\Role;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
});

function createAdminUser(): User
{
    $role = Role::factory()->create([
        'name' => 'Administrador',
        'slug' => Role::ADMINISTRADOR,
    ]);

    return User::factory()->create([
        'role_id' => $role->id,
        'email' => 'admin@entia.local',
        'password' => 'password',
    ]);
}

it('redirects guests away from the dashboard', function () {
    $this->get('/dashboard')
        ->assertRedirect('/login');
});

it('does not show the dashboard link to public visitors', function () {
    $site = SiteSetting::factory()->create()->site;
    Page::factory()->for($site)->create([
        'is_home' => true,
        'slug' => 'inicio',
    ]);

    $this->get('/')
        ->assertOk()
        ->assertDontSee('>Dashboard</a>', false)
        ->assertDontSee('/login');
});

it('allows an administrator to sign in', function () {
    $admin = createAdminUser();

    $this->post('/login', [
        'email' => 'admin@entia.local',
        'password' => 'password',
    ])->assertRedirect('/dashboard');

    $this->assertAuthenticatedAs($admin);
});

it('shows the protected dashboard to authenticated users', function () {
    $admin = createAdminUser();

    $this->actingAs($admin)
        ->get('/dashboard')
        ->assertOk()
        ->assertSee('dashboard-shell', false)
        ->assertSee('Bienvenido')
        ->assertSee('Administrador');
});

it('allows authenticated users to sign out', function () {
    $admin = createAdminUser();

    $this->actingAs($admin)
        ->post('/logout')
        ->assertRedirect('/login');

    $this->assertGuest();
});
