<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg p-6 bg-white">
                <h2 class="text-2xl font-semibold mb-4 text-center">Сформувати ТТН</h2>
                <form id="ttnForm">

                    <div>
                        <h2 class="text-xl font-semibold mb-4 text-left">Відправник</h2>
                        <div class="p-4 border-gray-500 border rounded">
                            <div class="mb-4">
                                @error('sender_ref')
                                <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення та унікальним") }}</span>
                                @enderror
                                <label for="sender_ref" class="block mb-2 font-bold">Відправник</label>
                                <select name="sender_ref" id="sender_ref" class="w-full border rounded px-3 py-2">
                                    <option value=""> Всі відправники </option>
                                    @foreach($senders as $sender)
                                        <option value="{{ $sender['Ref'] }}"> {{ $sender['CounterpartyFullName'] }} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <input type="hidden" id="contacts_person_ref" name="contacts_person_ref" value="">
                                @error('contacts_person')
                                <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення та унікальним") }}</span>
                                @enderror
                                <label for="contacts_person" class="block mb-2 font-bold">Довірене лице</label>
                                <select name="contacts_person" id="contacts_person" class="w-full border rounded px-3 py-2" disabled>
                                    <option value=""> Всі довірені лиця </option>
                                </select>
                            </div>

                            <div class="space-y-1 relative mb-4" id="cityContainer">
                                <input type="hidden" id="city_ref_hidden" name="city_ref_hidden" value="">
                                <label for="city_name" class="block font-semibold">Місто</label>
                                <input id="city_name" name="city_name" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву міста">
                                <ul id="city_list" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                    <!-- Міста будуть відображені тут -->
                                </ul>
                            </div>

                            <div class="mb-4">
                                <input type="hidden" id="sender_address" name="sender_address" value="">
                                @error('warehouse')
                                <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення та унікальним") }}</span>
                                @enderror
                                <label for="warehouse" class="block mb-2 font-bold">Відділення</label>
                                <select name="warehouse" id="warehouse" class="w-full max-h-48 border rounded px-3 py-2  bg-white" disabled>
                                    <option value=""> Всі відділення </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="delivery_id" value="{{ $delivery->id }}">
                    <input type="hidden" name="order_id" value="{{ $order->id }}">

                    <div class="mt-8">
                        <h2 class="text-xl font-semibold mb-4 text-left">Дані посилки</h2>
                        <div class="flex grid lg:grid-cols-3">
                            <div class="mb-4 mr-4">
                                @error('width')
                                <span class="text-red-500">{{ htmlspecialchars("Це поле є обо'вязковим для заповнення та унікальким") }}</span>
                                @enderror
                                <label for="width" class="block mb-2 font-bold">Ширина (см)</label>
                                <input type="number" name="width" min="0.1" step="0.1" id="width" class="w-full border rounded px-3 py-2" value="">
                            </div>
                            <div class="mb-4 mr-4">
                                @error('length')
                                <span class="text-red-500">{{ htmlspecialchars("Це поле є обо'вязковим для заповнення та унікальким") }}</span>
                                @enderror
                                <label for="length" class="block mb-2 font-bold">Довжина (см)</label>
                                <input type="number" name="length" min="0.1" step="0.1" id="length" class="w-full border rounded px-3 py-2" value="">
                            </div>
                            <div class="mb-4">
                                @error('height')
                                <span class="text-red-500">{{ htmlspecialchars("Це поле є обо'вязковим для заповнення та унікальким") }}</span>
                                @enderror
                                <label for="height" class="block mb-2 font-bold">Висота (см)</label>
                                <input type="number" name="height" min="0.1" step="0.1" id="height" class="w-full border rounded px-3 py-2" value="">
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        @error('weight')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обо'вязковим для заповнення та унікальким") }}</span>
                        @enderror
                        <label for="weight" class="block mb-2 font-bold">Вага</label>
                        <input type="number" name="weight" min="0.1" step="0.1" id="weight" class="w-full border rounded px-3 py-2" value="">
                    </div>

                    <div class="mb-4">
                        @error('description')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення та унікальним") }}</span>
                        @enderror
                        <label for="description" class="block mb-2 font-bold">Опис</label>
                        <input type="text" name="description" id="description" class="w-full border rounded px-3 py-2" value="">
                    </div>

                    <div class="mb-4">
                        @error('recipient_type')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення та унікальним") }}</span>
                        @enderror
                        <label for="recipient_type" class="block mb-2 font-bold">Тип отримувача</label>
                        <select name="recipient_type" id="recipient_type" class="w-full border rounded px-3 py-2">
                            <option value=""> Виберіть </option>
                            <option value="PrivatePerson"> Приватна особа </option>
                            <option value="Organization"> Організація </option>
                        </select>
                    </div>

                    <div class="text-center mb-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Сформувати ТТН</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const NovaPoshtaCityInput = document.getElementById('city_name');
        const NovaPoshtaCityList = document.getElementById('city_list');
        const cityRefHidden = document.getElementById('city_ref_hidden');
        const warehouseSelect = document.getElementById('warehouse');
        const senderAddress = document.getElementById('sender_address');

        NovaPoshtaCityInput.addEventListener('input', function() {
            const searchText = this.value.trim().toLowerCase();

            if (searchText.length >= 0) {
                NovaPoshtaFetchCities(searchText);
            } else {
                NovaPoshtaCityList.innerHTML = '';
                NovaPoshtaCityList.classList.add('hidden');
            }
        });

        NovaPoshtaCityInput.addEventListener('focus', function() {
            if (NovaPoshtaCityInput.value.trim().length === 0) {
                NovaPoshtaFetchCities('');
            } else if (NovaPoshtaCityList.children.length > 0) {
                NovaPoshtaCityList.classList.remove('hidden');
            }
        });

        function NovaPoshtaFetchCities(searchText) {
            fetch('/operator/orders/novaposhta/ttn/create/getCitiesByName', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ city_name: searchText })
            })
                .then(response => response.json())
                .then(data => {
                    NovaPoshtaCityList.innerHTML = '';
                    if (data[0] && data[0].Addresses) {

                        data[0].Addresses.forEach(city => {
                            if (city.SettlementTypeCode.toLowerCase().startsWith('м')) {
                                if (city.MainDescription.toLowerCase().startsWith(searchText)) {
                                    const listItem = document.createElement('li');
                                    listItem.textContent = city.MainDescription;
                                    listItem.setAttribute('data-value', city.DeliveryCity);
                                    listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                    listItem.addEventListener('click', function() {
                                        NovaPoshtaCityInput.value = city.MainDescription;
                                        cityRefHidden.value = city.DeliveryCity;
                                        NovaPoshtaCityList.classList.add('hidden');
                                        fetchWarehouses(city.DeliveryCity);
                                        warehouseSelect.removeAttribute('disabled');
                                    });
                                    NovaPoshtaCityList.appendChild(listItem);
                                }
                            }
                        });
                    }

                    if (NovaPoshtaCityList.children.length > 0) {
                        NovaPoshtaCityList.classList.remove('hidden');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function fetchWarehouses(cityRef) {
            fetch('/operator/orders/novaposhta/ttn/create/getWarehouses', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ city_ref_hidden: cityRef })
            })
                .then(response => response.json())
                .then(data => {
                    warehouseSelect.innerHTML = '<option value=""> Всі відділення </option>';

                    data.forEach(warehouse => {
                        const option = document.createElement('option');
                        option.value = warehouse.Ref;
                        option.textContent = warehouse.Description;
                        warehouseSelect.appendChild(option);
                    });

                    warehouseSelect.addEventListener('change', function() {
                        const selectedWarehouseRef = this.value;
                        senderAddress.value = selectedWarehouseRef;
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        const senderRefSelect = document.getElementById('sender_ref');
        const contactsPersonSelect = document.getElementById('contacts_person');
        const contactsPersonRefInput = document.getElementById('contacts_person_ref');

        senderRefSelect.addEventListener('change', function() {
            const senderRef = this.value;

            if (senderRef) {
                fetchContactPersons(senderRef);
            } else {
                contactsPersonSelect.innerHTML = '<option value=""> Всі довірені лиця </option>';
                contactsPersonRefInput.value = '';
            }
        });

        contactsPersonSelect.addEventListener('change', function() {
            const selectedContactPersonRef = this.value;
            contactsPersonRefInput.value = selectedContactPersonRef;
        });

        function fetchContactPersons(senderRef) {
            fetch('/operator/orders/novaposhta/ttn/create/getCounterpartyContactPersons', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ sender_ref: senderRef })
            })
                .then(response => response.json())
                .then(data => {
                    contactsPersonSelect.innerHTML = '<option value=""> Всі довірені лиця </option>';

                    data.forEach(person => {
                        const option = document.createElement('option');
                        option.value = person.Ref;
                        option.textContent = person.Description;
                        contactsPersonSelect.appendChild(option);
                        contactsPersonSelect.removeAttribute('disabled');
                    });
                })
                .catch(error => console.error('Error:', error));
        }
    });

    document.getElementById('ttnForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const csrfToken = '{{ csrf_token() }}';
        const form = event.target;
        const senderRef = form.sender_ref.value;
        const senderAddress = form.sender_address.value;
        const width = form.width.value;
        const height = form.height.value;
        const length = form.length.value;
        const weight = form.weight.value;
        const description = form.description.value;
        const deliveryId = form.delivery_id.value;
        const orderId = form.order_id.value;
        const recipientType = form.recipient_type.value;
        const cityRefHidden = form.city_ref_hidden.value;
        const contactPersonRef = form.contacts_person_ref.value;

        fetch(`/operator/orders/novaposhta/ttn/store/${deliveryId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                sender_ref: senderRef,
                order_id: orderId,
                width: width,
                length: length,
                height: height,
                weight: weight,
                description: description,
                recipient_type: recipientType,
                city_ref_hidden: cityRefHidden,
                contacts_person_ref: contactPersonRef,
                sender_address: senderAddress
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = `/operator/orders/novaposhta/thank-ttn/${orderId}`;
                } else {
                    console.error('Error:', data.message);
                }
            })
            .catch(error => console.error('There was a problem with the fetch operation:', error));
    });
</script>
