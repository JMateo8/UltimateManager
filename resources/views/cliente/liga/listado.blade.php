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
                    <div class="p-6 text-center flex justify-between items-center bg-white border-b border-gray-200">
                        <div>
                            <b>Listado de ligas</b>
                        </div>
                        <div>
                            <a href="{{route("liga.create")}}">
                                <x-button class="bg-green-500">
                                    {{ __('Crear liga') }}
                                </x-button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center bg-white border-b border-gray-200">
                        <div x-data="{
                                  openTab: 3,
                                  activeClasses: 'border-l border-t border-r rounded-t text-indigo-700',
                                  inactiveClasses: 'text-black-500 hover:text-green-600'
                                }"
                             class="p-6">
                            <ul class="flex border-b">
                             @if(\Illuminate\Support\Facades\Auth::user()->admin !== 1)
                                <li @click="openTab = 1" :class="{ '-mb-px': openTab === 1 }" class="-mb-px mr-1">
                                    <a :class="openTab === 1 ? activeClasses : inactiveClasses" class="bg-white inline-block py-2 px-4 font-semibold" href="#">
                                        Equipos inscritos
                                    </a>
                                </li>
                                <li @click="openTab = 2" :class="{ '-mb-px': openTab === 2 }" class="mr-1">
                                    <a :class="openTab === 2 ? activeClasses : inactiveClasses" class="bg-white inline-block py-2 px-4 font-semibold" href="#">
                                        Ligas creadas
                                    </a>
                                </li>
                                @endif
                                <li @click="openTab = 3" :class="{ '-mb-px': openTab === 3 }" class="mr-1">
                                    <a :class="openTab === 3 ? activeClasses : inactiveClasses" class="bg-white inline-block py-2 px-4 font-semibold" href="#">
                                        Todas las ligas
                                    </a>
                                </li>
                            </ul>
                            <div class="w-full pt-4">
                                <div x-show="openTab === 1">
                                    <table class="min-w-min w-full table-auto">
                                        <thead>
                                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                            <th class="py-3 px-6 text-left hidden sm:table-cell md:table-cell lg:table-cell">ID</th>
                                            <th class="py-3 px-6 text-left">Liga</th>
                                            <th class="py-3 px-6 text-left">Administrador</th>
                                            <th class="py-3 px-6 text-left">Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-gray-600 text-sm font-light">
                                        @foreach($ligasActivas as $liga)
                                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                                <td class="py-3 px-6 text-center hidden sm:table-cell md:table-cell lg:table-cell">
                                                    <div class="flex items-center">
                                                        <span class="font-medium">{{$liga->id}}</span>
                                                    </div>
                                                </td>
                                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <span class="font-medium">{{$liga->nombre}}</span>
                                                    </div>
                                                </td>
                                                <td class="py-3 px-6 text-left">
                                                    <div class="flex items-center">
                                                        <span>{{\App\Models\User::find($liga->admin)->name}}</span>
                                                    </div>
                                                </td>
                                                <td class="py-3 px-6 text-left">
                                                    <div class="flex item-center">
                                                        <div class="w-4 mr-2 transform text-indigo-500 hover:text-indigo-500 hover:scale-110">
                                                            <a href="{{route('liga.show', [$liga])}}" title="Ver">
                                                                <i class="far fa-eye"></i>
                                                            </a>
                                                        </div>
                                                        @if(\Illuminate\Support\Facades\Auth::user()->admin === 1 ||
                                                            $liga->admin===\Illuminate\Support\Facades\Auth::id())
                                                            <form action="{{route('liga.destroy', [$liga])}}" method="post">
                                                                @method("delete")
                                                                @csrf
                                                                <div class="w-4 mr-2 transform text-red-500 hover:text-red-500 hover:scale-110">
                                                                    <button type="submit" title="Eliminar">
                                                                        <i class="far fa-trash-alt"></i>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                            <div class="w-4 mr-2 transform text-green-500 hover:text-green-500 hover:scale-110">
                                                                <form action="{{route('passvista')}}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="liga" value="{{$liga->id}}"/>
                                                                    <div class="w-4 mr-2 transform text-green-500 hover:text-green-500 hover:scale-110">
                                                                        <button type="submit" title="Cambiar contraseña">
                                                                            <i class="fas fa-unlock-alt"></i>
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div x-show="openTab === 2">
                                        <table class="min-w-max w-full table-auto">
                                            <thead>
                                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                                <th class="py-3 px-6 text-left hidden sm:table-cell md:table-cell lg:table-cell">ID</th>
                                                <th class="py-3 px-6 text-left">Liga</th>
                                                <th class="py-3 px-6 text-left hidden sm:table-cell md:table-cell lg:table-cell">Administrador</th>
                                                <th class="py-3 px-6 text-left">Acciones</th>
                                            </tr>
                                            </thead>
                                            <tbody class="text-gray-600 text-sm font-light">
                                            @foreach($ligasAdmin as $liga)
                                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                                    <td class="py-3 px-6 text-center hidden sm:table-cell md:table-cell lg:table-cell">
                                                        <div class="flex items-center">
                                                            {{$liga->id}}
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <span class="font-medium">{{$liga->nombre}}</span>
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 text-left hidden sm:table-cell md:table-cell lg:table-cell">
                                                        <div class="flex items-center">
                                                            <span>{{\App\Models\User::find($liga->admin)->name}}</span>
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-6 text-left">
                                                        <div class="flex item-center">
                                                            <div class="w-4 mr-2 transform text-indigo-500 hover:text-indigo-500 hover:scale-110">
                                                                <a href="{{route('liga.show', [$liga])}}" title="Ver">
                                                                    <i class="far fa-eye"></i>
                                                                </a>
                                                            </div>
                                                            @if(!in_array($liga->id, $ligasActivas->pluck("id")->toArray())) <div class="w-4 mr-2 transform text-yellow-500 hover:text-yellow-500 hover:scale-110">
                                                                    <a href="{{route('liga.edit', [$liga])}}" title="Inscribir">
                                                                        <i class="far fa-edit"></i>
                                                                    </a>
                                                                </div>
                                                            @endif
                                                            @if(\Illuminate\Support\Facades\Auth::user()->admin === 1 ||
                                                                $liga->admin===\Illuminate\Support\Facades\Auth::id())
                                                            <form action="{{route('liga.destroy', [$liga])}}" method="post">
                                                                    @method("delete")
                                                                    @csrf
                                                                    <div class="w-4 mr-2 transform text-red-500 hover:text-red-500 hover:scale-110">
                                                                        <button type="submit" title="Eliminar">
                                                                            <i class="far fa-trash-alt"></i>
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            <div class="w-4 mr-2 transform text-green-500 hover:text-green-500 hover:scale-110">
                                                                <form action="{{route('passvista')}}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="liga" value="{{$liga->id}}"/>
                                                                    <div class="w-4 mr-2 transform text-green-500 hover:text-green-500 hover:scale-110">
                                                                        <button type="submit" title="Cambiar contraseña">
                                                                            <i class="fas fa-unlock-alt"></i>
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                </div>
                                <div x-show="openTab === 3">
                                    <table id="ligas" class="min-w-full table-auto">
                                        <thead>
                                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                            <th class="py-3 px-6 text-left ">ID</th>
                                            <th class="py-3 px-6 text-left">Liga</th>
                                            <th class="py-3 px-6 text-left ">Administrador</th>
                                            <th class="py-3 px-6 text-left">Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-gray-600 text-sm font-light">
                                        @foreach($ligas as $liga)
                                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                                <td class="py-3 px-6 text-center ">
                                                    <div class="flex items-center">
                                                        {{$liga->id}}
                                                    </div>
                                                </td>
                                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <span class="font-medium">{{$liga->nombre}}</span>
                                                    </div>
                                                </td>
                                                <td class="py-3 px-6 text-left">
                                                    <div class="flex items-center">
                                                        {{\App\Models\User::find($liga->admin)->name}}
                                                    </div>
                                                </td>
                                                <td class="py-3 px-6 text-left">
                                                    <div class="flex item-center">
                                                        <div class="w-4 mr-2 transform text-indigo-500 hover:text-indigo-500 hover:scale-110">
                                                            <a href="{{route('liga.show', [$liga])}}" title="Ver">
                                                                <i class="far fa-eye"></i>
                                                            </a>
                                                        </div>
                                                        @if(!in_array($liga->id, $ligasActivas->pluck("id")->toArray()))
                                                        <div class="w-4 mr-2 transform text-yellow-500 hover:text-yellow-500 hover:scale-110">
                                                            <a href="{{route('liga.edit', [$liga])}}" title="Inscribir">
                                                                <i class="far fa-edit"></i>
                                                            </a>
                                                        </div>
                                                        @endif
                                                        @if(\Illuminate\Support\Facades\Auth::user()->admin === 1 ||
                                                            $liga->admin===\Illuminate\Support\Facades\Auth::id())
                                                        <form action="{{route('liga.destroy', [$liga])}}" method="post">
                                                                @method("delete")
                                                                @csrf
                                                                <div class="w-4 mr-2 transform text-red-500 hover:text-red-500 hover:scale-110">
                                                                    <button type="submit" title="Eliminar">
                                                                        <i class="far fa-trash-alt"></i>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                            <div class="w-4 mr-2 transform text-green-500 hover:text-green-500 hover:scale-110">
                                                                <form action="{{route('passvista')}}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="liga" value="{{$liga->id}}"/>
                                                                    <div class="w-4 mr-2 transform text-green-500 hover:text-green-500 hover:scale-110">
                                                                        <button type="submit" title="Cambiar contraseña">
                                                                            <i class="fas fa-unlock-alt"></i>
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                       @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Alpine.js -->



        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

        <script>
            $(document).ready(function () {
                let tableJugadores = $('#ligas').DataTable({
                    responsive: true,
                    dom: 'Blfrtip',
                    autoWidth: false,
                    buttons: [
                        'copy', 'excel', 'pdf'
                    ],
                    "order": [[ 0, "asc" ]],
                    "pagingType": "full_numbers",
                    pageLength: 10,
                    lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                }).columns.adjust().responsive.recalc();
            });
        </script>

    </x-slot>

</x-app-layout>
