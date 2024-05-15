<header class="bg-white dark:bg-gray-800 shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <x-nav-link :href="route('category.index')" :active="request()->routeIs('category.index')">
            {{ __('Category') }}
        </x-nav-link>
        <x-nav-link :href="route('color.index')" :active="request()->routeIs('color.index')">
            {{ __('Color') }}
        </x-nav-link>
        <x-nav-link :href="route('package.index')" :active="request()->routeIs('package.index')">
            {{ __('Package') }}
        </x-nav-link>
        <x-nav-link :href="route('material.index')" :active="request()->routeIs('material.index')">
            {{ __('Material') }}
        </x-nav-link>
        <x-nav-link :href="route('characteristic.index')" :active="request()->routeIs('characteristic.index')">
            {{ __('Characteristic') }}
        </x-nav-link>
        <x-nav-link :href="route('size.index')" :active="request()->routeIs('size.index')">
            {{ __('Size') }}
        </x-nav-link>
        <x-nav-link :href="route('status.index')" :active="request()->routeIs('status.index')">
            {{ __('Status') }}
        </x-nav-link>
        <x-nav-link :href="route('producer.index')" :active="request()->routeIs('producer.index')">
            {{ __('Producer') }}
        </x-nav-link>
    </div>
</header>
