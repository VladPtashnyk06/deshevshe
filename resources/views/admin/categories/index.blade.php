<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8" style="max-width: 95rem">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg bg-white">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-semibold mb-2 text-center">Категорії</h1>
                    <div class="text-center mb-4">
                        <a href="{{ route('category.create') }}" class="bg-green-600 hover:bg-green-700 block text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Створити категорію</a>
                    </div>
                    <form action="{{ route('category.index') }}" method="GET" style="display: flex; align-items: center; justify-content: center;">
                        <div class="mb-4" style="flex: 1;">
                            <label for="id" class="block mb-2 font-bold">ID категорії:</label>
                            <input type="number" name="id" id="id" value="{{ request()->input('id') }}">
                        </div>
                        <div class="mb-4" style="flex: 1;">
                            <label for="title" class="block mb-2 font-bold">Назва категорії:</label>
                            <input type="text" name="title" id="title" value="{{ request()->input('title') }}">
                        </div>
                        <div class="mb-4" style="flex: 1;">
                            <label for="level" class="block mb-2 font-bold">Рівень категорії:</label>
                            <input type="number" name="level" id="level" value="{{ request()->input('level') }}">
                        </div>
                        <div class="ml-2 mb-4">
                            <div class="mt-4">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border">Застосувати фільтри</button>
                                <button type="button" onclick="window.location='{{ route('category.index') }}'" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border ml-2">Очистити фільтри</button>
                            </div>
                        </div>
                    </form>
                    <table class="w-full mb-5">
                        <thead>
                        <tr class="text-center border-b-2 border-gray-700">
                            <th class="p-2 text-lg">ID</th>
                            <th class="p-2 text-lg">Категорія</th>
                            <th class="p-2 text-lg">Порядок сортування</th>
                            <th class="p-2 text-lg">Дії</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($filter)
                            @foreach($filterCategories as $filterCategory)
                                <tr class="text-center odd:bg-gray-200">
                                    <td class="px-6 py-4 font-bold" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
                                        {{ $filterCategory->id }}
                                    </td>
                                    <td class="px-6 py-4 font-bold" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
                                        {{ $filterCategory->title }}
                                    </td>
                                    <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
                                        {{ $filterCategory->level }}
                                    </td>
                                    <td class="px-6 py-4 text-right" style="vertical-align: middle; display: flex; gap: 10px;">
                                        <a href="{{ route('category.edit', $filterCategory->id) }}" title="Редагувати категорію">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="25px" viewBox="0 0 128 128">
                                                <g>
                                                    <path d="M36.108,110.473l70.436-70.436L87.963,21.457L17.526,91.893c-0.378,0.302-0.671,0.716-0.803,1.22   l-5.476,20.803c-0.01,0.04-0.01,0.082-0.019,0.121c-0.018,0.082-0.029,0.162-0.039,0.247c-0.007,0.075-0.009,0.147-0.009,0.222   c-0.001,0.077,0.001,0.147,0.009,0.225c0.01,0.084,0.021,0.166,0.039,0.246c0.008,0.04,0.008,0.082,0.019,0.121   c0.007,0.029,0.021,0.055,0.031,0.083c0.023,0.078,0.053,0.154,0.086,0.23c0.029,0.067,0.057,0.134,0.09,0.196   c0.037,0.066,0.077,0.127,0.121,0.189c0.041,0.063,0.083,0.126,0.13,0.184c0.047,0.059,0.1,0.109,0.152,0.162   c0.053,0.054,0.105,0.105,0.163,0.152c0.056,0.048,0.119,0.09,0.182,0.131c0.063,0.043,0.124,0.084,0.192,0.12   c0.062,0.033,0.128,0.062,0.195,0.09c0.076,0.033,0.151,0.063,0.23,0.087c0.028,0.009,0.054,0.023,0.083,0.031   c0.04,0.01,0.081,0.01,0.121,0.02c0.081,0.017,0.162,0.028,0.246,0.037c0.077,0.009,0.148,0.011,0.224,0.01   c0.075,0,0.147-0.001,0.223-0.008c0.084-0.011,0.166-0.022,0.247-0.039c0.04-0.01,0.082-0.01,0.121-0.02l20.804-5.475   C35.393,111.146,35.808,110.853,36.108,110.473z M19.651,108.349c-0.535-0.535-1.267-0.746-1.964-0.649l3.183-12.094l11.526,11.525   L20.3,110.313C20.398,109.616,20.188,108.884,19.651,108.349z" style="fill: orangered;"/>
                                                    <path d="M109.702,36.879l-18.58-18.581l7.117-7.117c0,0,12.656,4.514,18.58,18.582L109.702,36.879z" style="fill: orangered;"/>
                                                </g>
                                            </svg>
                                        </a>
                                        <a href="{{ route('category.createSubCategory', $filterCategory->id) }}" title="Додати під-категорію">
                                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                 width="25px" viewBox="0 0 401.994 401.994" style="enable-background:new 0 0 401.994 401.994; fill: green"
                                                 xml:space="preserve">
                                            <g>
                                                <path d="M394,154.175c-5.331-5.33-11.806-7.994-19.417-7.994H255.811V27.406c0-7.611-2.666-14.084-7.994-19.414
                                                    C242.488,2.666,236.02,0,228.398,0h-54.812c-7.612,0-14.084,2.663-19.414,7.993c-5.33,5.33-7.994,11.803-7.994,19.414v118.775
                                                    H27.407c-7.611,0-14.084,2.664-19.414,7.994S0,165.973,0,173.589v54.819c0,7.618,2.662,14.086,7.992,19.411
                                                    c5.33,5.332,11.803,7.994,19.414,7.994h118.771V374.59c0,7.611,2.664,14.089,7.994,19.417c5.33,5.325,11.802,7.987,19.414,7.987
                                                    h54.816c7.617,0,14.086-2.662,19.417-7.987c5.332-5.331,7.994-11.806,7.994-19.417V255.813h118.77
                                                    c7.618,0,14.089-2.662,19.417-7.994c5.329-5.325,7.994-11.793,7.994-19.411v-54.819C401.991,165.973,399.332,159.502,394,154.175z"
                                                />
                                            </g>
                                        </svg>
                                        </a>
                                        <form action="{{ route('category.destroy', $filterCategory->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Видалити категорію">
                                                <svg width="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 96 96" xmlns:xlink="http://www.w3.org/1999/xlink" style="fill: red">
                                                    <path d="m24,78c0,4.968 4.029,9 9,9h30c4.968,0 9-4.032 9-9l6-48h-60l6,48zm33-39h6v39h-6v-39zm-12,0h6v39h-6v-39zm-12,0h6v39h-6v-39zm43.5-21h-19.5c0,0-1.344-6-3-6h-12c-1.659,0-3,6-3,6h-19.5c-2.487,0-4.5,2.013-4.5,4.5s0,4.5 0,4.5h66c0,0 0-2.013 0-4.5s-2.016-4.5-4.5-4.5z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            @foreach($categories as $category)
                                @include('admin.categories.category-row', ['category' => $category, 'prefix' => ''])
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
