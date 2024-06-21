<div class="p-6 text-gray-900">
    <h1 class="text-3xl font-semibold mb-6 text-center">Cупутні товари</h1>

    <div class="flex flex-col lg:flex-row">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6 flex-1">
            @if($relatedProducts->count() > 0)
                @foreach($relatedProducts as $relatedProduct)
                    <div class="bg-white p-4 rounded-lg shadow-lg flex flex-col items-center">
                        @foreach($relatedProduct->relatedProduct->getMedia($relatedProduct->relatedProduct->id) as $media)
                            @if($media->getCustomProperty('main_image') === 1)
                                <div class="relative">
                                    @if($relatedProduct->relatedProduct->product_promotion)
                                        <span class="absolute top-0 right-0 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-bl">Акція</span>
                                    @elseif($relatedProduct->relatedProduct->top_product)
                                        <span class="absolute top-0 right-0 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-bl">Топ</span>
                                    @elseif(now()->diffInDays($relatedProduct->relatedProduct->created_at) <= 30)
                                        <span class="absolute top-0 right-0 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-bl">Новинка</span>
                                    @endif
                                    <a href="{{ route('site.product.showOneProduct', $relatedProduct->relatedProduct->id) }}">
                                        <img src="{{ $media->getUrl() }}" alt="{{ $media->getCustomProperty('alt') }}" class="h-40 w-auto rounded-md object-cover mb-4">
                                    </a>
                                </div>
                            @endif
                        @endforeach
                        <div class="text-center">
                            <a href="{{ route('site.product.showOneProduct', $relatedProduct->relatedProduct->id) }}">
                                <p class="text-xl font-semibold mb-2">{{ $relatedProduct->relatedProduct->title }}</p>
                            </a>
                            @if($relatedProduct->relatedProduct->package)
                                <p class="text-lg mb-2">В упаковці: {{ $relatedProduct->relatedProduct->package->title }}</p>
                            @endif
                            <p class="text-lg mb-2">Колір, розмір, доступно:</p>
                            @foreach($relatedProduct->relatedProduct->productVariants()->get() as $productVariant)
                                <ul class="text-lg mb-2">
                                    <li>{{ $productVariant->color->title }} - {{ $productVariant->size->title }} - {{ $productVariant->quantity }}</li>
                                </ul>
                            @endforeach

                            @if($relatedProduct->relatedProduct->price()->get())
                                @foreach($relatedProduct->relatedProduct->price()->get() as $price)
                                    @include('site.product.price.index')
                                @endforeach
                            @endif
                            <div class="mt-4">
                                @if($relatedProduct->relatedProduct->country_id)
                                    {{ $relatedProduct->relatedProduct->country->name }}
                                @endif
                            </div>
                            <div class="mt-4">
                                @if($relatedProduct->relatedProduct->status_id)
                                    {{ $relatedProduct->relatedProduct->status->title }}
                                @endif
                            </div>
                            <div class="mt-4">
                                @if($relatedProduct->relatedProduct->status_id == 1)
                                    <button onclick="openPopup({{ $relatedProduct->relatedProduct->id }})"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out mb-2 w-full border">
                                        В кошик
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <h2>Супунтих товарів до цього товару немає</h2>
            @endif
        </div>
    </div>
</div>
