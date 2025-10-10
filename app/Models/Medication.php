<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo para gestionar los medicamentos
 * Almacena información completa sobre fármacos, presentación y características
 */
class Medication extends Model
{
    use HasFactory;
    /**
     * Los atributos que se pueden asignar masivamente
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'commercial_name',      // Nombre comercial del medicamento
        'generic_name',         // Nombre genérico del medicamento
        'active_ingredient_id', // ID del principio activo
        'concentration_unit_id', // ID de la unidad de concentración
        'concentration',        // Concentración del principio activo
        'administration_route_id', // ID de la vía de administración
        'pharmaceutical_form',  // Forma farmacéutica (tableta, cápsula, etc.)
        'registration_number',  // Número de registro sanitario
        'laboratory',           // Laboratorio fabricante
        'presentation',         // Presentación (caja con X unidades)
        'indications',          // Indicaciones terapéuticas
        'contraindications',    // Contraindicaciones
        'warnings',             // Advertencias y precauciones
        'storage_conditions',   // Condiciones de almacenamiento
        'is_active',            // Estado de actividad
    ];

    /**
     * Los atributos que deben convertirse a tipos específicos
     *
     * @var array<string, string>
     */
    protected $casts = [
        'concentration' => 'decimal:4',    // Concentración con 4 decimales
        'storage_conditions' => 'array',    // Convertir JSON a array
        'is_active' => 'boolean',          // Convertir a booleano
    ];

    /**
     * Obtiene el principio activo del medicamento
     * Relación muchos a uno con el modelo ActiveIngredient
     */
    public function activeIngredient(): BelongsTo
    {
        return $this->belongsTo(ActiveIngredient::class);
    }

    /**
     * Obtiene la unidad de concentración del medicamento
     * Relación muchos a uno con el modelo ConcentrationUnit
     */
    public function concentrationUnit(): BelongsTo
    {
        return $this->belongsTo(ConcentrationUnit::class);
    }

    /**
     * Obtiene la vía de administración del medicamento
     * Relación muchos a uno con el modelo AdministrationRoute
     */
    public function administrationRoute(): BelongsTo
    {
        return $this->belongsTo(AdministrationRoute::class);
    }

    /**
     * Obtiene las interacciones fisicoquímicas donde el medicamento es el primero
     * Relación uno a muchos con el modelo PhysicochemicalInteraction
     */
    public function physicochemicalInteractionsAsMed1(): HasMany
    {
        return $this->hasMany(PhysicochemicalInteraction::class, 'medication_1_id');
    }

    /**
     * Obtiene las interacciones fisicoquímicas donde el medicamento es el segundo
     * Relación uno a muchos con el modelo PhysicochemicalInteraction
     */
    public function physicochemicalInteractionsAsMed2(): HasMany
    {
        return $this->hasMany(PhysicochemicalInteraction::class, 'medication_2_id');
    }

    /**
     * Obtiene las interacciones farmacodinámicas donde el medicamento es el primero
     * Relación uno a muchos con el modelo PharmacodynamicInteraction
     */
    public function pharmacodynamicInteractionsAsMed1(): HasMany
    {
        return $this->hasMany(PharmacodynamicInteraction::class, 'medication_1_id');
    }

    /**
     * Obtiene las interacciones farmacodinámicas donde el medicamento es el segundo
     * Relación uno a muchos con el modelo PharmacodynamicInteraction
     */
    public function pharmacodynamicInteractionsAsMed2(): HasMany
    {
        return $this->hasMany(PharmacodynamicInteraction::class, 'medication_2_id');
    }

    /**
     * Obtiene las interacciones farmacocinéticas donde el medicamento es el primero
     * Relación uno a muchos con el modelo PharmacokineticInteraction
     */
    public function pharmacokineticInteractionsAsMed1(): HasMany
    {
        return $this->hasMany(PharmacokineticInteraction::class, 'medication_1_id');
    }

    /**
     * Obtiene las interacciones farmacocinéticas donde el medicamento es el segundo
     * Relación uno a muchos con el modelo PharmacokineticInteraction
     */
    public function pharmacokineticInteractionsAsMed2(): HasMany
    {
        return $this->hasMany(PharmacokineticInteraction::class, 'medication_2_id');
    }

    /**
     * Obtiene todas las interacciones fisicoquímicas del medicamento
     * Combina las interacciones como medicamento 1 y como medicamento 2
     */
    public function physicochemicalInteractions(): HasMany
    {
        return $this->physicochemicalInteractionsAsMed1->union($this->physicochemicalInteractionsAsMed2);
    }

    /**
     * Obtiene todas las interacciones farmacodinámicas del medicamento
     * Combina las interacciones como medicamento 1 y como medicamento 2
     */
    public function pharmacodynamicInteractions(): HasMany
    {
        return $this->pharmacodynamicInteractionsAsMed1->union($this->pharmacodynamicInteractionsAsMed2);
    }

    /**
     * Obtiene todas las interacciones farmacocinéticas del medicamento
     * Combina las interacciones como medicamento 1 y como medicamento 2
     */
    public function pharmacokineticInteractions(): HasMany
    {
        return $this->pharmacokineticInteractionsAsMed1->union($this->pharmacokineticInteractionsAsMed2);
    }

    /**
     * Filtra una consulta para incluir solo medicamentos activos
     * Scope local para filtrar registros activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Filtra una consulta para buscar por nombre comercial, nombre genérico o número de registro
     * Scope local para búsquedas por texto
     */
    public function scopeSearch($query, $term)
    {
        return $query->where('commercial_name', 'like', "%{$term}%")
                    ->orWhere('generic_name', 'like', "%{$term}%")
                    ->orWhere('registration_number', 'like', "%{$term}%");
    }

    /**
     * Obtiene el nombre completo del medicamento (nombre comercial + concentración + unidad)
     * Atributo calculado para mostrar información completa del medicamento
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->commercial_name} {$this->concentration} {$this->concentrationUnit->symbol}";
    }
}
