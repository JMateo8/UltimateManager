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
                    <div class="p-6 text-center flex justify-between items-center bg-white border-b border-gray-200">
                        <div>
                            <b>Listado de equipos</b>
                        </div>
                        <div>
                            <a href="{{route("equipo.create")}}">
                                <x-button class="bg-green-600">
                                    {{ __('Nuevo equipo') }}
                                </x-button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($equipos->count())
                    <table class="min-w-max w-full table-auto">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Equipo</th>
                            <th class="py-3 px-6 text-left hidden sm:table-cell md:table-cell lg:table-cell">Puntuación</th>
                            <th class="py-3 px-6 text-left hidden sm:table-cell md:table-cell lg:table-cell">Jugadores</th>
                            <th class="py-3 px-6 text-left hidden sm:table-cell md:table-cell lg:table-cell">Ligas</th>
                            <th class="py-3 px-6 text-center">Acciones</th>
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
                                <td class="py-3 px-6 text-left whitespace-nowrap hidden sm:table-cell md:table-cell lg:table-cell">
                                    <div class="flex">
                                        {{number_format($equipo->puntuacion, 1, ",", "")}} pts.
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap hidden sm:table-cell md:table-cell lg:table-cell">
                                    <div class="flex">
                                        {{$equipo->jugadores->where("pivot.jornada_id", $jornada_actual)->count()}}/10
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left whitespace-nowrap hidden sm:table-cell md:table-cell lg:table-cell">
                                    <div class="flex">
                                        @if(count($equipo->ligas))
                                        @foreach($equipo->ligas as $liga)
                                            {{$liga->nombre}}<br/>
                                        @endforeach
                                        @else
                                            0 ligas
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center">
                                        <div class="w-4 mr-2 transform text-yellow-500 hover:text-yellow-500 hover:scale-110">
                                            <a href="{{route("equipo.show", [$equipo] )}}" title="Ver">
                                                <i class="far fa-edit"></i>
                                            </a>
                                        </div>
                                        <form action="{{route('equipo.destroy', [$equipo])}}" method="post">
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
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @else
                        <div class="flex items-center justify-center">
                            <b class="text-center">¡Crea tu primer equipo YA!</b>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </x-slot>
</x-app-layout>
