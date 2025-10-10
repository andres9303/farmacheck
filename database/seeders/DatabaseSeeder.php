<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Seeder principal de la base de datos
 * Orquesta la ejecución de todos los seeders específicos
 * para poblar la base de datos con datos iniciales
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Ejecuta todos los seeders para poblar la base de datos
     * Se ejecutan en orden para mantener las relaciones de integridad referencial
     */
    public function run(): void
    {
        //Crear usuario administrador para iniciar
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('1234567890'),
        ]);

        $this->call([
            // Tipos de compatibilidad (requerido por interacciones)
            CompatibilityTypeSeeder::class,
            // Vías de administración (requerido por medicamentos)
            AdministrationRouteSeeder::class,
            // Unidades de concentración (requerido por medicamentos)
            ConcentrationUnitSeeder::class,
            // Principios activos (requerido por medicamentos)
            ActiveIngredientSeeder::class,
            // Medicamentos (requerido por interacciones)
            MedicationSeeder::class,
            // Interacciones completas (depende de medicamentos)
            CompleteInteractionsSeeder::class,
            // Interacciones medicamentos Colombia
            ColombianMedicationsSeeder::class,
            /*
            // Seeders individuales de interacciones (reemplazados por CompleteInteractionsSeeder)
            PhysicochemicalInteractionSeeder::class,
            PharmacodynamicInteractionSeeder::class,
            PharmacokineticInteractionSeeder::class,
            */
        ]);
    }
}
