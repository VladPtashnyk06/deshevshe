<div class="p-6 text-gray-900">
    <a href="{{ route('site.product.recentlyViewedProducts') }}"><h1 class="text-3xl font-semibold mb-6 text-center">Переглянуті продукти</h1></a>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @if(!empty($viewedProducts))
            @foreach($viewedProducts as $product)
                <div class="bg-white p-4 rounded-lg shadow-lg flex flex-col items-center">
                    @foreach($product->getMedia($product->id) as $media)
                        @if($media->getCustomProperty('main_image') === 1)
                            <a href="{{ route('site.product.showOneProduct', $product->id) }}"><img src="{{ $media->getUrl() }}" alt="{{ $media->getCustomProperty('alt') }}" class="h-40 w-auto rounded-md object-cover mb-4"></a>
                        @endif
                    @endforeach
                    <div class="text-center">
                        <a href="{{ route('site.product.showOneProduct', $product->id) }}"><p class="text-xl font-semibold mb-2">{{ $product->title }}</p></a>
                        @if($product->package)
                            <p class="text-lg mb-2">В упаковці: {{ $product->package->title }}</p>
                        @endif
                        <p class="text-lg mb-2">Колір, розмір, доступно:</p>
                        @foreach($product->productVariants()->get() as $productVariant)
                            <ul class="text-lg mb-2">
                                <li>{{ $productVariant->color->title }} - {{ $productVariant->size->title }} - {{ $productVariant->quantity }}</li>
                            </ul>
                        @endforeach

                        @if($product->price()->get())
                            @foreach($product->price()->get() as $price)
                                @include('site.product.price.index')
                            @endforeach
                        @else
                            <p class="text-lg mb-2">Ціна не вказана</p>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            Немає переглянутих товарів
        @endif
    </div>
</div>
