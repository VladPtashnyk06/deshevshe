<x-app-layout>
    <main class="max-w-7xl mx-auto py-12">
        <section class="bg-white shadow sm:rounded-lg p-6">
            <h1 class="text-3xl font-semibold mb-6 text-center" itemprop="name">Адреса доставки</h1>
            <form action="{{ route('delivery.submit') }}" method="post" class="space-y-4">
                @csrf

                <div class="space-y-1 mb-4">
                    <label class="block font-semibold">Тип доставки</label>
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

                <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-md transition duration-300 ease-in-out hover:bg-blue-600">Submit</button>
            </form>
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
