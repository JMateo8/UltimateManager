<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Equipo;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ToggleButton extends Component
{
    public $equipo;
    public $jugador;
    public $jornada;
    public $capitan;

    public function mount($equipo, $jugador, $jornada)
    {
        $this->equipo = $equipo->id;
        $this->jugador = $jugador->id;
        $this->jornada = $jornada;
        $this->capitan = DB::table("equipo_jornada_jugador")
            ->where("equipo_id", $this->equipo)
            ->where("jugador_id", $this->jugador)
            ->where("jornada_id", $this->jornada)
            ->first()->capitan;
    }

    public function render()
    {
        return view('livewire.toggle-button');
    }

    public function updating($field, $value)
    {
        $eq = \App\Models\Equipo::find($this->equipo);
        $eq->jugadores()->where("jornada_id", $this->jornada)->where("capitan", 1)->update(["capitan" => 0]);
        if (!$this->capitan){
            $eq->jugadores()->where("jornada_id", $this->jornada)->where("jugador_id", $this->jugador)->update(["capitan" => 1]);
        }
        return redirect()->route('equipo.show', [$eq]);
    }
}
