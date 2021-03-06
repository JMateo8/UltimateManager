<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ultimate Manager') }}
        </h2>
    </x-slot>
    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex items-center justify-between overflow-x-auto">
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
            <div
                class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex justify-between items-center overflow-x-auto">
                <div class="p-6 bg-white">
                    <?php $jornadas = \App\Models\Jornada::all()->pluck('id'); ?>
                    <form action="{{route("showJornada", [$equipo])}}" method="post" class="m-0">
                        @csrf
                        @method("POST")
                        <div class="flex items-center gap-x-2">
                        <select class="border rounded-lg appearance-none focus:shadow-outline" name="jornada">
                            <h1>HOLA</h1>
                            @foreach($jornadas as $j)
                                <option value="{{$j}}" @if($j=== $jornada_actual) selected @endif>
                                    Jornada {{$j}}</option>
                            @endforeach
                        </select>
                        <x-button type="submit" name="submit" class="bg-indigo-700">Refrescar</x-button>
                        </div>
                    </form>
                </div>
                @if(!$jornadaObj->cerrada && $jornada == $jornada_actual)
                    <div class="flex justify-between items-center gap-x-2">
                        <div
                            class="widget p-4 rounded-lg bg-white border border-gray-100 dark:bg-gray-900 dark:border-gray-800">
                            <div class="flex flex-row items-center justify-between gap-x-4">
                                <div class="flex flex-col">
                                    <div class="text-xs uppercase font-light text-gray-500">
                                        Cambios disponibles
                                    </div>
                                    <div class="text-xl font-bold text-center">
                                        <b>{{3-$cambios}}/3</b>
                                    </div>
                                </div>
                                <i class="fas fa-exchange-alt"></i>
                            </div>
                        </div>
                        <div
                            class="widget p-4 rounded-lg bg-white border border-gray-100 dark:bg-gray-900 dark:border-gray-800">
                            <div class="flex flex-row items-center justify-between gap-x-4">
                                <div class="flex flex-col">
                                    <div class="text-xs uppercase font-light text-gray-500">
                                        Dinero en caja
                                    </div>
                                    <div class="text-xl font-bold">
                                        <b>{{number_format($equipo->dinero, 0, "", ".")}} ???</b>
                                    </div>
                                </div>
                                <svg class="fill-current w-4 h-4 mr-2 text-black" viewBox="0 0 64 64"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                        <path d="m51 32 11-11-19-19-30 30" fill="#78b75b"/>
                                        <path
                                            d="m22 32c0-2.559.976-5.118 2.929-7.071 3.905-3.905 10.237-3.905 14.142 0 1.953 1.953 2.929 4.512 2.929 7.071"
                                            fill="#669e4f"/>
                                        <path
                                            d="m38.827 33.414c0-1.068-.416-2.073-1.172-2.829-1.51-1.511-4.146-1.511-5.655 0l-2.829-2.829c.781-.779 2.048-.778 2.829.001l1.413-1.415c-1.558-1.558-4.096-1.559-5.656 0l-.707-.707-1.415 1.415.708.708c-.756.755-1.171 1.759-1.171 2.828-.001 1.068.416 2.073 1.172 2.829.755.755 1.76 1.171 2.828 1.171s2.072-.416 2.827-1.171l2.829 2.829c-.781.779-2.048.778-2.829-.001l-1.413 1.415c.779.779 1.804 1.169 2.828 1.169s2.048-.39 2.828-1.169l.707.707 1.415-1.415-.708-.708c.755-.756 1.171-1.76 1.171-2.828zm-8.243-1.414c-.754.755-2.073.755-2.827 0-.378-.378-.587-.88-.586-1.414 0-.534.208-1.036.585-1.414zm2.83-.001c.754-.755 2.073-.755 2.827 0 .378.378.586.88.586 1.414s-.208 1.036-.585 1.414z"
                                            fill="#78b75b"/>
                                        <g>
                                            <path
                                                d="m48.222 29.92-1.415-1.415 7.778-7.778-11.314-11.313-7.778 7.778-1.415-1.415 8.485-8.485c.391-.39 1.024-.391 1.415 0l12.729 12.728c.188.188.292.442.292.707 0 .266-.104.52-.292.708z"
                                                fill="#669e4f"/>
                                        </g>
                                        <g>
                                            <path d="m44.392 24.677h2v2h-2z" fill="#96cc7f"
                                                  transform="matrix(.707 -.708 .708 .707 -4.854 39.644)"/>
                                        </g>
                                        <g>
                                            <path d="m47.221 21.848h2v2.001h-2z" fill="#96cc7f"
                                                  transform="matrix(.707 -.707 .707 .707 -2.03 40.799)"/>
                                        </g>
                                        <g>
                                            <path d="m37.321 17.606h2v1.999h-2z" fill="#96cc7f"
                                                  transform="matrix(.708 -.707 .707 .708 -1.94 32.526)"/>
                                        </g>
                                        <g>
                                            <path d="m40.15 14.777h2v2.001h-2z" fill="#96cc7f"
                                                  transform="matrix(.707 -.707 .707 .707 .899 33.726)"/>
                                        </g>
                                        <path d="m2 32h60v26h-60z" fill="#96cc7f"/>
                                        <circle cx="32" cy="45" fill="#78b75b" r="10"/>
                                        <path d="m17 58 4 4 4-4" fill="#78b75b"/>
                                        <path
                                            d="m33 44h-.002v-4h.002c1.102 0 1.998.897 1.998 2h2c0-2.206-1.794-4-3.998-4h-.002v-1h-1.999v1c-2.206 0-4 1.794-4 4 0 2.205 1.794 3.999 4 3.999v4c-1.104 0-2-.897-2-2l-2 .001c0 2.205 1.794 3.999 4 3.999v1h1.999v-1h.002c2.204 0 3.998-1.794 3.998-4s-1.794-3.999-3.998-3.999zm-4.001-2c0-1.103.896-2 2-2v4c-1.103 0-2-.898-2-2zm4.001 7.999h-.002v-4h.002c1.102 0 1.998.897 1.998 2.001 0 1.102-.896 1.999-1.998 1.999z"
                                            fill="#669e4f"/>
                                        <g>
                                            <path
                                                d="m57.998 54.999h-11.999v-2h10.999v-15.999h-10.999v-2h11.999c.553 0 1 .447 1 1v18c0 .552-.447.999-1 .999z"
                                                fill="#669e4f"/>
                                        </g>
                                        <g>
                                            <path
                                                d="m17.999 55h-11.999c-.553 0-1-.448-1-1v-18c0-.553.447-1 .999-1h12l.001 2h-11v16h10.999z"
                                                fill="#669e4f"/>
                                        </g>
                                        <g>
                                            <path d="m45.999 49h1.999v2h-1.999z" fill="#78b75b"/>
                                        </g>
                                        <g>
                                            <path d="m49.999 49h1.999v2h-1.999z" fill="#78b75b"/>
                                        </g>
                                        <g>
                                            <path d="m45.999 39h1.999v2h-1.999z" fill="#78b75b"/>
                                        </g>
                                        <g>
                                            <path d="m49.999 39h1.999v2h-1.999z" fill="#78b75b"/>
                                        </g>
                                        <g>
                                            <path d="m12 39h1.999v2h-1.999z" fill="#78b75b"/>
                                        </g>
                                        <g>
                                            <path d="m16 39h1.999v2h-1.999z" fill="#78b75b"/>
                                        </g>
                                        <g>
                                            <path d="m12 49h1.999v2h-1.999z" fill="#78b75b"/>
                                        </g>
                                        <g>
                                            <path d="m16 49h1.999v2h-1.999z" fill="#78b75b"/>
                                        </g>
                                        <g>
                                            <path
                                                d="m61.999 30.999h-8.585l9.293-9.292c.188-.188.292-.442.293-.707 0-.266-.105-.52-.293-.708l-19-19c-.391-.391-1.024-.389-1.415 0l-29.708 29.707h-10.586c-.552 0-1 .448-1 1v26c0 .552.448 1 1 1h14.586l3.707 3.707c.189.188.443.294.709.293.265 0 .52-.105.707-.292l3.707-3.707h36.585c.552 0 1-.448 1-1v-26c0-.553-.448-1.001-1-1.001zm-19-27.585 17.586 17.585-10 10h-7.635c-.229-2.561-1.332-4.938-3.172-6.778-4.29-4.288-11.268-4.288-15.556 0-1.841 1.84-2.945 4.218-3.173 6.778h-5.634zm-15.773 27.585c-.135-.649.047-1.344.53-1.827l1.827 1.827zm10.787 0c-.11-.145-.228-.284-.358-.414-1.51-1.511-4.146-1.511-5.655 0l-2.829-2.829c.781-.779 2.048-.779 2.829.001l1.413-1.415c-1.558-1.558-4.096-1.559-5.656 0l-.707-.707-1.415 1.415.708.708c-.879.878-1.268 2.069-1.143 3.242h-2.14c.222-2.025 1.114-3.901 2.577-5.363 3.508-3.51 9.218-3.509 12.728 0 1.461 1.461 2.353 3.338 2.576 5.363h-2.928zm-17.014 29.586-1.585-1.585h3.17zm40-3.585h-58.001v-24h58.001z"/>
                                            <path
                                                d="m28.999 47.999-2 .001c0 2.205 1.794 3.999 4 3.999v1h1.999v-1h.002c2.204 0 3.998-1.794 3.998-4s-1.794-4-3.998-4h-.002v-4h.002c1.102 0 1.998.897 1.998 2h2c0-2.206-1.794-4-3.998-4h-.002v-1h-1.999v1c-2.206 0-4 1.794-4 4 0 2.205 1.794 3.999 4 3.999v4c-1.103.001-2-.896-2-1.999zm0-5.999c0-1.103.896-2 2-2v4c-1.103 0-2-.898-2-2zm3.999 3.999h.002c1.102 0 1.998.897 1.998 2.001 0 1.102-.896 1.999-1.998 1.999h-.002z"/>
                                            <path
                                                d="m31.999 55.999c6.064 0 10.999-4.935 10.999-11s-4.935-11-10.999-11c-6.065.001-10.999 4.935-10.999 11.001 0 6.064 4.934 10.999 10.999 10.999zm0-19.999c4.962 0 8.999 4.037 8.999 9 0 4.962-4.037 9-8.999 9-4.963 0-8.999-4.037-8.999-9s4.036-9 8.999-9z"/>
                                            <path
                                                d="m58.998 53.999v-17.999c0-.553-.447-1-1-1h-11.999v2h10.999v16h-10.999v2h11.999c.553-.001 1-.448 1-1.001z"/>
                                            <path
                                                d="m6 55h11.999v-2h-10.999v-16h11l-.001-2h-12c-.552 0-.999.447-.999 1v18c0 .552.447 1 1 1z"/>
                                            <path d="m45.999 49h1.999v2h-1.999z"/>
                                            <path d="m49.999 49h1.999v2h-1.999z"/>
                                            <path d="m45.999 39h1.999v2h-1.999z"/>
                                            <path d="m49.999 39h1.999v2h-1.999z"/>
                                            <path
                                                d="m43.271 9.414 11.313 11.314-7.778 7.778 1.415 1.415 8.485-8.485c.188-.188.292-.442.292-.708 0-.265-.104-.52-.292-.707l-12.727-12.729c-.391-.391-1.024-.39-1.415 0l-8.485 8.485 1.415 1.415z"/>
                                            <path d="m44.392 24.677h2v2h-2z"
                                                  transform="matrix(.707 -.707 .707 .707 -4.859 39.626)"/>
                                            <path d="m47.221 21.848h2v2.001h-2z"
                                                  transform="matrix(.707 -.707 .707 .707 -2.033 40.79)"/>
                                            <path d="m37.321 17.606h2v1.999h-2z"
                                                  transform="matrix(.708 -.707 .707 .708 -1.94 32.526)"/>
                                            <path d="m40.15 14.777h2v2.001h-2z"
                                                  transform="matrix(.707 -.707 .707 .707 .899 33.726)"/>
                                            <path d="m12 39h1.999v2h-1.999z"/>
                                            <path d="m16 39h1.999v2h-1.999z"/>
                                            <path d="m12 49h1.999v2h-1.999z"/>
                                            <path d="m16 49h1.999v2h-1.999z"/>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                        </div>
                        <div class="p-6 bg-white">
                            <form action="{{route("anularCambios", [$equipo])}}" method="post" class="m-0">
                                @csrf
                                @method("POST")
                                <x-button type="submit" name="submit" class="bg-indigo-700">Anular cambios</x-button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="pt-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center bg-white border-b border-gray-200 overflow-x-auto">
                        <table class="min-w-max w-full table-auto">
                            <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Jugador</th>
                                <th class="py-3 px-6 text-left hidden sm:hidden md:hidden lg:table-cell">Equipo</th>
                                <th class="py-3 px-6 text-left hidden sm:hidden md:hidden lg:table-cell">Posici??n</th>
                                <th class="py-3 px-6 text-center">Valoraci??n J<b>{{$jornada}}</b></th>
                                <th class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">Valoraci??n
                                    media
                                </th>
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
                                        <div class="flex items-center text-sm">
                                            <div class="relative w-8 h-8 mr-3 rounded-full md:block">
                                                @if($jugador->imagen)
                                                    <img class="object-cover w-full h-full rounded-full" src="{{$jugador->imagen}}" alt="Foto {{$jugador->nombre}}" loading="lazy" />
                                                @else
                                                    <img class="object-cover w-full h-full rounded-full" src="https://upload.wikimedia.org/wikipedia/commons/8/89/Portrait_Placeholder.png" alt="Jugador sin foto" loading="lazy" />
                                                @endif
                                                <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                            </div>
                                            <div>
                                                <span class="font-medium">{{$jugador->nombre}}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-left whitespace-nowrap hidden sm:hidden md:hidden lg:table-cell">
                                        <div class="flex items-center">
                                            <span class="font-medium">{{$jugador->equipo}}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">
                                        <div class="flex items-center">
                                            {{$jugador->posicion}}
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 whitespace-nowrap">
                                        <div class="flex items-center justify-center ">
                                            @if(sizeof($jugador->jornadas)===0)
                                                --- pts.
                                            @else
                                                @foreach($jugador->jornadas->where("id", $jornada) as $val_j)
                                                    @if(!$jugador->pivot->capitan)
                                                        <span>{{number_format($val_j->pivot->valoracion, 1, ",", "")}} pts.</span>
                                                    @else
                                                        <span class="text-green-700">{{number_format(($val_j->pivot->valoracion*2), 1, ",", "")}} pts. (x2)</span>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 whitespace-nowrap hidden sm:hidden md:hidden lg:table-cell">
                                        <div class="flex items-center justify-center">
                                            <?php ($val_jornada += $jugador->val_media)?>
                                            {{number_format($jugador->val_media, 1, ",", "")}} pts.
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 whitespace-nowrap">
                                        <div class="flex items-center justify-center">
                                            <?php ($salario += $jugador->precio)?>
                                            {{number_format($jugador->precio, 0, "", ".")}} ???
                                        </div>
                                    </td>
                                    @if(!$jornadaObj->cerrada && $jornada == $jornada_actual && $cambios<3)
                                        <td class="py-3 px-6 whitespace-nowrap">
                                            <div class="flex items-center justify-center gap-x-4">
                                                <div>
                                                    <form action="{{route('vender', [$equipo, $jugador])}}"
                                                          method="POST">
                                                        @csrf
                                                        @method("POST")
                                                        <x-button class="bg-red-600">
                                                            <i class="fas fa-minus-square"></i>
                                                        </x-button>
                                                    </form>
                                                </div>
                                                @livewire('toggle-button', ["jugador" => $jugador, "equipo" => $equipo,
                                                "jornada" => $jornada])
                                            </div>
                                        </td>
                                    @elseif($jornadaObj->cerrada && $jornada == $jornada_actual)
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
                                    <td class="py-3 px-6 text-center" colspan="3">
                                        <span>No hay ning??n jugador</span>
                                    </td>
                                    <td class="py-3 px-6 whitespace-nowrap hidden sm:hidden md:hidden lg:table-cell"
                                        colspan="3"></td>
                                    @if($jornada == $jornada_actual && !$jornadaObj->cerrada)
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
                                <td class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell"
                                    colspan="2"></td>
                                <td class="py-3 px-6 text-center">
                                    @if(sizeof($equipo->jornadas)===0)
                                        --- pts.
                                    @else
                                        @foreach($equipo->jornadas->where("id", $jornada) as $val_eq_j)
                                            {{number_format($val_eq_j->pivot->puntuacion, 1, ",", ".")}} pts.
                                        @endforeach
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell"></td>
                                <td class="py-3 px-6 text-center">
                                    <b>{{number_format($salario, 0, "", ".")}} ???</b>
                                @if($jornada==$jornada_actual)
                                    <td class="py-3 px-6 text-center">
                                        Cambios: ({{3-$cambios}}/3 disponsibles)
                                    </td>
                                @endif
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
