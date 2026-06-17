<?php

use App\Models\Category;
use App\Models\Role;
use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
});

function createCategoryUser(string $roleSlug = Role::EDITOR): User
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

it('redirects guests away from category management', function () {
    $this->get('/dashboard/categories')
        ->assertRedirect('/login');
});

it('shows category management to editors', function () {
    $editor = createCategoryUser();
    $category = Category::factory()->for($editor->site)->create([
        'name' => 'Branding',
        'slug' => 'branding',
    ]);

    $this->actingAs($editor)
        ->get('/dashboard/categories')
        ->assertOk()
        ->assertSee('Categorias')
        ->assertSee($category->name)
        ->assertSee($category->slug);
});

it('allows authenticated users to create categories', function () {
    $editor = createCategoryUser();

    $this->actingAs($editor)
        ->post('/dashboard/categories', [
            'name' => 'Marketing Digital',
            'slug' => '',
            'description' => 'Servicios y proyectos digitales.',
            'sort_order' => '3',
            'is_active' => '1',
        ])
        ->assertRedirect('/dashboard/categories')
        ->assertSessionHas('status', 'Categoria creada correctamente.');

    $category = Category::query()->firstOrFail();

    expect($category->site_id)->toBe($editor->site_id)
        ->and($category->name)->toBe('Marketing Digital')
        ->and($category->slug)->toBe('marketing-digital')
        ->and($category->sort_order)->toBe(3)
        ->and($category->is_active)->toBeTrue();
});

it('validates unique category slugs within the current site', function () {
    $editor = createCategoryUser();
    Category::factory()->for($editor->site)->create([
        'slug' => 'branding',
    ]);

    $this->actingAs($editor)
        ->post('/dashboard/categories', [
            'name' => 'Branding nuevo',
            'slug' => 'branding',
            'sort_order' => '0',
        ])
        ->assertSessionHasErrors('slug');
});

it('allows the same category slug on different sites', function () {
    $editor = createCategoryUser();
    Category::factory()->create([
        'slug' => 'branding',
    ]);

    $this->actingAs($editor)
        ->post('/dashboard/categories', [
            'name' => 'Branding',
            'slug' => 'branding',
            'sort_order' => '0',
        ])
        ->assertRedirect('/dashboard/categories');

    expect(Category::query()->where('slug', 'branding')->count())->toBe(2);
});

it('prevents managing categories from another site', function () {
    $editor = createCategoryUser();
    $otherCategory = Category::factory()->create();

    $this->actingAs($editor)
        ->get("/dashboard/categories/{$otherCategory->id}/edit")
        ->assertNotFound();
});

it('allows authenticated users to delete categories', function () {
    $editor = createCategoryUser();
    $category = Category::factory()->for($editor->site)->create();

    $this->actingAs($editor)
        ->delete("/dashboard/categories/{$category->id}")
        ->assertRedirect('/dashboard/categories')
        ->assertSessionHas('status', 'Categoria eliminada correctamente.');

    $this->assertDatabaseMissing('categories', [
        'id' => $category->id,
    ]);
});
