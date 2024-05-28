<x-app-layout>
    <main itemscope itemtype="http://schema.org/ItemList">
        <section class="mx-auto py-12" style="max-width: 100rem">
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
                                <div class="ml-4">
                                    <p>Кількість: {{ $item->quantity }}</p>
                                </div>
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
                                        <label for="user_name" class="block text-gray-700">Ім'я</label>
                                        <input type="text" id="user_name" name="user_name" class="mt-1 block w-full border rounded" required value="{{ Auth::user() ? Auth::user()->name : old('name') }}" placeholder="Введіть ім'я">
                                    </div>
                                    <div class="mb-4">
                                        <label for="user_last_name" class="block text-gray-700">Прізвище</label>
                                        <input type="text" id="user_last_name" name="user_last_name" class="mt-1 block w-full border rounded" required value="{{ Auth::user() ? Auth::user()->last_name : old('last_name') }}" placeholder="Введіть прізвище">
                                    </div>
                                    <div class="mb-4">
                                        <label for="user_phone" class="block text-gray-700">Номер телефону</label>
                                        <div class="flex">
                                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-900 text-sm">
                                        +380
                                    </span>
                                            <input type="text" id="user_phone" name="user_phone" class="mt-1 block w-full pl-2 border-l-0 rounded-r-md" required value="{{ Auth::user() ? str_replace('+380', '', Auth::user()->phone) : old('phone') }}" placeholder="971231212">
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="user_email" class="block text-gray-700">Електронна пошта</label>
                                        <input type="email" id="user_email" name="user_email" class="mt-1 block w-full border rounded" required value="{{ Auth::user() && Auth::user()->email ? Auth::user()->email : old('email') }}" placeholder="example@gmail.com">
                                    </div>
                                    @if(!Auth::user())
                                        <div class="mb-4">
                                            <label for="registration" class="block text-gray-700 font-semibold mb-2">Реєстрація (Створити особистий кабінет)</label>
                                            <input type="checkbox" name="registration" id="registration" class="mr-2">
                                        </div>
                                        <div id="passwordFields" class="hidden">
                                            <div class="mb-4">
                                                <label for="password" class="block text-gray-700">Пароль</label>
                                                <input type="password" id="password" name="password" class="mt-1 block w-full">
                                            </div>
                                            <div class="mb-4">
                                                <label for="password_confirmation" class="block text-gray-700">Підтвердження пароля</label>
                                                <input type="password" id="password_confirmation" name="password_confirmation" class="mt-1 block w-full">
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
                                </div>
                                <div class="second md:w-2/3">
                                    <h2 class="text-lg font-semibold">Спосіб доставки</h2>
                                    <div class="space-y-1 mb-4">
                                        <div class="flex">
                                            <img src="" alt="Лого(НП)" class="mr-4">
                                            <p>Нова пошта</p>
                                        </div>
                                        <div>
                                            <label>
                                                <input type="radio" name="delivery_type" value="branch" checked> Доставка у відділення - Нова Пошта
                                            </label>
                                        </div>
                                        <div>
                                            <label>
                                                <input type="radio" name="delivery_type" value="courier"> Доставка кур'єром - Нова Пошта
                                            </label>
                                        </div>
                                        <div>
                                            <label>
                                                <input type="radio" name="delivery_type" value="postomat"> Доставка в поштомат - Нова Пошта
                                            </label>
                                        </div>
                                    </div>

                                    <div class="space-y-1 mb-4">
                                        <label for="region" class="block font-semibold">Регіон / Область</label>
                                        <select name="region" id="region" class="w-full border rounded-md py-2 px-3">
                                            <option value="">--- Виберіть ---</option>
                                            @foreach($regions as $region)
                                                <option value="{{ $region['Ref'] }}">{{ $region['Description'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="space-y-1 relative mb-4" id="cityContainer">
                                        <label for="cityInput" class="block font-semibold">Місто</label>
                                        <input id="cityInput" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву міста">
                                        <ul id="cityList" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                            <!-- Міста будуть відображені тут -->
                                        </ul>
                                    </div>

                                    <input type="hidden" name="categoryOfWarehouse" id="categoryOfWarehouse" value="Branch">

                                    <div class="space-y-1 relative mb-4" id="branchesContainer">
                                        <label for="branchesInput" class="block font-semibold">Відділення Нової пошти</label>
                                        <input id="branchesInput" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву відділення">
                                        <ul id="branchesList" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                            <!-- Відділення будуть відображені тут -->
                                        </ul>
                                    </div>

                                    <div class="space-y-1 mb-4" id="addressContainer">
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

        phoneInput.addEventListener('input', function (e) {
            if (!/^\d*$/.test(phoneInput.value)) {
                phoneInput.value = phoneInput.value.replace(/[^\d]/g, '');
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const regionSelect = document.getElementById('region');
        const cityInput = document.getElementById('cityInput');
        const branchesInput = document.getElementById('branchesInput');
        const cityList = document.getElementById('cityList');
        const branchesList = document.getElementById('branchesList');
        const addressContainer = document.getElementById('addressContainer');
        const branchesContainer = document.getElementById('branchesContainer');
        const deliveryTypeInputs = document.querySelectorAll('input[name="delivery_type"]');

        regionSelect.addEventListener('change', function() {
            cityInput.value = '';
            branchesInput.value = '';
            cityList.innerHTML = '';
            branchesList.innerHTML = '';
        });

        cityInput.addEventListener('input', function() {
            const regionRef = regionSelect.value;
            const searchText = this.value.trim().toLowerCase();

            if (regionRef && searchText.length >= 0) {
                fetchCities(regionRef, searchText);
            } else {
                cityList.innerHTML = '';
                cityList.classList.add('hidden');
            }
        });

        cityInput.addEventListener('focus', function() {
            const regionRef = regionSelect.value;
            if (regionRef && cityInput.value.trim().length === 0) {
                fetchCities(regionRef, '');
            } else if (cityList.children.length > 0) {
                cityList.classList.remove('hidden');
            }
        });

        branchesInput.addEventListener('input', function() {
            const cityRef = document.querySelector('#cityList li[data-value]')?.getAttribute('data-value');
            const searchText = this.value.trim().toLowerCase();
            if (cityRef && searchText.length > 1) {
                fetchBranches(cityRef, searchText);
            } else {
                branchesList.innerHTML = '';
                branchesList.classList.add('hidden');
            }
        });

        branchesInput.addEventListener('focus', function() {
            const cityRef = document.querySelector('#cityList li[data-value]')?.getAttribute('data-value');
            if (branchesInput.value.trim().length === 0) {
                fetchBranches(cityRef, '');
            } else if (branchesList.children.length > 0) {
                branchesList.classList.remove('hidden');
            }
        });

        function fetchCities(regionRef, searchText) {
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
                    cityList.innerHTML = '';
                    data.forEach(city => {
                        if (city.Description.toLowerCase().startsWith(searchText)) {
                            const listItem = document.createElement('li');
                            listItem.textContent = city.Description;
                            listItem.setAttribute('data-value', city.Ref);
                            listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                            listItem.addEventListener('click', function() {
                                cityInput.value = this.textContent;
                                cityList.classList.add('hidden');
                                branchesInput.value = '';
                                branchesList.innerHTML = '';
                            });
                            cityList.appendChild(listItem);
                        }
                    });
                    if (cityList.children.length > 0) {
                        cityList.classList.remove('hidden');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function fetchBranches(cityRef, searchText) {
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
                    branchesList.innerHTML = '';
                    data.forEach(branch => {
                        if (document.getElementById('categoryOfWarehouse').value !== 'Postomat') {
                            if (branch.CategoryOfWarehouse === 'Branch') {
                                if (branch.Description.toLowerCase().includes(searchText)) {
                                    console.log(branch)
                                    const listItem = document.createElement('li');
                                    listItem.textContent = branch.Description;
                                    listItem.setAttribute('data-value', branch.Ref);
                                    listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                    listItem.addEventListener('click', function() {
                                        branchesInput.value = this.textContent;
                                        branchesList.classList.add('hidden');
                                    });
                                    branchesList.appendChild(listItem);
                                }
                            }
                        } else {
                            if (branch.Description.toLowerCase().includes(searchText)) {
                                const listItem = document.createElement('li');
                                listItem.textContent = branch.Description;
                                listItem.setAttribute('data-value', branch.Ref);
                                listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                listItem.addEventListener('click', function() {
                                    branchesInput.value = this.textContent;
                                    branchesList.classList.add('hidden');
                                });
                                branchesList.appendChild(listItem);
                            }
                        }
                    });
                    if (branchesList.children.length > 0) {
                        branchesList.classList.remove('hidden');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function updateFormVisibility() {
            const selectedDeliveryType = document.querySelector('input[name="delivery_type"]:checked').value;
            const inputCategoryOfWarehouse = document.getElementById('categoryOfWarehouse');
            if (selectedDeliveryType === 'branch') {
                branchesContainer.style.display = 'block';
                addressContainer.style.display = 'none';
                document.querySelector('#branchesContainer label').textContent = 'Відділення Нової пошти';
                branchesInput.placeholder = 'Введіть назву відділення';
                inputCategoryOfWarehouse.value = '';
            } else if (selectedDeliveryType === 'postomat') {
                branchesContainer.style.display = 'block';
                addressContainer.style.display = 'none';
                document.querySelector('#branchesContainer label').textContent = 'Поштомат Нової пошти';
                branchesInput.placeholder = 'Введіть назву поштомата';
                inputCategoryOfWarehouse.value = 'Postomat';
            } else if (selectedDeliveryType === 'courier') {
                branchesContainer.style.display = 'none';
                addressContainer.style.display = 'block';
                inputCategoryOfWarehouse.value = '';
            }
        }

        deliveryTypeInputs.forEach(input => {
            input.addEventListener('change', updateFormVisibility);
        });

        updateFormVisibility();
    });
</script>
