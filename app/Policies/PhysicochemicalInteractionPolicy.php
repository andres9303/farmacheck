<?php

namespace App\Policies;

use App\Models\PhysicochemicalInteraction;
use App\Models\User;
use Illuminate\Auth\Access\Response;

/**
 * Política de autorización para el modelo PhysicochemicalInteraction
 * Define los permisos para realizar acciones sobre interacciones fisicoquímicas
 */
class PhysicochemicalInteractionPolicy
{
    /**
     * Determina si el usuario puede ver la lista de interacciones fisicoquímicas
     * Requiere que el usuario tenga el correo verificado
     */
    public function viewAny(User $user): bool
    {
        // Todos los usuarios autenticados con correo verificado pueden ver interacciones fisicoquímicas
        return $user->hasVerifiedEmail();
    }

    /**
     * Determina si el usuario puede ver los detalles de una interacción fisicoquímica específica
     * Requiere que el usuario tenga el correo verificado
     */
    public function view(User $user, PhysicochemicalInteraction $physicochemicalInteraction): bool
    {
        // Todos los usuarios autenticados con correo verificado pueden ver detalles de una interacción fisicoquímica
        return $user->hasVerifiedEmail();
    }

    /**
     * Determina si el usuario puede crear nuevas interacciones fisicoquímicas
     * Requiere rol de administrador, farmacéutico o médico
     */
    public function create(User $user): bool
    {
        // Solo administradores, farmacéuticos o médicos con correo verificado pueden crear interacciones fisicoquímicas
        return $user->hasVerifiedEmail() && (
            $user->isAdmin() ||
            $user->isPharmacist() ||
            $user->isDoctor()
        );
    }

    /**
     * Determina si el usuario puede actualizar una interacción fisicoquímica existente
     * Requiere rol de administrador, farmacéutico o médico
     */
    public function update(User $user, PhysicochemicalInteraction $physicochemicalInteraction): bool
    {
        // Solo administradores, farmacéuticos o médicos con correo verificado pueden actualizar interacciones fisicoquímicas
        return $user->hasVerifiedEmail() && (
            $user->isAdmin() ||
            $user->isPharmacist() ||
            $user->isDoctor()
        );
    }

    /**
     * Determina si el usuario puede eliminar una interacción fisicoquímica
     * Requiere rol de administrador
     */
    public function delete(User $user, PhysicochemicalInteraction $physicochemicalInteraction): bool
    {
        // Solo administradores con correo verificado pueden eliminar interacciones fisicoquímicas
        return $user->hasVerifiedEmail() && $user->isAdmin();
    }

    /**
     * Determina si el usuario puede restaurar una interacción fisicoquímica eliminada
     * Requiere rol de administrador
     */
    public function restore(User $user, PhysicochemicalInteraction $physicochemicalInteraction): bool
    {
        // Solo administradores con correo verificado pueden restaurar interacciones fisicoquímicas eliminadas
        return $user->hasVerifiedEmail() && $user->isAdmin();
    }

    /**
     * Determina si el usuario puede eliminar permanentemente una interacción fisicoquímica
     * Requiere rol de administrador
     */
    public function forceDelete(User $user, PhysicochemicalInteraction $physicochemicalInteraction): bool
    {
        // Solo administradores con correo verificado pueden eliminar interacciones fisicoquímicas permanentemente
        return $user->hasVerifiedEmail() && $user->isAdmin();
    }
}
