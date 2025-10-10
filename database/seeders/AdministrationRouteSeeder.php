<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeder para vías de administración de medicamentos
 * Define las diferentes formas en que pueden administrarse
 * los medicamentos en el sistema
 */
class AdministrationRouteSeeder extends Seeder
{
    /**
     * Ejecuta el seeder para poblar la tabla de vías de administración
     * Crea las vías comunes de administración con sus códigos y descripciones
     */
    public function run(): void
    {
        $routes = [
            [
                'name' => 'Intravenosa',
                'code' => 'IV',
                'description' => 'Administración directa en vena. Permite efecto inmediato y absorción completa.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Intramuscular',
                'code' => 'IM',
                'description' => 'Administración en tejido muscular. Absorción más lenta que IV.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Subcutánea',
                'code' => 'SC',
                'description' => 'Administración bajo la piel. Absorción gradual y sostenida.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Oral',
                'code' => 'PO',
                'description' => 'Administración por vía oral. Pasa por tracto gastrointestinal.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sublingual',
                'code' => 'SL',
                'description' => 'Administración bajo la lengua. Absorción rápida sin paso hepático.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tópica',
                'code' => 'TOP',
                'description' => 'Aplicación sobre la piel. Efecto local principalmente.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rectal',
                'code' => 'PR',
                'description' => 'Administración rectal. Útil cuando vía oral no es posible.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Inhalatoria',
                'code' => 'INH',
                'description' => 'Administración por vía respiratoria. Acción rápida en vías aéreas.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Oftálmica',
                'code' => 'OFT',
                'description' => 'Administración en los ojos. Efecto local.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ótica',
                'code' => 'OT',
                'description' => 'Administración en el oído. Efecto local.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('administration_routes')->insert($routes);
    }
}
