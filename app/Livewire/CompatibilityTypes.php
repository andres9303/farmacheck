<?php

namespace App\Livewire;

use App\Models\CompatibilityType;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class CompatibilityTypes extends Component
{
    use WithPagination;

    /**
     * Variables de estado del componente
     * Almacenan los datos del formulario y el estado de la interfaz
     */
    public $name, $description, $color_code, $is_active = true;
    public $compatibility_type_id;
    public $search = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $confirmingDelete = false;

    /**
     * Reglas de validación para los campos del formulario
     */
    protected $rules = [
        'name' => 'required|string|max:255|unique:compatibility_types,name',
        'description' => 'nullable|string|max:1000',
        'color_code' => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
        'is_active' => 'boolean',
    ];

    /**
     * Mensajes de validación personalizados en español
     */
    protected $messages = [
        'name.required' => 'El nombre del tipo de compatibilidad es obligatorio.',
        'name.unique' => 'Ya existe un tipo de compatibilidad con este nombre.',
        'color_code.required' => 'El código de color es obligatorio.',
        'color_code.regex' => 'El código de color debe ser un valor hexadecimal válido (ej: #FF5733).',
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
     * Abre el modal para crear o editar tipos de compatibilidad
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
        $this->color_code = '#000000';
        $this->is_active = true;
        $this->compatibility_type_id = null;
    }

    /**
     * Guarda o actualiza un tipo de compatibilidad en la base de datos
     * Utiliza el método updateOrCreate para crear o editar según corresponda
     */
    public function store()
    {
        // Adaptar las reglas de validación para el ID actual
        $this->rules['name'] = 'required|string|max:255|unique:compatibility_types,name,' . $this->compatibility_type_id;
        $this->validate();

        CompatibilityType::updateOrCreate(['id' => $this->compatibility_type_id], [
            'name' => $this->name,
            'description' => $this->description,
            'color_code' => $this->color_code,
            'is_active' => $this->is_active,
        ]);

        $this->closeModal();
        $message = $this->compatibility_type_id ? 'Tipo de compatibilidad actualizado correctamente.' : 'Tipo de compatibilidad creado correctamente.';
        $this->dispatch('notify', message: $message);
    }

    /**
     * Carga los datos de un tipo de compatibilidad para editar
     * Busca el registro y llena los campos del formulario
     */
    public function edit($id)
    {
        $compatibilityType = CompatibilityType::findOrFail($id);
        $this->compatibility_type_id = $id;
        $this->name = $compatibilityType->name;
        $this->description = $compatibilityType->description;
        $this->color_code = $compatibilityType->color_code;
        $this->is_active = $compatibilityType->is_active;
        
        $this->showModal = true;
    }

    /**
     * Confirma la eliminación de un tipo de compatibilidad
     * Muestra el modal de confirmación de eliminación
     */
    public function confirmDelete($id)
    {
        $this->compatibility_type_id = $id;
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
        $this->compatibility_type_id = null;
    }

    /**
     * Cambia el estado a inactivo en lugar de eliminar
     * Busca el registro por ID y cambia su estado a inactivo
     */
    public function delete()
    {
        $compatibilityType = CompatibilityType::find($this->compatibility_type_id);
        $compatibilityType->is_active = false;
        $compatibilityType->save();
        
        $this->cancelDelete();
        $this->dispatch('notify', message: 'Tipo de compatibilidad desactivado correctamente.');
    }

    /**
     * Cambia el estado activo/inactivo de un tipo de compatibilidad
     * Permite activar o desactivar sin eliminar el registro
     */
    public function toggleActive($id)
    {
        $compatibilityType = CompatibilityType::find($id);
        $compatibilityType->is_active = !$compatibilityType->is_active;
        $compatibilityType->save();
        
        $status = $compatibilityType->is_active ? 'activado' : 'desactivado';
        $this->dispatch('notify', message: "Tipo de compatibilidad {$status} correctamente.");
    }

    /**
     * Renderiza el componente con la lista de tipos de compatibilidad
     * Aplica filtros de búsqueda y paginación
     */
    public function render()
    {
        $compatibilityTypes = CompatibilityType::orderBy('name')
            ->where('name', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.compatibility-types', [
            'compatibilityTypes' => $compatibilityTypes
        ]);
    }
}
