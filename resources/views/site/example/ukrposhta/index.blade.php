<x-app-layout>
    <main class="max-w-7xl mx-auto py-12">
        <section class="bg-white shadow sm:rounded-lg p-6">
            <h1 class="text-3xl font-semibold mb-6 text-center" itemprop="name">Адреса доставки</h1>
            @csrf

            <div class="space-y-1 mb-4">
                <label class="block font-semibold">Тип доставки</label>
                <div>
                    <label>
                        <input type="radio" name="delivery_type" value="UkrPoshta_exspresBranch" checked> Експрес відділення - Укрпошта
                    </label>
                </div>
                <div>
                    <label>
                        <input type="radio" name="delivery_type" value="UkrPoshta_exspresCourier"> Експрес кур'єр - Укрпошта
                    </label>
                </div>
                <div>
                    <label>
                        <input type="radio" name="delivery_type" value="UkrPoshta_branch"> Стандарт відділення - Укрпошта
                    </label>
                </div>
                <div>
                    <label>
                        <input type="radio" name="delivery_type" value="UkrPoshta_courier"> Стандарт кур'єр - Укрпошта
                    </label>
                </div>
            </div>

            <div class="space-y-1 mb-4">
                <label for="regionUA" class="block font-semibold">Регіон / Область</label>
                <select name="regionUA" id="regionUA" class="w-full border rounded-md py-2 px-3">
                    <option value="">--- Виберіть ---</option>
                    @foreach($regions as $region)
                        <option value="{{ $region['REGION_ID'] }}">{{ ucfirst(strtolower($region['REGION_UA'])) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1 relative mb-4" id="cityContainer">
                <input type="hidden" id="cityId" name="cityId" value="">
                <label for="cityInput" class="block font-semibold">Місто</label>
                <input id="cityInput" name="cityInput" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву міста">
                <ul id="cityList" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                    <li id="noCityFound" class="py-2 px-3 hidden">За Вашим запитом нічого не знайдено</li>
                    <!-- Міста будуть відображені тут -->
                </ul>
            </div>

            <input type="hidden" name="inputNetworkPartner" id="inputNetworkPartner" value="">

            <div class="space-y-1 relative mb-4" id="branchesContainer">
                <input type="hidden" name="branchID" id="branchID" value="">
                <label for="branchesInput" class="block font-semibold">Відділення Укр-Пошти</label>
                <input id="branchesInput" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву відділення">
                <ul id="branchesList" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                    <li id="noBranchFound" class="py-2 px-3 hidden">За Вашим запитом нічого не знайдено</li>
                    <!-- Відділення будуть відображені тут -->
                </ul>
            </div>

            <div class="space-y-1 mb-4" id="addressContainer" style="display: none;">
                <label for="address" class="block font-semibold">Адреса</label>
                <input type="text" name="address" id="address" class="w-full border rounded-md py-2 px-3">
            </div>

            <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-md transition duration-300 ease-in-out hover:bg-blue-600">Submit</button>
        </section>
    </main>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deliveryTypeRadios = document.querySelectorAll('input[name="delivery_type"]');
        const regionSelect = document.getElementById('regionUA');
        const cityInput = document.getElementById('cityInput');
        const branchesInput = document.getElementById('branchesInput');
        const cityList = document.getElementById('cityList');
        const branchesList = document.getElementById('branchesList');
        const cityId = document.getElementById('cityId');
        const branchID = document.getElementById('branchID');
        const addressContainer = document.getElementById('addressContainer');
        const branchesContainer = document.getElementById('branchesContainer');

        regionSelect.addEventListener('change', function() {
            cityInput.value = '';
            branchesInput.value = '';
            cityList.innerHTML = '';
            branchesList.innerHTML = '';
            cityId.value = '';
            branchID.value = '';
        });

        cityInput.addEventListener('input', function() {
            const regionId = regionSelect.value;
            const searchText = this.value.trim().toLowerCase();
            if (regionId && searchText.length > 0) {
                fetchCities(regionId, searchText);
            } else {
                cityList.innerHTML = '';
                cityList.classList.add('hidden');
            }
        });

        cityInput.addEventListener('focus', function() {
            const regionId = regionSelect.value;
            if (regionId && cityInput.value.trim().length === 0) {
                fetchCities(regionId, '');
            } else if (cityList.children.length > 0) {
                cityList.classList.remove('hidden');
            }
        });

        branchesInput.addEventListener('input', function() {
            const searchText = this.value.trim().toLowerCase();
            const cityIdValue = cityId.value;
            if (cityIdValue && searchText.length > 1) {
                fetchBranches(cityId, searchText);
            } else {
                branchesList.innerHTML = '';
                branchesList.classList.add('hidden');
            }
        });

        branchesInput.addEventListener('focus', function() {
            const cityIdValue = cityId.value;
            if (branchesInput.value.trim().length === 0) {
                fetchBranches(cityIdValue, '');
            } else if (branchesList.children.length > 0) {
                branchesList.classList.remove('hidden');
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
                    cityList.innerHTML = '';
                    data.forEach(city => {
                        if (city.CITY_UA.toLowerCase().startsWith(searchText)) {
                            const listItem = document.createElement('li');
                            listItem.textContent = city.CITY_UA;
                            listItem.setAttribute('data-value', city.CITY_ID);
                            listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                            listItem.addEventListener('click', function() {
                                cityInput.value = city.CITY_UA;
                                cityId.value = city.CITY_ID;
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
                    branchesList.innerHTML = '';
                    data.forEach(branch => {
                        const listItem = document.createElement('li');
                        if (branch.POSTOFFICE_UA.toLowerCase().includes(searchText) || branch.STREET_UA_VPZ.toLowerCase().includes(searchText)) {
                            listItem.textContent = branch.POSTOFFICE_UA + ' ' + branch.STREET_UA_VPZ;
                            listItem.setAttribute('data-value', branch.POSTOFFICE_ID);
                            listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                            listItem.addEventListener('click', function() {
                                branchesInput.value = branch.POSTOFFICE_UA + ' ' + branch.STREET_UA_VPZ;
                                branchID.value = branch.POSTOFFICE_ID;
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

        function toggleFields() {
            const selectedType = document.querySelector('input[name="delivery_type"]:checked').value;
            branchesInput.value = '';
            branchesList.innerHTML = '';
            branchID.value = '';

            if (selectedType === 'UkrPoshta_exspresCourier' || selectedType === 'UkrPoshta_courier') {
                branchesContainer.style.display = 'none';
                addressContainer.style.display = 'block';
            } else if (selectedType === 'UkrPoshta_exspresBranch' || selectedType === 'UkrPoshta_branch') {
                branchesContainer.style.display = 'block';
                addressContainer.style.display = 'none';
                branchesInput.placeholder = 'Введіть назву відділення';
            }
        }

        deliveryTypeRadios.forEach(radio => {
            radio.addEventListener('change', toggleFields);
        });

        toggleFields()
    });
</script>
