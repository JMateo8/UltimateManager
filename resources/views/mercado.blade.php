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
        </div>

        <div class="pt-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 overflow-x-auto">
                        <div x-data="{
                              openTab: 1,
                              activeClasses: 'border-l border-t border-r rounded-t text-indigo-700',
                              inactiveClasses: 'text-black-500 hover:text-green-600'
                            }" class="p-6">
                            <ul class="flex border-b overflow-x-auto overflow-y-hidden">
                                <li @click="openTab = 1" :class="{ '-mb-px': openTab === 1 }" class="-mb-px mr-1">
                                    <a :class="openTab === 1 ? activeClasses : inactiveClasses" class="bg-white inline-block py-2 px-4 font-semibold" href="#">
                                        Todos
                                    </a>
                                </li>
                                <li @click="openTab = 2" :class="{ '-mb-px': openTab === 2 }" class="-mb-px mr-1">
                                    <a :class="openTab === 2 ? activeClasses : inactiveClasses" class="bg-white inline-block py-2 px-4 font-semibold" href="#">
                                        Bases
                                    </a>
                                </li>
                                <li @click="openTab = 3" :class="{ '-mb-px': openTab === 3 }" class="mr-1">
                                    <a :class="openTab === 3 ? activeClasses : inactiveClasses" class="bg-white inline-block py-2 px-4 font-semibold" href="#">
                                        Escoltas
                                    </a>
                                </li>
                                <li @click="openTab = 4" :class="{ '-mb-px': openTab === 4 }" class="mr-1">
                                    <a :class="openTab === 4 ? activeClasses : inactiveClasses" class="bg-white inline-block py-2 px-4 font-semibold" href="#">
                                        Aleros
                                    </a>
                                </li>
                                <li @click="openTab = 5" :class="{ '-mb-px': openTab === 5 }" class="mr-1">
                                    <a :class="openTab === 5 ? activeClasses : inactiveClasses" class="bg-white inline-block py-2 px-4 font-semibold" href="#">
                                        Ala-Pívot
                                    </a>
                                </li>
                                <li @click="openTab = 6" :class="{ '-mb-px': openTab === 6 }" class="mr-1">
                                    <a :class="openTab === 6 ? activeClasses : inactiveClasses" class="bg-white inline-block py-2 px-4 font-semibold" href="#">
                                        Pívot
                                    </a>
                                </li>
                            </ul>
                            <div class="w-full pt-4">
                                <div x-show="openTab === 1">
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
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div x-show="openTab === 2">
                                    <table id="bases" class="min-w-full table-auto">
                                        <thead>
                                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                            <th class="py-3 px-6 text-left" data-priority="1">Nombre</th>
                                            <th class="py-3 px-6 text-center table-cell sm:table-cell md:table-cell lg:table-cell">Equipo</th>
                                            <th class="py-3 px-6 text-center table-cell sm:table-cell md:table-cell lg:table-cell">Posición</th>
                                            <th class="py-3 px-6 text-center table-cell sm:table-cell md:table-cell lg:table-cell">Valoración media</th>
                                            <th class="py-3 px-6 text-center table-cell sm:table-cell md:table-cell lg:table-cell">Precio</th>
                                            <th class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">País</th>
                                            <th class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">Altura</th>
                                            <th class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">Edad</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-gray-600 text-sm font-light">
                                        @foreach($jugadores as $jugador)
                                            @if($jugador->posicion === "Base")
                                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <span class="font-medium">{{$jugador->nombre}}</span>
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 text-center whitespace-nowrap table-cell sm:table-cell md:table-cell lg:table-cell">
                                                        <span class="font-medium">{{$jugador->equipo_euro->nombre}}</span>
                                                    </td>
                                                    <td class="py-3 px-6 text-center table-cell sm:table-cell md:table-cell lg:table-cell">
                                                        {{$jugador->posicion}}
                                                    </td>
                                                    <td class="py-3 px-6 whitespace-nowrap table-cell sm:table-cell md:table-cell lg:table-cell">
                                                        <div class="flex items-center justify-center">
                                                            {{number_format($jugador->val_media, 1, ",", "")}}
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 whitespace-nowrap table-cell sm:table-cell md:table-cell lg:table-cell">
                                                        <div class="flex items-center justify-center">
                                                            {{number_format($jugador->precio, 0, "", ".")}} €
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">
                                                        <div class="flex items-center justify-center">
                                                            {{$jugador->pais}}
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">
                                                        <div class="flex items-center justify-center">
                                                            {{number_format($jugador->altura/100, 2, "'", ".")}} m.
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">
                                                        <div class="flex items-center justify-center">
                                                            {{$jugador->edad}}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <hr class="py-2">
                                </div>
                                <div x-show="openTab === 3">
                                    <table id="escoltas" class="min-w-full table-auto">
                                        <thead>
                                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                            <th class="py-3 px-6 text-left" data-priority="1">Nombre</th>
                                            <th class="py-3 px-6 text-center table-cell sm:table-cell md:table-cell lg:table-cell">Equipo</th>
                                            <th class="py-3 px-6 text-center table-cell sm:table-cell md:table-cell lg:table-cell">Posición</th>
                                            <th class="py-3 px-6 text-center table-cell sm:table-cell md:table-cell lg:table-cell">Valoración media</th>
                                            <th class="py-3 px-6 text-center table-cell sm:table-cell md:table-cell lg:table-cell">Precio</th>
                                            <th class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">País</th>
                                            <th class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">Altura</th>
                                            <th class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">Edad</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-gray-600 text-sm font-light">
                                        @foreach($jugadores as $jugador)
                                            @if($jugador->posicion === "Escolta")
                                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <span class="font-medium">{{$jugador->nombre}}</span>
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 text-center whitespace-nowrap table-cell sm:table-cell md:table-cell lg:table-cell">
                                                        <span class="font-medium">{{$jugador->equipo_euro->nombre}}</span>
                                                    </td>
                                                    <td class="py-3 px-6 text-center table-cell sm:table-cell md:table-cell lg:table-cell">
                                                        {{$jugador->posicion}}
                                                    </td>
                                                    <td class="py-3 px-6 whitespace-nowrap table-cell sm:table-cell md:table-cell lg:table-cell">
                                                        <div class="flex items-center justify-center">
                                                            {{number_format($jugador->val_media, 1, ",", "")}}
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 whitespace-nowrap table-cell sm:table-cell md:table-cell lg:table-cell">
                                                        <div class="flex items-center justify-center">
                                                            {{number_format($jugador->precio, 0, "", ".")}} €
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">
                                                        <div class="flex items-center justify-center">
                                                            {{$jugador->pais}}
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">
                                                        <div class="flex items-center justify-center">
                                                            {{number_format($jugador->altura/100, 2, "'", ".")}} m.
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">
                                                        <div class="flex items-center justify-center">
                                                            {{$jugador->edad}}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div x-show="openTab === 4">
                                    <table id="aleros" class="min-w-full table-auto">
                                        <thead>
                                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                            <th class="py-3 px-6 text-left" data-priority="1">Nombre</th>
                                            <th class="py-3 px-6 text-center table-cell sm:table-cell md:table-cell lg:table-cell">Equipo</th>
                                            <th class="py-3 px-6 text-center table-cell sm:table-cell md:table-cell lg:table-cell">Posición</th>
                                            <th class="py-3 px-6 text-center table-cell sm:table-cell md:table-cell lg:table-cell">Valoración media</th>
                                            <th class="py-3 px-6 text-center table-cell sm:table-cell md:table-cell lg:table-cell">Precio</th>
                                            <th class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">País</th>
                                            <th class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">Altura</th>
                                            <th class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">Edad</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-gray-600 text-sm font-light">
                                        @foreach($jugadores as $jugador)
                                            @if($jugador->posicion === "Alero")
                                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <span class="font-medium">{{$jugador->nombre}}</span>
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 text-center whitespace-nowrap table-cell sm:table-cell md:table-cell lg:table-cell">
                                                        <span class="font-medium">{{$jugador->equipo_euro->nombre}}</span>
                                                    </td>
                                                    <td class="py-3 px-6 text-center table-cell sm:table-cell md:table-cell lg:table-cell">
                                                        {{$jugador->posicion}}
                                                    </td>
                                                    <td class="py-3 px-6 whitespace-nowrap table-cell sm:table-cell md:table-cell lg:table-cell">
                                                        <div class="flex items-center justify-center">
                                                            {{number_format($jugador->val_media, 1, ",", "")}}
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 whitespace-nowrap table-cell sm:table-cell md:table-cell lg:table-cell">
                                                        <div class="flex items-center justify-center">
                                                            {{number_format($jugador->precio, 0, "", ".")}} €
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">
                                                        <div class="flex items-center justify-center">
                                                            {{$jugador->pais}}
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">
                                                        <div class="flex items-center justify-center">
                                                            {{number_format($jugador->altura/100, 2, "'", ".")}} m.
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">
                                                        <div class="flex items-center justify-center">
                                                            {{$jugador->edad}}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div x-show="openTab === 5">
                                    <table id="alapivots" class="min-w-full table-auto">
                                        <thead>
                                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                            <th class="py-3 px-6 text-left" data-priority="1">Nombre</th>
                                            <th class="py-3 px-6 text-center table-cell sm:table-cell md:table-cell lg:table-cell">Equipo</th>
                                            <th class="py-3 px-6 text-center table-cell sm:table-cell md:table-cell lg:table-cell">Posición</th>
                                            <th class="py-3 px-6 text-center table-cell sm:table-cell md:table-cell lg:table-cell">Valoración media</th>
                                            <th class="py-3 px-6 text-center table-cell sm:table-cell md:table-cell lg:table-cell">Precio</th>
                                            <th class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">País</th>
                                            <th class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">Altura</th>
                                            <th class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">Edad</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-gray-600 text-sm font-light">
                                        @foreach($jugadores as $jugador)
                                            @if($jugador->posicion === "Ala-Pivot")
                                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <span class="font-medium">{{$jugador->nombre}}</span>
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 text-center whitespace-nowrap table-cell sm:table-cell md:table-cell lg:table-cell">
                                                        <span class="font-medium">{{$jugador->equipo_euro->nombre}}</span>
                                                    </td>
                                                    <td class="py-3 px-6 text-center table-cell sm:table-cell md:table-cell lg:table-cell">
                                                        {{$jugador->posicion}}
                                                    </td>
                                                    <td class="py-3 px-6 whitespace-nowrap table-cell sm:table-cell md:table-cell lg:table-cell">
                                                        <div class="flex items-center justify-center">
                                                            {{number_format($jugador->val_media, 1, ",", "")}}
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 whitespace-nowrap table-cell sm:table-cell md:table-cell lg:table-cell">
                                                        <div class="flex items-center justify-center">
                                                            {{number_format($jugador->precio, 0, "", ".")}} €
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">
                                                        <div class="flex items-center justify-center">
                                                            {{$jugador->pais}}
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">
                                                        <div class="flex items-center justify-center">
                                                            {{number_format($jugador->altura/100, 2, "'", ".")}} m.
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">
                                                        <div class="flex items-center justify-center">
                                                            {{$jugador->edad}}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div x-show="openTab === 6">
                                    <table id="pivots" class="min-w-full table-auto" width="100%">
                                        <thead>
                                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                            <th class="py-3 px-6 text-left" data-priority="1">Nombre</th>
                                            <th class="py-3 px-6 text-center table-cell sm:table-cell md:table-cell lg:table-cell">Equipo</th>
                                            <th class="py-3 px-6 text-center table-cell sm:table-cell md:table-cell lg:table-cell">Posición</th>
                                            <th class="py-3 px-6 text-center table-cell sm:table-cell md:table-cell lg:table-cell">Valoración media</th>
                                            <th class="py-3 px-6 text-center table-cell sm:table-cell md:table-cell lg:table-cell">Precio</th>
                                            <th class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">País</th>
                                            <th class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">Altura</th>
                                            <th class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">Edad</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-gray-600 text-sm font-light">
                                        @foreach($jugadores as $jugador)
                                            @if($jugador->posicion === "Pivot")
                                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <span class="font-medium">{{$jugador->nombre}}</span>
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 text-center whitespace-nowrap table-cell sm:table-cell md:table-cell lg:table-cell">
                                                        <span class="font-medium">{{$jugador->equipo_euro->nombre}}</span>
                                                    </td>
                                                    <td class="py-3 px-6 text-center table-cell sm:table-cell md:table-cell lg:table-cell">
                                                        {{$jugador->posicion}}
                                                    </td>
                                                    <td class="py-3 px-6 whitespace-nowrap table-cell sm:table-cell md:table-cell lg:table-cell">
                                                        <div class="flex items-center justify-center">
                                                            {{number_format($jugador->val_media, 1, ",", "")}}
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 whitespace-nowrap table-cell sm:table-cell md:table-cell lg:table-cell">
                                                        <div class="flex items-center justify-center">
                                                            {{number_format($jugador->precio, 0, "", ".")}} €
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">
                                                        <div class="flex items-center justify-center">
                                                            {{$jugador->pais}}
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">
                                                        <div class="flex items-center justify-center">
                                                            {{number_format($jugador->altura/100, 2, "'", ".")}} m.
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">
                                                        <div class="flex items-center justify-center">
                                                            {{$jugador->edad}}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Alpine.js -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        <script>
            $(document).ready(function () {
                let tableJugadores = $('#jugadores, #bases, #escoltas, #aleros, #alapivots, #pivots').DataTable({
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
