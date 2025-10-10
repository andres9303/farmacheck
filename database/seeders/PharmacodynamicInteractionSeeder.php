<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PharmacodynamicInteractionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener IDs de medicamentos (usamos medication_id pero la interacción es por principio activo)
        $fentanylId = DB::table('medications')->where('registration_number', 'INVIMA2024-003')->value('id');
        $midazolamId = DB::table('medications')->where('registration_number', 'INVIMA2024-004')->value('id');
        $morfinaId = DB::table('medications')->where('registration_number', 'INVIMA2024-013')->value('id');
        $cordaroneId = DB::table('medications')->where('registration_number', 'INVIMA2024-005')->value('id'); // oral
        $warfarinaId = DB::table('medications')->where('registration_number', 'INVIMA2024-007')->value('id');
        $dopaminaId = DB::table('medications')->where('registration_number', 'INVIMA2024-009')->value('id');
        $norepinefrinaId = DB::table('medications')->where('registration_number', 'INVIMA2024-010')->value('id');

        $compatibleId = DB::table('compatibility_types')->where('code', 'COMPATIBLE')->value('id');
        $precautionId = DB::table('compatibility_types')->where('code', 'PRECAUTION')->value('id');
        $minorId = DB::table('compatibility_types')->where('code', 'MINOR')->value('id');
        $criticalId = DB::table('compatibility_types')->where('code', 'CRITICAL')->value('id');

        $interactions = [
            // CRÍTICA: Fentanyl + Midazolam (Depresión respiratoria)
            [
                'medication_1_id' => $fentanylId,
                'medication_2_id' => $midazolamId,
                'compatibility_type_id' => $precautionId, // No crítica pero requiere precaución importante
                'interaction_type' => 'Sinergia Aditiva',
                'description' => 'Fentanyl (opioide) y midazolam (benzodiacepina) producen sinergia aditiva en la depresión del sistema nervioso central. Ambos causan sedación, depresión respiratoria y reducción del nivel de consciencia.',
                'mechanism' => 'Fentanyl actúa sobre receptores mu-opioides causando analgesia y depresión respiratoria. Midazolam potencia la acción del GABA en receptores GABA-A causando sedación. Los efectos se suman produciendo depresión del SNC mayor que cada medicamento individual.',
                'clinical_effects' => 'Sedación profunda, depresión respiratoria (FR <10-12 rpm), disminución de saturación de oxígeno, hipotensión, bradicardia, pérdida de reflejos protectores de vía aérea, riesgo de paro respiratorio.',
                'recommendations' => 'REDUCIR dosis de ambos medicamentos en 25-50% de la dosis habitual. Titular lentamente según respuesta. Monitoreo continuo: SatO2, frecuencia respiratoria, nivel de consciencia (escala de sedación), presión arterial. Tener disponibles antídotos: naloxona (para fentanyl) y flumazenil (para midazolam). Considerar soporte ventilatorio si es necesario. En UCI es combinación útil y segura CON monitoreo adecuado.',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Alta evidencia - Ampliamente documentado en práctica clínica',
                    'population' => 'Mayor riesgo: ancianos, EPOC, apnea del sueño, obesidad, insuficiencia hepática'
                ]),
                'source' => 'Micromedex, UpToDate, guías de sedación UCI',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // CRÍTICA: Fentanyl + Morfina (Sobredosis opioide)
            [
                'medication_1_id' => $fentanylId,
                'medication_2_id' => $morfinaId,
                'compatibility_type_id' => $criticalId,
                'interaction_type' => 'Sinergia Aditiva - Duplicación Terapéutica',
                'description' => 'Uso simultáneo de dos opioides potentes (fentanyl y morfina) resulta en efecto opioide aditivo con alto riesgo de sobredosis y depresión respiratoria severa.',
                'mechanism' => 'Ambos son agonistas de receptores mu-opioides. El efecto analgésico y depresor respiratorio se suma. Fentanyl es 50-100 veces más potente que morfina, facilitando sobredosis inadvertida.',
                'clinical_effects' => 'Depresión respiratoria severa (FR <8 rpm o apnea), sedación profunda o coma, miosis puntiforme, hipotensión severa, bradicardia, paro respiratorio, muerte.',
                'recommendations' => 'EVITAR uso simultáneo excepto en situaciones muy específicas (rotación de opioides, dolor refractario en cuidados paliativos). Si se usan ambos, calcular dosis equivalente de opioide total (conversión a equivalentes de morfina). Reducir dosis de ambos significativamente. Monitoreo continuo intensivo. Naloxona inmediatamente disponible. Considerar esta combinación solo en unidades con capacidad de soporte ventilatorio.',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Alta evidencia - Contraindicación relativa',
                    'warnings' => 'Riesgo de muerte por depresión respiratoria'
                ]),
                'source' => 'FDA, Micromedex, guías de manejo de dolor',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // PRECAUCIÓN: Amiodarona + Warfarina (Prolongación QT + sangrado)
            [
                'medication_1_id' => $cordaroneId,
                'medication_2_id' => $warfarinaId,
                'compatibility_type_id' => $precautionId,
                'interaction_type' => 'Sinergia Aditiva',
                'description' => 'Amiodarona y warfarina pueden prolongar ambos el intervalo QT, aumentando riesgo de arritmias ventriculares (torsades de pointes). Además existe interacción farmacocinética importante (ver interacciones farmacocinéticas).',
                'mechanism' => 'Ambos medicamentos prolongan la repolarización ventricular (intervalo QT en ECG). Amiodarona bloquea canales de potasio. Warfarina puede contribuir indirectamente a prolongación de QT por alteraciones electrolíticas.',
                'clinical_effects' => 'Prolongación de intervalo QT >500ms, riesgo de torsades de pointes (arritmia ventricular polimórfica potencialmente fatal), síncope, paro cardíaco.',
                'recommendations' => 'Monitoreo ECG basal y periódico (semanal al inicio, luego mensual). Medir intervalo QTc. Evitar combinación si QTc basal >480ms. Corregir hipopotasemia e hipomagnesemia antes de iniciar. Monitorear electrolitos semanalmente. Mayor precaución en: mujeres, ancianos, insuficiencia cardíaca, bradicardia. Suspender si QTc >500ms o aumenta >60ms del basal. Además, ajustar dosis de warfarina por interacción farmacocinética (ver INR).',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Alta evidencia',
                    'risk_factors' => 'Mujeres, edad >65 años, bradicardia, IC, alteraciones electrolíticas'
                ]),
                'source' => 'FDA, ACC/AHA Guidelines, Micromedex',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // PRECAUCIÓN: Dopamina + Norepinefrina (Vasoconstricción excesiva)
            [
                'medication_1_id' => $dopaminaId,
                'medication_2_id' => $norepinefrinaId,
                'compatibility_type_id' => $precautionId,
                'interaction_type' => 'Sinergia Aditiva',
                'description' => 'Dopamina y norepinefrina son ambos vasopresores con efectos alfa-adrenérgicos que causan vasoconstricción. El uso simultáneo potencia el efecto vasopresor.',
                'mechanism' => 'Ambos activan receptores alfa-adrenérgicos causando vasoconstricción arterial y venosa. Norepinefrina es vasopresor más potente. Dopamina en dosis >10mcg/kg/min tiene efecto alfa predominante. Los efectos se suman produciendo vasoconstricción intensa.',
                'clinical_effects' => 'Hipertensión severa, taquicardia, vasoconstricción periférica excesiva con isquemia (dedos, extremidades), isquemia mesentérica, necrosis tisular en sitio de extravasación, cefalea severa, arritmias cardíacas.',
                'recommendations' => 'Combinación frecuente y útil en shock séptico refractario. Usar dosis más bajas de cada uno en lugar de dosis altas de uno solo. Monitoreo continuo: PA cada 2-5 minutos (invasiva preferible), ECG continuo, perfusión periférica, diuresis horaria, lactato sérico. Evaluar perfusión de extremidades cada 2-4 horas. Administrar en vía central para evitar extravasación. Titular cuidadosamente. Objetivo: PAM 65-70mmHg, no más.',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Alta evidencia - Combinación estándar en shock',
                    'guidelines' => 'Surviving Sepsis Campaign 2021'
                ]),
                'source' => 'Surviving Sepsis Guidelines, Micromedex, UpToDate',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // PRECAUCIÓN: Midazolam + Morfina (Depresión SNC)
            [
                'medication_1_id' => $midazolamId,
                'medication_2_id' => $morfinaId,
                'compatibility_type_id' => $precautionId,
                'interaction_type' => 'Sinergia Aditiva',
                'description' => 'Midazolam (benzodiacepina) y morfina (opioide) producen sinergia aditiva en depresión del SNC y respiratoria. Similar a fentanyl + midazolam pero morfina tiene vida media más larga.',
                'mechanism' => 'Midazolam potencia GABA causando sedación. Morfina activa receptores mu-opioides causando analgesia y depresión respiratoria. Los efectos depresores del SNC se suman. Morfina tiene duración de acción más prolongada que fentanyl (3-4 horas vs 30-60 minutos).',
                'clinical_effects' => 'Sedación profunda prolongada, depresión respiratoria (FR <10 rpm), desaturación, hipotensión, bradicardia, íleo, retención urinaria, riesgo de paro respiratorio.',
                'recommendations' => 'Reducir dosis de ambos medicamentos en 25-40%. Morfina tiene duración más larga, considerar sedación prolongada. Monitoreo continuo: SatO2, FR, nivel de consciencia, PA. Tener naloxona y flumazenil disponibles. Mayor precaución en ancianos (reducir dosis 50%), insuficiencia renal (morfina se acumula), insuficiencia hepática. Combinación útil para sedoanalgesia pero requiere vigilancia estrecha.',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Alta evidencia',
                    'special_populations' => 'Ancianos, IR, IH, EPOC'
                ]),
                'source' => 'Micromedex, guías de sedación, UpToDate',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // MENOR: Dopamina uso solo (información educativa)
            [
                'medication_1_id' => $dopaminaId,
                'medication_2_id' => $dopaminaId, // Mismo medicamento para info
                'compatibility_type_id' => $compatibleId,
                'interaction_type' => 'Información - Efectos dosis-dependientes',
                'description' => 'La dopamina tiene efectos farmacológicos diferentes según la dosis utilizada. Es importante para entender sus interacciones con otros vasopresores.',
                'mechanism' => 'Dosis bajas (2-5 mcg/kg/min): efecto dopaminérgico (vasodilatación renal y mesentérica). Dosis medias (5-10 mcg/kg/min): efecto beta-adrenérgico (inotrópico). Dosis altas (>10 mcg/kg/min): efecto alfa-adrenérgico (vasoconstricción).',
                'clinical_effects' => 'Dosis dependientes: renal en dosis bajas, cardíaco en dosis medias, vasopresor en dosis altas. Taquicardia, arritmias (especialmente en dosis >10 mcg/kg/min), aumento de consumo miocárdico de oxígeno.',
                'recommendations' => 'Iniciar con dosis bajas y titular según respuesta. Monitoreo continuo hemodinámico. Preferir norepinefrina como vasopresor de primera línea en shock séptico. Dopamina es segunda línea o en bradicardia asociada. No usar "dosis renal" (mito - no protege función renal).',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Conocimiento farmacológico establecido',
                    'note' => 'Registro informativo, no es interacción entre dos medicamentos'
                ]),
                'source' => 'Surviving Sepsis Guidelines, farmacología básica',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('pharmacodynamic_interactions')->insert($interactions);
    }
}
