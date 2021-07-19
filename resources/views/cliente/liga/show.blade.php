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
                    <div class="p-6 text-center bg-white border-b border-gray-200">
                        <b>{{$liga->nombre}}</b>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center bg-white border-b border-gray-200">
                        @if($equipos->count()===0)
                            <div class="border-b-2 pb-3">
                                <b>Esta liga no tiene ningún equipos inscrito</b>
                            </div>
                        @else
                            <div class="border-b-2 pb-3 mb-3">
                                <b>Clasificación</b>
                            </div>
                            <table class="min-w-min w-full table-auto">
                            <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left hidden sm:table-cell md:table-cell lg:table-cell">Posicion</th>
                                <th class="py-3 px-6 text-left hidden sm:table-cell md:table-cell lg:table-cell">Equipo</th>
                                <th class="py-3 px-6 text-left">Usuario</th>
                                <th class="py-3 px-6 text-left">Puntuación</th>
                                <th class="py-3 px-6 text-left">Acciones</th>
                            </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                            @foreach($equipos as $e)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-center hidden sm:table-cell md:table-cell lg:table-cell">
                                        <div class="flex items-center">
                                            <!--<span class="font-medium">{{++$loop->index}}</span>-->
                                            <span class="font-medium">{{$loop->iteration}}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-center hidden sm:table-cell md:table-cell lg:table-cell">
                                        <div class="flex items-center">
                                            <span class="font-medium">{{$e->nombre}}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="font-medium">{{\App\Models\User::find($e->user_id)->name}}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        <div class="flex items-center">
                                            <span>{{number_format($e['puntuacion'], 1, ",", "")}} pts.</span>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @endif
                        <hr/>
                        <a href="{{route("liga.index")}}">
                            <x-button class="mt-4">
                                {{ __('Volver') }}
                            </x-button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

</x-app-layout>
