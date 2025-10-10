{{--
    Vista Livewire para la matriz de compatibilidad de medicamentos
    Permite seleccionar medicamentos y generar una matriz visual de sus interacciones
    Muestra detalles de las interacciones al hacer clic en la matriz
--}}
<div>
    {{-- Componente de notificación --}}
    <x-action-message on="notify" class="fixed top-4 right-4 z-50 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg" />

    {{-- Encabezado con título y descripción --}}
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Matriz de Compatibilidad</h1>
        <p class="mt-2 text-gray-600">Seleccione medicamentos para generar una matriz visual de sus interacciones.</p>
    </div>

    {{-- Panel de configuración --}}
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Filtro de tipo de interacción --}}
            <div>
                <x-input-label for="interaction_type" :value="__('Tipo de Interacción')" />
                <select wire:model.live="interactionType" id="interactionType" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="all">Todas las interacciones</option>
                    <option value="physicochemical">Fisicoquímicas</option>
                    <option value="pharmacodynamic">Farmacodinámicas</option>
                    <option value="pharmacokinetic">Farmacocinéticas</option>
                </select>
            </div>

            {{-- Límite de tamaño de la matriz --}}
            <div>
                <x-input-label for="limit" :value="__('Límite de Matriz')" />
                <select wire:model.live="limit" id="limit" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="5">5 medicamentos</option>
                    <option value="10" selected>10 medicamentos</option>
                    <option value="15">15 medicamentos</option>
                    <option value="20">20 medicamentos</option>
                </select>
            </div>

            {{-- Botón de exportación (deshabilitado) --}}
            <div class="flex items-end">
                @if (1==0)
                    <button wire:click="exportToCSV" class="w-full px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                        <i class="fas fa-download mr-2"></i> Exportar a CSV
                    </button>
                @endif
            </div>
        </div>
    </div>

    {{-- Selección de medicamentos --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        {{-- Lista de medicamentos disponibles --}}
        <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-4">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Lista de Medicamentos</h3>
            <div class="mb-4">
                <input wire:model.live="search" type="text" placeholder="Buscar medicamento..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <div class="max-h-60 overflow-y-auto">
                {{ $medications->links() }}
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
            <h3 class="text-lg font-medium text-gray-900 mb-4">
                Medicamentos Seleccionados
                <span class="text-sm font-normal text-gray-500">({{ count($selectedMedications) }}/{{ $limit }})</span>
            </h3>
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
                <div class="mt-4 space-y-2">
                    <button wire:click="clearSelection"
                            class="w-full px-3 py-2 bg-gray-200 text-gray-700 text-sm rounded hover:bg-gray-300">
                        Limpiar Selección
                    </button>
                    @if (count($selectedMedications) >= 2)
                        <button wire:click="generateMatrix"
                                class="w-full px-3 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                            Generar Matriz
                        </button>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- Matriz de compatibilidad --}}
    @if ($showMatrix && !empty($matrixData))
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Matriz de Compatibilidad</h2>
            
            {{-- Leyenda de colores --}}
            <div class="mb-4 flex flex-wrap gap-2">
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-green-500 rounded mr-2"></div>
                    <span class="text-sm">Compatible</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-red-500 rounded mr-2"></div>
                    <span class="text-sm">Incompatible</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-yellow-500 rounded mr-2"></div>
                    <span class="text-sm">Precaución</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-blue-500 rounded mr-2"></div>
                    <span class="text-sm">Condicional</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-gray-300 rounded mr-2"></div>
                    <span class="text-sm">Desconocido</span>
                </div>
            </div>

            {{-- Tabla de la matriz --}}
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse">
                    <thead>
                        <tr>
                            <th class="border border-gray-300 bg-gray-100 p-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Medicamento
                            </th>
                            @foreach ($selectedMedications as $medicationId)
                                <th class="border border-gray-300 bg-gray-100 p-2 text-center text-xs font-medium text-gray-700 uppercase tracking-wider" style="min-width: 80px;">
                                    {{ $matrixData['medications'][$medicationId]->commercial_name ?? 'Medicamento ' . $medicationId }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($selectedMedications as $medicationId)
                            <tr>
                                <td class="border border-gray-300 bg-gray-50 p-2 text-left text-sm font-medium text-gray-900">
                                    {{ $matrixData['medications'][$medicationId]->commercial_name ?? 'Medicamento ' . $medicationId }}
                                </td>
                                @foreach ($selectedMedications as $otherMedicationId)
                                    <td class="border border-gray-300 p-2 text-center">
                                        @if ($medicationId == $otherMedicationId)
                                            <div class="w-full h-full bg-gray-200 rounded flex items-center justify-center">
                                                <span class="text-gray-500">-</span>
                                            </div>
                                        @else
                                            @if (isset($matrixData['matrix'][$medicationId][$otherMedicationId]))
                                                <button wire:click="$set('selectedInteraction', '{{ $medicationId }}-{{ $otherMedicationId }}')"
                                                        class="w-full h-8 rounded flex items-center justify-center hover:opacity-80 transition-opacity"
                                                        style="background-color: {{ $matrixData['matrix'][$medicationId][$otherMedicationId]['color'] }};">
                                                    <span class="text-white font-bold text-xs">
                                                        {{ $matrixData['matrix'][$medicationId][$otherMedicationId]['label'] }}
                                                    </span>
                                                </button>
                                            @else
                                                <div class="w-full h-8 bg-gray-300 rounded flex items-center justify-center">
                                                    <span class="text-gray-600 font-bold text-xs">?</span>
                                                </div>
                                            @endif
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal de detalles de interacción --}}
        @if (isset($selectedInteraction) && str_contains($selectedInteraction, '-'))
            @php
                $parts = explode('-', $selectedInteraction);
                $medicationId1 = $parts[0] ?? null;
                $medicationId2 = $parts[1] ?? null;
                $interactionDetails = null;
                
                if ($medicationId1 && $medicationId2) {
                    $interactionDetails = $this->getInteractionDetails($medicationId1, $medicationId2);
                }
            @endphp
            
            @if ($interactionDetails)
                <div class="fixed inset-0 overflow-y-auto z-50">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 transition-opacity" wire:click="$set('selectedInteraction', null)">
                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>

                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="mb-4">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                        Detalles de Interacción
                                    </h3>
                                </div>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                    <div class="p-3 bg-gray-50 rounded-lg">
                                        <h4 class="font-medium text-gray-900 mb-1">Medicamento 1</h4>
                                        <p class="text-gray-700">{{ $interactionDetails['medication1']->commercial_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $interactionDetails['medication1']->concentration }} {{ $interactionDetails['medication1']->concentrationUnit->symbol }}</p>
                                    </div>
                                    <div class="p-3 bg-gray-50 rounded-lg">
                                        <h4 class="font-medium text-gray-900 mb-1">Medicamento 2</h4>
                                        <p class="text-gray-700">{{ $interactionDetails['medication2']->commercial_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $interactionDetails['medication2']->concentration }} {{ $interactionDetails['medication2']->concentrationUnit->symbol }}</p>
                                    </div>
                                </div>

                                <div class="mb-4 p-3 rounded-lg {{ $this->getRiskLevelColorClass($interactionDetails['risk_level']) }}">
                                    <h4 class="font-medium mb-1">Nivel de Riesgo</h4>
                                    <p>{{ $interactionDetails['description'] }}</p>
                                </div>

                                {{-- Información de depuración: mostrar conteos de interacciones --}}
                                @if(config('app.debug'))
                                    <div class="mb-4 p-4 bg-blue-100 border border-blue-400 rounded">
                                        <p class="text-blue-700">Fisicoquímicas: {{ $interactionDetails['interactions']['physicochemical']->count() }}</p>
                                        <p class="text-blue-700">Farmacodinámicas: {{ $interactionDetails['interactions']['pharmacodynamic']->count() }}</p>
                                        <p class="text-blue-700">Farmacocinéticas: {{ $interactionDetails['interactions']['pharmacokinetic']->count() }}</p>
                                    </div>
                                @endif
                                
                                <div class="space-y-4">
                                    {{-- Mostrar siempre todas las secciones de interacción, incluso si están vacías --}}
                                    <div>
                                        <h4 class="font-medium text-gray-900 mb-2">
                                            Interacciones Fisicoquímicas
                                            <span class="text-sm font-normal text-gray-500">({{ $interactionDetails['interactions']['physicochemical']->count() }})</span>
                                        </h4>
                                        @if ($interactionDetails['interactions']['physicochemical']->count() > 0)
                                            @foreach ($interactionDetails['interactions']['physicochemical'] as $interaction)
                                                <div class="p-3 bg-gray-50 rounded-lg mb-2">
                                                    <div class="flex items-center mb-1">
                                                        <span class="inline-block w-3 h-3 rounded-full mr-2"
                                                              style="background-color: {{ $interaction['compatibility_color'] }};"></span>
                                                        <span class="font-medium">{{ $interaction['compatibility_type'] }}</span>
                                                    </div>
                                                    @if ($interaction['description'])
                                                        <p class="text-sm text-gray-600 mb-1">{{ $interaction['description'] }}</p>
                                                    @endif
                                                    @if ($interaction['recommendations'])
                                                        <p class="text-sm text-gray-600">
                                                            <span class="font-medium">Recomendaciones:</span> {{ $interaction['recommendations'] }}
                                                        </p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="p-3 bg-gray-50 rounded-lg">
                                                <p class="text-sm text-gray-500">No hay interacciones fisicoquímicas registradas para esta combinación.</p>
                                            </div>
                                        @endif
                                    </div>

                                    <div>
                                        <h4 class="font-medium text-gray-900 mb-2">
                                            Interacciones Farmacodinámicas
                                            <span class="text-sm font-normal text-gray-500">({{ $interactionDetails['interactions']['pharmacodynamic']->count() }})</span>
                                        </h4>
                                        @if ($interactionDetails['interactions']['pharmacodynamic']->count() > 0)
                                            @foreach ($interactionDetails['interactions']['pharmacodynamic'] as $interaction)
                                                <div class="p-3 bg-gray-50 rounded-lg mb-2">
                                                    <div class="flex items-center mb-1">
                                                        <span class="inline-block w-3 h-3 rounded-full mr-2"
                                                              style="background-color: {{ $interaction['compatibility_color'] }};"></span>
                                                        <span class="font-medium">{{ $interaction['compatibility_type'] }}</span>
                                                    </div>
                                                    @if ($interaction['description'])
                                                        <p class="text-sm text-gray-600 mb-1">{{ $interaction['description'] }}</p>
                                                    @endif
                                                    @if ($interaction['mechanism'])
                                                        <p class="text-sm text-gray-600 mb-1">
                                                            <span class="font-medium">Mecanismo:</span> {{ $interaction['mechanism'] }}
                                                        </p>
                                                    @endif
                                                    @if ($interaction['recommendations'])
                                                        <p class="text-sm text-gray-600">
                                                            <span class="font-medium">Recomendaciones:</span> {{ $interaction['recommendations'] }}
                                                        </p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="p-3 bg-gray-50 rounded-lg">
                                                <p class="text-sm text-gray-500">No hay interacciones farmacodinámicas registradas para esta combinación.</p>
                                            </div>
                                        @endif
                                    </div>

                                    <div>
                                        <h4 class="font-medium text-gray-900 mb-2">
                                            Interacciones Farmacocinéticas
                                            <span class="text-sm font-normal text-gray-500">({{ $interactionDetails['interactions']['pharmacokinetic']->count() }})</span>
                                        </h4>
                                        @if ($interactionDetails['interactions']['pharmacokinetic']->count() > 0)
                                            @foreach ($interactionDetails['interactions']['pharmacokinetic'] as $interaction)
                                                <div class="p-3 bg-gray-50 rounded-lg mb-2">
                                                    <div class="flex items-center mb-1">
                                                        <span class="inline-block w-3 h-3 rounded-full mr-2"
                                                              style="background-color: {{ $interaction['compatibility_color'] }};"></span>
                                                        <span class="font-medium">{{ $interaction['compatibility_type'] }}</span>
                                                    </div>
                                                    @if ($interaction['description'])
                                                        <p class="text-sm text-gray-600 mb-1">{{ $interaction['description'] }}</p>
                                                    @endif
                                                    <div class="text-sm text-gray-600">
                                                        @if ($interaction['absorption_effect'])
                                                            <p class="mb-1"><span class="font-medium">Efecto en Absorción:</span> {{ $interaction['absorption_effect'] }}</p>
                                                        @endif
                                                        @if ($interaction['distribution_effect'])
                                                            <p class="mb-1"><span class="font-medium">Efecto en Distribución:</span> {{ $interaction['distribution_effect'] }}</p>
                                                        @endif
                                                        @if ($interaction['metabolism_effect'])
                                                            <p class="mb-1"><span class="font-medium">Efecto en Metabolismo:</span> {{ $interaction['metabolism_effect'] }}</p>
                                                        @endif
                                                        @if ($interaction['excretion_effect'])
                                                            <p class="mb-1"><span class="font-medium">Efecto en Excreción:</span> {{ $interaction['excretion_effect'] }}</p>
                                                        @endif
                                                        @if ($interaction['recommendations'])
                                                            <p><span class="font-medium">Recomendaciones:</span> {{ $interaction['recommendations'] }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="p-3 bg-gray-50 rounded-lg">
                                                <p class="text-sm text-gray-500">No hay interacciones farmacocinéticas registradas para esta combinación.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="button" wire:click="$set('selectedInteraction', null)"
                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    @endif
</div>