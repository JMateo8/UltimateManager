<?php
    $jornada = \App\Models\Jornada::where("actual", 1)->pluck("id")->toArray()[0];
    $cerrada = \App\Models\Jornada::find($jornada)->cerrada;
    $arrayJugadores = [];
    $equipos = \App\Models\Equipo::with("user")->with("jugadores", function($q) use($jornada) {
        $q->where("jornada_id", $jornada);
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
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="min-w-max w-full table-auto">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Liga</th>
                            <th class="py-3 px-6 text-left">Equipos</th>
                            <th class="py-3 px-6 text-left">Total</th>
                            <th class="py-3 px-6 text-left">Puntuaciones Jornada</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
{{--                        @foreach(\App\Models\Liga::with("equipos")->get() as $liga)--}}
                        @foreach(\App\Models\Liga::with("equipos")->get() as $liga)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-medium">{{ucwords($liga->nombre)}}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex flex-col">
                                        @foreach($liga->equipos as $equipo)
                                            {{ucwords($equipo->nombre)}}<br/>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex flex-col">
                                        @foreach($liga->equipos as $equipo)
                                            {{ucwords($equipo->puntuacion)}} pts.<br/>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex flex-col">
                                        @foreach($liga->equipos as $equipo)
{{--                                            <span class="font-medium">{{info($equipo->with("jornadas")->get())}}</span>--}}
                                            @for($i=1; $i<$jornada; $i++)
                                            @foreach($equipo->jornadas->where("pivot.jornada_id", $i) as $ej)
                                                J{{$i}}: {{$ej->pivot->puntuacion}} pts.
                                            @endforeach
                                            @endfor
                                        <br/>
{{--                                        @foreach($equipo->with("jornadas")->get() as $eq)--}}
{{--                                        @foreach($eq->jornadas->where("id", 1) as $ej)--}}
{{--                                            <span class="font-medium">{{$ej->pivot->puntuacion}}</span>--}}
{{--                                            {{info($eq)}}--}}
{{--                                        @endforeach--}}
{{--                                        @endforeach--}}
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
                <div class="p-6 bg-white border-b border-gray-200 flex justify-between items-center">
                    <div>
                        Resultados de la jornada <b>{{$jornada}}</b> || @if($cerrada) Disponible (jornada cerrada) @else No disponible (hasta cierre de jornada) @endif
                    </div>
                    <div class="flex justify-between gap-x-2">
                        <div>
                            <form action="{{route("siguienteJornada")}}" method="POST">
                                @csrf
                                @method("POST")
                                <div class="flex flex-row justify-between items-center gap-x-2">
                                <div>
                                    <div @if(!$cerrada) class="relative border-solid rounded-lg border-solid border-2 border-gray-700 bg-gray-100 flex justify-center items-center opacity-50 cursor-not-allowed" @else class="relative border-solid rounded-lg border-solid border-2 border-green-700 hover:border-solid bg-green-100 flex justify-center items-center hover:bg-green-900 hover:text-white" @endif>
                                        <div class="absolute">
                                            <div class="flex flex-row items-center justify-center gap-x-2">
                                                <i class="fas fa-upload text-green-700 hover:text-white"></i>
{{--                                                <i class="fa fa-folder-open text-green-700"></i>--}}
{{--                                                <i class="fas fa-cloud-upload-alt text-green-700"></i>--}}
{{--                                                <i class="fas fa-file-upload text-green-700"></i>--}}
                                                <span class="block text-green-400 font-semibold hover:text-white">Selecciona el archivo</span>
                                            </div>
                                        </div>
                                        <input type="file" required @if(!$cerrada) disabled @endif class="h-full w-full opacity-0" name="">
                                    </div>
                                </div>
                                <div>
                                    <button type="submit" @if(!$cerrada) disabled class="bg-green-600 text-white font-bold py-2 px-4 rounded opacity-50 cursor-not-allowed" @else class="bg-transparent hover:bg-green-600 text-green-700 font-semibold hover:text-white py-2 px-4 border border-green-500 hover:border-black rounded" @endif>
                                        Subir archivo
                                    </button>
                                </div>
                                </div>
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
                            @for($t=1; $t<=$jornada; $t++)
                                <th class="py-3 px-2 text-center whitespace-nowrap border-black border-l-2">
                                    <div class="flex flex-col">
                                        <span class="font-medium">J{{$t}}</span>
                                    </div>
                                </th>
                            @endfor
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
                        @foreach(\App\Models\EquipoEuro::with("jugadores")->get() as $equipo)
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
                        @foreach(\App\Models\User::with(["equipos", "ligas"])->get() as $user)
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
                        @foreach(\App\Models\Liga::with("equipos")->get() as $liga)
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
