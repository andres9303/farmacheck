<?php

namespace Database\Factories;

use App\Models\ActiveIngredient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ActiveIngredient>
 */
class ActiveIngredientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ActiveIngredient::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->paragraph(),
            'atc_code' => $this->faker->unique()->regexify('[A-Z][0-9]{2}[A-Z][A-Z][0-9]{2}'),
            'is_active' => true,
        ];
    }
}