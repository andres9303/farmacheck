<?php

namespace App\Policies;

use App\Models\Medication;
use App\Models\User;
use Illuminate\Auth\Access\Response;

/**
 * Política de autorización para el modelo Medication
 * Define los permisos para realizar acciones sobre medicamentos
 */
class MedicationPolicy
{
    /**
     * Determina si el usuario puede ver la lista de medicamentos
     * Requiere que el usuario tenga el correo verificado
     */
    public function viewAny(User $user): bool
    {
        // Todos los usuarios autenticados con correo verificado pueden ver medicamentos
        return $user->hasVerifiedEmail();
    }

    /**
     * Determina si el usuario puede ver los detalles de un medicamento específico
     * Requiere que el usuario tenga el correo verificado
     */
    public function view(User $user, Medication $medication): bool
    {
        // Todos los usuarios autenticados con correo verificado pueden ver detalles de un medicamento
        return $user->hasVerifiedEmail();
    }

    /**
     * Determina si el usuario puede crear nuevos medicamentos
     * Requiere rol de administrador, farmacéutico o médico
     */
    public function create(User $user): bool
    {
        // Solo administradores, farmacéuticos o médicos con correo verificado pueden crear medicamentos
        return $user->hasVerifiedEmail() && (
            $user->isAdmin() ||
            $user->isPharmacist() ||
            $user->isDoctor()
        );
    }

    /**
     * Determina si el usuario puede actualizar un medicamento existente
     * Requiere rol de administrador, farmacéutico o médico
     */
    public function update(User $user, Medication $medication): bool
    {
        // Solo administradores, farmacéuticos o médicos con correo verificado pueden actualizar medicamentos
        return $user->hasVerifiedEmail() && (
            $user->isAdmin() ||
            $user->isPharmacist() ||
            $user->isDoctor()
        );
    }

    /**
     * Determina si el usuario puede eliminar un medicamento
     * Requiere rol de administrador
     */
    public function delete(User $user, Medication $medication): bool
    {
        // Solo administradores con correo verificado pueden eliminar medicamentos
        return $user->hasVerifiedEmail() && $user->isAdmin();
    }

    /**
     * Determina si el usuario puede restaurar un medicamento eliminado
     * Requiere rol de administrador
     */
    public function restore(User $user, Medication $medication): bool
    {
        // Solo administradores con correo verificado pueden restaurar medicamentos eliminados
        return $user->hasVerifiedEmail() && $user->isAdmin();
    }

    /**
     * Determina si el usuario puede eliminar permanentemente un medicamento
     * Requiere rol de administrador
     */
    public function forceDelete(User $user, Medication $medication): bool
    {
        // Solo administradores con correo verificado pueden eliminar medicamentos permanentemente
        return $user->hasVerifiedEmail() && $user->isAdmin();
    }
}
