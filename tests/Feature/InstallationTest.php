<?php

use App\Models\Category;
use App\Models\Page;
use App\Models\Project;
use App\Models\Role;
use App\Models\Service;
use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

function configureInstallation(): void
{
    config([
        'entia.install.admin_name' => 'Administradora',
        'entia.install.admin_email' => 'admin@example.test',
        'entia.install.admin_password' => 'una-contrasena-segura',
        'entia.install.client_name' => 'Cliente de prueba',
        'entia.install.client_legal_name' => null,
        'entia.install.client_email' => 'cliente@example.test',
        'entia.install.client_phone' => null,
        'entia.install.site_name' => 'Sitio de prueba',
        'entia.install.site_domain' => 'sitio.example.test',
        'entia.install.site_tagline' => null,
        'entia.install.site_contact_email' => 'contacto@example.test',
        'entia.install.site_contact_phone' => null,
        'entia.install.site_address' => null,
        'entia.install.site_meta_title' => null,
        'entia.install.site_meta_description' => null,
    ]);
}

it('seeds only system roles by default', function () {
    $this->artisan('db:seed')
        ->assertExitCode(0);

    expect(Role::query()->count())->toBe(2)
        ->and(Site::query()->count())->toBe(0)
        ->and(User::query()->count())->toBe(0)
        ->and(Page::query()->count())->toBe(0)
        ->and(Category::query()->count())->toBe(0)
        ->and(Service::query()->count())->toBe(0)
        ->and(Project::query()->count())->toBe(0);
});

it('installs the first site from explicit configuration without demo content', function () {
    configureInstallation();

    $this->artisan('entia:install')
        ->expectsOutput('Entia fue instalado correctamente sin contenido demo.')
        ->assertExitCode(0);

    $admin = User::query()->firstOrFail();

    expect(Site::query()->count())->toBe(1)
        ->and(User::query()->count())->toBe(1)
        ->and($admin->email)->toBe('admin@example.test')
        ->and(Hash::check('una-contrasena-segura', $admin->password))->toBeTrue()
        ->and(Page::query()->count())->toBe(0)
        ->and(Category::query()->count())->toBe(0)
        ->and(Service::query()->count())->toBe(0)
        ->and(Project::query()->count())->toBe(0);
});

it('does not reinstall or modify an existing site', function () {
    configureInstallation();

    $this->artisan('entia:install')->assertExitCode(0);

    config(['entia.install.site_name' => 'Nombre cambiado']);

    $this->artisan('entia:install')
        ->expectsOutput('Entia ya tiene datos instalados. No se modifico la informacion existente.')
        ->assertExitCode(1);

    expect(Site::query()->firstOrFail()->name)->toBe('Sitio de prueba');
});

it('rejects an unsafe administrator password', function () {
    configureInstallation();
    config(['entia.install.admin_password' => 'password']);

    $this->artisan('entia:install')
        ->expectsOutput('ENTIA_ADMIN_PASSWORD debe tener al menos 12 caracteres y no puede ser password.')
        ->assertExitCode(1);

    expect(Site::query()->count())->toBe(0)
        ->and(User::query()->count())->toBe(0);
});

it('requires the client and site identity before installation', function () {
    configureInstallation();
    config(['entia.install.client_name' => null]);

    $this->artisan('entia:install')
        ->expectsOutput('Falta configurar ENTIA_CLIENT_NAME antes de instalar Entia.')
        ->assertExitCode(1);

    expect(Site::query()->count())->toBe(0)
        ->and(User::query()->count())->toBe(0);
});

it('does not allow demo content seeding in production', function () {
    app()->detectEnvironment(fn (): string => 'production');

    expect(fn () => $this->artisan('db:seed', ['--class' => 'DemoContentSeeder', '--force' => true]))
        ->toThrow(LogicException::class, 'DemoContentSeeder solo puede ejecutarse fuera de produccion.');
});

it('resets the password of an existing administrator from temporary configuration', function () {
    configureInstallation();

    $this->artisan('entia:install')->assertExitCode(0);

    config([
        'entia.install.reset_email' => 'admin@example.test',
        'entia.install.reset_password' => 'otra-contrasena-segura',
    ]);

    $this->artisan('entia:admin-reset')
        ->expectsOutput('Contrasena actualizada para admin@example.test.')
        ->assertExitCode(0);

    expect(Hash::check('otra-contrasena-segura', User::query()->firstOrFail()->password))->toBeTrue();
});

it('does not reset an unknown administrator or accept a weak reset password', function () {
    configureInstallation();

    $this->artisan('entia:install')->assertExitCode(0);

    config([
        'entia.install.reset_email' => 'unknown@example.test',
        'entia.install.reset_password' => 'password',
    ]);

    $this->artisan('entia:admin-reset')
        ->expectsOutput('ENTIA_ADMIN_RESET_PASSWORD debe tener al menos 12 caracteres y no puede ser password.')
        ->assertExitCode(1);

    expect(Hash::check('una-contrasena-segura', User::query()->firstOrFail()->password))->toBeTrue();
});
