<?php

use App\Models\Category;
use App\Models\Page;
use App\Models\Role;
use App\Models\Section;
use App\Models\Service;
use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
});

function createServiceUser(string $roleSlug = Role::EDITOR): User
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

it('redirects guests away from service management', function () {
    $this->get('/dashboard/services')
        ->assertRedirect('/login');
});

it('allows authenticated users to create services', function () {
    $editor = createServiceUser();
    $category = Category::factory()->for($editor->site)->create();

    $this->actingAs($editor)
        ->post('/dashboard/services', [
            'category_id' => $category->id,
            'title' => 'Branding e identidad',
            'slug' => '',
            'excerpt' => 'Sistema visual y verbal para marcas.',
            'body' => 'Definicion de estrategia, identidad y mensajes centrales.',
            'image_path' => 'media/branding.jpg',
            'is_published' => '1',
            'is_featured' => '1',
            'sort_order' => '2',
            'meta_title' => 'Branding e identidad',
            'meta_description' => 'Servicio de branding para marcas en crecimiento.',
        ])
        ->assertRedirect('/dashboard/services')
        ->assertSessionHas('status', 'Servicio creado correctamente.');

    $service = Service::query()->firstOrFail();

    expect($service->site_id)->toBe($editor->site_id)
        ->and($service->category_id)->toBe($category->id)
        ->and($service->slug)->toBe('branding-e-identidad')
        ->and($service->is_published)->toBeTrue()
        ->and($service->is_featured)->toBeTrue()
        ->and($service->sort_order)->toBe(2);
});

it('validates service category belongs to the current site', function () {
    $editor = createServiceUser();
    $otherCategory = Category::factory()->create();

    $this->actingAs($editor)
        ->post('/dashboard/services', [
            'category_id' => $otherCategory->id,
            'title' => 'Servicio externo',
            'slug' => '',
            'sort_order' => '0',
        ])
        ->assertSessionHasErrors('category_id');
});

it('prevents managing services from another site', function () {
    $editor = createServiceUser();
    $otherService = Service::factory()->create();

    $this->actingAs($editor)
        ->get("/dashboard/services/{$otherService->id}/edit")
        ->assertNotFound();
});

it('renders only published services publicly', function () {
    $published = Service::factory()->create([
        'title' => 'Campanas digitales',
        'slug' => 'campanas-digitales',
        'is_published' => true,
    ]);
    $draft = Service::factory()->create([
        'title' => 'Servicio borrador',
        'slug' => 'servicio-borrador',
        'is_published' => false,
    ]);

    $this->get('/servicios')
        ->assertOk()
        ->assertSee($published->title)
        ->assertDontSee($draft->title);

    $this->get('/servicios/campanas-digitales')
        ->assertOk()
        ->assertSee($published->title);

    $this->get('/servicios/servicio-borrador')
        ->assertNotFound();
});

it('renders services section with published services', function () {
    $page = Page::factory()->create([
        'is_home' => true,
        'is_published' => true,
    ]);
    $service = Service::factory()->for($page->site)->create([
        'title' => 'Consultoria creativa',
        'is_published' => true,
    ]);
    Section::factory()->for($page)->create([
        'type' => 'services',
        'content' => ['title' => 'Servicios destacados', 'limit' => 3],
        'is_visible' => true,
    ]);

    $this->get('/')
        ->assertOk()
        ->assertSee('Servicios destacados')
        ->assertSee($service->title);
});

it('allows authenticated users to delete services', function () {
    $editor = createServiceUser();
    $service = Service::factory()->for($editor->site)->create();

    $this->actingAs($editor)
        ->delete("/dashboard/services/{$service->id}")
        ->assertRedirect('/dashboard/services')
        ->assertSessionHas('status', 'Servicio eliminado correctamente.');

    $this->assertDatabaseMissing('services', [
        'id' => $service->id,
    ]);
});
