<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__("Crear un codigo de descuento")}}
        </h2>
    </x-slot>
    <form action="{{route('discount-code.store')}}" method="POST" enctype="multipart/form-data" class="ml-5 mt-5">
@csrf
        <div>
            <x-input-label for="code" :value="__('Code')"/>
            <x-text-input id="code" name="code" type="text" required maxlength="40"/>
            <x-input-error :messages="$errors->get('code')" class="mt-2"/>
        </div>
        <br>
        <div>
            <x-input-label for="percentage" :value="__('Percentage')"/>
            <x-text-input id="percentage" name="percentage" type="number" required min="1" max="100"/>
            <x-input-error :messages="$errors->get('percentage')" class="mt-2"/>
        </div>
        <br>
        <div>
            <x-input-label for="valid_until" :value="__('Valid Until')"/>
            <x-text-input id="valid_until" name="valid_until" type="date" required/>
            <x-input-error :messages="$errors->get('valid_until')" class="mt-2"/>
        </div>
        <br>
        <x-primary-button>{{ __('Crear') }}</x-primary-button>
    </form>
</x-app-layout>
