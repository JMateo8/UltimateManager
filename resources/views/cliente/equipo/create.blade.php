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
                        Crear equipo
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
                            <div class="mt-4">
                                <x-label for="nombre" :value="__('Nombre')" />
                                <x-input id="nombre" class="mt-1 w-1/2"
                                         type="text"
                                         name="nombre"
                                         required />
                            </div>
                            <input type="hidden" name="user_id" value="{{\Illuminate\Support\Facades\Auth::id()}}">
                            <x-button class="mt-4" type="submit">
                                {{ __('Crear') }}
                            </x-button>
                        </form>
                        <a href="{{route("equipo.index")}}">
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
