<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeder para tipos de compatibilidad entre medicamentos
 * Define los niveles y categorías de compatibilidad utilizados
 * en el sistema para clasificar interacciones medicamentosas
 */
class CompatibilityTypeSeeder extends Seeder
{
    /**
     * Ejecuta el seeder para poblar la tabla de tipos de compatibilidad
     * Crea los niveles de compatibilidad utilizados en todo el sistema
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'Compatible',
                'code' => 'COMPATIBLE',
                'level' => 'compatible',
                'color' => '#4CAF50',
                'description' => 'Los medicamentos son compatibles y pueden administrarse juntos sin problemas significativos.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Precaución',
                'code' => 'PRECAUTION',
                'level' => 'precaution',
                'color' => '#FFC107',
                'description' => 'Los medicamentos pueden administrarse juntos pero requieren monitoreo o ajuste de dosis.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Incompatibilidad Menor',
                'code' => 'MINOR',
                'level' => 'minor',
                'color' => '#FF9800',
                'description' => 'Incompatibilidad menor. Se recomienda administrar en vías separadas o con lavado intermedio.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Incompatibilidad Crítica',
                'code' => 'CRITICAL',
                'level' => 'critical',
                'color' => '#F44336',
                'description' => 'Incompatibilidad severa. No administrar juntos. Riesgo significativo para el paciente.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('compatibility_types')->insert($types);
    }
}