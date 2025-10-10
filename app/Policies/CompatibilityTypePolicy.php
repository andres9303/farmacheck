<?php

namespace App\Policies;

use App\Models\CompatibilityType;
use App\Models\User;
use Illuminate\Auth\Access\Response;

/**
 * Política de autorización para el modelo CompatibilityType
 * Define los permisos para realizar acciones sobre tipos de compatibilidad
 * Nota: Actualmente todas las operaciones están denegadas (return false)
 */
class CompatibilityTypePolicy
{
    /**
     * Determina si el usuario puede ver la lista de tipos de compatibilidad
     * Actualmente denegado para todos los usuarios
     */
    public function viewAny(User $user): bool
    {
        // Actualmente ningún usuario puede ver la lista de tipos de compatibilidad
        return false;
    }

    /**
     * Determina si el usuario puede ver los detalles de un tipo de compatibilidad específico
     * Actualmente denegado para todos los usuarios
     */
    public function view(User $user, CompatibilityType $compatibilityType): bool
    {
        // Actualmente ningún usuario puede ver detalles de un tipo de compatibilidad
        return false;
    }

    /**
     * Determina si el usuario puede crear nuevos tipos de compatibilidad
     * Actualmente denegado para todos los usuarios
     */
    public function create(User $user): bool
    {
        // Actualmente ningún usuario puede crear tipos de compatibilidad
        return false;
    }

    /**
     * Determina si el usuario puede actualizar un tipo de compatibilidad existente
     * Actualmente denegado para todos los usuarios
     */
    public function update(User $user, CompatibilityType $compatibilityType): bool
    {
        // Actualmente ningún usuario puede actualizar tipos de compatibilidad
        return false;
    }

    /**
     * Determina si el usuario puede eliminar un tipo de compatibilidad
     * Actualmente denegado para todos los usuarios
     */
    public function delete(User $user, CompatibilityType $compatibilityType): bool
    {
        // Actualmente ningún usuario puede eliminar tipos de compatibilidad
        return false;
    }

    /**
     * Determina si el usuario puede restaurar un tipo de compatibilidad eliminado
     * Actualmente denegado para todos los usuarios
     */
    public function restore(User $user, CompatibilityType $compatibilityType): bool
    {
        // Actualmente ningún usuario puede restaurar tipos de compatibilidad
        return false;
    }

    /**
     * Determina si el usuario puede eliminar permanentemente un tipo de compatibilidad
     * Actualmente denegado para todos los usuarios
     */
    public function forceDelete(User $user, CompatibilityType $compatibilityType): bool
    {
        // Actualmente ningún usuario puede eliminar permanentemente tipos de compatibilidad
        return false;
    }
}
