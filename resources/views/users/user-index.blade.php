@extends('layouts.delta')

@section('title', __('Usuarios'))

@section('content')
    <div class="container mx-auto p-10 m-10 mb-72 ">
        <x-user-index />
    </div>
@endsection

