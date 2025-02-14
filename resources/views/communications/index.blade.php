<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-200 leading-tight">
                {{ __('Communications') }}
            </h2>
            <label class="flex items-center">
                <span class="mr-2 text-gray-200">Show Data</span>
                <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                    <input type="checkbox" id="dataToggle"
                        class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"
                        checked />
                    <label for="dataToggle"
                        class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                </div>
            </label>
        </div>
    </x-slot>

    <div id="dataContainer" class="container mx-auto p-4">
        @if (session('success'))
            <div class="bg-green-900 border-t-4 border-green-600 rounded-b px-4 py-3 text-green-200" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold text-white">Communications</h1>
            <a href="{{ route('communications.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create New Communication</a>
        </div>

        <table class="min-w-full bg-gray-800 border border-gray-700 rounded-lg shadow-sm">
            <thead>
                <tr class="bg-gray-700">
                    <th class="py-2 px-4 text-left text-gray-200">Customer</th>
                    <th class="py-2 px-4 text-left text-gray-200">Employee</th>
                    <th class="py-2 px-4 text-left text-gray-200">Message</th>
                    <th class="py-2 px-4 text-left text-gray-200">Sent Date</th>
                    <th class="py-2 px-4 text-left text-gray-200">Status</th>
                    <th class="py-2 px-4 text-left text-gray-200">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($communications as $communication)
                    <tr class="border-t border-gray-700 hover:bg-gray-700">
                        <td class="py-2 px-4 text-gray-300">{{ $communication->customer->person->first_name ?? 'N/A' }}</td>
                        <td class="py-2 px-4 text-gray-300">{{ $communication->employee->person->first_name ?? 'N/A' }}</td>
                        <td class="py-2 px-4 text-gray-300">{{ Str::limit($communication->message, 50) }}</td>
                        <td class="py-2 px-4 text-gray-300">{{ \Carbon\Carbon::parse($communication->sent_date)->format('d F Y') }}</td>
                        <td class="py-2 px-4 text-gray-300">
                            <span class="{{ $communication->is_active ? 'text-green-400' : 'text-red-400' }}">
                                {{ $communication->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="py-2 px-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('communications.show', $communication->id) }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View</a>
                                <a href="{{ route('communications.edit', $communication->id) }}"
                                    class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                                <form action="{{ route('communications.destroy', $communication->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                        onclick="return confirm('Are you sure you want to delete this communication?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4 text-gray-300">
            {{ $communications->links() }}
        </div>
    </div>
    <div id="errorContainer" class="container mx-auto mt-8 hidden ml-64">
        <p class="text-red-500">No communications found at the moment.</p>
    </div>
</x-app-layout>

<script>
    document.getElementById('dataToggle').addEventListener('change', function() {
        const dataContainer = document.getElementById('dataContainer');
        const errorContainer = document.getElementById('errorContainer');
        if (this.checked) {
            dataContainer.classList.remove('hidden');
            errorContainer.classList.add('hidden');
        } else {
            dataContainer.classList.add('hidden');
            errorContainer.classList.remove('hidden');
        }
    });
</script>

<style>
    .toggle-checkbox:checked {
        right: 0;
        border-color: #68D391;
    }

    .toggle-checkbox:checked+.toggle-label {
        background-color: #68D391;
    }
</style>