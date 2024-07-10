<header class="bg-white dark:bg-gray-800 shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
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
        <x-nav-link :href="route('status.index')" :active="request()->routeIs('status.index')">
            {{ __('Статус') }}
        </x-nav-link>
        <x-nav-link :href="route('producer.index')" :active="request()->routeIs('producer.index')">
            {{ __('Виробник') }}
        </x-nav-link>
        <x-nav-link :href="route('promotional.index')" :active="request()->routeIs('promotional.index')">
            {{ __('Акційній товари') }}
        </x-nav-link>
        <x-nav-link :href="route('product.ratingProduct')" :active="request()->routeIs('product.ratingProduct')">
            {{ __('Рейтинги товарів') }}
        </x-nav-link>
    </div>
</header>
