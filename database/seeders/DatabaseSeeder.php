<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call(RoleAndPermissionSeeder::class);
        $this->call(CadastrosSeeder::class);

        $admin = User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@patrimonio.test',
        ]);

        $admin->assignRole('admin');
    }
}
