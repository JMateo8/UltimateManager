<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de administración') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="pt-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex items-center justify-between">
                    <div class="p-6 bg-white">
                        <a href="{{route("liga.index")}}">
                            <x-button>
                                Volver
                            </x-button>
                        </a>
                    </div>
                    @if(!in_array($liga->id, $ligasActivas))
                    <div class="p-6 bg-white">
                        <a href="{{route("liga.edit", [$liga])}}">
                            <x-button class="bg-green-600">
                                Inscrbir
                            </x-button>
                        </a>
                    </div>
                    @endif
                    <div class="p-6 bg-white">
                        LIGA <b>{{$liga->nombre}}</b>
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
                            @foreach($equipos as $equipo)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-center hidden sm:table-cell md:table-cell lg:table-cell">
                                        <div class="flex items-center">
                                            <!--<span class="font-medium">{{++$loop->index}}</span>-->
                                            <span class="font-medium">{{$loop->iteration}}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-center hidden sm:table-cell md:table-cell lg:table-cell">
                                        <div class="flex items-center">
                                            <span class="font-medium">{{$equipo->nombre}}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="font-medium">{{\App\Models\User::find($equipo->user_id)->name}}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        <div class="flex items-center">
                                            <span>{{number_format($equipo->puntuacion, 1, ",", "")}} pts.</span>
                                        </div>
                                    </td>
                                    @if(\Illuminate\Support\Facades\Auth::user()->admin === 1
                                        || $liga->admin === \Illuminate\Support\Facades\Auth::id()
                                        || $equipo->user_id === \Illuminate\Support\Facades\Auth::id())
                                        <td class="py-3 px-6 text-left">
                                            <div class="flex item-center">
                                                <form action="{{route('desapuntar')}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="w-4 mr-2 transform text-red-500 hover:text-red-500 hover:scale-110">
                                                        <input type="hidden" name="equipo" value="{{$equipo->id}}">
                                                        <input type="hidden" name="liga" value="{{$liga->id}}">
                                                        <button type="submit" title="Desapuntar">
                                                            <i class="fas fa-sign-out-alt"></i>
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
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

</x-app-layout>
