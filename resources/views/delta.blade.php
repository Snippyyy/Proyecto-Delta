@extends('layouts.delta')

@section('title', 'Delta')

@section('content')

    <section class="bg-white py-8">
        <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12">
            <x-category-show-nav/>
            @foreach($products as $product)
                <livewire:product-item :product="$product" />
            @endforeach
        </div>
    </section>

@endsection
