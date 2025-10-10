<?php

namespace App\Livewire;

use App\Models\Medication;
use App\Models\ActiveIngredient;
use App\Models\AdministrationRoute;
use App\Models\ConcentrationUnit;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Medications extends Component
{
    use WithPagination;

    /**
     * Variables de estado del componente
     * Almacenan los datos del formulario y el estado de la interfaz
     */
    public $commercial_name, $generic_name, $description, $concentration, $pharmaceutical_form, $presentation, $is_active = true;
    public $active_ingredient_id, $administration_route_id, $concentration_unit_id;
    public $medication_id;
    public $search = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $confirmingDelete = false;

    /**
     * Reglas de validación para los campos del formulario
     */
    protected $rules = [
        'commercial_name' => 'required|string|max:255',
        'generic_name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'active_ingredient_id' => 'required|exists:active_ingredients,id',
        'concentration' => 'required|numeric|between:0,999999.9999',
        'concentration_unit_id' => 'required|exists:concentration_units,id',
        'administration_route_id' => 'required|exists:administration_routes,id',
        'pharmaceutical_form' => 'required|string|max:100',
        'presentation' => 'nullable|string|max:255',
        'is_active' => 'boolean',
    ];

    /**
     * Mensajes de validación personalizados en español
     */
    protected $messages = [
        'commercial_name.required' => 'El nombre comercial del medicamento es obligatorio.',
        'generic_name.required' => 'El nombre genérico del medicamento es obligatorio.',
        'active_ingredient_id.required' => 'El principio activo es obligatorio.',
        'active_ingredient_id.exists' => 'El principio activo seleccionado no es válido.',
        'concentration.required' => 'La concentración es obligatoria.',
        'concentration.numeric' => 'La concentración debe ser un valor numérico.',
        'concentration.between' => 'La concentración debe estar entre 0 y 999999.9999.',
        'concentration_unit_id.required' => 'La unidad de concentración es obligatoria.',
        'concentration_unit_id.exists' => 'La unidad de concentración seleccionada no es válida.',
        'administration_route_id.required' => 'La vía de administración es obligatoria.',
        'administration_route_id.exists' => 'La vía de administración seleccionada no es válida.',
        'pharmaceutical_form.required' => 'La forma farmacéutica es obligatoria.',
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
     * Abre el modal para crear o editar medicamentos
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
        $this->commercial_name = '';
        $this->generic_name = '';
        $this->description = '';
        $this->active_ingredient_id = '';
        $this->concentration = '';
        $this->concentration_unit_id = '';
        $this->administration_route_id = '';
        $this->pharmaceutical_form = '';
        $this->presentation = '';
        $this->is_active = true;
        $this->medication_id = null;
    }

    /**
     * Guarda o actualiza un medicamento en la base de datos
     * Utiliza el método updateOrCreate para crear o editar según corresponda
     */
    public function store()
    {
        // Adaptar las reglas de validación para el ID actual
        $this->rules['commercial_name'] = 'required|string|max:255|unique:medications,commercial_name,' . $this->medication_id;
        $this->rules['generic_name'] = 'required|string|max:255';
        $this->validate();

        Medication::updateOrCreate(['id' => $this->medication_id], [
            'commercial_name' => $this->commercial_name,
            'generic_name' => $this->generic_name,
            'active_ingredient_id' => $this->active_ingredient_id,
            'concentration' => $this->concentration,
            'concentration_unit_id' => $this->concentration_unit_id,
            'administration_route_id' => $this->administration_route_id,
            'pharmaceutical_form' => $this->pharmaceutical_form,
            'presentation' => $this->presentation,
            'is_active' => $this->is_active,
        ]);

        $this->closeModal();
        $message = $this->medication_id ? 'Medicamento actualizado correctamente.' : 'Medicamento creado correctamente.';
        $this->dispatch('notify', message: $message);
    }

    /**
     * Carga los datos de un medicamento para editar
     * Busca el registro y llena los campos del formulario
     */
    public function edit($id)
    {
        $medication = Medication::findOrFail($id);
        $this->medication_id = $id;
        $this->commercial_name = $medication->commercial_name;
        $this->generic_name = $medication->generic_name;
        $this->active_ingredient_id = $medication->active_ingredient_id;
        $this->concentration = $medication->concentration;
        $this->concentration_unit_id = $medication->concentration_unit_id;
        $this->administration_route_id = $medication->administration_route_id;
        $this->pharmaceutical_form = $medication->pharmaceutical_form;
        $this->presentation = $medication->presentation;
        $this->is_active = $medication->is_active;
        
        $this->showModal = true;
    }

    /**
     * Confirma la eliminación de un medicamento
     * Muestra el modal de confirmación de eliminación
     */
    public function confirmDelete($id)
    {
        $this->medication_id = $id;
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
        $this->medication_id = null;
    }

    /**
     * Cambia el estado a inactivo en lugar de eliminar
     * Busca el registro por ID y cambia su estado a inactivo
     */
    public function delete()
    {
        $medication = Medication::find($this->medication_id);
        $medication->is_active = false;
        $medication->save();
        
        $this->cancelDelete();
        $this->dispatch('notify', message: 'Medicamento desactivado correctamente.');
    }

    /**
     * Cambia el estado activo/inactivo de un medicamento
     * Permite activar o desactivar sin eliminar el registro
     */
    public function toggleActive($id)
    {
        $medication = Medication::find($id);
        $medication->is_active = !$medication->is_active;
        $medication->save();
        
        $status = $medication->is_active ? 'activado' : 'desactivado';
        $this->dispatch('notify', ['message' => "Medicamento {$status} correctamente."]);
    }

    /**
     * Renderiza el componente con la lista de medicamentos
     * Aplica filtros de búsqueda y paginación
     */
    public function render()
    {
        $medications = Medication::with(['activeIngredient', 'administrationRoute', 'concentrationUnit'])
            ->where(function ($query) {
                $query->where('commercial_name', 'like', '%' . $this->search . '%')
                    ->orWhere('generic_name', 'like', '%' . $this->search . '%')
                    ->orWhereHas('activeIngredient', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy('commercial_name')
            ->paginate(10);

        $activeIngredients = ActiveIngredient::where('is_active', true)->orderBy('name')->get();
        $administrationRoutes = AdministrationRoute::where('is_active', true)->orderBy('name')->get();
        $concentrationUnits = ConcentrationUnit::where('is_active', true)->orderBy('name')->get();

        return view('livewire.medications', [
            'medications' => $medications,
            'activeIngredients' => $activeIngredients,
            'administrationRoutes' => $administrationRoutes,
            'concentrationUnits' => $concentrationUnits
        ]);
    }
}
