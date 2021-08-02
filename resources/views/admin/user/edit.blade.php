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
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
                                        Nombre
                                    </label>
                                    <input name="name" id="name" type="text" required value="{{old('email', $user->name)}}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white">
                                </div>
                                <div class="w-full md:w-1/2 px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="email">
                                        Correo electrónico
                                    </label>
                                    <input name="email" id="email" type="text" required value="{{old('email', $user->email)}}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    @error('email')
                                    <p class="text-red-600 text-sm font-semibold">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label for="admin" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
                                        Rol
                                    </label>
                                    <div class="relative">
                                        <select id="admin" required name="admin" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                            <option value="0" @if(old('admin', $user->admin) === '0') selected @endif>Usuario</option>
                                            <option value="1" @if(old('admin', $user->admin) === '1') selected @endif>Administrador</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="password">
                                        Contraseña
                                    </label>
                                    <input required name="password" id="password" type="password" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    @error('password')
                                    <p class="text-red-600 text-sm font-semibold">{{$message}}</p>
                                    @enderror
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
