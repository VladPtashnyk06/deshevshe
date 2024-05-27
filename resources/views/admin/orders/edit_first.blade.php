<x-app-layout>
    <main itemscope itemtype="http://schema.org/ItemList">
        <section class="w-full mx-auto py-12" style="max-width: 114rem">
            <div class="bg-white shadow sm:rounded-lg p-6">

                @include('admin.orders.header')

                <form action="{{ route('operator.order.updateFirst', $order->id) }}" method="post">
                    @csrf

                    <div class="tabcontent p-4">
                        <div class="mb-4">
                            <label for="currency" class="block text-gray-700">Валюта замовлення</label>
                            <select name="currency" id="currency" class="w-full border rounded px-3 py-2">
                                <option value="UAH" @if($order->currency == 'UAH') selected @endif>UAH</option>
                                <option value="USD" @if($order->currency == 'USD') selected @endif>USD</option>
                                <option value="EUR" @if($order->currency == 'EUR') selected @endif>EUR</option>
                            </select>
                        </div>
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
                        <div class="mt-4 flex justify-between">
                            <a class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border" style="padding: 10px 41px" href="{{ route('operator.order.index') }}">
                                Назад
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border">
                                Продовжити
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
</x-app-layout>
