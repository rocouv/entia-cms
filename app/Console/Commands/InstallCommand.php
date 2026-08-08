<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Models\Role;
use App\Models\Site;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InstallCommand extends Command
{
    protected $signature = 'entia:install';

    protected $description = 'Crea el primer sitio y administrador de Entia';

    public function handle(): int
    {
        if (Site::query()->exists() || User::query()->exists()) {
            $this->error('Entia ya tiene datos instalados. No se modifico la informacion existente.');

            return self::FAILURE;
        }

        $required = [
            'admin_name' => 'ENTIA_ADMIN_NAME',
            'admin_email' => 'ENTIA_ADMIN_EMAIL',
            'admin_password' => 'ENTIA_ADMIN_PASSWORD',
            'client_name' => 'ENTIA_CLIENT_NAME',
            'site_name' => 'ENTIA_SITE_NAME',
        ];

        foreach ($required as $key => $environmentVariable) {
            if (blank(config("entia.install.{$key}"))) {
                $this->error("Falta configurar {$environmentVariable} antes de instalar Entia.");

                return self::FAILURE;
            }
        }

        $password = (string) config('entia.install.admin_password');

        if (strlen($password) < 12 || $password === 'password') {
            $this->error('ENTIA_ADMIN_PASSWORD debe tener al menos 12 caracteres y no puede ser password.');

            return self::FAILURE;
        }

        DB::transaction(function (): void {
            foreach ([
                Role::ADMINISTRADOR => 'Administrador',
                Role::EDITOR => 'Editor',
            ] as $slug => $name) {
                Role::query()->updateOrCreate(['slug' => $slug], ['name' => $name]);
            }

            $client = Client::query()->create([
                'name' => config('entia.install.client_name'),
                'legal_name' => config('entia.install.client_legal_name'),
                'contact_email' => config('entia.install.client_email'),
                'contact_phone' => config('entia.install.client_phone'),
            ]);

            $site = Site::query()->create([
                'client_id' => $client->id,
                'name' => config('entia.install.site_name'),
                'domain' => config('entia.install.site_domain'),
                'is_active' => true,
            ]);

            $site->settings()->create([
                'site_name' => config('entia.install.site_name'),
                'tagline' => config('entia.install.site_tagline'),
                'contact_email' => config('entia.install.site_contact_email'),
                'contact_phone' => config('entia.install.site_contact_phone'),
                'address' => config('entia.install.site_address'),
                'meta_title' => config('entia.install.site_meta_title'),
                'meta_description' => config('entia.install.site_meta_description'),
                'social_links' => [],
            ]);

            User::query()->create([
                'name' => config('entia.install.admin_name'),
                'email' => config('entia.install.admin_email'),
                'password' => Hash::make(config('entia.install.admin_password')),
                'role_id' => Role::query()->where('slug', Role::ADMINISTRADOR)->value('id'),
                'site_id' => $site->id,
            ]);
        });

        $this->info('Entia fue instalado correctamente sin contenido demo.');

        return self::SUCCESS;
    }
}
