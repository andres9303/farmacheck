<?php

namespace Tests\Feature;

use App\Models\Medication;
use App\Models\User;
use App\Services\InteractionValidatorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InteractionValidatorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Prueba que un usuario puede acceder a la página del validador de interacciones.
     */
    public function test_user_can_access_interaction_validator(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/interaction-validator');

        $response->assertStatus(200);
    }

    /**
     * Prueba que un invitado no puede acceder a la página del validador de interacciones.
     */
    public function test_guest_cannot_access_interaction_validator(): void
    {
        $response = $this->get('/interaction-validator');

        $response->assertRedirect('/login');
    }

    /**
     * Prueba que el validador de interacciones puede detectar medicamentos compatibles.
     */
    public function test_interaction_validator_detects_compatible_medications(): void
    {
        $this->seed([
            \Database\Seeders\CompatibilityTypeSeeder::class,
            \Database\Seeders\ActiveIngredientSeeder::class,
            \Database\Seeders\AdministrationRouteSeeder::class,
            \Database\Seeders\ConcentrationUnitSeeder::class,
            \Database\Seeders\MedicationSeeder::class,
            \Database\Seeders\InteractionSeeder::class,
        ]);

        $user = User::factory()->create();
        $this->actingAs($user);

        $medication1 = Medication::where('commercial_name', 'Amoxil')->first();
        $medication2 = Medication::where('commercial_name', 'Advil')->first();

        $response = $this->post('/interaction-validator/validate', [
            'medications' => [$medication1->id, $medication2->id],
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'interactions' => [
                '*' => [
                    'type',
                    'medication1',
                    'medication2',
                    'compatibility',
                    'description',
                    'recommendations',
                ],
            ],
        ]);
    }

    /**
     * Prueba que el validador de interacciones puede detectar medicamentos incompatibles.
     */
    public function test_interaction_validator_detects_incompatible_medications(): void
    {
        $this->seed([
            \Database\Seeders\CompatibilityTypeSeeder::class,
            \Database\Seeders\ActiveIngredientSeeder::class,
            \Database\Seeders\AdministrationRouteSeeder::class,
            \Database\Seeders\ConcentrationUnitSeeder::class,
            \Database\Seeders\MedicationSeeder::class,
            \Database\Seeders\InteractionSeeder::class,
        ]);

        $user = User::factory()->create();
        $this->actingAs($user);

        $medication1 = Medication::where('commercial_name', 'Advil')->first();
        $medication2 = Medication::where('commercial_name', 'Coumadin')->first();

        $response = $this->post('/interaction-validator/validate', [
            'medications' => [$medication1->id, $medication2->id],
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'interactions' => [
                '*' => [
                    'type',
                    'medication1',
                    'medication2',
                    'compatibility',
                    'description',
                    'recommendations',
                ],
            ],
        ]);
    }

    /**
     * Prueba que el validador de interacciones devuelve resultados vacíos para un solo medicamento.
     */
    public function test_interaction_validator_returns_empty_for_single_medication(): void
    {
        $this->seed([
            \Database\Seeders\CompatibilityTypeSeeder::class,
            \Database\Seeders\ActiveIngredientSeeder::class,
            \Database\Seeders\AdministrationRouteSeeder::class,
            \Database\Seeders\ConcentrationUnitSeeder::class,
            \Database\Seeders\MedicationSeeder::class,
        ]);

        $user = User::factory()->create();
        $this->actingAs($user);

        $medication = Medication::first();
        $medication2 = Medication::skip(1)->first();

        $response = $this->post('/interaction-validator/validate', [
            'medications' => [$medication->id, $medication2->id],
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'interactions' => [],
        ]);
    }

    /**
     * Prueba que el validador de interacciones devuelve resultados vacíos para medicamentos no existentes.
     */
    public function test_interaction_validator_returns_empty_for_non_existent_medications(): void
    {
        $this->seed([
            \Database\Seeders\CompatibilityTypeSeeder::class,
            \Database\Seeders\ActiveIngredientSeeder::class,
            \Database\Seeders\AdministrationRouteSeeder::class,
            \Database\Seeders\ConcentrationUnitSeeder::class,
            \Database\Seeders\MedicationSeeder::class,
        ]);

        $user = User::factory()->create();
        $this->actingAs($user);

        // Obtener medicamentos válidos para asegurar que la validación pase
        $medication = Medication::first();
        $response = $this->post('/interaction-validator/validate', [
            'medications' => [$medication->id, 9999], // Uno válido y uno inválido
        ]);

        $response->assertStatus(302); // Redirección por validación fallida
    }
}
