{{--
    Vista Livewire para gestión de interacciones farmacodinámicas
    Muestra una tabla con las interacciones farmacodinámicas entre medicamentos
    Permite crear, editar, activar/desactivar y eliminar interacciones
--}}
<div>
    {{-- Componente de notificación --}}
    <x-action-message on="notify" class="fixed top-4 right-4 z-50 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg" />

    {{-- Encabezado con título y botón de nueva interacción --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Interacciones Farmacodinámicas</h1>
        <button wire:click="openModal" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
            <i class="fas fa-plus mr-2"></i> Nueva Interacción Farmacodinámica
        </button>
    </div>

    {{-- Barra de búsqueda --}}
    <div class="mb-6">
        <div class="relative">
            <input wire:model.live="search" type="text" placeholder="Buscar por medicamento..." class="w-full px-4 py-2 pl-10 pr-4 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                <i class="fas fa-search text-gray-400"></i>
            </div>
        </div>
    </div>

    {{-- Tabla de interacciones farmacodinámicas --}}
    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Medicamento 1</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Medicamento 2</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo de Compatibilidad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mecanismo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Significancia Clínica</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($pharmacodynamicInteractions as $pharmacodynamicInteraction)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $pharmacodynamicInteraction->medication1->commercial_name }}</div>
                                <div class="text-sm text-gray-500">{{ $pharmacodynamicInteraction->medication1->concentration }} {{ $pharmacodynamicInteraction->medication1->concentrationUnit->symbol }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $pharmacodynamicInteraction->medication2->commercial_name }}</div>
                                <div class="text-sm text-gray-500">{{ $pharmacodynamicInteraction->medication2->concentration }} {{ $pharmacodynamicInteraction->medication2->concentrationUnit->symbol }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="inline-block w-3 h-3 rounded-full mr-2" style="background-color: {{ $pharmacodynamicInteraction->compatibilityType->color }};"></span>
                                    <span class="text-sm text-gray-900">{{ $pharmacodynamicInteraction->compatibilityType->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ Str::limit($pharmacodynamicInteraction->mechanism, 50) ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ Str::limit($pharmacodynamicInteraction->clinical_effects, 50) ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $pharmacodynamicInteraction->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $pharmacodynamicInteraction->is_active ? 'Activa' : 'Inactiva' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="edit({{ $pharmacodynamicInteraction->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="toggleActive({{ $pharmacodynamicInteraction->id }})" class="text-yellow-600 hover:text-yellow-900 mr-3">
                                    <i class="fas fa-power-off"></i>
                                </button>
                                <button wire:click="confirmDelete({{ $pharmacodynamicInteraction->id }})" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                No se encontraron interacciones farmacodinámicas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Paginación --}}
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="flex-1 flex justify-between sm:hidden">
                {{ $pharmacodynamicInteractions->links() }}
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Mostrando <span class="font-medium">{{ $pharmacodynamicInteractions->firstItem() }}</span> a
                        <span class="font-medium">{{ $pharmacodynamicInteractions->lastItem() }}</span> de
                        <span class="font-medium">{{ $pharmacodynamicInteractions->total() }}</span> resultados
                    </p>
                </div>
                <div>
                    {{ $pharmacodynamicInteractions->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Modal para crear/editar interacción --}}
    @if ($showModal)
        <div class="fixed inset-0 overflow-y-auto z-50">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" wire:click="closeModal">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <form wire:submit="store">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="col-span-2 sm:col-span-1">
                                    <x-input-label for="medication1_id" :value="__('Medicamento 1')" />
                                    <select wire:model="medication1_id" id="medication1_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">Seleccionar medicamento</option>
                                        @foreach ($medications as $medication)
                                            <option value="{{ $medication->id }}">{{ $medication->commercial_name }} ({{ $medication->concentration }} {{ $medication->concentrationUnit->symbol }})</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('medication1_id')" class="mt-2" />
                                </div>

                                <div class="col-span-2 sm:col-span-1">
                                    <x-input-label for="medication2_id" :value="__('Medicamento 2')" />
                                    <select wire:model="medication2_id" id="medication2_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">Seleccionar medicamento</option>
                                        @foreach ($medications as $medication)
                                            <option value="{{ $medication->id }}">{{ $medication->commercial_name }} ({{ $medication->concentration }} {{ $medication->concentrationUnit->symbol }})</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('medication2_id')" class="mt-2" />
                                </div>

                                <div class="col-span-2">
                                    <x-input-label for="compatibility_type_id" :value="__('Tipo de Compatibilidad')" />
                                    <select wire:model="compatibility_type_id" id="compatibility_type_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">Seleccionar tipo</option>
                                        @foreach ($compatibilityTypes as $compatibilityType)
                                            <option value="{{ $compatibilityType->id }}">{{ $compatibilityType->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('compatibility_type_id')" class="mt-2" />
                                </div>

                                <div class="col-span-2">
                                    <x-input-label for="interaction_type" :value="__('Tipo de Interacción')" />
                                    <select wire:model="interaction_type" id="interaction_type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">Seleccionar tipo</option>
                                        <option value="Sinérgica">Sinérgica</option>
                                        <option value="Antagonista">Antagonista</option>
                                        <option value="Aditiva">Aditiva</option>
                                        <option value="Potenciación">Potenciación</option>
                                        <option value="Inhibición">Inhibición</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('interaction_type')" class="mt-2" />
                                </div>

                                <div class="col-span-2">
                                    <x-input-label for="description" :value="__('Descripción')" />
                                    <textarea wire:model="description" id="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3" name="description"></textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>

                                <div class="col-span-2">
                                    <x-input-label for="mechanism" :value="__('Mecanismo')" />
                                    <textarea wire:model="mechanism" id="mechanism" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3" name="mechanism"></textarea>
                                    <x-input-error :messages="$errors->get('mechanism')" class="mt-2" />
                                </div>

                                <div class="col-span-2">
                                    <x-input-label for="clinical_effects" :value="__('Efectos Clínicos')" />
                                    <textarea wire:model="clinical_effects" id="clinical_effects" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3" name="clinical_effects"></textarea>
                                    <x-input-error :messages="$errors->get('clinical_effects')" class="mt-2" />
                                </div>

                                <div class="col-span-2">
                                    <x-input-label for="recommendations" :value="__('Recomendaciones')" />
                                    <textarea wire:model="recommendations" id="recommendations" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3" name="recommendations"></textarea>
                                    <x-input-error :messages="$errors->get('recommendations')" class="mt-2" />
                                </div>

                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Estado</label>
                                    <div class="mt-1">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" wire:model="is_active" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <span class="ml-2">Activa</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                {{ $pharmacodynamic_interaction_id ? 'Actualizar' : 'Guardar' }}
                            </button>
                            <button type="button" wire:click="closeModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal de confirmación para eliminar --}}
    @if ($showDeleteModal)
        <div class="fixed inset-0 overflow-y-auto z-50">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" wire:click="cancelDelete">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-exclamation-triangle text-red-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Eliminar Interacción Farmacodinámica
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        ¿Está seguro que desea eliminar esta interacción farmacodinámica? Esta acción no se puede deshacer.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" wire:click="delete" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Eliminar
                        </button>
                        <button type="button" wire:click="cancelDelete" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
