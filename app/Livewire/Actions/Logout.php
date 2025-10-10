<?php

namespace App\Livewire\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/**
 * Clase para gestionar el cierre de sesión de usuarios
 * Proporciona la funcionalidad para cerrar sesión de forma segura
 */
class Logout
{
    /**
     * Cierra la sesión del usuario actual en la aplicación
     * Invalida la sesión y regenera el token de seguridad
     */
    public function __invoke(): void
    {
        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();
    }
}
