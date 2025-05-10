<div x-data="{ showModal: @entangle('showModal') }">
    <!-- Modal -->
    <div x-show="showModal" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg w-full max-w-md p-6 mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Add New Client</h3>
                <button @click="showModal = false" class="text-gray-500 hover:text-gray-700">
                    &times;
                </button>
            </div>

            <form wire:submit.prevent="saveClient">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Name</label>
                    <input type="text" wire:model="nom" class="w-full px-3 py-2 border rounded">
                    @error('nom') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">prenom</label>
                    <input type="text" wire:model="prenom" class="w-full px-3 py-2 border rounded">
                    @error('prenom') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Phone</label>
                    <input type="text" wire:model="tel" class="w-full px-3 py-2 border rounded">
                    @error('tel') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" @click="showModal = false"
                            class="px-4 py-2 text-gray-700 bg-gray-100 rounded hover:bg-gray-200">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700
                                   disabled:opacity-50" wire:loading.attr="disabled">
                        <span wire:loading.remove>Save Client</span>
                        <span wire:loading>Saving...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush
