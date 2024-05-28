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
                            @error('user_phone')
                            <span class="text-red-500">{{ htmlspecialchars("Ви ввели не правильний номер, він не відповідає вимогам українського номеру") }}</span>
                            @enderror
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

                        <div class="mb-4">
                            <label for="region" class="block mb-2 font-bold">Область</label>
                            <select name="region" id="region" class="w-full border rounded-md py-2 px-3">
                                @foreach($regions as $region)
                                    <option value="{{ $region['Ref'] }}" {{ $region['Ref'] == $order->delivery->region ? 'selected': '' }}>{{ $region['Description'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1 relative mb-4" id="cityContainer">
                            <input type="hidden" id="cityRefHidden" name="cityRefHidden" value="{{ $order->delivery->city }}">
                            <label for="cityInput" class="block font-semibold">Місто</label>
                            <input id="cityInput" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву міста">
                            <ul id="cityList" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                <!-- Міста будуть відображені тут -->
                            </ul>
                        </div>

                        <div class="space-y-1 relative mb-4" id="branchesContainer">
                            <input type="hidden" id="branchRefHidden" name="branchRefHidden" value="{{ $order->delivery->branch }}">
                            <label for="branchesInput" class="block font-semibold">Відділення Нової пошти</label>
                            <input id="branchesInput" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву відділення">
                            <ul id="branchesList" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                <!-- Відділення будуть відображені тут -->
                            </ul>
                        </div>

                        <div class="mb-4">
                            <label for="address" class="block mb-2 font-bold">Адреса</label>
                            <input type="text" name="address" id="address" class="w-full border rounded px-3 py-2" value="{{ $order->delivery->address ? $order->delivery->address : 'Немає' }}">
                        </div>

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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const regionSelect = document.getElementById('region');
        const cityInput = document.getElementById('cityInput');
        const branchesInput = document.getElementById('branchesInput');
        const cityList = document.getElementById('cityList');
        const branchesList = document.getElementById('branchesList');
        const cityRefHidden = document.getElementById('cityRefHidden');
        const branchRefHidden = document.getElementById('branchRefHidden');

        loadInitialData();

        regionSelect.addEventListener('change', function() {
            cityInput.value = '';
            branchesInput.value = '';
            cityList.innerHTML = '';
            branchesList.innerHTML = '';
            cityRefHidden.value = '';
            branchRefHidden.value = '';
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
            const cityRef = cityRefHidden.value;
            const searchText = this.value.trim().toLowerCase();
            if (cityRef && searchText.length > 1) {
                fetchBranches(cityRef, searchText);
            } else {
                branchesList.innerHTML = '';
                branchesList.classList.add('hidden');
            }
        });

        branchesInput.addEventListener('focus', function() {
            const cityRef = cityRefHidden.value;
            if (branchesInput.value.trim().length === 0) {
                fetchBranches(cityRef, '');
            } else if (branchesList.children.length > 0) {
                branchesList.classList.remove('hidden');
            }
        });

        function loadInitialData() {
            const cityRef = cityRefHidden.value;
            const branchRef = branchRefHidden.value;
            if (cityRef) {
                fetchCityByRef(cityRef);
            }
            if (branchRef) {
                fetchBranchByRef(branchRef);
            }
        }

        function fetchCityByRef(ref) {
            fetch(`/city/${ref}`)
                .then(response => response.json())
                .then(data => {
                    cityInput.value = data.Description;
                })
                .catch(error => console.error('Error:', error));
        }

        function fetchBranchByRef(ref) {
            fetch(`/branch/${ref}`)
                .then(response => response.json())
                .then(data => {
                    branchesInput.value = data.Description;
                })
                .catch(error => console.error('Error:', error));
        }

        function fetchCities(regionRef, searchText) {
            fetch('/cities', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ region: regionRef, search: searchText })
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
                                cityInput.value = city.Description;
                                cityRefHidden.value = city.Ref;
                                cityList.classList.add('hidden');
                                branchesInput.value = '';
                                branchesList.innerHTML = '';
                                branchRefHidden.value = '';
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
            fetch('/branches', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ city: cityRef, search: searchText })
            })
                .then(response => response.json())
                .then(data => {
                    branchesList.innerHTML = '';
                    data.forEach(branch => {
                        if (branch.Description.toLowerCase().includes(searchText)) {
                            const listItem = document.createElement('li');
                            listItem.textContent = branch.Description;
                            listItem.setAttribute('data-value', branch.Ref);
                            listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                            listItem.addEventListener('click', function() {
                                branchesInput.value = this.textContent;
                                branchRefHidden.value = branch.Ref;
                                branchesList.classList.add('hidden');
                            });
                            branchesList.appendChild(listItem);
                        }
                    });
                    if (branchesList.children.length > 0) {
                        branchesList.classList.remove('hidden');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    });
</script>
