<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeder completo para interacciones entre medicamentos
 * Genera todos los tipos de interacciones (fisicoquímicas, farmacodinámicas y farmacocinéticas)
 * entre los medicamentos del sistema
 */
class CompleteInteractionsSeeder extends Seeder
{
    /**
     * Ejecuta el seeder para poplar todas las tablas de interacciones
     * Orquesta la generación de los tres tipos de interacciones
     */
    public function run(): void
    {
        // Obtener todos los IDs de medicamentos para las relaciones
        $perfalganId = DB::table('medications')->where('registration_number', 'INVIMA2024-002')->value('id');
        $tylenolId = DB::table('medications')->where('registration_number', 'INVIMA2024-001')->value('id');
        $fentanylId = DB::table('medications')->where('registration_number', 'INVIMA2024-003')->value('id');
        $midazolamId = DB::table('medications')->where('registration_number', 'INVIMA2024-004')->value('id');
        $cordaroneId = DB::table('medications')->where('registration_number', 'INVIMA2024-005')->value('id');
        $cordaroneIVId = DB::table('medications')->where('registration_number', 'INVIMA2024-006')->value('id');
        $warfarinaId = DB::table('medications')->where('registration_number', 'INVIMA2024-007')->value('id');
        $furosemidaId = DB::table('medications')->where('registration_number', 'INVIMA2024-008')->value('id');
        $dopaminaId = DB::table('medications')->where('registration_number', 'INVIMA2024-009')->value('id');
        $norepinefrinaId = DB::table('medications')->where('registration_number', 'INVIMA2024-010')->value('id');
        $prilosecId = DB::table('medications')->where('registration_number', 'INVIMA2024-011')->value('id');
        $omeprazolIVId = DB::table('medications')->where('registration_number', 'INVIMA2024-012')->value('id');
        $morfinaId = DB::table('medications')->where('registration_number', 'INVIMA2024-013')->value('id');

        // IDs de tipos de compatibilidad para clasificar las interacciones
        $compatibleId = DB::table('compatibility_types')->where('code', 'COMPATIBLE')->value('id');
        $precautionId = DB::table('compatibility_types')->where('code', 'PRECAUTION')->value('id');
        $minorId = DB::table('compatibility_types')->where('code', 'MINOR')->value('id');
        $criticalId = DB::table('compatibility_types')->where('code', 'CRITICAL')->value('id');

        // ============================================================
        // INTERACCIONES FISICOQUÍMICAS (Solo medicamentos IV)
        // Compatibilidad física de soluciones para administración intravenosa
        // ============================================================
        $this->seedPhysicochemicalInteractions($perfalganId, $fentanylId, $midazolamId, $cordaroneIVId,
            $furosemidaId, $dopaminaId, $norepinefrinaId, $omeprazolIVId, $morfinaId,
            $compatibleId, $precautionId, $minorId, $criticalId);

        // ============================================================
        // INTERACCIONES FARMACODINÁMICAS (Todos los medicamentos)
        // Efectos de los medicamentos sobre el organismo y entre sí
        // ============================================================
        $this->seedPharmacodynamicInteractions($tylenolId, $perfalganId, $fentanylId, $midazolamId,
            $cordaroneId, $cordaroneIVId, $warfarinaId, $furosemidaId, $dopaminaId,
            $norepinefrinaId, $prilosecId, $omeprazolIVId, $morfinaId,
            $compatibleId, $precautionId, $minorId, $criticalId);

        // ============================================================
        // INTERACCIONES FARMACOCINÉTICAS (Por principio activo)
        // Efectos sobre la absorción, distribución, metabolismo y excreción
        // ============================================================
        $this->seedPharmacokineticInteractions($tylenolId, $perfalganId, $fentanylId, $midazolamId,
            $cordaroneId, $warfarinaId, $furosemidaId, $dopaminaId, $prilosecId, $morfinaId, $compatibleId, $precautionId);
    }

    /**
     * Genera interacciones fisicoquímicas entre medicamentos IV
     * Se enfoca en la compatibilidad física de soluciones para administración intravenosa
     */
    private function seedPhysicochemicalInteractions($perfalganId, $fentanylId, $midazolamId,
        $cordaroneIVId, $furosemidaId, $dopaminaId, $norepinefrinaId, $omeprazolIVId, $morfinaId,
        $compatibleId, $precautionId, $minorId, $criticalId)
    {
        $interactions = [
            // ========== PERFALGAN (Paracetamol IV) ==========
            
            // Perfalgan + Fentanyl
            [
                'medication_1_id' => $perfalganId,
                'medication_2_id' => $fentanylId,
                'compatibility_type_id' => $compatibleId,
                'description' => 'Paracetamol IV y fentanyl son físicamente compatibles. Pueden administrarse en la misma vía IV sin problemas.',
                'mechanism' => 'pH similar y sin reacción química entre ambos. Compatible en SF 0.9% y DAD 5%.',
                'consequences' => 'Sin consecuencias adversas. Mantienen estabilidad.',
                'recommendations' => 'Compatibles. Pueden administrarse simultáneamente en la misma vía IV. Combinación útil para analgesia multimodal.',
                'evidence_level' => json_encode(['level' => 'B', 'description' => 'Moderada evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Perfalgan + Midazolam
            [
                'medication_1_id' => $perfalganId,
                'medication_2_id' => $midazolamId,
                'compatibility_type_id' => $compatibleId,
                'description' => 'Paracetamol IV y midazolam son compatibles físicamente.',
                'mechanism' => 'Sin interacción química. pH compatible (perfalgan 5.5, midazolam 3-4).',
                'consequences' => 'Sin consecuencias adversas fisicoquímicas.',
                'recommendations' => 'Compatibles. Pueden administrarse en la misma vía IV.',
                'evidence_level' => json_encode(['level' => 'B', 'description' => 'Moderada evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Perfalgan + Cordarone IV (ya existe en seeder original - MENOR)
            
            // Perfalgan + Furosemida
            [
                'medication_1_id' => $perfalganId,
                'medication_2_id' => $furosemidaId,
                'compatibility_type_id' => $minorId,
                'description' => 'Paracetamol IV (pH 5.5) y furosemida (pH 9) presentan incompatibilidad menor por diferencia de pH.',
                'mechanism' => 'Gran diferencia de pH puede causar precipitación leve en altas concentraciones.',
                'consequences' => 'Posible turbidez leve si se mezclan directamente.',
                'recommendations' => 'Administrar en vías separadas o lavar línea con SF entre medicamentos. No mezclar en la misma jeringa.',
                'evidence_level' => json_encode(['level' => 'B', 'description' => 'Moderada evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Perfalgan + Dopamina
            [
                'medication_1_id' => $perfalganId,
                'medication_2_id' => $dopaminaId,
                'compatibility_type_id' => $minorId,
                'description' => 'Paracetamol IV (pH 5.5) y dopamina (pH 3-4) tienen diferencia de pH que puede causar incompatibilidad.',
                'mechanism' => 'Dopamina se inactiva en pH alcalino. Diferencia de pH moderada.',
                'consequences' => 'Posible reducción de actividad de dopamina si se mezclan.',
                'recommendations' => 'Usar vías IV separadas. Si se usa misma vía, administrar secuencialmente con lavado de SF entre cada uno.',
                'evidence_level' => json_encode(['level' => 'B', 'description' => 'Moderada evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Perfalgan + Norepinefrina
            [
                'medication_1_id' => $perfalganId,
                'medication_2_id' => $norepinefrinaId,
                'compatibility_type_id' => $minorId,
                'description' => 'Paracetamol IV y norepinefrina presentan incompatibilidad menor por diferencia de pH.',
                'mechanism' => 'Norepinefrina (pH 3-4.5) y paracetamol (pH 5.5) tienen diferencia de pH. Norepinefrina se oxida en pH alcalino.',
                'consequences' => 'Posible pérdida de potencia de norepinefrina.',
                'recommendations' => 'Preferible usar vías separadas. Norepinefrina debe administrarse en DAD 5% preferentemente.',
                'evidence_level' => json_encode(['level' => 'B', 'description' => 'Moderada evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Perfalgan + Omeprazol IV (ya existe en seeder original - CRÍTICA)
            
            // Perfalgan + Morfina
            [
                'medication_1_id' => $perfalganId,
                'medication_2_id' => $morfinaId,
                'compatibility_type_id' => $compatibleId,
                'description' => 'Paracetamol IV y morfina son físicamente compatibles.',
                'mechanism' => 'pH compatible. Sin reacción química adversa.',
                'consequences' => 'Sin consecuencias fisicoquímicas adversas.',
                'recommendations' => 'Compatibles. Pueden administrarse en la misma vía IV. Excelente combinación para analgesia multimodal.',
                'evidence_level' => json_encode(['level' => 'A', 'description' => 'Alta evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ========== FENTANYL ==========
            
            // Fentanyl + Midazolam (ya existe - COMPATIBLE)
            
            // Fentanyl + Cordarone IV
            [
                'medication_1_id' => $fentanylId,
                'medication_2_id' => $cordaroneIVId,
                'compatibility_type_id' => $compatibleId,
                'description' => 'Fentanyl y amiodarona IV son físicamente compatibles.',
                'mechanism' => 'pH similar (fentanyl 4-5, amiodarona 4.1). Sin reacción química.',
                'consequences' => 'Sin incompatibilidad física.',
                'recommendations' => 'Compatibles físicamente. Pueden administrarse en la misma vía. Considerar interacción farmacocinética (ver interacciones farmacocinéticas).',
                'evidence_level' => json_encode(['level' => 'B', 'description' => 'Moderada evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Fentanyl + Furosemida
            [
                'medication_1_id' => $fentanylId,
                'medication_2_id' => $furosemidaId,
                'compatibility_type_id' => $minorId,
                'description' => 'Fentanyl (pH 4-5) y furosemida (pH 9) presentan incompatibilidad menor por gran diferencia de pH.',
                'mechanism' => 'Gran diferencia de pH. Furosemida precipita en medio ácido.',
                'consequences' => 'Posible turbidez o precipitación leve.',
                'recommendations' => 'Administrar en vías IV separadas. Si se usa misma vía, lavar con SF entre medicamentos.',
                'evidence_level' => json_encode(['level' => 'B', 'description' => 'Moderada evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Fentanyl + Dopamina
            [
                'medication_1_id' => $fentanylId,
                'medication_2_id' => $dopaminaId,
                'compatibility_type_id' => $compatibleId,
                'description' => 'Fentanyl y dopamina son compatibles físicamente. pH similar.',
                'mechanism' => 'Ambos tienen pH ácido (fentanyl 4-5, dopamina 3-4). Sin reacción adversa.',
                'consequences' => 'Sin incompatibilidad física.',
                'recommendations' => 'Compatibles. Pueden administrarse en la misma vía IV. Combinación frecuente en UCI.',
                'evidence_level' => json_encode(['level' => 'A', 'description' => 'Alta evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Fentanyl + Norepinefrina
            [
                'medication_1_id' => $fentanylId,
                'medication_2_id' => $norepinefrinaId,
                'compatibility_type_id' => $compatibleId,
                'description' => 'Fentanyl y norepinefrina son compatibles físicamente.',
                'mechanism' => 'pH similar (ambos ácidos). Sin incompatibilidad química.',
                'consequences' => 'Sin consecuencias fisicoquímicas adversas.',
                'recommendations' => 'Compatibles. Pueden administrarse en la misma vía IV. Proteger de la luz ambos medicamentos.',
                'evidence_level' => json_encode(['level' => 'A', 'description' => 'Alta evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Fentanyl + Omeprazol IV
            [
                'medication_1_id' => $fentanylId,
                'medication_2_id' => $omeprazolIVId,
                'compatibility_type_id' => $criticalId,
                'description' => 'Fentanyl (pH 4-5) y omeprazol IV (pH 9-10) son ALTAMENTE incompatibles por gran diferencia de pH.',
                'mechanism' => 'Omeprazol se degrada rápidamente en pH ácido. Diferencia extrema de pH causa precipitación inmediata.',
                'consequences' => 'Precipitación inmediata. Pérdida total de actividad del omeprazol. Turbidez marcada.',
                'recommendations' => 'NUNCA mezclar. Usar vías IV completamente separadas. Omeprazol debe administrarse en línea exclusiva.',
                'evidence_level' => json_encode(['level' => 'A', 'description' => 'Alta evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Fentanyl + Morfina (ya existe - COMPATIBLE)

            // ========== MIDAZOLAM ==========
            
            // Midazolam + Cordarone IV
            [
                'medication_1_id' => $midazolamId,
                'medication_2_id' => $cordaroneIVId,
                'compatibility_type_id' => $compatibleId,
                'description' => 'Midazolam y amiodarona IV son compatibles físicamente.',
                'mechanism' => 'pH similar (midazolam 3-4, amiodarona 4.1). Sin reacción adversa.',
                'consequences' => 'Sin incompatibilidad física.',
                'recommendations' => 'Compatibles físicamente. Considerar interacción farmacocinética importante (ver interacciones farmacocinéticas - amiodarona aumenta niveles de midazolam).',
                'evidence_level' => json_encode(['level' => 'B', 'description' => 'Moderada evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Midazolam + Furosemida
            [
                'medication_1_id' => $midazolamId,
                'medication_2_id' => $furosemidaId,
                'compatibility_type_id' => $minorId,
                'description' => 'Midazolam (pH 3-4) y furosemida (pH 9) presentan incompatibilidad menor por diferencia de pH.',
                'mechanism' => 'Gran diferencia de pH. Furosemida precipita en medio ácido.',
                'consequences' => 'Turbidez o precipitación leve.',
                'recommendations' => 'Administrar en vías separadas o lavar línea con SF entre medicamentos.',
                'evidence_level' => json_encode(['level' => 'B', 'description' => 'Moderada evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Midazolam + Dopamina
            [
                'medication_1_id' => $midazolamId,
                'medication_2_id' => $dopaminaId,
                'compatibility_type_id' => $compatibleId,
                'description' => 'Midazolam y dopamina son compatibles físicamente. pH similar.',
                'mechanism' => 'Ambos ácidos (midazolam 3-4, dopamina 3-4). Sin incompatibilidad.',
                'consequences' => 'Sin consecuencias fisicoquímicas adversas.',
                'recommendations' => 'Compatibles. Pueden administrarse en la misma vía IV. Combinación común en sedación de UCI.',
                'evidence_level' => json_encode(['level' => 'A', 'description' => 'Alta evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Midazolam + Norepinefrina
            [
                'medication_1_id' => $midazolamId,
                'medication_2_id' => $norepinefrinaId,
                'compatibility_type_id' => $compatibleId,
                'description' => 'Midazolam y norepinefrina son compatibles físicamente.',
                'mechanism' => 'pH similar. Sin reacción química adversa.',
                'consequences' => 'Sin incompatibilidad física.',
                'recommendations' => 'Compatibles. Pueden administrarse en la misma vía IV.',
                'evidence_level' => json_encode(['level' => 'A', 'description' => 'Alta evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Midazolam + Omeprazol IV
            [
                'medication_1_id' => $midazolamId,
                'medication_2_id' => $omeprazolIVId,
                'compatibility_type_id' => $criticalId,
                'description' => 'Midazolam (pH 3-4) y omeprazol IV (pH 9-10) son INCOMPATIBLES por diferencia extrema de pH.',
                'mechanism' => 'Omeprazol se degrada completamente en pH ácido. Precipitación inmediata.',
                'consequences' => 'Precipitado visible inmediato. Pérdida total de actividad de omeprazol.',
                'recommendations' => 'NUNCA mezclar. Usar vías IV separadas. Omeprazol en línea exclusiva.',
                'evidence_level' => json_encode(['level' => 'A', 'description' => 'Alta evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Midazolam + Morfina (ya existe - PRECAUCIÓN)

            // ========== CORDARONE IV (Amiodarona) ==========
            
            // Cordarone IV + Furosemida
            [
                'medication_1_id' => $cordaroneIVId,
                'medication_2_id' => $furosemidaId,
                'compatibility_type_id' => $minorId,
                'description' => 'Amiodarona IV (pH 4.1) y furosemida (pH 9) presentan incompatibilidad por diferencia de pH.',
                'mechanism' => 'Gran diferencia de pH. Furosemida precipita en medio ácido.',
                'consequences' => 'Posible turbidez o precipitación.',
                'recommendations' => 'Administrar en vías IV separadas. Lavar línea con SF entre medicamentos si se usa misma vía.',
                'evidence_level' => json_encode(['level' => 'B', 'description' => 'Moderada evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Cordarone IV + Dopamina
            [
                'medication_1_id' => $cordaroneIVId,
                'medication_2_id' => $dopaminaId,
                'compatibility_type_id' => $compatibleId,
                'description' => 'Amiodarona IV y dopamina son compatibles físicamente. pH similar.',
                'mechanism' => 'pH similar (amiodarona 4.1, dopamina 3-4). Sin incompatibilidad química.',
                'consequences' => 'Sin consecuencias fisicoquímicas adversas.',
                'recommendations' => 'Compatibles. Pueden administrarse en la misma vía IV. Proteger amiodarona de la luz.',
                'evidence_level' => json_encode(['level' => 'B', 'description' => 'Moderada evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Cordarone IV + Norepinefrina
            [
                'medication_1_id' => $cordaroneIVId,
                'medication_2_id' => $norepinefrinaId,
                'compatibility_type_id' => $compatibleId,
                'description' => 'Amiodarona IV y norepinefrina son compatibles físicamente.',
                'mechanism' => 'pH compatible. Sin reacción química adversa.',
                'consequences' => 'Sin incompatibilidad física.',
                'recommendations' => 'Compatibles. Pueden administrarse en la misma vía IV. Proteger ambos de la luz.',
                'evidence_level' => json_encode(['level' => 'B', 'description' => 'Moderada evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Cordarone IV + Omeprazol IV
            [
                'medication_1_id' => $cordaroneIVId,
                'medication_2_id' => $omeprazolIVId,
                'compatibility_type_id' => $criticalId,
                'description' => 'Amiodarona IV (pH 4.1) y omeprazol IV (pH 9-10) son INCOMPATIBLES por diferencia extrema de pH.',
                'mechanism' => 'Omeprazol se degrada rápidamente en pH ácido. Diferencia de pH muy grande.',
                'consequences' => 'Degradación de omeprazol. Posible precipitación.',
                'recommendations' => 'NUNCA mezclar. Usar vías IV completamente separadas. Omeprazol requiere línea exclusiva.',
                'evidence_level' => json_encode(['level' => 'A', 'description' => 'Alta evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Cordarone IV + Morfina
            [
                'medication_1_id' => $cordaroneIVId,
                'medication_2_id' => $morfinaId,
                'compatibility_type_id' => $compatibleId,
                'description' => 'Amiodarona IV y morfina son compatibles físicamente.',
                'mechanism' => 'pH compatible (amiodarona 4.1, morfina 2.5-6.5). Sin incompatibilidad.',
                'consequences' => 'Sin consecuencias fisicoquímicas adversas.',
                'recommendations' => 'Compatibles. Pueden administrarse en la misma vía IV.',
                'evidence_level' => json_encode(['level' => 'B', 'description' => 'Moderada evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ========== FUROSEMIDA ==========
            
            // Furosemida + Dopamina (ya existe - CRÍTICA)
            // Furosemida + Omeprazol IV (ya existe - CRÍTICA)

            // Furosemida + Norepinefrina
            [
                'medication_1_id' => $furosemidaId,
                'medication_2_id' => $norepinefrinaId,
                'compatibility_type_id' => $criticalId,
                'description' => 'Furosemida (pH 9) y norepinefrina (pH 3-4.5) son ALTAMENTE incompatibles por diferencia extrema de pH.',
                'mechanism' => 'Norepinefrina se oxida e inactiva rápidamente en medio alcalino. Furosemida precipita en medio ácido.',
                'consequences' => 'Pérdida completa de actividad de norepinefrina. Posible precipitación de furosemida. Cambio de color.',
                'recommendations' => 'NUNCA mezclar. SIEMPRE usar vías IV separadas. Lavar línea con mínimo 10ml SF si se usa misma vía secuencialmente.',
                'evidence_level' => json_encode(['level' => 'A', 'description' => 'Alta evidencia - Incompatibilidad crítica']),
                'source' => 'Trissel\'s Handbook, Micromedex',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Furosemida + Morfina
            [
                'medication_1_id' => $furosemidaId,
                'medication_2_id' => $morfinaId,
                'compatibility_type_id' => $minorId,
                'description' => 'Furosemida (pH 9) y morfina (pH 2.5-6.5) presentan incompatibilidad menor por diferencia de pH.',
                'mechanism' => 'Diferencia de pH moderada a alta. Posible precipitación en altas concentraciones.',
                'consequences' => 'Posible turbidez o precipitación leve.',
                'recommendations' => 'Preferible usar vías separadas. Si se usa misma vía, lavar con SF entre medicamentos.',
                'evidence_level' => json_encode(['level' => 'B', 'description' => 'Moderada evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ========== DOPAMINA ==========
            
            // Dopamina + Norepinefrina (ya existe - COMPATIBLE)

            // Dopamina + Omeprazol IV
            [
                'medication_1_id' => $dopaminaId,
                'medication_2_id' => $omeprazolIVId,
                'compatibility_type_id' => $criticalId,
                'description' => 'Dopamina (pH 3-4) y omeprazol IV (pH 9-10) son ALTAMENTE incompatibles.',
                'mechanism' => 'Dopamina se oxida e inactiva en medio alcalino. Omeprazol se degrada en medio ácido. Diferencia extrema de pH.',
                'consequences' => 'Pérdida de actividad de ambos medicamentos. Precipitación. Cambio de color de dopamina (rosado indica oxidación).',
                'recommendations' => 'NUNCA mezclar. SIEMPRE usar vías IV separadas. Omeprazol en línea exclusiva.',
                'evidence_level' => json_encode(['level' => 'A', 'description' => 'Alta evidencia - Incompatibilidad crítica']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Dopamina + Morfina
            [
                'medication_1_id' => $dopaminaId,
                'medication_2_id' => $morfinaId,
                'compatibility_type_id' => $compatibleId,
                'description' => 'Dopamina y morfina son compatibles físicamente. pH compatible.',
                'mechanism' => 'Ambos tienen pH ácido (dopamina 3-4, morfina 2.5-6.5). Sin incompatibilidad química.',
                'consequences' => 'Sin consecuencias fisicoquímicas adversas.',
                'recommendations' => 'Compatibles. Pueden administrarse en la misma vía IV. Proteger dopamina de la luz.',
                'evidence_level' => json_encode(['level' => 'A', 'description' => 'Alta evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ========== NOREPINEFRINA ==========
            
            // Norepinefrina + Omeprazol IV
            [
                'medication_1_id' => $norepinefrinaId,
                'medication_2_id' => $omeprazolIVId,
                'compatibility_type_id' => $criticalId,
                'description' => 'Norepinefrina (pH 3-4.5) y omeprazol IV (pH 9-10) son ALTAMENTE incompatibles.',
                'mechanism' => 'Norepinefrina se oxida rápidamente en medio alcalino perdiendo actividad. Omeprazol se degrada en medio ácido. Diferencia extrema de pH.',
                'consequences' => 'Inactivación completa de norepinefrina. Cambio de color (rosado/marrón indica oxidación). Degradación de omeprazol. Precipitación posible.',
                'recommendations' => 'NUNCA mezclar. SIEMPRE usar vías IV completamente separadas. Norepinefrina preferible en DAD 5%. Omeprazol en línea exclusiva.',
                'evidence_level' => json_encode(['level' => 'A', 'description' => 'Alta evidencia - Incompatibilidad crítica']),
                'source' => 'Trissel\'s Handbook, Micromedex',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Norepinefrina + Morfina
            [
                'medication_1_id' => $norepinefrinaId,
                'medication_2_id' => $morfinaId,
                'compatibility_type_id' => $compatibleId,
                'description' => 'Norepinefrina y morfina son compatibles físicamente.',
                'mechanism' => 'pH compatible (norepinefrina 3-4.5, morfina 2.5-6.5). Sin reacción química adversa.',
                'consequences' => 'Sin incompatibilidad física.',
                'recommendations' => 'Compatibles. Pueden administrarse en la misma vía IV. Proteger norepinefrina de la luz.',
                'evidence_level' => json_encode(['level' => 'A', 'description' => 'Alta evidencia']),
                'source' => 'Trissel\'s Handbook',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ========== OMEPRAZOL IV ==========
            
            // Omeprazol IV + Morfina
            [
                'medication_1_id' => $omeprazolIVId,
                'medication_2_id' => $morfinaId,
                'compatibility_type_id' => $criticalId,
                'description' => 'Omeprazol IV (pH 9-10) y morfina (pH 2.5-6.5) son INCOMPATIBLES por diferencia extrema de pH.',
                'mechanism' => 'Omeprazol se degrada rápidamente en pH ácido. Gran diferencia de pH causa precipitación.',
                'consequences' => 'Precipitación inmediata. Pérdida total de actividad del omeprazol. Turbidez marcada.',
                'recommendations' => 'NUNCA mezclar. SIEMPRE usar vías IV separadas. Omeprazol requiere línea exclusiva y administración en 20-30 minutos.',
                'evidence_level' => json_encode(['level' => 'A', 'description' => 'Alta evidencia - Incompatibilidad crítica']),
                'source' => 'Trissel\'s Handbook, King Guide',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('physicochemical_interactions')->insert($interactions);
    }

    /**
     * Genera interacciones farmacodinámicas entre medicamentos
     * Se enfoca en los efectos de los medicamentos sobre el organismo y entre sí
     */
    private function seedPharmacodynamicInteractions($tylenolId, $perfalganId, $fentanylId, $midazolamId,
        $cordaroneId, $cordaroneIVId, $warfarinaId, $furosemidaId, $dopaminaId, $norepinefrinaId,
        $prilosecId, $omeprazolIVId, $morfinaId, $compatibleId, $precautionId, $minorId, $criticalId)
    {
        $interactions = [
            // ========== PARACETAMOL (Tylenol + Perfalgan - mismo principio activo) ==========
            
            // Tylenol + Perfalgan (DUPLICACIÓN TERAPÉUTICA)
            [
                'medication_1_id' => $tylenolId,
                'medication_2_id' => $perfalganId,
                'compatibility_type_id' => $precautionId,
                'interaction_type' => 'Duplicación Terapéutica',
                'description' => 'Ambos medicamentos contienen paracetamol. Uso simultáneo resulta en dosis acumulada con riesgo de hepatotoxicidad por sobredosis.',
                'mechanism' => 'Mismo principio activo administrado por dos vías diferentes. Los efectos se suman. Paracetamol es metabolizado en hígado y dosis >4g/día pueden causar daño hepático severo.',
                'clinical_effects' => 'Dosis acumulada elevada. Si se administran cada 6 horas: Tylenol 500mg PO + Perfalgan 1g IV = 6g/día total (excede dosis máxima). Riesgo de hepatotoxicidad aguda: náusea, vómito, dolor abdominal, elevación de transaminasas, insuficiencia hepática fulminante en casos severos.',
                'recommendations' => 'EVITAR uso simultáneo. Usar SOLO UNO de los dos. Si se requiere analgesia multimodal, combinar con otros analgésicos (AINEs, opioides). Dosis máxima de paracetamol: 4g/día (3g/día en hepatopatía, alcoholismo, desnutrición). Si se usó uno, esperar completar intervalo de dosis antes de cambiar al otro. Educar al paciente sobre automedicación.',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Alta evidencia - Riesgo conocido de hepatotoxicidad',
                    'risk_factors' => 'Alcoholismo, hepatopatía, desnutrición, ayuno prolongado, uso crónico'
                ]),
                'source' => 'FDA, guías de manejo de dolor',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Paracetamol + Warfarina
            [
                'medication_1_id' => $tylenolId,
                'medication_2_id' => $warfarinaId,
                'compatibility_type_id' => $precautionId,
                'interaction_type' => 'Potenciación',
                'description' => 'Paracetamol en dosis altas (>2g/día) por tiempo prolongado (>1 semana) puede aumentar el efecto anticoagulante de warfarina.',
                'mechanism' => 'Mecanismo no completamente esclarecido. Posible inhibición de síntesis de factores de coagulación dependientes de vitamina K o alteración del metabolismo de warfarina. El efecto es dosis y tiempo dependiente.',
                'clinical_effects' => 'Aumento leve a moderado del INR (generalmente <1 punto). Riesgo aumentado de sangrado si se usa paracetamol >2g/día por >7 días. Efecto es reversible al suspender paracetamol.',
                'recommendations' => 'Uso ocasional de paracetamol (<2g/día por <3 días) es generalmente seguro. Si se requiere uso prolongado o dosis altas: monitorear INR más frecuentemente (cada 3-5 días al inicio, luego semanal). Educar al paciente sobre no automedicarse con paracetamol sin informar. Paracetamol sigue siendo analgésico más seguro en pacientes anticoagulados (preferible a AINEs que tienen mayor riesgo). Ajustar warfarina si INR aumenta significativamente.',
                'evidence_level' => json_encode([
                    'level' => 'B',
                    'description' => 'Moderada evidencia - Estudios observacionales',
                    'dose_dependent' => 'Riesgo aumenta con dosis >2g/día y uso >7 días'
                ]),
                'source' => 'Micromedex, estudios de casos',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Paracetamol + Morfina
            [
                'medication_1_id' => $perfalganId,
                'medication_2_id' => $morfinaId,
                'compatibility_type_id' => $compatibleId,
                'interaction_type' => 'Sinergia Aditiva Beneficiosa',
                'description' => 'Paracetamol y morfina tienen mecanismos de acción diferentes y complementarios. La combinación es sinérgica para analgesia sin aumentar efectos adversos opioides significativamente.',
                'mechanism' => 'Paracetamol inhibe síntesis de prostaglandinas a nivel central. Morfina activa receptores mu-opioides. Mecanismos diferentes, efectos analgésicos se suman. Esta combinación es estrategia de analgesia multimodal estándar.',
                'clinical_effects' => 'Analgesia superior a cualquiera de los dos solos. Permite usar dosis menores de morfina (ahorro de opioides), reduciendo efectos adversos opioides (náusea, constipación, sedación, depresión respiratoria). Combinación estándar para dolor moderado a severo postoperatorio.',
                'recommendations' => 'Combinación RECOMENDADA y ampliamente usada. Administrar paracetamol 1g IV/PO cada 6-8 horas + morfina según necesidad. Esta combinación permite estrategia de opioid-sparing (reducir dosis de opioides). Continuar paracetamol programado y morfina a demanda. Excelente perfil de seguridad. Monitoreo habitual para cada medicamento.',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Alta evidencia - Práctica estándar en analgesia multimodal',
                    'guidelines' => 'Recomendado en guías de manejo de dolor postoperatorio'
                ]),
                'source' => 'WHO Pain Ladder, guías postoperatorias, Cochrane reviews',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ========== FENTANYL + MIDAZOLAM (ya existe en seeder original) ==========
            // ========== FENTANYL + MORFINA (ya existe en seeder original) ==========
            // ========== MIDAZOLAM + MORFINA (ya existe en seeder original) ==========
            // ========== AMIODARONA + WARFARINA (ya existe en seeder original) ==========
            // ========== DOPAMINA + NOREPINEFRINA (ya existe en seeder original) ==========

            // ========== NUEVAS INTERACCIONES FARMACODINÁMICAS ==========

            // Cordarone + Cordarone IV (mismo medicamento, diferente vía)
            [
                'medication_1_id' => $cordaroneId,
                'medication_2_id' => $cordaroneIVId,
                'compatibility_type_id' => $criticalId,
                'interaction_type' => 'Duplicación Terapéutica',
                'description' => 'Ambos son amiodarona. Uso simultáneo por vía oral e IV resulta en dosis acumulada excesiva con alto riesgo de toxicidad.',
                'mechanism' => 'Amiodarona tiene vida media extremadamente larga (~58 días) y se acumula en tejidos. Administración simultánea por dos vías causa sobredosis con toxicidad multiorgánica.',
                'clinical_effects' => 'Toxicidad por amiodarona: bradicardia severa, hipotensión, prolongación QT extrema (>600ms), torsades de pointes, bloqueo AV completo, disfunción tiroidea severa (hipo o hipertiroidismo), hepatotoxicidad, neumonitis intersticial, neuropatía periférica, fotosensibilidad severa, depósitos corneales.',
                'recommendations' => 'NUNCA usar ambas vías simultáneamente. Protocolo de conversión: si se inicia amiodarona IV por emergencia (arritmia aguda), suspender amiodarona oral. Si se está usando amiodarona oral crónica y se requiere dosis IV: calcular dosis considerando niveles previos. Generalmente: usar SOLO una vía a la vez. Al cambiar de IV a oral, considerar vida media larga (efecto IV persiste días). Monitoreo ECG, función tiroidea, función hepática, radiografía de tórax.',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Alta evidencia - Contraindicación absoluta de duplicación',
                    'critical' => 'Riesgo de toxicidad multiorgánica severa'
                ]),
                'source' => 'FDA, guías de cardiología, Micromedex',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Prilosec + Omeprazol IV (mismo medicamento)
            [
                'medication_1_id' => $prilosecId,
                'medication_2_id' => $omeprazolIVId,
                'compatibility_type_id' => $minorId,
                'interaction_type' => 'Duplicación Terapéutica',
                'description' => 'Ambos son omeprazol. Uso simultáneo resulta en dosis acumulada pero la toxicidad es baja comparada con otros medicamentos.',
                'mechanism' => 'Mismo principio activo por dos vías. Omeprazol inhibe bomba de protones (H+/K+ ATPasa). La inhibición es dosis-dependiente pero tiene efecto techo (máxima inhibición de ácido se alcanza con dosis moderadas).',
                'clinical_effects' => 'Supresión ácida excesiva pero generalmente bien tolerada. Posibles efectos: cefalea, diarrea, náusea, mayor riesgo de infecciones (C. difficile, neumonía), hipomagnesemia (uso prolongado), deficiencia de vitamina B12, fracturas osteoporóticas (uso muy prolongado), nefritis intersticial (raro).',
                'recommendations' => 'Evitar duplicación innecesaria. Usar SOLO una vía. Si se inició omeprazol IV por hemorragia digestiva y luego paciente tolera vía oral, cambiar a oral y suspender IV. No hay beneficio en usar ambas vías simultáneamente. Dosis máxima generalmente: 40mg/día (puede usarse 80mg/día en situaciones específicas como Zollinger-Ellison). Riesgo de toxicidad es bajo pero duplicación es innecesaria.',
                'evidence_level' => json_encode([
                    'level' => 'B',
                    'description' => 'Moderada evidencia - Bajo riesgo pero innecesario',
                    'recommendation' => 'Evitar duplicación por buena práctica'
                ]),
                'source' => 'Micromedex, guías de gastroenterología',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Fentanyl + Dopamina
            [
                'medication_1_id' => $fentanylId,
                'medication_2_id' => $dopaminaId,
                'compatibility_type_id' => $precautionId,
                'interaction_type' => 'Efecto Aditivo Cardiovascular',
                'description' => 'Fentanyl puede causar bradicardia y vasodilatación. Dopamina tiene efecto cronotrópico e inotrópico positivo. Los efectos cardiovasculares pueden ser impredecibles.',
                'mechanism' => 'Fentanyl causa bradicardia por estimulación vagal y puede causar hipotensión por liberación de histamina y vasodilatación. Dopamina en dosis medias-altas tiene efecto beta-adrenérgico (aumenta FC y contractilidad) y alfa-adrenérgico (vasoconstricción). Los efectos pueden ser antagónicos o sinérgicos según dosis y momento.',
                'clinical_effects' => 'Bradicardia inicial por fentanyl, luego taquicardia por dopamina. Hipotensión transitoria posible. En algunos pacientes: arritmias (extrasístoles ventriculares). Rigidez de pared torácica (chest wall rigidity) por fentanyl puede dificultar ventilación mecánica.',
                'recommendations' => 'Combinación frecuente y generalmente segura en UCI con monitoreo. Administrar fentanyl lentamente (evitar bolos rápidos). Monitoreo continuo: ECG, PA, FC. Tener atropina disponible si bradicardia severa. Tener midazolam o relajantes musculares disponibles si rigidez de pared torácica. Titular dopamina según respuesta hemodinámica. Generalmente se toleran bien con precauciones habituales.',
                'evidence_level' => json_encode([
                    'level' => 'B',
                    'description' => 'Moderada evidencia - Práctica común en UCI',
                    'monitoring' => 'Monitoreo hemodinámico continuo recomendado'
                ]),
                'source' => 'Guías de sedación UCI, Micromedex',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Fentanyl + Norepinefrina
            [
                'medication_1_id' => $fentanylId,
                'medication_2_id' => $norepinefrinaId,
                'compatibility_type_id' => $precautionId,
                'interaction_type' => 'Efecto Cardiovascular Complejo',
                'description' => 'Fentanyl puede causar bradicardia e hipotensión transitoria. Norepinefrina es vasopresor potente. Combinación requiere monitoreo pero es frecuente en UCI.',
                'mechanism' => 'Fentanyl causa bradicardia vagal y puede causar hipotensión por vasodilatación. Norepinefrina causa vasoconstricción potente y aumenta PA. Los efectos sobre PA pueden antagonizarse transitoriamente.',
                'clinical_effects' => 'Bradicardia inicial por fentanyl. Hipotensión transitoria posible que requiere aumentar dosis de norepinefrina temporalmente. Hipertensión si se administran simultáneamente en bolos. Arritmias posibles.',
                'recommendations' => 'Combinación muy frecuente en shock séptico con sedoanalgesia. Administrar fentanyl lentamente, nunca en bolo rápido. Monitoreo continuo: PA invasiva preferible, ECG, FC. Titular norepinefrina según respuesta. Anticipar posible aumento transitorio de requerimiento de norepinefrina al iniciar fentanyl. Generalmente bien tolerada con monitoreo adecuado.',
                'evidence_level' => json_encode([
                    'level' => 'B',
                    'description' => 'Moderada evidencia - Práctica estándar en UCI',
                    'common' => 'Combinación muy frecuente y generalmente segura'
                ]),
                'source' => 'Guías de manejo de shock, Surviving Sepsis Campaign',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Midazolam + Dopamina
            [
                'medication_1_id' => $midazolamId,
                'medication_2_id' => $dopaminaId,
                'compatibility_type_id' => $precautionId,
                'interaction_type' => 'Efecto Cardiovascular Aditivo',
                'description' => 'Midazolam causa sedación e hipotensión por vasodilatación. Dopamina tiene efecto inotrópico y vasopresor. Los efectos sobre PA pueden ser complejos.',
                'mechanism' => 'Midazolam causa vasodilatación y depresión miocárdica leve, reduciendo PA. Dopamina aumenta contractilidad y presión arterial. El efecto neto depende de dosis de cada uno.',
                'clinical_effects' => 'Hipotensión al iniciar midazolam (especialmente en bolos rápidos o pacientes hipovolémicos). Puede requerir aumento transitorio de dosis de dopamina. Bradicardia o taquicardia según dosis de dopamina. Sedación profunda puede enmascarar signos de hipoperfusión.',
                'recommendations' => 'Combinación frecuente y útil para sedación en shock. Titular midazolam lentamente, iniciar con dosis bajas (1-2mg, luego infusión 1-5mg/h). Asegurar euvolemia antes de sedar. Monitoreo continuo hemodinámico. Anticipar aumento de requerimiento de dopamina al iniciar sedación. Reducir dosis de midazolam si hipotensión severa. Generalmente segura con titulación cuidadosa.',
                'evidence_level' => json_encode([
                    'level' => 'B',
                    'description' => 'Moderada evidencia - Práctica común en UCI',
                    'titration' => 'Titulación lenta y cuidadosa recomendada'
                ]),
                'source' => 'Guías de sedación UCI',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Midazolam + Norepinefrina
            [
                'medication_1_id' => $midazolamId,
                'medication_2_id' => $norepinefrinaId,
                'compatibility_type_id' => $precautionId,
                'interaction_type' => 'Efecto Cardiovascular',
                'description' => 'Midazolam puede causar hipotensión por vasodilatación y depresión miocárdica leve. Norepinefrina es vasopresor potente que contrarresta estos efectos.',
                'mechanism' => 'Midazolam reduce tono vascular y contractilidad miocárdica levemente. Norepinefrina causa vasoconstricción intensa y efecto inotrópico. Norepinefrina puede compensar efectos hipotensores de midazolam.',
                'clinical_effects' => 'Hipotensión al iniciar midazolam, especialmente con bolos. Aumento de requerimiento de norepinefrina al sedar (10-30% más). Bradicardia posible con dosis altas de midazolam.',
                'recommendations' => 'Combinación MUY frecuente en shock séptico. Titular midazolam muy lentamente. Iniciar con 1-2mg IV, luego infusión 0.5-2mg/h. Anticipar aumento de requerimiento de norepinefrina. Mantener PAM >65mmHg. Monitoreo continuo: PA invasiva, ECG, perfusión periférica. Esta combinación es segura y estándar en UCI con monitoreo adecuado.',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Alta evidencia - Práctica estándar en UCI',
                    'guidelines' => 'Recomendado en guías de sedación y manejo de shock'
                ]),
                'source' => 'Surviving Sepsis Campaign, guías de sedación UCI',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Morfina + Dopamina
            [
                'medication_1_id' => $morfinaId,
                'medication_2_id' => $dopaminaId,
                'compatibility_type_id' => $precautionId,
                'interaction_type' => 'Efecto Cardiovascular Complejo',
                'description' => 'Morfina causa vasodilatación, liberación de histamina y puede causar hipotensión significativa. Dopamina tiene efecto inotrópico y vasopresor.',
                'mechanism' => 'Morfina causa vasodilatación venosa y arterial, libera histamina (más que fentanyl), reduce precarga y puede reducir PA significativamente. Dopamina aumenta contractilidad y PA. El efecto neto depende de dosis y estado hemodinámico del paciente.',
                'clinical_effects' => 'Hipotensión significativa al iniciar morfina (más que con fentanyl). Bradicardia por estimulación vagal. Puede requerir aumento importante de dosis de dopamina (20-50% más). Liberación de histamina puede causar: broncoespasmo (en asmáticos), prurito, eritema.',
                'recommendations' => 'Usar con precaución en shock. PREFERIR fentanyl sobre morfina en pacientes inestables hemodinámicamente. Si se usa morfina: titular MUY lentamente (1-2mg cada 5-10min), diluir y administrar lento. Asegurar euvolemia. Monitoreo continuo hemodinámico. Tener difenhidramina disponible si liberación de histamina severa. Anticipar aumento significativo de dopamina. Considerar cambiar a fentanyl si hipotensión refractaria.',
                'evidence_level' => json_encode([
                    'level' => 'B',
                    'description' => 'Moderada evidencia',
                    'preference' => 'Fentanyl preferible en pacientes inestables'
                ]),
                'source' => 'Guías de sedoanalgesia, Micromedex',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Morfina + Norepinefrina
            [
                'medication_1_id' => $morfinaId,
                'medication_2_id' => $norepinefrinaId,
                'compatibility_type_id' => $precautionId,
                'interaction_type' => 'Efecto Cardiovascular',
                'description' => 'Morfina causa vasodilatación e hipotensión. Norepinefrina contrarresta con vasoconstricción potente. Combinación requiere titulación cuidadosa.',
                'mechanism' => 'Morfina causa vasodilatación y liberación de histamina, reduciendo significativamente PA. Norepinefrina causa vasoconstricción potente. Los efectos se antagonizan parcialmente.',
                'clinical_effects' => 'Hipotensión al iniciar morfina. Aumento significativo de requerimiento de norepinefrina (puede duplicarse transitoriamente). Bradicardia. Broncoespasmo posible en asmáticos.',
                'recommendations' => 'Combinación frecuente pero morfina NO es primera elección en shock (preferir fentanyl). Si se usa: titular morfina MUY lentamente. Dosis pequeñas (1-2mg IV cada 10-15min). Anticipar aumento importante de norepinefrina. Monitoreo continuo: PA invasiva, ECG. Tener efedrina o fenilefrina disponible como rescue. Considerar fentanyl como alternativa más segura en inestabilidad hemodinámica.',
                'evidence_level' => json_encode([
                    'level' => 'B',
                    'description' => 'Moderada evidencia',
                    'recommendation' => 'Fentanyl es opioide de elección en shock'
                ]),
                'source' => 'Guías de manejo de shock, Surviving Sepsis',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Furosemida + Dopamina (farmacodinámica)
            [
                'medication_1_id' => $furosemidaId,
                'medication_2_id' => $dopaminaId,
                'compatibility_type_id' => $compatibleId,
                'interaction_type' => 'Efecto Complementario',
                'description' => 'Furosemida (diurético) y dopamina en dosis bajas (efecto renal) pueden tener efecto complementario sobre diuresis. Sin embargo, concepto de "dosis renal" de dopamina está en desuso.',
                'mechanism' => 'Furosemida inhibe reabsorción de sodio en asa de Henle, aumentando diuresis. Dopamina en dosis bajas (2-5mcg/kg/min) causa vasodilatación renal aumentando flujo renal. Efectos son complementarios pero dopamina NO protege función renal (mito desacreditado).',
                'clinical_effects' => 'Aumento de diuresis. Riesgo de depleción de volumen si diuresis excesiva. Hipotensión. Alteraciones electrolíticas (hipopotasemia, hipomagnesemia, hiponatremia). Ototoxicidad con dosis altas de furosemida.',
                'recommendations' => 'Combinación aceptable pero NO usar "dosis renal" de dopamina (este concepto está desacreditado - no previene insuficiencia renal). Si se usa dopamina, es por efecto hemodinámico (dosis >5mcg/kg/min), no por "protección renal". Furosemida es el diurético principal. Monitoreo: balance hídrico estricto, electrolitos (K+, Mg++, Na+) cada 6-12 horas, función renal (creatinina, BUN), presión arterial. Reponer electrolitos según necesidad. Evitar depleción de volumen excesiva.',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Alta evidencia - Mito de dosis renal desacreditado',
                    'myth' => 'Dopamina NO previene insuficiencia renal aguda'
                ]),
                'source' => 'Kidney Disease: Improving Global Outcomes (KDIGO), Surviving Sepsis',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Furosemida + Norepinefrina
            [
                'medication_1_id' => $furosemidaId,
                'medication_2_id' => $norepinefrinaId,
                'compatibility_type_id' => $precautionId,
                'interaction_type' => 'Efecto Cardiovascular Antagónico',
                'description' => 'Furosemida causa diuresis y puede reducir precarga. Norepinefrina aumenta PA por vasoconstricción. Furosemida puede antagonizar parcialmente efecto de norepinefrina por reducción de volumen.',
                'mechanism' => 'Furosemida aumenta excreción de sodio y agua, reduciendo volumen intravascular y precarga. Esto puede reducir gasto cardíaco. Norepinefrina aumenta PA por vasoconstricción y efecto inotrópico. La reducción de precarga por furosemida puede requerir mayor dosis de norepinefrina.',
                'clinical_effects' => 'Hipotensión si diuresis excesiva. Aumento de requerimiento de norepinefrina con cada dosis de furosemida. Hipoperfusión renal si PAM <65mmHg. Alteraciones electrolíticas (hipopotasemia aumenta riesgo de arritmias). Alcalosis metabólica.',
                'recommendations' => 'Combinación frecuente en shock con sobrecarga de volumen. Administrar furosemida cuando PAM >65mmHg y paciente euvolémico o hipervolémico. Evitar diuresis excesiva (objetivo: balance negativo 500-1000ml/día, no más). Monitoreo continuo: PA, balance hídrico horario, electrolitos cada 6-12h, lactato, diuresis. Reponer potasio agresivamente (mantener K+ >4 mEq/L para prevenir arritmias). Titular norepinefrina según respuesta. Si hipotensión severa post-furosemida, dar bolo de cristaloides 250-500ml.',
                'evidence_level' => json_encode([
                    'level' => 'B',
                    'description' => 'Moderada evidencia',
                    'practice' => 'Práctica común en UCI - requiere monitoreo estrecho'
                ]),
                'source' => 'Surviving Sepsis Campaign, guías de manejo de fluidos',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Omeprazol + Warfarina (farmacodinámica leve)
            [
                'medication_1_id' => $prilosecId,
                'medication_2_id' => $warfarinaId,
                'compatibility_type_id' => $compatibleId,
                'interaction_type' => 'Sin Interacción Farmacodinámica Significativa',
                'description' => 'Omeprazol y warfarina no tienen interacción farmacodinámica directa. La interacción principal es farmacocinética (ver interacciones farmacocinéticas). Desde perspectiva farmacodinámica, omeprazol no afecta coagulación.',
                'mechanism' => 'Omeprazol inhibe bomba de protones gástrica. Warfarina inhibe síntesis de factores de coagulación dependientes de vitamina K. Mecanismos completamente diferentes sin interacción directa sobre coagulación.',
                'clinical_effects' => 'No hay efectos farmacodinámicos aditivos o antagónicos. La interacción importante es farmacocinética (omeprazol puede aumentar leve a moderadamente el INR por inhibición de metabolismo).',
                'recommendations' => 'Desde perspectiva farmacodinámica, es combinación segura. Omeprazol es IBP de elección en pacientes anticoagulados que requieren gastroprotección. Beneficio: reduce riesgo de sangrado gastrointestinal en pacientes anticoagulados. Monitorear INR por interacción farmacocinética (ver sección correspondiente), no por interacción farmacodinámica.',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Alta evidencia - Sin interacción farmacodinámica',
                    'note' => 'Interacción es farmacocinética, no farmacodinámica'
                ]),
                'source' => 'Guías de anticoagulación, gastroprotección',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('pharmacodynamic_interactions')->insert($interactions);
    }

    /**
     * Genera interacciones farmacocinéticas entre medicamentos
     * Se enfoca en los efectos sobre la absorción, distribución, metabolismo y excreción
     */
    private function seedPharmacokineticInteractions($tylenolId, $perfalganId, $fentanylId, $midazolamId,
        $cordaroneId, $warfarinaId, $furosemidaId, $dopaminaId, $prilosecId, $morfinaId, $compatibleId, $precautionId)
    {
        $interactions = [
            // ========== AMIODARONA → WARFARINA (ya existe en seeder original) ==========
            // ========== OMEPRAZOL → WARFARINA (ya existe en seeder original) ==========
            // ========== OMEPRAZOL → MIDAZOLAM (ya existe en seeder original) ==========
            // ========== AMIODARONA → MIDAZOLAM (ya existe en seeder original) ==========
            // ========== AMIODARONA → FENTANYL (ya existe en seeder original) ==========

            // ========== NUEVAS INTERACCIONES FARMACOCINÉTICAS ==========

            // Amiodarona → Morfina
            [
                'medication_1_id' => $morfinaId, // AFECTADO
                'medication_2_id' => $cordaroneId, // CAUSANTE
                'compatibility_type_id' => $compatibleId,
                'process_affected' => 'Metabolismo',
                'description' => 'Amiodarona tiene interacción mínima con morfina. Morfina es metabolizada principalmente por glucuronidación (UGT2B7), no por CYP450, por lo que amiodarona (inhibidor de CYP) tiene poco efecto.',
                'mechanism' => 'Morfina se metaboliza por conjugación con ácido glucurónico (glucuronidación) en hígado, formando morfina-3-glucurónido y morfina-6-glucurónido. Este proceso es catalizado por UGT2B7, NO por sistema CYP450. Amiodarona inhibe CYP3A4, CYP2C9, CYP2D6 pero NO afecta significativamente glucuronidación.',
                'clinical_effects' => 'Sin cambio clínicamente significativo en niveles de morfina. Efecto analgésico no se altera. Farmacocinética de morfina permanece esencialmente igual.',
                'recommendations' => 'No se requiere ajuste de dosis de morfina cuando se usa con amiodarona. Usar dosis habituales. Monitoreo clínico habitual (analgesia, efectos adversos) es suficiente. Esta interacción farmacocinética es de mínima relevancia clínica.',
                'evidence_level' => json_encode([
                    'level' => 'B',
                    'description' => 'Moderada evidencia - Interacción no significativa',
                    'mechanism' => 'Morfina no metabolizada por CYP450'
                ]),
                'source' => 'Micromedex, estudios farmacocinéticos',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Omeprazol → Morfina
            [
                'medication_1_id' => $morfinaId, // AFECTADO
                'medication_2_id' => $prilosecId, // CAUSANTE
                'compatibility_type_id' => $compatibleId,
                'process_affected' => 'Metabolismo',
                'description' => 'Omeprazol no tiene interacción farmacocinética significativa con morfina. Morfina se metaboliza por glucuronidación, no por CYP450.',
                'mechanism' => 'Morfina se metaboliza por UGT2B7 (glucuronidación). Omeprazol inhibe CYP2C19 y CYP3A4 levemente, pero NO afecta glucuronidación. Sin interacción farmacocinética relevante.',
                'clinical_effects' => 'Sin cambio en niveles de morfina. Efecto analgésico no se altera.',
                'recommendations' => 'No requiere ajuste de dosis. Combinación segura desde perspectiva farmacocinética. De hecho, combinación beneficiosa: omeprazol reduce riesgo de úlcera por estrés en pacientes críticos que reciben opioides.',
                'evidence_level' => json_encode([
                    'level' => 'B',
                    'description' => 'Moderada evidencia - Sin interacción significativa'
                ]),
                'source' => 'Micromedex',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Omeprazol → Fentanyl
            [
                'medication_1_id' => $fentanylId, // AFECTADO
                'medication_2_id' => $prilosecId, // CAUSANTE
                'compatibility_type_id' => $compatibleId,
                'process_affected' => 'Metabolismo',
                'description' => 'Omeprazol tiene interacción mínima con fentanyl. Omeprazol es inhibidor débil de CYP3A4, que metaboliza fentanyl, pero el efecto clínico es mínimo.',
                'mechanism' => 'Fentanyl es sustrato de CYP3A4. Omeprazol tiene efecto inhibitorio débil sobre CYP3A4 (<20% de inhibición). El aumento de niveles de fentanyl es mínimo (<15%).',
                'clinical_effects' => 'Aumento mínimo y clínicamente no significativo de niveles de fentanyl. Efecto analgésico puede prolongarse levemente (minutos adicionales) pero generalmente imperceptible.',
                'recommendations' => 'No se requiere ajuste de dosis de fentanyl. Interacción de baja relevancia clínica. Monitoreo clínico habitual es suficiente. Mucho menor que con inhibidores potentes de CYP3A4 (ketoconazol, ritonavir).',
                'evidence_level' => json_encode([
                    'level' => 'B',
                    'description' => 'Moderada evidencia - Interacción mínima',
                    'magnitude' => 'Aumento <15% en niveles'
                ]),
                'source' => 'Micromedex, estudios farmacocinéticos',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Warfarina → otros medicamentos (Warfarina como causante es raro)
            // En general warfarina es AFECTADO, no causante. No tiene efecto inhibidor/inductor relevante.

            // Paracetamol como causante (interacciones son raras)
            [
                'medication_1_id' => $warfarinaId, // AFECTADO
                'medication_2_id' => $tylenolId, // CAUSANTE
                'compatibility_type_id' => $precautionId,
                'process_affected' => 'Metabolismo',
                'description' => 'Paracetamol en dosis altas y uso prolongado puede aumentar efecto de warfarina. Mecanismo farmacocinético no está completamente aclarado pero puede involucrar inhibición leve de síntesis de factores de coagulación o interferencia con metabolismo de warfarina.',
                'mechanism' => 'Mecanismo no completamente entendido. Posibles explicaciones: 1) Paracetamol en dosis altas puede inhibir levemente enzimas que metabolizan warfarina (CYP2C9). 2) Efecto sobre síntesis de factores de coagulación dependientes de vitamina K. 3) Competencia por sitios de metabolismo hepático. El efecto es dosis y tiempo dependiente.',
                'clinical_effects' => 'Aumento leve del INR (típicamente <1 punto) con uso de paracetamol >2g/día por >1 semana. Aumento del riesgo de sangrado es pequeño pero real. El efecto es reversible al suspender paracetamol.',
                'recommendations' => 'Dosis ocasionales de paracetamol (<2g/día, <3 días) son seguras. Si se requiere uso prolongado o dosis altas: monitorear INR más frecuentemente (cada 3-5 días inicialmente). Educar al paciente sobre informar uso de paracetamol. Ajustar warfarina si INR aumenta >0.5 del objetivo. Paracetamol sigue siendo analgésico MÁS SEGURO en pacientes anticoagulados (mucho más seguro que AINEs).',
                'evidence_level' => json_encode([
                    'level' => 'B',
                    'description' => 'Moderada evidencia - Estudios observacionales',
                    'dose_dependent' => 'Efecto aumenta con dosis >2g/día y uso >7 días',
                    'recommendation' => 'Paracetamol sigue siendo analgésico de elección en anticoagulados'
                ]),
                'source' => 'Estudios de cohorte, Micromedex, meta-análisis',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Furosemida interacciones farmacocinéticas (pocas significativas)
            [
                'medication_1_id' => $furosemidaId, // Información general
                'medication_2_id' => $furosemidaId, // Mismo para referencia
                'compatibility_type_id' => $compatibleId,
                'process_affected' => 'Excreción',
                'description' => 'Furosemida se excreta principalmente sin cambios por riñón (65%) y algo por vía biliar. Tiene pocas interacciones farmacocinéticas significativas como causante. Es más frecuentemente AFECTADA por otros medicamentos que afectan función renal.',
                'mechanism' => 'Furosemida no inhibe ni induce enzimas CYP450 significativamente. Su eliminación es principalmente renal por secreción tubular activa. AINEs pueden reducir efecto de furosemida compitiendo por secreción tubular, pero en este sistema no hay AINEs.',
                'clinical_effects' => 'Furosemida raramente causa interacciones farmacocinéticas con los medicamentos en este sistema. Su efecto principal es farmacológico (diuresis, alteraciones electrolíticas) más que farmacocinético.',
                'recommendations' => 'Desde perspectiva farmacocinética, furosemida tiene bajo potencial de interacciones. Las interacciones importantes son farmacodinámicas (ver sección correspondiente). Monitoreo principal: electrolitos, función renal, balance hídrico, no niveles de otros medicamentos.',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Conocimiento farmacológico establecido',
                    'note' => 'Información de referencia - bajo potencial de interacciones farmacocinéticas'
                ]),
                'source' => 'Farmacología clínica, Micromedex',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Dopamina y Norepinefrina (no tienen interacciones farmacocinéticas significativas)
            [
                'medication_1_id' => $dopaminaId, // Información general
                'medication_2_id' => $dopaminaId, // Mismo para referencia
                'compatibility_type_id' => $compatibleId,
                'process_affected' => 'Metabolismo',
                'description' => 'Dopamina y norepinefrina son catecolaminas que se metabolizan rápidamente por MAO (monoamino oxidasa) y COMT (catecol-O-metiltransferasa). No tienen interacciones farmacocinéticas significativas con otros medicamentos del sistema. No inhiben ni inducen CYP450.',
                'mechanism' => 'Catecolaminas se metabolizan por: 1) MAO (monoamino oxidasa) mitocondrial. 2) COMT (catecol-O-metiltransferasa) citosólica. Estos sistemas son independientes de CYP450. Dopamina y norepinefrina no afectan metabolismo de otros medicamentos.',
                'clinical_effects' => 'Sin interacciones farmacocinéticas relevantes con medicamentos del sistema. Las interacciones importantes son farmacodinámicas (efectos cardiovasculares).',
                'recommendations' => 'No se requieren ajustes de dosis por interacciones farmacocinéticas. Monitoreo hemodinámico por efectos farmacológicos, no por alteración de niveles de otros medicamentos. Nota: IMAO (inhibidores de MAO) SÍ interactúan con catecolaminas pero no hay IMAOs en este sistema.',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Conocimiento farmacológico establecido',
                    'note' => 'Información de referencia - sin interacciones farmacocinéticas significativas'
                ]),
                'source' => 'Farmacología de catecolaminas',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Midazolam → Morfina (inverso al que ya existe)
            [
                'medication_1_id' => $morfinaId, // AFECTADO
                'medication_2_id' => $midazolamId, // CAUSANTE
                'compatibility_type_id' => $compatibleId,
                'process_affected' => 'Metabolismo',
                'description' => 'Midazolam no tiene efecto sobre el metabolismo de morfina. Midazolam no inhibe ni induce UGT2B7 (enzima que metaboliza morfina).',
                'mechanism' => 'Midazolam es metabolizado por CYP3A4. Morfina es metabolizada por UGT2B7 (glucuronidación). Son vías metabólicas completamente diferentes. Midazolam no afecta actividad de UGT2B7.',
                'clinical_effects' => 'Sin cambio en niveles de morfina. Sin alteración de efecto analgésico desde perspectiva farmacocinética. La interacción importante entre estos medicamentos es farmacodinámica (depresión respiratoria aditiva).',
                'recommendations' => 'No requiere ajuste de dosis por interacción farmacocinética. La precaución con esta combinación es por interacción farmacodinámica (ver sección correspondiente - depresión respiratoria).',
                'evidence_level' => json_encode([
                    'level' => 'B',
                    'description' => 'Moderada evidencia - Sin interacción farmacocinética',
                    'note' => 'Interacción principal es farmacodinámica'
                ]),
                'source' => 'Micromedex',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Fentanyl → Midazolam (inverso - fentanyl como causante)
            [
                'medication_1_id' => $midazolamId, // AFECTADO
                'medication_2_id' => $fentanylId, // CAUSANTE
                'compatibility_type_id' => $compatibleId,
                'process_affected' => 'Metabolismo',
                'description' => 'Fentanyl no tiene efecto inhibidor ni inductor sobre CYP3A4, por lo que no altera el metabolismo de midazolam significativamente.',
                'mechanism' => 'Fentanyl es sustrato de CYP3A4 pero NO es inhibidor ni inductor de esta enzima. Midazolam también es metabolizado por CYP3A4. Como fentanyl no afecta la actividad de CYP3A4, no altera metabolismo de midazolam.',
                'clinical_effects' => 'Sin cambio en niveles de midazolam por presencia de fentanyl. Sedación no se prolonga por razones farmacocinéticas. La interacción relevante es farmacodinámica (depresión SNC aditiva).',
                'recommendations' => 'No requiere ajuste de dosis por interacción farmacocinética. Monitoreo es por efectos farmacológicos (sedación, depresión respiratoria), no por alteración de niveles.',
                'evidence_level' => json_encode([
                    'level' => 'B',
                    'description' => 'Moderada evidencia - Sin interacción farmacocinética significativa'
                ]),
                'source' => 'Micromedex, estudios farmacocinéticos',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Paracetamol → Morfina, Fentanyl, Midazolam (paracetamol como causante - no hay interacciones)
            [
                'medication_1_id' => $fentanylId, // Ejemplo - aplica para todos los opioides/benzos
                'medication_2_id' => $perfalganId, // CAUSANTE
                'compatibility_type_id' => $compatibleId,
                'process_affected' => 'Metabolismo',
                'description' => 'Paracetamol no tiene interacciones farmacocinéticas significativas con fentanyl, morfina o midazolam. No inhibe ni induce CYP450 o UGT en dosis terapéuticas.',
                'mechanism' => 'Paracetamol es metabolizado principalmente por glucuronidación y sulfatación. En dosis terapéuticas NO inhibe ni induce enzimas CYP450. Una pequeña fracción (<10%) se metaboliza por CYP2E1 formando NAPQI (metabolito tóxico), pero esto no afecta otros medicamentos.',
                'clinical_effects' => 'Sin cambio en niveles de opioides o benzodiacepinas. Paracetamol no altera farmacocinética de sedantes o analgésicos.',
                'recommendations' => 'Paracetamol puede combinarse libremente con opioides y benzodiacepinas desde perspectiva farmacocinética. De hecho, es estrategia recomendada de analgesia multimodal. No requiere ajuste de dosis de ningún medicamento. Beneficio: permite reducir dosis de opioides (opioid-sparing).',
                'evidence_level' => json_encode([
                    'level' => 'A',
                    'description' => 'Alta evidencia - Sin interacciones farmacocinéticas',
                    'recommendation' => 'Combinación recomendada en analgesia multimodal'
                ]),
                'source' => 'Guías de manejo de dolor, Micromedex',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('pharmacokinetic_interactions')->insert($interactions);
    }
}
