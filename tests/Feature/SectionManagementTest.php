<?php

use App\Models\Media;
use App\Models\Page;
use App\Models\Role;
use App\Models\Section;
use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
});

function createSectionUser(string $roleSlug = Role::EDITOR): User
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

it('redirects guests away from section management', function () {
    $page = Page::factory()->create();

    $this->get("/dashboard/pages/{$page->id}/sections")
        ->assertRedirect('/login');
});

it('shows section management to editors', function () {
    $editor = createSectionUser();
    $page = Page::factory()->for($editor->site)->create([
        'title' => 'Inicio',
    ]);
    $section = Section::factory()->for($page)->create([
        'type' => 'hero',
        'content' => ['title' => 'Hero principal'],
        'sort_order' => 1,
    ]);

    $this->actingAs($editor)
        ->get("/dashboard/pages/{$page->id}/sections")
        ->assertOk()
        ->assertSee('Secciones')
        ->assertSee($section->typeLabel())
        ->assertSee('Hero principal');
});

it('allows authenticated users to create sections', function () {
    $editor = createSectionUser();
    $page = Page::factory()->for($editor->site)->create();

    $this->actingAs($editor)
        ->post("/dashboard/pages/{$page->id}/sections", [
            'type' => 'hero',
            'content_title' => 'Bienvenido a Entia',
            'subtitle' => 'Sitios administrables para negocios locales',
            'content_body' => 'Texto de apoyo del hero.',
            'button_text' => 'Contactar',
            'button_url' => '/contacto',
            'items_text' => "Rapido\nEditable\nSimple",
            'variant' => 'featured',
            'spacing' => 'large',
            'sort_order' => '1',
            'is_visible' => '1',
        ])
        ->assertRedirect("/dashboard/pages/{$page->id}/sections")
        ->assertSessionHas('status', 'Seccion creada correctamente.');

    $section = Section::query()->firstOrFail();

    expect($section->page_id)->toBe($page->id)
        ->and($section->type)->toBe('hero')
        ->and($section->content['title'])->toBe('Bienvenido a Entia')
        ->and($section->content['subtitle'])->toBe('Sitios administrables para negocios locales')
        ->and($section->content['items'])->toBe(['Rapido', 'Editable', 'Simple'])
        ->and($section->settings['variant'])->toBe('featured')
        ->and($section->settings['spacing'])->toBe('large')
        ->and($section->sort_order)->toBe(1)
        ->and($section->is_visible)->toBeTrue();
});

it('allows authenticated users to create sections with typed content fields', function () {
    $editor = createSectionUser();
    $page = Page::factory()->for($editor->site)->create();

    $this->actingAs($editor)
        ->post("/dashboard/pages/{$page->id}/sections", [
            'type' => 'cards',
            'content' => [
                'title' => 'Beneficios',
                'items' => [
                    ['icon' => 'bolt', 'title' => 'Rapido', 'description' => 'Carga agil.'],
                    ['icon' => 'edit', 'title' => 'Editable', 'description' => 'Contenido flexible.'],
                    ['icon' => '', 'title' => '', 'description' => ''],
                ],
            ],
            'sort_order' => '2',
            'is_visible' => '1',
        ])
        ->assertRedirect("/dashboard/pages/{$page->id}/sections");

    $section = Section::query()->firstOrFail();

    expect($section->type)->toBe('cards')
        ->and($section->content['title'])->toBe('Beneficios')
        ->and($section->content['items'])->toBe([
            ['icon' => 'bolt', 'title' => 'Rapido', 'description' => 'Carga agil.'],
            ['icon' => 'edit', 'title' => 'Editable', 'description' => 'Contenido flexible.'],
        ]);
});

it('shows site images in gallery section fields', function () {
    $editor = createSectionUser();
    $page = Page::factory()->for($editor->site)->create();
    $siteImage = Media::factory()->for($editor->site)->create([
        'original_name' => 'local.jpg',
        'mime_type' => 'image/jpeg',
        'alt_text' => null,
    ]);
    $otherImage = Media::factory()->create([
        'original_name' => 'externa.jpg',
        'mime_type' => 'image/jpeg',
        'alt_text' => null,
    ]);

    $this->actingAs($editor)
        ->get("/dashboard/pages/{$page->id}/sections/create")
        ->assertOk()
        ->assertSee($siteImage->original_name)
        ->assertDontSee($otherImage->original_name);
});

it('stores gallery images from selected media fields', function () {
    $editor = createSectionUser();
    $page = Page::factory()->for($editor->site)->create();
    $selectedImage = Media::factory()->for($editor->site)->create([
        'path' => 'media/seleccionada.jpg',
        'alt_text' => 'Imagen seleccionada',
    ]);

    $this->actingAs($editor)
        ->post("/dashboard/pages/{$page->id}/sections", [
            'type' => 'gallery',
            'content' => [
                'title' => 'Galeria',
                'images' => [
                    'media_'.$selectedImage->id => [
                        'selected' => '1',
                        'url' => $selectedImage->path,
                        'alt' => $selectedImage->alt_text,
                    ],
                    'manual_0' => [
                        'url' => 'media/manual.jpg',
                        'alt' => 'Manual',
                    ],
                    'manual_1' => [
                        'url' => '',
                        'alt' => '',
                    ],
                ],
            ],
            'sort_order' => '3',
            'is_visible' => '1',
        ])
        ->assertRedirect("/dashboard/pages/{$page->id}/sections");

    $section = Section::query()->firstOrFail();

    expect($section->content['images'])->toBe([
        ['url' => 'media/seleccionada.jpg', 'alt' => 'Imagen seleccionada'],
        ['url' => 'media/manual.jpg', 'alt' => 'Manual'],
    ]);
});

it('allows authenticated users to update sections', function () {
    $editor = createSectionUser();
    $page = Page::factory()->for($editor->site)->create();
    $section = Section::factory()->for($page)->create([
        'type' => 'text_block',
        'content' => ['title' => 'Texto anterior', 'body' => 'Anterior'],
        'sort_order' => 1,
        'is_visible' => true,
    ]);

    $this->actingAs($editor)
        ->put("/dashboard/pages/{$page->id}/sections/{$section->id}", [
            'type' => 'faq',
            'content_title' => 'Preguntas frecuentes',
            'content_body' => 'Contenido actualizado.',
            'items_text' => "Pregunta 1\nPregunta 2",
            'sort_order' => '5',
        ])
        ->assertRedirect("/dashboard/pages/{$page->id}/sections")
        ->assertSessionHas('status', 'Seccion actualizada correctamente.');

    $section->refresh();

    expect($section->type)->toBe('faq')
        ->and($section->content['title'])->toBe('Preguntas frecuentes')
        ->and($section->content['items'])->toBe(['Pregunta 1', 'Pregunta 2'])
        ->and($section->sort_order)->toBe(5)
        ->and($section->is_visible)->toBeFalse();
});

it('prevents managing sections from another page', function () {
    $editor = createSectionUser();
    $page = Page::factory()->for($editor->site)->create();
    $otherPage = Page::factory()->for($editor->site)->create();
    $section = Section::factory()->for($otherPage)->create();

    $this->actingAs($editor)
        ->get("/dashboard/pages/{$page->id}/sections/{$section->id}/edit")
        ->assertNotFound();
});

it('prevents managing sections from another site', function () {
    $editor = createSectionUser();
    $otherPage = Page::factory()->create();

    $this->actingAs($editor)
        ->get("/dashboard/pages/{$otherPage->id}/sections")
        ->assertNotFound();
});

it('allows authenticated users to delete sections', function () {
    $editor = createSectionUser();
    $page = Page::factory()->for($editor->site)->create();
    $section = Section::factory()->for($page)->create();

    $this->actingAs($editor)
        ->delete("/dashboard/pages/{$page->id}/sections/{$section->id}")
        ->assertRedirect("/dashboard/pages/{$page->id}/sections")
        ->assertSessionHas('status', 'Seccion eliminada correctamente.');

    $this->assertDatabaseMissing('sections', [
        'id' => $section->id,
    ]);
});
