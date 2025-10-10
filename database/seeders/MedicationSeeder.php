<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeder para medicamentos
 * Define los medicamentos comerciales con sus propiedades
 * farmacéuticas y relaciones con principios activos
 */
class MedicationSeeder extends Seeder
{
    /**
     * Ejecuta el seeder para poblar la tabla de medicamentos
     * Crea medicamentos comerciales con sus detalles
     * como presentación, indicaciones y contraindicaciones
     */
    public function run(): void
    {
        // Obtener IDs de referencias de principios activos
        $paracetamolId = DB::table('active_ingredients')->where('name', 'Paracetamol')->value('id');
        $fentanylId = DB::table('active_ingredients')->where('name', 'Fentanyl')->value('id');
        $midazolamId = DB::table('active_ingredients')->where('name', 'Midazolam')->value('id');
        $amiodaronaId = DB::table('active_ingredients')->where('name', 'Amiodarona')->value('id');
        $warfarinaId = DB::table('active_ingredients')->where('name', 'Warfarina')->value('id');
        $furosemidaId = DB::table('active_ingredients')->where('name', 'Furosemida')->value('id');
        $dopaminaId = DB::table('active_ingredients')->where('name', 'Dopamina')->value('id');
        $norepinefrinaId = DB::table('active_ingredients')->where('name', 'Norepinefrina')->value('id');
        $omeprazolId = DB::table('active_ingredients')->where('name', 'Omeprazol')->value('id');
        $morfinaId = DB::table('active_ingredients')->where('name', 'Morfina')->value('id');

        // IDs de vías de administración
        $ivId = DB::table('administration_routes')->where('code', 'IV')->value('id');
        $poId = DB::table('administration_routes')->where('code', 'PO')->value('id');
        $imId = DB::table('administration_routes')->where('code', 'IM')->value('id');
        $scId = DB::table('administration_routes')->where('code', 'SC')->value('id');

        // IDs de unidades de concentración
        $mgId = DB::table('concentration_units')->where('symbol', 'mg')->value('id');
        $gId = DB::table('concentration_units')->where('symbol', 'g')->value('id');
        $mcgId = DB::table('concentration_units')->where('symbol', 'mcg')->value('id');
        $mgMlId = DB::table('concentration_units')->where('symbol', 'mg/ml')->value('id');

        $medications = [
            // Paracetamol
            [
                'commercial_name' => 'Tylenol',
                'generic_name' => 'Paracetamol',
                'active_ingredient_id' => $paracetamolId,
                'concentration_unit_id' => $mgId,
                'concentration' => 500,
                'administration_route_id' => $poId,
                'pharmaceutical_form' => 'Tableta',
                'registration_number' => 'INVIMA2024-001',
                'laboratory' => 'Johnson & Johnson',
                'presentation' => 'Caja x 20 tabletas',
                'indications' => 'Alivio temporal de dolores leves a moderados y reducción de fiebre.',
                'contraindications' => 'Hipersensibilidad al paracetamol. Insuficiencia hepática severa.',
                'warnings' => 'No exceder 4g/día. Riesgo de hepatotoxicidad en dosis altas o uso crónico.',
                'storage_conditions' => json_encode([
                    'temperature' => '15-30°C',
                    'humidity' => 'Lugar seco',
                    'light' => 'Proteger de la luz'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'commercial_name' => 'Perfalgan',
                'generic_name' => 'Paracetamol',
                'active_ingredient_id' => $paracetamolId,
                'concentration_unit_id' => $gId,
                'concentration' => 1,
                'administration_route_id' => $ivId,
                'pharmaceutical_form' => 'Solución inyectable',
                'registration_number' => 'INVIMA2024-002',
                'laboratory' => 'Bristol-Myers Squibb',
                'presentation' => 'Frasco ampolla 100ml (1g/100ml)',
                'indications' => 'Tratamiento del dolor moderado a severo y fiebre cuando vía oral no es posible.',
                'contraindications' => 'Hipersensibilidad. Insuficiencia hepática severa. Deshidratación severa.',
                'warnings' => 'Administrar en infusión mínimo 15 minutos. Monitorear función hepática.',
                'storage_conditions' => json_encode([
                    'temperature' => '2-8°C',
                    'stability' => 'Usar inmediatamente después de abrir',
                    'light' => 'Proteger de la luz'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Fentanyl
            [
                'commercial_name' => 'Fentanilo',
                'generic_name' => 'Fentanyl',
                'active_ingredient_id' => $fentanylId,
                'concentration_unit_id' => $mcgId,
                'concentration' => 50,
                'administration_route_id' => $ivId,
                'pharmaceutical_form' => 'Solución inyectable',
                'registration_number' => 'INVIMA2024-003',
                'laboratory' => 'Janssen',
                'presentation' => 'Ampolla 10ml (50mcg/ml)',
                'indications' => 'Analgesia en procedimientos quirúrgicos, sedación en UCI, manejo de dolor severo.',
                'contraindications' => 'Hipersensibilidad. Depresión respiratoria. Asma severa no controlada.',
                'warnings' => 'Opioide potente. Riesgo de depresión respiratoria. Tener naloxona disponible. Monitoreo continuo.',
                'storage_conditions' => json_encode([
                    'temperature' => '15-30°C',
                    'controlled' => 'Sustancia controlada - Lista II',
                    'security' => 'Almacenar en lugar seguro'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Midazolam
            [
                'commercial_name' => 'Dormicum',
                'generic_name' => 'Midazolam',
                'active_ingredient_id' => $midazolamId,
                'concentration_unit_id' => $mgMlId,
                'concentration' => 5,
                'administration_route_id' => $ivId,
                'pharmaceutical_form' => 'Solución inyectable',
                'registration_number' => 'INVIMA2024-004',
                'laboratory' => 'Roche',
                'presentation' => 'Ampolla 3ml (5mg/ml)',
                'indications' => 'Sedación consciente, inducción anestésica, sedación en UCI, status epilepticus.',
                'contraindications' => 'Hipersensibilidad. Glaucoma de ángulo cerrado. Miastenia gravis.',
                'warnings' => 'Depresión respiratoria. Tener flumazenil disponible. Reducir dosis en ancianos y hepatopatía.',
                'storage_conditions' => json_encode([
                    'temperature' => '15-30°C',
                    'light' => 'Proteger de la luz',
                    'controlled' => 'Sustancia controlada'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Amiodarona
            [
                'commercial_name' => 'Cordarone',
                'generic_name' => 'Amiodarona',
                'active_ingredient_id' => $amiodaronaId,
                'concentration_unit_id' => $mgId,
                'concentration' => 200,
                'administration_route_id' => $poId,
                'pharmaceutical_form' => 'Tableta',
                'registration_number' => 'INVIMA2024-005',
                'laboratory' => 'Sanofi',
                'presentation' => 'Caja x 20 tabletas',
                'indications' => 'Arritmias ventriculares y supraventriculares. Fibrilación auricular.',
                'contraindications' => 'Bradicardia severa. Bloqueo AV. Disfunción tiroidea. Hipersensibilidad al yodo.',
                'warnings' => 'Múltiples interacciones medicamentosas. Monitoreo ECG, función tiroidea y hepática. Fotosensibilidad.',
                'storage_conditions' => json_encode([
                    'temperature' => '15-25°C',
                    'light' => 'Proteger de la luz',
                    'humidity' => 'Lugar seco'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'commercial_name' => 'Cordarone IV',
                'generic_name' => 'Amiodarona',
                'active_ingredient_id' => $amiodaronaId,
                'concentration_unit_id' => $mgId,
                'concentration' => 150,
                'administration_route_id' => $ivId,
                'pharmaceutical_form' => 'Solución inyectable',
                'registration_number' => 'INVIMA2024-006',
                'laboratory' => 'Sanofi',
                'presentation' => 'Ampolla 3ml (50mg/ml)',
                'indications' => 'Arritmias ventriculares graves. Paro cardíaco. Fibrilación/flutter auricular con compromiso hemodinámico.',
                'contraindications' => 'Bradicardia sinusal. Bloqueo AV. Shock cardiogénico. Hipotensión severa.',
                'warnings' => 'Administrar en vía central si es posible. Monitoreo continuo ECG y presión arterial. Riesgo de hipotensión.',
                'storage_conditions' => json_encode([
                    'temperature' => '15-25°C',
                    'light' => 'Proteger de la luz - usar bolsa protectora',
                    'dilution' => 'Diluir en DAD 5%'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Warfarina
            [
                'commercial_name' => 'Coumadin',
                'generic_name' => 'Warfarina',
                'active_ingredient_id' => $warfarinaId,
                'concentration_unit_id' => $mgId,
                'concentration' => 5,
                'administration_route_id' => $poId,
                'pharmaceutical_form' => 'Tableta',
                'registration_number' => 'INVIMA2024-007',
                'laboratory' => 'Bristol-Myers Squibb',
                'presentation' => 'Caja x 30 tabletas',
                'indications' => 'Prevención y tratamiento de trombosis venosa, embolia pulmonar, fibrilación auricular, válvulas cardíacas protésicas.',
                'contraindications' => 'Hemorragia activa. Embarazo. Cirugía reciente del SNC. Hipertensión no controlada severa.',
                'warnings' => 'Monitoreo frecuente de INR. Múltiples interacciones medicamentosas y con alimentos. Riesgo de hemorragia.',
                'storage_conditions' => json_encode([
                    'temperature' => '15-30°C',
                    'light' => 'Proteger de la luz y humedad',
                    'humidity' => 'Mantener en envase original'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Furosemida
            [
                'commercial_name' => 'Lasix',
                'generic_name' => 'Furosemida',
                'active_ingredient_id' => $furosemidaId,
                'concentration_unit_id' => $mgMlId,
                'concentration' => 10,
                'administration_route_id' => $ivId,
                'pharmaceutical_form' => 'Solución inyectable',
                'registration_number' => 'INVIMA2024-008',
                'laboratory' => 'Sanofi-Aventis',
                'presentation' => 'Ampolla 2ml (10mg/ml)',
                'indications' => 'Edema pulmonar agudo, insuficiencia cardíaca congestiva, edema por insuficiencia renal, hipertensión.',
                'contraindications' => 'Anuria. Insuficiencia renal con anuria. Coma hepático. Depleción severa de electrolitos.',
                'warnings' => 'Monitoreo de electrolitos, función renal y presión arterial. Riesgo de hipotensión y depleción de volumen.',
                'storage_conditions' => json_encode([
                    'temperature' => '15-30°C',
                    'light' => 'Proteger de la luz',
                    'stability' => 'No mezclar con soluciones ácidas'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Dopamina
            [
                'commercial_name' => 'Dopamina',
                'generic_name' => 'Dopamina',
                'active_ingredient_id' => $dopaminaId,
                'concentration_unit_id' => $mgMlId,
                'concentration' => 40,
                'administration_route_id' => $ivId,
                'pharmaceutical_form' => 'Solución inyectable concentrada',
                'registration_number' => 'INVIMA2024-009',
                'laboratory' => 'Baxter',
                'presentation' => 'Ampolla 5ml (40mg/ml = 200mg/5ml)',
                'indications' => 'Shock cardiogénico, shock séptico, insuficiencia cardíaca aguda, hipotensión severa.',
                'contraindications' => 'Feocromocitoma. Taquiarritmias ventriculares. Hipersensibilidad a sulfitos.',
                'warnings' => 'Administrar en bomba de infusión. Monitoreo continuo hemodinámico. Riesgo de extravasación (necrosis tisular).',
                'storage_conditions' => json_encode([
                    'temperature' => '15-30°C',
                    'light' => 'Proteger de la luz - solución sensible',
                    'dilution' => 'Diluir antes de administrar en SF o DAD 5%',
                    'compatibility' => 'No mezclar con soluciones alcalinas'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Norepinefrina
            [
                'commercial_name' => 'Levophed',
                'generic_name' => 'Norepinefrina',
                'active_ingredient_id' => $norepinefrinaId,
                'concentration_unit_id' => $mgMlId,
                'concentration' => 1,
                'administration_route_id' => $ivId,
                'pharmaceutical_form' => 'Solución inyectable concentrada',
                'registration_number' => 'INVIMA2024-010',
                'laboratory' => 'Hospira',
                'presentation' => 'Ampolla 4ml (1mg/ml = 4mg/4ml)',
                'indications' => 'Shock séptico, shock cardiogénico, hipotensión severa refractaria a volumen.',
                'contraindications' => 'Hipotensión por hipovolemia no corregida. Trombosis mesentérica o vascular periférica.',
                'warnings' => 'Vasopresor potente. Administrar en vía central si es posible. Monitoreo continuo PA y perfusión tisular.',
                'storage_conditions' => json_encode([
                    'temperature' => '15-30°C',
                    'light' => 'Proteger de la luz - usar bolsa opaca',
                    'dilution' => 'Diluir en DAD 5% (preferentemente)',
                    'stability' => 'No mezclar con soluciones alcalinas'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Omeprazol
            [
                'commercial_name' => 'Prilosec',
                'generic_name' => 'Omeprazol',
                'active_ingredient_id' => $omeprazolId,
                'concentration_unit_id' => $mgId,
                'concentration' => 20,
                'administration_route_id' => $poId,
                'pharmaceutical_form' => 'Cápsula',
                'registration_number' => 'INVIMA2024-011',
                'laboratory' => 'AstraZeneca',
                'presentation' => 'Caja x 14 cápsulas',
                'indications' => 'Úlcera péptica, ERGE, síndrome de Zollinger-Ellison, prevención de úlceras por AINEs.',
                'contraindications' => 'Hipersensibilidad al omeprazol o benzimidazoles.',
                'warnings' => 'Administrar antes de las comidas. Uso prolongado puede causar deficiencia de B12 y magnesio.',
                'storage_conditions' => json_encode([
                    'temperature' => '15-30°C',
                    'humidity' => 'Lugar seco',
                    'light' => 'Proteger de la luz y humedad'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'commercial_name' => 'Omeprazol IV',
                'generic_name' => 'Omeprazol',
                'active_ingredient_id' => $omeprazolId,
                'concentration_unit_id' => $mgId,
                'concentration' => 40,
                'administration_route_id' => $ivId,
                'pharmaceutical_form' => 'Polvo liofilizado para solución inyectable',
                'registration_number' => 'INVIMA2024-012',
                'laboratory' => 'AstraZeneca',
                'presentation' => 'Frasco ampolla 40mg',
                'indications' => 'Hemorragia digestiva alta, prevención de úlceras por estrés en UCI, cuando vía oral no es posible.',
                'contraindications' => 'Hipersensibilidad al omeprazol.',
                'warnings' => 'Reconstituir con SF. Administrar en 20-30 minutos. pH alcalino - incompatible con soluciones ácidas.',
                'storage_conditions' => json_encode([
                    'temperature' => '15-25°C',
                    'reconstitution' => 'Usar inmediatamente después de reconstituir',
                    'light' => 'Proteger de la luz'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Morfina
            [
                'commercial_name' => 'Morfina Sulfato',
                'generic_name' => 'Morfina',
                'active_ingredient_id' => $morfinaId,
                'concentration_unit_id' => $mgMlId,
                'concentration' => 10,
                'administration_route_id' => $ivId,
                'pharmaceutical_form' => 'Solución inyectable',
                'registration_number' => 'INVIMA2024-013',
                'laboratory' => 'Sandoz',
                'presentation' => 'Ampolla 1ml (10mg/ml)',
                'indications' => 'Dolor severo agudo y crónico, infarto agudo de miocardio, edema pulmonar agudo, analgesia postoperatoria.',
                'contraindications' => 'Depresión respiratoria severa. Asma aguda. Íleo paralítico. Traumatismo craneoencefálico.',
                'warnings' => 'Opioide potente. Riesgo de adicción. Depresión respiratoria. Tener naloxona disponible. Monitoreo continuo.',
                'storage_conditions' => json_encode([
                    'temperature' => '15-30°C',
                    'controlled' => 'Sustancia controlada - Lista II',
                    'security' => 'Almacenamiento en lugar seguro con registro',
                    'light' => 'Proteger de la luz'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('medications')->insert($medications);
    }
}