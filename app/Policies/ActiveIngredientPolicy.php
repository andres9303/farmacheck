<?php

namespace App\Policies;

use App\Models\ActiveIngredient;
use App\Models\User;
use Illuminate\Auth\Access\Response;

/**
 * Política de autorización para el modelo ActiveIngredient
 * Define los permisos para realizar acciones sobre principios activos
 */
class ActiveIngredientPolicy
{
    /**
     * Determina si el usuario puede ver la lista de principios activos
     * Requiere que el usuario tenga el correo verificado
     */
    public function viewAny(User $user): bool
    {
        // Todos los usuarios autenticados con correo verificado pueden ver principios activos
        return $user->hasVerifiedEmail();
    }

    /**
     * Determina si el usuario puede ver los detalles de un principio activo específico
     * Requiere que el usuario tenga el correo verificado
     */
    public function view(User $user, ActiveIngredient $activeIngredient): bool
    {
        // Todos los usuarios autenticados con correo verificado pueden ver detalles de un principio activo
        return $user->hasVerifiedEmail();
    }

    /**
     * Determina si el usuario puede crear nuevos principios activos
     * Requiere rol de administrador, farmacéutico o médico
     */
    public function create(User $user): bool
    {
        // Solo administradores, farmacéuticos o médicos con correo verificado pueden crear principios activos
        return $user->hasVerifiedEmail() && (
            $user->isAdmin() ||
            $user->isPharmacist() ||
            $user->isDoctor()
        );
    }

    /**
     * Determina si el usuario puede actualizar un principio activo existente
     * Requiere rol de administrador, farmacéutico o médico
     */
    public function update(User $user, ActiveIngredient $activeIngredient): bool
    {
        // Solo administradores, farmacéuticos o médicos con correo verificado pueden actualizar principios activos
        return $user->hasVerifiedEmail() && (
            $user->isAdmin() ||
            $user->isPharmacist() ||
            $user->isDoctor()
        );
    }

    /**
     * Determina si el usuario puede eliminar un principio activo
     * Requiere rol de administrador
     */
    public function delete(User $user, ActiveIngredient $activeIngredient): bool
    {
        // Solo administradores con correo verificado pueden eliminar principios activos
        return $user->hasVerifiedEmail() && $user->isAdmin();
    }

    /**
     * Determina si el usuario puede restaurar un principio activo eliminado
     * Requiere rol de administrador
     */
    public function restore(User $user, ActiveIngredient $activeIngredient): bool
    {
        // Solo administradores con correo verificado pueden restaurar principios activos eliminados
        return $user->hasVerifiedEmail() && $user->isAdmin();
    }

    /**
     * Determina si el usuario puede eliminar permanentemente un principio activo
     * Requiere rol de administrador
     */
    public function forceDelete(User $user, ActiveIngredient $activeIngredient): bool
    {
        // Solo administradores con correo verificado pueden eliminar principios activos permanentemente
        return $user->hasVerifiedEmail() && $user->isAdmin();
    }
}
