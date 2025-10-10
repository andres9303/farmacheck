<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo para gestionar los principios activos de medicamentos
 * Almacena información sobre la composición química y propiedades terapéuticas
 */
class ActiveIngredient extends Model
{
    use HasFactory;
    /**
     * Los atributos que se pueden asignar masivamente
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',              // Nombre del principio activo
        'description',       // Descripción detallada
        'atc_code',          // Código ATC (Anatomical Therapeutic Chemical)
        'molecular_formula', // Fórmula molecular
        'molecular_weight',  // Peso molecular
        'therapeutic_actions', // Acciones terapéuticas
        'is_active',         // Estado de actividad
    ];

    /**
     * Los atributos que deben convertirse a tipos específicos
     *
     * @var array<string, string>
     */
    protected $casts = [
        'molecular_weight' => 'decimal:4',    // Peso molecular con 4 decimales
        'therapeutic_actions' => 'array',      // Convertir JSON a array
        'is_active' => 'boolean',              // Convertir a booleano
    ];

    /**
     * Obtiene los medicamentos que contienen este principio activo
     * Relación uno a muchos con el modelo Medication
     */
    public function medications(): HasMany
    {
        return $this->hasMany(Medication::class);
    }

    /**
     * Filtra una consulta para incluir solo principios activos activos
     * Scope local para filtrar registros activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Filtra una consulta para buscar por nombre o código ATC
     * Scope local para búsquedas por texto
     */
    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'like', "%{$term}%")
                    ->orWhere('atc_code', 'like', "%{$term}%");
    }
}
