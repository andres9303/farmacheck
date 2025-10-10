<?php

namespace App\Policies;

use App\Models\User;

class InteractionValidatorPolicy
{
    /**
     * Determine whether the user can access the interaction validator.
     */
    public function access(User $user): bool
    {
        // Todos los usuarios autenticados y verificados pueden acceder al validador de interacciones
        return $user->hasVerifiedEmail();
    }

    /**
     * Determine whether the user can validate interactions.
     */
    public function validate(User $user): bool
    {
        // Todos los usuarios autenticados y verificados pueden validar interacciones
        return $user->hasVerifiedEmail();
    }

    /**
     * Determine whether the user can export validation results.
     */
    public function export(User $user): bool
    {
        // Solo usuarios con roles específicos pueden exportar resultados
        return $user->hasVerifiedEmail() && (
            $user->isAdmin() || 
            $user->isPharmacist() || 
            $user->isDoctor()
        );
    }
}
