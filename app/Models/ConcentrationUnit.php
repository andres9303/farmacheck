<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo para gestionar las unidades de concentración de medicamentos
 * Almacena información sobre las diferentes unidades de medida
 */
class ConcentrationUnit extends Model
{
    use HasFactory;
    /**
     * Los atributos que se pueden asignar masivamente
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',        // Nombre completo de la unidad (ej: Miligramo)
        'symbol',      // Símbolo de la unidad (ej: mg)
        'description', // Descripción detallada
        'type',        // Tipo de unidad (masa, volumen, etc.)
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
     * Obtiene los medicamentos que utilizan esta unidad de concentración
     * Relación uno a muchos con el modelo Medication
     */
    public function medications(): HasMany
    {
        return $this->hasMany(Medication::class);
    }

    /**
     * Filtra una consulta para incluir solo unidades de concentración activas
     * Scope local para filtrar registros activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Filtra una consulta para buscar por nombre o símbolo
     * Scope local para búsquedas por texto
     */
    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'like', "%{$term}%")
                    ->orWhere('symbol', 'like', "%{$term}%");
    }

    /**
     * Filtra una consulta por tipo de unidad
     * Scope local para filtrar por tipo específico
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}
