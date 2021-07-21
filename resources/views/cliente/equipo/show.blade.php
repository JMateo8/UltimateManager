<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex items-center justify-between">
                <div class="p-6 bg-white">
                    <a href="{{route("equipo.index")}}">
                        <x-button>
                            Volver
                        </x-button>
                    </a>
                </div>
                <div class="p-6 bg-white">
                    EQUIPO <b>{{$equipo->nombre}}</b>
                </div>
                <div class="p-6 bg-white">
                    JORNADA <b>{{$jornada}}</b>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex justify-center items-center">
                <div class="p-6 bg-white border-b border-gray-200">
                <?php $jornadas = \App\Models\Jornada::all()->pluck('id'); ?>
                    <form action="{{route("showJornada", [$equipo])}}" method="post" class="m-0">
                        @csrf
                        @method("POST")
                        <select class="border rounded-lg appearance-none focus:shadow-outline" name="jornada">
                            <h1>HOLA</h1>
                            @foreach($jornadas as $j)
                                <option value="{{$j}}" @if($j=== $jornada_actual) selected @endif>Jornada {{$j}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="equipo" value="{{$equipo->id}}"/>
                        <x-button type="submit" name="submit">Refrescar</x-button>
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
                            <th class="py-3 px-6 text-left">Valoración J<b>{{$jornada}}</b></th>
                            <th class="py-3 px-6 text-center">Valoración media</th>
                            <th class="py-3 px-6 text-center">Precio</th>
                            @if($jornada == $jornada_actual)
                            <th class="py-3 px-6 text-center">Acciones</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                        <?php $salario = 0 ?>
                        <?php $val_jornada = 0 ?>
                        @foreach($jugadores as $jugador)
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
                                        <?php ($val_jornada+=$jugador->val_media)?>
                                        {{number_format($jugador->val_media, 1, ",", "")}}
                                    </div>
                                </td>
                                <td class="py-3 px-6 whitespace-nowrap">
                                    <div class="flex items-center justify-center">
                                        <?php ($salario+=$jugador->precio)?>
                                        {{number_format($jugador->precio, 0, "", ".")}} €
                                    </div>
                                </td>
                                @if($jornada == $jornada_actual && !\App\Models\Jornada::find($jornada)->cerrada)
                                <td class="py-3 px-6 whitespace-nowrap">
                                    <div class="flex items-center justify-center">
                                        <form action="{{route('detach', [$j])}}" method="POST">
                                            @csrf
                                            @method("POST")
                                            <input type="hidden" name="equipo" value="{{$equipo->id}}"/>
                                            <input type="hidden" name="jugador" value="{{$jugador->id}}"/>
                                            <input type="hidden" name="jornada" value="{{$jornada}}"/>
                                            <x-button class="bg-red-600">
                                                <i class="fas fa-minus-square"></i>
                                            </x-button>
                                        </form>
                                    </div>
                                </td>
                                @else
                                    <td class="py-3 px-6 whitespace-nowrap">
                                        <div class="flex items-center justify-center">
                                            <x-button class="bg-gray-600 cursor-not-allowed">
                                                <i class="fas fa-lock"></i>
                                            </x-button>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        @for($i=$jugadores->count(); $i<10; $i++)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-center" colspan="6">
                                    <span>No hay ningún jugador</span>
                                </td>
                                @if($jornada == $jornada_actual && !\App\Models\Jornada::find($jornada)->cerrada)
                                <td class="text-center">
                                    <a href="{{route("equipo.edit", [$equipo])}}">
                                        <x-button class="bg-green-600">
                                            <i class="fas fa-plus-square"></i>
                                        </x-button>
                                    </a>
                                </td>
                                @endif
                            </tr>
                        @endfor
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-center">
                                <b>{{count($jugadores)}}/10</b> jugadores alineados
                            </td>
                            <td class="py-3 px-6 text-center" colspan="3"></td>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <b>{{number_format($val_jornada, 0, "", ".")}} pts.</b>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <b>{{number_format($salario, 0, "", ".")}} €</b>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
