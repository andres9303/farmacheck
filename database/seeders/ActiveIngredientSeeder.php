<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeder para principios activos de medicamentos
 * Define los componentes farmacológicamente activos
 * de los medicamentos utilizados en el sistema
 */
class ActiveIngredientSeeder extends Seeder
{
    /**
     * Ejecuta el seeder para poblar la tabla de principios activos
     * Crea los principios activos comunes con sus propiedades farmacológicas
     */
    public function run(): void
    {
        $ingredients = [
            [
                'name' => 'Paracetamol',
                'description' => 'Analgésico y antipirético. Inhibe la síntesis de prostaglandinas en el sistema nervioso central.',
                'atc_code' => 'N02BE01',
                'molecular_formula' => 'C8H9NO2',
                'molecular_weight' => 151.1626,
                'therapeutic_actions' => json_encode([
                    'Analgésico',
                    'Antipirético',
                    'Anti-inflamatorio débil'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fentanyl',
                'description' => 'Opioide sintético potente. Agonista de receptores mu-opioides. Aproximadamente 100 veces más potente que la morfina.',
                'atc_code' => 'N01AH01',
                'molecular_formula' => 'C22H28N2O',
                'molecular_weight' => 336.4710,
                'therapeutic_actions' => json_encode([
                    'Analgésico opioide',
                    'Anestésico',
                    'Sedante'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Midazolam',
                'description' => 'Benzodiacepina de acción corta. Potencia la acción del GABA. Propiedades sedantes, ansiolíticas y amnésicas.',
                'atc_code' => 'N05CD08',
                'molecular_formula' => 'C18H13ClFN3',
                'molecular_weight' => 325.7670,
                'therapeutic_actions' => json_encode([
                    'Sedante',
                    'Ansiolítico',
                    'Hipnótico',
                    'Anticonvulsivante',
                    'Relajante muscular'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Amiodarona',
                'description' => 'Antiarrítmico clase III. Prolonga el potencial de acción y el período refractario. Bloquea canales de potasio.',
                'atc_code' => 'C01BD01',
                'molecular_formula' => 'C25H29I2NO3',
                'molecular_weight' => 645.3116,
                'therapeutic_actions' => json_encode([
                    'Antiarrítmico',
                    'Bloqueador de canales de potasio',
                    'Anti-anginoso'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Warfarina',
                'description' => 'Anticoagulante oral. Inhibe la síntesis de factores de coagulación dependientes de vitamina K (II, VII, IX, X).',
                'atc_code' => 'B01AA03',
                'molecular_formula' => 'C19H16O4',
                'molecular_weight' => 308.3280,
                'therapeutic_actions' => json_encode([
                    'Anticoagulante',
                    'Inhibidor de vitamina K'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Furosemida',
                'description' => 'Diurético de asa. Inhibe la reabsorción de sodio y cloro en el asa ascendente de Henle.',
                'atc_code' => 'C03CA01',
                'molecular_formula' => 'C12H11ClN2O5S',
                'molecular_weight' => 330.7450,
                'therapeutic_actions' => json_encode([
                    'Diurético',
                    'Antihipertensivo',
                    'Tratamiento de edema'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dopamina',
                'description' => 'Catecolamina endógena. Agonista de receptores dopaminérgicos, beta y alfa adrenérgicos según dosis.',
                'atc_code' => 'C01CA04',
                'molecular_formula' => 'C8H11NO2',
                'molecular_weight' => 153.1784,
                'therapeutic_actions' => json_encode([
                    'Vasopresor',
                    'Inotrópico positivo',
                    'Agonista dopaminérgico'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Norepinefrina',
                'description' => 'Catecolamina potente. Agonista alfa y beta adrenérgico. Vasopresor de elección en shock séptico.',
                'atc_code' => 'C01CA03',
                'molecular_formula' => 'C8H11NO3',
                'molecular_weight' => 169.1778,
                'therapeutic_actions' => json_encode([
                    'Vasopresor',
                    'Inotrópico',
                    'Agonista adrenérgico'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Omeprazol',
                'description' => 'Inhibidor de la bomba de protones (IBP). Suprime la secreción ácida gástrica inhibiendo H+/K+ ATPasa.',
                'atc_code' => 'A02BC01',
                'molecular_formula' => 'C17H19N3O3S',
                'molecular_weight' => 345.4160,
                'therapeutic_actions' => json_encode([
                    'Antiulceroso',
                    'Inhibidor de bomba de protones',
                    'Supresor de ácido gástrico'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Morfina',
                'description' => 'Opioide natural. Agonista de receptores mu-opioides. Analgésico potente estándar de referencia.',
                'atc_code' => 'N02AA01',
                'molecular_formula' => 'C17H19NO3',
                'molecular_weight' => 285.3377,
                'therapeutic_actions' => json_encode([
                    'Analgésico opioide',
                    'Sedante',
                    'Antitusígeno'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('active_ingredients')->insert($ingredients);
    }
}
