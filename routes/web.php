<?php

/**
 * Archivo de rutas web de la aplicación
 * Define todas las rutas accesibles desde el navegador
 */

use Illuminate\Support\Facades\Route;
use App\Livewire\ActiveIngredients;
use App\Livewire\AdministrationRoutes;
use App\Livewire\ConcentrationUnits;
use App\Livewire\Medications;
use App\Livewire\CompatibilityTypes;
use App\Livewire\PhysicochemicalInteractions;
use App\Livewire\PharmacodynamicInteractions;
use App\Livewire\PharmacokineticInteractions;
use App\Livewire\InteractionValidator;
use App\Livewire\CompatibilityMatrix;
use App\Http\Controllers\InteractionValidatorController;
use Livewire\Volt\Volt;

// Redirigir la página inicial al login
Route::redirect('/', '/login');

// Ruta del dashboard (requiere autenticación y verificación)
Route::get('dashboard', \App\Livewire\Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Ruta del perfil de usuario (requiere autenticación)
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Rutas para operaciones CRUD (requieren autenticación y verificación)
Route::middleware(['auth', 'verified'])->group(function () {
    // Gestión de principios activos
    Route::get('/active-ingredients', ActiveIngredients::class)->name('active-ingredients');
    // Gestión de vías de administración
    Route::get('/administration-routes', AdministrationRoutes::class)->name('administration-routes');
    // Gestión de unidades de concentración
    Route::get('/concentration-units', ConcentrationUnits::class)->name('concentration-units');
    // Gestión de medicamentos
    Route::get('/medications', Medications::class)->name('medications');
    // Gestión de tipos de compatibilidad
    Route::get('/compatibility-types', CompatibilityTypes::class)->name('compatibility-types');
    // Gestión de interacciones fisicoquímicas
    Route::get('/physicochemical-interactions', PhysicochemicalInteractions::class)->name('physicochemical-interactions');
    // Gestión de interacciones farmacodinámicas
    Route::get('/pharmacodynamic-interactions', PharmacodynamicInteractions::class)->name('pharmacodynamic-interactions');
    // Gestión de interacciones farmacocinéticas
    Route::get('/pharmacokinetic-interactions', PharmacokineticInteractions::class)->name('pharmacokinetic-interactions');
    // Validador de interacciones
    Route::get('/interaction-validator', InteractionValidator::class)->name('interaction-validator');
    // Matriz de compatibilidad
    Route::get('/compatibility-matrix', CompatibilityMatrix::class)->name('compatibility-matrix');
    
    // Rutas API
    Route::post('/interaction-validator/validate', [InteractionValidatorController::class, 'validate'])->name('interaction-validator.validate');
});

// Incluir rutas de autenticación
require __DIR__.'/auth.php';
