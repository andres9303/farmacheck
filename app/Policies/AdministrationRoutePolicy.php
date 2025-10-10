<?php

namespace App\Policies;

use App\Models\AdministrationRoute;
use App\Models\User;
use Illuminate\Auth\Access\Response;

/**
 * Política de autorización para el modelo AdministrationRoute
 * Define los permisos para realizar acciones sobre vías de administración
 * Nota: Actualmente todas las operaciones están denegadas (return false)
 */
class AdministrationRoutePolicy
{
    /**
     * Determina si el usuario puede ver la lista de vías de administración
     * Actualmente denegado para todos los usuarios
     */
    public function viewAny(User $user): bool
    {
        // Actualmente ningún usuario puede ver la lista de vías de administración
        return false;
    }

    /**
     * Determina si el usuario puede ver los detalles de una vía de administración específica
     * Actualmente denegado para todos los usuarios
     */
    public function view(User $user, AdministrationRoute $administrationRoute): bool
    {
        // Actualmente ningún usuario puede ver detalles de una vía de administración
        return false;
    }

    /**
     * Determina si el usuario puede crear nuevas vías de administración
     * Actualmente denegado para todos los usuarios
     */
    public function create(User $user): bool
    {
        // Actualmente ningún usuario puede crear vías de administración
        return false;
    }

    /**
     * Determina si el usuario puede actualizar una vía de administración existente
     * Actualmente denegado para todos los usuarios
     */
    public function update(User $user, AdministrationRoute $administrationRoute): bool
    {
        // Actualmente ningún usuario puede actualizar vías de administración
        return false;
    }

    /**
     * Determina si el usuario puede eliminar una vía de administración
     * Actualmente denegado para todos los usuarios
     */
    public function delete(User $user, AdministrationRoute $administrationRoute): bool
    {
        // Actualmente ningún usuario puede eliminar vías de administración
        return false;
    }

    /**
     * Determina si el usuario puede restaurar una vía de administración eliminada
     * Actualmente denegado para todos los usuarios
     */
    public function restore(User $user, AdministrationRoute $administrationRoute): bool
    {
        // Actualmente ningún usuario puede restaurar vías de administración
        return false;
    }

    /**
     * Determina si el usuario puede eliminar permanentemente una vía de administración
     * Actualmente denegado para todos los usuarios
     */
    public function forceDelete(User $user, AdministrationRoute $administrationRoute): bool
    {
        // Actualmente ningún usuario puede eliminar permanentemente vías de administración
        return false;
    }
}
