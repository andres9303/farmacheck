<?php

namespace App\Policies;

use App\Models\ConcentrationUnit;
use App\Models\User;
use Illuminate\Auth\Access\Response;

/**
 * Política de autorización para el modelo ConcentrationUnit
 * Define los permisos para realizar acciones sobre unidades de concentración
 * Nota: Actualmente todas las operaciones están denegadas (return false)
 */
class ConcentrationUnitPolicy
{
    /**
     * Determina si el usuario puede ver la lista de unidades de concentración
     * Actualmente denegado para todos los usuarios
     */
    public function viewAny(User $user): bool
    {
        // Actualmente ningún usuario puede ver la lista de unidades de concentración
        return false;
    }

    /**
     * Determina si el usuario puede ver los detalles de una unidad de concentración específica
     * Actualmente denegado para todos los usuarios
     */
    public function view(User $user, ConcentrationUnit $concentrationUnit): bool
    {
        // Actualmente ningún usuario puede ver detalles de una unidad de concentración
        return false;
    }

    /**
     * Determina si el usuario puede crear nuevas unidades de concentración
     * Actualmente denegado para todos los usuarios
     */
    public function create(User $user): bool
    {
        // Actualmente ningún usuario puede crear unidades de concentración
        return false;
    }

    /**
     * Determina si el usuario puede actualizar una unidad de concentración existente
     * Actualmente denegado para todos los usuarios
     */
    public function update(User $user, ConcentrationUnit $concentrationUnit): bool
    {
        // Actualmente ningún usuario puede actualizar unidades de concentración
        return false;
    }

    /**
     * Determina si el usuario puede eliminar una unidad de concentración
     * Actualmente denegado para todos los usuarios
     */
    public function delete(User $user, ConcentrationUnit $concentrationUnit): bool
    {
        // Actualmente ningún usuario puede eliminar unidades de concentración
        return false;
    }

    /**
     * Determina si el usuario puede restaurar una unidad de concentración eliminada
     * Actualmente denegado para todos los usuarios
     */
    public function restore(User $user, ConcentrationUnit $concentrationUnit): bool
    {
        // Actualmente ningún usuario puede restaurar unidades de concentración
        return false;
    }

    /**
     * Determina si el usuario puede eliminar permanentemente una unidad de concentración
     * Actualmente denegado para todos los usuarios
     */
    public function forceDelete(User $user, ConcentrationUnit $concentrationUnit): bool
    {
        // Actualmente ningún usuario puede eliminar permanentemente unidades de concentración
        return false;
    }
}
