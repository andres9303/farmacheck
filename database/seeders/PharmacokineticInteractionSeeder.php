<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PharmacokineticInteractionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener IDs de medicamentos
        $cordaroneId = DB::table('medications')->where('registration_number', 'INVIMA2024-005')->value('id'); // oral
        $warfarinaId = DB::table('medications')->where('registration_number', 'INVIMA2024-007')->value('id');
        $omeprazolId = DB::table('medications')->where('registration_number', 'INVIMA2024-011')->value('id'); // oral
        $midazolamId = DB::table('medications')->where('registration_number', 'INVIMA2024-004')->value('id');
        $fentanylId = DB::table('medications')->where('registration_number', 'INVIMA2024-003')->value('id');

        $compatibleId = DB::table('compatibility_types')->where('code', 'COMPATIBLE')->value('id');
        $precautionId = DB::table('compatibility_types')->where('code', 'PRECAUTION')->value('id');
        $minorId = DB::table('compatibility_types')->where('code', 'MINOR')->value('id');
        $criticalId = DB::table('compatibility_types')->where('code', 'CRITICAL')->value('id');

        $interactions = [
            // CRÍTICA: Amiodarona → Warfarina (Metabolismo - CYP2C9)
            [
                'medication_1_id' => $warfarinaId, // AFECTADO
                'medication_2_id' => $cordaroneId, // CAUSANTE
                'compatibility_type_id' => $criticalId,
                'process_affected' => 'Metabolismo',
                'description' => 'Amiodarona es un potente inhibidor de CYP2C9, enzima que metaboliza la warfarina (específicamente el enantiómero S-warfarina, más potente). La inhibición resulta en aumento significativo de niveles de warfarina.',
                'mechanism' => 'Amiodarona inhibe CYP2C9 en el hígado, reduciendo el metabolismo de S-warfarina. Esto causa acumulación de warfarina con aumento de 30-50% en niveles plasmáticos. El efecto se mantiene durante semanas después de suspender amiodarona (vida media muy larga ~58 días).',
                'clinical_effects' => 'INR aumenta significativamente (puede duplicarse o triplicarse). Riesgo alto de hemorragia: sangrado gastrointestinal, hematuria, equimosis, hematomas, sangrado intracraneal (el más grave). Efecto se manifiesta en 3-7 días y alcanza máximo en 2-4 semanas.',
                'recommendations' => 'REDUCIR dosis de warfarina en 30-50% al iniciar amiodarona. Monitoreo INR muy frecuente: cada 2-3 días la primera semana, luego semanal por 4 semanas, después cada 2-4 semanas. Objetivo INR: 2-3 (según indicación). Ajustar warfarina según INR. Educar al paciente sobre signos de sangrado. Si se suspende amiodarona, puede requerir AUMENTAR warfarina gradualmente (monitoreo INR continuo). El efecto de amiodarona persiste 1-3 meses después de suspenderla.',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Alta evidencia - Interacción bien documentada',
                    'magnitude' => 'Aumento de INR 30-100%',
                    'time_course' => 'Inicio: 3-7 días, Máximo: 2-4 semanas, Duración: semanas-meses'
                ]),
                'source' => 'Micromedex, Lexicomp, FDA, estudios farmacocinéticos',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // CRÍTICA: Omeprazol → Warfarina (Metabolismo - CYP2C19)
            [
                'medication_1_id' => $warfarinaId, // AFECTADO
                'medication_2_id' => $omeprazolId, // CAUSANTE
                'compatibility_type_id' => $minorId, // Menor que amiodarona
                'process_affected' => 'Metabolismo',
                'description' => 'Omeprazol inhibe débilmente CYP2C19, que participa en el metabolismo de R-warfarina (enantiómero menos potente). La interacción es menor que con amiodarona pero puede aumentar levemente el efecto anticoagulante.',
                'mechanism' => 'Omeprazol es sustrato e inhibidor de CYP2C19. Reduce metabolismo de R-warfarina principalmente. Como R-warfarina es menos potente que S-warfarina, el efecto clínico es menor. Aumento de INR típicamente <20%.',
                'clinical_effects' => 'Aumento leve a moderado de INR (generalmente 10-20%). Riesgo menor de sangrado comparado con otras interacciones. Efecto más significativo en metabolizadores lentos de CYP2C19 (asiáticos tienen mayor frecuencia).',
                'recommendations' => 'Monitoreo INR al iniciar o cambiar dosis de omeprazol: verificar INR en 3-5 días, luego seguimiento habitual. Ajustar warfarina solo si INR aumenta significativamente. Considerar pantoprazol como alternativa (menor interacción). Mayoría de pacientes no requieren ajuste de dosis. Estar alerta en metabolizadores lentos de CYP2C19.',
                'evidence_level' => json_encode([
                    'level' => 'B',
                    'description' => 'Moderada evidencia - Interacción clínicamente significativa en algunos pacientes',
                    'magnitude' => 'Aumento de INR 10-20%',
                    'variability' => 'Mayor en metabolizadores lentos CYP2C19'
                ]),
                'source' => 'Micromedex, estudios farmacocinéticos',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // PRECAUCIÓN: Omeprazol → Midazolam (Metabolismo - CYP3A4 leve)
            [
                'medication_1_id' => $midazolamId, // AFECTADO
                'medication_2_id' => $omeprazolId, // CAUSANTE
                'compatibility_type_id' => $compatibleId, // Interacción mínima
                'process_affected' => 'Metabolismo',
                'description' => 'Omeprazol puede inhibir levemente CYP3A4, que metaboliza midazolam. Sin embargo, la magnitud de la interacción es clínicamente poco significativa.',
                'mechanism' => 'Omeprazol tiene efecto inhibitorio débil sobre CYP3A4. Midazolam es sustrato de CYP3A4 y sufre metabolismo de primer paso importante. La inhibición por omeprazol es mínima (<20% aumento de niveles).',
                'clinical_effects' => 'Aumento leve y transitorio de niveles de midazolam. Puede prolongar levemente sedación (minutos adicionales). Efecto clínico generalmente no significativo en dosis habituales.',
                'recommendations' => 'No se requiere ajuste de dosis rutinario. Estar alerta a sedación prolongada en pacientes con factores de riesgo (ancianos, insuficiencia hepática). Monitoreo clínico habitual es suficiente. Interacción de menor relevancia clínica comparada con inhibidores potentes de CYP3A4 (ketoconazol, eritromicina).',
                'evidence_level' => json_encode([
                    'level' => 'B',
                    'description' => 'Moderada evidencia - Interacción de baja relevancia clínica',
                    'magnitude' => 'Aumento <20% en niveles de midazolam'
                ]),
                'source' => 'Micromedex, estudios de interacciones',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // INFORMACIÓN: Fentanyl metabolismo (educativa)
            [
                'medication_1_id' => $fentanylId,
                'medication_2_id' => $fentanylId, // Mismo para referencia
                'compatibility_type_id' => $compatibleId,
                'process_affected' => 'Metabolismo',
                'description' => 'Fentanyl es metabolizado por CYP3A4 principalmente. Esta información es importante para entender interacciones potenciales con inhibidores/inductores de CYP3A4.',
                'mechanism' => 'Fentanyl sufre N-dealquilación por CYP3A4 hepática e intestinal. Los metabolitos son inactivos. Inhibidores potentes de CYP3A4 (ketoconazol, ritonavir, claritromicina, jugo de toronja) pueden aumentar niveles de fentanyl significativamente.',
                'clinical_effects' => 'Con inhibidores de CYP3A4: aumento de niveles de fentanyl (hasta 2-3 veces), prolongación de efectos, mayor riesgo de depresión respiratoria. Con inductores de CYP3A4 (rifampicina, fenitoína, carbamazepina): disminución de niveles, menor efecto analgésico.',
                'recommendations' => 'Evitar inhibidores potentes de CYP3A4 durante uso de fentanyl, o reducir dosis de fentanyl en 25-50%. Evitar jugo de toronja. Con inductores: puede requerir aumento de dosis. Monitoreo clínico de analgesia y efectos adversos. En este seeder no hay medicamentos inhibidores potentes, pero es información relevante para el sistema.',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Conocimiento farmacológico establecido',
                    'note' => 'Información de referencia, no interacción específica con otro medicamento del sistema'
                ]),
                'source' => 'Micromedex, ficha técnica fentanyl, estudios farmacocinéticos',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // BIDIRECCIONAL: Amiodarona ↔ Midazolam (Metabolismo - CYP3A4)
            [
                'medication_1_id' => $midazolamId, // AFECTADO
                'medication_2_id' => $cordaroneId, // CAUSANTE
                'compatibility_type_id' => $precautionId,
                'process_affected' => 'Metabolismo',
                'description' => 'Amiodarona es inhibidor moderado de CYP3A4, enzima que metaboliza midazolam. Aumenta niveles y prolonga efectos del midazolam.',
                'mechanism' => 'Amiodarona inhibe CYP3A4 intestinal y hepática. Midazolam tiene alto metabolismo de primer paso por CYP3A4. La inhibición aumenta biodisponibilidad oral de midazolam (2-3 veces) y reduce su aclaramiento, prolongando vida media.',
                'clinical_effects' => 'Sedación prolongada e intensa. Aumento de 2-4 veces en niveles de midazolam. Depresión respiratoria más pronunciada y duradera. Mayor tiempo de recuperación de sedación. Efecto más marcado con midazolam oral que IV.',
                'recommendations' => 'REDUCIR dosis de midazolam en 50% si el paciente está recibiendo amiodarona crónica. Titular dosis lentamente. Monitoreo prolongado post-sedación. Mayor precaución en ancianos e insuficiencia hepática. Si es sedación única (procedimiento), considerar dosis 50% menor. Alternativa: usar benzodiacepinas no metabolizadas por CYP3A4 (lorazepam, temazepam). El efecto inhibitorio de amiodarona persiste semanas después de suspenderla.',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Alta evidencia',
                    'magnitude' => 'Aumento 2-4 veces en niveles de midazolam',
                    'duration' => 'Efecto prolongado (vida media amiodarona ~58 días)'
                ]),
                'source' => 'Micromedex, Lexicomp, estudios de interacción CYP3A4',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Amiodarona → Fentanyl (similar a midazolam)
            [
                'medication_1_id' => $fentanylId, // AFECTADO
                'medication_2_id' => $cordaroneId, // CAUSANTE
                'compatibility_type_id' => $precautionId,
                'process_affected' => 'Metabolismo',
                'description' => 'Amiodarona inhibe CYP3A4, reduciendo el metabolismo de fentanyl. Puede aumentar niveles de fentanyl y prolongar sus efectos.',
                'mechanism' => 'Amiodarona inhibe CYP3A4 que es la principal vía de metabolismo de fentanyl. Reduce el aclaramiento de fentanyl en 20-40%. Efecto más notable con fentanyl transdérmico (exposición continua) que con dosis IV únicas.',
                'clinical_effects' => 'Aumento de niveles de fentanyl en 20-50%. Analgesia más intensa y prolongada. Mayor riesgo de depresión respiratoria y sedación. Bradicardia más pronunciada (efecto sinérgico con amiodarona). Mayor acumulación con dosis repetidas o infusión continua.',
                'recommendations' => 'Reducir dosis de fentanyl en 20-30% en pacientes con amiodarona crónica. Mayor vigilancia respiratoria (SatO2, FR). Titular dosis cuidadosamente. Naloxona disponible. Particular precaución con fentanyl transdérmico (efecto acumulativo). Monitoreo más prolongado post-procedimiento. Ajustar según respuesta clínica individual.',
                'evidence_level' => json_encode([
                    'level' => 'B',
                    'description' => 'Moderada evidencia',
                    'magnitude' => 'Aumento 20-50% en niveles',
                    'clinical_significance' => 'Moderada a alta según dosis y duración'
                ]),
                'source' => 'Micromedex, estudios farmacocinéticos CYP3A4',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('pharmacokinetic_interactions')->insert($interactions);
    }
}
