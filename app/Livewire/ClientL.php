<?php


// app/Livewire/ClientL.php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Client;

class ClientL extends Component
{
    public $selectedClient = null;
    public $clients = [];

    protected $listeners = ['clientAdded' => 'refreshClients'];

    public function mount()
    {
        $this->clients = Client::all();
    }

    public function refreshClients()
    {
        $this->clients = Client::all();
    }

    public function render()
    {
        return view('livewire.client-l');
    }
}
