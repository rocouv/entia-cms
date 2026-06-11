<?php

use App\Models\Media;
use App\Models\Role;
use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
});

function createMediaUser(string $roleSlug = Role::EDITOR): User
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

it('redirects guests away from media management', function () {
    $this->get('/dashboard/media')
        ->assertRedirect('/login');
});

it('shows media management to editors', function () {
    $editor = createMediaUser();
    $media = Media::factory()->for($editor->site)->for($editor)->create([
        'original_name' => 'hero.jpg',
    ]);

    $this->actingAs($editor)
        ->get('/dashboard/media')
        ->assertOk()
        ->assertSee('Media')
        ->assertSee($media->original_name)
        ->assertSee(asset('storage/'.$media->path), false);
});

it('allows authenticated users to upload media', function () {
    Storage::fake('public');
    $editor = createMediaUser();
    $file = UploadedFile::fake()->image('hero.jpg', 1200, 800)->size(300);

    $this->actingAs($editor)
        ->post('/dashboard/media', [
            'file' => $file,
            'alt_text' => 'Imagen principal del sitio',
        ])
        ->assertRedirect('/dashboard/media')
        ->assertSessionHas('status', 'Archivo subido correctamente.');

    $media = Media::query()->firstOrFail();

    expect($media->site_id)->toBe($editor->site_id)
        ->and($media->user_id)->toBe($editor->id)
        ->and($media->disk)->toBe('public')
        ->and($media->original_name)->toBe('hero.jpg')
        ->and($media->mime_type)->toBe('image/jpeg')
        ->and($media->alt_text)->toBe('Imagen principal del sitio');

    Storage::disk('public')->assertExists($media->path);
});

it('validates uploaded media type', function () {
    Storage::fake('public');
    $editor = createMediaUser();

    $this->actingAs($editor)
        ->post('/dashboard/media', [
            'file' => UploadedFile::fake()->create('script.exe', 10, 'application/octet-stream'),
        ])
        ->assertSessionHasErrors('file');

    expect(Media::query()->count())->toBe(0);
});

it('allows authenticated users to delete media', function () {
    Storage::fake('public');
    $editor = createMediaUser();
    Storage::disk('public')->put('media/hero.jpg', 'fake-image');
    $media = Media::factory()->for($editor->site)->for($editor)->create([
        'path' => 'media/hero.jpg',
    ]);

    $this->actingAs($editor)
        ->delete("/dashboard/media/{$media->id}")
        ->assertRedirect('/dashboard/media')
        ->assertSessionHas('status', 'Archivo eliminado correctamente.');

    $this->assertDatabaseMissing('media', [
        'id' => $media->id,
    ]);

    Storage::disk('public')->assertMissing('media/hero.jpg');
});
