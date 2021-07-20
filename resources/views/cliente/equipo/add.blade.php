<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de administración') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="pt-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center flex items-center justify-between bg-white border-b border-gray-200">
                        <div>
                            <a href="{{route('equipo.show', [$equipo])}}">
                                <x-button>
                                    Volver
                                </x-button>
                            </a>
                        </div>
                        <div>
                            Añadir jugador al equipo <b>{{($equipo->nombre)}}</b>
                        </div>
                    </div>
{{--                    <div class="p-6 text-center flex justify-between bg-white border-b border-gray-200">--}}
{{--                        <div>--}}
{{--                            {{(print_r($jugEq->toArray()))}}--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>

        <div class="pt-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center bg-white border-b border-gray-200">
                        <table id="jugadores" class="min-w-max w-full table-auto">
                            <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Nombre</th>
                                <th class="py-3 px-6 text-left ">Equipo</th>
                                <th class="py-3 px-6 text-center ">Posición</th>
                                <th class="py-3 px-6 text-center">Valoración media</th>
                                <th class="py-3 px-6 text-center">Precio</th>
                                <th class="py-3 px-6 text-center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">

                            @foreach($jugadores as $j)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="mr-2">
                                            <!--{{$j->image}} -->
                                            <!--<img class="w-6 h-6" src="https://img.icons8.com/color/100/000000/vue-js.png"/>
                                            -->
                                            <!--<span>{{$j->id}}</span>-->
                                            </div>
                                            <span class="font-medium">{{$j->nombre}}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        <div class="flex items-center">
                                            <span>{{$j->equipo}}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex items-center justify-center">
                                            {{$j->posicion}}
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex items-center justify-center">
                                            {{number_format($j->val_media, 1, ",", "")}}
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex items-center justify-center">
                                            {{number_format($j->precio, 0, "", ".")}} €
                                            <!--300.000 €-->
                                        </div>
                                    </td>
                                    @if(!in_array($j->id, $jugEq->toArray()))
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center">
                                            <form action="{{route('attach')}}" method="POST">
                                                @csrf
                                                @method("POST")
                                                <input type="hidden" name="equipo" value="{{$equipo->id}}"/>
                                                <input type="hidden" name="jugador" value="{{$j->id}}"/>
                                                <button type="submit">
                                                    <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-green-100 bg-green-600 rounded-full">Fichar</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    @else
                                        <td class="py-3 px-6 text-center">
                                            <div class="flex item-center justify-center">
                                                <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">Ya está en tu equipo</span>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                let tableUsers = $('#jugadores').DataTable({
                    responsive: true,
                    dom: 'Blfrtip',
                    autoWidth: false,
                    buttons: [
                        'copy', 'excel', 'pdf'
                    ],
                    "order": [[ 3, "desc" ]],
                    "pagingType": "full_numbers",
                    pageLength: 10,
                    lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                }).columns.adjust().responsive.recalc();
            });
        </script>
    </x-slot>

</x-app-layout>
