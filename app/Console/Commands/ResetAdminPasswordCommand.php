<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetAdminPasswordCommand extends Command
{
    protected $signature = 'entia:admin-reset';

    protected $description = 'Restablece la contrasena de un administrador existente';

    public function handle(): int
    {
        $email = config('entia.install.reset_email');
        $password = (string) config('entia.install.reset_password');

        if (blank($email) || blank($password)) {
            $this->error('Configura ENTIA_ADMIN_RESET_EMAIL y ENTIA_ADMIN_RESET_PASSWORD antes de continuar.');

            return self::FAILURE;
        }

        if (strlen($password) < 12 || $password === 'password') {
            $this->error('ENTIA_ADMIN_RESET_PASSWORD debe tener al menos 12 caracteres y no puede ser password.');

            return self::FAILURE;
        }

        $admin = User::query()
            ->where('email', $email)
            ->whereHas('role', fn ($query) => $query->where('slug', Role::ADMINISTRADOR))
            ->first();

        if (! $admin) {
            $this->error("No existe un administrador con el correo {$email}.");

            return self::FAILURE;
        }

        DB::transaction(function () use ($admin, $password): void {
            $admin->update(['password' => Hash::make($password)]);
        });

        $this->info("Contrasena actualizada para {$email}.");

        return self::SUCCESS;
    }
}
