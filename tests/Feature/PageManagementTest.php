<?php

use App\Models\Page;
use App\Models\Role;
use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
});

function createPageUser(string $roleSlug = Role::EDITOR): User
{
    $role = Role::factory()->create([
        'name' => str($roleSlug)->headline()->toString(),
        'slug' => $roleSlug,
    ]);

    $site = Site::factory()->create();

    return User::factory()->create([
        'role_id' => $role->id,
        'site_id' => $site->id,
    ]);
}

it('redirects guests away from page management', function () {
    $this->get('/dashboard/pages')
        ->assertRedirect('/login');
});

it('shows page management to editors', function () {
    $editor = createPageUser();
    $page = Page::factory()->for($editor->site)->create([
        'title' => 'Servicios',
        'slug' => 'servicios',
    ]);

    $this->actingAs($editor)
        ->get('/dashboard/pages')
        ->assertOk()
        ->assertSee('Paginas')
        ->assertSee($page->title)
        ->assertSee('/servicios');
});

it('allows authenticated users to create pages', function () {
    $editor = createPageUser();

    $this->actingAs($editor)
        ->post('/dashboard/pages', [
            'title' => 'Inicio Principal',
            'slug' => '',
            'excerpt' => 'Pagina inicial del sitio.',
            'body' => 'Contenido base de la pagina.',
            'is_home' => '1',
            'is_published' => '1',
            'show_in_navigation' => '1',
            'navigation_label' => 'Inicio',
            'sort_order' => '1',
            'meta_title' => 'Inicio Principal',
            'meta_description' => 'Descripcion SEO de inicio.',
        ])
        ->assertRedirect('/dashboard/pages')
        ->assertSessionHas('status', 'Pagina creada correctamente.');

    $page = Page::query()->firstOrFail();

    expect($page->site_id)->toBe($editor->site_id)
        ->and($page->title)->toBe('Inicio Principal')
        ->and($page->slug)->toBe('inicio-principal')
        ->and($page->is_home)->toBeTrue()
        ->and($page->is_published)->toBeTrue()
        ->and($page->show_in_navigation)->toBeTrue()
        ->and($page->navigation_label)->toBe('Inicio')
        ->and($page->sort_order)->toBe(1);
});

it('allows authenticated users to update pages and move the home flag', function () {
    $editor = createPageUser();
    $oldHome = Page::factory()->for($editor->site)->create([
        'title' => 'Home anterior',
        'slug' => 'home-anterior',
        'is_home' => true,
    ]);
    $page = Page::factory()->for($editor->site)->create([
        'title' => 'Nosotros',
        'slug' => 'nosotros',
        'is_home' => false,
    ]);

    $this->actingAs($editor)
        ->put("/dashboard/pages/{$page->id}", [
            'title' => 'Sobre Nosotros',
            'slug' => 'sobre-nosotros',
            'excerpt' => 'Nuevo extracto.',
            'body' => 'Contenido actualizado.',
            'is_home' => '1',
            'is_published' => '1',
            'show_in_navigation' => '1',
            'navigation_label' => 'Nosotros',
            'sort_order' => '2',
            'meta_title' => 'Sobre Nosotros',
            'meta_description' => 'Descripcion SEO actualizada.',
        ])
        ->assertRedirect('/dashboard/pages')
        ->assertSessionHas('status', 'Pagina actualizada correctamente.');

    $page->refresh();
    $oldHome->refresh();

    expect($page->title)->toBe('Sobre Nosotros')
        ->and($page->slug)->toBe('sobre-nosotros')
        ->and($page->is_home)->toBeTrue()
        ->and($oldHome->is_home)->toBeFalse();
});

it('validates unique slugs within the current site', function () {
    $editor = createPageUser();
    Page::factory()->for($editor->site)->create([
        'slug' => 'contacto',
    ]);

    $this->actingAs($editor)
        ->post('/dashboard/pages', [
            'title' => 'Contacto nuevo',
            'slug' => 'contacto',
            'sort_order' => '0',
        ])
        ->assertSessionHasErrors('slug');
});

it('allows the same slug on different sites', function () {
    $editor = createPageUser();
    Page::factory()->create([
        'slug' => 'contacto',
    ]);

    $this->actingAs($editor)
        ->post('/dashboard/pages', [
            'title' => 'Contacto',
            'slug' => 'contacto',
            'sort_order' => '0',
        ])
        ->assertRedirect('/dashboard/pages');

    expect(Page::query()->where('slug', 'contacto')->count())->toBe(2);
});

it('allows authenticated users to delete pages', function () {
    $editor = createPageUser();
    $page = Page::factory()->for($editor->site)->create();

    $this->actingAs($editor)
        ->delete("/dashboard/pages/{$page->id}")
        ->assertRedirect('/dashboard/pages')
        ->assertSessionHas('status', 'Pagina eliminada correctamente.');

    $this->assertDatabaseMissing('pages', [
        'id' => $page->id,
    ]);
});
