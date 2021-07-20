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
                        Crear nueva liga
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center bg-white border-b border-gray-200">
                        <form action="{{route('liga.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mt-4">
                                <x-label for="nommbre" :value="__('Nombre de la liga')" />
                                <x-input id="nombre" class="mt-1 w-1/2"
                                         type="text"
                                         name="nombre"
                                         required />
                            </div>
                            <div class="mt-4">
                                <x-label for="password" :value="__('Contraseña')" />
                                <x-input id="password" class="mt-1 w-1/2"
                                         type="password"
                                         name="password"
                                         required />
                            </div>
                            <div class="mt-4 invisible h-0 w-0">
                                <x-label for="admin" :value="__('Id Admin')" />
                                <x-input id="admin" class="mt-1 w-1/2"
                                         type="hidden"
                                         name="admin"
                                         value="{{\Illuminate\Support\Facades\Auth::id()}}"
                                />
                            </div>
                            <x-button class="mt-4 bg-green-600" type="submit">
                                {{ __('Crear') }}
                            </x-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

</x-app-layout>
