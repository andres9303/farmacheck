<?php
// Componente de navegación principal del sistema
// Gestiona el menú de navegación y la autenticación de usuarios

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Cierra la sesión del usuario actual y lo redirige a la página principal.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

{{-- Navegación principal de la aplicación --}}
<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm">
    {{-- Menú de navegación primario --}}
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                {{-- Logo --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" wire:navigate>
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                {{-- Enlaces de navegación --}}
                <div class="hidden space-x-2 sm:ms-6 sm:flex sm:items-center">
                    {{-- Panel de Control --}}
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    
                    {{-- Catálogo (Dropdown) --}}
                    <div class="relative" x-data="{ dropdownOpen: false }" @click.outside="dropdownOpen = false">
                        <button @click="dropdownOpen = !dropdownOpen" class="inline-flex items-center h-16 px-4 border-b-2 border-transparent text-sm font-medium text-gray-700 hover:text-gray-900 hover:border-gray-300 focus:outline-none focus:text-gray-900 focus:border-gray-300 transition duration-150 ease-in-out">
                            <span>{{ __('Catálogo') }}</span>
                            <svg class="ms-2 h-4 w-4 transition-transform" :class="{'rotate-180': dropdownOpen}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        
                        <div x-show="dropdownOpen"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             class="absolute left-0 top-full mt-0 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
                             style="display: none;">
                            <div class="py-2" role="menu">
                                <a href="{{ route('active-ingredients') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" wire:navigate>
                                    {{ __('Principios Activos') }}
                                </a>
                                <a href="{{ route('administration-routes') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" wire:navigate>
                                    {{ __('Vías de Administración') }}
                                </a>
                                <a href="{{ route('concentration-units') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" wire:navigate>
                                    {{ __('Unidades de Concentración') }}
                                </a>
                                <a href="{{ route('medications') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" wire:navigate>
                                    {{ __('Medicamentos') }}
                                </a>
                                <a href="{{ route('compatibility-types') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" wire:navigate>
                                    {{ __('Tipos de Compatibilidad') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Interacciones (Dropdown) --}}
                    <div class="relative" x-data="{ dropdownOpen: false }" @click.outside="dropdownOpen = false">
                        <button @click="dropdownOpen = !dropdownOpen" class="inline-flex items-center h-16 px-4 border-b-2 border-transparent text-sm font-medium text-gray-700 hover:text-gray-900 hover:border-gray-300 focus:outline-none focus:text-gray-900 focus:border-gray-300 transition duration-150 ease-in-out">
                            <span>{{ __('Interacciones') }}</span>
                            <svg class="ms-2 h-4 w-4 transition-transform" :class="{'rotate-180': dropdownOpen}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        
                        <div x-show="dropdownOpen"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             class="absolute left-0 top-full mt-0 w-64 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
                             style="display: none;">
                            <div class="py-2" role="menu">
                                <a href="{{ route('physicochemical-interactions') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" wire:navigate>
                                    {{ __('Interacciones Fisicoquímicas') }}
                                </a>
                                <a href="{{ route('pharmacodynamic-interactions') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" wire:navigate>
                                    {{ __('Interacciones Farmacodinámicas') }}
                                </a>
                                <a href="{{ route('pharmacokinetic-interactions') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" wire:navigate>
                                    {{ __('Interacciones Farmacocinéticas') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Herramientas (Dropdown) --}}
                    <div class="relative" x-data="{ dropdownOpen: false }" @click.outside="dropdownOpen = false">
                        <button @click="dropdownOpen = !dropdownOpen" class="inline-flex items-center h-16 px-4 border-b-2 border-transparent text-sm font-medium text-gray-700 hover:text-gray-900 hover:border-gray-300 focus:outline-none focus:text-gray-900 focus:border-gray-300 transition duration-150 ease-in-out">
                            <span>{{ __('Herramientas') }}</span>
                            <svg class="ms-2 h-4 w-4 transition-transform" :class="{'rotate-180': dropdownOpen}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        
                        <div x-show="dropdownOpen"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             class="absolute left-0 top-full mt-0 w-60 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
                             style="display: none;">
                            <div class="py-2" role="menu">
                                <a href="{{ route('interaction-validator') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" wire:navigate>
                                    {{ __('Validador de Interacciones') }}
                                </a>
                                <a href="{{ route('compatibility-matrix') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" wire:navigate>
                                    {{ __('Matriz de Compatibilidad') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Dropdown de configuración --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        {{-- Autenticación --}}
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Menú hamburguesa para móviles --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Menú de navegación responsive --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            {{-- Catálogo (Dropdown móvil) --}}
            <div x-data="{ dropdownOpen: false }">
                <button @click="dropdownOpen = !dropdownOpen" class="flex items-center justify-between w-full px-4 py-2 text-left text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none">
                    <span>{{ __('Catálogo') }}</span>
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div x-show="dropdownOpen" class="pl-8 space-y-1">
                    <x-responsive-nav-link :href="route('active-ingredients')" :active="request()->routeIs('active-ingredients')" wire:navigate>
                        {{ __('Principios Activos') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('administration-routes')" :active="request()->routeIs('administration-routes')" wire:navigate>
                        {{ __('Vías de Administración') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('concentration-units')" :active="request()->routeIs('concentration-units')" wire:navigate>
                        {{ __('Unidades de Concentración') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('medications')" :active="request()->routeIs('medications')" wire:navigate>
                        {{ __('Medicamentos') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('compatibility-types')" :active="request()->routeIs('compatibility-types')" wire:navigate>
                        {{ __('Tipos de Compatibilidad') }}
                    </x-responsive-nav-link>
                </div>
            </div>
            
            {{-- Interacciones (Dropdown móvil) --}}
            <div x-data="{ dropdownOpen: false }">
                <button @click="dropdownOpen = !dropdownOpen" class="flex items-center justify-between w-full px-4 py-2 text-left text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none">
                    <span>{{ __('Interacciones') }}</span>
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div x-show="dropdownOpen" class="pl-8 space-y-1">
                    <x-responsive-nav-link :href="route('physicochemical-interactions')" :active="request()->routeIs('physicochemical-interactions')" wire:navigate>
                        {{ __('Interacciones Fisicoquímicas') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('pharmacodynamic-interactions')" :active="request()->routeIs('pharmacodynamic-interactions')" wire:navigate>
                        {{ __('Interacciones Farmacodinámicas') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('pharmacokinetic-interactions')" :active="request()->routeIs('pharmacokinetic-interactions')" wire:navigate>
                        {{ __('Interacciones Farmacocinéticas') }}
                    </x-responsive-nav-link>
                </div>
            </div>
            
            {{-- Herramientas (Dropdown móvil) --}}
            <div x-data="{ dropdownOpen: false }">
                <button @click="dropdownOpen = !dropdownOpen" class="flex items-center justify-between w-full px-4 py-2 text-left text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none">
                    <span>{{ __('Herramientas') }}</span>
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div x-show="dropdownOpen" class="pl-8 space-y-1">
                    <x-responsive-nav-link :href="route('interaction-validator')" :active="request()->routeIs('interaction-validator')" wire:navigate>
                        {{ __('Validador de Interacciones') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('compatibility-matrix')" :active="request()->routeIs('compatibility-matrix')" wire:navigate>
                        {{ __('Matriz de Compatibilidad') }}
                    </x-responsive-nav-link>
                </div>
            </div>
        </div>

        {{-- Opciones de configuración responsive --}}
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                {{-- Autenticación móvil --}}
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>
