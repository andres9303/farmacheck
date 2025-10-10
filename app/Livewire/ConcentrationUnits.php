<?php

namespace App\Livewire;

use App\Models\ConcentrationUnit;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ConcentrationUnits extends Component
{
    use WithPagination;

    /**
     * Variables de estado del componente
     * Almacenan los datos del formulario y el estado de la interfaz
     */
    public $name, $symbol, $description, $type, $is_active = true;
    public $concentration_unit_id;
    public $search = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $confirmingDelete = false;

    /**
     * Reglas de validación para los campos del formulario
     */
    protected $rules = [
        'name' => 'required|string|max:255|unique:concentration_units,name',
        'symbol' => 'required|string|max:10|unique:concentration_units,symbol',
        'description' => 'nullable|string|max:1000',
        'type' => 'required|string|max:50',
        'is_active' => 'boolean',
    ];

    /**
     * Mensajes de validación personalizados en español
     */
    protected $messages = [
        'name.required' => 'El nombre de la unidad de concentración es obligatorio.',
        'name.unique' => 'Ya existe una unidad de concentración con este nombre.',
        'symbol.required' => 'El símbolo de la unidad de concentración es obligatorio.',
        'symbol.unique' => 'Ya existe una unidad de concentración con este símbolo.',
        'type.required' => 'El tipo de unidad de concentración es obligatorio.',
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
     * Abre el modal para crear o editar unidades de concentración
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
        $this->symbol = '';
        $this->description = '';
        $this->type = '';
        $this->is_active = true;
        $this->concentration_unit_id = null;
    }

    /**
     * Guarda o actualiza una unidad de concentración en la base de datos
     * Utiliza el método updateOrCreate para crear o editar según corresponda
     */
    public function store()
    {
        // Adaptar las reglas de validación para el ID actual
        $this->rules['name'] = 'required|string|max:255|unique:concentration_units,name,' . $this->concentration_unit_id;
        $this->rules['symbol'] = 'required|string|max:10|unique:concentration_units,symbol,' . $this->concentration_unit_id;
        $this->validate();

        ConcentrationUnit::updateOrCreate(['id' => $this->concentration_unit_id], [
            'name' => $this->name,
            'symbol' => $this->symbol,
            'description' => $this->description,
            'type' => $this->type,
            'is_active' => $this->is_active,
        ]);

        $this->closeModal();
        $message = $this->concentration_unit_id ? 'Unidad de concentración actualizada correctamente.' : 'Unidad de concentración creada correctamente.';
        $this->dispatch('notify', message: $message);
    }

    /**
     * Carga los datos de una unidad de concentración para editar
     * Busca el registro y llena los campos del formulario
     */
    public function edit($id)
    {
        $concentrationUnit = ConcentrationUnit::findOrFail($id);
        $this->concentration_unit_id = $id;
        $this->name = $concentrationUnit->name;
        $this->symbol = $concentrationUnit->symbol;
        $this->description = $concentrationUnit->description;
        $this->type = $concentrationUnit->type;
        $this->is_active = $concentrationUnit->is_active;
        
        $this->showModal = true;
    }

    /**
     * Confirma la eliminación de una unidad de concentración
     * Muestra el modal de confirmación de eliminación
     */
    public function confirmDelete($id)
    {
        $this->concentration_unit_id = $id;
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
        $this->concentration_unit_id = null;
    }

    /**
     * Cambia el estado a inactivo en lugar de eliminar
     * Busca el registro por ID y cambia su estado a inactivo
     */
    public function delete()
    {
        $concentrationUnit = ConcentrationUnit::find($this->concentration_unit_id);
        $concentrationUnit->is_active = false;
        $concentrationUnit->save();
        
        $this->cancelDelete();
        $this->dispatch('notify', message: 'Unidad de concentración desactivada correctamente.');
    }

    /**
     * Cambia el estado activo/inactivo de una unidad de concentración
     * Permite activar o desactivar sin eliminar el registro
     */
    public function toggleActive($id)
    {
        $concentrationUnit = ConcentrationUnit::find($id);
        $concentrationUnit->is_active = !$concentrationUnit->is_active;
        $concentrationUnit->save();
        
        $status = $concentrationUnit->is_active ? 'activada' : 'desactivada';
        $this->dispatch('notify', message: "Unidad de concentración {$status} correctamente.");
    }

    /**
     * Renderiza el componente con la lista de unidades de concentración
     * Aplica filtros de búsqueda y paginación
     */
    public function render()
    {
        $concentrationUnits = ConcentrationUnit::with('medications')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('symbol', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.concentration-units', [
            'concentrationUnits' => $concentrationUnits
        ]);
    }
}
