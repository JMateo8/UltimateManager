<?php
    $jornada = \App\Models\Jornada::where("actual", 1)->pluck("id")->toArray()[0];
    $cerrada = \App\Models\Jornada::find($jornada)->cerrada;
    $arrayJugadores = [];
    $equipos = \App\Models\Equipo::with("user")->with("jugadores", function($q) {
        $q->where("jornada_id", 4);
    })->get()
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de administración') }}
        </h2>
    </x-slot>
    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 flex justify-between items-center">
                    <div>
                        JORNADA <b>{{$jornada}}</b> || @if($cerrada) Cerrada @else Abierta @endif
                    </div>
                    <div class="flex justify-between gap-x-2">
                        <div>
                            <form action="{{route("cerrarJornada")}}" method="POST">
                                @csrf
                                @method("POST")
                                <input type="hidden" name="jornada" value="{{$jornada}}"/>
                                <button type="submit" @if($cerrada) disabled class="bg-blue-500 text-white font-bold py-2 px-4 rounded opacity-50 cursor-not-allowed" @else class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-black rounded" @endif>
                                    Cerrar jornada
                                </button>
                            </form>
                        </div>
                        <div>
                            <form action="{{route("siguienteJornada")}}" method="POST">
                                @csrf
                                @method("POST")
                                <input type="hidden" name="jornada" value="{{$jornada}}"/>
                                <button type="submit" @if(!$cerrada) disabled class="bg-blue-500 text-white font-bold py-2 px-4 rounded opacity-50 cursor-not-allowed" @else class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-black rounded" @endif>
                                    Siguiente jornada
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="min-w-max w-full table-auto">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Jugador</th>
                            @foreach(\App\Models\Jornada::all() as $jorn)
                                <th class="py-3 px-2 text-center whitespace-nowrap border-black border-l-2">
                                    <div class="flex flex-col">
                                        <span class="font-medium">J{{$jorn->id}}</span>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                        @foreach(\App\Models\Jugador::with("jornadas")->paginate(10) as $jugador)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-medium">{{$jugador->nombre}}</span>
                                    </div>
                                </td>
                                @forelse($jugador->jornadas as $jorn)
                                    <td class="py-3 px-2 text-center whitespace-nowrap border-black border-l-2">
                                        <div class="flex flex-col">
                                            <span class="font-medium">{{$jorn->pivot->valoracion}}</span>
                                        </div>
                                    </td>
                                @empty
                                    <td class="py-3 px-2 text-center whitespace-nowrap border-black border-l-2">
                                        <div class="flex flex-col">
                                            <span class="font-medium">-</span>
                                        </div>
                                    </td>
                                @endforelse
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{\App\Models\Jugador::with("jornadas")->paginate(10)->links()}}
                </div>
            </div>
        </div>
    </div>

    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="min-w-max w-full table-auto">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Equipo</th>
                            <th class="py-3 px-6 text-left">Jugador</th>
                            <th class="py-3 px-6 text-left">ID EQUIPO</th>
                            <th class="py-3 px-6 text-left">ID JUGADOR</th>
                            <th class="py-3 px-6 text-left">ID JORNADA</th>
                            <th class="py-3 px-6 text-left">Array</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                        @foreach(\App\Models\Equipo::all() as $equipo)
                            <?php
                                $arrayJugadores[] = $equipo->jugadores->where("pivot.jornada_id",$jornada)->toArray();
                            ?>
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span>{{$equipo->nombre}}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex flex-col">
                                        @foreach($equipo->jugadores->where("pivot.jornada_id",$jornada) as $jugador)
                                            <span class="font-medium">{{$jugador->nombre}}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex flex-col">
                                        @foreach($equipo->jugadores->where("pivot.jornada_id",$jornada) as $jugador)
                                            <span class="font-medium">{{$jugador->pivot->equipo_id}}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex flex-col">
                                        @foreach($equipo->jugadores->where("pivot.jornada_id",$jornada) as $jugador)
                                            <span class="font-medium">{{$jugador->pivot->jugador_id}}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex flex-col">
                                        @foreach($equipo->jugadores->where("pivot.jornada_id",$jornada) as $jugador)
                                            <span class="font-medium">{{$jugador->pivot->jornada_id}}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex flex-col">
                                        @foreach($equipo->jugadores->where("pivot.jornada_id",$jornada) as $jugador)
                                            <span class="font-medium">{{$jugador}}</span>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="font-medium">Hola</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="font-medium">Hola</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="font-medium">Hola</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="font-medium">Hola</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="font-medium">{{print_r($arrayJugadores)}}</span>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
<!--                    --><?php //info($arrayJugadores);?>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="min-w-max w-full table-auto">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Nombre</th>
                            <th class="py-3 px-6 text-left">Nombre</th>
                            <th class="py-3 px-6 text-left">Puntuación</th>
                            <th class="py-3 px-6 text-left">Jugadores</th>
                            <th class="py-3 px-6 text-left">ID JORNADA</th>
                            <th class="py-3 px-6 text-left">ID EQUIPO</th>
                            <th class="py-3 px-6 text-left">ID JUGADOR</th>
                            <th class="py-3 px-6 text-left">Valoracion</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                        @foreach($equipos as $equipo)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-medium">{{$equipo->nombre}}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-medium">{{$equipo->user->name}}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-medium">{{$equipo->puntuacion}} pts.</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex flex-col">
                                        @foreach($equipo->jugadores as $jugador)
                                        {{info($jugador)}}
                                            <span class="font-medium">{{$jugador->nombre}}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex flex-col">
                                        @foreach($equipo->jugadores as $jugador)
                                            <span class="font-medium">{{$jugador->pivot->jornada_id}}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex flex-col">
                                        @foreach($equipo->jugadores as $jugador)
                                            <span class="font-medium">{{$jugador->pivot->equipo_id}}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex flex-col">
                                        @foreach($equipo->jugadores as $jugador)
                                            <span class="font-medium">{{$jugador->pivot->jugador_id}}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex flex-col">
                                        @foreach($equipo->jugadores as $jugador)
                                            <span class="font-medium">{{$jugador->pivot->jugador_id}}</span>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="min-w-max w-full table-auto">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">ID</th>
                            <th class="py-3 px-6 text-left">Nombre</th>
                            <th class="py-3 px-6 text-left">Jugadores</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                        @foreach(\App\Models\EquipoEuro::all() as $equipo)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-medium">{{$equipo->id}}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-medium">{{$equipo->nombre}}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex flex-col">
                                        @foreach($equipo->jugadores as $jugador)
                                            <span class="font-medium">{{$jugador->nombre}}</span>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="min-w-max w-full table-auto">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">User</th>
                            <th class="py-3 px-6 text-left">Equipos</th>
                            <th class="py-3 px-6 text-left">Ligas</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                        @foreach($users as $user)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-medium">{{$user->name}}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex flex-col">
                                        @foreach($user->equipos as $equipo)
                                        <span class="font-medium">{{$equipo->nombre}}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex flex-col">
                                        @foreach($user->ligas as $liga)
                                            <span class="font-medium">{{$liga->nombre}}</span>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="min-w-max w-full table-auto">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Liga</th>
                            <th class="py-3 px-6 text-left">Equipos</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                        @foreach(\App\Models\Liga::all() as $liga)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-medium">{{$liga->nombre}}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex flex-col">
                                        @foreach($liga->equipos as $equipo)
                                            <span class="font-medium">{{$equipo->nombre}}</span>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
