<nav id="header" class="w-full z-30 top-0 py-1 border-gray-400 border-b-2">
    <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-6 py-3">
        <label for="menu-toggle" class="cursor-pointer md:hidden block">
            <svg class="fill-current text-gray-900" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                <title>menu</title>
                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
            </svg>
        </label>
        <input class="hidden" type="checkbox" id="menu-toggle" />
        <div class="hidden md:flex md:items-center md:w-auto w-full order-3 md:order-1" id="menu">
            <nav>
                <ul class="md:flex items-center justify-between text-base text-gray-700 pt-4 md:pt-0">
                    @auth
                        @if (Route::currentRouteName() !== 'product.create')
                            <li>
                                <a class="inline-block no-underline hover:text-black hover:underline py-2 px-4" href="{{route('product.create')}}">
                                    Publicar producto
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </nav>
        </div>
        <div class="order-1 md:order-2 flex justify-center w-full md:w-auto">
            <a class="flex items-center tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl" href="{{route('index')}}">
                <svg class="fill-current text-gray-800 mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M5,22h14c1.103,0,2-0.897,2-2V9c0-0.553-0.447-1-1-1h-3V7c0-2.757-2.243-5-5-5S7,4.243,7,7v1H4C3.447,8,3,8.447,3,9v11 C3,21.103,3.897,22,5,22z M9,7c0-1.654,1.346-3,3-3s3,1.346,3,3v1H9V7z M5,10h2v2h2v-2h6v2h2v-2h2l0.002,10H5V10z" />
                </svg>
                DELTA
            </a>
        </div>
        <div class="order-2 md:order-3 flex items-center" id="nav-content">
            <div class="relative inline-block text-left">
                <button class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none" id="menu-button" aria-expanded="true" aria-haspopup="true">
                    <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <circle fill="none" cx="12" cy="7" r="3" />
                        <path d="M12 2C9.243 2 7 4.243 7 7s2.243 5 5 5 5-2.243 5-5S14.757 2 12 2zM12 10c-1.654 0-3-1.346-3-3s1.346-3 3-3 3 1.346 3 3S13.654 10 12 10zM21 21v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1h2v-1c0-2.757 2.243-5 5-5h4c2.757 0 5 2.243 5 5v1H21z" />
                    </svg>
                </button>
                <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden bg-white" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1" style="z-index: 50;">
                    <div class="py-1" role="none">
                        @auth()
                            <a href="{{route('profile.edit')}}" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-400" role="menuitem" tabindex="-1" id="menu-item-0">
                                Area Personal
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-400" role="menuitem" tabindex="-1" id="menu-item-1">
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{route('login')}}" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-400" role="menuitem" tabindex="-1" id="menu-item-0">
                                Login
                            </a>
                            <a href="{{route('register')}}" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-400" role="menuitem" tabindex="-1" id="menu-item-1">
                                Register
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
            <a class="pl-3 inline-block no-underline hover:text-black" href="#">
                <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M21,7H7.462L5.91,3.586C5.748,3.229,5.392,3,5,3H2v2h2.356L9.09,15.414C9.252,15.771,9.608,16,10,16h8 c0.4,0,0.762-0.238,0.919-0.606l3-7c0.133-0.309,0.101-0.663-0.084-0.944C21.649,7.169,21.336,7,21,7z M17.341,14h-6.697L8.371,9 h11.112L17.341,14z" />
                    <circle cx="10.5" cy="18.5" r="1.5" />
                    <circle cx="17.5" cy="18.5" r="1.5" />
                </svg>
            </a>
        </div>
    </div>
</nav>
