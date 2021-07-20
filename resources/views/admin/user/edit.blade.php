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
                    <div class="p-6 text-center flex justify-between items-center bg-white border-b border-gray-200">
                        <div>
                            <a href="{{route("user.index")}}">
                                <x-button>
                                    {{ __('Volver') }}
                                </x-button>
                            </a>
                        </div>
                        <div>
                            Editar usuario <b>{{$user->name}}</b>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center bg-white border-b border-gray-200">
                        <form action="{{route('user.update',[$user])}}" method="POST">
                            @csrf
                            @method("PUT")
                            <div class="mt-4">
                                <x-label for="name" :value="__('Nombre')" />
                                <x-input id="name" class="mt-1 w-1/2"
                                         type="text"
                                         name="name"
                                         value="{{$user->name}}"
                                         placeholder="{{$user->name}}"
                                         required />
                            </div>
                            <div class="mt-4">
                                <x-label for="email" :value="__('Correo electrónico')" />
                                <x-input id="email" class="mt-1 w-1/2"
                                         type="text"
                                         name="email"
                                         value="{{$user->email}}"
                                         placeholder="{{$user->email}}"
                                         required />
                            </div>
                            <div class="mt-4">
                                <x-label for="password" :value="__('Contraseña')" />
                                <x-input id="password" class="mt-1 w-1/2"
                                         type="password"
                                         name="password"
                                         value=""
                                         placeholder=""
                                         required />
                            </div>
                            <div class="mt-4">
                                <x-label for="admin" :value="__('Rol')" />
                                <select name="admin" class="w-1/2 rounded-md shadow-sm border-gray-300 focus:border-green-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="0" @if($user->admin === 0) selected @endif>Usuario</option>
                                    <option value="1" @if($user->admin === 1) selected @endif>Administrador</option>
                                </select>

                            </div>
                            <x-button class="mt-4" type="submit">
                                {{ __('Actualizar') }}
                            </x-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

</x-app-layout>
