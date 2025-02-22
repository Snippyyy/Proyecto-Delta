@extends('layouts.delta')

@section('title', __("Favoritos"))

@section('content')

    @if($favoriteItems->isEmpty())
        <div class="bg-gray-200">
            <p class="text-center">{{__("No tienes productos favoritos")}}</p>
        </div>
    @endif
    <ul>
        @foreach($favoriteItems as $favorite)
            @livewire('favorite-items', ['favorite' => $favorite])
        @endforeach
    </ul>

@endsection

