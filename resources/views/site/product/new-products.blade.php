<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="mx-auto sm:px-6 lg:px-8 max-w-7xl">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-semibold mb-6 text-center"><a href="{{ route('site.product.recProducts') }}">Нові продукти (надходження)</a></h1>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if(!empty($newProducts))
                            @foreach($newProducts as $newProduct)
                                <div class="bg-white p-4 rounded-lg shadow-lg flex flex-col items-center">
                                    @foreach($newProduct->getMedia($newProduct->id) as $media)
                                        @if($media->getCustomProperty('main_image') === 1)
                                            <a href="{{ route('site.product.showOneProduct', $newProduct->id) }}"><img src="{{ $media->getUrl() }}" alt="{{ $media->getCustomProperty('alt') }}" class="h-40 w-auto rounded-md object-cover mb-4"></a>
                                        @endif
                                    @endforeach
                                    <div class="text-center">
                                        <a href="{{ route('site.product.showOneProduct', $newProduct->id) }}">
                                            <p class="text-xl font-semibold mb-2">{{ $newProduct->title }}</p>
                                        </a>
                                        @if($newProduct->package)
                                            <p class="text-lg mb-2">В упаковці: {{ $newProduct->package->title }}</p>
                                        @endif
                                        <p class="text-lg mb-2">Колір, розмір, доступно:</p>
                                        @foreach($newProduct->productVariants()->get() as $productVariant)
                                            <ul class="text-lg mb-2">
                                                <li>{{ $productVariant->color->title }} - {{ $productVariant->size->title }} - {{ $productVariant->quantity }}</li>
                                            </ul>
                                        @endforeach

                                        @if($newProduct->price()->get())
                                            @foreach($newProduct->price()->get() as $price)
                                                @include('site.product.price.index')
                                            @endforeach
                                        @else
                                            <p class="text-lg mb-2">Ціна не вказана</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            Немає нових товарів (надходжень)
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
