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
                        Ver jugador: <b>{{$jugador->nombre}}</b> | {{$jugador->equipo}}
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center bg-white border-b border-gray-200">
                        <div class="grid overflow-hidden grid-cols-1 sm:grid-cols-2 grid-rows-1 gap-2">
                            <div class="box">
                                <img class="border-2 h-full w-full" src="https://www.euroleague.net/rs/avxijgcoadecfbkk/c4974b14-d249-46d4-9092-0e470e8d733d/80f/filename/c49.jpg">
                            </div>
                            <div class="box">
                                <ul class="list-disc list-inside text-left ml-8">
                                    <li><b>Nombre</b>: {{$jugador->nombre}}</li>
                                    <li><b>Equipo</b>: {{$jugador->equipo}}</li>
                                    <li><b>Posición</b>: {{$jugador->posicion}}</li>
                                    <li><b>Nacionalidad</b>: España </li>
                                    <li><b>Edad</b>: 34 años</li>
                                    <li><b>Dorsal</b>: #13</li>
                                    <li><b>Height</b>: 1.91m</li>
                                    <li><b>Valoración media</b>: {{number_format($jugador->val_media, 1, ",", "")}}</li>
                                    <li><b>Valoración precio</b>: {{number_format($jugador->precio, 0, "", ".")}} €</li>
                                </ul>
                            </div>
                        </div>
                        <a href="{{route("jugador.index")}}">
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
