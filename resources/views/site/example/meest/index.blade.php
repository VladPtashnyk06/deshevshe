<x-app-layout>
    <main class="max-w-7xl mx-auto py-12">
        <section class="bg-white shadow sm:rounded-lg p-6">
            <h1 class="text-3xl font-semibold mb-6 text-center" itemprop="name">Адреса доставки</h1>
            @csrf

            <div class="space-y-1 mb-4">
                <label class="block font-semibold">Тип доставки</label>
                <div>
                    <label>
                        <input type="radio" name="delivery_type" value="Meest_branch" checked> Meest: відділення
                    </label>
                </div>
                <div>
                    <label>
                        <input type="radio" name="delivery_type" value="Meest_courier"> Meest: кур'єр
                    </label>
                </div>
                <div>
                    <label>
                        <input type="radio" name="delivery_type" value="Meest_postomat"> Meest: поштомат
                    </label>
                </div>
            </div>

            <div class="space-y-1 mb-4">
                <label for="region" class="block font-semibold">Регіон / Область</label>
                <select name="region" id="region" class="w-full border rounded-md py-2 px-3">
                    <option value="">--- Виберіть ---</option>
                    @foreach($regions as $region)
                        <option value="{{ $region['regionID'] }}">{{ ucfirst(strtolower($region['regionDescr']['descrUA'])) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1 relative mb-4" id="cityContainer">
                <input type="hidden" id="cityId" name="cityId" value="">
                <label for="cityInput" class="block font-semibold">Місто</label>
                <input id="cityInput" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву міста">
                <ul id="cityList" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                    <li id="noCityFound" class="py-2 px-3 hidden">За Вашим запитом нічого не знайдено</li>
                    <!-- Міста будуть відображені тут -->
                </ul>
            </div>

            <input type="hidden" name="inputNetworkPartner" id="inputNetworkPartner" value="">

            <div class="space-y-1 relative mb-4" id="branchesContainer">
                <input type="hidden" name="branchID" id="branchID" value="">
                <label for="branchesInput" class="block font-semibold">Відділення Meest</label>
                <input id="branchesInput" class="w-full border rounded-md py-2 px-3">
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
        const regionSelect = document.getElementById('region');
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

            if (regionId && searchText.length >= 0) {
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
            const cityId = document.querySelector('#cityList li[data-value]')?.getAttribute('data-value');
            const searchText = this.value.trim().toLowerCase();
            if (cityId && searchText.length > 1) {
                fetchBranches(cityId, cityInput.value, searchText);
            } else {
                branchesList.innerHTML = '';
                branchesList.classList.add('hidden');
            }
        });

        branchesInput.addEventListener('focus', function() {
            const cityId = document.querySelector('#cityList li[data-value]')?.getAttribute('data-value');
            if (branchesInput.value.trim().length === 0) {
                fetchBranches(cityId, cityInput.value, '');
            } else if (branchesList.children.length > 0) {
                branchesList.classList.remove('hidden');
            }
        });

        function fetchCities(regionId, searchText) {
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
                    cityList.innerHTML = '';
                    data.forEach(city => {
                        if (city.cityDescr.descrUA.toLowerCase().includes(searchText)) {
                            const listItem = document.createElement('li');
                            listItem.textContent = city.cityDescr.descrUA;
                            listItem.setAttribute('data-value', city.cityID);
                            listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                            listItem.addEventListener('click', function() {
                                cityInput.value = city.cityDescr.descrUA;
                                cityId.value = city.cityID;
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

        function fetchBranches(cityId, cityDescr, searchText) {
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
                    branchesList.innerHTML = '';
                    data.forEach(branch => {
                        const listItem = document.createElement('li');
                        if (document.getElementById('inputNetworkPartner').value !== 'Postomat') {
                            if (branch.branchType.toLowerCase().includes(searchText) || branch.addressMoreInformation.toLowerCase().includes(searchText) || branch.address.toLowerCase().includes(searchText)) {
                                listItem.textContent = branch.branchType + '(' + branch.addressMoreInformation + ')' + ' ' + branch.address;
                                listItem.setAttribute('data-value', branch.branchID);
                                listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                listItem.addEventListener('click', function () {
                                    branchesInput.value = branch.branchType + '(' + branch.addressMoreInformation + ')' + ' ' + branch.address;
                                    branchID.value = branch.branchID;
                                    branchesList.classList.add('hidden');
                                });
                                branchesList.appendChild(listItem);
                            }
                        } else {
                            if (branch.networkPartner === "Поштомат") {
                                if (branch.branchType.toLowerCase().includes(searchText) || branch.addressMoreInformation.toLowerCase().includes(searchText) || branch.address.toLowerCase().includes(searchText)) {
                                    listItem.textContent = branch.branchType + '(' + branch.addressMoreInformation + ')' + ' ' + branch.address;
                                    listItem.setAttribute('data-value', branch.branchID);
                                    listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                    listItem.addEventListener('click', function() {
                                        branchesInput.value = branch.branchType + '(' + branch.addressMoreInformation + ')' + ' ' + branch.address;
                                        branchID.value = branch.branchID;
                                        branchesList.classList.add('hidden');
                                    });
                                    branchesList.appendChild(listItem);
                                }
                            }
                        }
                    });
                    if (branchesList.children.length > 0) {
                        branchesList.classList.remove('hidden');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function toggleFields() {
            const inputNetworkPartner = document.getElementById('inputNetworkPartner');
            const selectedType = document.querySelector('input[name="delivery_type"]:checked').value;
            branchesInput.value = '';
            branchesList.innerHTML = '';
            branchID.value = '';

            if (selectedType === 'Meest_branch') {
                branchesContainer.style.display = 'block';
                addressContainer.style.display = 'none';
                branchesInput.placeholder = 'Введіть назву відділення';
                inputNetworkPartner.value = '';
            } else if (selectedType === 'Meest_courier') {
                branchesContainer.style.display = 'none';
                addressContainer.style.display = 'block';
                inputNetworkPartner.value = '';
            } else if (selectedType === 'Meest_postomat') {
                branchesContainer.style.display = 'block';
                addressContainer.style.display = 'none';
                branchesInput.placeholder = 'Введіть назву поштомату';
                inputNetworkPartner.value = 'Postomat';
            }
        }

        deliveryTypeRadios.forEach(radio => {
            radio.addEventListener('change', toggleFields);
        });

        toggleFields()
    });
</script>
