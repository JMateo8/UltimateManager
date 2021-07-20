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
                            <b>Administración de usuarios</b>
                        </div>
                        <div>
                            <a href="{{route("user.create")}}">
                                <x-button class="bg-green-500">
                                    {{ __('Añadir') }}
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
                        <table id="users" class="min-w-max w-full table-auto">
                            <thead>
                                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Nombre</th>
                                    <th class="py-3 px-6 text-center">Admin</th>
                                    <th class="py-3 px-6 text-center">Correo</th>
                                    <th class="py-3 px-6 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                            @foreach($users as $u)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="font-medium">{{$u->name}}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        <div class="flex items-center justify-center">
                                            @if($u->admin===1)
                                                <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-indigo-100 bg-indigo-600 rounded-full">Administrador</span>
                                            @else
                                                <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-green-100 bg-green-600 rounded-full">User</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex items-center justify-center">
                                            {{$u->email}}
                                        </div>
                                    </td>

                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center">
                                            <div class="w-4 mr-2 transform text-yellow-500 hover:text-yellow-500 hover:scale-110">
                                                <a href="{{route("user.edit", [$u] )}}" title="Editar">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                            </div>
                                            @if(\Illuminate\Support\Facades\Auth::id() !== $u->id)
                                            <form action="{{route('user.destroy', [$u])}}" method="post">
                                                @method("delete")
                                                @csrf
                                                <div class="w-4 mr-2 transform text-red-500 hover:text-red-500 hover:scale-110">
                                                    <button type="submit" title="Eliminar">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </form>
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
        <script>
            $(document).ready(function () {
                let tableUsers = $('#users').DataTable({
                    responsive: true,
                    dom: 'Blfrtip',
                    autoWidth: false,
                    buttons: [
                        'copy', 'excel', 'pdf'
                    ],
                    "order": [[ 1, "asc" ]],
                    "pagingType": "full_numbers",
                    pageLength: 10,
                    lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                }).columns.adjust().responsive.recalc();
            });
        </script>
    </x-slot>

</x-app-layout>
