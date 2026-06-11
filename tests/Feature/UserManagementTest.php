<?php

use App\Models\Role;
use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
});

function createUserManagementContext(): array
{
    $adminRole = Role::factory()->create([
        'name' => 'Administrador',
        'slug' => Role::ADMINISTRADOR,
    ]);

    $editorRole = Role::factory()->create([
        'name' => 'Editor',
        'slug' => Role::EDITOR,
    ]);

    $site = Site::factory()->create();

    $admin = User::factory()->create([
        'role_id' => $adminRole->id,
        'site_id' => $site->id,
    ]);

    return compact('adminRole', 'editorRole', 'site', 'admin');
}

it('redirects guests away from user management', function () {
    $this->get('/dashboard/users')
        ->assertRedirect('/login');
});

it('blocks editors from user management', function () {
    $context = createUserManagementContext();
    $editor = User::factory()->create([
        'role_id' => $context['editorRole']->id,
        'site_id' => $context['site']->id,
    ]);

    $this->actingAs($editor)
        ->get('/dashboard/users')
        ->assertForbidden();
});

it('shows user management to administrators', function () {
    $context = createUserManagementContext();
    $editor = User::factory()->create([
        'name' => 'Editora Demo',
        'role_id' => $context['editorRole']->id,
        'site_id' => $context['site']->id,
    ]);

    $this->actingAs($context['admin'])
        ->get('/dashboard/users')
        ->assertOk()
        ->assertSee('Usuarios del dashboard')
        ->assertSee($editor->name);
});

it('allows administrators to create editors', function () {
    $context = createUserManagementContext();

    $this->actingAs($context['admin'])
        ->post('/dashboard/users', [
            'name' => 'Editor Nuevo',
            'email' => 'editor@entia.local',
            'password' => 'password-seguro',
            'password_confirmation' => 'password-seguro',
        ])
        ->assertRedirect('/dashboard/users')
        ->assertSessionHas('status', 'Editor creado correctamente.');

    $editor = User::query()->where('email', 'editor@entia.local')->firstOrFail();

    expect($editor->role_id)->toBe($context['editorRole']->id)
        ->and($editor->site_id)->toBe($context['site']->id)
        ->and(Hash::check('password-seguro', $editor->password))->toBeTrue();
});

it('allows administrators to update editors', function () {
    $context = createUserManagementContext();
    $editor = User::factory()->create([
        'role_id' => $context['editorRole']->id,
        'site_id' => $context['site']->id,
    ]);

    $this->actingAs($context['admin'])
        ->put("/dashboard/users/{$editor->id}", [
            'name' => 'Editor Actualizado',
            'email' => 'editor.actualizado@entia.local',
            'password' => 'nueva-password',
            'password_confirmation' => 'nueva-password',
        ])
        ->assertRedirect('/dashboard/users')
        ->assertSessionHas('status', 'Usuario actualizado correctamente.');

    $editor->refresh();

    expect($editor->name)->toBe('Editor Actualizado')
        ->and($editor->email)->toBe('editor.actualizado@entia.local')
        ->and(Hash::check('nueva-password', $editor->password))->toBeTrue();
});

it('allows administrators to delete editors', function () {
    $context = createUserManagementContext();
    $editor = User::factory()->create([
        'role_id' => $context['editorRole']->id,
        'site_id' => $context['site']->id,
    ]);

    $this->actingAs($context['admin'])
        ->delete("/dashboard/users/{$editor->id}")
        ->assertRedirect('/dashboard/users')
        ->assertSessionHas('status', 'Editor eliminado correctamente.');

    $this->assertDatabaseMissing('users', [
        'id' => $editor->id,
    ]);
});

it('allows administrators to update administrator user information', function () {
    $context = createUserManagementContext();

    $this->actingAs($context['admin'])
        ->put("/dashboard/users/{$context['admin']->id}", [
            'name' => 'Administrador Actualizado',
            'email' => 'admin.actualizado@entia.local',
            'password' => '',
            'password_confirmation' => '',
        ])
        ->assertRedirect('/dashboard/users')
        ->assertSessionHas('status', 'Usuario actualizado correctamente.');

    $context['admin']->refresh();

    expect($context['admin']->name)->toBe('Administrador Actualizado')
        ->and($context['admin']->email)->toBe('admin.actualizado@entia.local')
        ->and($context['admin']->role_id)->toBe($context['adminRole']->id);
});

it('prevents administrators from deleting administrator users', function () {
    $context = createUserManagementContext();

    $this->actingAs($context['admin'])
        ->delete("/dashboard/users/{$context['admin']->id}")
        ->assertForbidden();
});
