<!-- resources/views/livewire/client-l.blade.php -->
<div class="container mx-auto p-4">
    <div class="flex gap-4 items-center">
        <!-- Client Select Dropdown -->
        <select wire:model="selectedClient"
                class="w-full max-w-xs px-4 py-2 border rounded">
            @foreach ($clients as $client)
                <option value="{{ $client->id }}">{{ $client->nom }}</option>
            @endforeach
        </select>

        <!-- Add Client Button -->
        <button wire:click="$dispatch('openAddClientModal')"
                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            <i class="fas fa-plus"></i> Add Client
        </button>
    </div>

    <!-- Selected Client Display -->
    @if($selectedClient)
        <div class="mt-4 p-4 bg-gray-100 rounded">
            Selected Client: {{ Client::find($selectedClient)->nom }}
        </div>
    @endif

    <!-- Add Client Component -->
    @livewire('add-client')
</div>
