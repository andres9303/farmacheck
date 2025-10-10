<?php

namespace App\Livewire;

use App\Models\Medication;
use App\Services\InteractionValidationService;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class CompatibilityMatrix extends Component
{
    use WithPagination;

    /**
     * Variables de estado del componente
     * Almacenan los datos del formulario y el estado de la interfaz
     */
    public $selectedMedications = [];
    public $matrixData = [];
    public $search = '';
    public $showMatrix = false;
    public $matrixType = 'medications'; // 'medications' o 'active-ingredients'
    public $interactionType = 'all'; // 'all', 'physicochemical', 'pharmacodynamic', 'pharmacokinetic'
    public $limit = 10; // Límite para el tamaño de la matriz para evitar problemas de rendimiento
    public $selectedInteraction = null; // Para detalles de interacción en modal

    /**
     * Inicializa el componente
     * Reinicia las variables al cargar el componente
     */
    public function mount()
    {
        $this->selectedMedications = [];
        $this->resetMatrix();
    }

    /**
     * Reinicia los datos de la matriz
     * Limpia todas las variables relacionadas con la matriz
     */
    public function resetMatrix()
    {
        $this->selectedMedications = [];
        $this->matrixData = [];
        $this->showMatrix = false;
        $this->selectedInteraction = null;
    }

    /**
     * Genera la matriz de compatibilidad
     * Crea una matriz visual de interacciones entre medicamentos seleccionados
     */
    public function generateMatrix()
    {
        if (count($this->selectedMedications) < 2) {
            $this->dispatch('notify', message: 'Debe seleccionar al menos dos medicamentos.', type: 'error');
            return;
        }

        if (count($this->selectedMedications) > $this->limit) {
            $this->dispatch('notify', message: "No puede seleccionar más de {$this->limit} medicamentos para la matriz.", type: 'error');
            return;
        }

        $this->showMatrix = true;
        $this->matrixData = $this->calculateMatrixData();
        
        // Depuración: Registrar los datos de la matriz para verificar si los medicamentos se cargan correctamente
        logger()->info('Matrix Data:', [
            'selectedMedications' => $this->selectedMedications,
            'medicationsInMatrix' => array_keys($this->matrixData['medications']->toArray())
        ]);
    }

    /**
     * Calcula los datos de la matriz
     * Realiza validaciones de interacciones entre todos los medicamentos seleccionados
     */
    private function calculateMatrixData()
    {
        $medications = Medication::whereIn('id', $this->selectedMedications)
            ->with(['activeIngredient', 'concentrationUnit'])
            ->get()
            ->keyBy('id');

        $matrix = [];
        $validationService = app(InteractionValidationService::class);

        // Inicializar matriz
        foreach ($this->selectedMedications as $medicationId) {
            $matrix[$medicationId] = [];
            foreach ($this->selectedMedications as $otherMedicationId) {
                if ($medicationId == $otherMedicationId) {
                    $matrix[$medicationId][$otherMedicationId] = [
                        'type' => 'self',
                        'color' => '#E5E7EB',
                        'label' => '-',
                        'interactions' => []
                    ];
                } else {
                    $matrix[$medicationId][$otherMedicationId] = [
                        'type' => 'empty',
                        'color' => '#E5E7EB',
                        'label' => '?',
                        'interactions' => []
                    ];
                }
            }
        }

        // Llenar matriz con datos de interacciones
        for ($i = 0; $i < count($this->selectedMedications); $i++) {
            for ($j = $i + 1; $j < count($this->selectedMedications); $j++) {
                $medicationId1 = $this->selectedMedications[$i];
                $medicationId2 = $this->selectedMedications[$j];

                $validationResult = $validationService->validateMedicationInteraction(
                    $medicationId1,
                    $medicationId2
                );

                // Depuración: Registrar resultado de validación
                logger()->info('Validation result for medications', [
                    'medicationId1' => $medicationId1,
                    'medicationId2' => $medicationId2,
                    'status' => $validationResult['status'],
                    'riskLevel' => $validationResult['overall_risk_level']['level'] ?? 'unknown',
                    'hasInteractions' => $this->hasAnyInteractions($validationResult['interactions'] ?? [])
                ]);

                if ($validationResult['status'] === 'success') {
                    $riskLevel = $validationResult['overall_risk_level']['level'];
                    $filteredInteractions = $this->filterInteractions($validationResult['interactions']);
                    
                    // Siempre mostrar la interacción, incluso si no hay datos específicos
                    $matrix[$medicationId1][$medicationId2] = [
                        'type' => 'interaction',
                        'color' => $this->getRiskLevelColor($riskLevel),
                        'label' => $this->getInteractionLabel($validationResult),
                        'interactions' => $filteredInteractions,
                        'risk_level' => $riskLevel,
                        'description' => $validationResult['overall_risk_level']['description']
                    ];

                    // Reflejar la interacción en la otra dirección
                    $matrix[$medicationId2][$medicationId1] = $matrix[$medicationId1][$medicationId2];
                }
            }
        }

        return [
            'medications' => $medications,
            'matrix' => $matrix
        ];
    }

    /**
     * Obtiene la etiqueta de interacción según el nivel de riesgo
     * Devuelve un símbolo visual para cada tipo de riesgo
     */
    private function getInteractionLabel($validationResult)
    {
        $riskLevel = $validationResult['overall_risk_level']['level'];
        $labels = [
            'safe' => '✓',
            'danger' => '✗',
            'warning' => '!',
            'info' => 'i',
            'unknown' => '?'
        ];

        return $labels[$riskLevel] ?? '?';
    }

    /**
     * Filtra las interacciones según el tipo seleccionado
     * Muestra solo las interacciones del tipo seleccionado o todas
     */
    private function filterInteractions($interactions)
    {
        $allTypes = ['physicochemical', 'pharmacodynamic', 'pharmacokinetic'];
        $filteredInteractions = [];

        // Depuración: Registrar los datos de interacciones
        logger()->info('Filtering interactions', [
            'interactionType' => $this->interactionType,
            'interactionsData' => $interactions
        ]);

        foreach ($allTypes as $type) {
            if ($this->interactionType === 'all' || $this->interactionType === $type) {
                // Mantener el valor original (sea colección o false)
                $interaction = $interactions[$type] ?? false;
                
                // Si es una colección, mantenerla tal como está
                if ($interaction instanceof \Illuminate\Support\Collection) {
                    $filteredInteractions[$type] = $interaction;
                } else {
                    // Si es false o cualquier otro valor, convertirlo en colección vacía
                    $filteredInteractions[$type] = collect([]);
                }
                
                // Depuración: Registrar cada tipo procesado
                logger()->info('Interaction type processed', [
                    'type' => $type,
                    'count' => $filteredInteractions[$type]->count(),
                    'isCollection' => $filteredInteractions[$type] instanceof \Illuminate\Support\Collection,
                    'originalWasFalse' => $interaction === false
                ]);
            } else {
                // Si este tipo no está seleccionado, proporcionar una colección vacía
                $filteredInteractions[$type] = collect([]);
            }
        }

        return $filteredInteractions;
    }

    /**
     * Verifica si hay interacciones en los datos proporcionados
     * Devuelve true si encuentra alguna interacción en los datos
     */
    private function hasAnyInteractions($interactions): bool
    {
        if (!is_array($interactions)) {
            return false;
        }

        foreach ($interactions as $type => $interactionData) {
            if ($interactionData instanceof \Illuminate\Support\Collection && $interactionData->count() > 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Obtiene la clase CSS para el color del nivel de riesgo
     * Devuelve las clases de Tailwind CSS según el nivel de riesgo
     */
    public function getRiskLevelColorClass($riskLevel)
    {
        $colors = [
            'safe' => 'bg-green-100 text-green-800',
            'danger' => 'bg-red-100 text-red-800',
            'warning' => 'bg-yellow-100 text-yellow-800',
            'info' => 'bg-blue-100 text-blue-800',
            'unknown' => 'bg-gray-100 text-gray-800',
        ];

        return $colors[$riskLevel] ?? $colors['unknown'];
    }

    /**
     * Obtiene el color del nivel de riesgo (hexadecimal)
     * Devuelve el código de color hexadecimal según el nivel de riesgo
     */
    public function getRiskLevelColor($riskLevel)
    {
        $colors = [
            'safe' => '#10B981',      // green-500
            'danger' => '#EF4444',    // red-500
            'warning' => '#F59E0B',   // yellow-500
            'info' => '#3B82F6',      // blue-500
            'unknown' => '#6B7280',   // gray-500
        ];

        return $colors[$riskLevel] ?? $colors['unknown'];
    }

    /**
     * Obtiene los detalles de interacción para el modal
     * Recupera información completa sobre una interacción específica
     */
    public function getInteractionDetails($medicationId1, $medicationId2)
    {
        // Depuración: Registrar la solicitud
        logger()->info('Getting interaction details', [
            'medicationId1' => $medicationId1,
            'medicationId2' => $medicationId2,
            'matrixDataKeys' => array_keys($this->matrixData),
            'matrixKeys' => isset($this->matrixData['matrix']) ? array_keys($this->matrixData['matrix']) : [],
        ]);
        
        if (!isset($this->matrixData['matrix'][$medicationId1][$medicationId2])) {
            logger()->warning('Interaction cell not found', [
                'medicationId1' => $medicationId1,
                'medicationId2' => $medicationId2,
                'availableMedicationIds' => array_keys($this->matrixData['matrix'] ?? [])
            ]);
            return null;
        }

        $cell = $this->matrixData['matrix'][$medicationId1][$medicationId2];
        
        logger()->info('Interaction cell found', [
            'cellType' => $cell['type'],
            'cellData' => $cell
        ]);
        
        if ($cell['type'] !== 'interaction') {
            logger()->warning('Cell is not an interaction', [
                'cellType' => $cell['type'],
                'expectedType' => 'interaction'
            ]);
            return null;
        }

        if (!isset($this->matrixData['medications'][$medicationId1]) || !isset($this->matrixData['medications'][$medicationId2])) {
            logger()->warning('Medication not found in matrix data', [
                'medicationId1' => $medicationId1,
                'medicationId2' => $medicationId2,
                'availableMedications' => array_keys($this->matrixData['medications']->toArray())
            ]);
            return null;
        }

        $medication1 = $this->matrixData['medications'][$medicationId1];
        $medication2 = $this->matrixData['medications'][$medicationId2];

        return [
            'medication1' => $medication1,
            'medication2' => $medication2,
            'risk_level' => $cell['risk_level'],
            'description' => $cell['description'],
            'interactions' => $cell['interactions']
        ];
    }

    /**
     * Exporta la matriz a formato CSV
     * Genera un archivo descargable con los datos de la matriz
     */
    public function exportToCSV()
    {
        if (!$this->showMatrix || empty($this->matrixData)) {
            $this->dispatch('notify', message: 'No hay datos de matriz para exportar.', type: 'error');
            return;
        }

        $filename = 'compatibility_matrix_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            
            // Agregar encabezado CSV
            $header = ['Medicamento'];
            foreach ($this->selectedMedications as $medicationId) {
                $medication = $this->matrixData['medications'][$medicationId];
                $header[] = $medication->commercial_name;
            }
            fputcsv($file, $header);
            
            // Agregar datos CSV
            foreach ($this->selectedMedications as $medicationId) {
                $medication = $this->matrixData['medications'][$medicationId];
                $row = [$medication->commercial_name];
                
                foreach ($this->selectedMedications as $otherMedicationId) {
                    $cell = $this->matrixData['matrix'][$medicationId][$otherMedicationId];
                    $row[] = $cell['label'];
                }
                
                fputcsv($file, $row);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Agrega un medicamento a la lista seleccionada
     * Adiciona un medicamento si no excede el límite permitido
     */
    public function addMedication($medicationId)
    {
        if (!in_array($medicationId, $this->selectedMedications)) {
            if (count($this->selectedMedications) < $this->limit) {
                $this->selectedMedications[] = $medicationId;
                // Regenerar matriz si ya estaba visible y tenemos al menos 2 medicamentos
                if ($this->showMatrix && count($this->selectedMedications) >= 2) {
                    $this->matrixData = $this->calculateMatrixData();
                }
            } else {
                $this->dispatch('notify', ['message' => "No puede seleccionar más de {$this->limit} medicamentos.", 'type' => 'error']);
            }
        }
    }

    /**
     * Elimina un medicamento de la lista seleccionada
     * Remueve un medicamento y actualiza la matriz si es necesario
     */
    public function removeMedication($medicationId)
    {
        $this->selectedMedications = array_values(array_filter(
            $this->selectedMedications,
            fn($id) => $id != $medicationId
        ));
        
        // Si eliminamos medicamentos y quedamos con menos de 2, ocultar la matriz
        if (count($this->selectedMedications) < 2) {
            $this->showMatrix = false;
        } else if ($this->showMatrix) {
            // Regenerar matriz si ya estaba visible y aún tenemos al menos 2 medicamentos
            $this->matrixData = $this->calculateMatrixData();
        }
        
        // Forzar actualización
        $this->dispatch('refreshComponent');
    }

    /**
     * Limpia toda la selección de medicamentos
     * Reinicia todas las variables relacionadas con la matriz
     */
    public function clearSelection()
    {
        $this->selectedMedications = [];
        $this->matrixData = [];
        $this->showMatrix = false;
        $this->selectedInteraction = null;
        
        // Forzar actualización
        $this->dispatch('refreshComponent');
    }

    /**
     * Alterna la selección de medicamento (para compatibilidad con versiones anteriores)
     * Método de conveniencia que agrega o elimina según el estado actual
     */
    public function toggleMedication($medicationId)
    {
        if (in_array($medicationId, $this->selectedMedications)) {
            $this->removeMedication($medicationId);
        } else {
            $this->addMedication($medicationId);
        }
    }


    /**
     * Renderiza el componente con la lista de medicamentos
     * Aplica filtros de búsqueda y carga los medicamentos seleccionados
     */
    public function render()
    {
        $medications = Medication::where('is_active', true)
            ->where(function ($query) {
                $query->where('commercial_name', 'like', '%' . $this->search . '%')
                    ->orWhere('generic_name', 'like', '%' . $this->search . '%')
                    ->orWhereHas('activeIngredient', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->with(['activeIngredient', 'concentrationUnit'])
            ->orderBy('commercial_name')
            ->paginate(20);

        // Verificar si hay medicamentos seleccionados antes de ejecutar la consulta
        $selectedMedicationObjects = collect();
        if (is_array($this->selectedMedications) && count($this->selectedMedications) > 0) {
            $selectedMedicationObjects = Medication::whereIn('id', $this->selectedMedications)
                ->with(['activeIngredient', 'concentrationUnit'])
                ->get()
                ->keyBy('id');
        }

        return view('livewire.compatibility-matrix', [
            'medications' => $medications,
            'selectedMedicationObjects' => $selectedMedicationObjects,
        ]);
    }
}