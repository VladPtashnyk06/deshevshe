<script>
    document.addEventListener('DOMContentLoaded', function() {
        const registrationCheckbox = document.getElementById('registration');
        const passwordFields = document.getElementById('passwordFields');

        if (registrationCheckbox) {
            registrationCheckbox.addEventListener('change', function() {
                passwordFields.classList.toggle('hidden', !this.checked);
            });
        }

        const phoneInput = document.getElementById('user_phone');
        phoneInput.addEventListener('input', function() {
            phoneInput.value = phoneInput.value.replace(/[^\d]/g, '');
        });

        const deliveryTypeInputs = document.querySelectorAll('input[name="delivery_type"]');
        const containers = {
            NovaPoshta: document.getElementById('NovaPoshtaContainer'),
            Meest: document.getElementById('MeestContainer'),
            UkrPoshta: document.getElementById('UkrPoshtaContainer')
        };
        const formElements = {
            Meest: {
                regionSelect: document.getElementById('MeestRegion'),
                cityInput: document.getElementById('MeestCityInput'),
                branchesInput: document.getElementById('MeestBranchesInput'),
                cityList: document.getElementById('MeestCityList'),
                branchesList: document.getElementById('MeestBranchesList'),
                cityIdHidden: document.getElementById('meestCityIdHidden'),
                branchIdHidden: document.getElementById('meestBranchIDHidden'),
                branchesContainer: document.getElementById('MeestBranchesContainer')
            },
            NovaPoshta: {
                regionSelect: document.getElementById('NovaPoshtaRegion'),
                cityInput: document.getElementById('NovaPoshtaCityInput'),
                branchesInput: document.getElementById('NovaPoshtaBranchesInput'),
                cityList: document.getElementById('NovaPoshtaCityList'),
                branchesList: document.getElementById('NovaPoshtaBranchesList'),
                cityRefHidden: document.getElementById('cityRefHidden'),
                branchRefHidden: document.getElementById('branchRefHidden'),
                branchesContainer: document.getElementById('NovaPoshtaBranchesContainer')
            },
            UkrPoshta: {
                regionSelect: document.getElementById('UkrPoshtaRegion'),
                cityInput: document.getElementById('UkrPoshtaCityInput'),
                branchesInput: document.getElementById('UkrPoshtaBranchesInput'),
                cityList: document.getElementById('UkrPoshtaCityList'),
                branchesList: document.getElementById('UkrPoshtaBranchesList'),
                cityIdHidden: document.getElementById('ukrPoshtaCityIdHidden'),
                branchIdHidden: document.getElementById('ukrPoshtaBranchIDHidden'),
                branchesContainer: document.getElementById('UkrPoshtaBranchesContainer')
            },
            addressContainer: document.getElementById('addressContainer'),
            inputCategoryOfWarehouse: document.getElementById('categoryOfWarehouse')
        };

        const debounce = (func, wait) => {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        };

        const resetForm = () => {
            Object.values(formElements).forEach(elements => {
                if (elements.cityInput) elements.cityInput.value = '';
                if (elements.branchesInput) elements.branchesInput.value = '';
                if (elements.cityList) elements.cityList.innerHTML = '';
                if (elements.branchesList) elements.branchesList.innerHTML = '';
            });
            formElements.NovaPoshta.branchRefHidden.value = '';
            formElements.Meest.branchIdHidden.value = '';
            formElements.UkrPoshta.branchIdHidden.value = '';
        };

        const updateFormVisibility = () => {
            const selectedDeliveryType = document.querySelector('input[name="delivery_type"]:checked').value;
            const [poshta, delivery] = selectedDeliveryType.split("_");

            resetForm();
            Object.values(containers).forEach(container => container.classList.add('hidden'));
            containers[poshta].classList.remove('hidden');

            const elements = formElements[poshta];

            if (delivery === 'branch') {
                elements.branchesContainer.style.display = 'block';
                formElements.addressContainer.style.display = 'none';
                elements.branchesInput.placeholder = `Введіть назву відділення ${poshta === 'NovaPoshta' ? 'Нової Пошти' : poshta}*`;
                elements.branchesContainer.querySelector('label').textContent = `Відділення ${poshta === 'NovaPoshta' ? 'Нової Пошти' : poshta}*`;
                formElements.inputCategoryOfWarehouse.value = '';
            } else if (delivery === 'postomat') {
                elements.branchesContainer.style.display = 'block';
                formElements.addressContainer.style.display = 'none';
                elements.branchesInput.placeholder = `Введіть назву поштомата ${poshta === 'NovaPoshta' ? 'Нової Пошти' : poshta}*`;
                elements.branchesContainer.querySelector('label').textContent = `Поштомат ${poshta === 'NovaPoshta' ? 'Нової Пошти' : poshta}*`;
                formElements.inputCategoryOfWarehouse.value = 'Postomat';
            } else if (delivery === 'courier') {
                elements.branchesContainer.style.display = 'none';
                formElements.addressContainer.style.display = 'block';
                formElements.inputCategoryOfWarehouse.value = '';
            }
        };

        const setupEventListeners = (elements, fetchCities, fetchBranches) => {
            elements.regionSelect.addEventListener('change', resetForm);

            elements.cityInput.addEventListener('input', debounce(function() {
                const searchText = this.value.trim().toLowerCase();
                if (elements.regionSelect.value && searchText.length >= 0) {
                    fetchCities(elements.regionSelect.value, searchText, elements.cityList);
                } else {
                    elements.cityList.innerHTML = '';
                    elements.cityList.classList.add('hidden');
                }
            }, 300));

            elements.cityInput.addEventListener('focus', function() {
                if (elements.regionSelect.value && elements.cityInput.value.trim().length === 0) {
                    fetchCities(elements.regionSelect.value, '', elements.cityList);
                } else if (elements.cityList.children.length > 0) {
                    elements.cityList.classList.remove('hidden');
                }
            });

            elements.branchesInput.addEventListener('input', debounce(function() {
                const cityRef = elements.cityList.querySelector('li[data-value]')?.getAttribute('data-value');
                const searchText = this.value.trim().toLowerCase();
                if (cityRef && searchText.length >= 0) {
                    fetchBranches(cityRef, searchText, elements.branchesList);
                } else {
                    elements.branchesList.innerHTML = '';
                    elements.branchesList.classList.add('hidden');
                }
            }, 300));

            elements.branchesInput.addEventListener('focus', function() {
                const cityRef = elements.cityList.querySelector('li[data-value]')?.getAttribute('data-value');
                if (elements.cityInput.value.trim().length === 0) {
                    fetchBranches(cityRef, '', elements.branchesList);
                } else if (elements.branchesList.children.length > 0) {
                    elements.branchesList.classList.remove('hidden');
                }
            });
        };

        const fetchCities = (url, regionId, searchText, listElement) => {
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ regionId, searchText })
            })
                .then(response => response.json())
                .then(data => {
                    listElement.innerHTML = '';
                    data.forEach(city => {
                        if (city.Description.toLowerCase().startsWith(searchText)) {
                            const listItem = document.createElement('li');
                            listItem.textContent = city.Description;
                            listItem.setAttribute('data-value', city.Ref);
                            listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                            listItem.addEventListener('click', function() {
                                listElement.previousElementSibling.value = city.Description;
                                listElement.nextElementSibling.value = city.Ref;
                                listElement.classList.add('hidden');
                                listElement.nextElementSibling.value = '';
                                listElement.innerHTML = '';
                            });
                            listElement.appendChild(listItem);
                        }
                    });
                    if (listElement.children.length > 0) {
                        listElement.classList.remove('hidden');
                    }
                })
                .catch(error => console.error('Error:', error));
        };

        const fetchBranches = (url, cityRef, searchText, listElement, categoryOfWarehouse) => {
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ cityRef, searchText, categoryOfWarehouse })
            })
                .then(response => response.json())
                .then(data => {
                    listElement.innerHTML = '';
                    data.forEach(branch => {
                        if (categoryOfWarehouse !== 'Postomat' && branch.CategoryOfWarehouse === 'Branch' || categoryOfWarehouse === 'Postomat') {
                            const listItem = document.createElement('li');
                            listItem.textContent = branch.Description;
                            listItem.setAttribute('data-value', branch.Ref);
                            listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                            listItem.addEventListener('click', function() {
                                listElement.previousElementSibling.value = branch.Description;
                                listElement.nextElementSibling.value = branch.Ref;
                                listElement.classList.add('hidden');
                            });
                            listElement.appendChild(listItem);
                        }
                    });
                    if (listElement.children.length > 0) {
                        listElement.classList.remove('hidden');
                    }
                })
                .catch(error => console.error('Error:', error));
        };

        deliveryTypeInputs.forEach(input => {
            input.addEventListener('change', updateFormVisibility);
        });

        setupEventListeners(formElements.Meest, (regionId, searchText, cityList) => {
            fetchCities('/get-meest-cities', regionId, searchText, cityList);
        }, (cityRef, searchText, branchesList) => {
            fetchBranches('/get-meest-branches', cityRef, searchText, branchesList);
        });

        setupEventListeners(formElements.NovaPoshta, (regionId, searchText, cityList) => {
            fetchCities('/get-nova-poshta-cities', regionId, searchText, cityList);
        }, (cityRef, searchText, branchesList) => {
            fetchBranches('/get-nova-poshta-branches', cityRef, searchText, branchesList, formElements.inputCategoryOfWarehouse.value);
        });

        setupEventListeners(formElements.UkrPoshta, (regionId, searchText, cityList) => {
            fetchCities('/get-ukrposhta-cities', regionId, searchText, cityList);
        }, (cityRef, searchText, branchesList) => {
            fetchBranches('/get-ukrposhta-branches', cityRef, searchText, branchesList);
        });

        updateFormVisibility();
    });
</script>
