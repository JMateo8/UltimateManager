<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    EQUIPO {{$equipo->nombre}}
                </div>
                <?php $jornadas = \App\Models\Jornada::all()->pluck('id'); ?>
                {{$jornadas}}
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{route("showJornada", [$equipo])}}" method="post">
                        @csrf
                        @method("POST")
                        <select name="jornada">
                            <h1>HOLA</h1>
                            @foreach($jornadas as $jornada)
                            <option value="{{$jornada}}">Jornada {{$jornada}}</option>
                            @endforeach
                        </select>
                        <input type="submit" name="submit" value="Refrescar">
                    </form>
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
                            <th class="py-3 px-6 text-left">Equipo</th>
                            <th class="py-3 px-6 text-left">Posición</th>
                            <th class="py-3 px-6 text-left">Valoración J{{$jornada}}</th>
                            <th class="py-3 px-6 text-center">Valoración media</th>
                            <th class="py-3 px-6 text-center">Precio</th>
                            <th class="py-3 px-6 text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                        @foreach($jugadores as $jugador)
                        {{$jugador}}
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-medium">{{$jugador->nombre}}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-medium">{{$jugador->equipo}}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex items-center">
                                        {{$jugador->posicion}}
                                    </div>
                                </td>
                                <td class="py-3 px-6 whitespace-nowrap">
                                    <div class="flex items-center justify-center">
                                        @if(is_null($jugador->valoracion))
                                            --- pts.
                                        @else
                                            {{number_format($jugador->valoracion, 1, ",", "")}} pts.
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-6 whitespace-nowrap">
                                    <div class="flex items-center justify-center">
                                        {{number_format($jugador->val_media, 1, ",", "")}}
                                    </div>
                                </td>
                                <td class="py-3 px-6 whitespace-nowrap">
                                    <div class="flex items-center justify-center">
                                        {{number_format($jugador->precio, 0, "", ".")}} €
                                    </div>
                                </td>
                                <td class="py-3 px-6 whitespace-nowrap">
                                    <div class="flex items-center justify-center">
                                        Acciones
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
