<header class="bg-white dark:bg-gray-800 shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <x-nav-link :href="route('product.index')" :active="request()->routeIs('product.index')">
            {{ __('Продукт') }}
        </x-nav-link>
        <x-nav-link :href="route('brand.index')" :active="request()->routeIs('brand.index')">
            {{ __('Бренд') }}
        </x-nav-link>
        <x-nav-link :href="route('fabric-composition.index')" :active="request()->routeIs('fabric-composition.index')">
            {{ __('Склад') }}
        </x-nav-link>
        <x-nav-link :href="route('fashion.index')" :active="request()->routeIs('fashion.index')">
            {{ __('Фасон') }}
        </x-nav-link>
        <x-nav-link :href="route('gender.index')" :active="request()->routeIs('gender.index')">
            {{ __('Стать') }}
        </x-nav-link>
        <x-nav-link :href="route('season.index')" :active="request()->routeIs('season.index')">
            {{ __('Сезон') }}
        </x-nav-link>
        <x-nav-link :href="route('style.index')" :active="request()->routeIs('style.index')">
            {{ __('Стиль') }}
        </x-nav-link>
        <x-nav-link :href="route('category.index')" :active="request()->routeIs('category.index')">
            {{ __('Категорія') }}
        </x-nav-link>
        <x-nav-link :href="route('color.index')" :active="request()->routeIs('color.index')">
            {{ __('Колір') }}
        </x-nav-link>
        <x-nav-link :href="route('material.index')" :active="request()->routeIs('material.index')">
            {{ __('Матеріал') }}
        </x-nav-link>
        <x-nav-link :href="route('characteristic.index')" :active="request()->routeIs('characteristic.index')">
            {{ __('Характеристики') }}
        </x-nav-link>
        <x-nav-link :href="route('size.index')" :active="request()->routeIs('size.index')">
            {{ __('Розмір') }}
        </x-nav-link>
        <x-nav-link :href="route('producer.index')" :active="request()->routeIs('producer.index')">
            {{ __('Виробник') }}
        </x-nav-link>
        <x-nav-link :href="route('promotional.index')" :active="request()->routeIs('promotional.index')">
            {{ __('Акційній товари') }}
        </x-nav-link>
{{--        <x-nav-link :href="route('product.ratingProduct')" :active="request()->routeIs('product.ratingProduct')">--}}
{{--            {{ __('Рейтинги товарів') }}--}}
{{--        </x-nav-link>--}}
        <x-nav-link :href="route('top-product.index')" :active="request()->routeIs('top-product.index')">
            {{ __('Топ товари') }}
        </x-nav-link>
    </div>
</header>
