<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ultimate Manager') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="pt-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center bg-white border-b border-gray-200">
                        <div class="text-center">
                            <b>Mercado de jugadores</b>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <table id="jugadores" class="min-w-full table-auto">
                                <thead>
                                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Nombre</th>
                                    <th class="py-3 px-6 text-center">Equipo</th>
                                    <th class="py-3 px-6 text-center">Posición</th>
                                    <th class="py-3 px-6 text-center">Valoración media</th>
                                    <th class="py-3 px-6 text-center">Precio</th>
                                    <th class="py-3 px-6 text-center">País</th>
                                    <th class="py-3 px-6 text-center">Altura</th>
                                    <th class="py-3 px-6 text-center">Edad</th>
                                    @if(auth()->user()->admin === 1)
                                        <th class="py-3 px-6 text-center">Acciones</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                @foreach($jugadores as $jugador)
                                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                                        <td class="py-3 px-6 text-left whitespace-nowrap">
                                            <div class="flex items-center">
                                                <span class="font-medium">{{$jugador->nombre}}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-6 text-center whitespace-nowrap">
                                            <span class="font-medium">{{$jugador->equipo_euro->nombre}}</span>
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            {{$jugador->posicion}}
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
                                        <td class="py-3 px-6 text-center">
                                            <div class="flex items-center justify-center">
                                                {{$jugador->pais}}
                                            </div>
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            <div class="flex items-center justify-center">
                                                {{number_format($jugador->altura/100, 2, "'", ".")}} m.
                                            </div>
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            <div class="flex items-center justify-center">
                                                {{$jugador->edad}}
                                            </div>
                                        </td>
                                        @if(auth()->user()->admin === 1)
                                            <td class="py-3 px-6 text-center">
                                                <div class="flex item-center justify-center">
                                                    <div class="w-4 mr-2 transform text-yellow-500 hover:text-yellow-500 hover:scale-110">
                                                        <a href="{{route("jugador.edit", [$jugador] )}}" title="Editar">
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                                    </div>
                                                    <form action="{{route('jugador.destroy', [$jugador])}}" method="post">
                                                        @method("delete")
                                                        @csrf
                                                        <div class="w-4 mr-2 transform text-red-500 hover:text-red-500 hover:scale-110">
                                                            <button type="submit" title="Eliminar">
                                                                <i class="far fa-trash-alt"></i>
                                                            </button>
                                                        </div>
                                                    </form>
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
            <!-- Alpine.js -->
            <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

            <script>
                $(document).ready(function () {
                    let tableJugadores = $('#jugadores').DataTable({
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
