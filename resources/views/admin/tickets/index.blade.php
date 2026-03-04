<x-admin-layout
    title="Soporte | Simify"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Soporte']
    ]"
>
    <x-slot name="actions">
        <a href="{{ route('admin.tickets.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md inline-flex items-center text-sm font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <i class="fa-solid fa-plus w-4 h-4"></i>
            <span class="ml-1">Nuevo Ticket</span>
        </a>
    </x-slot>

    <div class="p-6 overflow-hidden bg-white shadow-xl sm:rounded-lg">
        @if($tickets->isEmpty())
            <div class="text-center py-12">
                <i class="fa-solid fa-inbox text-gray-400 text-5xl mb-4"></i>
                <p class="text-gray-500 text-lg">No hay tickets de soporte</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioridad</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($tickets as $ticket)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $ticket->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $ticket->user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($ticket->title, 50) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($ticket->status === 'open') bg-blue-100 text-blue-800
                                        @elseif($ticket->status === 'in_progress') bg-yellow-100 text-yellow-800
                                        @elseif($ticket->status === 'resolved') bg-green-100 text-green-800
                                        @elseif($ticket->status === 'closed') bg-gray-100 text-gray-800
                                        @endif
                                    ">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($ticket->priority === 'low') bg-gray-100 text-gray-800
                                        @elseif($ticket->priority === 'normal') bg-blue-100 text-blue-800
                                        @elseif($ticket->priority === 'high') bg-orange-100 text-orange-800
                                        @elseif($ticket->priority === 'urgent') bg-red-100 text-red-800
                                        @endif
                                    ">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $ticket->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.tickets.show', $ticket) }}" class="text-blue-600 hover:text-blue-900 transition-colors">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.tickets.edit', $ticket) }}" class="text-indigo-600 hover:text-indigo-900 transition-colors">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                        <button onclick="handleDelete({{ $ticket->id }})" class="text-red-600 hover:text-red-900 transition-colors">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $tickets->links() }}
            </div>

            <!-- Delete Form (hidden) -->
            @foreach($tickets as $ticket)
                <form id="delete-form-{{ $ticket->id }}" action="{{ route('admin.tickets.destroy', $ticket) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            @endforeach
        @endif
    </div>

    @push('js')
        <script>
            function handleDelete(ticketId) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, ¡eliminar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + ticketId).submit();
                    }
                })
            }

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
