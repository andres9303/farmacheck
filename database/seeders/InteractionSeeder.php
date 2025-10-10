<?php

namespace Database\Seeders;

use App\Models\CompatibilityType;
use App\Models\Medication;
use App\Models\PhysicochemicalInteraction;
use App\Models\PharmacodynamicInteraction;
use App\Models\PharmacokineticInteraction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InteractionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the IDs of the related entities
        $compatible = CompatibilityType::where('name', 'Compatible')->first();
        $incompatible = CompatibilityType::where('name', 'Incompatible')->first();
        $precaution = CompatibilityType::where('name', 'Precaución')->first();
        $conditional = CompatibilityType::where('name', 'Condicional')->first();
        
        // Skip if compatibility types don't exist
        if (!$compatible || !$incompatible || !$precaution || !$conditional) {
            return;
        }

        // Get medication IDs
        $medications = Medication::all()->keyBy('commercial_name');
        
        // Skip if no medications exist
        if ($medications->isEmpty()) {
            return;
        }
        
        // Physicochemical Interactions
        $physicochemicalInteractions = [
            [
                'medication_1_id' => $medications['Amoxil']->id,
                'medication_2_id' => $medications['Advil']->id,
                'compatibility_type_id' => $compatible->id,
                'description' => 'No se conocen interacciones fisicoquímicas significativas entre amoxicilina e ibuprofeno.',
                'recommendations' => 'Pueden administrarse juntos sin problemas de compatibilidad.',
                'is_active' => true,
            ],
            [
                'medication_1_id' => $medications['Amoxil']->id,
                'medication_2_id' => $medications['Losec']->id,
                'compatibility_type_id' => $precaution->id,
                'description' => 'El omeprazol puede reducir la absorción de amoxicilina al disminuir la acidez gástrica.',
                'recommendations' => 'Administrar amoxicilina al menos 2 horas antes del omeprazol.',
                'is_active' => true,
            ],
            [
                'medication_1_id' => $medications['Ventolin']->id,
                'medication_2_id' => $medications['Lasix']->id,
                'compatibility_type_id' => $precaution->id,
                'description' => 'El uso concomitante de salbutamol y furosemida puede causar hipopotasemia.',
                'recommendations' => 'Monitorear los niveles de potasio en pacientes que reciben ambos medicamentos.',
                'is_active' => true,
            ],
            [
                'medication_1_id' => $medications['Cipro']->id,
                'medication_2_id' => $medications['Humulin N']->id,
                'compatibility_type_id' => $compatible->id,
                'description' => 'No se conocen interacciones fisicoquímicas entre ciprofloxacino e insulina.',
                'recommendations' => 'Pueden administrarse juntos sin problemas de compatibilidad.',
                'is_active' => true,
            ],
        ];

        foreach ($physicochemicalInteractions as $interaction) {
            PhysicochemicalInteraction::create($interaction);
        }

        // Pharmacodynamic Interactions
        $pharmacodynamicInteractions = [
            [
                'medication_1_id' => $medications['Advil']->id,
                'medication_2_id' => $medications['Coumadin']->id,
                'compatibility_type_id' => $precaution->id,
                'interaction_type' => 'Potenciación',
                'description' => 'El ibuprofeno puede potenciar el efecto anticoagulante de la warfarina.',
                'mechanism' => 'El ibuprofeno desplaza a la warfarina de su unión a proteínas plasmáticas y puede afectar la función plaquetaria.',
                'clinical_effects' => 'Aumenta el riesgo de sangrado.',
                'recommendations' => 'Monitorear el INR y signos de sangrado. Considerar un analgésico alternativo.',
                'is_active' => true,
            ],
            [
                'medication_1_id' => $medications['Renitec']->id,
                'medication_2_id' => $medications['Lasix']->id,
                'compatibility_type_id' => $precaution->id,
                'interaction_type' => 'Sinergia',
                'description' => 'La combinación puede causar una reducción excesiva de la presión arterial.',
                'mechanism' => 'Ambos medicamentos tienen efectos hipotensores que se suman.',
                'clinical_effects' => 'Riesgo de hipotensión arterial y deshidratación.',
                'recommendations' => 'Monitorear la presión arterial y la función renal. Ajustar dosis si es necesario.',
                'is_active' => true,
            ],
            [
                'medication_1_id' => $medications['Tylenol']->id,
                'medication_2_id' => $medications['Glucophage']->id,
                'compatibility_type_id' => $precaution->id,
                'interaction_type' => 'Potenciación',
                'description' => 'El uso conjunto de paracetamol y metformina puede aumentar el riesgo de acidosis láctica.',
                'mechanism' => 'El paracetamol en dosis altas puede afectar la función renal, lo que puede reducir la eliminación de metformina.',
                'clinical_effects' => 'Riesgo de acidosis láctica en pacientes con insuficiencia renal.',
                'recommendations' => 'Evitar dosis altas de paracetamol en pacientes tratados con metformina.',
                'is_active' => true,
            ],
            [
                'medication_1_id' => $medications['Synthroid']->id,
                'medication_2_id' => $medications['Losec']->id,
                'compatibility_type_id' => $precaution->id,
                'interaction_type' => 'Antagonismo',
                'description' => 'El omeprazol puede reducir la absorción de levotiroxina.',
                'mechanism' => 'El omeprazol aumenta el pH gástrico, lo que puede afectar la absorción de levotiroxina.',
                'clinical_effects' => 'Puede reducir la eficacia del tratamiento con levotiroxina.',
                'recommendations' => 'Administrar levotiroxina al menos 4 horas antes del omeprazol.',
                'is_active' => true,
            ],
        ];

        foreach ($pharmacodynamicInteractions as $interaction) {
            PharmacodynamicInteraction::create($interaction);
        }

        // Pharmacokinetic Interactions
        $pharmacokineticInteractions = [
            [
                'medication_1_id' => $medications['Cipro']->id,
                'medication_2_id' => $medications['Coumadin']->id,
                'compatibility_type_id' => $precaution->id,
                'process_affected' => 'Metabolismo',
                'description' => 'El ciprofloxacino puede aumentar el efecto anticoagulante de la warfarina.',
                'mechanism' => 'El ciprofloxacino puede desplazar a la warfarina de su unión a proteínas plasmáticas y puede inhibir el metabolismo de la warfarina a través del citocromo P450.',
                'clinical_effects' => 'Aumenta el riesgo de sangrado.',
                'recommendations' => 'Monitorear el INR frecuentemente al iniciar o suspender el ciprofloxacino. Ajustar dosis de warfarina si es necesario.',
                'is_active' => true,
            ],
            [
                'medication_1_id' => $medications['Losec']->id,
                'medication_2_id' => $medications['Valium']->id,
                'compatibility_type_id' => $precaution->id,
                'process_affected' => 'Metabolismo',
                'description' => 'El omeprazol puede aumentar la concentración plasmática de diazepam.',
                'mechanism' => 'El omeprazol puede inhibir el metabolismo del diazepam a través del citocromo P450.',
                'clinical_effects' => 'Puede aumentar el efecto sedante del diazepam.',
                'recommendations' => 'Considerar una reducción de la dosis de diazepam o un inhibidor de la bomba de protones alternativo.',
                'is_active' => true,
            ],
            [
                'medication_1_id' => $medications['Lipitor']->id,
                'medication_2_id' => $medications['Claritin']->id,
                'compatibility_type_id' => $compatible->id,
                'process_affected' => 'Ninguno',
                'description' => 'No se conocen interacciones farmacocinéticas significativas entre atorvastatina y loratadina.',
                'mechanism' => 'No se conocen efectos significativos en la absorción, distribución, metabolismo o excreción.',
                'clinical_effects' => 'No se esperan efectos clínicos significativos.',
                'recommendations' => 'Pueden administrarse juntos sin ajustes de dosis.',
                'is_active' => true,
            ],
            [
                'medication_1_id' => $medications['Ventolin']->id,
                'medication_2_id' => $medications['Humulin N']->id,
                'compatibility_type_id' => $precaution->id,
                'process_affected' => 'Distribución',
                'description' => 'El salbutamol puede aumentar los efectos de la insulina.',
                'mechanism' => 'El salbutamol puede aumentar la sensibilidad a la insulina.',
                'clinical_effects' => 'Puede causar hipoglucemia.',
                'recommendations' => 'Monitorear los niveles de glucosa en sangre. Ajustar dosis de insulina si es necesario.',
                'is_active' => true,
            ],
        ];

        foreach ($pharmacokineticInteractions as $interaction) {
            PharmacokineticInteraction::create($interaction);
        }
    }
}
