<?php

namespace App\Policies;

use App\Models\PharmacodynamicInteraction;
use App\Models\User;
use Illuminate\Auth\Access\Response;

/**
 * Política de autorización para el modelo PharmacodynamicInteraction
 * Define los permisos para realizar acciones sobre interacciones farmacodinámicas
 * Nota: Actualmente todas las operaciones están denegadas (return false)
 */
class PharmacodynamicInteractionPolicy
{
    /**
     * Determina si el usuario puede ver la lista de interacciones farmacodinámicas
     * Actualmente denegado para todos los usuarios
     */
    public function viewAny(User $user): bool
    {
        // Actualmente ningún usuario puede ver la lista de interacciones farmacodinámicas
        return false;
    }

    /**
     * Determina si el usuario puede ver los detalles de una interacción farmacodinámica específica
     * Actualmente denegado para todos los usuarios
     */
    public function view(User $user, PharmacodynamicInteraction $pharmacodynamicInteraction): bool
    {
        // Actualmente ningún usuario puede ver detalles de una interacción farmacodinámica
        return false;
    }

    /**
     * Determina si el usuario puede crear nuevas interacciones farmacodinámicas
     * Actualmente denegado para todos los usuarios
     */
    public function create(User $user): bool
    {
        // Actualmente ningún usuario puede crear interacciones farmacodinámicas
        return false;
    }

    /**
     * Determina si el usuario puede actualizar una interacción farmacodinámica existente
     * Actualmente denegado para todos los usuarios
     */
    public function update(User $user, PharmacodynamicInteraction $pharmacodynamicInteraction): bool
    {
        // Actualmente ningún usuario puede actualizar interacciones farmacodinámicas
        return false;
    }

    /**
     * Determina si el usuario puede eliminar una interacción farmacodinámica
     * Actualmente denegado para todos los usuarios
     */
    public function delete(User $user, PharmacodynamicInteraction $pharmacodynamicInteraction): bool
    {
        // Actualmente ningún usuario puede eliminar interacciones farmacodinámicas
        return false;
    }

    /**
     * Determina si el usuario puede restaurar una interacción farmacodinámica eliminada
     * Actualmente denegado para todos los usuarios
     */
    public function restore(User $user, PharmacodynamicInteraction $pharmacodynamicInteraction): bool
    {
        // Actualmente ningún usuario puede restaurar interacciones farmacodinámicas
        return false;
    }

    /**
     * Determina si el usuario puede eliminar permanentemente una interacción farmacodinámica
     * Actualmente denegado para todos los usuarios
     */
    public function forceDelete(User $user, PharmacodynamicInteraction $pharmacodynamicInteraction): bool
    {
        // Actualmente ningún usuario puede eliminar permanentemente interacciones farmacodinámicas
        return false;
    }
}
