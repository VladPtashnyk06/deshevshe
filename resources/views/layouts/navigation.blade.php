<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('site.index') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex ml-4">
                    @if(Auth::user() && Auth::user()->role == 'admin')
                        <x-nav-link :href="route('user.index')" :active="request()->routeIs('user.index')">
                            {{ __('Користувачі') }}
                        </x-nav-link>
                        <x-nav-link :href="route('product.index')" :active="request()->routeIs('product.index')">
                            {{ __('Продукт') }}
                        </x-nav-link>
                        <x-nav-link :href="route('blog.index')" :active="request()->routeIs('blog.index')">
                            {{ __('Блог') }}
                        </x-nav-link>
                        <x-nav-link :href="route('order.index')" :active="request()->routeIs('order.index')">
                            {{ __('Замовлення') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('site.catalog.index')" :active="request()->routeIs('site.catalog.index')">
                            {{ __('Продукти') }}
                        </x-nav-link>
                        @if(Auth::user() && Auth::user()->role == 'operator')
                            <x-nav-link :href="route('operator.order.index')" :active="request()->routeIs('operator.order.index')">
                                {{ __('Замовлення') }}
                            </x-nav-link>
                        @else
                            @if(Auth::user() && Auth::user()->role == 'user')
                                <x-nav-link :href="route('site.order.index')" :active="request()->routeIs('site.order.index')">
                                    {{ __('Всі мої замовлення') }}
                                </x-nav-link>
                            @endif
                        @endif
                    @endif
                </div>
            </div>

            @if(Auth::user())
                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @else
                <div class="flex items-center">
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">Увійти</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">Зареєструватися</a>
                    @endif
                </div>
            @endif

            <!-- Currency Selector and Cart -->
            @if(!Auth::user() || Auth::user()->role == 'user')
                <div class="flex items-center ml-4">
                    <form action="{{ route('change-currency') }}" method="post" id="currency-form" class="flex items-center mr-4">
                        @csrf
                        <select name="currency" id="currency-select" class="rounded-l-md border border-gray-300 focus:border-blue-500 focus:outline-none py-2 px-4 bg-white dark:bg-gray-800 text-sm w-20" style="color: white">
                            <option value="UAH" @if(session('currency') == 'UAH') selected @endif>UAH</option>
                            <option value="USD" @if(session('currency') == 'USD') selected @endif>USD</option>
                            <option value="EUR" @if(session('currency') == 'EUR') selected @endif>EUR</option>
                        </select>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-r-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-sm">Змінити</button>
                    </form>

                    <!-- Cart Icon -->
                    <div class="relative ml-4">
                        <a href="{{ route('cart') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white focus:outline-none transition duration-150 ease-in-out">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 width="30px" height="30px" viewBox="0 0 512 512" xml:space="preserve" style="fill: #FFFFFF;">
                                <path d="M420.25,64l54.844,384H36.875L91.75,64H420.25 M448,32H64L0,480h512L448,32L448,32z"/>
                                <path d="M384,128c0-17.688-14.312-32-32-32s-32,14.313-32,32c0,10.938,5.844,20.125,14.25,25.906
                                        C326.5,211.375,293.844,256,256,256c-37.813,0-70.5-44.625-78.25-102.094C186.156,148.125,192,138.938,192,128
                                        c0-17.688-14.313-32-32-32s-32,14.313-32,32c0,12.563,7.438,23.188,17.938,28.406C155.125,232.063,200.031,288,256,288
                                        s100.875-55.938,110.062-131.594C376.594,151.188,384,140.563,384,128z"/>
                        </svg>
                        </a>
                    </div>
                </div>
            @endif

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

        <!-- Responsive Settings Options -->
        @if(Auth::user())
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endif
    </div>
</nav>
