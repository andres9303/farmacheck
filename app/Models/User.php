<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Modelo para gestionar los usuarios del sistema
 * Extiende la funcionalidad de autenticación base de Laravel
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Los atributos que se pueden asignar masivamente
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',     // Nombre completo del usuario
        'email',    // Correo electrónico (único)
        'password', // Contraseña hasheada
    ];

    /**
     * Los atributos que deben ocultarse al serializar
     * Información sensible que no debe exponerse
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',        // Contraseña hasheada
        'remember_token',  // Token para recordar sesión
    ];

    /**
     * Obtiene los atributos que deben convertirse a tipos específicos
     * Define transformaciones para ciertos campos
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',  // Convertir a objeto DateTime
            'password' => 'hashed',             // Indica que la contraseña está hasheada
        ];
    }
}
