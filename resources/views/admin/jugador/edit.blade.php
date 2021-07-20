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
                        <a href="{{route("jugador.index")}}">
                            <x-button>
                                Volver
                            </x-button>
                        </a>
                    </div>
                    <div class="p-6 bg-white">
                        Editar jugador: <b>{{$jugador->nombre}}</b> | {{$jugador->equipo}}
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center bg-white border-b border-gray-200">
                        <form action="{{route('jugador.update',[$jugador])}}" method="POST">
                            @csrf
                            @method("PUT")
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="nombre">
                                        Nombre
                                    </label>
                                    <input name="nombre" id="nombre" type="text" value="{{$nombre}}" placeholder="{{$nombre}}" required class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white">
                                </div>
                                <div class="w-full md:w-1/2 px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="apellido">
                                        Apellido
                                    </label>
                                    <input name="apellido" id="apellido" type="text" value="{{$apellido}}" placeholder="{{$apellido}}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                </div>
                            </div>
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full px-3">
                                    <label for="equipo" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
                                        Equipo
                                    </label>
                                    <div class="relative">
                                        <select id="equipo" name="equipo" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                            @foreach(\App\Models\EquipoEuro::all() as $equipo)
                                                <option value="{{$equipo->id}}" @if($jugador->equipo === $equipo->id) selected @endif>{{$equipo->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="posicion">
                                        Posición
                                    </label>
                                    <select id="posicion" name="posicion" required class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                        <option value="Base" @if($jugador->posicion === 'Base') selected @endif>Base</option>
                                        <option value="Escolta" @if($jugador->posicion === 'Escolta') selected @endif>Escolta</option>
                                        <option value="Alero" @if($jugador->posicion === 'Alero') selected @endif>Alero</option>
                                        <option value="Ala-Pívot" @if($jugador->posicion === 'Ala-Pívot') selected @endif>Ala-Pívot</option>
                                        <option value="Pívot" @if($jugador->posicion === 'Pívot') selected @endif>Pívot</option>
                                    </select>
                                </div>
                                <div class="w-full md:w-1/2 px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="val_media">
                                        Valoración media
                                    </label>
                                    <input name="val_media" id="val_media" type="text" value="{{$jugador->val_media}}" placeholder="{{$jugador->val_media}}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    <p class="text-gray-600 text-xs italic">Decimal con punto, no coma (17.4)</p>
                                </div>
                            </div>
                            <div class="flex flex-wrap -mx-3 mb-2">
                                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                    <label for="pais" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                        Nacionalidad
                                    </label>
                                    <input id="pais" name="pais" type="text" value="{{$jugador->pais}}" placeholder="{{$jugador->pais}}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    <p class="text-gray-600 text-xs italic">Código de 3 letras</p>
                                </div>
                                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                    <label for="edad" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                        Edad
                                    </label>
                                    <input id="edad" name="edad" type="number" value="{{$jugador->edad}}" placeholder="{{$jugador->edad}}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                </div>
                                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                    <label for="altura" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                        Altura
                                    </label>
                                    <input id="altura" name="altura" type="number" value="{{$jugador->altura}}" placeholder="{{$jugador->altura}}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    <p class="text-gray-600 text-xs italic">En cm. (195 cm.)</p>
                                </div>
                            </div>
                            <x-button type="submit" class="bg-green-600">
                                Crear
                            </x-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

</x-app-layout>
