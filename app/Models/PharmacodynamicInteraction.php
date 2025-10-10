<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo para gestionar las interacciones farmacodinámicas entre medicamentos
 * Almacena información sobre efectos en los mecanismos de acción de los fármacos
 */
class PharmacodynamicInteraction extends Model
{
    /**
     * Los atributos que se pueden asignar masivamente
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'medication_1_id',        // ID del primer medicamento
        'medication_2_id',        // ID del segundo medicamento
        'compatibility_type_id',  // ID del tipo de compatibilidad
        'interaction_type',       // Tipo de interacción (sinérgica, antagonista, etc.)
        'description',            // Descripción detallada de la interacción
        'mechanism',              // Mecanismo de la interacción
        'clinical_effects',       // Efectos clínicos de la interacción
        'recommendations',        // Recomendaciones para manejar la interacción
        'evidence_level',         // Nivel de evidencia científica
        'source',                 // Fuente de información
        'is_active',              // Estado de actividad
    ];

    /**
     * Los atributos que deben convertirse a tipos específicos
     *
     * @var array<string, string>
     */
    protected $casts = [
        'evidence_level' => 'array',  // Convertir JSON a array
        'is_active' => 'boolean',     // Convertir a booleano
    ];

    /**
     * Obtiene el primer medicamento de la interacción
     * Relación muchos a uno con el modelo Medication
     */
    public function medication1(): BelongsTo
    {
        return $this->belongsTo(Medication::class, 'medication_1_id');
    }

    /**
     * Obtiene el segundo medicamento de la interacción
     * Relación muchos a uno con el modelo Medication
     */
    public function medication2(): BelongsTo
    {
        return $this->belongsTo(Medication::class, 'medication_2_id');
    }

    /**
     * Obtiene el tipo de compatibilidad de la interacción
     * Relación muchos a uno con el modelo CompatibilityType
     */
    public function compatibilityType(): BelongsTo
    {
        return $this->belongsTo(CompatibilityType::class);
    }

    /**
     * Filtra una consulta para incluir solo interacciones activas
     * Scope local para filtrar registros activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Filtra una consulta por medicamento
     * Busca interacciones donde un medicamento específico participa
     */
    public function scopeForMedication($query, $medicationId)
    {
        return $query->where(function ($q) use ($medicationId) {
            $q->where('medication_1_id', $medicationId)
              ->orWhere('medication_2_id', $medicationId);
        });
    }

    /**
     * Filtra una consulta por nivel de compatibilidad
     * Busca interacciones de un nivel de riesgo específico
     */
    public function scopeOfLevel($query, $level)
    {
        return $query->whereHas('compatibilityType', function ($q) use ($level) {
            $q->where('level', $level);
        });
    }

    /**
     * Filtra una consulta por tipo de interacción
     * Busca interacciones de un tipo específico
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('interaction_type', $type);
    }

    /**
     * Obtiene el par de medicamentos como cadena formateada
     * Atributo calculado para mostrar información del par de medicamentos
     */
    public function getMedicationPairAttribute(): string
    {
        return "{$this->medication1->full_name} + {$this->medication2->full_name}";
    }
}
