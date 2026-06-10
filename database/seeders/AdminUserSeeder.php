<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::query()->where('slug', Role::ADMINISTRADOR)->firstOrFail();

        User::query()->updateOrCreate(
            ['email' => env('ENTIA_ADMIN_EMAIL', 'admin@entia.local')],
            [
                'name' => env('ENTIA_ADMIN_NAME', 'Administrador Entia'),
                'password' => Hash::make(env('ENTIA_ADMIN_PASSWORD', 'password')),
                'role_id' => $adminRole->id,
            ],
        );
    }
}
