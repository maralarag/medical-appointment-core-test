<x-admin-layout
    title="Detalles del Ticket de Soporte"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Soporte', 'href' => route('admin.tickets.index')],
        ['name' => '#' . $ticket->id]
    ]"
>
    <div class="p-6 overflow-hidden bg-white shadow-xl sm:rounded-lg">
        <!-- Header -->
        <div class="mb-6 pb-6 border-b border-gray-200">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $ticket->title }}</h1>
                    <p class="text-sm text-gray-500 mt-1">Ticket #{{ $ticket->id }} - {{ $ticket->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="flex gap-2">
                    <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full
                        @if($ticket->status === 'open') bg-blue-100 text-blue-800
                        @elseif($ticket->status === 'in_progress') bg-yellow-100 text-yellow-800
                        @elseif($ticket->status === 'resolved') bg-green-100 text-green-800
                        @elseif($ticket->status === 'closed') bg-gray-100 text-gray-800
                        @endif
                    ">
                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                    </span>
                    <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full
                        @if($ticket->priority === 'low') bg-gray-100 text-gray-800
                        @elseif($ticket->priority === 'normal') bg-blue-100 text-blue-800
                        @elseif($ticket->priority === 'high') bg-orange-100 text-orange-800
                        @elseif($ticket->priority === 'urgent') bg-red-100 text-red-800
                        @endif
                    ">
                        {{ ucfirst($ticket->priority) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- User Info -->
        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
            <div class="flex items-center">
                <i class="fa-solid fa-user text-gray-400 text-lg mr-3"></i>
                <div>
                    <p class="text-sm text-gray-500">Creado por</p>
                    <p class="font-medium text-gray-900">{{ $ticket->user->name }} ({{ $ticket->user->email }})</p>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-3">Descripción</h2>
            <div class="p-4 bg-gray-50 rounded-lg text-gray-700 whitespace-pre-wrap">
                {{ $ticket->description }}
            </div>
        </div>

        <!-- Timeline Info -->
        <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-500">Fecha de creación</p>
                <p class="font-medium text-gray-900">{{ $ticket->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-500">Última actualización</p>
                <p class="font-medium text-gray-900">{{ $ticket->updated_at->format('d/m/Y H:i') }}</p>
            </div>
            @if($ticket->resolved_at)
                <div class="p-4 bg-green-50 rounded-lg md:col-span-2">
                    <p class="text-sm text-green-600">Fecha de resolución</p>
                    <p class="font-medium text-green-900">{{ $ticket->resolved_at->format('d/m/Y H:i') }}</p>
                </div>
            @endif
        </div>

        <!-- Actions -->
        <div class="mt-8 flex gap-3 border-t border-gray-200 pt-6">
            <a href="{{ route('admin.tickets.edit', $ticket) }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <i class="fa-solid fa-edit mr-2"></i> Editar
            </a>
            <button onclick="handleDelete({{ $ticket->id }})"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-md font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                <i class="fa-solid fa-trash mr-2"></i> Eliminar
            </button>
            <a href="{{ route('admin.tickets.index') }}"
               class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-md font-medium transition-colors">
                <i class="fa-solid fa-arrow-left mr-2"></i> Volver
            </a>
        </div>
    </div>

    <!-- Delete Form (hidden) -->
    <form id="delete-form-{{ $ticket->id }}" action="{{ route('admin.tickets.destroy', $ticket) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

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
