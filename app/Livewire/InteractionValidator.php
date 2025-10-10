<?php

namespace App\Livewire;

use App\Models\Medication;
use App\Services\InteractionValidationService;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class InteractionValidator extends Component
{
    /**
     * Variables de estado del componente
     * Almacenan los datos del formulario y el estado de la interfaz
     */
    public $selectedMedications = [];
    public $validationResults = null;
    public $isLoading = false;
    public $search = '';
    public $showResults = false;
    public $validationMode = 'multiple'; // 'pair' o 'multiple'
    public $medication_1_id, $medication_2_id;
    public $showDetails = []; // Array para almacenar qué pares mostrar detalles

    /**
     * Reglas de validación para los campos del formulario
     */
    protected $rules = [
        'medication_1_id' => 'required|exists:medications,id',
        'medication_2_id' => 'required|exists:medications,id|different:medication_1_id',
    ];

    /**
     * Mensajes de validación personalizados en español
     */
    protected $messages = [
        'medication_1_id.required' => 'El primer medicamento es obligatorio.',
        'medication_1_id.exists' => 'El primer medicamento seleccionado no es válido.',
        'medication_2_id.required' => 'El segundo medicamento es obligatorio.',
        'medication_2_id.exists' => 'El segundo medicamento seleccionado no es válido.',
        'medication_2_id.different' => 'Los medicamentos deben ser diferentes.',
    ];

    /**
     * Inicializa el componente
     * Reinicia la validación al cargar el componente
     */
    public function mount()
    {
        $this->resetValidation();
    }

    /**
     * Alterna la visibilidad de los detalles para un par específico
     * Muestra u oculta los detalles de interacción para un par de medicamentos
     */
    public function toggleDetails($pairKey)
    {
        if (isset($this->showDetails[$pairKey])) {
            unset($this->showDetails[$pairKey]);
        } else {
            $this->showDetails[$pairKey] = true;
        }
    }

    /**
     * Valida un par de medicamentos
     * Utiliza el servicio de validación para verificar interacciones entre dos medicamentos
     */
    public function validatePair()
    {
        $this->validationMode = 'pair';
        $this->validate();
        
        $this->isLoading = true;
        
        $validationService = app(InteractionValidationService::class);
        $this->validationResults = $validationService->validateMedicationInteraction(
            $this->medication_1_id,
            $this->medication_2_id
        );
        
        $this->isLoading = false;
        $this->showResults = true;
    }

    /**
     * Valida múltiples medicamentos
     * Utiliza el servicio de validación para verificar interacciones entre múltiples medicamentos
     */
    public function validateMultiple()
    {
        $this->validationMode = 'multiple';
        
        if (count($this->selectedMedications) < 2) {
            $this->dispatch('notify', ['message' => 'Debe seleccionar al menos dos medicamentos.', 'type' => 'error']);
            return;
        }
        
        $this->isLoading = true;
        
        $validationService = app(InteractionValidationService::class);
        $this->validationResults = $validationService->validateMultipleMedicationInteractions(
            $this->selectedMedications
        );
        
        $this->isLoading = false;
        $this->showResults = true;
    }

    /**
     * Agrega un medicamento a la lista seleccionada
     * Verifica que el medicamento no esté ya en la lista
     */
    public function addMedication($medicationId)
    {
        if (!in_array($medicationId, $this->selectedMedications)) {
            $this->selectedMedications[] = $medicationId;
        }
    }

    /**
     * Elimina un medicamento de la lista seleccionada
     * Reindexa el array para mantener la continuidad
     */
    public function removeMedication($medicationId)
    {
        $this->selectedMedications = array_values(array_filter(
            $this->selectedMedications,
            fn($id) => $id != $medicationId
        ));
    }

    /**
     * Limpia toda la selección de medicamentos
     * Reinicia todas las variables relacionadas con la validación
     */
    public function clearSelection()
    {
        $this->selectedMedications = [];
        $this->validationResults = null;
        $this->showResults = false;
        $this->medication_1_id = null;
        $this->medication_2_id = null;
        $this->showDetails = [];
    }

    /**
     * Reinicia los resultados de validación
     * Limpia los resultados pero mantiene la selección de medicamentos
     */
    public function resetResults()
    {
        $this->validationResults = null;
        $this->showResults = false;
        $this->medication_1_id = null;
        $this->medication_2_id = null;
        $this->showDetails = [];
    }

    /**
     * Obtiene la clase CSS para el color del nivel de riesgo
     * Devuelve las clases de Tailwind CSS según el nivel de riesgo
     */
    public function getRiskLevelColorClass($riskLevel)
    {
        $colors = [
            'safe' => 'bg-green-100 text-green-800 border-green-200',
            'danger' => 'bg-red-100 text-red-800 border-red-200',
            'warning' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            'info' => 'bg-blue-100 text-blue-800 border-blue-200',
            'unknown' => 'bg-gray-100 text-gray-800 border-gray-200',
        ];
        
        return $colors[$riskLevel] ?? $colors['unknown'];
    }

    /**
     * Obtiene el icono para el nivel de riesgo
     * Devuelve las clases de FontAwesome según el nivel de riesgo
     */
    public function getRiskLevelIcon($riskLevel)
    {
        $icons = [
            'safe' => 'fas fa-check-circle',
            'danger' => 'fas fa-times-circle',
            'warning' => 'fas fa-exclamation-triangle',
            'info' => 'fas fa-info-circle',
            'unknown' => 'fas fa-question-circle',
        ];
        
        return $icons[$riskLevel] ?? $icons['unknown'];
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
            ->get();
        
        return view('livewire.interaction-validator', [
            'medications' => $medications,
            'selectedMedicationObjects' => Medication::whereIn('id', $this->selectedMedications)
                ->with(['activeIngredient', 'concentrationUnit'])
                ->get()
                ->keyBy('id'),
        ]);
    }
}