<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo para gestionar los tipos de compatibilidad entre medicamentos
 * Clasifica las interacciones según su nivel de riesgo y características
 */
class CompatibilityType extends Model
{
    /**
     * Los atributos que se pueden asignar masivamente
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',        // Nombre del tipo de compatibilidad
        'code',        // Código identificador único
        'level',       // Nivel de riesgo (ej: bajo, medio, alto)
        'color',       // Color para representación visual
        'description', // Descripción detallada
        'is_active',   // Estado de actividad
    ];

    /**
     * Los atributos que deben convertirse a tipos específicos
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',  // Convertir a booleano
    ];

    /**
     * Obtiene las interacciones fisicoquímicas de este tipo de compatibilidad
     * Relación uno a muchos con el modelo PhysicochemicalInteraction
     */
    public function physicochemicalInteractions(): HasMany
    {
        return $this->hasMany(PhysicochemicalInteraction::class);
    }

    /**
     * Obtiene las interacciones farmacodinámicas de este tipo de compatibilidad
     * Relación uno a muchos con el modelo PharmacodynamicInteraction
     */
    public function pharmacodynamicInteractions(): HasMany
    {
        return $this->hasMany(PharmacodynamicInteraction::class);
    }

    /**
     * Obtiene las interacciones farmacocinéticas de este tipo de compatibilidad
     * Relación uno a muchos con el modelo PharmacokineticInteraction
     */
    public function pharmacokineticInteractions(): HasMany
    {
        return $this->hasMany(PharmacokineticInteraction::class);
    }

    /**
     * Filtra una consulta para incluir solo tipos de compatibilidad activos
     * Scope local para filtrar registros activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Filtra una consulta por nivel de riesgo
     * Scope local para filtrar por nivel específico
     */
    public function scopeOfLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    /**
     * Filtra una consulta para buscar por nombre o código
     * Scope local para búsquedas por texto
     */
    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'like', "%{$term}%")
                    ->orWhere('code', 'like', "%{$term}%");
    }
}
