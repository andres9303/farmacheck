<?php

namespace Database\Factories;

use App\Models\AdministrationRoute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdministrationRoute>
 */
class AdministrationRouteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AdministrationRoute::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $routes = [
            ['name' => 'Vía oral', 'code' => 'ORAL', 'description' => 'Administración por boca'],
            ['name' => 'Vía intravenosa', 'code' => 'IV', 'description' => 'Administración directamente en la vena'],
            ['name' => 'Vía intramuscular', 'code' => 'IM', 'description' => 'Administración en el músculo'],
            ['name' => 'Vía subcutánea', 'code' => 'SC', 'description' => 'Administración debajo de la piel'],
            ['name' => 'Vía intradérmica', 'code' => 'ID', 'description' => 'Administración dentro de la piel'],
        ];

        $route = $this->faker->unique()->randomElement($routes);

        return [
            'name' => $route['name'],
            'code' => $route['code'],
            'description' => $route['description'],
            'is_active' => true,
        ];
    }
}