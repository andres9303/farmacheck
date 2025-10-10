<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeder para unidades de concentración de medicamentos
 * Define las diferentes unidades utilizadas para expresar
 * la concentración y dosis de los medicamentos
 */
class ConcentrationUnitSeeder extends Seeder
{
    /**
     * Ejecuta el seeder para poblar la tabla de unidades de concentración
     * Crea las unidades comunes de masa, volumen y concentración
     */
    public function run(): void
    {
        $units = [
            [
                'name' => 'Miligramos',
                'symbol' => 'mg',
                'description' => 'Unidad de masa. 1 mg = 0.001 g',
                'type' => 'mass',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gramos',
                'symbol' => 'g',
                'description' => 'Unidad base de masa en sistema métrico.',
                'type' => 'mass',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Microgramos',
                'symbol' => 'mcg',
                'description' => 'Unidad de masa. 1 mcg = 0.001 mg = 0.000001 g',
                'type' => 'mass',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Miligramos por mililitro',
                'symbol' => 'mg/ml',
                'description' => 'Concentración: masa por volumen.',
                'type' => 'concentration',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gramos por mililitro',
                'symbol' => 'g/ml',
                'description' => 'Concentración: masa por volumen para soluciones concentradas.',
                'type' => 'concentration',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mililitros',
                'symbol' => 'ml',
                'description' => 'Unidad de volumen.',
                'type' => 'volume',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Porcentaje',
                'symbol' => '%',
                'description' => 'Porcentaje de concentración.',
                'type' => 'percentage',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Unidades Internacionales',
                'symbol' => 'UI',
                'description' => 'Medida de actividad biológica.',
                'type' => 'biological',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Miliequivalentes',
                'symbol' => 'mEq',
                'description' => 'Unidad de medida electrolítica.',
                'type' => 'electrolyte',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Milimoles',
                'symbol' => 'mmol',
                'description' => 'Unidad de cantidad de sustancia.',
                'type' => 'molar',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('concentration_units')->insert($units);
    }
}
