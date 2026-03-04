<x-admin-layout
    title="Crear Ticket de Soporte"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Soporte', 'href' => route('admin.tickets.index')],
        ['name' => 'Nuevo']
    ]"
>
    <div class="p-6 overflow-hidden bg-white shadow-xl sm:rounded-lg">
        <form action="{{ route('admin.tickets.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 gap-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Título del problema</label>
                    <input type="text" name="title" id="title"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('title') border-red-500 @enderror"
                           value="{{ old('title') }}" required placeholder="Ej: Sistema lento">
                    @error('title')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Descripción detallada</label>
                    <textarea name="description" id="description" rows="5"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('description') border-red-500 @enderror"
                              required placeholder="Describe tu problema o duda...">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Priority -->
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700">Prioridad</label>
                    <select name="priority" id="priority"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('priority') border-red-500 @enderror"
                            required>
                        <option value="">Selecciona una prioridad</option>
                        <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Baja</option>
                        <option value="normal" {{ old('priority') === 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>Alta</option>
                        <option value="urgent" {{ old('priority') === 'urgent' ? 'selected' : '' }}>Urgente</option>
                    </select>
                    @error('priority')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-8 flex gap-3">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fa-solid fa-check mr-2"></i> Crear Ticket
                </button>
                <a href="{{ route('admin.tickets.index') }}"
                   class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-md font-medium transition-colors">
                    <i class="fa-solid fa-times mr-2"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>
