<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <h2 class="font-semibold text-xl text-white-900 leading-tight">
                {{ __('Accounts') }}
            </h2>
            <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
               
            <!-- Zoek form -->
                <div class="flex space-x-2">
                    <input type="text" id="searchName" placeholder="naam" 
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <input type="text" id="searchRelation" placeholder="relatienummer" 
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                
                <label class="flex items-center">
                    <span class="mr-2 text-white-900 toon">Toon Data</span>
                    <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                        <input type="checkbox" id="dataToggle"
                            class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"
                            checked />
                        <label for="dataToggle"
                            class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                    </div>
                </label>
                <a href="{{ route('account.create') }}" class="bg-blue-600 text-white px-5 py-3 rounded-md transition duration-300 hover:bg-green-700 transform hover:scale-105">Account Aanmaken</a>
            </div>
        </div>
    </x-slot>

    <div id="dataContainer" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <div class="w-full overflow-x-auto">
                    <div class="bg-white shadow-lg rounded-lg my-6">
                        @if ($paginatedAccounts->isNotEmpty())
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-100 text-gray-800 uppercase text-sm font-medium leading-normal">
                                        <th class="py-4 px-6 text-left">#</th>
                                        <th class="py-4 px-6 text-left">Naam</th>
                                        <th class="py-4 px-6 text-left">Relatienummer</th>

                                        
                                        <th class="py-4 px-6 text-left">E-mail</th>
                                        <th class="py-4 px-6 text-left">Telefoon</th>


                                        <th class="py-4 px-6 text-left">Status</th>
                                        <th class="py-4 px-6 text-left">Acties</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-800 text-sm font-light">
                                    @foreach ($paginatedAccounts as $account)
                                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                                            <td class="py-3 px-6">{{ $account->id }}</td>
                                            <td class="py-3 px-6">{{ $account->first_name }} {{ $account->middle_name }} {{ $account->last_name }}</td>
                                            <td class="py-3 px-6">{{ $account->relation_number }}</td>
                                            <td class="py-3 px-6">
                                                <span class="email" data-email="{{ $account->email }}">***@***.com</span>
                                                <button class="reveal-btn" onclick="toggleVisibility(this)">👁️</button>
                                            </td>
                                            <td class="py-3 px-6">
                                                <span class="phone" data-phone="{{ $account->mobile }}">+31****</span>
                                                <button class="reveal-btn" onclick="toggleVisibility(this)">👁️</button>
                                            </td>
                                            <td class="py-3 px-6">
                                                <span class="px-2 py-1 rounded {{ $account->is_active ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                                    {{ $account->is_active ? 'Actief' : 'Inactief' }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-6 flex space-x-2">
                                                <a href="{{ route('account.show', $account->id) }}" class="text-blue-500 hover:underline">ⓘ</a>
                                                <a href="{{ route('account.edit', $account->id) }}" class="text-yellow-500 hover:underline">✎</a>
                                                <form action="{{ route('account.destroy', $account->id) }}" method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:underline">🗑️</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-red-500 p-6">Geen accounts gevonden. Probeer later opnieuw.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-4">
                {{ $paginatedAccounts->links() }}
            </div>
        </div>
    </div>

    <div id="errorContainer" class="py-12 hidden ml-64">
        <p class="text-red-500">Geen accounts gevonden. Probeer later opnieuw.</p>
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

    function toggleVisibility(button) {
    const span = button.previousElementSibling;
    if (span.textContent.includes('***')) {
        if (span.classList.contains('email')) {
            span.textContent = span.getAttribute('data-email');
        } else if (span.classList.contains('phone')) {
            span.textContent = span.getAttribute('data-phone');
        }
    } else {
        if (span.classList.contains('email')) {
            span.textContent = '***@***.com';
        } else if (span.classList.contains('phone')) {
            span.textContent = '+31****';
        }
    }
}

    // Add search functionality
    function performSearch() {
        const nameSearch = document.getElementById('searchName').value.toLowerCase();
        const relationSearch = document.getElementById('searchRelation').value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const name = row.children[1].textContent.toLowerCase();
            const relation = row.children[2].textContent.toLowerCase();
            const matchName = name.includes(nameSearch);
            const matchRelation = relation.includes(relationSearch);
            
            if ((nameSearch === '' || matchName) && (relationSearch === '' || matchRelation)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    document.getElementById('searchName').addEventListener('input', performSearch);
    document.getElementById('searchRelation').addEventListener('input', performSearch);

    // Add this to your existing JavaScript
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (confirm('Weet je zeker dat je dit account permanent wilt verwijderen? Dit kan niet ongedaan worden gemaakt!')) {
                this.submit();
            }
        });
    });
</script>

<style>
    h2 {
        color: #fff;
    }

    .toon {
        color: #fff;
    }

    .toggle-checkbox:checked {
        right: 0;
        border-color: #38A169;
    }

    .toggle-checkbox:checked+.toggle-label {
        background-color: #38A169;
    }

    .reveal-btn {
        background: none;
        border: none;
        cursor: pointer;
        margin-left: 5px;
    }

    .overflow-x-auto {
        overflow-x: auto;
    }
    
    /* Add search input styles */
    input[type="text"] {
        padding: 0.5rem;
        min-width: 200px;
    }
</style>