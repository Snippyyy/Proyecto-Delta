<!DOCTYPE html>
<html lang="es">

<head>
    <x-delta-header />
    <title>@yield('title', 'Delta')</title>
</head>

<body class="bg-white text-gray-600 work-sans leading-normal text-base tracking-normal">

<x-nav-delta />

@include('components.delta-session')

@yield('content')


<x-delta-footer />

</body>

@yield('scripts')

</html>
