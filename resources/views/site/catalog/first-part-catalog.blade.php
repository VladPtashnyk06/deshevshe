<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8 max-w-7xl">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-semibold mb-6 text-center">Продукти</h1>
                    <ul class="bg-yellow-200 p-4 rounded-lg">
                        @foreach($categories as $category)
                            @include('site.catalog.second-part-catalog', ['category' => $category])
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
