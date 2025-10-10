<?php

namespace App\Providers;

use App\Models\ActiveIngredient;
use App\Models\AdministrationRoute;
use App\Models\CompatibilityType;
use App\Models\ConcentrationUnit;
use App\Models\Medication;
use App\Models\PharmacodynamicInteraction;
use App\Models\PharmacokineticInteraction;
use App\Models\PhysicochemicalInteraction;
use App\Policies\ActiveIngredientPolicy;
use App\Policies\AdministrationRoutePolicy;
use App\Policies\CompatibilityTypePolicy;
use App\Policies\ConcentrationUnitPolicy;
use App\Policies\InteractionValidatorPolicy;
use App\Policies\MedicationPolicy;
use App\Policies\PharmacodynamicInteractionPolicy;
use App\Policies\PharmacokineticInteractionPolicy;
use App\Policies\PhysicochemicalInteractionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        ActiveIngredient::class => ActiveIngredientPolicy::class,
        AdministrationRoute::class => AdministrationRoutePolicy::class,
        CompatibilityType::class => CompatibilityTypePolicy::class,
        ConcentrationUnit::class => ConcentrationUnitPolicy::class,
        Medication::class => MedicationPolicy::class,
        PhysicochemicalInteraction::class => PhysicochemicalInteractionPolicy::class,
        PharmacodynamicInteraction::class => PharmacodynamicInteractionPolicy::class,
        PharmacokineticInteraction::class => PharmacokineticInteractionPolicy::class,
        // For non-model components like InteractionValidator, we'll register policies manually
        'InteractionValidator' => InteractionValidatorPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
