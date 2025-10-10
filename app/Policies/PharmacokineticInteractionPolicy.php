<?php

namespace App\Policies;

use App\Models\PharmacokineticInteraction;
use App\Models\User;
use Illuminate\Auth\Access\Response;

/**
 * Política de autorización para el modelo PharmacokineticInteraction
 * Define los permisos para realizar acciones sobre interacciones farmacocinéticas
 * Nota: Actualmente todas las operaciones están denegadas (return false)
 */
class PharmacokineticInteractionPolicy
{
    /**
     * Determina si el usuario puede ver la lista de interacciones farmacocinéticas
     * Actualmente denegado para todos los usuarios
     */
    public function viewAny(User $user): bool
    {
        // Actualmente ningún usuario puede ver la lista de interacciones farmacocinéticas
        return false;
    }

    /**
     * Determina si el usuario puede ver los detalles de una interacción farmacocinética específica
     * Actualmente denegado para todos los usuarios
     */
    public function view(User $user, PharmacokineticInteraction $pharmacokineticInteraction): bool
    {
        // Actualmente ningún usuario puede ver detalles de una interacción farmacocinética
        return false;
    }

    /**
     * Determina si el usuario puede crear nuevas interacciones farmacocinéticas
     * Actualmente denegado para todos los usuarios
     */
    public function create(User $user): bool
    {
        // Actualmente ningún usuario puede crear interacciones farmacocinéticas
        return false;
    }

    /**
     * Determina si el usuario puede actualizar una interacción farmacocinética existente
     * Actualmente denegado para todos los usuarios
     */
    public function update(User $user, PharmacokineticInteraction $pharmacokineticInteraction): bool
    {
        // Actualmente ningún usuario puede actualizar interacciones farmacocinéticas
        return false;
    }

    /**
     * Determina si el usuario puede eliminar una interacción farmacocinética
     * Actualmente denegado para todos los usuarios
     */
    public function delete(User $user, PharmacokineticInteraction $pharmacokineticInteraction): bool
    {
        // Actualmente ningún usuario puede eliminar interacciones farmacocinéticas
        return false;
    }

    /**
     * Determina si el usuario puede restaurar una interacción farmacocinética eliminada
     * Actualmente denegado para todos los usuarios
     */
    public function restore(User $user, PharmacokineticInteraction $pharmacokineticInteraction): bool
    {
        // Actualmente ningún usuario puede restaurar interacciones farmacocinéticas
        return false;
    }

    /**
     * Determina si el usuario puede eliminar permanentemente una interacción farmacocinética
     * Actualmente denegado para todos los usuarios
     */
    public function forceDelete(User $user, PharmacokineticInteraction $pharmacokineticInteraction): bool
    {
        // Actualmente ningún usuario puede eliminar permanentemente interacciones farmacocinéticas
        return false;
    }
}
