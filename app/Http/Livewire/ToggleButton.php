<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Equipo;
use App\Models\Jornada;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
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
//        $this->capitan = (bool) $this->model->getAttribute($this->field);
    }

    public function render()
    {
        return view('livewire.toggle-button');
    }

    public function updating($field, $value)
    {
//        $jornada = Jornada::where("actual", 1)->first()->id;
        $eq = \App\Models\Equipo::find($this->equipo);
        $eq->jugadores()->where("jornada_id", $this->jornada)->where("capitan", 1)->update(["capitan" => 0]);
        $eq->jugadores()->where("jornada_id", $this->jornada)->where("jugador_id", $this->jugador)->update(["capitan" => 1]);
//        DB::table("equipo_jornada_jugador")
//            ->where("equipo_id", $this->equipo)
//            ->where("jornada_id", $this->jornada)
//            ->where("capitan", 1)
//            ->update(["capitan" => 0]);
//
//        DB::table("equipo_jornada_jugador")
//            ->where("equipo_id", $this->equipo)
//            ->where("jornada_id", $this->jornada)
//            ->where("jugador_id", $this->jugador)
//            ->update(["capitan" => 1]);
//        \App\Models\Equipo::with("users")->where("pivot.capitan", 1)->update(["capitan" => 0]);
//        User::where('admin', 1)->update(['admin' => 0]);
//        $this->model->setAttribute($this->field, $value)->save();
        return redirect()->route('equipo.show', [$eq]);
    }
}
