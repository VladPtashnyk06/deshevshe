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

                    <div class="mb-4">
                        <label for="address" class="block mb-2 font-bold">Адреса</label>
                        <input type="text" name="address" id="address" class="w-full border rounded px-3 py-2" value="{{ $order->delivery->address ? $order->delivery->address : 'Немає' }}">
                    </div>

                    <div class="space-y-1 relative mb-4" id="cityContainer">
                        <input type="hidden" id="cityRefHidden" name="cityRefHidden" value="{{ $order->delivery->cityRef }}">
                        <label for="cityInput" class="block font-semibold">Місто</label>
                        <input id="cityInput" name="city" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву міста" value="{{ $order->delivery->city }}">
                        <ul id="cityList" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                            <!-- Міста будуть відображені тут -->
                        </ul>
                    </div>

                    <div class="mb-4">
                        <label for="region" class="block mb-2 font-bold">Область</label>
                        <select name="region" id="region" class="w-full border rounded-md py-2 px-3">
                            @foreach($regions as $region)
                                <option value="{{ $region['Ref'] }}" {{ $region['Ref'] == $order->delivery->region ? 'selected': '' }}>{{ $region['Description'] }}</option>
                            @endforeach
                        </select>
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
        const regionSelect = document.getElementById('region');
        const cityInput = document.getElementById('cityInput');
        const cityList = document.getElementById('cityList');
        const cityRefHidden = document.getElementById('cityRefHidden');

        regionSelect.addEventListener('change', function() {
            cityInput.value = '';
            cityList.innerHTML = '';
            cityRefHidden.value = '';
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
                        // console.log(city)
                        if (city.Description.toLowerCase().startsWith(searchText)) {
                            const listItem = document.createElement('li');
                            listItem.textContent = city.Description;
                            listItem.setAttribute('data-value', city.Ref);
                            listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                            listItem.addEventListener('click', function() {
                                cityInput.value = city.Description;
                                console.log(city.Ref)
                                cityRefHidden.value = city.Ref;
                                console.log(cityRefHidden.value)
                                cityList.classList.add('hidden');
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
    });
</script>

