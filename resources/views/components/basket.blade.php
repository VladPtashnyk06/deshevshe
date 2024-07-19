@if(Cart::getTotalQuantity() >= 1)
    @foreach($cartItems as $item)
        <div class="bascket-card item-center">
            <form action="{{ route('cart.remove') }}" method="post" style="margin-right: 16px">
                @csrf
                @method('delete')

                <input type="hidden" name="id" value="{{ $item->id }}">
                <button class="delete-cart-product text-cart d-flex item-center"><span>видалити</span>
                    <svg fill="none" height="8" viewbox="0 0 8 8" width="8" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.99998 1.00002L1 7M0.999975 1L6.99995 6.99998" stroke="#121212" stroke-linecap="round" stroke-linejoin="round" stroke-opacity="0.5"></path>
                    </svg>
                </button>
            </form>
            @if(!$item->attributes->is_gift)
                <div class="img-cart">
                    <picture><img src="{{ $item->attributes->imageUrl ?: asset('/img/_no_image.png') }}" alt="Купити {{ $item->name }}" class="w-full h-full object-cover rounded h-48"></picture>
                </div>
                <div class="description-cart">
                    <p class="head-cart">{{ $item->name }}</p>
                    <p class="text-cart">Артикул: <span>{{ $item->attributes->code }}</span></p>
                    <p class="text-cart d-flex item-center">
                        <span>Колір:</span>
                        @if($item->attributes->color)
                            <span class="color-cart">{{ $item->attributes->color }}</span>
                        @else
                            <span class="color-cart">Не вибраний</span>
                        @endif
                    </p>
                    <p class="text-cart">Розмір:
                        @if($item->attributes->size)
                            <span>{{ $item->attributes->size }}</span>
                        @else
                            <span>Не вибраний</span>
                        @endif
                    </p>
                    <div class="price-cart mobile-price">
                        <p class="text-cart">Ціна:
                            @if($item->attributes->discount_price)
                                <span class="price-cart-text">{{ number_format($item->attributes->discount_price, 2) }}₴</span>
                            @else
                                <span class="price-cart-text">{{ number_format($item->price, 2) }}₴</span>
                            @endif
                        </p>
                    </div>
                </div>
            @endif
            <div class="count-cart">
                <p class="d-flex text-cart item-center"><span>Кількість:</span>
                    <input type="hidden" name="id" value="{{ $item->id }}">
                    <input type="hidden" name="quantity" value="{{ $item->quantity }}">
                    <a class="min" href="#">
                        <svg fill="none" height="3" viewbox="0 0 8 3" width="8" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 2.036V0.964001H8V2.036H0Z" fill="black"></path>
                        </svg>
                    </a>
                    <input class="number" min="1" type="number" value="1">
                    <a class="max" href="#">
                        <svg fill="none" height="7" viewbox="0 0 8 7" width="8" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.912 7.004V-0.0039978H4.256V7.004H2.912ZM0 4.14V2.876H7.168V4.14H0Z" fill="black"></path>
                        </svg>
                    </a>
                </p>
            </div>
            <div class="price-cart desctop-price">
                <p class="text-cart">Ціна:<span class="price-cart-text">{{ $item->attributes->discount_price ? number_format($item->attributes->discount_price, 2) : number_format($item->price, 2) }}₴</span>
                </p>
            </div>
            <div class="sum-cart">
                <p class="text-cart">Сума:<span class="price-cart-text">{{ $item->attributes->discount_price ? ( number_format($item->attributes->discount_price, 2) * $item->quantity): ( number_format($item->price, 2) * $item->quantity) }}₴</span>
                </p>
            </div>
        </div>
    @endforeach
@endif
