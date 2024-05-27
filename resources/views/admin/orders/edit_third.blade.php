<x-app-layout>
    <main itemscope itemtype="http://schema.org/ItemList">
        <section class="w-full mx-auto py-12" style="max-width: 114rem">
            <div class="bg-white shadow sm:rounded-lg p-6">

                @include('admin.orders.header')

                <form action="" method="post">
                    @csrf

{{--                    <div class="mb-4">--}}
{{--                        <label for="currency" class="block text-gray-700">Вибрати адресу</label>--}}
{{--                        <select name="currency" id="currency" class="w-full border rounded px-3 py-2">--}}
{{--                            <option value="UAH" @if($order->currency == 'UAH') selected @endif>UAH</option>--}}
{{--                            <option value="USD" @if($order->currency == 'USD') selected @endif>USD</option>--}}
{{--                            <option value="EUR" @if($order->currency == 'EUR') selected @endif>EUR</option>--}}
{{--                        </select>--}}
{{--                    </div>--}}
                    <div class="mb-4">
                        <label for="user_name" class="block mb-2 font-bold w-full">Ім'я</label>
                        <input type="text" name="user_name" id="user_name" class="w-full border rounded px-3 py-2" value="{{ $order->user_name }}">
                    </div>

                    <div class="mb-4">
                        <label for="user_last_name" class="block mb-2 font-bold">Прізвище</label>
                        <input type="text" name="user_last_name" id="user_last_name" class="w-full border rounded px-3 py-2" value="{{ $order->user_last_name }}">
                    </div>

                    <div class="mb-4">
                        <label for="address" class="block mb-2 font-bold">Адреса</label>
                        <input type="text" name="address" id="address" class="w-full border rounded px-3 py-2" value="">
                    </div>

                    <div class="mb-4">
                        <label for="city" class="block mb-2 font-bold">Місто</label>
                        <input type="text" name="city" id="city" class="w-full border rounded px-3 py-2" value="">
                    </div>

                    <div class="mb-4">
                        <label for="country_id" class="block mb-2 font-bold">Країна</label>
{{--                        <select name="country_id" id="country_id" class="w-full border rounded px-3 py-2">--}}
{{--                            @foreach()--}}

{{--                            @endforeach--}}
{{--                        </select>--}}
                    </div>

                    <div class="mb-4">
                        <label for="region_id" class="block mb-2 font-bold">Облать</label>
{{--                        <select name="region_id" id="region_id" class="w-full border rounded px-3 py-2">--}}
{{--                            @foreach()--}}
{{--                                --}}
{{--                            @endforeach--}}
{{--                        </select>--}}
                    </div>

                    <div class="mt-4 flex justify-between">
                        <a class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border" style="padding: 10px 41px" href="{{ route('operator.order.editSecond', $order->id) }}">
                            Назад
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border">
                            Продовжити
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </main>
</x-app-layout>


