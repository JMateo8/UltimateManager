<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ultimate Manager') }}
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
                    <div class="p-6 bg-white">
                        Cambiar contraseña <b>{{$liga->nombre}}</b>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center bg-white border-b border-gray-200">
                        <form action="{{route('liga.update', [$liga])}}" method="POST">
                            @method("PUT")
                            @csrf
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="nombre">
                                        Nombre de la liga
                                    </label>
                                    <input readonly name="nombre" id="nombre" type="text" value="{{$liga->nombre}}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white">
                                </div>
                                <div class="w-full md:w-1/2 px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="password">
                                        Contraseña
                                    </label>
                                    <input name="password" id="password" type="password" required class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                </div>
                            </div>
                            <x-button type="submit" class="bg-green-600">
                                {{ __('Actualizar') }}
                            </x-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

</x-app-layout>
