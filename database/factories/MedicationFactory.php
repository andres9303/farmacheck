<?php

namespace Database\Factories;

use App\Models\Medication;
use App\Models\ActiveIngredient;
use App\Models\ConcentrationUnit;
use App\Models\AdministrationRoute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medication>
 */
class MedicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Medication::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'commercial_name' => $this->faker->words(2, true),
            'generic_name' => $this->faker->word(),
            'active_ingredient_id' => ActiveIngredient::factory(),
            'concentration_unit_id' => ConcentrationUnit::factory(),
            'concentration' => $this->faker->randomFloat(2, 0.1, 100),
            'administration_route_id' => AdministrationRoute::factory(),
            'pharmaceutical_form' => $this->faker->randomElement(['Tableta', 'Cápsula', 'Jarabe', 'Inyectable']),
            'registration_number' => $this->faker->unique()->numerify('INV-####-####'),
            'laboratory' => $this->faker->company(),
            'presentation' => $this->faker->randomElement(['Caja con 10 tabletas', 'Caja con 20 cápsulas', 'Frasco con 120 ml', 'Ampolla con 5 ml']),
            'indications' => $this->faker->paragraph(),
            'contraindications' => $this->faker->paragraph(),
            'warnings' => $this->faker->paragraph(),
            'storage_conditions' => json_encode([
                'temperature' => $this->faker->randomElement(['ambiente', 'refrigeración']),
                'humidity' => $this->faker->randomElement(['baja', 'media', 'alta']),
                'light' => $this->faker->randomElement(['proteger de la luz', 'no requiere protección'])
            ]),
            'is_active' => true,
        ];
    }
}