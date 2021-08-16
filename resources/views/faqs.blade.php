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
                        <div class="text-center">
                            <b>Reglas y preguntas más frecuentes (FAQ's)</b>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="grid overflow-hidden grid-cols-2 grid-rows-2 gap-2">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h2 class="text-base text-center font-semibold uppercase">Equipos</h2>
                        </div>
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h2 class="text-base text-center font-semibold uppercase">Ligas</h2>
                        </div>
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h2 class="text-base text-center font-semibold uppercase">Mercado</h2>
                        </div>
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h2 class="text-base text-center font-semibold uppercase">xxx</h2>
                        </div>
                    </div>
                </div>
            </div>
    </x-slot>

</x-app-layout>
