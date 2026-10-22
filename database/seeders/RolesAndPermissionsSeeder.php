<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $adminRole = \Spatie\Permission\Models\Role::create(['name' => 'Administrador']);
        $gestorRole = \Spatie\Permission\Models\Role::create(['name' => 'Gestor']);
        $estudianteRole = \Spatie\Permission\Models\Role::create(['name' => 'Estudiante']);

        $admin = \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@bvui.edu.ve',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole($adminRole);
    }
}
