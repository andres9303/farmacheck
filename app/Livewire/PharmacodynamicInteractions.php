<?php

namespace App\Livewire;

use App\Models\PharmacodynamicInteraction;
use App\Models\Medication;
use App\Models\CompatibilityType;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class PharmacodynamicInteractions extends Component
{
    use WithPagination;

    /**
     * Variables de estado del componente
     * Almacenan los datos del formulario y el estado de la interfaz
     */
    public $medication1_id, $medication2_id, $compatibility_type_id, $interaction_type, $description, $mechanism, $clinical_effects, $recommendations, $is_active = true;
    public $pharmacodynamic_interaction_id;
    public $search = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $confirmingDelete = false;

    /**
     * Reglas de validación para los campos del formulario
     */
    protected $rules = [
        'medication1_id' => 'required|exists:medications,id|different:medication2_id',
        'medication2_id' => 'required|exists:medications,id|different:medication1_id',
        'compatibility_type_id' => 'required|exists:compatibility_types,id',
        'interaction_type' => 'required|string|max:100',
        'description' => 'nullable|string|max:1000',
        'mechanism' => 'nullable|string|max:1000',
        'clinical_effects' => 'nullable|string|max:1000',
        'recommendations' => 'nullable|string|max:1000',
        'is_active' => 'boolean',
    ];

    /**
     * Mensajes de validación personalizados en español
     */
    protected $messages = [
        'medication1_id.required' => 'El primer medicamento es obligatorio.',
        'medication1_id.exists' => 'El primer medicamento seleccionado no es válido.',
        'medication1_id.different' => 'Los medicamentos deben ser diferentes.',
        'medication2_id.required' => 'El segundo medicamento es obligatorio.',
        'medication2_id.exists' => 'El segundo medicamento seleccionado no es válido.',
        'medication2_id.different' => 'Los medicamentos deben ser diferentes.',
        'compatibility_type_id.required' => 'El tipo de compatibilidad es obligatorio.',
        'compatibility_type_id.exists' => 'El tipo de compatibilidad seleccionado no es válido.',
    ];

    /**
     * Reinicia los errores de validación al actualizar propiedades
     * Proporciona validación en tiempo real mientras el usuario escribe
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     * Abre el modal para crear o editar interacciones farmacodinámicas
     * Limpia los campos y reinicia la validación
     */
    public function openModal()
    {
        $this->resetValidation();
        $this->resetInputFields();
        $this->showModal = true;
    }

    /**
     * Cierra el modal y reinicia los campos del formulario
     */
    public function closeModal()
    {
        $this->showModal = false;
        $this->resetInputFields();
    }

    /**
     * Reinicia todos los campos del formulario a sus valores por defecto
     * Método privado para uso interno del componente
     */
    private function resetInputFields()
    {
        $this->medication1_id = '';
        $this->medication2_id = '';
        $this->compatibility_type_id = '';
        $this->interaction_type = '';
        $this->description = '';
        $this->mechanism = '';
        $this->clinical_effects = '';
        $this->recommendations = '';
        $this->is_active = true;
        $this->pharmacodynamic_interaction_id = null;
    }

    /**
     * Guarda o actualiza una interacción farmacodinámica en la base de datos
     * Utiliza el método updateOrCreate para crear o editar según corresponda
     */
    public function store()
    {
        $this->validate();

        PharmacodynamicInteraction::updateOrCreate(['id' => $this->pharmacodynamic_interaction_id], [
            'medication_1_id' => $this->medication1_id,
            'medication_2_id' => $this->medication2_id,
            'compatibility_type_id' => $this->compatibility_type_id,
            'interaction_type' => $this->interaction_type,
            'description' => $this->description,
            'mechanism' => $this->mechanism,
            'clinical_effects' => $this->clinical_effects,
            'recommendations' => $this->recommendations,
            'is_active' => $this->is_active,
        ]);

        $this->closeModal();
        $message = $this->pharmacodynamic_interaction_id ? 'Interacción farmacodinámica actualizada correctamente.' : 'Interacción farmacodinámica creada correctamente.';
        $this->dispatch('notify', message: $message);
    }

    /**
     * Carga los datos de una interacción farmacodinámica para editar
     * Busca el registro y llena los campos del formulario
     */
    public function edit($id)
    {
        $pharmacodynamicInteraction = PharmacodynamicInteraction::findOrFail($id);
        $this->pharmacodynamic_interaction_id = $id;
        $this->medication1_id = $pharmacodynamicInteraction->medication_1_id;
        $this->medication2_id = $pharmacodynamicInteraction->medication_2_id;
        $this->compatibility_type_id = $pharmacodynamicInteraction->compatibility_type_id;
        $this->interaction_type = $pharmacodynamicInteraction->interaction_type;
        $this->description = $pharmacodynamicInteraction->description;
        $this->mechanism = $pharmacodynamicInteraction->mechanism;
        $this->clinical_effects = $pharmacodynamicInteraction->clinical_effects;
        $this->recommendations = $pharmacodynamicInteraction->recommendations;
        $this->is_active = $pharmacodynamicInteraction->is_active;
        
        $this->showModal = true;
    }

    /**
     * Confirma la eliminación de una interacción farmacodinámica
     * Muestra el modal de confirmación de eliminación
     */
    public function confirmDelete($id)
    {
        $this->pharmacodynamic_interaction_id = $id;
        $this->confirmingDelete = true;
        $this->showDeleteModal = true;
    }

    /**
     * Cancela la eliminación y cierra el modal de confirmación
     */
    public function cancelDelete()
    {
        $this->confirmingDelete = false;
        $this->showDeleteModal = false;
        $this->pharmacodynamic_interaction_id = null;
    }

    /**
     * Cambia el estado a inactivo en lugar de eliminar
     * Busca el registro por ID y cambia su estado a inactivo
     */
    public function delete()
    {
        $pharmacodynamicInteraction = PharmacodynamicInteraction::find($this->pharmacodynamic_interaction_id);
        $pharmacodynamicInteraction->is_active = false;
        $pharmacodynamicInteraction->save();
        
        $this->cancelDelete();
        $this->dispatch('notify', message: 'Interacción farmacodinámica desactivada correctamente.');
    }

    /**
     * Cambia el estado activo/inactivo de una interacción farmacodinámica
     * Permite activar o desactivar sin eliminar el registro
     */
    public function toggleActive($id)
    {
        $pharmacodynamicInteraction = PharmacodynamicInteraction::find($id);
        $pharmacodynamicInteraction->is_active = !$pharmacodynamicInteraction->is_active;
        $pharmacodynamicInteraction->save();
        
        $status = $pharmacodynamicInteraction->is_active ? 'activada' : 'desactivada';
        $this->dispatch('notify', message: "Interacción farmacodinámica {$status} correctamente.");
    }

    /**
     * Renderiza el componente con la lista de interacciones farmacodinámicas
     * Aplica filtros de búsqueda y paginación
     */
    public function render()
    {
        $pharmacodynamicInteractions = PharmacodynamicInteraction::with(['medication1', 'medication2', 'compatibilityType'])
            ->whereHas('medication1', function ($query) {
                $query->where('commercial_name', 'like', '%' . $this->search . '%')
                      ->orWhere('generic_name', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('medication2', function ($query) {
                $query->where('commercial_name', 'like', '%' . $this->search . '%')
                      ->orWhere('generic_name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('medication_1_id')
            ->orderBy('medication_2_id')
            ->paginate(10);

        $medications = Medication::where('is_active', true)
            ->orderBy('commercial_name')
            ->get();
        $compatibilityTypes = CompatibilityType::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('livewire.pharmacodynamic-interactions', [
            'pharmacodynamicInteractions' => $pharmacodynamicInteractions,
            'medications' => $medications,
            'compatibilityTypes' => $compatibilityTypes
        ]);
    }
}
