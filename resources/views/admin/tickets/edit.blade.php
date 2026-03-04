<x-admin-layout
    title="Editar Ticket de Soporte"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Soporte', 'href' => route('admin.tickets.index')],
        ['name' => '#' . $ticket->id, 'href' => route('admin.tickets.show', $ticket)],
        ['name' => 'Editar']
    ]"
>
    <div class="p-6 overflow-hidden bg-white shadow-xl sm:rounded-lg">
        <form action="{{ route('admin.tickets.update', $ticket) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Título del problema</label>
                    <input type="text" name="title" id="title"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('title') border-red-500 @enderror"
                           value="{{ old('title', $ticket->title) }}" required>
                    @error('title')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Descripción detallada</label>
                    <textarea name="description" id="description" rows="5"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('description') border-red-500 @enderror"
                              required>{{ old('description', $ticket->description) }}</textarea>
                    @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                    <select name="status" id="status"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('status') border-red-500 @enderror"
                            required>
                        <option value="open" {{ old('status', $ticket->status) === 'open' ? 'selected' : '' }}>Abierto</option>
                        <option value="in_progress" {{ old('status', $ticket->status) === 'in_progress' ? 'selected' : '' }}>En progreso</option>
                        <option value="resolved" {{ old('status', $ticket->status) === 'resolved' ? 'selected' : '' }}>Resuelto</option>
                        <option value="closed" {{ old('status', $ticket->status) === 'closed' ? 'selected' : '' }}>Cerrado</option>
                    </select>
                    @error('status')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Priority -->
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700">Prioridad</label>
                    <select name="priority" id="priority"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('priority') border-red-500 @enderror"
                            required>
                        <option value="low" {{ old('priority', $ticket->priority) === 'low' ? 'selected' : '' }}>Baja</option>
                        <option value="normal" {{ old('priority', $ticket->priority) === 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="high" {{ old('priority', $ticket->priority) === 'high' ? 'selected' : '' }}>Alta</option>
                        <option value="urgent" {{ old('priority', $ticket->priority) === 'urgent' ? 'selected' : '' }}>Urgente</option>
                    </select>
                    @error('priority')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info -->
                <div class="p-4 bg-gray-50 rounded-lg grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Creado por</p>
                        <p class="font-medium text-gray-900">{{ $ticket->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Creado el</p>
                        <p class="font-medium text-gray-900">{{ $ticket->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Actualizado el</p>
                        <p class="font-medium text-gray-900">{{ $ticket->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-8 flex gap-3">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fa-solid fa-save mr-2"></i> Guardar cambios
                </button>
                <a href="{{ route('admin.tickets.show', $ticket) }}"
                   class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-md font-medium transition-colors">
                    <i class="fa-solid fa-times mr-2"></i> Cancelar
                </a>
            </div>
        </form>
    </div>

    @push('js')
        <script>
            @if (session()->has('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
            });
            @endif
        </script>
    @endpush
</x-admin-layout>
