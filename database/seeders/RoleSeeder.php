<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            Role::ADMINISTRADOR => 'Administrador',
            Role::EDITOR => 'Editor',
        ];

        foreach ($roles as $slug => $name) {
            Role::query()->updateOrCreate(
                ['slug' => $slug],
                ['name' => $name],
            );
        }
    }
}
