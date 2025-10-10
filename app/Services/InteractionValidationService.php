<?php

namespace App\Services;

use App\Models\Medication;
use App\Models\PhysicochemicalInteraction;
use App\Models\PharmacodynamicInteraction;
use App\Models\PharmacokineticInteraction;
use Illuminate\Support\Collection;

/**
 * Servicio para validar interacciones entre medicamentos
 * Analiza compatibilidades fisicoquímicas, farmacodinámicas y farmacocinéticas
 */
class InteractionValidationService
{
    /**
     * Valida las interacciones entre dos medicamentos
     * Busca todos los tipos de interacciones y calcula el nivel de riesgo general
     *
     * @param int $medication_1_id ID del primer medicamento
     * @param int $medication_2_id ID del segundo medicamento
     * @return array Resultado de la validación con información detallada
     */
    public function validateMedicationInteraction(int $medication_1_id, int $medication_2_id): array
    {
        $medication_1 = Medication::find($medication_1_id);
        $medication_2 = Medication::find($medication_2_id);
        
        if (!$medication_1 || !$medication_2) {
            return [
                'status' => 'error',
                'message' => 'Uno o ambos medicamentos no encontrados.',
                'data' => []
            ];
        }

        // Obtener todas las interacciones entre los dos medicamentos
        $physicochemicalInteractions = $this->getPhysicochemicalInteractions($medication_1_id, $medication_2_id);
        $pharmacodynamicInteractions = $this->getPharmacodynamicInteractions($medication_1_id, $medication_2_id);
        $pharmacokineticInteractions = $this->getPharmacokineticInteractions($medication_1_id, $medication_2_id);
        
        // Determinar la compatibilidad general
        $overallRiskLevel = $this->calculateOverallRiskLevel(
            $physicochemicalInteractions,
            $pharmacodynamicInteractions,
            $pharmacokineticInteractions
        );

        return [
            'status' => 'success',
            'medication_1' => [
                'id' => $medication_1->id,
                'commercial_name' => $medication_1->commercial_name,
                'concentration' => $medication_1->concentration . ' ' . $medication_1->concentrationUnit->symbol,
                'active_ingredient' => $medication_1->activeIngredient->name,
            ],
            'medication_2' => [
                'id' => $medication_2->id,
                'commercial_name' => $medication_2->commercial_name,
                'concentration' => $medication_2->concentration . ' ' . $medication_2->concentrationUnit->symbol,
                'active_ingredient' => $medication_2->activeIngredient->name,
            ],
            'overall_risk_level' => $overallRiskLevel,
            'interactions' => [
                'physicochemical' => $physicochemicalInteractions,
                'pharmacodynamic' => $pharmacodynamicInteractions,
                'pharmacokinetic' => $pharmacokineticInteractions,
            ],
            'recommendations' => $this->generateRecommendations(
                $physicochemicalInteractions,
                $pharmacodynamicInteractions,
                $pharmacokineticInteractions
            )
        ];
    }

    /**
     * Obtiene las interacciones fisicoquímicas entre dos medicamentos
     * Busca en ambas direcciones (med1-med2 y med2-med1)
     *
     * @param int $medication_1_id ID del primer medicamento
     * @param int $medication_2_id ID del segundo medicamento
     * @return Collection Colección de interacciones fisicoquímicas formateadas
     */
    private function getPhysicochemicalInteractions(int $medication_1_id, int $medication_2_id): Collection
    {
        return PhysicochemicalInteraction::with('compatibilityType')
            ->where(function ($query) use ($medication_1_id, $medication_2_id) {
                $query->where('medication_1_id', $medication_1_id)
                    ->where('medication_2_id', $medication_2_id);
            })
            ->orWhere(function ($query) use ($medication_1_id, $medication_2_id) {
                $query->where('medication_1_id', $medication_2_id)
                    ->where('medication_2_id', $medication_1_id);
            })
            ->where('is_active', true)
            ->get()
            ->map(function ($interaction) {
                return [
                    'id' => $interaction->id,
                    'type' => 'Fisicoquímica',
                    'compatibility_type' => $interaction->compatibilityType->name,
                    'compatibility_color' => $interaction->compatibilityType->color,
                    'description' => $interaction->description,
                    'recommendations' => $interaction->recommendations,
                ];
            });
    }

    /**
     * Obtiene las interacciones farmacodinámicas entre dos medicamentos
     * Busca en ambas direcciones (med1-med2 y med2-med1)
     *
     * @param int $medication_1_id ID del primer medicamento
     * @param int $medication_2_id ID del segundo medicamento
     * @return Collection Colección de interacciones farmacodinámicas formateadas
     */
    private function getPharmacodynamicInteractions(int $medication_1_id, int $medication_2_id): Collection
    {
        return PharmacodynamicInteraction::with('compatibilityType')
            ->where(function ($query) use ($medication_1_id, $medication_2_id) {
                $query->where('medication_1_id', $medication_1_id)
                    ->where('medication_2_id', $medication_2_id);
            })
            ->orWhere(function ($query) use ($medication_1_id, $medication_2_id) {
                $query->where('medication_1_id', $medication_2_id)
                    ->where('medication_2_id', $medication_1_id);
            })
            ->where('is_active', true)
            ->get()
            ->map(function ($interaction) {
                return [
                    'id' => $interaction->id,
                    'type' => 'Farmacodinámica',
                    'compatibility_type' => $interaction->compatibilityType->name,
                    'compatibility_color' => $interaction->compatibilityType->color,
                    'description' => $interaction->description,
                    'mechanism' => $interaction->mechanism,
                    'clinical_significance' => $interaction->clinical_significance,
                    'recommendations' => $interaction->recommendations,
                ];
            });
    }

    /**
     * Obtiene las interacciones farmacocinéticas entre dos medicamentos
     * Busca en ambas direcciones (med1-med2 y med2-med1)
     *
     * @param int $medication_1_id ID del primer medicamento
     * @param int $medication_2_id ID del segundo medicamento
     * @return Collection Colección de interacciones farmacocinéticas formateadas
     */
    private function getPharmacokineticInteractions(int $medication_1_id, int $medication_2_id): Collection
    {
        return PharmacokineticInteraction::with('compatibilityType')
            ->where(function ($query) use ($medication_1_id, $medication_2_id) {
                $query->where('medication_1_id', $medication_1_id)
                    ->where('medication_2_id', $medication_2_id);
            })
            ->orWhere(function ($query) use ($medication_1_id, $medication_2_id) {
                $query->where('medication_1_id', $medication_2_id)
                    ->where('medication_2_id', $medication_1_id);
            })
            ->where('is_active', true)
            ->get()
            ->map(function ($interaction) {
                return [
                    'id' => $interaction->id,
                    'type' => 'Farmacocinética',
                    'compatibility_type' => $interaction->compatibilityType->name,
                    'compatibility_color' => $interaction->compatibilityType->color,
                    'description' => $interaction->description,
                    'absorption_effect' => $interaction->absorption_effect,
                    'distribution_effect' => $interaction->distribution_effect,
                    'metabolism_effect' => $interaction->metabolism_effect,
                    'excretion_effect' => $interaction->excretion_effect,
                    'clinical_significance' => $interaction->clinical_significance,
                    'recommendations' => $interaction->recommendations,
                ];
            });
    }

    /**
     * Calcula el nivel de riesgo general basado en todas las interacciones
     * Determina el nivel de riesgo más común y proporciona una evaluación general
     *
     * @param Collection $physicochemicalInteracciones Interacciones fisicoquímicas
     * @param Collection $pharmacodynamicInteracciones Interacciones farmacodinámicas
     * @param Collection $pharmacokineticInteracciones Interacciones farmacocinéticas
     * @return array Evaluación del nivel de riesgo general
     */
    private function calculateOverallRiskLevel(
        Collection $physicochemicalInteractions,
        Collection $pharmacodynamicInteractions,
        Collection $pharmacokineticInteractions
    ): array {
        $allInteractions = collect()
            ->merge($physicochemicalInteractions)
            ->merge($pharmacodynamicInteractions)
            ->merge($pharmacokineticInteractions);
        
        if ($allInteractions->isEmpty()) {
            return [
                'level' => 'unknown',
                'label' => 'Desconocido',
                'color' => '#9CA3AF',
                'description' => 'No hay información registrada sobre la compatibilidad entre estos medicamentos.'
            ];
        }

        // Contar interacciones por tipo de compatibilidad
        $compatibilityCounts = $allInteractions
            ->groupBy('compatibility_type')
            ->map(function ($group) {
                return $group->count();
            })
            ->sortDesc();
        
        // Obtener el tipo de compatibilidad más común
        $mostCommonType = $compatibilityCounts->keys()->first();
        $mostCommonColor = $allInteractions
            ->where('compatibility_type', $mostCommonType)
            ->first()['compatibility_color'];
        
        // Determinar el nivel de riesgo basado en los tipos de compatibilidad
        $riskLevels = [
            'Compatible' => 'safe',
            'Incompatible' => 'danger',
            'Incompatibilidad Menor' => 'warning',
            'Incompatibilidad Crítica' => 'danger',
            'Precaución' => 'warning',
        ];
        
        $riskLevel = $riskLevels[$mostCommonType] ?? 'unknown';
        
        $labels = [
            'safe' => 'Seguro',
            'danger' => 'Peligroso',
            'warning' => 'Precaución',
            'info' => 'Condicional',
            'unknown' => 'Desconocido',
        ];
        
        $descriptions = [
            'safe' => 'Los medicamentos son compatibles y pueden administrarse juntos.',
            'danger' => 'Los medicamentos no son compatibles y no deben administrarse juntos.',
            'warning' => 'Los medicamentos pueden interactuar y se requiere supervisión médica.',
            'info' => 'La compatibilidad depende de condiciones específicas como la concentración o la vía de administración.',
            'unknown' => 'No hay información registrada sobre la compatibilidad entre estos medicamentos.',
        ];
        
        return [
            'level' => $riskLevel,
            'label' => $labels[$riskLevel],
            'color' => $mostCommonColor,
            'description' => $descriptions[$riskLevel],
            'interaction_counts' => $compatibilityCounts->toArray(),
            'total_interactions' => $allInteractions->count()
        ];
    }

    /**
     * Genera recomendaciones basadas en todas las interacciones
     * Recopila y consolida todas las recomendaciones de las diferentes interacciones
     *
     * @param Collection $physicochemicalInteracciones Interacciones fisicoquímicas
     * @param Collection $pharmacodynamicInteracciones Interacciones farmacodinámicas
     * @param Collection $pharmacokineticInteracciones Interacciones farmacocinéticas
     * @return array Lista de recomendaciones consolidadas
     */
    private function generateRecommendations(
        Collection $physicochemicalInteractions,
        Collection $pharmacodynamicInteractions,
        Collection $pharmacokineticInteractions
    ): array {
        $allRecommendations = collect()
            ->merge($physicochemicalInteractions->pluck('recommendations'))
            ->merge($pharmacodynamicInteractions->pluck('recommendations'))
            ->merge($pharmacokineticInteractions->pluck('recommendations'))
            ->filter()
            ->unique()
            ->values()
            ->toArray();
        
        if (empty($allRecommendations)) {
            return ['No hay recomendaciones específicas para esta combinación de medicamentos.'];
        }
        
        return $allRecommendations;
    }

    /**
     * Valida las interacciones entre múltiples medicamentos
     * Analiza todas las combinaciones posibles entre los medicamentos proporcionados
     *
     * @param array $medication_ids Array de IDs de medicamentos a validar
     * @return array Resultado de la validación múltiple con información detallada
     */
    public function validateMultipleMedicationInteractions(array $medication_ids): array
    {
        $results = [];
        $medications = Medication::whereIn('id', $medication_ids)->get();
        
        if ($medications->count() !== count($medication_ids)) {
            return [
                'status' => 'error',
                'message' => 'Uno o más medicamentos no encontrados.',
                'data' => []
            ];
        }
        
        // Validar todas las combinaciones posibles
        for ($i = 0; $i < count($medication_ids); $i++) {
            for ($j = $i + 1; $j < count($medication_ids); $j++) {
                $pairKey = $medication_ids[$i] . '-' . $medication_ids[$j];
                $results[$pairKey] = $this->validateMedicationInteraction(
                    $medication_ids[$i],
                    $medication_ids[$j]
                );
            }
        }
        
        return [
            'status' => 'success',
            'medications' => $medications->map(function ($medication) {
                return [
                    'id' => $medication->id,
                    'commercial_name' => $medication->commercial_name,
                    'concentration' => $medication->concentration . ' ' . $medication->concentrationUnit->symbol,
                    'active_ingredient' => $medication->activeIngredient->name,
                ];
            })->toArray(),
            'pairwise_interactions' => $results,
            'overall_assessment' => $this->assessOverallCompatibility($results)
        ];
    }

    /**
     * Evalúa la compatibilidad general para múltiples medicamentos
     * Determina el nivel de riesgo más alto entre todas las combinaciones
     *
     * @param array $pairwiseResults Resultados de las validaciones por pares
     * @return array Evaluación de la compatibilidad general
     */
    private function assessOverallCompatibility(array $pairwiseResults): array
    {
        $riskLevels = collect($pairwiseResults)
            ->pluck('overall_risk_level.level')
            ->unique()
            ->values()
            ->toArray();
        
        // Si alguna combinación es peligrosa, la combinación general es peligrosa
        if (in_array('danger', $riskLevels)) {
            return [
                'level' => 'danger',
                'label' => 'Peligroso',
                'color' => '#EF4444',
                'description' => 'Al menos una combinación de medicamentos es peligrosa y no debe administrarse conjuntamente.'
            ];
        }
        
        // Si alguna combinación requiere precaución, la combinación general requiere precaución
        if (in_array('warning', $riskLevels)) {
            return [
                'level' => 'warning',
                'label' => 'Precaución',
                'color' => '#F59E0B',
                'description' => 'Al menos una combinación de medicamentos requiere supervisión médica.'
            ];
        }
        
        // Si todas las combinaciones son seguras o condicionales, la combinación general es segura
        if (in_array('safe', $riskLevels) || in_array('info', $riskLevels)) {
            return [
                'level' => 'safe',
                'label' => 'Seguro',
                'color' => '#10B981',
                'description' => 'Todas las combinaciones de medicamentos son compatibles o condicionalmente compatibles.'
            ];
        }
        
        // Si todas las combinaciones son desconocidas, la combinación general es desconocida
        return [
            'level' => 'unknown',
            'label' => 'Desconocido',
            'color' => '#9CA3AF',
            'description' => 'No hay información registrada sobre la compatibilidad entre estos medicamentos.'
        ];
    }
}