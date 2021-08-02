<?php
    $jornada = \App\Models\Jornada::where("actual", 1)->pluck("id")->toArray()[0];
    $cerrada = \App\Models\Jornada::find($jornada)->cerrada;
    $arrayJugadores = [];
    $equipos = \App\Models\Equipo::with(["user", "jornadas"])->with("jugadores", function($q) use($jornada) {
        $q->where("jornada_id", $jornada);
    })->get();
//    info(\App\Models\JornadaJugador::all());
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de administración') }}
        </h2>
    </x-slot>

{{--    <div class="pt-6">--}}
{{--        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">--}}
{{--            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">--}}
{{--                <div class="p-6 bg-white border-b border-gray-200">--}}
{{--                    <table class="min-w-max w-full table-auto">--}}
{{--                        <thead>--}}
{{--                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">--}}
{{--                            <th class="py-3 px-6 text-left">Liga</th>--}}
{{--                            <th class="py-3 px-6 text-left">Equipos</th>--}}
{{--                            <th class="py-3 px-6 text-left">Total</th>--}}
{{--                            <th class="py-3 px-6 text-left">Puntuaciones Jornada</th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody class="text-gray-600 text-sm font-light">--}}
{{--                        @foreach(\App\Models\Liga::with("equipos")->get() as $liga)--}}
{{--                        @foreach(\App\Models\Liga::with("equipos")->get() as $liga)--}}
{{--                            <tr class="border-b border-gray-200 hover:bg-gray-100">--}}
{{--                                <td class="py-3 px-6 text-left whitespace-nowrap">--}}
{{--                                    <div class="flex items-center">--}}
{{--                                        <span class="font-medium">{{ucwords($liga->nombre)}}</span>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td class="py-3 px-6 text-left whitespace-nowrap">--}}
{{--                                    <div class="flex flex-col">--}}
{{--                                        @foreach($liga->equipos as $equipo)--}}
{{--                                            {{ucwords($equipo->nombre)}}<br/>--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td class="py-3 px-6 text-left whitespace-nowrap">--}}
{{--                                    <div class="flex flex-col">--}}
{{--                                        @foreach($liga->equipos as $equipo)--}}
{{--                                            {{ucwords($equipo->puntuacion)}} pts.<br/>--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td class="py-3 px-6 text-left whitespace-nowrap">--}}
{{--                                    <div class="flex flex-col">--}}
{{--                                        @foreach($liga->equipos as $equipo)--}}
{{--                                            <span class="font-medium">{{info($equipo->with("jornadas")->get())}}</span>--}}
{{--                                            @if($jornada<=10)--}}
{{--                                                @for($i=$jornada; $i>0; $i--)--}}
{{--                                                    @foreach($equipo->jornadas->where("pivot.jornada_id", $i) as $ej)--}}
{{--                                                        J{{$i}}: {{$ej->pivot->puntuacion}} pts.--}}
{{--                                                    @endforeach--}}
{{--                                                @endfor--}}
{{--                                            @else--}}
{{--                                                @for($i=$jornada; $i>$jornada-10; $i--)--}}
{{--                                                    @foreach($equipo->jornadas->where("pivot.jornada_id", $i) as $ej)--}}
{{--                                                        J{{$i}}: {{$ej->pivot->puntuacion}} pts.--}}
{{--                                                    @endforeach--}}
{{--                                                @endfor--}}
{{--                                            @endif--}}
{{--                                        <br/>--}}
{{--                                        @foreach($equipo->with("jornadas")->get() as $eq)--}}
{{--                                        @foreach($eq->jornadas->where("id", 1) as $ej)--}}
{{--                                            <span class="font-medium">{{$ej->pivot->puntuacion}}</span>--}}
{{--                                            {{info($eq)}}--}}
{{--                                        @endforeach--}}
{{--                                        @endforeach--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                        @endforeach--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

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
                    <div class="w-1/4">
                        Resultados de la jornada <b>{{$jornada}}</b>
{{--                        || @if($cerrada) Disponible (jornada cerrada) @else No disponible (hasta cierre de jornada) @endif--}}
                    </div>
                    <div class="w-3/4" flex justify-between gap-x-2">
                        <div>
                            <form action="{{ route('file-import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method("POST")
                                <div class="flex flex-row justify-between items-center gap-x-2">
                                <div class="w-3/4">
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
                                        <input type="file" name="file" required @if(!$cerrada) disabled @endif class="h-full w-full opacity-0">
                                    </div>
                                </div>
                                <div class="w-1/4">
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

    <div class="grid overflow-hidden sm:grid-cols-3 grid-cols-1 grid-rows-1 gap-2 pt-6 sm:px-6 lg:px-8">
        <div class="box xl:ml-24">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="pb-3 border-b-2 text-center">
                            Hay {{\App\Models\User::count()}} usuarios registrados
                        </div>
                        <div class="pt-3 text-center">
                            <a href="{{route("user.index")}}">
                                <x-button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <g><path d="m11.894 24c-.131 0-.259-.052-.354-.146-.118-.118-.17-.288-.137-.452l.707-3.536c.02-.097.066-.186.137-.255l7.778-7.778c.584-.585 1.537-.585 2.121 0l1.414 1.414c.585.585.585 1.536 0 2.121l-7.778 7.778c-.069.07-.158.117-.256.137l-3.535.707c-.032.007-.065.01-.097.01zm1.168-3.789-.53 2.652 2.651-.53 7.671-7.671c.195-.195.195-.512 0-.707l-1.414-1.414c-.195-.195-.512-.195-.707 0zm2.367 2.582h.01z"/></g><g><path d="m13.5 15h-10c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h10c.276 0 .5.224.5.5s-.224.5-.5.5z"/></g><g><path d="m11.5 18h-8c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h8c.276 0 .5.224.5.5s-.224.5-.5.5z"/></g><g><path d="m8.5 7c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2zm0-3c-.552 0-1 .449-1 1s.448 1 1 1 1-.449 1-1-.448-1-1-1z"/></g><g><path d="m12 12c-.276 0-.5-.224-.5-.5v-1c0-.827-.673-1.5-1.5-1.5h-3c-.827 0-1.5.673-1.5 1.5v1c0 .276-.224.5-.5.5s-.5-.224-.5-.5v-1c0-1.378 1.121-2.5 2.5-2.5h3c1.379 0 2.5 1.122 2.5 2.5v1c0 .276-.224.5-.5.5z"/></g><g><path d="m9.5 21h-7c-1.379 0-2.5-1.122-2.5-2.5v-16c0-1.378 1.121-2.5 2.5-2.5h12c1.379 0 2.5 1.122 2.5 2.5v9c0 .276-.224.5-.5.5s-.5-.224-.5-.5v-9c0-.827-.673-1.5-1.5-1.5h-12c-.827 0-1.5.673-1.5 1.5v16c0 .827.673 1.5 1.5 1.5h7c.276 0 .5.224.5.5s-.224.5-.5.5z"/></g>
                                    </svg>
                                    <span>Usuarios</span>
                                </x-button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="pb-3 border-b-2 text-center">
                            {{\App\Models\Jugador::count()}} jugadores disponibles
                        </div>
                        <div class="pt-3 text-center">
                            <a href="{{route("jugador.index")}}">
                                <x-button class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                    <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                                        <path d="m59 16c0-6.065-4.935-11-11-11s-11 4.935-11 11 4.935 11 11 11 11-4.935 11-11zm-20 0c0-4.963 4.037-9 9-9s9 4.037 9 9-4.037 9-9 9-9-4.037-9-9z"/><path d="m63 16c0-8.271-6.729-15-15-15s-15 6.729-15 15c0 6.368 3.995 11.808 9.606 13.98l-2.02 2.02h-8.04l-7 8h-11.983l-12.297 13.321 1.469 1.357 11.703-12.678h12.017l7-8h7.96l3.359-3.359c.916.202 1.863.314 2.833.339l-5.021 5.02h-9.086l-6 8h-11.954l-14.546 16.624v2.376h58v-36.836c2.474-2.676 4-6.241 4-10.164zm-28 0c0-7.168 5.832-13 13-13s13 5.832 13 13-5.832 13-13 13-13-5.832-13-13zm16 14.698v30.302h-4v-26.586l3.665-3.665c.111-.02.225-.029.335-.051zm-7.586 7.302 1.586-1.586v24.586h-4v-23zm-28.414 23h-4v-8.767l4-4.571zm2-15h4v15h-4zm6 0h4v15h-4zm6-.667 4-5.333v21h-4zm6-7.333h4v23h-4zm-26 16.519v6.481h-5.671zm44 6.481v-30.875c1.449-.515 2.794-1.244 4-2.153v33.028z"/><path d="m7 38h2v-4h2v-12h-2v-4h-2v4h-2v12h2zm0-14h2v8h-2z"/><path d="m15 33h2v-4h2v-10h-2v-4h-2v4h-2v10h2zm0-12h2v6h-2z"/><path d="m23 26h2v-4h2v-8h-2v-4h-2v4h-2v8h2zm0-10h2v4h-2z"/>
                                    </svg>
                                    <span>Mercado</span>
                                </x-button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box xl:mr-24">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="pb-3 border-b-2 text-center">
                            {{\App\Models\Liga::count()}} ligas creadas
                        </div>
                        <div class="pt-3 text-center">
                            <a href="{{route("liga.index")}}">
                                <x-button class="bg-pink-500 hover:bg-pink-700 font-bold py-2 px-4 rounded inline-flex items-center">
                                    <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path d="m414.167 366.003c-11.346 0-21.167 8.072-23.352 19.193-.798 4.064 1.849 8.006 5.914 8.805 4.066.794 8.007-1.85 8.805-5.914.806-4.104 4.437-7.084 8.633-7.084 4.852 0 8.798 3.946 8.798 8.798s-3.947 8.798-8.798 8.798c-4.142 0-7.5 3.357-7.5 7.5s3.358 7.5 7.5 7.5c4.852 0 8.798 3.947 8.798 8.799s-3.947 8.798-8.798 8.798c-4.84 0-8.798-3.989-8.798-8.798 0-4.143-3.358-7.5-7.5-7.5s-7.5 3.357-7.5 7.5c0 12.919 10.762 23.798 23.798 23.798 13.123 0 23.798-10.676 23.798-23.798 0-6.303-2.467-12.037-6.481-16.299 4.013-4.262 6.481-9.996 6.481-16.298 0-13.122-10.676-23.798-23.798-23.798zm-294.038 1.424c0-13.122-10.676-23.798-23.798-23.798-11.347 0-21.167 8.072-23.352 19.193-.798 4.064 1.85 8.007 5.914 8.805 4.065.793 8.006-1.85 8.805-5.914.806-4.104 4.437-7.084 8.633-7.084 4.715 0 8.577 3.729 8.789 8.393.204 4.49-2.302 7.509-5.722 12.396-10.087 14.413-16.105 22.293-19.338 26.526-4.049 5.302-5.897 7.722-4.624 11.862.75 2.438 2.596 4.309 5.064 5.132 3.153 1.052 24.523.614 34.924.484 4.142-.052 7.457-3.451 7.405-7.593-.052-4.11-3.399-7.406-7.498-7.406-.032 0-.064 0-.096.001-6.221.077-12.814.13-18.352.143 3.513-4.706 8.341-11.313 14.803-20.548 4.795-6.851 8.443-13.609 8.443-20.592zm142.678-83.175h-13.614c-4.142 0-7.5 3.357-7.5 7.5s3.358 7.5 7.5 7.5h6.114v56.194c0 4.143 3.358 7.5 7.5 7.5s7.5-3.357 7.5-7.5v-63.694c0-4.143-3.358-7.5-7.5-7.5zm234.193 173.807v-91.361c0-15.163-12.336-27.5-27.5-27.5h-26.326c-4.142 0-7.5 3.357-7.5 7.5s3.358 7.5 7.5 7.5h26.326c6.893 0 12.5 5.607 12.5 12.5v91.302h-135.667v-91.302c0-6.893 5.607-12.5 12.5-12.5h54.341c4.142 0 7.5-3.357 7.5-7.5s-3.358-7.5-7.5-7.5h-54.341c-4.5 0-8.747 1.093-12.5 3.018v-140.518c0-15.163-12.336-27.5-27.5-27.5h-10.608v-17.228c0-10.541-8.576-19.116-19.117-19.116h-8.183v-27.669c5.231-5.44 9.933-11.338 14.078-17.589 22.201-.907 42.587-14.103 52.411-34.144l10.9-22.23c2.1-4.283 1.849-9.255-.673-13.3-2.522-4.046-6.878-6.462-11.651-6.462h-29.781v-5.088c0-6.27-5.102-11.372-11.373-11.372h-97.673c-6.271 0-11.373 5.102-11.373 11.372v5.088h-29.78c-4.773 0-9.128 2.416-11.651 6.462-2.521 4.045-2.773 9.017-.673 13.3l10.899 22.23c9.825 20.041 30.211 33.237 52.411 34.144 4.146 6.25 8.847 12.149 14.078 17.589v27.669h-8.183c-10.541 0-19.117 8.575-19.117 19.116v17.228h-10.608c-15.164 0-27.5 12.337-27.5 27.5v95.518c-3.753-1.924-8-3.018-12.5-3.018h-110.666c-15.164 0-27.5 12.337-27.5 27.5v113.802c0 4.143 3.358 7.5 7.5 7.5s7.5-3.357 7.5-7.5v-113.802c0-6.893 5.607-12.5 12.5-12.5h110.667c6.893 0 12.5 5.607 12.5 12.5v136.302h-149.502c-8.914 0-16.165 7.252-16.165 16.165v21.67c0 8.913 7.251 16.165 16.165 16.165h479.671c8.913 0 16.165-7.252 16.165-16.165v-21.67c-.001-8.52-6.631-15.505-15.001-16.106zm-181.108-426.599h28.051l-9.997 20.389c-5.927 12.091-16.951 20.876-29.694 24.263 6.537-13.992 10.537-29.156 11.64-44.652zm-137.838 20.389-9.997-20.389h28.051c1.104 15.496 5.103 30.66 11.64 44.652-12.743-3.387-23.767-12.173-29.694-24.263zm32.737-36.849h90.418c.671 31.257-8.754 61.595-30.924 84.609h-28.57c-22.27-23.197-31.517-52.905-30.924-84.609zm55.134 99.609v23.245h-19.851v-23.245zm-47.15 42.362c0-2.27 1.847-4.116 4.117-4.116h66.217c2.27 0 4.117 1.847 4.117 4.116v17.228h-74.45v-17.228zm-38.108 44.727c0-6.893 5.607-12.5 12.5-12.5h125.667c6.893 0 12.5 5.607 12.5 12.5v256.302h-150.667zm316.333 294.137c0 .643-.522 1.165-1.165 1.165h-479.67c-.642 0-1.165-.522-1.165-1.165v-21.67c0-.643.522-1.165 1.165-1.165h479.671c.642 0 1.165.522 1.165 1.165v21.67z"/>
                                    </svg>
                                    <span>Ligas</span>
                                </x-button>
{{--                                <button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">--}}
{{--                                    Administrar ligas--}}
{{--                                </button>--}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 overflow-x-auto">
                    <table class="min-w-max w-full table-auto">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Jugador</th>
                            <th class="py-3 px-6 text-left">Promedio</th>
{{--                            @if($jornada<=10)--}}
                                @for($t=1; $t<=$jornada; $t++)
                                    <th class="py-3 px-2 text-center whitespace-nowrap border-black border-l-2">
                                        <div class="flex flex-col">
                                            <span class="font-medium">J{{$t}}</span>
                                        </div>
                                    </th>
                                @endfor
{{--                            @else--}}
{{--                                @for($t=$jornada-8; $t<=$jornada; $t++)--}}
{{--                                    <th class="py-3 px-2 text-center whitespace-nowrap border-black border-l-2">--}}
{{--                                        <div class="flex flex-col">--}}
{{--                                            <span class="font-medium">J{{$t}}</span>--}}
{{--                                        </div>--}}
{{--                                    </th>--}}
{{--                                @endfor--}}
{{--                            @endif--}}
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                        {{--                        @foreach(\App\Models\Jugador::with("jornadas")->get() as $jugador)--}}
                        @foreach(\App\Models\Jugador::with("jornadas")->orderByDesc("val_media")->paginate(5) as $jugador)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-medium">{{$jugador->nombre}}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-medium">{{number_format($jugador->val_media, 1, ",", ".")}} pts.</span>
                                    </div>
                                </td>
{{--                                @if($jugador->jornadas->count()<=10)--}}
                                    @foreach($jugador->jornadas as $jorn)
                                        <td class="py-3 px-2 text-center whitespace-nowrap border-black border-l-2">
                                            <div class="flex flex-col">
                                                <span class="font-medium">{{$jorn->pivot->valoracion}}</span>
                                            </div>
                                        </td>
                                    @endforeach
{{--                                @else--}}
{{--                                    @foreach($jugador->jornadas->take(8) as $jorn)--}}
{{--                                        <td class="py-3 px-2 text-center whitespace-nowrap border-black border-l-2">--}}
{{--                                            <div class="flex flex-col">--}}
{{--                                                <span class="font-medium">{{$jorn->pivot->valoracion}}</span>--}}
{{--                                            </div>--}}
{{--                                        </td>--}}
{{--                                    @endforeach--}}
{{--                                @endif--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <hr class="py-2"/>
                    {{\App\Models\Jugador::with("jornadas")->paginate(5)->links()}}
                </div>
            </div>
        </div>
    </div>

    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 overflow-x-auto">
                    <table class="min-w-max w-full table-auto">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Equipos</th>
                            <th class="py-3 px-6 text-left">User</th>
                            <th class="py-3 px-6 text-left">Total</th>
                            <th class="py-3 px-6 text-left">Jugadores J{{$jornada}}</th>
                            <th class="py-3 px-6 text-left">Puntuaciones Jornada</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                        {{--                        @foreach(\App\Models\Liga::with("equipos")->get() as $liga)--}}
                        {{--                        @foreach(\App\Models\Equipo::with(["user", "jornadas"])->get() as $equipo)--}}
                        @foreach($equipos as $equipo)
                            {{info($equipo->toArray())}}
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-medium">{{ucwords($equipo->nombre)}}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-medium">{{ucwords($equipo->user->name)}}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-medium">{{ucwords($equipo->puntuacion)}} pts.</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        @foreach($equipo->jugadores as $jug)
                                            {{$jug->nombre}}<br/>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        @foreach($equipo->jornadas->sortByDesc("id")->take(10) as $jor)
                                            J{{$jor->id}}: {{$jor->pivot->puntuacion}} pts. <br/>
                                        @endforeach
                                    </div>
                                </td>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
{{--    <div class="pt-6">--}}
{{--        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">--}}
{{--            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">--}}
{{--                <div class="p-6 bg-white border-b border-gray-200">--}}
{{--                    <table class="min-w-max w-full table-auto">--}}
{{--                        <thead>--}}
{{--                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">--}}
{{--                            <th class="py-3 px-6 text-left">Nombre</th>--}}
{{--                            <th class="py-3 px-6 text-left">Nombre</th>--}}
{{--                            <th class="py-3 px-6 text-left">Puntuación</th>--}}
{{--                            <th class="py-3 px-6 text-left">Jugadores</th>--}}
{{--                            <th class="py-3 px-6 text-left">ID JORNADA</th>--}}
{{--                            <th class="py-3 px-6 text-left">ID EQUIPO</th>--}}
{{--                            <th class="py-3 px-6 text-left">ID JUGADOR</th>--}}
{{--                            <th class="py-3 px-6 text-left">Valoracion</th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody class="text-gray-600 text-sm font-light">--}}
{{--                        @foreach($equipos as $equipo)--}}
{{--                            <tr class="border-b border-gray-200 hover:bg-gray-100">--}}
{{--                                <td class="py-3 px-6 text-left whitespace-nowrap">--}}
{{--                                    <div class="flex items-center">--}}
{{--                                        <span class="font-medium">{{$equipo->nombre}}</span>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td class="py-3 px-6 text-left whitespace-nowrap">--}}
{{--                                    <div class="flex items-center">--}}
{{--                                        <span class="font-medium">{{$equipo->user->name}}</span>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td class="py-3 px-6 text-left whitespace-nowrap">--}}
{{--                                    <div class="flex items-center">--}}
{{--                                        <span class="font-medium">{{$equipo->puntuacion}} pts.</span>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td class="py-3 px-6 text-left whitespace-nowrap">--}}
{{--                                    <div class="flex flex-col">--}}
{{--                                        @foreach($equipo->jugadores as $jugador)--}}
{{--                                        {{info($jugador)}}--}}
{{--                                            <span class="font-medium">{{$jugador->nombre}}</span>--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td class="py-3 px-6 text-left whitespace-nowrap">--}}
{{--                                    <div class="flex flex-col">--}}
{{--                                        @foreach($equipo->jugadores as $jugador)--}}
{{--                                            <span class="font-medium">{{$jugador->pivot->jornada_id}}</span>--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td class="py-3 px-6 text-left whitespace-nowrap">--}}
{{--                                    <div class="flex flex-col">--}}
{{--                                        @foreach($equipo->jugadores as $jugador)--}}
{{--                                            <span class="font-medium">{{$jugador->pivot->equipo_id}}</span>--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td class="py-3 px-6 text-left whitespace-nowrap">--}}
{{--                                    <div class="flex flex-col">--}}
{{--                                        @foreach($equipo->jugadores as $jugador)--}}
{{--                                            <span class="font-medium">{{$jugador->pivot->jugador_id}}</span>--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td class="py-3 px-6 text-left whitespace-nowrap">--}}
{{--                                    <div class="flex flex-col">--}}
{{--                                        @foreach($equipo->jugadores as $jugador)--}}
{{--                                            <span class="font-medium">{{$jugador->pivot->jugador_id}}</span>--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                        @endforeach--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="pt-6">--}}
{{--        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">--}}
{{--            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">--}}
{{--                <div class="p-6 bg-white border-b border-gray-200">--}}
{{--                    <table class="min-w-max w-full table-auto">--}}
{{--                        <thead>--}}
{{--                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">--}}
{{--                            <th class="py-3 px-6 text-left">ID</th>--}}
{{--                            <th class="py-3 px-6 text-left">Nombre</th>--}}
{{--                            <th class="py-3 px-6 text-left">Jugadores</th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody class="text-gray-600 text-sm font-light">--}}
{{--                        @foreach(\App\Models\EquipoEuro::with("jugadores")->get() as $equipo)--}}
{{--                            <tr class="border-b border-gray-200 hover:bg-gray-100">--}}
{{--                                <td class="py-3 px-6 text-left whitespace-nowrap">--}}
{{--                                    <div class="flex items-center">--}}
{{--                                        <span class="font-medium">{{$equipo->id}}</span>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td class="py-3 px-6 text-left whitespace-nowrap">--}}
{{--                                    <div class="flex items-center">--}}
{{--                                        <span class="font-medium">{{$equipo->nombre}}</span>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td class="py-3 px-6 text-left whitespace-nowrap">--}}
{{--                                    <div class="flex flex-col">--}}
{{--                                        @foreach($equipo->jugadores as $jugador)--}}
{{--                                            <span class="font-medium">{{$jugador->nombre}}</span>--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                        @endforeach--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="pt-6">--}}
{{--        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">--}}
{{--            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">--}}
{{--                <div class="p-6 bg-white border-b border-gray-200">--}}
{{--                    <table class="min-w-max w-full table-auto">--}}
{{--                        <thead>--}}
{{--                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">--}}
{{--                            <th class="py-3 px-6 text-left">User</th>--}}
{{--                            <th class="py-3 px-6 text-left">Equipos</th>--}}
{{--                            <th class="py-3 px-6 text-left">Ligas</th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody class="text-gray-600 text-sm font-light">--}}
{{--                        @foreach(\App\Models\User::with(["equipos", "ligas"])->get() as $user)--}}
{{--                            <tr class="border-b border-gray-200 hover:bg-gray-100">--}}
{{--                                <td class="py-3 px-6 text-left whitespace-nowrap">--}}
{{--                                    <div class="flex items-center">--}}
{{--                                        <span class="font-medium">{{$user->name}}</span>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td class="py-3 px-6 text-left whitespace-nowrap">--}}
{{--                                    <div class="flex flex-col">--}}
{{--                                        @foreach($user->equipos as $equipo)--}}
{{--                                        <span class="font-medium">{{$equipo->nombre}}</span>--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td class="py-3 px-6 text-left whitespace-nowrap">--}}
{{--                                    <div class="flex flex-col">--}}
{{--                                        @foreach($user->ligas as $liga)--}}
{{--                                            <span class="font-medium">{{$liga->nombre}}</span>--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                        @endforeach--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

</x-app-layout>
