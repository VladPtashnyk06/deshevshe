<x-app-layout>
    <main itemscope itemtype="http://schema.org/ItemList">
        <section class="max-w-7xl mx-auto py-12">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h1 class="text-3xl font-semibold mb-6 text-left" itemprop="name">Редагувати замовлення №{{ $order->id }}</h1>
                <div class="flex flex-col md:flex-row md:justify-between">
                    <form action="{{ route('operator.order.smallUpdate', $order->id) }}" method="post" class="w-full">
                        @csrf

                        <div class="mb-4">
                            <label for="user_name" class="block mb-2 font-bold w-full">Ім'я</label>
                            <input type="text" name="user_name" id="user_name" class="w-full border rounded px-3 py-2" value="{{ $order->user_name }}">
                        </div>

                        <div class="mb-4">
                            <label for="user_last_name" class="block mb-2 font-bold">Прізвище</label>
                            <input type="text" name="user_last_name" id="user_last_name" class="w-full border rounded px-3 py-2" value="{{ $order->user_last_name }}">
                        </div>

                        <div class="mb-4">
                            <label for="user_phone" class="block mb-2 font-bold">Телефон</label>
                            <div class="flex">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-100 text-gray-900 text-sm">
                                    +380
                                </span>
                                <input type="text" name="user_phone" id="user_phone" class="w-full border rounded px-3 py-2" value="{{ str_replace('+380', '', $order->user_phone) }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="user_email" class="block mb-2 font-bold">E-mail</label>
                            <input type="text" name="user_email" id="user_email" class="w-full border rounded px-3 py-2" value="{{ $order->user_email ? $order->user_email : 'Немає' }}">
                        </div>

                        <div class="mb-4">
                            <label for="payment_method_id" class="block text-gray-700">Спосіб оплати</label>
                            <select name="payment_method_id" id="payment_method_id" class="w-full border rounded px-3 py-2">
                                <option value="">Всі методи оплати</option>
                                @foreach($paymentMethods as $paymentMethod)
                                    <option value="{{ $paymentMethod->id }}" {{ $order->payment_method_id == $paymentMethod->id ? 'selected' : ''}}>{{ $paymentMethod->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if(!empty($order->user->userAddresses()->get()))
                            @foreach($order->user->userAddresses()->get() as $userAddress)
                                <div class="mb-4">
                                    <label for="region" class="block mb-2 font-bold">Область</label>
                                    <input type="text" name="region" id="region" class="w-full border rounded px-3 py-2" value="{{ $userAddress->region->title ? $userAddress->region->title : 'Немає' }}">
                                </div>

                                <div class="mb-4">
                                    <label for="city" class="block mb-2 font-bold">Місто</label>
                                    <input type="text" name="city" id="city" class="w-full border rounded px-3 py-2" value="{{ $userAddress->city ? $userAddress->city : 'Немає' }}">
                                </div>

                                <div class="mb-4">
                                    <label for="address" class="block mb-2 font-bold">Адреса</label>
                                    <input type="text" name="address" id="address" class="w-full border rounded px-3 py-2" value="{{ $userAddress->address ? $userAddress->address : 'Немає' }}">
                                </div>
                            @endforeach
                        @endif
                        <div class="mt-4">
                            <a class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border" href="{{ route('operator.order.index') }}">
                                Назад
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border">Оновити дані замовлення</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
</x-app-layout>
