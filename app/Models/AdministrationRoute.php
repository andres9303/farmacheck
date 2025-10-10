<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo para gestionar las vías de administración de medicamentos
 * Almacena información sobre las diferentes formas de administrar fármacos
 */
class AdministrationRoute extends Model
{
    use HasFactory;
    /**
     * Los atributos que se pueden asignar masivamente
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',        // Nombre de la vía de administración (ej: Oral, Intravenosa)
        'code',        // Código identificador único
        'description', // Descripción detallada de la vía
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
     * Obtiene los medicamentos que utilizan esta vía de administración
     * Relación uno a muchos con el modelo Medication
     */
    public function medications(): HasMany
    {
        return $this->hasMany(Medication::class);
    }

    /**
     * Filtra una consulta para incluir solo vías de administración activas
     * Scope local para filtrar registros activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
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
