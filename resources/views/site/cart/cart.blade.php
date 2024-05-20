<x-app-layout>
    <main itemscope itemtype="http://schema.org/ItemList">
        <section class="max-w-7xl mx-auto py-12">
            {{--    Actions messages--}}
            @if(!empty(session('cart')))
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                   class="bg-green-100 text-green-800 p-4 rounded mb-4 text-center">
                    {{ (session('cart') === 'cart_added') ? 'Товар додано в кошик!'
                    : ((session('cart') === 'cart_updated') ? 'Кошик оновлено!'
                    : ((session('cart') === 'cart_deleted') ? 'Товар видалено!' : '')) }}
                </p>
            @endif
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h1 class="text-3xl font-semibold mb-6 text-center" itemprop="name">Кошик</h1>
                @if(Cart::getTotalQuantity() >= 1)
                    <div class="flex flex-col md:flex-row md:justify-between">
                        <div class="md:w-2/3">
                            @foreach($cartItems as $item)
                                <div class="flex items-center mb-4 border-b pb-4">
                                    <form action="{{ route('cart.remove') }}" method="post" class="mr-4">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        <button type="submit" name="cartRemove" value="1" class="text-red-500 hover:text-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                      d="M14.1763 1.28027C14.5651 0.88794 15.1953 0.88794 15.584 1.28027C15.9727 1.6726 15.9727 2.3087 15.584 2.70103L9.90321 8.43474L15.7133 14.299C16.102 14.6913 16.102 15.3274 15.7133 15.7197C15.3246 16.1121 14.6944 16.1121 14.3057 15.7197L8.49558 9.8555L2.6855 15.7197C2.29679 16.1121 1.66657 16.1121 1.27786 15.7197C0.889151 15.3274 0.88915 14.6913 1.27786 14.299L7.08794 8.43474L1.40717 2.70103C1.01846 2.3087 1.01846 1.6726 1.40717 1.28027C1.79588 0.88794 2.4261 0.88794 2.81481 1.28027L8.49558 7.01398L14.1763 1.28027Z"
                                                      fill="#D9D9D9"/>
                                            </svg>
                                        </button>
                                    </form>
                                    <div class="flex-shrink-0 w-24 h-24">
                                        <a href="{{ route('site.product.showOneProduct', $item->attributes->product_id) }}">
                                            <img src="{{ $item->attributes->imageUrl ?: asset('/img/_no_image.png') }}"
                                                 alt="Купити {{ $item->name }}" class="w-full h-full object-cover rounded">
                                        </a>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h2 class="text-lg font-semibold">
                                            <a href="{{ route('site.product.showOneProduct', $item->attributes->product_id) }}">{{ $item->name }}</a>
                                        </h2>
                                        <p class="text-gray-500">Код: {{ $item->attributes->code }}</p>
                                        <p class="text-gray-500">Колір:
                                            @if($item->attributes->color)
                                                <span>{{ $item->attributes->color }}</span>
                                            @else
                                                <span class="text-red-500">Не вибраний</span>
                                            @endif
                                        </p>
                                        <p class="text-gray-500">Розмір:
                                            @if($item->attributes->size)
                                                <span>{{ $item->attributes->size }}</span>
                                            @else
                                                <span class="text-red-500">Не вибраний</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="ml-4 flex items-center space-x-2">
                                        <form action="{{ route('cart.update') }}" method="post" class="flex">
                                            @csrf
                                            @method('patch')
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <input type="hidden" name="quantity" value="{{ $item->quantity }}">
                                            @if($item->quantity < $item->attributes->product_quantity)
                                                <button type="submit" name="quantityDed" value="1" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">-</button>
                                                <p class="px-2">{{ $item->quantity }}</p>
                                                <button type="submit" name="quantityAdd" value="1" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">+</button>
                                            @else
                                                <button type="submit" name="quantityDed" value="1" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">-</button>
                                                <p class="px-2">{{ $item->quantity }}</p>
                                                <p>Максимальна доступна кількість</p>
                                            @endif
                                        </form>
                                    </div>
                                    <div class="ml-4 text-right">
                                        @if($item->attributes->discount_price)
                                            <p class="text-gray-500 line-through">{{ number_format($item->attributes->discount_price, 0, '.', ' ') . ' грн' }}</p>
                                            <p class="text-lg font-semibold">{{ number_format($item->price, 0, '.', ' ') . ' грн' }}</p>
                                        @else
                                            <p class="text-lg font-semibold">{{ number_format($item->price, 0, '.', ' ') . ' грн' }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="md:w-1/3 bg-gray-100 p-6 rounded-lg shadow-lg mt-6 md:mt-0">
                            <h2 class="text-xl font-semibold mb-4">Ваше замовлення:</h2>
                            <div class="flex justify-between items-center mb-2">
                                <p>Товарів в кошику:</p>
                                <p>{{ (Cart::getTotalQuantity() >= 1) ? Cart::getTotalQuantity() : '0' }}</p>
                            </div>
                            <div class="mb-2">
                                <div class="flex justify-between items-center mb-2">
                                    <p>Сума без знижки:</p>
                                    <p>{{ number_format($cartItems->totalPrice, 0, '.', ' ') . ' грн' }}</p>
                                </div>
                                <div class="flex justify-between items-center mb-2">
                                    <p>Знижка:</p>
                                    <p>{{ number_format($cartItems->totalDiscount, 0, '.', ' ') . ' грн' }}</p>
                                </div>
                            </div>
                            <hr class="mb-2">
                            <div class="flex justify-between items-center mb-4">
                                <p class="font-semibold">До сплати:</p>
                                <p class="text-xl font-semibold">{{ number_format($cartItems->totalDiscountPrice, 0, '.', ' ') . ' грн' }}</p>
                            </div>
                            <div class="flex flex-col space-y-2">
{{--                                <a class="text-center bg-blue-500 text-white py-2 rounded hover:bg-blue-700 transition duration-300" href="{{ route('order') }}">--}}
{{--                                    Підтвердити--}}
{{--                                </a>--}}
                                <a class="text-center bg-gray-300 py-2 rounded hover:bg-gray-400 transition duration-300" href="{{ route('site.product.index') }}">
                                    Продовжити покупки
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <h2 class="text-2xl text-center mt-6">Кошик порожній</h2>
                @endif
            </div>
        </section>
    </main>
</x-app-layout>
