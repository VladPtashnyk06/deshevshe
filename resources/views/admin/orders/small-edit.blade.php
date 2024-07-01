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

                        @include('admin.orders.delivery')

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
        const Region = document.getElementById('region');
        const CityName = document.getElementById('city_name');
        const CityRefHidden = document.getElementById('city_ref');
        const BranchNumber = document.getElementById('branch_number');
        const Branch = document.getElementById('branch_name');
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
        const DeliveryNameAndType = document.getElementById('delivery_name_and_type').value;
        const DeliveryLocation = document.getElementById('delivery_location').value;
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

        DeliveryTypeInputs.forEach(input => {
            if (input.value === DeliveryNameAndType) {
                input.checked = true;
            }
        });

        DeliveryLocationTypeRadios.forEach(input => {
            if (input.value === DeliveryLocation) {
                input.checked = true;
                type = DeliveryLocation;
            }
        });

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

            DeliveryTypeInputs.forEach(radio => {
                radio.addEventListener('change', function() {
                    CityRefHidden.value = '';
                    CityName.value = '';
                    BranchNumber.value = '';
                    Branch.value = '';
                    BranchRefHidden.value = '';
                    NovaPoshtaCityInput.value = '';
                    NovaPoshtaCityList.value = '';
                    NovaPoshtaBranchesInput.value = '';
                    NovaPoshtaBranchesList.innerHTML = '';
                    UkrPoshtaCityInput.value = '';
                    UkrPoshtaCityList.innerHTML = '';
                    UkrPoshtaBranchesInput.value = '';
                    UkrPoshtaBranchesList.innerHTML = '';
                    MeestCityInput.value = '';
                    MeestCityList.innerHTML = '';
                    MeestBranchesInput.value = '';
                    MeestBranchesList.innerHTML = '';
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
                });
            });
        });

        function setType() {
            DeliveryLocationTypeRadios.forEach(radio => {
                if (radio.checked) {
                    if (radio.value === 'City') {
                        type = 'City';
                        CityRefHidden.value = '';
                        CityName.value = '';
                        BranchNumber.value = '';
                        Branch.value = '';
                        BranchRefHidden.value = '';
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
                        BranchNumber.value = '';
                        Branch.value = '';
                        BranchRefHidden.value = '';
                        NovaPoshtaCityInput.value = '';
                        NovaPoshtaCityList.innerHTML = '';
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
                            Branch.value = '';
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
                                            Branch.value = branch.Description;
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
                                            Branch.value = branch.Description;
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

                if (MeestRegionSelect && Region) {
                    MeestRegionSelect.addEventListener('change', function() {
                        Region.value = this.selectedOptions[0].text;
                    });
                }

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
                                        CityName.value = city.cityDescr.descrUA;
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
                            Branch.value = '';
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
                                            Branch.value = branch.branchType + '(' + branch.addressMoreInformation + ')' + ' ' + branch.address;
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
                                                Branch.value = branch.branchType + '(' + branch.addressMoreInformation + ')' + ' ' + branch.address;
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
                            Branch.value = '';
                            data.forEach(branch => {
                                const listItem = document.createElement('li');
                                if (branch.POSTOFFICE_UA.toLowerCase().includes(searchText.toLowerCase()) || branch.STREET_UA_VPZ.toLowerCase().includes(searchText.toLowerCase())) {
                                    listItem.textContent = branch.POSTOFFICE_UA + (branch.STREET_UA_VPZ ? ' ' + branch.STREET_UA_VPZ : '');
                                    listItem.setAttribute('data-value', branch.POSTOFFICE_UA);
                                    listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                    listItem.addEventListener('click', function() {
                                        UkrPoshtaBranchesInput.value = branch.POSTOFFICE_UA + (branch.STREET_UA_VPZ ? ' ' + branch.STREET_UA_VPZ : '');
                                        BranchRefHidden.value = branch.POSTOFFICE_ID;
                                        Branch.value = branch.POSTOFFICE_UA + (branch.STREET_UA_VPZ ? ' ' + branch.STREET_UA_VPZ : '');
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
