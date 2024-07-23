<header class="bg-white dark:bg-gray-800 shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <x-nav-link :href="route('promoCode.index')" :active="request()->routeIs('promoCode.index')">
            {{ __('Промокоди') }}
        </x-nav-link>
        <x-nav-link :href="route('certificate.index')" :active="request()->routeIs('certificate.index')">
            {{ __('Сертифікати') }}
        </x-nav-link>
    </div>
</header>
