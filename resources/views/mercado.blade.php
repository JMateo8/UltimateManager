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
                    <table id="jugadores" class="min-w-full table-auto">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Nombre</th>
                            <th class="py-3 px-6 text-left">Equipo</th>
                            <th class="py-3 px-6 text-left">Posición</th>
                            <th class="py-3 px-6 text-center">Valoración media</th>
                            <th class="py-3 px-6 text-center">Precio</th>
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
                                        {{number_format($jugador->val_media, 1, ",", "")}}
                                    </div>
                                </td>
                                <td class="py-3 px-6 whitespace-nowrap">
                                    <div class="flex items-center justify-center">
                                        {{number_format($jugador->precio, 0, "", ".")}} €
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
</x-app-layout>
