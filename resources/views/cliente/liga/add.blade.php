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
                    <div class="p-6 text-center flex justify-between bg-white border-b border-gray-200">
                        <div>
                            <b class="text-center">Añadir equipo a la liga {{$liga->nombre}}</b>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center bg-white border-b border-gray-200">
                        <form action="{{route('inscribir')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mt-4">
                                @if(\Illuminate\Support\Facades\Auth::user()->admin === 0)
                                <x-label for="equipo" :value="__('Escoge uno de tus equipos:')" />
                                <select id="equipo" name="equipo">
                                    @foreach($equipos as $equipo)
                                        <option value="{{$equipo->id}}">{{$equipo->nombre}}</option>
                                    @endforeach
                                </select>
                                @endif
                            </div>
                            <div class="my-4 pb-3 border-b-2">
                                <x-label for="password" :value="__('Clave de acceso:')" />
                                <x-input id="password" class="mt-1 w-1/2"
                                         type="password"
                                         name="password"
                                         value=""
                                         placeholder=""
                                         required />
                            </div>
                            <input type="hidden" name="liga" value="{{$liga->id}}"/>
                            <x-button type="submit">
                                Añadir
                            </x-button>
                        </form>
                        <a href="{{route("liga.index")}}">
                            <x-button class="mt-4">
                                {{ __('Volver') }}
                            </x-button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Alpine.js -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

    </x-slot>

</x-app-layout>
