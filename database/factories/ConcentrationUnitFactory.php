<?php

namespace Database\Factories;

use App\Models\ConcentrationUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ConcentrationUnit>
 */
class ConcentrationUnitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ConcentrationUnit::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['miligramo', 'gramo', 'microgramo', 'miliequivalente', 'porcentaje']),
            'symbol' => $this->faker->randomElement(['mg', 'g', 'mcg', 'mEq', '%']),
            'description' => $this->faker->sentence(),
            'is_active' => true,
        ];
    }
}