<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Capitan extends Component
{
    public $equipo;
    public $jugador;
    public $capitan;

    public function mount() {
        info($this->jugador);
        info($this->equipo);
        info($this->capitan);
    }

    public function render()
    {
        return view('livewire.capitan');
    }
    public function updating(){
        return redirect()->route("equipo.show", [$this->equipo]);
    }
}
