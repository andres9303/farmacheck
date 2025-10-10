<?php

namespace App\Http\Controllers;

use App\Services\InteractionValidationService;
use Illuminate\Http\Request;

class InteractionValidatorController extends Controller
{
    /**
     * Valida las interacciones entre medicamentos
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validate(Request $request)
    {
        $request->validate([
            'medications' => 'required|array|min:2',
            'medications.*' => 'exists:medications,id',
        ]);

        $validationService = app(InteractionValidationService::class);
        $results = $validationService->validateMultipleMedicationInteractions(
            $request->input('medications')
        );

        return response()->json([
            'interactions' => $results['status'] === 'success'
                ? $this->formatInteractions($results)
                : []
        ]);
    }

    /**
     * Formatea los resultados de las interacciones para los tests
     *
     * @param array $results
     * @return array
     */
    private function formatInteractions(array $results): array
    {
        $formatted = [];

        foreach ($results['pairwise_interactions'] as $pairKey => $interaction) {
            if ($interaction['status'] === 'success' && !empty($interaction['interactions'])) {
                foreach ($interaction['interactions'] as $type => $typeInteractions) {
                    foreach ($typeInteractions as $item) {
                        $formatted[] = [
                            'type' => $item['type'],
                            'medication1' => $interaction['medication_1']['commercial_name'],
                            'medication2' => $interaction['medication_2']['commercial_name'],
                            'compatibility' => $item['compatibility_type'],
                            'description' => $item['description'],
                            'recommendations' => $item['recommendations'],
                        ];
                    }
                }
            }
        }

        return $formatted;
    }
}
