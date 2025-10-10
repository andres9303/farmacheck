<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhysicochemicalInteractionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener IDs necesarios
        $perfalganId = DB::table('medications')->where('registration_number', 'INVIMA2024-002')->value('id');
        $cordaroneIVId = DB::table('medications')->where('registration_number', 'INVIMA2024-006')->value('id');
        $fentanylId = DB::table('medications')->where('registration_number', 'INVIMA2024-003')->value('id');
        $midazolamId = DB::table('medications')->where('registration_number', 'INVIMA2024-004')->value('id');
        $furosemidaId = DB::table('medications')->where('registration_number', 'INVIMA2024-008')->value('id');
        $dopaminaId = DB::table('medications')->where('registration_number', 'INVIMA2024-009')->value('id');
        $norepinefrinaId = DB::table('medications')->where('registration_number', 'INVIMA2024-010')->value('id');
        $omeprazolIVId = DB::table('medications')->where('registration_number', 'INVIMA2024-012')->value('id');
        $morfinaId = DB::table('medications')->where('registration_number', 'INVIMA2024-013')->value('id');

        $compatibleId = DB::table('compatibility_types')->where('code', 'COMPATIBLE')->value('id');
        $precautionId = DB::table('compatibility_types')->where('code', 'PRECAUTION')->value('id');
        $minorId = DB::table('compatibility_types')->where('code', 'MINOR')->value('id');
        $criticalId = DB::table('compatibility_types')->where('code', 'CRITICAL')->value('id');

        $interactions = [
            // CRÍTICA: Furosemida + Dopamina (pH incompatible)
            [
                'medication_1_id' => $furosemidaId,
                'medication_2_id' => $dopaminaId,
                'compatibility_type_id' => $criticalId,
                'description' => 'La furosemida (pH 9) y la dopamina (pH 3-4) son altamente incompatibles debido a la gran diferencia de pH. La mezcla resulta en precipitación inmediata y pérdida de potencia de ambos medicamentos.',
                'mechanism' => 'La furosemida es una solución alcalina que precipita en medio ácido. La dopamina se inactiva en medio alcalino por oxidación. La diferencia de pH causa precipitación visible de cristales blancos.',
                'consequences' => 'Precipitado blanco lechoso inmediato. Pérdida total de actividad farmacológica. Riesgo de embolia por cristales si se administra. Oclusión de catéteres.',
                'recommendations' => 'NUNCA mezclar en la misma jeringa, bolsa o línea IV. Administrar en vías IV separadas. Si se usa la misma vía, lavar con mínimo 10ml de SF entre medicamentos. Esperar 5 minutos entre administraciones.',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Alta evidencia - Estudios in vitro demostrados',
                    'references' => 'Trissel\'s Handbook on Injectable Drugs 2024'
                ]),
                'source' => 'Trissel\'s Handbook, Micromedex',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // CRÍTICA: Furosemida + Omeprazol IV
            [
                'medication_1_id' => $furosemidaId,
                'medication_2_id' => $omeprazolIVId,
                'compatibility_type_id' => $criticalId,
                'description' => 'Omeprazol IV reconstituido tiene pH muy alcalino (9-10) y la furosemida también es alcalina (pH 9). Sin embargo, la incompatibilidad se debe a la degradación del omeprazol en presencia de iones.',
                'mechanism' => 'El omeprazol es extremadamente inestable y se degrada rápidamente en presencia de iones y cambios de pH. Forma precipitado cristalino con furosemida.',
                'consequences' => 'Turbidez y precipitación visible en minutos. Pérdida de actividad del omeprazol. Posible oclusión de catéter.',
                'recommendations' => 'NO administrar en la misma vía IV simultáneamente. Si se requieren ambos medicamentos, usar vías separadas. El omeprazol debe administrarse en infusión lenta (20-30 min) en línea exclusiva.',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Alta evidencia',
                    'references' => 'Trissel\'s, King Guide to Parenteral Admixtures'
                ]),
                'source' => 'Trissel\'s Handbook 2024',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // MENOR: Perfalgan + Cordarone IV
            [
                'medication_1_id' => $perfalganId,
                'medication_2_id' => $cordaroneIVId,
                'compatibility_type_id' => $minorId,
                'description' => 'El paracetamol IV (pH 5.5) y la amiodarona IV (pH 4.1) presentan incompatibilidad menor por diferencia de pH. Pueden formar precipitado si se mezclan directamente.',
                'mechanism' => 'Diferencia de pH moderada que puede causar precipitación de microcristales. La amiodarona contiene polisorbato que puede interactuar con el paracetamol.',
                'consequences' => 'Posible turbidez leve o precipitado fino después de 30-60 minutos de mezcla. Reducción leve de biodisponibilidad.',
                'recommendations' => 'Preferible administrar en vías IV separadas. Si se usa la misma vía, lavar con 10ml SF entre medicamentos. No mezclar en la misma bolsa. Pueden administrarse en sitios Y diferentes con flujos adecuados.',
                'evidence_level' => json_encode([
                    'level' => 'B',
                    'description' => 'Moderada evidencia',
                    'references' => 'Estudios de estabilidad limitados'
                ]),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // COMPATIBLE: Fentanyl + Midazolam
            [
                'medication_1_id' => $fentanylId,
                'medication_2_id' => $midazolamId,
                'compatibility_type_id' => $compatibleId,
                'description' => 'Fentanyl y midazolam son físicamente compatibles. Pueden mezclarse en la misma jeringa o bolsa sin problemas de estabilidad química.',
                'mechanism' => 'Ambos medicamentos tienen pH similar (fentanyl 4-5, midazolam 3-4) y no presentan reacciones químicas entre sí. Son estables en SF 0.9% y DAD 5%.',
                'consequences' => 'Ninguna consecuencia negativa desde el punto de vista fisicoquímico. Mantienen estabilidad y potencia.',
                'recommendations' => 'Pueden administrarse en la misma vía IV, mezclarse en la misma jeringa o bolsa. Estables por 24 horas a temperatura ambiente en SF 0.9% o DAD 5%. Combinación frecuentemente usada en sedación de UCI.',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Alta evidencia - Ampliamente documentado',
                    'references' => 'Múltiples estudios de estabilidad'
                ]),
                'source' => 'Trissel\'s Handbook, Micromedex, King Guide',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // COMPATIBLE: Dopamina + Norepinefrina
            [
                'medication_1_id' => $dopaminaId,
                'medication_2_id' => $norepinefrinaId,
                'compatibility_type_id' => $compatibleId,
                'description' => 'Dopamina y norepinefrina son compatibles físicamente. Ambas catecolaminas pueden administrarse simultáneamente sin problemas de precipitación o degradación.',
                'mechanism' => 'pH similar (dopamina 3-4, norepinefrina 3-4.5). Ambas son catecolaminas estables en soluciones ácidas. Compatible en DAD 5% principalmente.',
                'consequences' => 'Sin consecuencias fisicoquímicas negativas. Ambos medicamentos mantienen estabilidad.',
                'recommendations' => 'Pueden administrarse en la misma vía IV si es necesario. Preferible usar DAD 5% como diluyente. Proteger de la luz (ambos son fotosensibles). Monitoreo hemodinámico estricto por efecto farmacológico aditivo.',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Alta evidencia',
                    'references' => 'Trissel\'s, estudios clínicos en UCI'
                ]),
                'source' => 'Trissel\'s Handbook 2024, Micromedex',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // COMPATIBLE: Fentanyl + Morfina
            [
                'medication_1_id' => $fentanylId,
                'medication_2_id' => $morfinaId,
                'compatibility_type_id' => $compatibleId,
                'description' => 'Fentanyl y morfina son físicamente compatibles. Pueden mezclarse sin problemas de precipitación aunque no es común esta combinación.',
                'mechanism' => 'Ambos opioides tienen pH ácido compatible (fentanyl 4-5, morfina 2.5-6.5). No hay reacción química entre ellos.',
                'consequences' => 'Sin incompatibilidad física. Mantienen estabilidad química.',
                'recommendations' => 'Compatibles físicamente pero NO se recomienda combinar por riesgo de sobredosis y depresión respiratoria severa. Si se usan ambos, calcular dosis equivalentes de opioide total. Monitoreo continuo respiratorio obligatorio.',
                'evidence_level' => json_encode([
                    'level' => 'B',
                    'description' => 'Moderada evidencia fisicoquímica',
                    'references' => 'Trissel\'s Handbook'
                ]),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // PRECAUCIÓN: Midazolam + Morfina
            [
                'medication_1_id' => $midazolamId,
                'medication_2_id' => $morfinaId,
                'compatibility_type_id' => $precautionId,
                'description' => 'Midazolam y morfina son físicamente compatibles en la mayoría de diluciones, pero pueden presentar turbidez en altas concentraciones.',
                'mechanism' => 'pH levemente diferente (midazolam 3-4, morfina 2.5-6.5). En concentraciones altas o en algunos vehículos pueden presentar leve turbidez por diferencia de solubilidad.',
                'consequences' => 'Posible turbidez leve en concentraciones altas (>5mg/ml midazolam). Compatible en concentraciones clínicas habituales.',
                'recommendations' => 'Verificar transparencia de la solución antes de administrar. Usar concentraciones estándar. Compatible en SF 0.9% y DAD 5% en concentraciones habituales. Monitoreo respiratorio estricto por efecto farmacodinámico aditivo.',
                'evidence_level' => json_encode([
                    'level' => 'B',
                    'description' => 'Moderada evidencia - Depende de concentración',
                    'references' => 'Trissel\'s Handbook'
                ]),
                'source' => 'Trissel\'s Handbook, estudios de compatibilidad',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('physicochemical_interactions')->insert($interactions);
    }
}
