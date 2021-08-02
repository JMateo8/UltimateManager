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
                        <a href="{{route("equipo.index")}}">
                            <x-button>
                                Volver
                            </x-button>
                        </a>
                    </div>
                    <div class="p-6 bg-white">
                        <b>Crear nuevo equipo</b>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center bg-white border-b border-gray-200">
                        <form action="{{route('equipo.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method("POST")
                            <div class="flex flex-wrap justify-center -mx-3 mb-6">
                                <div class="sm:w-3/4 w-full px-3">
                                    <label for="nombre" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                        Nombre del equipo
                                    </label>
                                    <input name="nombre" value="{{old('nombre')}}" id="nombre" type="text" required placeholder="Equipo XXX" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    @error('nombre')
                                    <p class="text-red-600 text-sm font-semibold">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                            <input type="hidden" name="user_id" value="{{auth()->id()}}">
                            <x-button type="submit" class="bg-green-600">
                                {{ __('Crear') }}
                            </x-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

</x-app-layout>
