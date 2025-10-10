<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Medication;
use App\Models\ActiveIngredient;
use App\Models\AdministrationRoute;
use App\Models\ConcentrationUnit;
use App\Models\CompatibilityType;
use App\Models\PhysicochemicalInteraction;
use App\Models\PharmacodynamicInteraction;
use App\Models\PharmacokineticInteraction;

/**
 * Componente Livewire para el panel de control principal
 * Muestra estadísticas y resúmenes del estado del sistema
 */
class Dashboard extends Component
{
    #[Layout('layouts.app')]
    // Variables para almacenar los conteos de elementos del catálogo
    public $conteoMedicamentos;
    public $conteoPrincipiosActivos;
    public $conteoViasAdministracion;
    public $conteoUnidadesConcentracion;
    public $conteoTiposCompatibilidad;
    
    // Variables para almacenar los conteos de interacciones
    public $conteoInteraccionesFisicoquimicas;
    public $conteoInteraccionesFarmacodinamicas;
    public $conteoInteraccionesFarmacocineticas;
    public $conteoTotalInteracciones;

    /**
     * Método que se ejecuta al montar el componente
     * Inicializa las estadísticas del dashboard
     */
    public function mount()
    {
        $this->cargarEstadisticas();
    }

    /**
     * Carga las estadísticas desde la base de datos
     * Consulta las tablas para obtener conteos de diferentes elementos
     */
    public function cargarEstadisticas()
    {
        // Contar elementos del catálogo (solo los activos)
        $this->conteoMedicamentos = Medication::active()->count();
        $this->conteoPrincipiosActivos = ActiveIngredient::active()->count();
        $this->conteoViasAdministracion = AdministrationRoute::active()->count();
        $this->conteoUnidadesConcentracion = ConcentrationUnit::active()->count();
        $this->conteoTiposCompatibilidad = CompatibilityType::active()->count();
        
        // Contar interacciones (solo las activas)
        $this->conteoInteraccionesFisicoquimicas = PhysicochemicalInteraction::active()->count();
        $this->conteoInteraccionesFarmacodinamicas = PharmacodynamicInteraction::active()->count();
        $this->conteoInteraccionesFarmacocineticas = PharmacokineticInteraction::active()->count();
        
        // Calcular total de interacciones
        $this->conteoTotalInteracciones = $this->conteoInteraccionesFisicoquimicas +
                                       $this->conteoInteraccionesFarmacodinamicas +
                                       $this->conteoInteraccionesFarmacocineticas;
    }

    /**
     * Renderiza el componente
     * Devuelve la vista del dashboard con todos los datos cargados
     */
    public function render()
    {
        return view('livewire.dashboard');
    }
}