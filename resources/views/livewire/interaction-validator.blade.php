{{--
    Vista Livewire para el validador de interacciones medicamentosas
    Permite seleccionar medicamentos y validar sus interacciones
    Muestra resultados detallados de las interacciones encontradas
--}}
<div>
    {{-- Componente de notificación --}}
    <x-action-message on="notify" class="fixed top-4 right-4 z-50 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg" />

    {{-- Encabezado con título y descripción --}}
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Validador de Interacciones Medicamentosas</h1>
        <p class="mt-2 text-gray-600">Seleccione los medicamentos que desea verificar para detectar posibles interacciones.</p>
    </div>

    {{-- Selección de modo de validación --}}
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <div class="flex flex-wrap gap-4">
            <button wire:click="$set('validationMode', 'multiple')"
                    class="px-4 py-2 rounded-lg font-medium transition-colors duration-200
                           {{ $validationMode === 'multiple'
                               ? 'bg-blue-600 text-white'
                               : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Validación Múltiple
            </button>
        </div>
    </div>

    {{-- Modo de validación múltiple --}}
    @if ($validationMode === 'multiple')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            {{-- Lista de medicamentos disponibles --}}
            <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Lista de Medicamentos</h3>
                <div class="mb-4">
                    <input wire:model.live="search" type="text" placeholder="Buscar medicamento..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <div class="max-h-60 overflow-y-auto">
                    @forelse ($medications as $medication)
                        <div class="p-3 border border-gray-200 rounded-lg mb-2 flex justify-between items-center">
                            <div>
                                <div class="font-medium text-gray-900">{{ $medication->commercial_name }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ $medication->concentration }} {{ $medication->concentrationUnit->symbol }}
                                    ({{ $medication->activeIngredient->name }})
                                </div>
                            </div>
                            <button wire:click="addMedication({{ $medication->id }})"
                                    class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700
                                           {{ in_array($medication->id, $selectedMedications) ? 'opacity-50 cursor-not-allowed' : '' }}">
                                {{ in_array($medication->id, $selectedMedications) ? 'Agregado' : 'Agregar' }}
                            </button>
                        </div>
                    @empty
                        <div class="text-center py-4 text-gray-500">No se encontraron medicamentos.</div>
                    @endforelse
                </div>
            </div>

            {{-- Lista de medicamentos seleccionados --}}
            <div class="bg-white rounded-lg shadow-sm p-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Medicamentos Seleccionados</h3>
                <div class="max-h-60 overflow-y-auto">
                    @forelse ($selectedMedicationObjects as $medication)
                        <div class="p-3 border border-gray-200 rounded-lg mb-2 flex justify-between items-center">
                            <div>
                                <div class="font-medium text-gray-900">{{ $medication->commercial_name }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ $medication->concentration }} {{ $medication->concentrationUnit->symbol }}
                                </div>
                            </div>
                            <button wire:click="removeMedication({{ $medication->id }})"
                                    class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                                Eliminar
                            </button>
                        </div>
                    @empty
                        <div class="text-center py-4 text-gray-500">No hay medicamentos seleccionados.</div>
                    @endforelse
                </div>
                @if (count($selectedMedications) > 0)
                    <div class="mt-4">
                        <button wire:click="clearSelection"
                                class="w-full px-3 py-2 bg-gray-200 text-gray-700 text-sm rounded hover:bg-gray-300">
                            Limpiar Selección
                        </button>
                    </div>
                @endif
            </div>
        </div>

        {{-- Botón de validación --}}
        <div class="flex justify-center mb-6">
            <button wire:click="validateMultiple"
                    wire:loading.attr="disabled"
                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700
                           transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                <span wire:loading.remove>Validar Interacciones</span>
                <span wire:loading>Validando...</span>
            </button>
        </div>
    @endif

    {{-- Estado de carga --}}
    @if ($isLoading)
        <div class="flex justify-center items-center py-12">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
        </div>
    @endif

    {{-- Resultados de la validación --}}
    @if ($showResults && $validationResults && $validationResults['status'] === 'success')
        {{-- Resultados de validación múltiple --}}
        @if ($validationMode === 'multiple')
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Resultados de la Validación</h2>
                
                {{-- Evaluación general --}}
                <div class="mb-6 p-4 rounded-lg border {{ $this->getRiskLevelColorClass($validationResults['overall_assessment']['level']) }}">
                    <div class="flex items-center">
                        <i class="{{ $this->getRiskLevelIcon($validationResults['overall_assessment']['level']) }} text-2xl mr-3"></i>
                        <div>
                            <h3 class="text-lg font-medium">Evaluación General: {{ $validationResults['overall_assessment']['label'] }}</h3>
                            <p class="text-sm">{{ $validationResults['overall_assessment']['description'] }}</p>
                        </div>
                    </div>
                </div>

                {{-- Información de medicamentos evaluados --}}
                <div class="mb-6">
                    <h4 class="font-medium text-gray-900 mb-2">Medicamentos Evaluados</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach ($validationResults['medications'] as $medication)
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="font-medium text-gray-900">{{ $medication['commercial_name'] }}</p>
                                <p class="text-sm text-gray-500">{{ $medication['concentration'] }}</p>
                                <p class="text-sm text-gray-500">PA: {{ $medication['active_ingredient'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Interacciones por pares --}}
                <div class="space-y-4">
                    <h4 class="font-medium text-gray-900">Interacciones por Pares</h4>
                    @foreach ($validationResults['pairwise_interactions'] as $pairKey => $pairResult)
                        <div class="p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center mb-2">
                                <i class="{{ $this->getRiskLevelIcon($pairResult['overall_risk_level']['level']) }} mr-2"></i>
                                <span class="font-medium">{{ $pairResult['medication_1']['commercial_name'] }} + {{ $pairResult['medication_2']['commercial_name'] }}</span>
                                <span class="ml-2 px-2 py-1 text-xs rounded-full {{ $this->getRiskLevelColorClass($pairResult['overall_risk_level']['level']) }}">
                                    {{ $pairResult['overall_risk_level']['label'] }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600">{{ $pairResult['overall_risk_level']['description'] }}</p>
                            
                            {{-- Mostrar detalles de interacciones si existen --}}
                            @if ($pairResult['interactions']['physicochemical']->count() > 0 ||
                                  $pairResult['interactions']['pharmacodynamic']->count() > 0 ||
                                  $pairResult['interactions']['pharmacokinetic']->count() > 0)
                                <div class="mt-2">
                                    <button wire:click="toggleDetails('{{ $pairKey }}')"
                                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        @if (isset($showDetails[$pairKey]))
                                            Ocultar detalles
                                        @else
                                            Ver detalles
                                        @endif
                                    </button>
                                    @if (isset($showDetails[$pairKey]))
                                        <div class="mt-2 p-3 bg-gray-50 rounded text-sm">
                                            @if ($pairResult['interactions']['physicochemical']->count() > 0)
                                                <p class="font-medium mb-1">Interacciones Fisicoquímicas:</p>
                                                @foreach ($pairResult['interactions']['physicochemical'] as $interaction)
                                                    <p class="ml-2">- {{ $interaction['compatibility_type'] }}: {{ $interaction['description'] ?? 'Sin descripción' }}</p>
                                                @endforeach
                                            @endif
                                            
                                            @if ($pairResult['interactions']['pharmacodynamic']->count() > 0)
                                                <p class="font-medium mb-1 mt-2">Interacciones Farmacodinámicas:</p>
                                                @foreach ($pairResult['interactions']['pharmacodynamic'] as $interaction)
                                                    <p class="ml-2">- {{ $interaction['compatibility_type'] }}: {{ $interaction['description'] ?? 'Sin descripción' }}</p>
                                                @endforeach
                                            @endif
                                            
                                            @if ($pairResult['interactions']['pharmacokinetic']->count() > 0)
                                                <p class="font-medium mb-1 mt-2">Interacciones Farmacocinéticas:</p>
                                                @foreach ($pairResult['interactions']['pharmacokinetic'] as $interaction)
                                                    <p class="ml-2">- {{ $interaction['compatibility_type'] }}: {{ $interaction['description'] ?? 'Sin descripción' }}</p>
                                                @endforeach
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @else
                                <p class="text-sm text-gray-500 mt-2">No se encontraron interacciones registradas.</p>
                            @endif
                        </div>
                    @endforeach
                </div>

                {{-- Botón de reinicio --}}
                <div class="mt-6 flex justify-center">
                    <button wire:click="resetResults"
                            class="px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300
                                   transition-colors duration-200">
                        Nueva Validación
                    </button>
                </div>
            </div>
        @endif
    @endif

    {{-- Estado de error --}}
    @if ($showResults && $validationResults && $validationResults['status'] === 'error')
        <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-6">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-600 text-xl mr-3"></i>
                <div>
                    <h3 class="text-lg font-medium text-red-900">Error en la Validación</h3>
                    <p class="text-red-700">{{ $validationResults['message'] }}</p>
                </div>
            </div>
            <div class="mt-4">
                <button wire:click="resetResults"
                        class="px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700
                               transition-colors duration-200">
                    Intentar de Nuevo
                </button>
            </div>
        </div>
    @endif
</div>