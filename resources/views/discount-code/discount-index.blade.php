<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__("Códigos de Descuento")}}
        </h2>
    </x-slot>

    @include('components.delta-session')

    @livewire('discount-codes')

</x-app-layout>
