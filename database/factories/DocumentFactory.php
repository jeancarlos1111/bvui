<?php

namespace Database\Factories;

use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected static array $careerIds = [];
    protected static array $locationIds = [];

    public function definition(): array
    {
        if (empty(self::$careerIds)) {
            self::$careerIds = \App\Models\Career::pluck('id')->toArray();
        }
        if (empty(self::$locationIds)) {
            self::$locationIds = \App\Models\Location::pluck('id')->toArray();
        }
        
        // Si no hay carreras o ubicaciones, se debe crear al menos una
        if (empty(self::$careerIds)) {
            $career = \App\Models\Career::create(['name' => 'Carrera por Defecto']);
            self::$careerIds = [$career->id];
        }
        if (empty(self::$locationIds)) {
            $location = \App\Models\Location::create(['name' => 'Ubicación por Defecto']);
            self::$locationIds = [$location->id];
        }

        return [
            'title' => fake()->sentence(6),
            'abstract' => fake()->realText(200),
            'year' => fake()->numberBetween(2010, 2026),
            'category' => fake()->randomElement(['TEG', 'Pasantía', 'Proyecto', 'Servicio Comunitario']),
            'status' => fake()->randomElement(['Pendiente', 'Aprobado', 'Aprobado', 'Aprobado', 'Rechazado']),
            'pdf_path' => 'private/documentos/falso.pdf',
            'user_id' => \App\Models\User::factory(),
            'career_id' => fake()->randomElement(self::$careerIds),
            'location_id' => fake()->randomElement(self::$locationIds),
        ];
    }
}
