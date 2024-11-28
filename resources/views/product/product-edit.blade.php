<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar Producto - {{$product->name}}</title>
</head>
<body>
<form action="{{route('product.update', $product)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div>
        <x-input-label for="name" :value="__('Title')"/>
        <x-text-input name="name"></x-text-input>
        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
    </div>
    <br>
    <div>
        <x-input-label for="description" :value="__('Description')"/>
        <br>
        <textarea name="description"></textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2"/>
    </div>
    <br>
    <div>
        <x-input-label for="price" :value="__('Price')"/>
        <x-text-input name="price"></x-text-input>
        <x-input-error :messages="$errors->get('price')" class="mt-2"/>
    </div>
    <br>
    <div>
        <x-input-label for="shipment" :value="__('Shipment')"/>
        <input type="hidden" name="shipment" value="0">
        <input type="checkbox" value="1" name="shipment"> <span>¿Aceptas envios?</span>
        <x-input-error :messages="$errors->get('shipment')" class="mt-2"/>
    </div>
    <br>
    <div>
        <x-input-label for="category_id" :value="__('Category')"/>
        <select name="category_id" id="category">
            @foreach($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>
    </div>
    <x-primary-button>{{ __('Edit') }}</x-primary-button>
</form>
<br>
<a href="{{route('product.show', $product)}}">Volver</a>
</body>
</html>
