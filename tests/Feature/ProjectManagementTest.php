<?php

use App\Models\Category;
use App\Models\Page;
use App\Models\Project;
use App\Models\Role;
use App\Models\Section;
use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
});

function createProjectUser(string $roleSlug = Role::EDITOR): User
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

it('redirects guests away from project management', function () {
    $this->get('/dashboard/projects')
        ->assertRedirect('/login');
});

it('allows authenticated users to create projects', function () {
    $editor = createProjectUser();
    $category = Category::factory()->for($editor->site)->create();

    $this->actingAs($editor)
        ->post('/dashboard/projects', [
            'category_id' => $category->id,
            'title' => 'Lanzamiento Bruma Cafe',
            'slug' => '',
            'client_name' => 'Bruma Cafe',
            'excerpt' => 'Campana de apertura para cafeterias.',
            'body' => 'Reposicionamiento, pauta y landing de conversion.',
            'image_path' => 'media/bruma.jpg',
            'is_published' => '1',
            'is_featured' => '1',
            'sort_order' => '4',
            'meta_title' => 'Lanzamiento Bruma Cafe',
            'meta_description' => 'Caso de lanzamiento para cafeterias.',
        ])
        ->assertRedirect('/dashboard/projects')
        ->assertSessionHas('status', 'Proyecto creado correctamente.');

    $project = Project::query()->firstOrFail();

    expect($project->site_id)->toBe($editor->site_id)
        ->and($project->category_id)->toBe($category->id)
        ->and($project->slug)->toBe('lanzamiento-bruma-cafe')
        ->and($project->client_name)->toBe('Bruma Cafe')
        ->and($project->is_published)->toBeTrue()
        ->and($project->is_featured)->toBeTrue()
        ->and($project->sort_order)->toBe(4);
});

it('validates project category belongs to the current site', function () {
    $editor = createProjectUser();
    $otherCategory = Category::factory()->create();

    $this->actingAs($editor)
        ->post('/dashboard/projects', [
            'category_id' => $otherCategory->id,
            'title' => 'Proyecto externo',
            'slug' => '',
            'sort_order' => '0',
        ])
        ->assertSessionHasErrors('category_id');
});

it('prevents managing projects from another site', function () {
    $editor = createProjectUser();
    $otherProject = Project::factory()->create();

    $this->actingAs($editor)
        ->get("/dashboard/projects/{$otherProject->id}/edit")
        ->assertNotFound();
});

it('renders only published projects publicly', function () {
    $published = Project::factory()->create([
        'title' => 'Bruma Cafe',
        'slug' => 'bruma-cafe',
        'is_published' => true,
    ]);
    $draft = Project::factory()->create([
        'title' => 'Proyecto borrador',
        'slug' => 'proyecto-borrador',
        'is_published' => false,
    ]);

    $this->get('/proyectos')
        ->assertOk()
        ->assertSee($published->title)
        ->assertDontSee($draft->title);

    $this->get('/proyectos/bruma-cafe')
        ->assertOk()
        ->assertSee($published->title);

    $this->get('/proyectos/proyecto-borrador')
        ->assertNotFound();
});

it('renders projects section with published projects', function () {
    $page = Page::factory()->create([
        'is_home' => true,
        'is_published' => true,
    ]);
    $project = Project::factory()->for($page->site)->create([
        'title' => 'Nexo Fit',
        'is_published' => true,
    ]);
    Section::factory()->for($page)->create([
        'type' => 'projects',
        'content' => ['title' => 'Proyectos destacados', 'limit' => 3],
        'is_visible' => true,
    ]);

    $this->get('/')
        ->assertOk()
        ->assertSee('Proyectos destacados')
        ->assertSee($project->title);
});

it('allows authenticated users to delete projects', function () {
    $editor = createProjectUser();
    $project = Project::factory()->for($editor->site)->create();

    $this->actingAs($editor)
        ->delete("/dashboard/projects/{$project->id}")
        ->assertRedirect('/dashboard/projects')
        ->assertSessionHas('status', 'Proyecto eliminado correctamente.');

    $this->assertDatabaseMissing('projects', [
        'id' => $project->id,
    ]);
});
