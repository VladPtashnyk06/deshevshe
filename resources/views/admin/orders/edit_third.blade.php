<x-app-layout>
    <main itemscope itemtype="http://schema.org/ItemList">
        <section class="w-full mx-auto py-12" style="max-width: 114rem">
            <div class="bg-white shadow sm:rounded-lg p-6">

                @include('admin.orders.header')

                <form action="{{ route('operator.order.updateThird', $order->id) }}" method="post">
                    @csrf

                    <div class="mb-4">
                        <label for="user_name" class="block mb-2 font-bold w-full">Ім'я</label>
                        <input type="text" name="user_name" id="user_name" class="w-full border rounded px-3 py-2" value="{{ $order->user_name }}">
                    </div>

                    <div class="mb-4">
                        <label for="user_last_name" class="block mb-2 font-bold">Прізвище</label>
                        <input type="text" name="user_last_name" id="user_last_name" class="w-full border rounded px-3 py-2" value="{{ $order->user_last_name }}">
                    </div>

                    <input type="hidden" id="deliveryNameAndType" name="deliveryNameAndType" value="{{ $deliveryNameAndType }}">

                    <div>
                        <h2 class="text-lg font-semibold">Спосіб доставки</h2>
                        <div class="space-y-1 mb-4">
                            <div class="flex">
                                <img src="" alt="Лого(НП)" class="mr-4">
                                <p>Нова пошта</p>
                            </div>
                            <div>
                                <label>
                                    <input type="radio" name="delivery_type" value="NovaPoshta_branch"> Доставка у відділення - Нова Пошта
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
                        <div class="space-y-1 mb-4">
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
                    </div>
                    <div class="space-y-1 mb-4">
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

                    <input type="hidden" name="categoryOfWarehouse" id="categoryOfWarehouse">

                    <div id="NovaPoshtaContainer">
                        <div class="space-y-1 mb-4">
                            <label for="NovaPoshtaRegion" class="block font-semibold">Регіон / Область</label>
                            <select name="NovaPoshtaRegion" id="NovaPoshtaRegion" class="w-full border rounded-md py-2 px-3">
                                <option value="" selected>--- Виберіть ---</option>
                                @foreach($novaPoshtaRegions as $region)
                                    <option value="{{ $region['Ref'] }}" {{ $order->delivery->region == $region['Ref'] ? 'selected' : '' }}>{{ $region['Description'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1 relative mb-4" id="cityContainer">
                            <input type="hidden" id="cityRefHidden" name="cityRefHidden" value="{{ $order->delivery->cityRef }}">
                            <label for="NovaPoshtaCityInput" class="block font-semibold">Місто</label>
                            <input id="NovaPoshtaCityInput" name="NovaPoshtaCityInput" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву міста" value="{{ $order->delivery->city ? $order->delivery->city : 'Немає' }}">
                            <ul id="NovaPoshtaCityList" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                <!-- Міста будуть відображені тут -->
                            </ul>
                        </div>

                        <div class="space-y-1 relative mb-4" id="NovaPoshtaBranchesContainer">
                            <input type="hidden" id="branchRefHidden" name="branchRefHidden" value="">
                            <label for="NovaPoshtaBranchesInput" class="block font-semibold"></label>
                            <input id="NovaPoshtaBranchesInput" name="NovaPoshtaBranchesInput" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву відділення" value="{{ $order->delivery->branch ? $order->delivery->branch : 'Немає' }}">
                            <ul id="NovaPoshtaBranchesList" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                <!-- Відділення будуть відображені тут -->
                            </ul>
                        </div>
                    </div>

                    <div id="MeestContainer" class="hidden">
                        <div class="space-y-1 mb-4">
                            <label for="MeestRegion" class="block font-semibold">Регіон / Область</label>
                            <select name="MeestRegion" id="MeestRegion" class="w-full border rounded-md py-2 px-3">
                                <option value="">--- Виберіть ---</option>
                                @foreach($meestRegions as $region)
                                    <option value="{{ $region['regionID'] }}" {{ $order->delivery->region == $region['regionID'] ? 'selected' : '' }}>{{ ucfirst(strtolower($region['regionDescr']['descrUA'])) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1 relative mb-4" id="cityContainer">
                            <input type="hidden" id="meestCityIDHidden" name="meestCityIDHidden" value="{{ $order->delivery->cityRef }}">
                            <label for="MeestCityInput" class="block font-semibold">Місто</label>
                            <input id="MeestCityInput" name="MeestCityInput" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву міста" value="{{ $order->delivery->city ? $order->delivery->city : 'Немає' }}">
                            <ul id="MeestCityList" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                <!-- Міста будуть відображені тут -->
                            </ul>
                        </div>

                        <div class="space-y-1 relative mb-4" id="MeestBranchesContainer">
                            <input type="hidden" name="meestBranchIDHidden" id="meestBranchIDHidden" value="">
                            <label for="MeestBranchesInput" class="block font-semibold"></label>
                            <input id="MeestBranchesInput" name="MeestBranchesInput" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву відділення" value="{{ $order->delivery->branch ? $order->delivery->branch : 'Немає' }}">
                            <ul id="MeestBranchesList" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                <!-- Відділення будуть відображені тут -->
                            </ul>
                        </div>
                    </div>

                    <div id="UkrPoshtaContainer" class="hidden">
                        <div class="space-y-1 mb-4">
                            <label for="UkrPoshtaRegion" class="block font-semibold">Регіон / Область</label>
                            <select name="UkrPoshtaRegion" id="UkrPoshtaRegion" class="w-full border rounded-md py-2 px-3">
                                <option value="">--- Виберіть ---</option>
                                @foreach($ukrPoshtaRegions as $region)
                                    <option value="{{ $region['REGION_ID'] }}" {{ $region['REGION_ID'] == $order->delivery->region ? 'selected' : ''}}>{{ ucfirst(strtolower($region['REGION_UA'])) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1 relative mb-4" id="UkrPoshtaCityContainer">
                            <input type="hidden" id="ukrPoshtaCityIdHidden" name="ukrPoshtaCityIdHidden" value="{{ $order->delivery->cityRef }}">
                            <label for="UkrPoshtaCityInput" class="block font-semibold">Місто</label>
                            <input id="UkrPoshtaCityInput" name="UkrPoshtaCityInput" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву міста" value="{{ $order->delivery->city ? $order->delivery->city : 'Немає' }}">
                            <ul id="UkrPoshtaCityList" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                <!-- Міста будуть відображені тут -->
                            </ul>
                        </div>

                        <div class="space-y-1 relative mb-4" id="UkrPoshtaBranchesContainer">
                            <input type="hidden" name="ukrPoshtaBranchIDHidden" id="ukrPoshtaBranchIDHidden" value="">
                            <label for="UkrPoshtaBranchesInput" class="block font-semibold">Відділення Укр-Пошти</label>
                            <input id="UkrPoshtaBranchesInput" name="UkrPoshtaBranchesInput" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву відділення" value="{{ $order->delivery->branch ? $order->delivery->branch : 'Немає' }}">
                            <ul id="UkrPoshtaBranchesList" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                <!-- Відділення будуть відображені тут -->
                            </ul>
                        </div>
                    </div>

                    <div class="mb-4" id="addressContainer">
                        <label for="address" class="block mb-2 font-bold">Адреса</label>
                        <input type="text" name="address" id="address" class="w-full border rounded px-3 py-2" value="{{ $order->delivery->address ? $order->delivery->address : 'Немає' }}">
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
<script>
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
        const cityRefHidden = document.getElementById('cityRefHidden');
        const regionRefHidden = document.getElementById('regionRefHidden');
        const branchRefHidden = document.getElementById('branchRefHidden');
        const deliveryTypeInputs = document.querySelectorAll('input[name="delivery_type"]');
        const deliveryNameAndType = document.getElementById('deliveryNameAndType').value;
        const addressContainer = document.getElementById('addressContainer');

        deliveryTypeInputs.forEach(input => {
            if (input.value === deliveryNameAndType) {
                input.checked = true;
            }
        });

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

            if (poshta === 'NovaPoshta') {
                meestContainer.classList.add('hidden');
                novaPoshtaContainer.classList.remove('hidden');
                ukrPoshtaContainer.classList.add('hidden');

                MeestCityInput.value = '';
                MeestBranchesInput.value = '';
                MeestCityList.innerHTML = '';
                MeestBranchesList.innerHTML = '';
                UkrPoshtaCityInput.value = '';
                UkrPoshtaBranchesInput.value = '';
                UkrPoshtaCityList.innerHTML = '';
                UkrPoshtaBranchesList.innerHTML = '';

                if (delivery === 'branch') {
                    document.querySelector('#NovaPoshtaBranchesContainer label').textContent = 'Відділення Нової Пошти';
                    NovaPoshtaBranchesContainer.style.display = 'block';
                    addressContainer.style.display = 'none';
                } else if (delivery === 'postomat') {
                    document.querySelector('#NovaPoshtaBranchesContainer label').textContent = 'Поштомат Нової Пошти';
                    NovaPoshtaBranchesContainer.style.display = 'block';
                    addressContainer.style.display = 'none';
                } else if (delivery === 'courier') {
                    NovaPoshtaBranchesContainer.style.display = 'none';
                    addressContainer.style.display = 'block';
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
                    } else if (NovaPoshtaCityList.children.length >= 0) {
                        NovaPoshtaCityList.classList.remove('hidden');
                    }
                });

                NovaPoshtaBranchesInput.addEventListener('input', function() {
                    const cityRef = cityRefHidden.value;
                    const searchText = this.value.trim().toLowerCase();
                    if (cityRef && searchText.length >= 0) {
                        NovaPoshtaFetchBranches(cityRef, searchText);
                    } else {
                        NovaPoshtaBranchesList.innerHTML = '';
                        NovaPoshtaBranchesList.classList.add('hidden');
                    }
                });

                NovaPoshtaBranchesInput.addEventListener('focus', function() {
                    const cityRef = cityRefHidden.value;
                    if (NovaPoshtaCityInput.value.trim().length === 0) {
                        NovaPoshtaFetchBranches(cityRef, '');
                    } else if (NovaPoshtaBranchesList.children.length >= 0) {
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
                const cityId = document.getElementById('meestCityIDHidden');
                const branchID = document.getElementById('meestBranchIDHidden');
                novaPoshtaContainer.classList.add('hidden');
                meestContainer.classList.remove('hidden');
                ukrPoshtaContainer.classList.add('hidden');

                NovaPoshtaCityInput.value = '';
                NovaPoshtaBranchesInput.value = '';
                NovaPoshtaCityList.innerHTML = '';
                NovaPoshtaBranchesList.innerHTML = '';
                UkrPoshtaCityInput.value = '';
                UkrPoshtaBranchesInput.value = '';
                UkrPoshtaCityList.innerHTML = '';
                UkrPoshtaBranchesList.innerHTML = '';

                if (delivery === 'branch') {
                    document.querySelector('#MeestBranchesContainer label').textContent = 'Відділення Meest';
                    MeestBranchesContainer.style.display = 'block';
                    addressContainer.style.display = 'none';
                } else if (delivery === 'postomat') {
                    document.querySelector('#MeestBranchesContainer label').textContent = 'Поштомат Meest';
                    inputCategoryOfWarehouse.value = 'Postomat';
                    MeestBranchesContainer.style.display = 'block';
                    addressContainer.style.display = 'none';
                } else if (delivery === 'courier') {
                    MeestBranchesContainer.style.display = 'none';
                    addressContainer.style.display = 'block';
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
                                        console.log('city:' + MeestCityInput.value)
                                        console.log('id' + cityId)
                                        MeestCityInput.value = city.cityDescr.descrUA;
                                        cityId.value = city.cityID;
                                        // console.log(cityId.value)
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

                NovaPoshtaCityInput.value = '';
                NovaPoshtaBranchesInput.value = '';
                NovaPoshtaCityList.innerHTML = '';
                NovaPoshtaBranchesList.innerHTML = '';
                MeestCityInput.value = '';
                MeestBranchesInput.value = '';
                MeestCityList.innerHTML = '';
                MeestBranchesList.innerHTML = '';

                if (delivery === 'branch' || delivery === 'exspresBranch') {
                    document.querySelector('#UkrPoshtaBranchesContainer label').textContent = 'Відділення УкрПошти';
                    UkrPoshtaBranchesContainer.style.display = 'block';
                    addressContainer.style.display = 'none';
                } else if (delivery === 'courier' || delivery === 'exspresCourier') {
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
                        fetchBranches(cityIdValue, searchText);
                    } else {
                        UkrPoshtaBranchesList.innerHTML = '';
                        UkrPoshtaBranchesList.classList.add('hidden');
                    }
                });

                UkrPoshtaBranchesInput.addEventListener('focus', function() {
                    const cityIdValue = cityId.value;
                    if (UkrPoshtaBranchesInput.value.trim().length === 0) {
                        fetchBranches(cityIdValue, '');
                    } else if (UkrPoshtaBranchesList.children.length >= 0) {
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
