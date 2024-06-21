<x-app-layout>
    <main itemscope itemtype="http://schema.org/ItemList">
        <section class="w-full mx-auto py-12" style="max-width: 114rem">
            <div class="bg-white shadow sm:rounded-lg p-6">

                @include('admin.orders.header')

                <form action="{{ route('operator.order.updateThird', $order->id) }}" method="post">
                    @csrf

                    <div class="mb-4">
                        <label for="user_last_name" class="block mb-2 font-bold">Прізвище</label>
                        <input type="text" name="user_last_name" id="user_last_name" class="w-full border rounded px-3 py-2" value="{{ $order->user_last_name }}">
                    </div>

                    <div class="mb-4">
                        <label for="user_name" class="block mb-2 font-bold w-full">Ім'я</label>
                        <input type="text" name="user_name" id="user_name" class="w-full border rounded px-3 py-2" value="{{ $order->user_name }}">
                    </div>

                    <div class="mb-4">
                        <label for="user_middle_name" class="block mb-2 font-bold">По батькові</label>
                        <input type="text" name="user_middle_name" id="user_middle_name" class="w-full border rounded px-3 py-2" value="{{ $order->user_middle_name }}">
                    </div>

                    @include('admin.orders.delivery')

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
        const NovaPoshtaRegionSelect = document.getElementById('nova_poshta_region_ref');
        const NovaPoshtaRegion = document.getElementById('nova_poshta_region');
        const NovaPoshtaBranchDiv = document.getElementById('nova_poshta_branch_div');
        const NovaPoshtaCityDiv = document.getElementById('nova_poshta_city_div');
        const NovaPoshtaCityInput = document.getElementById('nova_poshta_city_input');
        const NovaPoshtaBranchesInput = document.getElementById('nova_poshta_branches_input');
        const NovaPoshtaCityList = document.getElementById('nova_poshta_city_list');
        const NovaPoshtaBranchesList = document.getElementById('nova_poshta_branches_list');
        const UkrPoshtaBranchesContainer = document.getElementById('UkrPoshtaBranchesContainer');
        const UkrPoshtaRegionSelect = document.getElementById('UkrPoshtaRegion');
        const UkrPoshtaCityInput = document.getElementById('UkrPoshtaCityInput');
        const UkrPoshtaBranchesInput = document.getElementById('UkrPoshtaBranchesInput');
        const UkrPoshtaCityList = document.getElementById('UkrPoshtaCityList');
        const UkrPoshtaBranchesList = document.getElementById('UkrPoshtaBranchesList');
        const addressContainer = document.getElementById('addressContainer');
        const cityRefHidden = document.getElementById('city_ref');
        const cityName = document.getElementById('city_name');
        const branchRefHidden = document.getElementById('branch_ref');
        const branchNumber = document.getElementById('branch_number');
        const deliveryTypeInputs = document.querySelectorAll('input[name="delivery_type"]');
        const deliveryNameAndType = document.getElementById('delivery_name_and_type').value;
        const deliveryLocation = document.getElementById('delivery_location').value;
        const deliveryLocationTypeRadios = document.querySelectorAll('input[name="delivery_location_type"]');
        const deliveryLocationVillage = document.getElementById('delivery_location_village');
        const deliveryLocationTypeContainer = document.getElementById('delivery_location_type_container');
        const NovaPoshtaCityBranchContainer = document.getElementById('nova_postha_city_and_branch');
        const UkrPoshtaCityBranchContainer = document.getElementById('ukr_postha_city_and_branch');
        const MeestCityBranchContainer = document.getElementById('meest_city_and_branch');
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

        deliveryTypeInputs.forEach(input => {
            if (input.value === deliveryNameAndType) {
                input.checked = true;
            }
        });

        deliveryLocationTypeRadios.forEach(input => {
            if (input.value === deliveryLocation) {
                input.checked = true;
                let type = deliveryLocation;
            }
        });

        NovaPoshtaRegionSelect.addEventListener('change', function() {
            NovaPoshtaCityInput.value = '';
            cityRefHidden.value = '';
            branchRefHidden.value = '';
            branchNumber.value = '';
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
            cityName.value = '';
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
            deliveryLocationTypeRadios.forEach(radio => {
                if (radio.checked) {
                    if (radio.value === 'City') {
                        type = 'City';
                    } else if (radio.value === 'Village') {
                        type = 'Village';
                    }
                }
            });
        }

        function setTypeSecond() {
            deliveryLocationTypeRadios.forEach(radio => {
                if (radio.checked) {
                    if (radio.value === 'City') {
                        type = 'City';
                        cityRefHidden.value = '';
                        cityName.value = '';
                        branchRefHidden.value = '';
                        branchNumber.value = '';
                        NovaPoshtaBranchesInput.value = '';
                        NovaPoshtaBranchesList.innerHTML = '';
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
                        cityRefHidden.value = '';
                        cityName.value = '';
                        NovaPoshtaCityInput.value = '';
                        NovaPoshtaCityList.innerHTML = '';
                        branchRefHidden.value = '';
                        branchNumber.value = '';
                        NovaPoshtaBranchesInput.value = '';
                        NovaPoshtaBranchesList.innerHTML = '';
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

        function clearDataForDeliveries() {
            cityRefHidden.value = '';
            cityName.value = '';
            NovaPoshtaCityInput.value = '';
            NovaPoshtaCityList.innerHTML = '';
            branchRefHidden.value = '';
            branchNumber.value = '';
            NovaPoshtaBranchesInput.value = '';
            NovaPoshtaBranchesList.innerHTML = '';
            DistrictInput.value = ' ';
            DistrictList.value = '';
            DistrictRef.value = '';
            VillageInput.value = ' ';
            VillageList.value = '';
            VillageRef.value = '';
            StreetInput.value = ' ';
            StreetList.value = '';
            StreetRef.value = '';
            House.value = ' ';
            Flat.value = ' ';
        }

        setType();

        deliveryTypeInputs.forEach(radio => {
            radio.addEventListener('change', function() {
                clearDataForDeliveries();
                updateFormVisibility();
            });
        });

        deliveryLocationTypeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                setTypeSecond();
                updateFormVisibility();
            });
        });

        function updateFormVisibility() {
            const selectedDeliveryType = document.querySelector('input[name="delivery_type"]:checked').value;
            const inputCategoryOfWarehouse = document.getElementById('categoryOfWarehouse');
            const novaPoshtaContainer = document.getElementById('nova_poshta_container');
            const meestContainer = document.getElementById('MeestContainer');
            const ukrPoshtaContainer = document.getElementById('UkrPoshtaContainer');

            const poshtaAndDelivery = selectedDeliveryType.split("_");
            let poshta = poshtaAndDelivery[0];
            let delivery = poshtaAndDelivery[1];

            //
            //Nova Poshta
            //
            if (poshta === 'NovaPoshta') {
                NovaPoshtaCityBranchContainer.style.display = 'block';
                meestContainer.classList.add('hidden');
                novaPoshtaContainer.classList.remove('hidden');
                ukrPoshtaContainer.classList.add('hidden');
                NovaPoshtaBranchDiv.style.display = 'block';
                addressContainer.style.display = 'none';
                NovaPoshtaCityDiv.style.display = 'block';
                deliveryLocationVillage.classList.add('hidden');
                NovaPoshtaBranchesInput.placeholder = 'Введіть назву відділення';
                inputCategoryOfWarehouse.value = 'Branch';
                if (delivery === 'branch') {
                    if (type === 'City') {
                        NovaPoshtaBranchDiv.style.display = 'block';
                        NovaPoshtaCityDiv.style.display = 'block';
                        deliveryLocationVillage.classList.add('hidden');
                    } else if (type === 'Village') {
                        NovaPoshtaCityBranchContainer.insertBefore(deliveryLocationVillage, NovaPoshtaBranchDiv);
                        NovaPoshtaCityDiv.style.display = 'none';
                        deliveryLocationVillage.classList.remove('hidden');
                    }
                    document.querySelector('#nova_poshta_branch_div label').textContent = 'Відділення Нової Пошти *';
                } else if (delivery === 'postomat') {
                    addressContainer.style.display = 'none';
                    NovaPoshtaBranchDiv.style.display = 'block';
                    NovaPoshtaCityDiv.style.display = 'block';
                    document.querySelector('#nova_poshta_branch_div label').textContent = 'Поштомат Нової Пошти *';
                    NovaPoshtaBranchesInput.placeholder = 'Введіть назву поштомата';
                    inputCategoryOfWarehouse.value = 'Postomat';

                    if (type === 'City') {
                        NovaPoshtaCityDiv.style.display = 'block';
                        NovaPoshtaBranchDiv.style.display = 'block';
                        deliveryLocationVillage.classList.add('hidden');
                    } else if (type === 'Village') {
                        NovaPoshtaCityBranchContainer.insertBefore(deliveryLocationVillage, NovaPoshtaBranchDiv);
                        NovaPoshtaCityDiv.style.display = 'none';
                        NovaPoshtaBranchDiv.style.display = 'block';
                        deliveryLocationVillage.classList.remove('hidden');
                    }
                } else if (delivery === 'courier') {
                    NovaPoshtaBranchDiv.style.display = 'none';
                    addressContainer.style.display = 'block';
                    inputCategoryOfWarehouse.value = '';

                    if (type === 'City') {
                        NovaPoshtaBranchDiv.style.display = 'none';
                        NovaPoshtaCityDiv.style.display = 'block';
                        deliveryLocationVillage.classList.add('hidden');
                    } else if (type === 'Village') {
                        NovaPoshtaBranchDiv.style.display = 'none';
                        NovaPoshtaCityDiv.style.display = 'none';
                        deliveryLocationVillage.classList.remove('hidden');
                    }
                }

                if (NovaPoshtaRegionSelect && NovaPoshtaRegion) {
                    NovaPoshtaRegionSelect.addEventListener('change', function() {
                        NovaPoshtaRegion.value = this.selectedOptions[0].text;
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
                        cityRef = cityRefHidden.value;
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
                        cityRef = cityRefHidden.value;
                    } else {
                        cityRef = VillageRef.value;
                    }
                    if (NovaPoshtaBranchesInput.value.trim().length === 0) {
                        NovaPoshtaFetchBranches(cityRef, '');
                    } else if (NovaPoshtaBranchesList.children.length > 0) {
                        NovaPoshtaBranchesList.classList.remove('hidden');
                    }
                });

                deliveryLocationTypeRadios.forEach(radio => {
                    if (radio.checked) {
                        if (radio.value === 'City') {
                            StreetInput.addEventListener('input', function() {
                                const searchText = this.value.trim().toLowerCase();
                                if (cityName.value && searchText.length >= 0) {
                                    NovaPoshtaFetchStreets(cityName.value, searchText);
                                } else {
                                    StreetList.innerHTML = '';
                                    StreetList.classList.add('hidden');
                                }
                            });

                            StreetInput.addEventListener('focus', function() {
                                if (StreetInput.value.trim().length === 0) {
                                    NovaPoshtaFetchStreets(cityName.value, '');
                                } else if (StreetList.children.length > 0) {
                                    StreetList.classList.remove('hidden');
                                }
                            });
                        }
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
                                            cityName.value = city.Description
                                            cityRefHidden.value = city.Ref;
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
                                            branchRefHidden.value = branch.Ref;
                                            branchNumber.value = branch.Number;
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
                                            branchRefHidden.value = branch.Ref;
                                            branchNumber.value = branch.Number;
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

                function NovaPoshtaFetchStreets(cityName, searchText) {
                    fetch('/get-nova-poshta-streets', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ city_name: cityName, search: searchText })
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
                                        cityName.value = village.Description
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
                const cityId = document.getElementById('meestCityIdHidden');
                const branchID = document.getElementById('meestBranchIDHidden');
                novaPoshtaContainer.classList.add('hidden');
                meestContainer.classList.remove('hidden');
                ukrPoshtaContainer.classList.add('hidden');

                if (delivery === 'branch') {
                    deliveryLocationTypeContainer.classList.add('hidden');
                    MeestBranchesContainer.style.display = 'block';
                    addressContainer.style.display = 'none';
                    document.querySelector('#MeestBranchesContainer label').textContent = 'Відділення Meest';
                    MeestBranchesInput.placeholder = 'Введіть назву відділення';
                    inputCategoryOfWarehouse.value = '';
                } else if (delivery === 'postomat') {
                    deliveryLocationTypeContainer.classList.add('hidden');
                    MeestBranchesContainer.style.display = 'block';
                    addressContainer.style.display = 'none';
                    document.querySelector('#MeestBranchesContainer label').textContent = 'Поштомат Meest';
                    MeestBranchesInput.placeholder = 'Введіть назву поштомата';
                    inputCategoryOfWarehouse.value = 'Postomat';
                } else if (delivery === 'courier') {
                    deliveryLocationTypeContainer.classList.remove('hidden');
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
                UkrPoshtaCityBranchContainer.style.display = 'block';
                const cityId = document.getElementById('ukrPoshtaCityIdHidden');
                const branchID = document.getElementById('ukrPoshtaBranchIDHidden');
                novaPoshtaContainer.classList.add('hidden');
                meestContainer.classList.add('hidden');
                ukrPoshtaContainer.classList.remove('hidden');

                if (delivery === 'exspresBranch' || delivery === 'branch') {
                    deliveryLocationTypeContainer.classList.add('hidden');
                    UkrPoshtaBranchesContainer.style.display = 'block';
                    addressContainer.style.display = 'none';
                    document.querySelector('#MeestBranchesContainer label').textContent = 'Відділення УкрПошта';
                    UkrPoshtaCityInput.placeholder = 'Введіть назву відділення';
                } else if (delivery === 'exspresCourier' || delivery === 'courier') {
                    deliveryLocationTypeContainer.classList.remove('hidden');
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
                    } else if (UkrPoshtaCityInput.children.length >= 0) {
                        UkrPoshtaCityList.classList.remove('hidden');
                    }
                });

                UkrPoshtaBranchesInput.addEventListener('input', function() {
                    const searchText = this.value.trim().toLowerCase();
                    const cityIdValue = cityId.value;
                    if (cityIdValue && searchText.length > 0) {
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
                    fetch(`/ukr/branches?cityId=${cityId}`, {
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
                                    listItem.textContent = branch.POSTOFFICE_UA + ' ' + branch.STREET_UA_VPZ;
                                    listItem.setAttribute('data-value', branch.POSTOFFICE_UA);
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
