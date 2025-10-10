<?php

namespace App\Livewire;

use App\Models\ActiveIngredient;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ActiveIngredients extends Component
{
    use WithPagination;

    /**
     * Variables de estado del componente
     * Almacenan los datos del formulario y el estado de la interfaz
     */
    public $name, $description, $atc_code, $molecular_formula, $molecular_weight, $is_active = true;
    public $therapeutic_actions = [];
    public $therapeutic_actions_str = '';
    public $active_ingredient_id;
    public $search = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $confirmingDelete = false;

    /**
     * Reglas de validación para los campos del formulario
     */
    protected $rules = [
        'name' => 'required|string|max:255|unique:active_ingredients,name',
        'description' => 'nullable|string|max:1000',
        'atc_code' => 'nullable|string|max:10',
        'molecular_formula' => 'nullable|string|max:100',
        'molecular_weight' => 'nullable|numeric|between:0,999999.9999',
        'therapeutic_actions' => 'nullable|array',
        'is_active' => 'boolean',
    ];

    /**
     * Mensajes de validación personalizados en español
     */
    protected $messages = [
        'name.required' => 'El nombre del principio activo es obligatorio.',
        'name.unique' => 'Ya existe un principio activo con este nombre.',
        'molecular_weight.numeric' => 'El peso molecular debe ser un valor numérico.',
        'molecular_weight.between' => 'El peso molecular debe estar entre 0 y 999999.9999.',
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
     * Abre el modal para crear o editar principios activos
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
        $this->name = '';
        $this->description = '';
        $this->atc_code = '';
        $this->molecular_formula = '';
        $this->molecular_weight = '';
        $this->therapeutic_actions = [];
        $this->therapeutic_actions_str = '';
        $this->is_active = true;
        $this->active_ingredient_id = null;
    }

    /**
     * Guarda o actualiza un principio activo en la base de datos
     * Convierte el string de acciones terapéuticas a un array
     */
    public function store()
    {
        // Adaptar la regla de validación para el ID actual
        $this->rules['name'] = 'required|string|max:255|unique:active_ingredients,name,' . $this->active_ingredient_id;
        $this->validate();

        // Convertir el string de acciones terapéuticas a un array
        $this->therapeutic_actions = array_filter(array_map('trim', explode(',', $this->therapeutic_actions_str)));

        ActiveIngredient::updateOrCreate(['id' => $this->active_ingredient_id], [
            'name' => $this->name,
            'description' => $this->description,
            'atc_code' => $this->atc_code,
            'molecular_formula' => $this->molecular_formula,
            'molecular_weight' => $this->molecular_weight,
            'therapeutic_actions' => $this->therapeutic_actions,
            'is_active' => $this->is_active,
        ]);

        $this->closeModal();
        $message = $this->active_ingredient_id ? 'Principio activo actualizado correctamente.' : 'Principio activo creado correctamente.';
        $this->dispatch('notify', message: $message);
    }

    /**
     * Carga los datos de un principio activo para editar
     * Busca el registro y llena los campos del formulario
     */
    public function edit($id)
    {
        $activeIngredient = ActiveIngredient::findOrFail($id);
        $this->active_ingredient_id = $id;
        $this->name = $activeIngredient->name;
        $this->description = $activeIngredient->description;
        $this->atc_code = $activeIngredient->atc_code;
        $this->molecular_formula = $activeIngredient->molecular_formula;
        $this->molecular_weight = $activeIngredient->molecular_weight;
        $this->therapeutic_actions = $activeIngredient->therapeutic_actions ?? [];
        $this->therapeutic_actions_str = implode(', ', $this->therapeutic_actions);
        $this->is_active = $activeIngredient->is_active;
        
        $this->showModal = true;
    }

    /**
     * Confirma la eliminación de un principio activo
     * Muestra el modal de confirmación de eliminación
     */
    public function confirmDelete($id)
    {
        $this->active_ingredient_id = $id;
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
        $this->active_ingredient_id = null;
    }

    /**
     * Cambia el estado a inactivo en lugar de eliminar
     * Busca el registro por ID y cambia su estado a inactivo
     */
    public function delete()
    {
        $activeIngredient = ActiveIngredient::find($this->active_ingredient_id);
        $activeIngredient->is_active = false;
        $activeIngredient->save();
        
        $this->cancelDelete();
        $this->dispatch('notify', message: 'Principio activo desactivado correctamente.');
    }

    /**
     * Cambia el estado activo/inactivo de un principio activo
     * Permite activar o desactivar sin eliminar el registro
     */
    public function toggleActive($id)
    {
        $activeIngredient = ActiveIngredient::find($id);
        $activeIngredient->is_active = !$activeIngredient->is_active;
        $activeIngredient->save();
        
        $status = $activeIngredient->is_active ? 'activado' : 'desactivado';
        $this->dispatch('notify', ['message' => "Principio activo {$status} correctamente."]);
    }

    /**
     * Renderiza el componente con la lista de principios activos
     * Aplica filtros de búsqueda y paginación
     */
    public function render()
    {
        $activeIngredients = ActiveIngredient::with('medications')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('atc_code', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.active-ingredients', [
            'activeIngredients' => $activeIngredients
        ]);
    }
}
