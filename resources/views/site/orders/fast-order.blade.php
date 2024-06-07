<x-app-layout>
    <main itemscope itemtype="http://schema.org/ItemList">
        <section class="mx-auto py-12" style="max-width: 105rem">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h1 class="text-3xl font-semibold mb-6 text-center" itemprop="name">Створення замовлення</h1>
                <div class="flex flex-col md:flex-row md:justify-between">
                    <div class="md:w-2/3">
                        <h2 class="text-xl font-semibold mb-4">Товар</h2>
                        <div class="flex items-center mb-4 border-b p-6" style="padding-left: 0">
                            <div class="flex-shrink-0 w-24 h-24">
                                @foreach($product->getMedia($product->id) as $media)
                                    @if($media->getCustomProperty('main_image') === 1)
                                            <a href="{{ route('site.product.showOneProduct', $product->id) }}">
                                                <img src="{{ $media->getUrl() }}" alt="Купити {{ $media->getCustomProperty('alt') }}" class="w-full h-full object-cover rounded h-48">
                                            </a>
                                    @endif
                                @endforeach
                            </div>
                            <div class="ml-4 flex-1">
                                <h2 class="text-lg font-semibold">{{ $product->title }}</h2>
                                <p class="text-gray-500">Код: {{ $product->code }}</p>
                                <p class="text-gray-500">Колір: {{ $thisProductVariant->color->title ?: 'Не вибраний' }}</p>
                                <p class="text-gray-500">Розмір: {{ $thisProductVariant->size->title ?: 'Не вибраний' }}</p>
                                <p class="text-lg font-semibold">{{ round($product->price->pair, 2) . ' ' . session()->get('currency') }}</p>
                            </div>
                            <div class="ml-4">
                                <p>Кількість: {{ $thisProductVariant->quantity }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="md:w-2/3 bg-gray-100 p-6 rounded-lg shadow-lg mt-6 md:mt-0">
                        <h2 class="text-xl font-semibold mb-4">Інформація про замовлення</h2>
                        <p class="flex justify-between">
                            <span>Загальна вартість:</span>
                            <span>{{ number_format($product->price->pair * $thisProductVariant->quantity, 2, '.', ' ') . ' ' . session('currency') }}</span>
                        </p>
                        <hr class="my-4">
                        <p class="flex justify-between text-lg font-semibold">
                            <span>До сплати:</span>
                            <span>{{ number_format($product->price->pair * $thisProductVariant->quantity, 2, '.', ' ') . ' ' . session('currency') }}</span>
                        </p>
                        @if($product->price->pair * $thisProductVariant->quantity > 500)
                            <p class="text-red-500 mt-4 text-center">
                                Мінімальна сума для замовлення 500 {{ session('currency') }}.
                            </p>
                        @endif
                        <form action="{{ route('site.order.store') }}" method="POST" class="mt-6">
                            @csrf

                            <div class="flex">
                                <div class="first md:w-2/3 mr-4">
                                    <input type="hidden" name="total_price" value="{{ round($product->price->pair * $thisProductVariant->quantity, 2) }}">
{{--                                    <input type="hidden" name="cost_delivery" value="{{ $freeShipping ? 'Безкоштовно' : 'За Ваш рахунок' }}">--}}
                                    <input type="hidden" name="currency" value="{{ session('currency') }}">
                                    <input type="hidden" name="user_id" value="{{ Auth::user() ? Auth::user()->id : '' }}">
                                    <div class="mb-4">
                                        <label for="user_name" class="block text-gray-700">Ім'я</label>
                                        <input type="text" id="user_name" name="user_name" class="mt-1 block w-full border rounded" required value="{{ Auth::user() ? Auth::user()->name : old('user_name') }}" placeholder="Введіть ім'я">
                                    </div>
                                    <div class="mb-4">
                                        <label for="user_last_name" class="block text-gray-700">Прізвище</label>
                                        <input type="text" id="user_last_name" name="user_last_name" class="mt-1 block w-full border rounded" required value="{{ Auth::user() ? Auth::user()->last_name : old('user_last_name') }}" placeholder="Введіть прізвище">
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
                                        <div id="passwordFields" class="hidden">
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

                                    <div id="NovaPoshtaContainer" class="text-gray-700">
                                        <div class="space-y-1 mb-4">
                                            <label for="NovaPoshtaRegion" class="block font-semibold">Регіон / Область</label>
                                            <select name="NovaPoshtaRegion" id="NovaPoshtaRegion" class="w-full border rounded-md py-2 px-3">
                                                <option value="" selected>--- Виберіть ---</option>
                                                @foreach($novaPoshtaRegions as $region)
                                                    <option value="{{ $region['Ref'] }}">{{ $region['Description'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="space-y-1 relative mb-4" id="cityContainer">
                                            <input type="hidden" id="cityRefHidden" name="cityRefHidden" value="">
                                            <label for="NovaPoshtaCityInput" class="block font-semibold">Місто</label>
                                            <input id="NovaPoshtaCityInput" name="NovaPoshtaCityInput" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву міста">
                                            <ul id="NovaPoshtaCityList" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                                <!-- Міста будуть відображені тут -->
                                            </ul>
                                        </div>

                                        <div class="space-y-1 relative mb-4" id="NovaPoshtaBranchesContainer">
                                            <input type="hidden" id="branchRefHidden" name="branchRefHidden" value="">
                                            <label for="NovaPoshtaBranchesInput" class="block font-semibold"></label>
                                            <input id="NovaPoshtaBranchesInput" name="NovaPoshtaBranchesInput" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву відділення">
                                            <ul id="NovaPoshtaBranchesList" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                                <!-- Відділення будуть відображені тут -->
                                            </ul>
                                        </div>
                                    </div>

                                    <div id="MeestContainer" class="hidden text-gray-700">
                                        <div class="space-y-1 mb-4">
                                            <label for="MeestRegion" class="block font-semibold">Регіон / Область</label>
                                            <select name="MeestRegion" id="MeestRegion" class="w-full border rounded-md py-2 px-3">
                                                <option value="">--- Виберіть ---</option>
                                                @foreach($meestRegions as $region)
                                                    <option value="{{ $region['regionID'] }}">{{ ucfirst(strtolower($region['regionDescr']['descrUA'])) }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="space-y-1 relative mb-4" id="cityContainer">
                                            <input type="hidden" id="meestCityIdHidden" name="meestCityIdHidden" value="">
                                            <label for="MeestCityInput" class="block font-semibold">Місто</label>
                                            <input id="MeestCityInput" name="MeestCityInput" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву міста">
                                            <ul id="MeestCityList" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                                <!-- Міста будуть відображені тут -->
                                            </ul>
                                        </div>

                                        <div class="space-y-1 relative mb-4" id="MeestBranchesContainer">
                                            <input type="hidden" name="meestBranchIDHidden" id="meestBranchIDHidden" value="">
                                            <label for="MeestBranchesInput" class="block font-semibold"></label>
                                            <input id="MeestBranchesInput" name="MeestBranchesInput" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву відділення">
                                            <ul id="MeestBranchesList" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                                <!-- Відділення будуть відображені тут -->
                                            </ul>
                                        </div>
                                    </div>

                                    <div id="UkrPoshtaContainer" class="hidden text-gray-700">
                                        <div class="space-y-1 mb-4">
                                            <label for="UkrPoshtaRegion" class="block font-semibold">Регіон / Область</label>
                                            <select name="UkrPoshtaRegion" id="UkrPoshtaRegion" class="w-full border rounded-md py-2 px-3">
                                                <option value="">--- Виберіть ---</option>
                                                @foreach($ukrPoshtaRegions as $region)
                                                    <option value="{{ $region['REGION_ID'] }}">{{ ucfirst(strtolower($region['REGION_UA'])) }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="space-y-1 relative mb-4" id="UkrPoshtaCityContainer">
                                            <input type="hidden" id="ukrPoshtaCityIdHidden" name="ukrPoshtaCityIdHidden" value="">
                                            <label for="UkrPoshtaCityInput" class="block font-semibold">Місто</label>
                                            <input id="UkrPoshtaCityInput" name="UkrPoshtaCityInput" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву міста">
                                            <ul id="UkrPoshtaCityList" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                                <!-- Міста будуть відображені тут -->
                                            </ul>
                                        </div>

                                        <div class="space-y-1 relative mb-4" id="UkrPoshtaBranchesContainer">
                                            <input type="hidden" name="ukrPoshtaBranchIDHidden" id="ukrPoshtaBranchIDHidden" value="">
                                            <label for="UkrPoshtaBranchesInput" class="block font-semibold">Відділення Укр-Пошти</label>
                                            <input id="UkrPoshtaBranchesInput" name="UkrPoshtaBranchesInput" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву відділення">
                                            <ul id="UkrPoshtaBranchesList" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                                <!-- Відділення будуть відображені тут -->
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="space-y-1 mb-4 text-gray-700" id="addressContainer">
                                        <label for="address" class="block font-semibold">Адреса</label>
                                        <input type="text" name="address" id="address" class="w-full border rounded-md py-2 px-3">
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const registrationCheckbox = document.getElementById('registration');
        const passwordFields = document.getElementById('passwordFields');

        registrationCheckbox.addEventListener('change', function() {
            if (this.checked) {
                passwordFields.classList.remove('hidden');
            } else {
                passwordFields.classList.add('hidden');
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const phoneInput = document.getElementById('user_phone');

        phoneInput.addEventListener('input', function (
            e) {
            if (!/^\d*$/.test(phoneInput.value)) {
                phoneInput.value = phoneInput.value.replace(/[^\d]/g, '');
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const MeestBranchesContainer = document.getElementById('MeestBranchesContainer');
        const MeestRegionSelect = document.getElementById('MeestRegion');
        const MeestCityInput = document.getElementById('MeestCityInput');
        const MeestBranchesInput = document.getElementById('MeestBranchesInput');
        const MeestCityList = document.getElementById('MeestCityList');
        const MeestBranchesList = document.getElementById('MeestBranchesList');
        const NovaPoshtaBranchesContainer = document.getElementById('NovaPoshtaBranchesContainer');
        const NovaPoshtaRegionSelect = document.getElementById('NovaPoshtaRegion');
        const NovaPoshtaCityInput = document.getElementById('NovaPoshtaCityInput');
        const NovaPoshtaBranchesInput = document.getElementById('NovaPoshtaBranchesInput');
        const NovaPoshtaCityList = document.getElementById('NovaPoshtaCityList');
        const NovaPoshtaBranchesList = document.getElementById('NovaPoshtaBranchesList');
        const UkrPoshtaBranchesContainer = document.getElementById('UkrPoshtaBranchesContainer');
        const UkrPoshtaRegionSelect = document.getElementById('UkrPoshtaRegion');
        const UkrPoshtaCityInput = document.getElementById('UkrPoshtaCityInput');
        const UkrPoshtaBranchesInput = document.getElementById('UkrPoshtaBranchesInput');
        const UkrPoshtaCityList = document.getElementById('UkrPoshtaCityList');
        const UkrPoshtaBranchesList = document.getElementById('UkrPoshtaBranchesList');
        const addressContainer = document.getElementById('addressContainer');
        const cityRefHidden = document.getElementById('cityRefHidden');
        const branchRefHidden = document.getElementById('branchRefHidden');
        const deliveryTypeInputs = document.querySelectorAll('input[name="delivery_type"]');

        NovaPoshtaRegionSelect.addEventListener('change', function() {
            NovaPoshtaCityInput.value = '';
            NovaPoshtaBranchesInput.value = '';
            NovaPoshtaCityList.innerHTML = '';
            NovaPoshtaBranchesList.innerHTML = '';
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
        })

        function updateFormVisibility() {
            const selectedDeliveryType = document.querySelector('input[name="delivery_type"]:checked').value;
            const inputCategoryOfWarehouse = document.getElementById('categoryOfWarehouse');
            const novaPoshtaContainer = document.getElementById('NovaPoshtaContainer');
            const meestContainer = document.getElementById('MeestContainer');
            const ukrPoshtaContainer = document.getElementById('UkrPoshtaContainer');

            const poshtaAndDelivery = selectedDeliveryType.split("_");
            let poshta = poshtaAndDelivery[0];
            let delivery = poshtaAndDelivery[1];

            NovaPoshtaBranchesInput.value = '';
            NovaPoshtaCityInput.value = '';
            MeestBranchesInput.value = '';
            MeestCityInput.value = '';
            NovaPoshtaBranchesList.innerHTML = '';
            MeestBranchesList.innerHTML = '';
            MeestCityList.innerHTML = '';
            branchRefHidden.value = '';

            if (poshta === 'NovaPoshta') {
                meestContainer.classList.add('hidden');
                novaPoshtaContainer.classList.remove('hidden');
                ukrPoshtaContainer.classList.add('hidden');
                if (delivery === 'branch') {
                    NovaPoshtaBranchesContainer.style.display = 'block';
                    addressContainer.style.display = 'none';
                    document.querySelector('#NovaPoshtaBranchesContainer label').textContent = 'Відділення Нової Пошти';
                    NovaPoshtaBranchesInput.placeholder = 'Введіть назву відділення';
                    inputCategoryOfWarehouse.value = '';
                } else if (delivery === 'postomat') {
                    NovaPoshtaBranchesContainer.style.display = 'block';
                    addressContainer.style.display = 'none';
                    document.querySelector('#NovaPoshtaBranchesContainer label').textContent = 'Поштомат Нової Пошти';
                    NovaPoshtaBranchesInput.placeholder = 'Введіть назву поштомата';
                    inputCategoryOfWarehouse.value = 'Postomat';
                } else if (delivery === 'courier') {
                    NovaPoshtaBranchesContainer.style.display = 'none';
                    addressContainer.style.display = 'block';
                    inputCategoryOfWarehouse.value = '';
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
                    const cityRef = document.querySelector('#NovaPoshtaCityList li[data-value]')?.getAttribute('data-value');
                    const searchText = this.value.trim().toLowerCase();
                    if (cityRef && searchText.length >= 0) {
                        NovaPoshtaFetchBranches(cityRef, searchText);
                    } else {
                        NovaPoshtaBranchesList.innerHTML = '';
                        NovaPoshtaBranchesList.classList.add('hidden');
                    }
                });

                NovaPoshtaBranchesInput.addEventListener('focus', function() {
                    const cityRef = document.querySelector('#NovaPoshtaCityList li[data-value]')?.getAttribute('data-value');
                    if (NovaPoshtaCityInput.value.trim().length === 0) {
                        NovaPoshtaFetchBranches(cityRef, '');
                    } else if (NovaPoshtaBranchesList.children.length > 0) {
                        NovaPoshtaBranchesList.classList.remove('hidden');
                    }
                });

                function NovaPoshtaFetchCities(regionRef, searchText) {
                    fetch('/cities', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ region: regionRef })
                    })
                        .then(response => response.json())
                        .then(data => {
                            NovaPoshtaCityList.innerHTML = '';
                            data.forEach(city => {
                                if (city.Description.toLowerCase().startsWith(searchText)) {
                                    const listItem = document.createElement('li');
                                    listItem.textContent = city.Description;
                                    listItem.setAttribute('data-value', city.Ref);
                                    listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                    listItem.addEventListener('click', function() {
                                        NovaPoshtaCityInput.value = city.Description;
                                        cityRefHidden.value = city.Ref;
                                        NovaPoshtaCityList.classList.add('hidden');
                                        MeestBranchesInput.value = '';
                                        NovaPoshtaBranchesList.innerHTML = '';
                                    });
                                    NovaPoshtaCityList.appendChild(listItem);
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
                    fetch('/branches', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ city: cityRef, search: searchText, categoryOfWarehouse: categoryOfWarehouse })
                    })
                        .then(response => response.json())
                        .then(data => {
                            NovaPoshtaBranchesList.innerHTML = '';
                            data.forEach(branch => {
                                if (document.getElementById('categoryOfWarehouse').value !== 'Postomat') {
                                    if (branch.CategoryOfWarehouse === 'Branch') {
                                        if (branch.Description.toLowerCase().includes(searchText)) {
                                            const listItem = document.createElement('li');
                                            listItem.textContent = branch.Description;
                                            listItem.setAttribute('data-value', branch.Ref);
                                            listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                            listItem.addEventListener('click', function() {
                                                NovaPoshtaBranchesInput.value = this.textContent;
                                                branchRefHidden.value = branch.Ref;
                                                NovaPoshtaBranchesList.classList.add('hidden');
                                            });
                                            NovaPoshtaBranchesList.appendChild(listItem);
                                        }
                                    }
                                } else {
                                    if (branch.Description.toLowerCase().includes(searchText)) {
                                        const listItem = document.createElement('li');
                                        listItem.textContent = branch.Description;
                                        listItem.setAttribute('data-value', branch.Ref);
                                        listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                        listItem.addEventListener('click', function() {
                                            NovaPoshtaBranchesInput.value = this.textContent;
                                            branchRefHidden.value = branch.Ref;
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
            } else if (poshta === 'Meest') {
                const cityId = document.getElementById('meestCityIdHidden');
                const branchID = document.getElementById('meestBranchIDHidden');
                novaPoshtaContainer.classList.add('hidden');
                meestContainer.classList.remove('hidden');
                ukrPoshtaContainer.classList.add('hidden');

                if (delivery === 'branch') {
                    MeestBranchesContainer.style.display = 'block';
                    addressContainer.style.display = 'none';
                    document.querySelector('#MeestBranchesContainer label').textContent = 'Відділення Meest';
                    MeestBranchesInput.placeholder = 'Введіть назву відділення';
                    inputCategoryOfWarehouse.value = '';
                } else if (delivery === 'postomat') {
                    MeestBranchesContainer.style.display = 'block';
                    addressContainer.style.display = 'none';
                    document.querySelector('#MeestBranchesContainer label').textContent = 'Поштомат Meest';
                    MeestBranchesInput.placeholder = 'Введіть назву поштомата';
                    inputCategoryOfWarehouse.value = 'Postomat';
                } else if (delivery === 'courier') {
                    MeestBranchesContainer.style.display = 'none';
                    addressContainer.style.display = 'block';
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
                    const cityId = document.querySelector('#MeestCityList li[data-value]')?.getAttribute('data-value');
                    const searchText = this.value.trim().toLowerCase();
                    if (cityId && searchText.length > 1) {
                        MeestFetchBranches(cityId, MeestCityInput.value, searchText);
                    } else {
                        MeestBranchesList.innerHTML = '';
                        MeestBranchesList.classList.add('hidden');
                    }
                });

                MeestBranchesInput.addEventListener('focus', function() {
                    const cityId = document.querySelector('#MeestCityList li[data-value]')?.getAttribute('data-value');
                    if (cityId && MeestBranchesInput.value.trim().length === 0) {
                        MeestFetchBranches(cityId, MeestCityInput.value, '');
                    } else if (MeestBranchesList.children.length > 0) {
                        MeestBranchesList.classList.remove('hidden');
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
                                        cityId.value = city.cityID;
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
                                            branchID.value = branch.branchID;
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
                                                branchID.value = branch.branchID;
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
                const cityId = document.getElementById('ukrPoshtaCityIdHidden');
                const branchID = document.getElementById('ukrPoshtaBranchIDHidden');
                novaPoshtaContainer.classList.add('hidden');
                meestContainer.classList.add('hidden');
                ukrPoshtaContainer.classList.remove('hidden');

                if (delivery === 'exspresBranch' || delivery === 'branch') {
                    UkrPoshtaBranchesContainer.style.display = 'block';
                    addressContainer.style.display = 'none';
                    document.querySelector('#MeestBranchesContainer label').textContent = 'Відділення УкрПошта';
                    UkrPoshtaCityInput.placeholder = 'Введіть назву відділення';
                } else if (delivery === 'exspresCourier' || delivery === 'courier') {
                    UkrPoshtaBranchesContainer.style.display = 'none';
                    addressContainer.style.display = 'block';
                }

                UkrPoshtaCityInput.addEventListener('input', function() {
                    const regionId = UkrPoshtaRegionSelect.value;
                    const searchText = this.value.trim().toLowerCase();
                    if (regionId && searchText.length > 0) {
                        fetchCities(regionId, searchText);
                    } else {
                        UkrPoshtaCityList.innerHTML = '';
                        UkrPoshtaCityList.classList.add('hidden');
                    }
                });

                UkrPoshtaCityInput.addEventListener('focus', function() {
                    const regionId = UkrPoshtaRegionSelect.value;
                    if (regionId && UkrPoshtaCityInput.value.trim().length === 0) {
                        fetchCities(regionId, '');
                    } else if (UkrPoshtaCityInput.children.length > 0) {
                        UkrPoshtaCityList.classList.remove('hidden');
                    }
                });

                UkrPoshtaBranchesInput.addEventListener('input', function() {
                    const searchText = this.value.trim().toLowerCase();
                    const cityIdValue = cityId.value;
                    if (cityIdValue && searchText.length > 1) {
                        fetchBranches(cityId, searchText);
                    } else {
                        UkrPoshtaBranchesList.innerHTML = '';
                        UkrPoshtaBranchesList.classList.add('hidden');
                    }
                });

                UkrPoshtaBranchesInput.addEventListener('focus', function() {
                    const cityIdValue = cityId.value;
                    if (UkrPoshtaBranchesInput.value.trim().length === 0) {
                        fetchBranches(cityIdValue, '');
                    } else if (UkrPoshtaBranchesList.children.length > 0) {
                        UkrPoshtaBranchesList.classList.remove('hidden');
                    }
                });

                function fetchCities(regionId, searchText) {
                    fetch(`/ukr/cities?regionId=${regionId}`, {
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
                                if (city.CITY_UA.toLowerCase().startsWith(searchText)) {
                                    const listItem = document.createElement('li');
                                    listItem.textContent = city.CITY_UA;
                                    listItem.setAttribute('data-value', city.CITY_ID);
                                    listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                    listItem.addEventListener('click', function() {
                                        UkrPoshtaCityInput.value = city.CITY_UA;
                                        cityId.value = city.CITY_ID;
                                        UkrPoshtaCityList.classList.add('hidden');
                                        UkrPoshtaBranchesInput.value = '';
                                        UkrPoshtaBranchesList.innerHTML = '';
                                    });
                                    UkrPoshtaCityList.appendChild(listItem);
                                }
                            });
                            if (UkrPoshtaCityList.children.length > 0) {
                                UkrPoshtaCityList.classList.remove('hidden');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }

                function fetchBranches(cityId, searchText) {
                    console.log(cityId)
                    fetch(`/ukr/branches?cityId=${cityId}`, {
                        method: 'GET',
                        headers: {
                            'accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data)
                            UkrPoshtaBranchesList.innerHTML = '';
                            data.forEach(branch => {
                                const listItem = document.createElement('li');
                                if (branch.POSTOFFICE_UA.toLowerCase().includes(searchText) || branch.STREET_UA_VPZ.toLowerCase().includes(searchText)) {
                                    listItem.textContent = branch.POSTOFFICE_UA + ' ' + branch.STREET_UA_VPZ;
                                    listItem.setAttribute('data-value', branch.POSTOFFICE_ID);
                                    listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                    listItem.addEventListener('click', function() {
                                        UkrPoshtaBranchesInput.value = branch.POSTOFFICE_UA + ' ' + branch.STREET_UA_VPZ;
                                        branchID.value = branch.POSTOFFICE_ID;
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
            }
        }

        deliveryTypeInputs.forEach(input => {
            input.addEventListener('change', updateFormVisibility);
        });

        updateFormVisibility();
    });
</script>
