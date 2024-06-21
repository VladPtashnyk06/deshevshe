<x-app-layout>
    <main itemscope itemtype="http://schema.org/ItemList">
        <section class="mx-auto py-12" style="max-width: 105rem">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h1 class="text-3xl font-semibold mb-6 text-center" itemprop="name">Створення замовлення</h1>
                <div class="flex flex-col md:flex-row md:justify-between">
                    <div class="md:w-2/3">
                        <h2 class="text-xl font-semibold mb-4">Вміст кошика</h2>
                        @foreach($cartItems as $item)
                            <div class="flex items-center mb-4 border-b p-6" style="padding-left: 0">
                                <div class="flex-shrink-0 w-24 h-24">
                                    <img src="{{ $item->attributes->imageUrl ?: asset('/img/_no_image.png') }}"
                                         alt="Купити {{ $item->name }}" class="w-full h-full object-cover rounded h-48">
                                </div>
                                <div class="ml-4 flex-1">
                                    <h2 class="text-lg font-semibold">{{ $item->name }}</h2>
                                    <p class="text-gray-500">Код: {{ $item->attributes->code }}</p>
                                    <p class="text-gray-500">Колір: {{ $item->attributes->color ?: 'Не вибраний' }}</p>
                                    <p class="text-gray-500">Розмір: {{ $item->attributes->size ?: 'Не вибраний' }}</p>
                                    <p class="text-lg font-semibold">{{ round($item->price, 2) . ' ' . $item->attributes->currency }}</p>
                                </div>
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
                        @endforeach
                    </div>
                    <div class="md:w-2/3 bg-gray-100 p-6 rounded-lg shadow-lg mt-6 md:mt-0">
                        <h2 class="text-xl font-semibold mb-4">Інформація про замовлення</h2>
                        <p class="flex justify-between">
                            <span>Загальна вартість:</span>
                            <span>{{ number_format($totalPrice, 2, '.', ' ') . ' ' . session('currency') }}</span>
                        </p>
                        <p class="flex justify-between">
                            <span>Знижка:</span>
                            <span>-{{ number_format($discount, 2, '.', ' ') . ' ' . session('currency') }}</span>
                        </p>
                        @if($freeShipping)
                            <p class="flex justify-between">
                                <span>Доставка:</span>
                                <span>Безкоштовно</span>
                            </p>
                        @else
                            <p class="flex justify-between">
                                <span>Доставка:</span>
                                <span>За Ваш рахунок</span>
                            </p>
                        @endif
                        <hr class="my-4">
                        <p class="flex justify-between text-lg font-semibold">
                            <span>До сплати:</span>
                            <span>{{ number_format($totalDiscountPrice, 2, '.', ' ') . ' ' . session('currency') }}</span>
                        </p>
                        @if($belowMinimumAmount)
                            <p class="text-red-500 mt-4 text-center">
                                Мінімальна сума для замовлення {{ number_format($minimumAmount, 2, '.', ' ') }} {{ session('currency') }}.
                            </p>
                        @endif
                        <form action="{{ route('site.order.store') }}" method="POST" class="mt-6">
                            @csrf

                            <div class="flex">
                                <div class="first md:w-2/3 mr-4">
                                    <input type="hidden" name="total_price" value="{{ round($totalDiscountPrice, 2) }}">
                                    <input type="hidden" name="cost_delivery" value="{{ $freeShipping ? 'Безкоштовно' : 'За Ваш рахунок' }}">
                                    <input type="hidden" name="currency" value="{{ session('currency') }}">
                                    <input type="hidden" name="user_id" value="{{ Auth::user() ? Auth::user()->id : '' }}">
                                    <div class="mb-4">
                                        <label for="user_last_name" class="block text-gray-700">Прізвище</label>
                                        <input type="text" id="user_last_name" name="user_last_name" class="mt-1 block w-full border rounded" required value="{{ Auth::user() ? Auth::user()->last_name : old('user_last_name') }}" placeholder="Введіть прізвище">
                                    </div>
                                    <div class="mb-4">
                                        <label for="user_name" class="block text-gray-700">Ім'я</label>
                                        <input type="text" id="user_name" name="user_name" class="mt-1 block w-full border rounded" required value="{{ Auth::user() ? Auth::user()->name : old('user_name') }}" placeholder="Введіть ім'я">
                                    </div>
                                    <div class="mb-4">
                                        <label for="user_middle_name" class="block text-gray-700">По батькові</label>
                                        <input type="text" id="user_middle_name" name="user_middle_name" class="mt-1 block w-full border rounded" required value="{{ Auth::user() ? Auth::user()->middle_name : old('user_middle_name') }}" placeholder="Введіть по батькові">
                                    </div>
                                    <div class="mb-4">
                                        @error('user_phone')
                                        <span class="text-red-500">{{ htmlspecialchars("Ви ввели не правильний номер, він не відповідає вимогам українського номеру") }}</span>
                                        @enderror
                                        <label for="user_phone" class="block text-gray-700">Номер телефону</label>
                                        <div class="flex">
                                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-900 text-sm">
                                        +380
                                    </span>
                                            <input type="text" id="user_phone" name="user_phone" class="mt-1 block w-full pl-2 border-l-0 rounded-r-md" required value="{{ Auth::user() ? str_replace('+380', '', Auth::user()->phone) : old('user_phone') }}" placeholder="971231212">
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="user_email" class="block text-gray-700">Електронна пошта</label>
                                        <input type="email" id="user_email" name="user_email" class="mt-1 block w-full border rounded" required value="{{ Auth::user() && Auth::user()->email ? Auth::user()->email : old('user_email') }}" placeholder="example@gmail.com">
                                    </div>
                                    @if(!Auth::user())
                                        <div class="mb-4">
                                            <label for="registration" class="block text-gray-700 font-semibold mb-2">Реєстрація (Створити особистий кабінет)</label>
                                            <input type="checkbox" name="registration" id="registration" class="mr-2">
                                        </div>
                                        <div id="password_fields" class="hidden">
                                            <div class="mb-4">
                                                <label for="password" class="block text-gray-700">Пароль</label>
                                                <input type="password" id="password" name="password" class="mt-1 block w-full border rounded">
                                            </div>
                                            <div class="mb-4">
                                                <label for="password_confirmation" class="block text-gray-700">Підтвердження пароля</label>
                                                <input type="password" id="password_confirmation" name="password_confirmation" class="mt-1 block w-full border rounded">
                                            </div>
                                        </div>
                                    @endif
                                    <div class="mb-4">
                                        <label for="comment" class="block text-gray-700">Коментар</label>
                                        <textarea name="comment" id="comment" class="w-full border rounded px-3 py-2 h-32">{{ old('comment') }}</textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label for="payment_method_id" class="block text-gray-700">Спосіб оплати</label>
                                        <select name="payment_method_id" id="payment_method_id" class="w-full border rounded px-3 py-2">
                                            <option value="">Всі способи оплати</option>
                                            @foreach($paymentMethods as $paymentMethod)
                                                <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        @if ($errors->has('promo_code'))
                                            <div class="alert alert-danger bg-red-500">
                                                {{ $errors->first('promo_code') }}
                                            </div>
                                        @endif
                                        <label for="promo_code" class="block text-gray-700">Промокод</label>
                                        <input type="text" id="promo_code" name="promo_code" class="mt-1 block w-full border rounded" placeholder="Введіть промокод">
                                    </div>
                                    @if(Auth::user())
                                        <div class="mb-4">
                                            <label for="points" class="block text-gray-700">Бали</label>
                                            <input type="number" id="points" max="{{ Auth::user()->points }}" name="points" class="mt-1 block w-full border rounded" placeholder="Максимальна кількість балів: {{ Auth::user()->points }} {{ session()->get('currency') }}">
                                        </div>
                                    @endif
                                </div>
                                <div class="second md:w-2/3">
                                    <h2 class="text-lg font-semibold">Спосіб доставки</h2>
                                    <div class="space-y-1 mb-4 text-gray-700">
                                        <div class="flex">
                                            <img src="" alt="Лого(НП)" class="mr-4">
                                            <p>Нова пошта</p>
                                        </div>
                                        <div>
                                            <label>
                                                <input type="radio" name="delivery_type" value="NovaPoshta_branch" checked> Доставка у відділення - Нова Пошта
                                            </label>
                                        </div>
                                        <div>
                                            <label>
                                                <input type="radio" name="delivery_type" value="NovaPoshta_courier"> Доставка кур'єром - Нова Пошта
                                            </label>
                                        </div>
                                        <div>
                                            <label>
                                                <input type="radio" name="delivery_type" value="NovaPoshta_postomat"> Доставка в поштомат - Нова Пошта
                                            </label>
                                        </div>
                                    </div>
                                    <div class="space-y-1 mb-4 text-gray-700">
                                        <div class="flex">
                                            <img src="" alt="Лого(Meest)" class="mr-4">
                                            <p>Meest</p>
                                        </div>
                                        <div>
                                            <label>
                                                <input type="radio" name="delivery_type" value="Meest_branch"> Доставка у відділення - Meest
                                            </label>
                                        </div>
                                        <div>
                                            <label>
                                                <input type="radio" name="delivery_type" value="Meest_courier"> Доставка кур'єром - Meest
                                            </label>
                                        </div>
                                        <div>
                                            <label>
                                                <input type="radio" name="delivery_type" value="Meest_postomat"> Доставка в поштомат - Meest
                                            </label>
                                        </div>
                                    </div>
                                    <div class="space-y-1 mb-4 text-gray-700">
                                        <div class="flex">
                                            <img src="" alt="Лого(УкрПошта)" class="mr-4">
                                            <p>УкрПошта</p>
                                        </div>
                                        <div>
                                            <label>
                                                <input type="radio" name="delivery_type" value="UkrPoshta_exspresBranch"> Доставка експрес у відділення - Укрпошта
                                            </label>
                                        </div>
                                        <div>
                                            <label>
                                                <input type="radio" name="delivery_type" value="UkrPoshta_exspresCourier"> Доставка експрес кур'єром - Укрпошта
                                            </label>
                                        </div>
                                        <div>
                                            <label>
                                                <input type="radio" name="delivery_type" value="UkrPoshta_branch"> Доставка стандартна у відділення - Укрпошта
                                            </label>
                                        </div>
                                        <div>
                                            <label>
                                                <input type="radio" name="delivery_type" value="UkrPoshta_courier"> Доставка стандартна кур'єром - Укрпошта
                                            </label>
                                        </div>
                                    </div>

                                    <input type="hidden" name="categoryOfWarehouse" id="categoryOfWarehouse" value="Branch">

                                    <div id="delivery_location_type_container" class="flex grid grid-cols-2 justify-items-center mb-4">
                                        <div>
                                            <label>
                                                <input type="radio" name="delivery_location_type" value="City" checked> Місто
                                            </label>
                                        </div>
                                        <div>
                                            <label>
                                                <input type="radio" name="delivery_location_type" value="Village"> Село
                                            </label>
                                        </div>
                                    </div>

                                    <input type="hidden" id="region" name="region" value="">
                                    <input type="hidden" id="city_name" name="city_name" value="">
                                    <input type="hidden" id="branch_number" name="branch_number" value="">
                                    <input type="hidden" id="city_ref" name="city_ref" value="">
                                    <input type="hidden" id="branch_ref" name="branch_ref" value="">
                                    <div id="nova_poshta_container" class="text-gray-700">
                                        <div class="space-y-1 mb-4" id="nova_poshta_region_div">
                                            <label for="nova_poshta_region_ref" class="block font-semibold">Регіон / Область *</label>
                                            <select name="nova_poshta_region_ref" id="nova_poshta_region_ref" class="w-full border rounded-md py-2 px-3">
                                                <option value="" selected>--- Виберіть ---</option>
                                            @foreach($novaPoshtaRegions as $region)
                                                    <option value="{{ $region['Ref'] }}">{{ $region['Description'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div id="nova_postha_city_and_branch">
                                            <div class="space-y-1 relative mb-4 inputCity" id="nova_poshta_city_div">
                                                <label for="nova_poshta_city_input" class="block font-semibold">Місто *</label>
                                                <input id="nova_poshta_city_input" name="nova_poshta_city_input" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву міста">
                                                <ul id="nova_poshta_city_list" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                                    <!-- Міста будуть відображені тут -->
                                                </ul>
                                            </div>

                                            <div class="space-y-1 relative mb-4" id="nova_poshta_branch_div">
                                                <label for="nova_poshta_branches_input" class="block font-semibold"></label>
                                                <input id="nova_poshta_branches_input" name="nova_poshta_branches_input" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву відділення">
                                                <ul id="nova_poshta_branches_list" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                                    <!-- Відділення будуть відображені тут -->
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="meest_container" class="hidden text-gray-700">
                                        <div class="space-y-1 mb-4">
                                            <label for="meest_region_ref" class="block font-semibold">Регіон / Область</label>
                                            <select name="meest_region_ref" id="meest_region_ref" class="w-full border rounded-md py-2 px-3">
                                                <option value="">--- Виберіть ---</option>
                                                    @foreach($meestRegions as $region)
                                                        <option value="{{ $region['regionID'] }}">{{ ucfirst(strtolower($region['regionDescr']['descrUA'])) }}</option>
                                                    @endforeach
                                            </select>
                                        </div>

                                        <div id="meest_city_and_branch">
                                            <div class="space-y-1 relative mb-4 inputCity" id="meest_city_div">
                                                <label for="meest_city_input" class="block font-semibold">Місто</label>
                                                <input id="meest_city_input" name="meest_city_input" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву міста">
                                                <ul id="meest_city_list" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                                    <!-- Міста будуть відображені тут -->
                                                </ul>
                                            </div>

                                            <div class="space-y-1 relative mb-4" id="meest_branch_div">
                                                <label for="meest_branches_input" class="block font-semibold"></label>
                                                <input id="meest_branches_input" name="meest_branches_input" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву відділення">
                                                <ul id="meest_branches_list" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                                    <!-- Відділення будуть відображені тут -->
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="ukr_poshta_container" class="hidden text-gray-700">
                                        <div class="space-y-1 mb-4">
                                            <label for="ukr_poshta_region_ref" class="block font-semibold">Регіон / Область</label>
                                            <select name="ukr_poshta_region_ref" id="ukr_poshta_region_ref" class="w-full border rounded-md py-2 px-3">
                                                <option value="">--- Виберіть ---</option>
                                                @foreach($ukrPoshtaRegions as $region)
                                                    <option value="{{ $region['REGION_ID'] }}">{{ ucfirst(strtolower($region['REGION_UA'])) }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div id="ukr_postha_city_and_branch">
                                            <div class="space-y-1 relative mb-4 inputCity" id="ukr_poshta_city_div">
                                                <label for="ukr_poshta_city_input" class="block font-semibold">Місто</label>
                                                <input id="ukr_poshta_city_input" name="ukr_poshta_city_input" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву міста">
                                                <ul id="ukr_poshta_city_list" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                                    <!-- Міста будуть відображені тут -->
                                                </ul>
                                            </div>

                                            <div class="space-y-1 relative mb-4" id="ukr_poshta_branch_div">
                                                <label for="ukr_poshta_branches_input" class="block font-semibold">Відділення Укр-Пошти</label>
                                                <input id="ukr_poshta_branches_input" name="ukr_poshta_branches_input" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву відділення">
                                                <ul id="ukr_poshta_branches_list" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                                    <!-- Відділення будуть відображені тут -->
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="delivery_location_village" class="hidden">
                                        <div class="space-y-1 relative mb-4" id="">
                                            <input type="hidden" name="district_ref" id="district_ref" value="">
                                            <label for="district_input" class="block font-semibold">Район *</label>
                                            <input id="district_input" name="district_input" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву района">
                                            <ul id="district_list" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                                <!-- Відділення будуть відображені тут -->
                                            </ul>
                                        </div>

                                        <div class="space-y-1 relative mb-4" id="">
                                            <input type="hidden" name="village_ref" id="village_ref" value="">
                                            <label for="village_input" class="block font-semibold">Село *</label>
                                            <input id="village_input" name="village_input" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву села">
                                            <ul id="village_list" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                                <!-- Відділення будуть відображені тут -->
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="space-y-1 mb-4 text-gray-700" id="address_container">
                                        <div>
                                            <div class="space-y-1 relative mb-4" id="">
                                                <input type="hidden" name="street_ref" id="street_ref" value="">
                                                <label for="street_input" class="block font-semibold">Вулиця *</label>
                                                <input id="street_input" name="street_input" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву вулиці">
                                                <ul id="street_list" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                                    <!-- Відділення будуть відображені тут -->
                                                </ul>
                                            </div>

                                            <div class="space-y-1 relative mb-4" id="">
                                                <label for="house" class="block font-semibold">Будинок *</label>
                                                <input id="house" name="house" class="w-full border rounded-md py-2 px-3" placeholder="Введіть номер будинку">
                                            </div>

                                            <div>
                                                <label for="flat" class="block font-semibold">Квартира</label>
                                                <input type="text" id="flat" name="flat" class="w-full border rounded-md py-2 px-3">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-300">
                                    Оформити замовлення
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-app-layout>
<input type="hidden" id="region" name="region" value="">
<input type="hidden" id="city_name" name="city_name" value="">
<input type="hidden" id="branch_number" name="branch_number" value="">
<input type="hidden" id="city_ref" name="city_ref" value="">
<input type="hidden" id="branch_ref" name="branch_ref" value="">
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const RegistrationCheckbox = document.getElementById('registration');
        const PasswordFields = document.getElementById('password_fields');
        const PhoneInput = document.getElementById('user_phone');

        if (RegistrationCheckbox) {
            RegistrationCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    PasswordFields.classList.remove('hidden');
                } else {
                    PasswordFields.classList.add('hidden');
                }
            });
        }

        PhoneInput.addEventListener('input', function (
            e) {
            if (!/^\d*$/.test(PhoneInput.value)) {
                PhoneInput.value = PhoneInput.value.replace(/[^\d]/g, '');
            }
        });

        const Region = document.getElementById('region');
        const CityName = document.getElementById('city_name');
        const BranchNumber = document.getElementById('branch_number');
        const CityRefHidden = document.getElementById('city_ref');
        const BranchRefHidden = document.getElementById('branch_ref');
        const MeestContainer = document.getElementById('meest_container');
        const MeestBranchesContainer = document.getElementById('meest_branch_div');
        const MeestRegionSelect = document.getElementById('meest_region_ref');
        const MeestCityInput = document.getElementById('meest_city_input');
        const MeestBranchesInput = document.getElementById('meest_branches_input');
        const MeestCityList = document.getElementById('meest_city_list');
        const MeestBranchesList = document.getElementById('meest_branches_list');
        const MeestCityBranchContainer = document.getElementById('meest_city_and_branch');
        const NovaPoshtaContainer = document.getElementById('nova_poshta_container');
        const NovaPoshtaRegionSelect = document.getElementById('nova_poshta_region_ref');
        const NovaPoshtaBranchDiv = document.getElementById('nova_poshta_branch_div');
        const NovaPoshtaCityDiv = document.getElementById('nova_poshta_city_div');
        const NovaPoshtaCityInput = document.getElementById('nova_poshta_city_input');
        const NovaPoshtaBranchesInput = document.getElementById('nova_poshta_branches_input');
        const NovaPoshtaCityList = document.getElementById('nova_poshta_city_list');
        const NovaPoshtaBranchesList = document.getElementById('nova_poshta_branches_list');
        const NovaPoshtaCityBranchContainer = document.getElementById('nova_postha_city_and_branch');
        const UkrPoshtaContainer = document.getElementById('ukr_poshta_container');
        const UkrPoshtaBranchDiv = document.getElementById('ukr_poshta_branch_div');
        const UkrPoshtaCityDiv = document.getElementById('ukr_poshta_city_div');
        const UkrPoshtaRegionSelect = document.getElementById('ukr_poshta_region_ref');
        const UkrPoshtaCityInput = document.getElementById('ukr_poshta_city_input');
        const UkrPoshtaBranchesInput = document.getElementById('ukr_poshta_branches_input');
        const UkrPoshtaCityList = document.getElementById('ukr_poshta_city_list');
        const UkrPoshtaBranchesList = document.getElementById('ukr_poshta_branches_list');
        const UkrPoshtaCityBranchContainer = document.getElementById('ukr_postha_city_and_branch');
        const AddressContainer = document.getElementById('address_container');
        const DeliveryTypeInputs = document.querySelectorAll('input[name="delivery_type"]');
        const DeliveryLocationTypeRadios = document.querySelectorAll('input[name="delivery_location_type"]');
        const DeliveryLocationVillage = document.getElementById('delivery_location_village');
        const DeliveryLocationTypeContainer = document.getElementById('delivery_location_type_container');
        const StreetInput = document.getElementById('street_input');
        const StreetList = document.getElementById('street_list');
        const StreetRef = document.getElementById('street_ref');
        const DistrictInput = document.getElementById('district_input');
        const DistrictList = document.getElementById('district_list');
        const DistrictRef = document.getElementById('district_ref');
        const VillageInput = document.getElementById('village_input');
        const VillageList = document.getElementById('village_list');
        const VillageRef = document.getElementById('village_ref');
        const House = document.getElementById('house');
        const Flat = document.getElementById('flat');
        let type = 'City';

        NovaPoshtaRegionSelect.addEventListener('change', function() {
            NovaPoshtaCityInput.value = '';
            CityRefHidden.value = '';
            BranchRefHidden.value = '';
            NovaPoshtaBranchesInput.value = '';
            NovaPoshtaCityList.innerHTML = '';
            NovaPoshtaBranchesList.innerHTML = '';
            StreetInput.value = '';
            StreetList.value = '';
            StreetRef.value = '';
            DistrictInput.value = '';
            DistrictList.value = '';
            DistrictRef.value = '';
            VillageInput.value = '';
            VillageList.value = '';
            VillageRef.value = '';
            CityName.value = '';
            House.value = '';
            Flat.value = '';
        });
        MeestRegionSelect.addEventListener('change', function() {
            MeestCityInput.value = '';
            MeestBranchesInput.value = '';
            MeestCityList.innerHTML = '';
            MeestBranchesList.innerHTML = '';
        });
        UkrPoshtaRegionSelect.addEventListener('change', function () {
            UkrPoshtaCityInput.value = '';
            UkrPoshtaBranchesInput.value = '';
            UkrPoshtaCityList.innerHTML = '';
            UkrPoshtaBranchesList.innerHTML = '';
            StreetInput.value = '';
            StreetList.value = '';
            StreetRef.value = '';
            DistrictInput.value = '';
            DistrictList.value = '';
            DistrictRef.value = '';
            VillageInput.value = '';
            VillageList.value = '';
            VillageRef.value = '';
            CityName.value = '';
            House.value = '';
            Flat.value = '';
        })

        document.addEventListener('click', function(event) {
            const isClickInsideDistrictList = DistrictList.contains(event.target) || event.target === DistrictInput;
            const isClickInsideVillageList = VillageList.contains(event.target) || event.target === VillageInput;
            const isClickInsideStreetList = StreetList.contains(event.target) || event.target === StreetInput;

            if (!isClickInsideDistrictList) {
                DistrictList.classList.add('hidden');
            }

            if (!isClickInsideVillageList) {
                VillageList.classList.add('hidden');
            }

            if (!isClickInsideStreetList) {
                StreetList.classList.add('hidden');
            }
        });

        function setType() {
            DeliveryLocationTypeRadios.forEach(radio => {
                if (radio.checked) {
                    if (radio.value === 'City') {
                        type = 'City';
                        CityRefHidden.value = '';
                        CityName.value = '';
                        BranchRefHidden.value = '';
                        BranchNumber.value = '';
                        NovaPoshtaBranchesInput.value = '';
                        NovaPoshtaBranchesList.innerHTML = '';
                        UkrPoshtaCityInput.value = '';
                        UkrPoshtaCityList.innerHTML = '';
                        UkrPoshtaBranchesInput.value = '';
                        UkrPoshtaBranchesList.innerHTML = '';
                        DistrictInput.value = '';
                        DistrictList.value = '';
                        DistrictRef.value = '';
                        VillageInput.value = '';
                        VillageList.value = '';
                        VillageRef.value = '';
                        StreetInput.value = '';
                        StreetList.value = '';
                        StreetRef.value = '';
                        House.value = '';
                        Flat.value = '';
                    } else if (radio.value === 'Village') {
                        type = 'Village';
                        CityRefHidden.value = '';
                        CityName.value = '';
                        NovaPoshtaCityInput.value = '';
                        NovaPoshtaCityList.innerHTML = '';
                        BranchRefHidden.value = '';
                        BranchNumber.value = '';
                        NovaPoshtaBranchesInput.value = '';
                        NovaPoshtaBranchesList.innerHTML = '';
                        UkrPoshtaCityInput.value = '';
                        UkrPoshtaCityList.innerHTML = '';
                        UkrPoshtaBranchesInput.value = '';
                        UkrPoshtaBranchesList.innerHTML = '';
                        DistrictInput.value = '';
                        DistrictList.value = '';
                        DistrictRef.value = '';
                        StreetInput.value = '';
                        StreetList.value = '';
                        StreetRef.value = '';
                        House.value = '';
                        Flat.value = '';
                    }
                }
            });
        }

        let currentInputHandler = null;
        let currentFocusHandler = null;

        updateFormVisibility();

        DeliveryTypeInputs.forEach(input => {
            input.addEventListener('change', updateFormVisibility);
        });

        setType();

        DeliveryLocationTypeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                setType();
                updateFormVisibility();
            });
        });

        function updateFormVisibility() {
            let selectedDeliveryType = document.querySelector('input[name="delivery_type"]:checked').value;
            const inputCategoryOfWarehouse = document.getElementById('categoryOfWarehouse');

            let poshtaAndDelivery = selectedDeliveryType.split("_");
            let poshta = poshtaAndDelivery[0];
            let delivery = poshtaAndDelivery[1];

            NovaPoshtaBranchesInput.value = '';
            NovaPoshtaCityInput.value = '';
            MeestBranchesInput.value = '';
            MeestCityInput.value = '';
            NovaPoshtaBranchesList.innerHTML = '';
            MeestBranchesList.innerHTML = '';
            MeestCityList.innerHTML = '';
            BranchRefHidden.value = '';

            if (currentInputHandler) {
                StreetInput.removeEventListener('input', currentInputHandler);
            }
            if (currentFocusHandler) {
                StreetInput.removeEventListener('focus', currentFocusHandler);
            }

            DeliveryLocationTypeRadios.forEach(radio => {
                if (radio.checked) {
                    if (radio.value === 'City') {
                        currentInputHandler = function() {
                            if (poshta === 'NovaPoshta') {
                                const searchText = this.value.trim().toLowerCase();
                                if (CityName.value && searchText.length >= 0) {
                                    NovaPoshtaFetchStreets(CityName.value, searchText);
                                } else {
                                    StreetList.innerHTML = '';
                                    StreetList.classList.add('hidden');
                                }
                            } else if (poshta === 'UkrPoshta') {
                                let cityId;
                                if (type === 'City') {
                                    cityId = CityRefHidden.value;
                                } else if (type === 'Village') {
                                    cityId = VillageRef.value;
                                }
                                const searchText = this.value.trim().toLowerCase();
                                if (cityId && searchText.length >= 0) {
                                    fetchStreets(cityId, searchText);
                                } else {
                                    VillageList.innerHTML = '';
                                    VillageList.classList.add('hidden');
                                }
                            }
                        };

                        currentFocusHandler = function() {
                            if (poshta === 'NovaPoshta') {
                                if (StreetInput.value.trim().length === 0) {
                                    NovaPoshtaFetchStreets(CityName.value, '');
                                } else if (StreetList.children.length > 0) {
                                    StreetList.classList.remove('hidden');
                                }
                            } else if (poshta === 'UkrPoshta') {
                                let cityId;
                                if (type === 'City') {
                                    cityId = CityRefHidden.value;
                                } else if (type === 'Village') {
                                    cityId = VillageRef.value;
                                }
                                if (VillageInput.value.trim().length === 0) {
                                    fetchStreets(cityId, '');
                                } else if (VillageList.children.length > 0) {
                                    VillageList.classList.remove('hidden');
                                }
                            }
                        };

                        StreetInput.addEventListener('input', currentInputHandler);
                        StreetInput.addEventListener('focus', currentFocusHandler);
                    }
                }
            });

            //
            //Nova Poshta
            //
            if (poshta === 'NovaPoshta') {
                NovaPoshtaCityBranchContainer.style.display = 'block';
                MeestContainer.classList.add('hidden');
                NovaPoshtaContainer.classList.remove('hidden');
                UkrPoshtaContainer.classList.add('hidden');
                NovaPoshtaBranchDiv.style.display = 'block';
                AddressContainer.style.display = 'none';
                NovaPoshtaCityDiv.style.display = 'block';
                DeliveryLocationVillage.classList.add('hidden');
                NovaPoshtaBranchesInput.placeholder = 'Введіть назву відділення';
                inputCategoryOfWarehouse.value = 'Branch';

                if (delivery === 'branch') {
                    if (type === 'City') {
                        NovaPoshtaBranchDiv.style.display = 'block';
                        NovaPoshtaCityDiv.style.display = 'block';
                        DeliveryLocationVillage.classList.add('hidden');
                    } else if (type === 'Village') {
                        NovaPoshtaCityBranchContainer.insertBefore(DeliveryLocationVillage, NovaPoshtaBranchDiv);
                        NovaPoshtaCityDiv.style.display = 'none';
                        DeliveryLocationVillage.classList.remove('hidden');
                    }
                    document.querySelector('#nova_poshta_branch_div label').textContent = 'Відділення Нової Пошти *';
                } else if (delivery === 'postomat') {
                    AddressContainer.style.display = 'none';
                    NovaPoshtaBranchDiv.style.display = 'block';
                    NovaPoshtaCityDiv.style.display = 'block';
                    document.querySelector('#nova_poshta_branch_div label').textContent = 'Поштомат Нової Пошти *';
                    NovaPoshtaBranchesInput.placeholder = 'Введіть назву поштомата';
                    inputCategoryOfWarehouse.value = 'Postomat';

                    if (type === 'City') {
                        NovaPoshtaCityDiv.style.display = 'block';
                        NovaPoshtaBranchDiv.style.display = 'block';
                        DeliveryLocationVillage.classList.add('hidden');
                    } else if (type === 'Village') {
                        NovaPoshtaCityBranchContainer.insertBefore(DeliveryLocationVillage, NovaPoshtaBranchDiv);
                        NovaPoshtaCityDiv.style.display = 'none';
                        NovaPoshtaBranchDiv.style.display = 'block';
                        DeliveryLocationVillage.classList.remove('hidden');
                    }
                } else if (delivery === 'courier') {
                    NovaPoshtaBranchDiv.style.display = 'none';
                    AddressContainer.style.display = 'block';
                    inputCategoryOfWarehouse.value = '';

                    if (type === 'City') {
                        NovaPoshtaBranchDiv.style.display = 'none';
                        NovaPoshtaCityDiv.style.display = 'block';
                        DeliveryLocationVillage.classList.add('hidden');
                    } else if (type === 'Village') {
                        NovaPoshtaBranchDiv.style.display = 'none';
                        NovaPoshtaCityDiv.style.display = 'none';
                        DeliveryLocationVillage.classList.remove('hidden');
                    }
                }

                if (NovaPoshtaRegionSelect && Region) {
                    NovaPoshtaRegionSelect.addEventListener('change', function() {
                        Region.value = this.selectedOptions[0].text;
                    });
                }

                NovaPoshtaCityInput.addEventListener('input', function() {
                    const regionRef = NovaPoshtaRegionSelect.value;
                    const searchText = this.value.trim().toLowerCase();

                    if (regionRef && searchText.length >= 0) {
                        NovaPoshtaFetchCities(regionRef, searchText);
                    } else {
                        NovaPoshtaCityList.innerHTML = '';
                        NovaPoshtaCityList.classList.add('hidden');
                    }
                });

                NovaPoshtaCityInput.addEventListener('focus', function() {
                    const regionRef = NovaPoshtaRegionSelect.value;

                    if (regionRef && NovaPoshtaCityInput.value.trim().length === 0) {
                        NovaPoshtaFetchCities(regionRef, '');
                    } else if (NovaPoshtaCityList.children.length > 0) {
                        NovaPoshtaCityList.classList.remove('hidden');
                    }
                });

                NovaPoshtaBranchesInput.addEventListener('input', function() {
                    let cityRef;
                    if (type === 'City') {
                        cityRef = CityRefHidden.value;
                    } else {
                        cityRef = VillageRef.value;
                    }
                    const searchText = this.value.trim().toLowerCase();
                    if (cityRef  && searchText.length >= 0) {
                        NovaPoshtaFetchBranches(cityRef, searchText);
                    } else {
                        NovaPoshtaBranchesList.innerHTML = '';
                        NovaPoshtaBranchesList.classList.add('hidden');
                    }
                });

                NovaPoshtaBranchesInput.addEventListener('focus', function() {
                    let cityRef;
                    if (type === 'City') {
                        cityRef = CityRefHidden.value;
                    } else {
                        cityRef = VillageRef.value;
                    }
                    if (NovaPoshtaBranchesInput.value.trim().length === 0) {
                        NovaPoshtaFetchBranches(cityRef, '');
                    } else if (NovaPoshtaBranchesList.children.length > 0) {
                        NovaPoshtaBranchesList.classList.remove('hidden');
                    }
                });

                DistrictInput.addEventListener('input', function() {
                    const regionRef = NovaPoshtaRegionSelect.value;
                    const searchText = this.value.trim().toLowerCase();

                    if (regionRef && searchText.length >= 0) {
                        NovaPoshtaFetchDiscticts(regionRef, searchText);
                    } else {
                        DistrictList.innerHTML = '';
                        DistrictList.classList.add('hidden');
                    }
                });

                DistrictInput.addEventListener('focus', function() {
                    const regionRef = NovaPoshtaRegionSelect.value;
                    if (regionRef && DistrictInput.value.trim().length === 0) {
                        NovaPoshtaFetchDiscticts(regionRef, '');
                    } else if (DistrictList.children.length > 0) {
                        DistrictList.classList.remove('hidden');
                    }
                });

                VillageInput.addEventListener('input', function() {
                    const districtRef = DistrictRef.value;
                    const searchText = this.value.trim().toLowerCase();
                    if (districtRef && searchText.length >= 0) {
                        NovaPoshtaFetchVillages(districtRef, searchText);
                    } else {
                        VillageList.innerHTML = '';
                        VillageList.classList.add('hidden');
                    }
                });

                VillageInput.addEventListener('focus', function() {
                    const districtRef = DistrictRef.value;
                    if (VillageInput.value.trim().length === 0) {
                        NovaPoshtaFetchVillages(districtRef, '');
                    } else if (VillageList.children.length > 0) {
                        VillageList.classList.remove('hidden');
                    }
                });

                document.addEventListener('click', function(event) {
                    const isClickInsideCityList = NovaPoshtaCityList.contains(event.target) || event.target === NovaPoshtaCityInput;
                    const isClickInsideBranchesList = NovaPoshtaBranchesList.contains(event.target) || event.target === NovaPoshtaBranchesInput;

                    if (!isClickInsideCityList) {
                        NovaPoshtaCityList.classList.add('hidden');
                    }

                    if (!isClickInsideCityList) {
                        NovaPoshtaCityList.classList.add('hidden');
                    }

                    if (!isClickInsideBranchesList) {
                        NovaPoshtaBranchesList.classList.add('hidden');
                    }
                });

                function NovaPoshtaFetchCities(regionRef, searchText) {
                    fetch('/get-nova-poshta-cities', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ region_ref: regionRef, findByString: searchText })
                    })
                        .then(response => response.json())
                        .then(data => {
                            NovaPoshtaCityList.innerHTML = '';
                            data.forEach(city => {
                                if (type === 'City') {
                                    if (city.Description.toLowerCase().includes(searchText) && city.SettlementTypeDescription.toLowerCase().includes('місто')) {
                                        const listItem = document.createElement('li');
                                        listItem.textContent = city.SettlementTypeDescription + ' ' + city.Description;
                                        listItem.setAttribute('data-value', city.Ref);
                                        listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                        listItem.addEventListener('click', function() {
                                            NovaPoshtaCityInput.value = city.Description;
                                            CityName.value = city.Description
                                            CityRefHidden.value = city.Ref;
                                            NovaPoshtaCityList.classList.add('hidden');
                                            MeestBranchesInput.value = '';
                                            NovaPoshtaBranchesList.innerHTML = '';
                                        });
                                        NovaPoshtaCityList.appendChild(listItem);
                                    }
                                }
                            });
                            if (NovaPoshtaCityList.children.length > 0) {
                                NovaPoshtaCityList.classList.remove('hidden');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }

                function NovaPoshtaFetchBranches(cityRef, searchText) {
                    const categoryOfWarehouse = document.getElementById('categoryOfWarehouse').value;
                    fetch('/get-nova-poshta-branches', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ city: cityRef, search: searchText })
                    })
                        .then(response => response.json())
                        .then(data => {
                            NovaPoshtaBranchesList.innerHTML = '';
                            data.forEach(branch => {
                                if (categoryOfWarehouse === 'Postomat' && branch.CategoryOfWarehouse.toLowerCase().includes('postomat')) {
                                    if (branch.Description.toLowerCase().includes(searchText)) {
                                        const listItem = document.createElement('li');
                                        listItem.textContent = branch.Description;
                                        listItem.setAttribute('data-value', branch.Ref);
                                        listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                        listItem.addEventListener('click', function() {
                                            NovaPoshtaBranchesInput.value = this.textContent;
                                            BranchRefHidden.value = branch.Ref;
                                            BranchNumber.value = branch.Number;
                                            NovaPoshtaBranchesList.classList.add('hidden');
                                        });
                                        NovaPoshtaBranchesList.appendChild(listItem);
                                    }
                                } else if(categoryOfWarehouse === 'Branch' && !branch.CategoryOfWarehouse.toLowerCase().includes('postomat')) {
                                    if (branch.Description.toLowerCase().includes(searchText)) {
                                        const listItem = document.createElement('li');
                                        listItem.textContent = branch.Description;
                                        listItem.setAttribute('data-value', branch.Ref);
                                        listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                        listItem.addEventListener('click', function () {
                                            NovaPoshtaBranchesInput.value = this.textContent;
                                            BranchRefHidden.value = branch.Ref;
                                            BranchNumber.value = branch.Number;
                                            NovaPoshtaBranchesList.classList.add('hidden');
                                        });
                                        NovaPoshtaBranchesList.appendChild(listItem);
                                    }
                                }
                            });
                            if (NovaPoshtaBranchesList.children.length > 0) {
                                NovaPoshtaBranchesList.classList.remove('hidden');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }

                function NovaPoshtaFetchStreets(CityName, searchText) {
                    fetch('/get-nova-poshta-streets', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ city_name: CityName, search: searchText })
                    })
                        .then(response => response.json())
                        .then(data => {
                            StreetList.innerHTML = '';
                            data.forEach(street => {
                                if (street.Description.toLowerCase().includes(searchText) || street.StreetsType.toLowerCase().includes(searchText) || (street.StreetsType+' '+street.Description).toLowerCase().includes(searchText)) {
                                    const listItem = document.createElement('li');
                                    listItem.textContent = street.StreetsType + ' ' + street.Description;
                                    listItem.setAttribute('data-value', street.Ref);
                                    listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                    listItem.addEventListener('click', function() {
                                        StreetInput.value = this.textContent;
                                        StreetRef.value = street.Ref;
                                        StreetList.classList.add('hidden');
                                    });
                                    StreetList.appendChild(listItem);
                                }
                            });
                            if (StreetList.children.length > 0) {
                                StreetList.classList.remove('hidden');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }

                function NovaPoshtaFetchDiscticts(regionRef, searchText) {
                    fetch('/get-nova-poshta-settlement-districts', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ region: regionRef, search: searchText })
                    })
                        .then(response => response.json())
                        .then(data => {
                            DistrictList.innerHTML = '';
                            data.forEach(district => {
                                if (district.Description.toLowerCase().includes(searchText) || district.RegionType.toLowerCase().includes(searchText) || (district.Description+' '+district.RegionType).toLowerCase().includes(searchText)) {
                                    const listItem = document.createElement('li');
                                    listItem.textContent = district.Description + ' ' + district.RegionType;
                                    listItem.setAttribute('data-value', district.Ref);
                                    listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                    listItem.addEventListener('click', function() {
                                        DistrictInput.value = this.textContent;
                                        DistrictRef.value = district.Ref;
                                        DistrictList.classList.add('hidden');
                                    });
                                    DistrictList.appendChild(listItem);
                                }
                            });
                            if (DistrictList.children.length > 0) {
                                DistrictList.classList.remove('hidden');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }

                function NovaPoshtaFetchVillages(districtRef, searchText) {
                    fetch('/get-nova-poshta-settlement-villages', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ district_ref: districtRef, search: searchText })
                    })
                        .then(response => response.json())
                        .then(data => {
                            VillageList.innerHTML = '';
                            data.forEach(village => {
                                if ((village.Description.toLowerCase().includes(searchText) || village.SettlementTypeDescription.toLowerCase().includes(searchText) || (village.SettlementTypeDescription+' '+village.Description).toLowerCase().includes(searchText)) && !village.SettlementTypeDescription.toLowerCase().includes('місто')) {
                                    const listItem = document.createElement('li');
                                    listItem.textContent = village.SettlementTypeDescription + ' ' + village.Description;
                                    listItem.setAttribute('data-value', village.Ref);
                                    listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                    listItem.addEventListener('click', function() {
                                        CityName.value = village.Description
                                        VillageInput.value = this.textContent;
                                        VillageRef.value = village.Ref;
                                        VillageList.classList.add('hidden');
                                    });
                                    VillageList.appendChild(listItem);
                                }
                            });
                            if (VillageList.children.length > 0) {
                                VillageList.classList.remove('hidden');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }
            } else if (poshta === 'Meest') {
                MeestCityBranchContainer.style.display = 'block';
                DeliveryLocationTypeContainer.classList.add('hidden');
                NovaPoshtaContainer.classList.add('hidden');
                MeestContainer.classList.remove('hidden');
                UkrPoshtaContainer.classList.add('hidden');

                if (delivery === 'branch') {
                    DeliveryLocationTypeContainer.classList.add('hidden');
                    MeestBranchesContainer.style.display = 'block';
                    AddressContainer.style.display = 'none';
                    document.querySelector('#meest_branch_div label').textContent = 'Відділення Meest';
                    MeestBranchesInput.placeholder = 'Введіть назву відділення';
                    inputCategoryOfWarehouse.value = '';
                } else if (delivery === 'postomat') {
                    DeliveryLocationTypeContainer.classList.add('hidden');
                    MeestBranchesContainer.style.display = 'block';
                    AddressContainer.style.display = 'none';
                    document.querySelector('#meest_branch_div label').textContent = 'Поштомат Meest';
                    MeestBranchesInput.placeholder = 'Введіть назву поштомата';
                    inputCategoryOfWarehouse.value = 'Postomat';
                } else if (delivery === 'courier') {
                    DeliveryLocationTypeContainer.classList.add('hidden');
                    MeestBranchesContainer.style.display = 'none';
                    AddressContainer.style.display = 'block';
                    inputCategoryOfWarehouse.value = '';
                }

                MeestCityInput.addEventListener('input', function() {
                    const regionId = MeestRegionSelect.value;
                    const searchText = this.value.trim().toLowerCase();

                    if (regionId && searchText.length >= 1) {
                        MeestFetchCities(regionId, searchText);
                    } else {
                        MeestCityList.innerHTML = '';
                        MeestCityList.classList.add('hidden');
                    }
                });

                MeestCityInput.addEventListener('focus', function() {
                    const regionId = MeestRegionSelect.value;
                    if (regionId && MeestCityInput.value.trim().length === 0) {
                        MeestFetchCities(regionId, '');
                    } else if (MeestCityList.children.length > 0) {
                        MeestCityList.classList.remove('hidden');
                    }
                });

                MeestBranchesInput.addEventListener('input', function() {
                    const cityId = document.querySelector('#meest_city_list li[data-value]')?.getAttribute('data-value');
                    const searchText = this.value.trim().toLowerCase();
                    if (cityId && searchText.length > 1) {
                        MeestFetchBranches(cityId, MeestCityInput.value, searchText);
                    } else {
                        MeestBranchesList.innerHTML = '';
                        MeestBranchesList.classList.add('hidden');
                    }
                });

                MeestBranchesInput.addEventListener('focus', function() {
                    const cityId = document.querySelector('#meest_city_list li[data-value]')?.getAttribute('data-value');
                    if (cityId && MeestBranchesInput.value.trim().length === 0) {
                        MeestFetchBranches(cityId, MeestCityInput.value, '');
                    } else if (MeestBranchesList.children.length > 0) {
                        MeestBranchesList.classList.remove('hidden');
                    }
                });

                document.addEventListener('click', function(event) {
                    const isClickInsideCityList = MeestCityList.contains(event.target) || event.target === MeestCityInput;
                    const isClickInsideBranchesList = MeestBranchesList.contains(event.target) || event.target === MeestBranchesInput;

                    if (!isClickInsideCityList) {
                        MeestCityList.classList.add('hidden');
                    }

                    if (!isClickInsideBranchesList) {
                        MeestBranchesList.classList.add('hidden');
                    }
                });

                function MeestFetchCities(regionId, searchText) {
                    fetch('/meest/cities', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ regionId: regionId, regionDescr: searchText })
                    })
                        .then(response => response.json())
                        .then(data => {
                            MeestCityList.innerHTML = '';
                            data.forEach(city => {
                                if (city.cityDescr.descrUA.toLowerCase().includes(searchText)) {
                                    const listItem = document.createElement('li');
                                    listItem.textContent = city.cityDescr.descrUA;
                                    listItem.setAttribute('data-value', city.cityID);
                                    listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                    listItem.addEventListener('click', function() {
                                        MeestCityInput.value = city.cityDescr.descrUA;
                                        CityRefHidden.value = city.cityID;
                                        MeestCityList.classList.add('hidden');
                                        MeestBranchesInput.value = '';
                                        MeestBranchesList.innerHTML = '';
                                    });
                                    MeestCityList.appendChild(listItem);
                                }
                            });
                            if (MeestCityList.children.length > 0) {
                                MeestCityList.classList.remove('hidden');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }

                function MeestFetchBranches(cityId, cityDescr, searchText) {
                    fetch('/meest/branches', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ cityDescr: cityDescr, cityId: cityId, branchDescr: searchText, addressMoreInformation: searchText, address: searchText })
                    })
                        .then(response => response.json())
                        .then(data => {
                            MeestBranchesList.innerHTML = '';
                            data.forEach(branch => {
                                const listItem = document.createElement('li');
                                if (document.getElementById('categoryOfWarehouse').value !== 'Postomat') {
                                    if (branch.branchType.toLowerCase().includes(searchText) || branch.addressMoreInformation.toLowerCase().includes(searchText) || branch.address.toLowerCase().includes(searchText)) {
                                        listItem.textContent = branch.branchType + '(' + branch.addressMoreInformation + ')' + ' ' + branch.address;
                                        listItem.setAttribute('data-value', branch.branchID);
                                        listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                        listItem.addEventListener('click', function () {
                                            MeestBranchesInput.value = branch.branchType + '(' + branch.addressMoreInformation + ')' + ' ' + branch.address;
                                            BranchRefHidden.value = branch.branchID;
                                            MeestBranchesList.classList.add('hidden');
                                        });
                                        MeestBranchesList.appendChild(listItem);
                                    }
                                } else {
                                    if (branch.networkPartner === "Поштомат") {
                                        if (branch.branchType.toLowerCase().includes(searchText) || branch.addressMoreInformation.toLowerCase().includes(searchText) || branch.address.toLowerCase().includes(searchText)) {
                                            listItem.textContent = branch.branchType + '(' + branch.addressMoreInformation + ')' + ' ' + branch.address;
                                            listItem.setAttribute('data-value', branch.branchID);
                                            listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                            listItem.addEventListener('click', function() {
                                                MeestBranchesInput.value = branch.branchType + '(' + branch.addressMoreInformation + ')' + ' ' + branch.address;
                                                BranchRefHidden.value = branch.branchID;
                                                MeestBranchesList.classList.add('hidden');
                                            });
                                            MeestBranchesList.appendChild(listItem);
                                        }
                                    }
                                }
                            });
                            if (MeestBranchesList.children.length > 0) {
                                MeestBranchesList.classList.remove('hidden');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }
            } else if (poshta === 'UkrPoshta') {
                UkrPoshtaCityBranchContainer.style.display = 'block';
                NovaPoshtaContainer.classList.add('hidden');
                MeestContainer.classList.add('hidden');
                UkrPoshtaContainer.classList.remove('hidden');
                DeliveryLocationVillage.classList.add('hidden');
                AddressContainer.style.display = 'none';
                DeliveryLocationTypeContainer.classList.remove('hidden')
                UkrPoshtaCityDiv.classList.remove('hidden');

                if (delivery === 'exspresBranch' || delivery === 'branch') {
                    if (type === 'City') {
                        DeliveryLocationVillage.classList.add('hidden');
                        UkrPoshtaCityDiv.classList.remove('hidden');
                    } else if (type === 'Village') {
                        DeliveryLocationVillage.classList.remove('hidden');
                        UkrPoshtaCityDiv.classList.add('hidden');
                        UkrPoshtaCityBranchContainer.insertBefore(DeliveryLocationVillage, UkrPoshtaBranchDiv);
                        NovaPoshtaCityDiv.style.display = 'none';
                        DeliveryLocationVillage.classList.remove('hidden');
                    }
                    UkrPoshtaBranchDiv.style.display = 'block';
                    AddressContainer.style.display = 'none';
                    document.querySelector('#ukr_poshta_branch_div label').textContent = 'Відділення УкрПошта';
                    UkrPoshtaCityInput.placeholder = 'Введіть назву відділення';
                } else if (delivery === 'exspresCourier' || delivery === 'courier') {
                    UkrPoshtaBranchDiv.style.display = 'none';
                    AddressContainer.style.display = 'block';
                    if (type === 'City') {
                        UkrPoshtaBranchDiv.style.display = 'none';
                        UkrPoshtaCityDiv.classList.remove('hidden');
                        DeliveryLocationVillage.classList.add('hidden');
                    } else if (type === 'Village') {
                        UkrPoshtaBranchDiv.style.display = 'none';
                        UkrPoshtaCityDiv.classList.add('hidden');
                        DeliveryLocationVillage.classList.remove('hidden');
                    }
                }

                UkrPoshtaCityInput.addEventListener('input', function() {
                    const regionId = UkrPoshtaRegionSelect.value;
                    const searchText = this.value.trim().toLowerCase();
                    if (regionId && searchText.length > 0) {
                        fetchCities('', regionId, searchText);
                    } else {
                        UkrPoshtaCityList.innerHTML = '';
                        UkrPoshtaCityList.classList.add('hidden');
                    }
                });

                UkrPoshtaCityInput.addEventListener('focus', function() {
                    const regionId = UkrPoshtaRegionSelect.value;
                    if (regionId && UkrPoshtaCityInput.value.trim().length === 0) {
                        fetchCities('', regionId, '');
                    } else if (UkrPoshtaCityInput.children.length >= 0) {
                        UkrPoshtaCityList.classList.remove('hidden');
                    }
                });

                UkrPoshtaBranchesInput.addEventListener('input', function() {
                    const searchText = this.value.trim().toLowerCase();
                    let cityId;
                    if (type === 'City') {
                        cityId = CityRefHidden.value;
                    } else if (type === 'Village') {
                        cityId = VillageRef.value;
                    }
                    if (cityId && searchText.length > 0) {
                        fetchBranches(cityId, searchText);
                    } else {
                        UkrPoshtaBranchesList.innerHTML = '';
                        UkrPoshtaBranchesList.classList.add('hidden');
                    }
                });

                UkrPoshtaBranchesInput.addEventListener('focus', function() {
                    let cityId;
                    if (type === 'City') {
                        cityId = CityRefHidden.value;
                    } else if (type === 'Village') {
                        cityId = VillageRef.value;
                    }
                    if (UkrPoshtaBranchesInput.value.trim().length === 0) {
                        fetchBranches(cityId, '');
                    } else if (UkrPoshtaBranchesList.children.length >= 0) {
                        UkrPoshtaBranchesList.classList.remove('hidden');
                    }
                });

                DistrictInput.addEventListener('input', function() {
                    const regionRef = UkrPoshtaRegionSelect.value;
                    const searchText = this.value.trim().toLowerCase();

                    if (regionRef && searchText.length >= 0) {
                        fetchDistricts(regionRef, searchText);
                    } else {
                        DistrictList.innerHTML = '';
                        DistrictList.classList.add('hidden');
                    }
                });

                DistrictInput.addEventListener('focus', function() {
                    const regionRef = UkrPoshtaRegionSelect.value;
                    if (regionRef && DistrictInput.value.trim().length === 0) {
                        fetchDistricts(regionRef, '');
                    } else if (DistrictList.children.length > 0) {
                        DistrictList.classList.remove('hidden');
                    }
                });

                VillageInput.addEventListener('input', function() {
                    const districtId = DistrictRef.value;
                    const searchText = this.value.trim().toLowerCase();
                    if (districtId && searchText.length >= 0) {
                        fetchCities(districtId, '', searchText);
                    } else {
                        VillageList.innerHTML = '';
                        VillageList.classList.add('hidden');
                    }
                });

                VillageInput.addEventListener('focus', function() {
                    const districtId = DistrictRef.value;
                    if (VillageInput.value.trim().length === 0) {
                        fetchCities(districtId, '', '');
                    } else if (VillageList.children.length > 0) {
                        VillageList.classList.remove('hidden');
                    }
                });

                document.addEventListener('click', function(event) {
                    const isClickInsideCityList = UkrPoshtaCityList.contains(event.target) || event.target === UkrPoshtaCityInput;
                    const isClickInsideBranchesList = UkrPoshtaBranchesList.contains(event.target) || event.target === UkrPoshtaBranchesInput;

                    if (!isClickInsideCityList) {
                        UkrPoshtaCityList.classList.add('hidden');
                    }

                    if (!isClickInsideBranchesList) {
                        UkrPoshtaBranchesList.classList.add('hidden');
                    }
                });

                if (UkrPoshtaRegionSelect && Region) {
                    UkrPoshtaRegionSelect.addEventListener('change', function() {
                        Region.value = this.selectedOptions[0].text;
                    });
                }

                function fetchCities(districtId, regionId, searchText) {
                    fetch(`/get-ukr-poshta-cities?region_id=${regionId}&district_id=${districtId}`, {
                        method: 'GET',
                        headers: {
                            'accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            UkrPoshtaCityList.innerHTML = '';
                            data.forEach(city => {
                                if (type === 'City') {
                                    if (city.CITY_UA.toLowerCase().startsWith(searchText) && city.CITYTYPE_UA.toLowerCase().includes('місто')) {
                                        const listItem = document.createElement('li');
                                        listItem.textContent = city.CITY_UA;
                                        listItem.setAttribute('data-value', city.CITY_ID);
                                        listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                        listItem.addEventListener('click', function() {
                                            UkrPoshtaCityInput.value = city.CITY_UA;
                                            CityName.value = city.CITY_UA;
                                            CityRefHidden.value = city.CITY_ID;
                                            UkrPoshtaCityList.classList.add('hidden');
                                            UkrPoshtaBranchesInput.value = '';
                                            UkrPoshtaBranchesList.innerHTML = '';
                                        });
                                        UkrPoshtaCityList.appendChild(listItem);
                                    }
                                } else {
                                    if (city.CITY_UA.toLowerCase().startsWith(searchText) && !city.CITYTYPE_UA.toLowerCase().includes('місто')) {
                                        const listItem = document.createElement('li');
                                        listItem.textContent = city.CITY_UA;
                                        listItem.setAttribute('data-value', city.CITY_ID);
                                        listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                        listItem.addEventListener('click', function() {
                                            VillageInput.value = city.CITY_UA;
                                            CityName.value = city.CITY_UA;
                                            VillageRef.value = city.CITY_ID;
                                            VillageList.classList.add('hidden');
                                            UkrPoshtaBranchesInput.value = '';
                                            UkrPoshtaBranchesList.innerHTML = '';
                                        });
                                        VillageList.appendChild(listItem);
                                    }
                                }
                            });
                            if (UkrPoshtaCityList.children.length > 0) {
                                UkrPoshtaCityList.classList.remove('hidden');
                            } else {
                                VillageList.classList.remove('hidden');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }

                function fetchBranches(cityId, searchText) {
                    fetch(`/get-ukr-poshta-branches?cityId=${cityId}`, {
                        method: 'GET',
                        headers: {
                            'accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            UkrPoshtaBranchesList.innerHTML = '';
                            data.forEach(branch => {
                                const listItem = document.createElement('li');
                                if (branch.POSTOFFICE_UA.toLowerCase().includes(searchText.toLowerCase()) || branch.STREET_UA_VPZ.toLowerCase().includes(searchText.toLowerCase())) {
                                    listItem.textContent = branch.POSTOFFICE_UA + (branch.STREET_UA_VPZ ? ' ' + branch.STREET_UA_VPZ : '');
                                    listItem.setAttribute('data-value', branch.POSTOFFICE_UA);
                                    listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                    listItem.addEventListener('click', function() {
                                        UkrPoshtaBranchesInput.value = branch.POSTOFFICE_UA + (branch.STREET_UA_VPZ ? ' ' + branch.STREET_UA_VPZ : '');
                                        BranchRefHidden.value = branch.POSTOFFICE_ID;
                                        UkrPoshtaBranchesList.classList.add('hidden');
                                    });
                                    UkrPoshtaBranchesList.appendChild(listItem);
                                }
                            });
                            if (UkrPoshtaBranchesList.children.length > 0) {
                                UkrPoshtaBranchesList.classList.remove('hidden');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }

                function fetchDistricts(regionId, searchText) {
                    fetch(`/get-ukr-poshta-districts?regionId=${regionId}`, {
                        method: 'GET',
                        headers: {
                            'accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            DistrictList.innerHTML = '';
                            data.forEach(district => {
                                const listItem = document.createElement('li');
                                if (district.DISTRICT_UA.toLowerCase().includes(searchText.toLowerCase())) {
                                    listItem.textContent = district.DISTRICT_UA;
                                    listItem.setAttribute('data-value', district.DISTRICT_ID);
                                    listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                    listItem.addEventListener('click', function() {
                                        DistrictInput.value = this.textContent;
                                        DistrictRef.value = district.DISTRICT_ID;
                                        DistrictList.classList.add('hidden');
                                        VillageInput.value = '';
                                        VillageList.innerHTML = '';
                                    });
                                    DistrictList.appendChild(listItem);
                                }
                            });
                            if (DistrictList.children.length > 0) {
                                DistrictList.classList.remove('hidden');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }

                function fetchStreets(cityId, searchText) {
                    fetch(`/get-ukr-poshta-streets?cityId=${cityId}`, {
                        method: 'GET',
                        headers: {
                            'accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            StreetList.innerHTML = '';
                            data.forEach(street => {
                                const listItem = document.createElement('li');
                                if (street.STREET_UA.toLowerCase().includes(searchText.toLowerCase())) {
                                    listItem.textContent = street.SHORTSTREETTYPE_UA + ' ' + street.STREET_UA;
                                    listItem.setAttribute('data-value', street.DISTRICT_ID);
                                    listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                    listItem.addEventListener('click', function() {
                                        StreetInput.value = this.textContent;
                                        StreetRef.value = street.STREET_ID;
                                        StreetList.classList.add('hidden');
                                        House.value = '';
                                        Flat.value = '';
                                    });
                                    StreetList.appendChild(listItem);
                                }
                            });
                            if (StreetList.children.length > 0) {
                                StreetList.classList.remove('hidden');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }
            }
        }
    });
</script>
