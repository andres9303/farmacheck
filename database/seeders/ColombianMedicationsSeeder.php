<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColombianMedicationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener IDs de referencia necesarios
        $this->seedActiveIngredients();
        $this->seedMedications();
        $this->seedAllInteractions();
    }

    private function seedActiveIngredients()
    {
        $ingredients = [
            // ANALGÉSICOS Y OPIOIDES
            [
                'name' => 'Tramadol',
                'description' => 'Analgésico opioide débil. Agonista de receptores mu-opioides y además inhibe recaptación de serotonina y noradrenalina.',
                'atc_code' => 'N02AX02',
                'molecular_formula' => 'C16H25NO2',
                'molecular_weight' => 263.3750,
                'therapeutic_actions' => json_encode([
                    'Analgésico opioide débil',
                    'Inhibidor de recaptación de monoaminas',
                    'Analgésico central'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dipirona (Metamizol)',
                'description' => 'Analgésico, antipirético y espasmolítico. Derivado de pirazolona. Muy usado en Colombia y América Latina.',
                'atc_code' => 'N02BB02',
                'molecular_formula' => 'C13H16N3NaO4S',
                'molecular_weight' => 333.3380,
                'therapeutic_actions' => json_encode([
                    'Analgésico no opioide',
                    'Antipirético potente',
                    'Espasmolítico'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ketorolaco',
                'description' => 'AINE no selectivo. Potente efecto analgésico, superior a otros AINEs. Ampliamente usado en dolor postoperatorio en Colombia.',
                'atc_code' => 'M01AB15',
                'molecular_formula' => 'C15H13NO3',
                'molecular_weight' => 255.2680,
                'therapeutic_actions' => json_encode([
                    'AINE',
                    'Analgésico',
                    'Anti-inflamatorio',
                    'Antipirético'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ANTIBIÓTICOS
            [
                'name' => 'Gentamicina',
                'description' => 'Aminoglucósido bactericida. Inhibe síntesis proteica bacteriana. Uso común en infecciones graves en Colombia.',
                'atc_code' => 'J01GB03',
                'molecular_formula' => 'C21H43N5O7',
                'molecular_weight' => 477.5960,
                'therapeutic_actions' => json_encode([
                    'Antibiótico aminoglucósido',
                    'Bactericida',
                    'Gram negativos'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vancomicina',
                'description' => 'Antibiótico glucopéptido. Bactericida contra Gram positivos. Tratamiento de MRSA. Amplio uso hospitalario en Colombia.',
                'atc_code' => 'J01XA01',
                'molecular_formula' => 'C66H75Cl2N9O24',
                'molecular_weight' => 1449.2540,
                'therapeutic_actions' => json_encode([
                    'Antibiótico glucopéptido',
                    'Anti-MRSA',
                    'Gram positivos'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ceftriaxona',
                'description' => 'Cefalosporina de tercera generación. Amplio espectro. Uno de los antibióticos más usados en Colombia.',
                'atc_code' => 'J01DD04',
                'molecular_formula' => 'C18H18N8O7S3',
                'molecular_weight' => 554.5800,
                'therapeutic_actions' => json_encode([
                    'Antibiótico cefalosporina',
                    'Amplio espectro',
                    'Bactericida'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // SEDANTES Y ANTICONVULSIVANTES
            [
                'name' => 'Diazepam',
                'description' => 'Benzodiacepina de acción prolongada. Ansiolítico, sedante, anticonvulsivante. Muy accesible en Colombia.',
                'atc_code' => 'N05BA01',
                'molecular_formula' => 'C16H13ClN2O',
                'molecular_weight' => 284.7400,
                'therapeutic_actions' => json_encode([
                    'Benzodiacepina',
                    'Ansiolítico',
                    'Sedante',
                    'Anticonvulsivante',
                    'Relajante muscular'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fenitoína',
                'description' => 'Anticonvulsivante clásico. Estabilizador de membrana neuronal. Amplio uso en epilepsia y convulsiones en Colombia.',
                'atc_code' => 'N03AB02',
                'molecular_formula' => 'C15H12N2O2',
                'molecular_weight' => 252.2680,
                'therapeutic_actions' => json_encode([
                    'Anticonvulsivante',
                    'Antiarrítmico clase IB',
                    'Estabilizador de membrana'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // CARDIOVASCULARES
            [
                'name' => 'Enalapril',
                'description' => 'Inhibidor de la ECA (IECA). Antihipertensivo ampliamente prescrito en Colombia. Primera línea en HTA e ICC.',
                'atc_code' => 'C09AA02',
                'molecular_formula' => 'C20H28N2O5',
                'molecular_weight' => 376.4470,
                'therapeutic_actions' => json_encode([
                    'IECA',
                    'Antihipertensivo',
                    'Insuficiencia cardíaca',
                    'Nefroprotector'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Atorvastatina',
                'description' => 'Estatina inhibidora de HMG-CoA reductasa. Hipolipemiante muy prescrito en Colombia.',
                'atc_code' => 'C10AA05',
                'molecular_formula' => 'C33H35FN2O5',
                'molecular_weight' => 558.6440,
                'therapeutic_actions' => json_encode([
                    'Estatina',
                    'Hipolipemiante',
                    'Prevención cardiovascular'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Digoxina',
                'description' => 'Glucósido cardíaco. Inotrópico positivo. Uso en fibrilación auricular e insuficiencia cardíaca.',
                'atc_code' => 'C01AA05',
                'molecular_formula' => 'C41H64O14',
                'molecular_weight' => 780.9390,
                'therapeutic_actions' => json_encode([
                    'Glucósido cardíaco',
                    'Inotrópico positivo',
                    'Antiarrítmico'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // DIURÉTICOS Y ELECTROLITOS
            [
                'name' => 'Espironolactona',
                'description' => 'Diurético ahorrador de potasio. Antagonista de aldosterona. Uso en ICC e HTA en Colombia.',
                'atc_code' => 'C03DA01',
                'molecular_formula' => 'C24H32O4S',
                'molecular_weight' => 416.5730,
                'therapeutic_actions' => json_encode([
                    'Diurético ahorrador de potasio',
                    'Antagonista de aldosterona',
                    'Antihipertensivo'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // GASTROINTESTINALES
            [
                'name' => 'Ranitidina',
                'description' => 'Antagonista de receptores H2. Antiulceroso. Alternativa a omeprazol en Colombia, aunque en desuso por contaminación.',
                'atc_code' => 'A02BA02',
                'molecular_formula' => 'C13H22N4O3S',
                'molecular_weight' => 314.4040,
                'therapeutic_actions' => json_encode([
                    'Antagonista H2',
                    'Antiulceroso',
                    'Supresor de ácido gástrico'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Metoclopramida',
                'description' => 'Procinético y antiemético. Antagonista dopaminérgico. Muy usado en Colombia para náusea y gastroparesia.',
                'atc_code' => 'A03FA01',
                'molecular_formula' => 'C14H22ClN3O2',
                'molecular_weight' => 299.7960,
                'therapeutic_actions' => json_encode([
                    'Procinético',
                    'Antiemético',
                    'Antagonista dopaminérgico'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ANTICOAGULANTES Y ANTIAGREGANTES
            [
                'name' => 'Heparina',
                'description' => 'Anticoagulante. Potencia antitrombina III. Uso hospitalario amplio en Colombia para TVP, EP, SCA.',
                'atc_code' => 'B01AB01',
                'molecular_formula' => 'Variable',
                'molecular_weight' => 12000.0000,
                'therapeutic_actions' => json_encode([
                    'Anticoagulante',
                    'Prevención de trombosis',
                    'Tratamiento de TVP/EP'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ácido Acetilsalicílico (ASA)',
                'description' => 'AINE, antiagregante plaquetario. Aspirina. Ampliamente usado en prevención cardiovascular en Colombia.',
                'atc_code' => 'B01AC06',
                'molecular_formula' => 'C9H8O4',
                'molecular_weight' => 180.1574,
                'therapeutic_actions' => json_encode([
                    'Antiagregante plaquetario',
                    'AINE',
                    'Analgésico',
                    'Antipirético'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // CORTICOIDES
            [
                'name' => 'Dexametasona',
                'description' => 'Corticoide de alta potencia y larga duración. Amplio uso en inflamación, shock, edema cerebral en Colombia.',
                'atc_code' => 'H02AB02',
                'molecular_formula' => 'C22H29FO5',
                'molecular_weight' => 392.4610,
                'therapeutic_actions' => json_encode([
                    'Corticoide',
                    'Anti-inflamatorio',
                    'Inmunosupresor'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hidrocortisona',
                'description' => 'Corticoide natural. Uso en insuficiencia suprarrenal, shock, reacciones alérgicas en Colombia.',
                'atc_code' => 'H02AB09',
                'molecular_formula' => 'C21H30O5',
                'molecular_weight' => 362.4600,
                'therapeutic_actions' => json_encode([
                    'Corticoide',
                    'Anti-inflamatorio',
                    'Reemplazo hormonal'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // INSULINA Y ANTIDIABÉTICOS
            [
                'name' => 'Insulina NPH',
                'description' => 'Insulina de acción intermedia. Ampliamente usada en diabetes en Colombia por accesibilidad.',
                'atc_code' => 'A10AC01',
                'molecular_formula' => 'C257H383N65O77S6',
                'molecular_weight' => 5808.0000,
                'therapeutic_actions' => json_encode([
                    'Insulina acción intermedia',
                    'Hipoglucemiante',
                    'Control de diabetes'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Metformina',
                'description' => 'Biguanida. Primera línea en diabetes tipo 2 en Colombia. Reduce producción hepática de glucosa.',
                'atc_code' => 'A10BA02',
                'molecular_formula' => 'C4H11N5',
                'molecular_weight' => 129.1636,
                'therapeutic_actions' => json_encode([
                    'Antidiabético oral',
                    'Biguanida',
                    'Sensibilizador de insulina'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('active_ingredients')->insert($ingredients);
    }

    private function seedMedications()
    {
        // Obtener IDs
        $tramadolId = DB::table('active_ingredients')->where('name', 'Tramadol')->value('id');
        $dipironaId = DB::table('active_ingredients')->where('name', 'Dipirona (Metamizol)')->value('id');
        $ketorolacoId = DB::table('active_ingredients')->where('name', 'Ketorolaco')->value('id');
        $gentamicinaId = DB::table('active_ingredients')->where('name', 'Gentamicina')->value('id');
        $vancomicinaId = DB::table('active_ingredients')->where('name', 'Vancomicina')->value('id');
        $ceftriaxonaId = DB::table('active_ingredients')->where('name', 'Ceftriaxona')->value('id');
        $diazepamId = DB::table('active_ingredients')->where('name', 'Diazepam')->value('id');
        $fenitoinaId = DB::table('active_ingredients')->where('name', 'Fenitoína')->value('id');
        $enalaprilId = DB::table('active_ingredients')->where('name', 'Enalapril')->value('id');
        $atorvastatinaId = DB::table('active_ingredients')->where('name', 'Atorvastatina')->value('id');
        $digoxinaId = DB::table('active_ingredients')->where('name', 'Digoxina')->value('id');
        $espironolactonaId = DB::table('active_ingredients')->where('name', 'Espironolactona')->value('id');
        $rantidinaId = DB::table('active_ingredients')->where('name', 'Ranitidina')->value('id');
        $metoclopramidaId = DB::table('active_ingredients')->where('name', 'Metoclopramida')->value('id');
        $heparinaId = DB::table('active_ingredients')->where('name', 'Heparina')->value('id');
        $asaId = DB::table('active_ingredients')->where('name', 'Ácido Acetilsalicílico (ASA)')->value('id');
        $dexametasonaId = DB::table('active_ingredients')->where('name', 'Dexametasona')->value('id');
        $hidrocortisonaId = DB::table('active_ingredients')->where('name', 'Hidrocortisona')->value('id');
        $insulinaNPHId = DB::table('active_ingredients')->where('name', 'Insulina NPH')->value('id');
        $metforminaId = DB::table('active_ingredients')->where('name', 'Metformina')->value('id');

        // IDs de vías
        $ivId = DB::table('administration_routes')->where('code', 'IV')->value('id');
        $imId = DB::table('administration_routes')->where('code', 'IM')->value('id');
        $scId = DB::table('administration_routes')->where('code', 'SC')->value('id');
        $poId = DB::table('administration_routes')->where('code', 'PO')->value('id');

        // IDs de unidades
        $mgId = DB::table('concentration_units')->where('symbol', 'mg')->value('id');
        $gId = DB::table('concentration_units')->where('symbol', 'g')->value('id');
        $mgMlId = DB::table('concentration_units')->where('symbol', 'mg/ml')->value('id');
        $uiId = DB::table('concentration_units')->where('symbol', 'UI')->value('id');

        $medications = [
            // TRAMADOL
            [
                'commercial_name' => 'Tramal',
                'generic_name' => 'Tramadol',
                'active_ingredient_id' => $tramadolId,
                'concentration_unit_id' => $mgId,
                'concentration' => 50,
                'administration_route_id' => $poId,
                'pharmaceutical_form' => 'Cápsula',
                'registration_number' => 'INVIMA-COL-001',
                'laboratory' => 'Grünenthal Colombiana',
                'presentation' => 'Caja x 20 cápsulas',
                'indications' => 'Dolor moderado a severo',
                'contraindications' => 'Hipersensibilidad, intoxicación aguda con alcohol, opioides o psicofármacos',
                'warnings' => 'Riesgo de convulsiones. Síndrome serotoninérgico con ISRS. Dependencia',
                'storage_conditions' => json_encode(['temperature' => '15-30°C', 'controlled' => 'true']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'commercial_name' => 'Tramadol Genfar',
                'generic_name' => 'Tramadol',
                'active_ingredient_id' => $tramadolId,
                'concentration_unit_id' => $mgMlId,
                'concentration' => 50,
                'administration_route_id' => $ivId,
                'pharmaceutical_form' => 'Solución inyectable',
                'registration_number' => 'INVIMA-COL-002',
                'laboratory' => 'Genfar',
                'presentation' => 'Ampolla 1ml (50mg/ml)',
                'indications' => 'Dolor moderado a severo',
                'contraindications' => 'Hipersensibilidad, depresión respiratoria',
                'warnings' => 'Riesgo de síndrome serotoninérgico. Ajustar en IR y IH',
                'storage_conditions' => json_encode(['temperature' => '15-30°C']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // DIPIRONA (METAMIZOL)
            [
                'commercial_name' => 'Novalgina',
                'generic_name' => 'Dipirona',
                'active_ingredient_id' => $dipironaId,
                'concentration_unit_id' => $mgId,
                'concentration' => 500,
                'administration_route_id' => $poId,
                'pharmaceutical_form' => 'Tableta',
                'registration_number' => 'INVIMA-COL-003',
                'laboratory' => 'Sanofi',
                'presentation' => 'Caja x 10 tabletas',
                'indications' => 'Dolor, fiebre',
                'contraindications' => 'Hipersensibilidad, porfiria, deficiencia G6PD',
                'warnings' => 'Riesgo de agranulocitosis (raro). Hipotensión con IV',
                'storage_conditions' => json_encode(['temperature' => '15-30°C']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'commercial_name' => 'Dipirona Vitalis',
                'generic_name' => 'Dipirona',
                'active_ingredient_id' => $dipironaId,
                'concentration_unit_id' => $gId,
                'concentration' => 2,
                'administration_route_id' => $ivId,
                'pharmaceutical_form' => 'Solución inyectable',
                'registration_number' => 'INVIMA-COL-004',
                'laboratory' => 'Vitalis',
                'presentation' => 'Ampolla 5ml (2g/5ml)',
                'indications' => 'Dolor, fiebre, espasmo',
                'contraindications' => 'Hipersensibilidad, porfiria',
                'warnings' => 'Administrar lentamente (>5 min) para evitar hipotensión severa',
                'storage_conditions' => json_encode(['temperature' => '15-25°C', 'light' => 'Proteger']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // KETOROLACO
            [
                'commercial_name' => 'Dolac',
                'generic_name' => 'Ketorolaco',
                'active_ingredient_id' => $ketorolacoId,
                'concentration_unit_id' => $mgId,
                'concentration' => 10,
                'administration_route_id' => $poId,
                'pharmaceutical_form' => 'Tableta',
                'registration_number' => 'INVIMA-COL-005',
                'laboratory' => 'Roche Colombia',
                'presentation' => 'Caja x 10 tabletas',
                'indications' => 'Dolor moderado a severo postoperatorio',
                'contraindications' => 'Úlcera péptica activa, sangrado activo, IR severa, embarazo',
                'warnings' => 'Riesgo de sangrado GI. Máximo 5 días de uso. Evitar en >65 años',
                'storage_conditions' => json_encode(['temperature' => '15-30°C']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'commercial_name' => 'Ketorolaco Lafrancol',
                'generic_name' => 'Ketorolaco',
                'active_ingredient_id' => $ketorolacoId,
                'concentration_unit_id' => $mgMlId,
                'concentration' => 30,
                'administration_route_id' => $ivId,
                'pharmaceutical_form' => 'Solución inyectable',
                'registration_number' => 'INVIMA-COL-006',
                'laboratory' => 'Lafrancol',
                'presentation' => 'Ampolla 1ml (30mg/ml)',
                'indications' => 'Dolor moderado a severo',
                'contraindications' => 'Sangrado activo, IR severa, hipovolemia',
                'warnings' => 'Alto riesgo de sangrado. Evitar con anticoagulantes. Máximo 2 días IV',
                'storage_conditions' => json_encode(['temperature' => '15-30°C', 'light' => 'Proteger']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // GENTAMICINA
            [
                'commercial_name' => 'Garamicina',
                'generic_name' => 'Gentamicina',
                'active_ingredient_id' => $gentamicinaId,
                'concentration_unit_id' => $mgMlId,
                'concentration' => 80,
                'administration_route_id' => $ivId,
                'pharmaceutical_form' => 'Solución inyectable',
                'registration_number' => 'INVIMA-COL-007',
                'laboratory' => 'Schering-Plough',
                'presentation' => 'Ampolla 2ml (80mg/2ml)',
                'indications' => 'Infecciones por Gram negativos',
                'contraindications' => 'Hipersensibilidad a aminoglucósidos',
                'warnings' => 'Nefrotóxico y ototóxico. Monitoreo de niveles séricos. Ajustar en IR',
                'storage_conditions' => json_encode(['temperature' => '2-8°C', 'light' => 'Proteger']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // VANCOMICINA
            [
                'commercial_name' => 'Vancocin',
                'generic_name' => 'Vancomicina',
                'active_ingredient_id' => $vancomicinaId,
                'concentration_unit_id' => $mgId,
                'concentration' => 500,
                'administration_route_id' => $ivId,
                'pharmaceutical_form' => 'Polvo liofilizado para solución inyectable',
                'registration_number' => 'INVIMA-COL-008',
                'laboratory' => 'Lilly',
                'presentation' => 'Frasco ampolla 500mg',
                'indications' => 'Infecciones por MRSA, Gram positivos',
                'contraindications' => 'Hipersensibilidad',
                'warnings' => 'Síndrome del hombre rojo. Nefrotóxico. Ototóxico. Monitoreo de niveles',
                'storage_conditions' => json_encode(['temperature' => '15-30°C', 'infusion' => 'Mínimo 60 min']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // CEFTRIAXONA
            [
                'commercial_name' => 'Rocephin',
                'generic_name' => 'Ceftriaxona',
                'active_ingredient_id' => $ceftriaxonaId,
                'concentration_unit_id' => $gId,
                'concentration' => 1,
                'administration_route_id' => $ivId,
                'pharmaceutical_form' => 'Polvo liofilizado para solución inyectable',
                'registration_number' => 'INVIMA-COL-009',
                'laboratory' => 'Roche',
                'presentation' => 'Frasco ampolla 1g',
                'indications' => 'Infecciones bacterianas, meningitis, gonorrea',
                'contraindications' => 'Hipersensibilidad a cefalosporinas. Neonatos con hiperbilirrubinemia',
                'warnings' => 'NO mezclar con calcio. Riesgo de precipitación en vesícula',
                'storage_conditions' => json_encode(['temperature' => '15-25°C', 'calcium' => 'NO MEZCLAR']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // DIAZEPAM
            [
                'commercial_name' => 'Valium',
                'generic_name' => 'Diazepam',
                'active_ingredient_id' => $diazepamId,
                'concentration_unit_id' => $mgId,
                'concentration' => 10,
                'administration_route_id' => $poId,
                'pharmaceutical_form' => 'Tableta',
                'registration_number' => 'INVIMA-COL-010',
                'laboratory' => 'Roche',
                'presentation' => 'Caja x 30 tabletas',
                'indications' => 'Ansiedad, convulsiones, espasmo muscular, sedación',
                'contraindications' => 'Glaucoma de ángulo cerrado, miastenia gravis, depresión respiratoria',
                'warnings' => 'Dependencia. Evitar suspensión abrupta. Potencia efectos de alcohol y opioides',
                'storage_conditions' => json_encode(['temperature' => '15-30°C', 'controlled' => 'true']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'commercial_name' => 'Diazepam Normon',
                'generic_name' => 'Diazepam',
                'active_ingredient_id' => $diazepamId,
                'concentration_unit_id' => $mgMlId,
                'concentration' => 5,
                'administration_route_id' => $ivId,
                'pharmaceutical_form' => 'Solución inyectable',
                'registration_number' => 'INVIMA-COL-011',
                'laboratory' => 'Normon',
                'presentation' => 'Ampolla 2ml (5mg/ml)',
                'indications' => 'Status epilepticus, sedación, tetania',
                'contraindications' => 'Depresión respiratoria severa, shock',
                'warnings' => 'Administrar lentamente. Riesgo de paro respiratorio. Tromboflebitis',
                'storage_conditions' => json_encode(['temperature' => '15-30°C', 'light' => 'Proteger']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // FENITOÍNA
            [
                'commercial_name' => 'Epamin',
                'generic_name' => 'Fenitoína',
                'active_ingredient_id' => $fenitoinaId,
                'concentration_unit_id' => $mgId,
                'concentration' => 100,
                'administration_route_id' => $poId,
                'pharmaceutical_form' => 'Cápsula',
                'registration_number' => 'INVIMA-COL-012',
                'laboratory' => 'Abbott',
                'presentation' => 'Caja x 30 cápsulas',
                'indications' => 'Epilepsia, prevención de convulsiones',
                'contraindications' => 'Hipersensibilidad, bradicardia sinusal, bloqueo AV',
                'warnings' => 'Inductor enzimático potente. Múltiples interacciones. Monitoreo de niveles',
                'storage_conditions' => json_encode(['temperature' => '15-30°C']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'commercial_name' => 'Fenitoína Sódica',
                'generic_name' => 'Fenitoína',
                'active_ingredient_id' => $fenitoinaId,
                'concentration_unit_id' => $mgMlId,
                'concentration' => 50,
                'administration_route_id' => $ivId,
                'pharmaceutical_form' => 'Solución inyectable',
                'registration_number' => 'INVIMA-COL-013',
                'laboratory' => 'Sandoz',
                'presentation' => 'Ampolla 5ml (250mg/5ml)',
                'indications' => 'Status epilepticus, profilaxis de convulsiones postoperatorias',
                'contraindications' => 'Bradicardia, bloqueo AV, síndrome de Adams-Stokes',
                'warnings' => 'SOLO en SF. NO en DAD. Administrar lentamente (<50mg/min). Precipita en ácido',
                'storage_conditions' => json_encode(['temperature' => '15-30°C', 'pH' => 'Alcalino 12']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ENALAPRIL
            [
                'commercial_name' => 'Renitec',
                'generic_name' => 'Enalapril',
                'active_ingredient_id' => $enalaprilId,
                'concentration_unit_id' => $mgId,
                'concentration' => 10,
                'administration_route_id' => $poId,
                'pharmaceutical_form' => 'Tableta',
                'registration_number' => 'INVIMA-COL-014',
                'laboratory' => 'MSD',
                'presentation' => 'Caja x 30 tabletas',
                'indications' => 'HTA, insuficiencia cardíaca, prevención renal en diabetes',
                'contraindications' => 'Embarazo, angioedema previo con IECA, estenosis renal bilateral',
                'warnings' => 'Hiperpotasemia. Tos seca. Hipotensión primera dosis. Ajustar en IR',
                'storage_conditions' => json_encode(['temperature' => '15-30°C']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ATORVASTATINA
            [
                'commercial_name' => 'Lipitor',
                'generic_name' => 'Atorvastatina',
                'active_ingredient_id' => $atorvastatinaId,
                'concentration_unit_id' => $mgId,
                'concentration' => 20,
                'administration_route_id' => $poId,
                'pharmaceutical_form' => 'Tableta',
                'registration_number' => 'INVIMA-COL-015',
                'laboratory' => 'Pfizer',
                'presentation' => 'Caja x 30 tabletas',
                'indications' => 'Hipercolesterolemia, prevención cardiovascular',
                'contraindications' => 'Hepatopatía activa, embarazo, lactancia',
                'warnings' => 'Miopatía, rabdomiólisis. Hepatotoxicidad. Interacciones con CYP3A4',
                'storage_conditions' => json_encode(['temperature' => '15-30°C']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // DIGOXINA
            [
                'commercial_name' => 'Lanoxin',
                'generic_name' => 'Digoxina',
                'active_ingredient_id' => $digoxinaId,
                'concentration_unit_id' => $mgId,
                'concentration' => 0.25,
                'administration_route_id' => $poId,
                'pharmaceutical_form' => 'Tableta',
                'registration_number' => 'INVIMA-COL-016',
                'laboratory' => 'GlaxoSmithKline',
                'presentation' => 'Caja x 30 tabletas',
                'indications' => 'Insuficiencia cardíaca, fibrilación auricular',
                'contraindications' => 'Bloqueo AV completo, taquicardia ventricular, hiperpotasemia',
                'warnings' => 'Ventana terapéutica estrecha. Toxicidad: náusea, visión amarilla, arritmias',
                'storage_conditions' => json_encode(['temperature' => '15-30°C']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ESPIRONOLACTONA
            [
                'commercial_name' => 'Aldactone',
                'generic_name' => 'Espironolactona',
                'active_ingredient_id' => $espironolactonaId,
                'concentration_unit_id' => $mgId,
                'concentration' => 25,
                'administration_route_id' => $poId,
                'pharmaceutical_form' => 'Tableta',
                'registration_number' => 'INVIMA-COL-017',
                'laboratory' => 'Pfizer',
                'presentation' => 'Caja x 20 tabletas',
                'indications' => 'Insuficiencia cardíaca, HTA, hiperaldosteronismo, ascitis',
                'contraindications' => 'Hiperpotasemia, IR severa, enfermedad de Addison',
                'warnings' => 'Hiperpotasemia con IECA. Ginecomastia. Monitorear K+ y creatinina',
                'storage_conditions' => json_encode(['temperature' => '15-30°C']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // RANITIDINA
            [
                'commercial_name' => 'Zantac',
                'generic_name' => 'Ranitidina',
                'active_ingredient_id' => $rantidinaId,
                'concentration_unit_id' => $mgId,
                'concentration' => 150,
                'administration_route_id' => $poId,
                'pharmaceutical_form' => 'Tableta',
                'registration_number' => 'INVIMA-COL-018',
                'laboratory' => 'GlaxoSmithKline',
                'presentation' => 'Caja x 20 tabletas',
                'indications' => 'Úlcera péptica, ERGE, prevención de úlcera por estrés',
                'contraindications' => 'Hipersensibilidad',
                'warnings' => 'Ajustar en IR. Confusión en ancianos. Interacción con ketoconazol',
                'storage_conditions' => json_encode(['temperature' => '15-30°C']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // METOCLOPRAMIDA
            [
                'commercial_name' => 'Plasil',
                'generic_name' => 'Metoclopramida',
                'active_ingredient_id' => $metoclopramidaId,
                'concentration_unit_id' => $mgId,
                'concentration' => 10,
                'administration_route_id' => $poId,
                'pharmaceutical_form' => 'Tableta',
                'registration_number' => 'INVIMA-COL-019',
                'laboratory' => 'Sanofi',
                'presentation' => 'Caja x 30 tabletas',
                'indications' => 'Náusea, vómito, gastroparesia',
                'contraindications' => 'Obstrucción intestinal, feocromocitoma, epilepsia',
                'warnings' => 'Efectos extrapiramidales. Discinesia tardía. Síndrome neuroléptico maligno',
                'storage_conditions' => json_encode(['temperature' => '15-30°C']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'commercial_name' => 'Metoclopramida Vitalis',
                'generic_name' => 'Metoclopramida',
                'active_ingredient_id' => $metoclopramidaId,
                'concentration_unit_id' => $mgMlId,
                'concentration' => 5,
                'administration_route_id' => $ivId,
                'pharmaceutical_form' => 'Solución inyectable',
                'registration_number' => 'INVIMA-COL-020',
                'laboratory' => 'Vitalis',
                'presentation' => 'Ampolla 2ml (10mg/2ml)',
                'indications' => 'Náusea, vómito postoperatorio, gastroparesia',
                'contraindications' => 'Obstrucción GI, perforación, sangrado',
                'warnings' => 'Efectos extrapiramidales más frecuentes con IV. Distonía aguda',
                'storage_conditions' => json_encode(['temperature' => '15-30°C', 'light' => 'Proteger']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // HEPARINA
            [
                'commercial_name' => 'Heparina Sódica',
                'generic_name' => 'Heparina',
                'active_ingredient_id' => $heparinaId,
                'concentration_unit_id' => $uiId,
                'concentration' => 5000,
                'administration_route_id' => $scId,
                'pharmaceutical_form' => 'Solución inyectable',
                'registration_number' => 'INVIMA-COL-021',
                'laboratory' => 'Genfar',
                'presentation' => 'Jeringa prellenada 0.2ml (5000 UI)',
                'indications' => 'Prevención de TVP, tratamiento de TVP/EP, SCA',
                'contraindications' => 'Sangrado activo, trombocitopenia inducida por heparina',
                'warnings' => 'Riesgo de sangrado. Monitoreo APTT. Trombocitopenia. Reversión con protamina',
                'storage_conditions' => json_encode(['temperature' => '2-8°C']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ASPIRINA (ASA)
            [
                'commercial_name' => 'Aspirina',
                'generic_name' => 'Ácido Acetilsalicílico',
                'active_ingredient_id' => $asaId,
                'concentration_unit_id' => $mgId,
                'concentration' => 100,
                'administration_route_id' => $poId,
                'pharmaceutical_form' => 'Tableta',
                'registration_number' => 'INVIMA-COL-022',
                'laboratory' => 'Bayer',
                'presentation' => 'Caja x 30 tabletas',
                'indications' => 'Prevención cardiovascular, SCA, ACV isquémico',
                'contraindications' => 'Úlcera péptica activa, hemofilia, niños con varicela (Reye)',
                'warnings' => 'Riesgo de sangrado GI. Evitar con otros antiagregantes/anticoagulantes',
                'storage_conditions' => json_encode(['temperature' => '15-30°C']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // DEXAMETASONA
            [
                'commercial_name' => 'Decadron',
                'generic_name' => 'Dexametasona',
                'active_ingredient_id' => $dexametasonaId,
                'concentration_unit_id' => $mgId,
                'concentration' => 0.5,
                'administration_route_id' => $poId,
                'pharmaceutical_form' => 'Tableta',
                'registration_number' => 'INVIMA-COL-023',
                'laboratory' => 'MSD',
                'presentation' => 'Caja x 20 tabletas',
                'indications' => 'Inflamación, enfermedades autoinmunes, edema cerebral, alergia',
                'contraindications' => 'Infección sistémica no tratada, úlcera péptica activa',
                'warnings' => 'Hiperglucemia. Inmunosupresión. Osteoporosis. No suspender abruptamente',
                'storage_conditions' => json_encode(['temperature' => '15-30°C']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'commercial_name' => 'Dexametasona Wyeth',
                'generic_name' => 'Dexametasona',
                'active_ingredient_id' => $dexametasonaId,
                'concentration_unit_id' => $mgMlId,
                'concentration' => 4,
                'administration_route_id' => $ivId,
                'pharmaceutical_form' => 'Solución inyectable',
                'registration_number' => 'INVIMA-COL-024',
                'laboratory' => 'Wyeth',
                'presentation' => 'Ampolla 2ml (8mg/2ml)',
                'indications' => 'Shock, edema cerebral, reacción alérgica severa, COVID-19 severo',
                'contraindications' => 'Infección sistémica no tratada',
                'warnings' => 'Hiperglucemia severa. Riesgo de infección oportunista',
                'storage_conditions' => json_encode(['temperature' => '15-30°C', 'light' => 'Proteger']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // HIDROCORTISONA
            [
                'commercial_name' => 'Solu-Cortef',
                'generic_name' => 'Hidrocortisona',
                'active_ingredient_id' => $hidrocortisonaId,
                'concentration_unit_id' => $mgId,
                'concentration' => 100,
                'administration_route_id' => $ivId,
                'pharmaceutical_form' => 'Polvo liofilizado para solución inyectable',
                'registration_number' => 'INVIMA-COL-025',
                'laboratory' => 'Pfizer',
                'presentation' => 'Frasco ampolla 100mg',
                'indications' => 'Shock, insuficiencia suprarrenal, reacción alérgica severa',
                'contraindications' => 'Infección sistémica no tratada',
                'warnings' => 'Hiperglucemia. Reemplazo fisiológico: 15-25mg/día. Estrés: 100-300mg/día',
                'storage_conditions' => json_encode(['temperature' => '2-8°C', 'reconstituted' => 'Usar en 3 días']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // INSULINA NPH
            [
                'commercial_name' => 'Insulina NPH Humulin',
                'generic_name' => 'Insulina NPH',
                'active_ingredient_id' => $insulinaNPHId,
                'concentration_unit_id' => $uiId,
                'concentration' => 100,
                'administration_route_id' => $scId,
                'pharmaceutical_form' => 'Suspensión inyectable',
                'registration_number' => 'INVIMA-COL-026',
                'laboratory' => 'Lilly',
                'presentation' => 'Frasco 10ml (100 UI/ml)',
                'indications' => 'Diabetes mellitus tipo 1 y 2',
                'contraindications' => 'Hipoglucemia',
                'warnings' => 'Mezclar suavemente. NO agitar. Inicio 1-2h, pico 4-6h, duración 10-16h',
                'storage_conditions' => json_encode(['temperature' => '2-8°C', 'in_use' => 'Temperatura ambiente 28 días']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // METFORMINA
            [
                'commercial_name' => 'Glucophage',
                'generic_name' => 'Metformina',
                'active_ingredient_id' => $metforminaId,
                'concentration_unit_id' => $mgId,
                'concentration' => 850,
                'administration_route_id' => $poId,
                'pharmaceutical_form' => 'Tableta',
                'registration_number' => 'INVIMA-COL-027',
                'laboratory' => 'Merck',
                'presentation' => 'Caja x 30 tabletas',
                'indications' => 'Diabetes tipo 2, síndrome de ovario poliquístico',
                'contraindications' => 'IR severa (TFG <30), acidosis metabólica, insuficiencia hepática',
                'warnings' => 'Acidosis láctica (rara). Suspender 48h antes de medios de contraste. Deficiencia B12',
                'storage_conditions' => json_encode(['temperature' => '15-30°C']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('medications')->insert($medications);
    }

    private function seedAllInteractions()
    {
        // Obtener IDs de compatibilidad
        $compatibleId = DB::table('compatibility_types')->where('code', 'COMPATIBLE')->value('id');
        $precautionId = DB::table('compatibility_types')->where('code', 'PRECAUTION')->value('id');
        $minorId = DB::table('compatibility_types')->where('code', 'MINOR')->value('id');
        $criticalId = DB::table('compatibility_types')->where('code', 'CRITICAL')->value('id');

        // Obtener IDs de medicamentos
        $tramalIVId = DB::table('medications')->where('registration_number', 'INVIMA-COL-002')->value('id');
        $dipironaIVId = DB::table('medications')->where('registration_number', 'INVIMA-COL-004')->value('id');
        $ketorolacoIVId = DB::table('medications')->where('registration_number', 'INVIMA-COL-006')->value('id');
        $gentamicinaId = DB::table('medications')->where('registration_number', 'INVIMA-COL-007')->value('id');
        $vancomicinaId = DB::table('medications')->where('registration_number', 'INVIMA-COL-008')->value('id');
        $ceftriaxonaId = DB::table('medications')->where('registration_number', 'INVIMA-COL-009')->value('id');
        $diazepamIVId = DB::table('medications')->where('registration_number', 'INVIMA-COL-011')->value('id');
        $fenitoinaIVId = DB::table('medications')->where('registration_number', 'INVIMA-COL-013')->value('id');
        $metoclopramidaIVId = DB::table('medications')->where('registration_number', 'INVIMA-COL-020')->value('id');
        $dexametasonaIVId = DB::table('medications')->where('registration_number', 'INVIMA-COL-024')->value('id');
        $hidrocortisonaId = DB::table('medications')->where('registration_number', 'INVIMA-COL-025')->value('id');

        // Medicamentos orales
        $tramalOralId = DB::table('medications')->where('registration_number', 'INVIMA-COL-001')->value('id');
        $diazepamOralId = DB::table('medications')->where('registration_number', 'INVIMA-COL-010')->value('id');
        $fenitoinaOralId = DB::table('medications')->where('registration_number', 'INVIMA-COL-012')->value('id');
        $enalaprilId = DB::table('medications')->where('registration_number', 'INVIMA-COL-014')->value('id');
        $atorvastatinaId = DB::table('medications')->where('registration_number', 'INVIMA-COL-015')->value('id');
        $digoxinaId = DB::table('medications')->where('registration_number', 'INVIMA-COL-016')->value('id');
        $espironolactonaId = DB::table('medications')->where('registration_number', 'INVIMA-COL-017')->value('id');
        $rantidinaId = DB::table('medications')->where('registration_number', 'INVIMA-COL-018')->value('id');
        $aspirinaId = DB::table('medications')->where('registration_number', 'INVIMA-COL-022')->value('id');
        $metforminaId = DB::table('medications')->where('registration_number', 'INVIMA-COL-027')->value('id');

        $this->seedPhysicochemicalInteractionsColombia($compatibleId, $precautionId, $minorId, $criticalId,
            $tramalIVId, $dipironaIVId, $ketorolacoIVId, $gentamicinaId, $vancomicinaId, $ceftriaxonaId,
            $diazepamIVId, $fenitoinaIVId, $metoclopramidaIVId, $dexametasonaIVId, $hidrocortisonaId);

        $this->seedPharmacodynamicInteractionsColombia($compatibleId, $precautionId, $minorId, $criticalId,
            $tramalOralId, $tramalIVId, $diazepamOralId, $diazepamIVId, $ketorolacoIVId, $aspirinaId,
            $enalaprilId, $digoxinaId, $espironolactonaId, $gentamicinaId, $vancomicinaId, $metforminaId);

        $this->seedPharmacokineticInteractionsColombia($compatibleId, $precautionId, $minorId, $criticalId,
            $tramalOralId, $fenitoinaOralId, $atorvastatinaId, $digoxinaId, $rantidinaId, $metoclopramidaIVId);
    }

    private function seedPhysicochemicalInteractionsColombia($compatibleId, $precautionId, $minorId, $criticalId,
        $tramalIVId, $dipironaIVId, $ketorolacoIVId, $gentamicinaId, $vancomicinaId, $ceftriaxonaId,
        $diazepamIVId, $fenitoinaIVId, $metoclopramidaIVId, $dexametasonaIVId, $hidrocortisonaId)
    {
        $interactions = [
            // CRÍTICA: Fenitoína + Dextrosa (precipitación)
            [
                'medication_1_id' => $fenitoinaIVId,
                'medication_2_id' => $dexametasonaIVId,
                'compatibility_type_id' => $criticalId,
                'description' => 'Fenitoína (pH 12) precipita en soluciones ácidas o con dextrosa. Dexametasona contiene fosfato que puede alterar pH. Alto riesgo de precipitación.',
                'mechanism' => 'Fenitoína es muy alcalina (pH 12) y precipita rápidamente en pH <11. Cualquier mezcla con soluciones ácidas causa precipitación inmediata de cristales.',
                'consequences' => 'Precipitación visible inmediata. Cristales blancos. Oclusión de catéter. Pérdida de actividad. Riesgo de embolia.',
                'recommendations' => 'NUNCA mezclar. Fenitoína SOLO en SF 0.9%, NUNCA en dextrosa. Usar vías IV completamente separadas. Lavar línea con SF entre medicamentos.',
                'evidence_level' => json_encode(['level' => 'A', 'description' => 'Alta evidencia - Incompatibilidad conocida']),
                'source' => 'Trissel\'s Handbook, King Guide',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // CRÍTICA: Gentamicina + Ceftriaxona
            [
                'medication_1_id' => $gentamicinaId,
                'medication_2_id' => $ceftriaxonaId,
                'compatibility_type_id' => $criticalId,
                'description' => 'Gentamicina (aminoglucósido) y ceftriaxona (betalactámico) son físicamente INCOMPATIBLES. Se inactivan mutuamente si se mezclan.',
                'mechanism' => 'Los betalactámicos (ceftriaxona) pueden romper el anillo aminoglucósido, inactivando la gentamicina. Reacción química directa entre grupos funcionales.',
                'consequences' => 'Inactivación de ambos antibióticos. Pérdida completa de actividad bactericida. Falla terapéutica.',
                'recommendations' => 'NUNCA mezclar en la misma jeringa o bolsa. SIEMPRE administrar en vías IV separadas con intervalo mínimo de 1 hora. Lavar línea con 10ml SF entre cada uno.',
                'evidence_level' => json_encode(['level' => 'A', 'description' => 'Alta evidencia - Inactivación documentada']),
                'source' => 'Trissel\'s Handbook, estudios de estabilidad',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // CRÍTICA: Vancomicina + Ceftriaxona (con calcio)
            [
                'medication_1_id' => $vancomicinaId,
                'medication_2_id' => $ceftriaxonaId,
                'compatibility_type_id' => $minorId,
                'description' => 'Vancomicina y ceftriaxona son físicamente compatibles PERO ceftriaxona NO debe mezclarse con soluciones que contengan calcio (precipitación fatal).',
                'mechanism' => 'Vancomicina y ceftriaxona no reaccionan entre sí. Sin embargo, ceftriaxona forma complejos insolubles con calcio (precipitado de ceftriaxona-calcio).',
                'consequences' => 'Compatibles entre sí, pero precaución con calcio. Si hay calcio en la línea: precipitación pulmonar y renal potencialmente fatal.',
                'recommendations' => 'Pueden administrarse en la misma vía IV secuencialmente. NUNCA administrar ceftriaxona con soluciones que contengan calcio (Ringer Lactato, gluconato de calcio). Lavar línea con SF. En neonatos: separar administración 48 horas.',
                'evidence_level' => json_encode(['level' => 'A', 'description' => 'Alta evidencia - Muertes reportadas con ceftriaxona-calcio']),
                'source' => 'FDA Warning, Trissel\'s',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // COMPATIBLE: Tramadol + Dipirona
            [
                'medication_1_id' => $tramalIVId,
                'medication_2_id' => $dipironaIVId,
                'compatibility_type_id' => $compatibleId,
                'description' => 'Tramadol y dipirona son físicamente compatibles. Pueden administrarse en la misma vía IV sin problemas de precipitación.',
                'mechanism' => 'pH compatible (tramadol 4-6, dipirona 6-8). Sin reacción química adversa. Estables en SF y DAD 5%.',
                'consequences' => 'Sin incompatibilidad física. Ambos mantienen estabilidad.',
                'recommendations' => 'Compatibles. Pueden administrarse en la misma vía IV. Combinación frecuente en analgesia multimodal en Colombia. Dipirona administrar lentamente (>5 min) para evitar hipotensión.',
                'evidence_level' => json_encode(['level' => 'B', 'description' => 'Moderada evidencia']),
                'source' => 'Trissel\'s Handbook, práctica clínica colombiana',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // COMPATIBLE: Tramadol + Ketorolaco
            [
                'medication_1_id' => $tramalIVId,
                'medication_2_id' => $ketorolacoIVId,
                'compatibility_type_id' => $compatibleId,
                'description' => 'Tramadol y ketorolaco son físicamente compatibles.',
                'mechanism' => 'pH compatible. Sin reacción química. Estables en SF.',
                'consequences' => 'Sin incompatibilidad física.',
                'recommendations' => 'Compatibles. Pueden administrarse en la misma vía IV. Excelente combinación para analgesia multimodal. Ketorolaco potencia analgesia de tramadol.',
                'evidence_level' => json_encode(['level' => 'B', 'description' => 'Moderada evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // COMPATIBLE: Tramadol + Metoclopramida
            [
                'medication_1_id' => $tramalIVId,
                'medication_2_id' => $metoclopramidaIVId,
                'compatibility_type_id' => $compatibleId,
                'description' => 'Tramadol y metoclopramida son físicamente compatibles. Combinación útil: metoclopramida reduce náusea por tramadol.',
                'mechanism' => 'pH compatible. Sin incompatibilidad química.',
                'consequences' => 'Sin incompatibilidad física. Metoclopramida previene náusea inducida por tramadol.',
                'recommendations' => 'Compatibles. Pueden administrarse en la misma vía IV. Combinación recomendada para prevenir efectos adversos GI de tramadol.',
                'evidence_level' => json_encode(['level' => 'B', 'description' => 'Moderada evidencia']),
                'source' => 'Trissel\'s Handbook, práctica clínica',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // PRECAUCIÓN: Dipirona + Ketorolaco
            [
                'medication_1_id' => $dipironaIVId,
                'medication_2_id' => $ketorolacoIVId,
                'compatibility_type_id' => $compatibleId,
                'description' => 'Dipirona y ketorolaco son físicamente compatibles.',
                'mechanism' => 'pH compatible. Sin reacción química directa.',
                'consequences' => 'Sin incompatibilidad física. Ambos son analgésicos por mecanismos diferentes.',
                'recommendations' => 'Compatibles físicamente. Pueden administrarse en la misma vía IV. PRECAUCIÓN: Ambos aumentan riesgo de sangrado (ver interacciones farmacodinámicas).',
                'evidence_level' => json_encode(['level' => 'B', 'description' => 'Moderada evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // COMPATIBLE: Diazepam + Dipirona
            [
                'medication_1_id' => $diazepamIVId,
                'medication_2_id' => $dipironaIVId,
                'compatibility_type_id' => $compatibleId,
                'description' => 'Diazepam y dipirona son compatibles físicamente.',
                'mechanism' => 'Sin reacción química adversa.',
                'consequences' => 'Sin incompatibilidad física.',
                'recommendations' => 'Compatibles. Pueden administrarse en la misma vía IV. Ambos pueden causar hipotensión (ver interacciones farmacodinámicas).',
                'evidence_level' => json_encode(['level' => 'B', 'description' => 'Moderada evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // MENOR: Diazepam + Fenitoína
            [
                'medication_1_id' => $diazepamIVId,
                'medication_2_id' => $fenitoinaIVId,
                'compatibility_type_id' => $minorId,
                'description' => 'Diazepam y fenitoína presentan incompatibilidad menor. Fenitoína (pH 12) puede causar precipitación de diazepam en algunas condiciones.',
                'mechanism' => 'Gran diferencia de pH. Fenitoína muy alcalina puede precipitar diazepam.',
                'consequences' => 'Posible turbidez o precipitación leve.',
                'recommendations' => 'Preferible usar vías IV separadas. Si se usa misma vía, lavar con SF entre medicamentos. Fenitoína SIEMPRE en SF, NUNCA dextrosa.',
                'evidence_level' => json_encode(['level' => 'B', 'description' => 'Moderada evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // COMPATIBLE: Gentamicina + Vancomicina
            [
                'medication_1_id' => $gentamicinaId,
                'medication_2_id' => $vancomicinaId,
                'compatibility_type_id' => $compatibleId,
                'description' => 'Gentamicina y vancomicina son físicamente compatibles. Combinación frecuente en sepsis.',
                'mechanism' => 'Sin reacción química entre aminoglucósido y glucopéptido. Mecanismos de acción diferentes.',
                'consequences' => 'Sin incompatibilidad física.',
                'recommendations' => 'Compatibles. Pueden administrarse en vías IV separadas o en la misma con precaución. IMPORTANTE: Ambos son nefrotóxicos y ototóxicos (ver interacciones farmacodinámicas). Monitoreo de función renal y niveles séricos obligatorio.',
                'evidence_level' => json_encode(['level' => 'A', 'description' => 'Alta evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // COMPATIBLE: Dexametasona + Dipirona
            [
                'medication_1_id' => $dexametasonaIVId,
                'medication_2_id' => $dipironaIVId,
                'compatibility_type_id' => $compatibleId,
                'description' => 'Dexametasona y dipirona son físicamente compatibles.',
                'mechanism' => 'pH compatible. Sin reacción química adversa.',
                'consequences' => 'Sin incompatibilidad física.',
                'recommendations' => 'Compatibles. Pueden administrarse en la misma vía IV. Combinación útil en inflamación y dolor.',
                'evidence_level' => json_encode(['level' => 'B', 'description' => 'Moderada evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // COMPATIBLE: Dexametasona + Metoclopramida
            [
                'medication_1_id' => $dexametasonaIVId,
                'medication_2_id' => $metoclopramidaIVId,
                'compatibility_type_id' => $compatibleId,
                'description' => 'Dexametasona y metoclopramida son físicamente compatibles. Combinación estándar para náusea/vómito postoperatorio.',
                'mechanism' => 'Sin incompatibilidad química. Mecanismos antieméticos complementarios.',
                'consequences' => 'Sin incompatibilidad física. Efecto antiemético sinérgico.',
                'recommendations' => 'Compatibles. Pueden administrarse en la misma vía IV. Combinación recomendada en guías PONV (náusea/vómito postoperatorio).',
                'evidence_level' => json_encode(['level' => 'A', 'description' => 'Alta evidencia - Combinación estándar']),
                'source' => 'Trissel\'s Handbook, guías PONV',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // COMPATIBLE: Hidrocortisona + Gentamicina
            [
                'medication_1_id' => $hidrocortisonaId,
                'medication_2_id' => $gentamicinaId,
                'compatibility_type_id' => $compatibleId,
                'description' => 'Hidrocortisona y gentamicina son físicamente compatibles.',
                'mechanism' => 'Sin reacción química adversa.',
                'consequences' => 'Sin incompatibilidad física.',
                'recommendations' => 'Compatibles. Pueden administrarse en la misma vía IV. Combinación frecuente en shock séptico.',
                'evidence_level' => json_encode(['level' => 'A', 'description' => 'Alta evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // COMPATIBLE: Vancomicina + Metoclopramida
            [
                'medication_1_id' => $vancomicinaId,
                'medication_2_id' => $metoclopramidaIVId,
                'compatibility_type_id' => $compatibleId,
                'description' => 'Vancomicina y metoclopramida son físicamente compatibles.',
                'mechanism' => 'Sin incompatibilidad química.',
                'consequences' => 'Sin incompatibilidad física.',
                'recommendations' => 'Compatibles. Pueden administrarse en la misma vía IV secuencialmente.',
                'evidence_level' => json_encode(['level' => 'B', 'description' => 'Moderada evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('physicochemical_interactions')->insert($interactions);
    }

    private function seedPharmacodynamicInteractionsColombia($compatibleId, $precautionId, $minorId, $criticalId,
        $tramalOralId, $tramalIVId, $diazepamOralId, $diazepamIVId, $ketorolacoIVId, $aspirinaId,
        $enalaprilId, $digoxinaId, $espironolactonaId, $gentamicinaId, $vancomicinaId, $metforminaId)
    {
        $interactions = [
            // CRÍTICA: Tramadol + Diazepam (Depresión SNC)
            [
                'medication_1_id' => $tramalOralId,
                'medication_2_id' => $diazepamOralId,
                'compatibility_type_id' => $precautionId,
                'interaction_type' => 'Sinergia Aditiva',
                'description' => 'Tramadol (opioide) y diazepam (benzodiacepina) producen depresión aditiva del SNC. Riesgo de sedación profunda y depresión respiratoria.',
                'mechanism' => 'Tramadol actúa sobre receptores opioides mu y además inhibe recaptación de serotonina/noradrenalina. Diazepam potencia GABA. Efectos depresores del SNC se suman.',
                'clinical_effects' => 'Sedación profunda, somnolencia excesiva, mareo, depresión respiratoria, hipotensión, bradicardia, riesgo de caídas (ancianos), alteración de reflejos.',
                'recommendations' => 'Reducir dosis de ambos. Iniciar con tramadol 25-50mg (en lugar de 50-100mg) y diazepam 2.5-5mg (en lugar de 5-10mg). Titular según respuesta. Educar al paciente sobre no conducir ni operar maquinaria. EVITAR alcohol. Mayor precaución en ancianos (reducir dosis 50%). Monitoreo clínico frecuente primeros días.',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Alta evidencia',
                    'risk_populations' => 'Ancianos, EPOC, apnea del sueño, insuficiencia hepática'
                ]),
                'source' => 'Micromedex, FDA, práctica clínica colombiana',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // CRÍTICA: Ketorolaco + Aspirina (Sangrado)
            [
                'medication_1_id' => $ketorolacoIVId,
                'medication_2_id' => $aspirinaId,
                'compatibility_type_id' => $criticalId,
                'interaction_type' => 'Sinergia Aditiva',
                'description' => 'Ketorolaco y aspirina son AMBOS AINEs con efecto antiagregante plaquetario. Uso simultáneo aumenta dramáticamente riesgo de sangrado gastrointestinal y sistémico.',
                'mechanism' => 'Ambos inhiben ciclooxigenasa y bloquean síntesis de tromboxano A2, reduciendo función plaquetaria. Además, ambos dañan mucosa gástrica. Efectos se suman y potencian.',
                'clinical_effects' => 'Riesgo ALTO de hemorragia: sangrado GI (hematemesis, melena), hematuria, epistaxis, hematomas espontáneos, sangrado prolongado en heridas. Mayor riesgo de úlcera péptica. Falla renal aguda.',
                'recommendations' => 'EVITAR combinación. Si el paciente usa aspirina para prevención cardiovascular, NO agregar ketorolaco (usar paracetamol o tramadol). Si ya está usando ambos: SUSPENDER uno inmediatamente. Evaluar riesgo/beneficio. Si sangrado GI: suspender ambos, iniciar IBP, monitoreo hematocrito. En postoperatorio: preferir analgesia sin AINEs en pacientes con aspirina.',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Alta evidencia - Contraindicación relativa',
                    'black_box' => 'Ketorolaco tiene advertencia de caja negra por sangrado'
                ]),
                'source' => 'FDA Black Box Warning, guías de dolor',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // CRÍTICA: Enalapril + Espironolactona (Hiperpotasemia)
            [
                'medication_1_id' => $enalaprilId,
                'medication_2_id' => $espironolactonaId,
                'compatibility_type_id' => $precautionId,
                'interaction_type' => 'Sinergia Aditiva',
                'description' => 'Enalapril (IECA) y espironolactona (diurético ahorrador de K+) ambos aumentan potasio sérico. Riesgo significativo de hiperpotasemia severa.',
                'mechanism' => 'IECAs reducen aldosterona, disminuyendo excreción renal de K+. Espironolactona antagoniza aldosterona directamente, también reteniendo K+. Efectos se suman causando hiperpotasemia.',
                'clinical_effects' => 'Hiperpotasemia (K+ >5.5 mEq/L): debilidad muscular, parestesias, náusea, bradicardia, arritmias ventriculares (torsades de pointes), paro cardíaco (K+ >7 mEq/L). Riesgo mayor en IR, diabetes, ancianos.',
                'recommendations' => 'Combinación frecuente y ÚTIL en ICC pero requiere monitoreo estricto. Monitoreo K+ basal, a los 3-5 días, luego semanal x1 mes, después mensual. Mantener K+ 4-5 mEq/L. Reducir dosis de espironolactona (12.5-25mg/día en lugar de 50-100mg). EVITAR suplementos de K+. Educar al paciente: evitar sustitutos de sal (KCl). Si K+ >5.5: reducir/suspender espironolactona. Si K+ >6: suspender ambos, tratar hiperpotasemia.',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Alta evidencia',
                    'guidelines' => 'Combinación recomendada en ICC con monitoreo',
                    'mortality_benefit' => 'Reduce mortalidad en ICC pero requiere vigilancia de K+'
                ]),
                'source' => 'RALES Trial, ACC/AHA Guidelines',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // CRÍTICA: Gentamicina + Vancomicina (Nefrotoxicidad)
            [
                'medication_1_id' => $gentamicinaId,
                'medication_2_id' => $vancomicinaId,
                'compatibility_type_id' => $criticalId,
                'interaction_type' => 'Sinergia Aditiva',
                'description' => 'Gentamicina y vancomicina son AMBOS nefrotóxicos y ototóxicos. Uso simultáneo aumenta dramáticamente riesgo de insuficiencia renal aguda y sordera.',
                'mechanism' => 'Gentamicina causa necrosis tubular aguda directa. Vancomicina causa nefritis intersticial. Ambos se acumulan en células del túbulo proximal y cóclea. Efectos se suman.',
                'clinical_effects' => 'Insuficiencia renal aguda (aumento de creatinina >0.5mg/dl o 50% del basal), oliguria, necesidad de diálisis. Ototoxicidad: hipoacusia bilateral irreversible, tinnitus, vértigo. Mayor riesgo en: hipovolemia, IR previa, dosis altas, uso prolongado, >65 años.',
                'recommendations' => 'Combinación solo en infecciones GRAVES con sospecha de múltiples patógenos (ej: endocarditis, neutropenia febril). Monitoreo OBLIGATORIO: creatinina diaria, BUN, balance hídrico. Niveles séricos de gentamicina (valle <2 mcg/ml) y vancomicina (valle 10-20 mcg/ml). Duración mínima necesaria (<5-7 días idealmente). Asegurar euvolemia. Ajustar dosis según TFG. Considerar alternativas menos nefrotóxicas si es posible. Audiometría si tratamiento >5 días.',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Alta evidencia - Nefrotoxicidad aditiva bien documentada',
                    'incidence' => 'Nefrotoxicidad: 30-60% con combinación vs 10-25% con uno solo'
                ]),
                'source' => 'Micromedex, Sanford Guide, estudios de nefrotoxicidad',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // PRECAUCIÓN: Digoxina + Espironolactona
            [
                'medication_1_id' => $digoxinaId,
                'medication_2_id' => $espironolactonaId,
                'compatibility_type_id' => $precautionId,
                'interaction_type' => 'Efecto Complejo sobre Electrolitos',
                'description' => 'Espironolactona aumenta K+ mientras digoxina requiere K+ en rango normal (3.5-5 mEq/L). K+ alto protege de toxicidad digitálica pero K+ bajo aumenta riesgo.',
                'mechanism' => 'Digoxina inhibe bomba Na+/K+ ATPasa. Hipopotasemia aumenta afinidad de digoxina por su sitio de acción, aumentando toxicidad. Hiperpotasemia puede reducir efecto de digoxina. Espironolactona aumenta K+, lo cual puede ser protector O problemático.',
                'clinical_effects' => 'Si K+ muy alto (>5.5): digoxina menos efectiva, puede necesitar mayor dosis. Si K+ normal-alto (4.5-5): efecto protector contra toxicidad digitálica. Riesgo de arritmias si K+ fluctúa.',
                'recommendations' => 'Combinación aceptable y frecuente en ICC. Monitoreo de K+ estricto: mantener 4-5 mEq/L (rango ideal). Monitoreo de niveles de digoxina (0.5-0.9 ng/ml objetivo moderno, NO 0.8-2 ng/ml). Síntomas de toxicidad digitálica: náusea, visión amarilla, bradicardia, arritmias. Ajustar dosis según K+ y niveles séricos.',
                'evidence_level' => json_encode([
                    'level' => 'B',
                    'description' => 'Moderada evidencia',
                    'practice' => 'Combinación común en ICC con monitoreo'
                ]),
                'source' => 'Micromedex, guías de ICC',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // PRECAUCIÓN: Metformina + Enalapril
            [
                'medication_1_id' => $metforminaId,
                'medication_2_id' => $enalaprilId,
                'compatibility_type_id' => $compatibleId,
                'interaction_type' => 'Sin Interacción Farmacodinámica Significativa',
                'description' => 'Metformina y enalapril no tienen interacción farmacodinámica directa importante. Ambos son seguros y beneficiosos en diabetes con HTA.',
                'mechanism' => 'Metformina reduce glucosa por mecanismos hepáticos e intestinales. IECAs reducen PA y protegen riñón. Mecanismos independientes. IECAs pueden mejorar sensibilidad a insulina levemente.',
                'clinical_effects' => 'Sin efectos adversos aditivos significativos. Ambos son nefroprotectores en diabetes. Combinación reduce riesgo cardiovascular y progresión de nefropatía diabética.',
                'recommendations' => 'Combinación RECOMENDADA en diabetes tipo 2 con HTA. Monitoreo de función renal (TFG) cada 3-6 meses. Si TFG <30 ml/min: SUSPENDER metformina (riesgo de acidosis láctica). IECA continuar con precaución. Ajustar metformina en IR moderada (TFG 30-45: máximo 1000mg/día).',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Alta evidencia - Combinación estándar y beneficiosa',
                    'guidelines' => 'Recomendado en guías ADA, KDIGO'
                ]),
                'source' => 'ADA Guidelines, KDIGO Guidelines',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Duplicación: Tramadol oral + Tramadol IV
            [
                'medication_1_id' => $tramalOralId,
                'medication_2_id' => $tramalIVId,
                'compatibility_type_id' => $criticalId,
                'interaction_type' => 'Duplicación Terapéutica',
                'description' => 'Ambos son tramadol. Uso simultáneo causa sobredosis con riesgo de convulsiones y síndrome serotoninérgico.',
                'mechanism' => 'Mismo principio activo por dos vías. Tramadol se acumula. Dosis >400mg/día aumentan riesgo de convulsiones. Inhibición de recaptación de serotonina puede causar síndrome serotoninérgico.',
                'clinical_effects' => 'Sobredosis de tramadol: convulsiones (umbral bajo, 200-400mg dosis única), síndrome serotoninérgico (agitación, confusión, hipertermia, rigidez, mioclonías), depresión respiratoria, náusea/vómito severos.',
                'recommendations' => 'NUNCA usar ambas vías simultáneamente. Usar SOLO una vía. Si se cambia de oral a IV por NPO: suspender oral al iniciar IV. Dosis máxima tramadol: 400mg/día total. Reducir en IR, ancianos, epilepsia. EVITAR con ISRS (riesgo serotoninérgico).',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Alta evidencia - Contraindicación absoluta de duplicación',
                    'seizure_risk' => 'Riesgo de convulsiones dosis-dependiente'
                ]),
                'source' => 'FDA, Micromedex',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Duplicación: Diazepam oral + Diazepam IV
            [
                'medication_1_id' => $diazepamOralId,
                'medication_2_id' => $diazepamIVId,
                'compatibility_type_id' => $criticalId,
                'interaction_type' => 'Duplicación Terapéutica',
                'description' => 'Ambos son diazepam. Uso simultáneo causa sobredosis con depresión respiratoria severa.',
                'mechanism' => 'Mismo principio activo. Diazepam tiene vida media muy larga (~48h, hasta 100h en ancianos). Se acumula fácilmente.',
                'clinical_effects' => 'Sedación profunda, depresión respiratoria, hipotensión, confusión, ataxia, caídas, amnesia anterógrada, riesgo de paro respiratorio.',
                'recommendations' => 'NUNCA usar ambas vías simultáneamente. Si se requiere sedación rápida (convulsión): usar IV y suspender oral por 24-48h. Diazepam se acumula: efecto persiste días después de suspender. Reducir dosis 50% en ancianos e insuficiencia hepática.',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Alta evidencia - Contraindicación de duplicación',
                    'accumulation' => 'Vida media larga facilita acumulación'
                ]),
                'source' => 'Micromedex, FDA',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('pharmacodynamic_interactions')->insert($interactions);
    }
    
    private function seedPharmacokineticInteractionsColombia($compatibleId, $precautionId, $minorId, $criticalId,
        $tramalOralId, $fenitoinaOralId, $atorvastatinaId, $digoxinaId, $rantidinaId, $metoclopramidaIVId)
    {
        $interactions = [
            // CRÍTICA: Fenitoína → Atorvastatina (Metabolismo - Inducción CYP3A4)
            [
                'medication_1_id' => $atorvastatinaId, // AFECTADO
                'medication_2_id' => $fenitoinaOralId, // CAUSANTE
                'compatibility_type_id' => $criticalId,
                'process_affected' => 'Metabolismo',
                'description' => 'Fenitoína es un potente inductor enzimático de CYP3A4, principal enzima que metaboliza atorvastatina. Reduce significativamente los niveles plasmáticos de atorvastatina, disminuyendo su efecto hipolipemiante.',
                'mechanism' => 'Fenitoína induce la expresión y actividad de CYP3A4 hepático, aumentando el metabolismo de atorvastatina. Esto reduce el AUC (área bajo la curva) de atorvastatina en 30-50%. La inducción enzimática tarda 7-14 días en manifestarse plenamente y persiste semanas después de suspender fenitoína.',
                'clinical_effects' => 'Reducción significativa del efecto hipolipemiante: aumento del colesterol LDL y colesterol total. Pérdida del beneficio cardiovascular de la estatina. Posible necesidad de aumentar dosis de atorvastatina o cambiar a otra estatina no metabolizada por CYP3A4.',
                'recommendations' => 'EVITAR combinación si es posible. Alternativas: pravastatina o rosuvastatina (no metabolizadas por CYP3A4). Si se debe usar atorvastatina con fenitoína: DOBLAR dosis de atorvastatina (ej: 40mg a 80mg). Monitorear perfil lipídico 4-6 semanas después de iniciar fenitoína o cambiar dosis. Si se suspende fenitoína, REDUCIR dosis de atorvastatina a la mitad para evitar toxicidad muscular. Educar al paciente sobre síntomas de miopatía (dolor muscular, orina oscura).',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Alta evidencia - Interacción bien documentada',
                    'magnitude' => 'Reducción 30-50% en niveles de atorvastatina',
                    'time_course' => 'Inicio: 7-14 días, Duración: semanas después de suspender'
                ]),
                'source' => 'Micromedex, Lexicomp, estudios de interacciones CYP3A4',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // CRÍTICA: Ranitidina → Metoclopramida (Absorción - Aumento pH gástrico)
            [
                'medication_1_id' => $metoclopramidaIVId, // AFECTADO
                'medication_2_id' => $rantidinaId, // CAUSANTE
                'compatibility_type_id' => $minorId,
                'process_affected' => 'Absorción',
                'description' => 'Ranitidina aumenta el pH gástrico reduciendo la absorción de metoclopramida oral. Aunque en este caso metoclopramida es IV, es importante conocer esta interacción para uso oral.',
                'mechanism' => 'Metoclopramida es una base débil con mejor absorción en pH ácido. Ranitidina (antagonista H2) aumenta pH gástrico de 1-2 a 4-5, reduciendo la absorción de metoclopramida oral en 20-30%. La interacción es menos significativa que con omeprazol (inhibidor de bomba de protones).',
                'clinical_effects' => 'Reducción leve a moderada del efecto procinético y antiemético de metoclopramida oral. Menor alivio de náuseas y vómito. Efecto más notable en dosis únicas que en tratamiento crónico.',
                'recommendations' => 'Si se usa metoclopramida IV (como en este caso), la interacción no es relevante. Si se usa metoclopramida oral con ranitidina: administrar metoclopramida 30 minutos ANTES de ranitidina o con alimentos ácidos. Considerar aumentar dosis de metoclopramida oral si efecto insuficiente. Alternativa: usar domperidona (menor afectación por pH). Monitorear respuesta clínica del paciente.',
                'evidence_level' => json_encode([
                    'level' => 'B',
                    'description' => 'Moderada evidencia - Interacción clínicamente significativa',
                    'magnitude' => 'Reducción 20-30% en absorción oral',
                    'note' => 'No relevante para metoclopramida IV'
                ]),
                'source' => 'Micromedex, estudios de biodisponibilidad',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // PRECAUCIÓN: Digoxina ↔ Ranitidina (Absorción - Reducción)
            [
                'medication_1_id' => $digoxinaId, // AFECTADO
                'medication_2_id' => $rantidinaId, // CAUSANTE
                'compatibility_type_id' => $minorId,
                'process_affected' => 'Absorción',
                'description' => 'Ranitidina puede reducir la absorción de digoxina por aumento del pH gástrico y posible quelación. La interacción es menor que con antiácidos que contienen aluminio o magnesio.',
                'mechanism' => 'Digoxina tiene mejor absorción en pH ácido. Ranitidina aumenta pH gástrico reduciendo absorción en 10-20%. Además, posible formación de complejos no absorbibles entre digoxina y algunos componentes de la formulación de ranitidina.',
                'clinical_effects' => 'Reducción leve de niveles de digoxina (10-20%). Posible disminución del efecto terapéutico en insuficiencia cardíaca o control de frecuencia en fibrilación auricular. Riesgo de subdosificación.',
                'recommendations' => 'Monitorear niveles de digoxina 1-2 semanas después de iniciar ranitidina. Administrar digoxina 2 horas ANTES de ranitidina. Si niveles subterapéuticos, considerar aumentar dosis de digoxina en 10-20%. Estar alerta a síntomas de fallo cardiaco o mal control de frecuencia cardíaca. Preferir pantoprazol como alternativa (menor interacción).',
                'evidence_level' => json_encode([
                    'level' => 'B',
                    'description' => 'Moderada evidencia',
                    'magnitude' => 'Reducción 10-20% en absorción',
                    'monitoring' => 'Niveles de digoxina y respuesta clínica'
                ]),
                'source' => 'Micromedex, estudios de interacciones gastrointestinales',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // PRECAUCIÓN: Atorvastatina → Digoxina (Distribución - Proteínas plasmáticas)
            [
                'medication_1_id' => $digoxinaId, // AFECTADO
                'medication_2_id' => $atorvastatinaId, // CAUSANTE
                'compatibility_type_id' => $minorId,
                'process_affected' => 'Distribución',
                'description' => 'Atorvastatina puede desplazar ligeramente a digoxina de sus sitios de unión a proteínas plasmáticas, aumentando temporalmente la fracción libre de digoxina.',
                'mechanism' => 'Digoxina se une parcialmente a proteínas plasmáticas (~25%). Atorvastatina tiene alta unión a proteínas (>98%). Competencia por sitios de unión puede aumentar fracción libre de digoxina. El efecto es transitorio y leve dado que la mayoría de digoxina no está unida a proteínas.',
                'clinical_effects' => 'Aumento leve y transitorio de niveles libres de digoxina. Posible aumento de efectos digitálicos leves (náusea, leve bradicardia). Generalmente no clínicamente significativo en pacientes con niveles terapéuticos estables.',
                'recommendations' => 'Monitoreo clínico de toxicidad digitálica al iniciar atorvastatina, especialmente en pacientes ancianos o con función renal comprometida. Generalmente no requiere ajuste de dosis. Si aparecen síntomas de toxicidad: medir niveles de digoxina y ajustar dosis si es necesario. Mayor precaución si se agregan otros medicamentos que afectan digoxina.',
                'evidence_level' => json_encode([
                    'level' => 'C',
                    'description' => 'Baja evidencia - Interacción teórica con mínima relevancia clínica',
                    'magnitude' => 'Mínimo aumento de niveles libres',
                    'note' => 'Generalmente no requiere intervención'
                ]),
                'source' => 'Micromedex, datos teóricos de unión a proteínas',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // PRECAUCIÓN: Digoxina → Metoclopramida (Excreción - Motilidad GI)
            [
                'medication_1_id' => $digoxinaId, // AFECTADO
                'medication_2_id' => $metoclopramidaIVId, // CAUSANTE
                'compatibility_type_id' => $minorId,
                'process_affected' => 'Excreción',
                'description' => 'Metoclopramida aumenta la motilidad gastrointestinal disminuyendo el tiempo de tránsito. Esto puede reducir la absorción de digoxina en formulaciones de liberación prolongada o tabletas.',
                'mechanism' => 'Digoxina es absorbida principalmente en estómago y parte proximal del intestino delgado. Metoclopramida acelera el vaciamiento gástrico y tránsito intestinal, reduciendo el tiempo de contacto con la mucosa y disminuyendo absorción en 10-15%. Efecto más notable con tabletas (no con solución oral).',
                'clinical_effects' => 'Reducción leve de absorción de digoxina (10-15%). Niveles ligeramente más bajos. Posible reducción del efecto terapéutico en pacientes con dosis estables de digoxina.',
                'recommendations' => 'Si se usa metoclopramida IV (como en este caso), la interacción es mínima pero debe conocerse. Si se usa metoclopramida oral con digoxina: separar administración 2 horas si es posible. Monitorear niveles de digoxina si se inicia metoclopramida en paciente con digoxina estable. Considerar ajuste de dosis de digoxina si niveles se vuelven subterapéuticos. Mayor precaución en ancianos.',
                'evidence_level' => json_encode([
                    'level' => 'C',
                    'description' => 'Baja evidencia - Interacción menor',
                    'magnitude' => 'Reducción 10-15% en absorción',
                    'clinical_relevance' => 'Generalmente no significativa'
                ]),
                'source' => 'Micromedex, estudios de farmacocinética gastrointestinal',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // INFORMACIÓN: Digoxina metabolismo (educativa)
            [
                'medication_1_id' => $digoxinaId,
                'medication_2_id' => $digoxinaId, // Mismo para referencia
                'compatibility_type_id' => $compatibleId,
                'process_affected' => 'Excreción',
                'description' => 'Digoxina es eliminada principalmente por vía renal sin metabolismo significativo (90% inalterada en orina). La insuficiencia renal requiere ajuste de dosis. Esta información es importante para entender interacciones potenciales.',
                'mechanism' => 'Digoxina tiene vida media larga (36-48 horas en función renal normal). Se filtra en glomérulo y se secreta parcialmente en túbulos renales. No sufre metabolismo hepático significativo. Insuficiencia renal prolonga vida media hasta 5 días. Volumen de distribución grande (6-8 L/kg).',
                'clinical_effects' => 'En insuficiencia renal: acumulación de digoxina, niveles plasmáticos elevados, alto riesgo de toxicidad digitálica. Náusea, vómito, visión amarilla, bradicardia, arritmias ventriculares.',
                'recommendations' => 'Ajustar dosis de digoxina según función renal (TFG). Monitorear niveles séricos (objetivo 0.5-0.9 ng/ml en guías modernas). Evitar otros medicamentos que afecten eliminación renal (ej: amiodarona, verapamilo). En pacientes colombianos,特别注意 en adultos mayores con función renal disminuida. Hidratación adecuada. Evitar deshidratación.',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Conocimiento farmacológico establecido',
                    'note' => 'Información de referencia, no es interacción específica'
                ]),
                'source' => 'Micromedex, guías de insuficiencia cardíaca ACC/AHA',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('pharmacokinetic_interactions')->insert($interactions);
    }

    
}
