<?php
    $jornada_actual = \App\Models\Jornada::where("actual", 1)->first()->id;
    $equipos = \App\Models\Equipo::where("user_id", auth()->id())
        ->withCount([
            'jugadores' => function ($query) use($jornada_actual) {
                $query->where('jornada_id', $jornada_actual);
            }])
        ->take(4)
        ->get();
?>
<x-app-layout>
    <x-slot name="header">

        <div class="flex justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Ultimate Manager') }}
                </h2>
            </div>
            <div>
                Jornada actual: {{$jornada_actual}}
            </div>
        </div>

    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 max-h-full">
                    <div class="grid overflow-hidden grid-cols-3 grid-rows-2 gap-2">
                        <!--Tablas-->
                        <div class="box col-span-3 sm:col-span-2 md:col-span-2 lg:col-span-2">
                            <?php
                                //$equipos = auth()->user()->equipos->take(4);
                            ?>
                            <h3 class="text-center border-b-2 mb-3">Equipos</h3>
                            <table class="min-w-max w-full table-auto">
                                <thead>
                                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Equipo</th>
                                    <th class="py-3 px-6 text-left hidden sm:hidden md:table-cell lg:table-cell">Puntos</th>
                                    <th class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">Jugadores</th>
                                    <th class="py-3 px-6 text-center">Acciones</th>
                                </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    @if(count($equipos)===0)
                                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                                            <td class="py-3 px-6 text-left whitespace-nowrap" colspan="4">
                                                <div class="flex justify-between items-center">
                                                    <div><i>No has creado ningún equipo todavía</i></div>
                                                    <div>
                                                        <a href="{{route("equipo.create")}}">
                                                            <x-button>
                                                                Crear
                                                            </x-button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                    @foreach($equipos as $e)
                                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <span class="font-medium">{{$e->nombre}}</span>
                                                </div>
                                            </td>
                                            <td class="py-3 px-6 text-left hidden sm:hidden md:table-cell lg:table-cell">
                                                <div class="flex items-center">
                                                    <span class="text-center">{{number_format($e->puntuacion, 1, ",", "")}} pts.</span>
                                                </div>
                                            </td>
                                            <td class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">
                                                <div class="flex items-center justify-center">
                                                    <span class="text-center">
                                                        {{$e->jugadores_count}}/10
                                                    </span>
                                                </div>
                                            </td>

                                            <td class="py-3 px-6 text-center">
                                                <div class="flex item-center justify-center">
                                                    <div class="w-4 mr-2 transform text-yellow-500 hover:text-yellow-500 hover:scale-110">
                                                        <a href="{{route("equipo.show", [$e] )}}" title="Ver">
                                                            <!--<i class="far fa-eye"></i>-->
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                                    </div>
                                                    <form action="{{route('equipo.destroy', [$e])}}" method="post">
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
                                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                                        <td class="py-3 px-6 text-left whitespace-nowrap" colspan="4">
                                            <div class="flex items-center justify-between">
                                                <div>Ver todos los equipos</div>
                                                <div>
                                                    <a href="{{route("equipo.index")}}">
                                                        <x-button>
                                                            Ver
                                                        </x-button>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="box row-start-2 sm:col-start-2 col-span-3 sm:col-span-2 md:col-span-2 lg:col-span-2">
                            <!--Ligas-->
                            <?php
                            $ligas = \App\Models\Liga::with(["user"])
                                ->whereHas('equipos', function($q) {
                                    $q->where('user_id', \auth()->id());
                                })
                                ->withCount("equipos")->take(4)->get();
                            ?>
                            <h3 class="text-center border-b-2 mb-3">Ligas</h3>
                            <table class="min-w-max w-full table-auto">
                                <thead>
                                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Nombre</th>
                                    <th class="py-3 px-6 text-center hidden sm:hidden md:table-cell lg:table-cell">Admin</th>
                                    <th class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">Equipos</th>
                                    <th class="py-3 px-6 text-center">Acciones</th>
                                </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                @if(count($ligas)===0)
                                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                                        <td class="py-3 px-6 text-left whitespace-nowrap" colspan="4">
                                            <div class="flex items-center justify-between">
                                                <div><i>No perteneces a ninguna liga todavía</i></div>
                                                <div>
                                                    <a href="{{route("liga.index")}}">
                                                        <x-button>
                                                            Ligas
                                                        </x-button>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    @foreach($ligas as $liga)
                                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                                            <td class="py-3 px-6 text-left">
                                                <div class="flex items-center">
                                                    {{$liga->nombre}}
                                                </div>
                                            </td>
                                            <td class="py-3 px-6 text-center hidden sm:hidden md:table-cell lg:table-cell">
                                                <div class="flex items-center justify-center">
                                                    {{$liga->user->name}}
                                                </div>
                                            </td>
                                            <td class="py-3 px-6 text-center hidden sm:hidden md:hidden lg:table-cell">
                                                <div class="flex items-center justify-center">
                                                    {{$liga->equipos_count}}
                                                </div>
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                <div class="flex item-center justify-center">
                                                    <div class="w-4 mr-2 transform text-indigo-500 hover:text-indigo-500 hover:scale-110">
                                                        <a href="{{route('liga.show', [$liga])}}" title="Ver">
                                                            <i class="far fa-eye"></i>
                                                        </a>
                                                    </div>
                                                    @if(auth()->id() === $liga->admin)
                                                    <form action="{{route('liga.destroy', [$liga])}}" method="post">
                                                        @method("delete")
                                                        @csrf
                                                        <div class="w-4 mr-2 transform text-red-500 hover:text-red-500 hover:scale-110">
                                                            <button type="submit" title="Eliminar">
                                                                <i class="far fa-trash-alt"></i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                                        <td class="py-3 px-6 text-left whitespace-nowrap" colspan="4">
                                            <div class="flex items-center justify-between">
                                                <div>Ver todas las ligas</div>
                                                <div>
                                                    <a href="{{route("liga.index")}}">
                                                        <x-button>
                                                            Ver
                                                        </x-button>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>

                        <!--Twitter Timeline cols1xrows2-->
                        <div class="box row-start-3 row-span-2 sm:row-start-1 sm:col-start-1 col-span-3 sm:col-span-1">
                            <h3 class="text-center border-b-2 mb-3">Novedades</h3>
                            <a class="twitter-timeline" data-theme="light" data-height="700" href="https://twitter.com/EuroLeague?ref_src=twsrc%5Etfw">
                                Tweets by EuroLeague
                            </a>
                            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
