<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Client;

class AddClient extends Component
{
    public $nom = '';
    public $prenom = '';
    public $tel = '';
    public $showModal = false;

    protected $rules = [
        'nom' => 'required|string|max:255',
        'prenom' => 'nullable|string|max:255',
        'tel' => 'nullable|string|max:20',
    ];

    protected $listeners = ['openAddClientModal' => 'openModal'];

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset();
    }

    public function saveClient()
    {
        $this->validate();

        $client = Client::create([
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'tel' => $this->tel
        ]);

        $this->closeModal();
        $this->dispatch('clientAdded', $client->id);
    }

    public function render()
    {
        return view('livewire.add-client');
    }
}
