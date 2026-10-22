<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestingDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Generando 500 usuarios falsos...');
        
        // Crear 500 usuarios
        $users = collect();
        for ($i = 0; $i < 5; $i++) {
            $chunk = \App\Models\User::factory(100)->create()->each(function ($user) {
                // Asignar rol aleatorio (solo Gestor o Estudiante)
                $role = fake()->randomElement(['Gestor', 'Estudiante']);
                $user->assignRole($role);
            });
            $users = $users->merge($chunk);
        }

        $this->command->info('Generando 10,000 documentos (esto puede tomar unos minutos)...');

        // Desactivar sincronización de Scout temporalmente para no saturar Meilisearch
        \App\Models\Document::withoutSyncingToSearch(function () use ($users) {
            // Generar 10000 documentos en bloques de 200
            for ($i = 0; $i < 50; $i++) {
                \App\Models\Document::factory(200)->recycle($users)->create();
                $this->command->info("Lote " . ($i + 1) . " de 50 completado...");
            }
        });
        
        $this->command->info('Creación finalizada. Recuerda ejecutar php artisan scout:import "App\Models\Document" para indexarlos.');
    }
}
