<?php

namespace App\Livewire;

use App\Models\AdministrationRoute;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class AdministrationRoutes extends Component
{
    use WithPagination;

    /**
     * Variables de estado del componente
     * Almacenan los datos del formulario y el estado de la interfaz
     */
    public $name, $code, $description, $is_active = true;
    public $administration_route_id;
    public $search = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $confirmingDelete = false;

    /**
     * Reglas de validación para los campos del formulario
     */
    protected $rules = [
        'name' => 'required|string|max:255|unique:administration_routes,name',
        'code' => 'required|string|max:20|unique:administration_routes,code',
        'description' => 'nullable|string|max:1000',
        'is_active' => 'boolean',
    ];

    /**
     * Mensajes de validación personalizados en español
     */
    protected $messages = [
        'name.required' => 'El nombre de la vía de administración es obligatorio.',
        'name.unique' => 'Ya existe una vía de administración con este nombre.',
        'code.required' => 'El código de la vía de administración es obligatorio.',
        'code.unique' => 'Ya existe una vía de administración con este código.',
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
     * Abre el modal para crear o editar vías de administración
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
        $this->code = '';
        $this->description = '';
        $this->is_active = true;
        $this->administration_route_id = null;
    }

    /**
     * Guarda o actualiza una vía de administración en la base de datos
     * Utiliza el método updateOrCreate para crear o editar según corresponda
     */
    public function store()
    {
        // Adaptar las reglas de validación para el ID actual
        $this->rules['name'] = 'required|string|max:255|unique:administration_routes,name,' . $this->administration_route_id;
        $this->rules['code'] = 'required|string|max:20|unique:administration_routes,code,' . $this->administration_route_id;
        $this->validate();

        AdministrationRoute::updateOrCreate(['id' => $this->administration_route_id], [
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ]);

        $this->closeModal();
        $message = $this->administration_route_id ? 'Vía de administración actualizada correctamente.' : 'Vía de administración creada correctamente.';
        $this->dispatch('notify', message: $message);
    }

    /**
     * Carga los datos de una vía de administración para editar
     * Busca el registro y llena los campos del formulario
     */
    public function edit($id)
    {
        $administrationRoute = AdministrationRoute::findOrFail($id);
        $this->administration_route_id = $id;
        $this->name = $administrationRoute->name;
        $this->code = $administrationRoute->code;
        $this->description = $administrationRoute->description;
        $this->is_active = $administrationRoute->is_active;
        
        $this->showModal = true;
    }

    /**
     * Confirma la eliminación de una vía de administración
     * Muestra el modal de confirmación de eliminación
     */
    public function confirmDelete($id)
    {
        $this->administration_route_id = $id;
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
        $this->administration_route_id = null;
    }

    /**
     * Cambia el estado a inactivo en lugar de eliminar
     * Busca el registro por ID y cambia su estado a inactivo
     */
    public function delete()
    {
        $administrationRoute = AdministrationRoute::find($this->administration_route_id);
        $administrationRoute->is_active = false;
        $administrationRoute->save();
        
        $this->cancelDelete();
        $this->dispatch('notify', message: 'Vía de administración desactivada correctamente.');
    }

    /**
     * Cambia el estado activo/inactivo de una vía de administración
     * Permite activar o desactivar sin eliminar el registro
     */
    public function toggleActive($id)
    {
        $administrationRoute = AdministrationRoute::find($id);
        $administrationRoute->is_active = !$administrationRoute->is_active;
        $administrationRoute->save();
        
        $status = $administrationRoute->is_active ? 'activada' : 'desactivada';
        $this->dispatch('notify', message: "Vía de administración {$status} correctamente.");
    }

    /**
     * Renderiza el componente con la lista de vías de administración
     * Aplica filtros de búsqueda y paginación
     */
    public function render()
    {
        $administrationRoutes = AdministrationRoute::with('medications')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('code', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.administration-routes', [
            'administrationRoutes' => $administrationRoutes
        ]);
    }
}
