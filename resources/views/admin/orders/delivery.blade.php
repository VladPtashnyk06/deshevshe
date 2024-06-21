<input type="hidden" id="delivery_name_and_type" name="delivery_name_and_type" value="{{ $deliveryNameAndType }}">
<input type="hidden" id="delivery_location" name="delivery_location" value="{{ $deliveryLocation }}">

<div class="second">
    <h2 class="text-lg font-semibold">Спосіб доставки</h2>
    <div class="flex justify-between grid-cols-3">
        <div class="space-y-1 mb-4">
            <div class="flex">
                <img src="" alt="Лого(НП)" class="mr-4">
                <p>Нова пошта</p>
            </div>
            <div>
                <label>
                    <input type="radio" name="delivery_type" value="NovaPoshta_branch" checked> Доставка у відділення - Нова Пошта
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
    </div>

    <input type="hidden" name="categoryOfWarehouse" id="categoryOfWarehouse" value="Branch">

    <div id="delivery_location_type_container" class="flex grid grid-cols-2 justify-items-center mb-4">
        <div>
            <label>
                <input type="radio" name="delivery_location_type" value="City"> Місто
            </label>
        </div>
        <div>
            <label>
                <input type="radio" name="delivery_location_type" value="Village"> Село
            </label>
        </div>
    </div>

    <input type="hidden" id="city_name" name="city_name" value="">
    <input type="hidden" id="branch_number" name="branch_number" value="">
    <div id="nova_poshta_container">
        <div class="space-y-1 mb-4" id="nova_poshta_region_div">
            <input type="hidden" id="nova_poshta_region" name="nova_poshta_region" value="{{ $order->delivery->region ? $order->delivery->region : '' }}">
            <label for="nova_poshta_region_ref" class="block font-semibold">Регіон / Область *</label>
            <select name="nova_poshta_region_ref" id="nova_poshta_region_ref" class="w-full border rounded-md py-2 px-3">
                <option value="" selected>--- Виберіть ---</option>
                @foreach($novaPoshtaRegions as $region)
                    <option value="{{ $region['Ref'] }}" {{ $order->delivery->regionRef == $region['Ref'] ? 'selected' : '' }}>{{ $region['Description'] }}</option>
                @endforeach
            </select>
        </div>

        <div id="nova_postha_city_and_branch">
            <div class="space-y-1 relative mb-4 inputCity" id="nova_poshta_city_div">
                <input type="hidden" id="city_ref" name="city_ref" value="{{ $order->delivery->cityRef ? $order->delivery->cityRef : '' }}">
                <label for="nova_poshta_city_input" class="block font-semibold">Місто *</label>
                <input id="nova_poshta_city_input" name="nova_poshta_city_input" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву міста" value="{{ $order->delivery->city ? $order->delivery->city : '' }}">
                <ul id="nova_poshta_city_list" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                    <!-- Міста будуть відображені тут -->
                </ul>
            </div>

            <div class="space-y-1 relative mb-4" id="nova_poshta_branch_div">
                <input type="hidden" id="branch_ref" name="branch_ref" value="{{ $order->delivery->branchRef ? $order->delivery->branchRef : '' }}">
                <label for="nova_poshta_branches_input" class="block font-semibold"></label>
                <input id="nova_poshta_branches_input" name="nova_poshta_branches_input" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву відділення" value="{{ $order->delivery->branch ? $order->delivery->branch : '' }}">
                <ul id="nova_poshta_branches_list" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                    <!-- Відділення будуть відображені тут -->
                </ul>
            </div>
        </div>
    </div>

    <div id="MeestContainer" class="hidden">
        <div class="space-y-1 mb-4">
            <label for="MeestRegion" class="block font-semibold">Регіон / Область</label>
            <select name="MeestRegion" id="MeestRegion" class="w-full border rounded-md py-2 px-3">
                <option value="">--- Виберіть ---</option>
                @foreach($meestRegions as $region)
                    <option value="{{ $region['regionID'] }}" {{ $order->delivery->regionRef == $region['regionID'] ? 'selected' : '' }}>{{ ucfirst(strtolower($region['regionDescr']['descrUA'])) }}</option>
                @endforeach
            </select>
        </div>

        <div id="meest_city_and_branch">
            <div class="space-y-1 relative mb-4 inputCity" id="cityContainer">
                <input type="hidden" id="meestCityIdHidden" name="meestCityIdHidden" value="{{ $order->delivery->city ? $order->delivery->city : '' }}">
                <label for="MeestCityInput" class="block font-semibold">Місто</label>
                <input id="MeestCityInput" name="MeestCityInput" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву міста">
                <ul id="MeestCityList" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                    <!-- Міста будуть відображені тут -->
                </ul>
            </div>

            <div class="space-y-1 relative mb-4" id="MeestBranchesContainer">
                <input type="hidden" name="meestBranchIDHidden" id="meestBranchIDHidden" value="{{ $order->delivery->branch ? $order->delivery->branch : '' }}">
                <label for="MeestBranchesInput" class="block font-semibold"></label>
                <input id="MeestBranchesInput" name="MeestBranchesInput" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву відділення">
                <ul id="MeestBranchesList" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                    <!-- Відділення будуть відображені тут -->
                </ul>
            </div>
        </div>
    </div>

    <div id="UkrPoshtaContainer" class="hidden">
        <div class="space-y-1 mb-4">
            <label for="UkrPoshtaRegion" class="block font-semibold">Регіон / Область</label>
            <select name="UkrPoshtaRegion" id="UkrPoshtaRegion" class="w-full border rounded-md py-2 px-3">
                <option value="">--- Виберіть ---</option>
                @foreach($ukrPoshtaRegions as $region)
                    <option value="{{ $region['REGION_ID'] }}" {{ $region['REGION_ID'] == $order->delivery->regionRef ? 'selected' : ''}}>{{ ucfirst(strtolower($region['REGION_UA'])) }}</option>
                @endforeach
            </select>
        </div>

        <div id="ukr_postha_city_and_branch">
            <div class="space-y-1 relative mb-4 inputCity" id="UkrPoshtaCityContainer">
                <input type="hidden" id="ukrPoshtaCityIdHidden" name="ukrPoshtaCityIdHidden" value="{{ $order->delivery->city ? $order->delivery->city : '' }}">
                <label for="UkrPoshtaCityInput" class="block font-semibold">Місто</label>
                <input id="UkrPoshtaCityInput" name="UkrPoshtaCityInput" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву міста" value="{{ $order->delivery->city ? $order->delivery->city : '' }}">
                <ul id="UkrPoshtaCityList" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                    <!-- Міста будуть відображені тут -->
                </ul>
            </div>

            <div class="space-y-1 relative mb-4" id="UkrPoshtaBranchesContainer">
                <input type="hidden" name="ukrPoshtaBranchIDHidden" id="ukrPoshtaBranchIDHidden" value="{{ $order->delivery->branch ? $order->delivery->branch : '' }}">
                <label for="UkrPoshtaBranchesInput" class="block font-semibold">Відділення Укр-Пошти</label>
                <input id="UkrPoshtaBranchesInput" name="UkrPoshtaBranchesInput" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву відділення" value="{{ $order->delivery->branch ? $order->delivery->branch : '' }}">
                <ul id="UkrPoshtaBranchesList" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                    <!-- Відділення будуть відображені тут -->
                </ul>
            </div>
        </div>
    </div>

    <div id="delivery_location_village" class="hidden">
        <div class="space-y-1 relative mb-4" id="">
            <input type="hidden" name="district_ref" id="district_ref" value="{{ $order->delivery->districtRef ? $order->delivery->districtRef : '' }}">
            <label for="district_input" class="block font-semibold">Район *</label>
            <input id="district_input" name="district_input" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву района" value="{{ $order->delivery->district ? $order->delivery->district : '' }}">
            <ul id="district_list" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                <!-- Відділення будуть відображені тут -->
            </ul>
        </div>

        <div class="space-y-1 relative mb-4" id="">
            <input type="hidden" name="village_ref" id="village_ref" value="{{ $order->delivery->villageRef ? $order->delivery->villageRef : '' }}">
            <label for="village_input" class="block font-semibold">Село *</label>
            <input id="village_input" name="village_input" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву села" value="{{ $order->delivery->village ? $order->delivery->village : '' }}">
            <ul id="village_list" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                <!-- Відділення будуть відображені тут -->
            </ul>
        </div>
    </div>
    <div class="space-y-1 mb-4" id="addressContainer">
        <div>
            <div class="space-y-1 relative mb-4" id="">
                <input type="hidden" name="street_ref" id="street_ref" value="{{ $order->delivery->streetRef ? $order->delivery->streetRef : '' }}">
                <label for="street_input" class="block font-semibold">Вулиця *</label>
                <input id="street_input" name="street_input" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву вулиці" value="{{ $order->delivery->street ? (stripos($order->delivery->street, 'вул. ') === 0 ? str_replace('вул. ', '', $order->delivery->street) : $order->delivery->street) : '' }}">
                <ul id="street_list" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                    <!-- Відділення будуть відображені тут -->
                </ul>
            </div>

            <div class="space-y-1 relative mb-4" id="">
                <label for="house" class="block font-semibold">Будинок *</label>
                <input id="house" name="house" class="w-full border rounded-md py-2 px-3" placeholder="Введіть номер будинку" value="{{ $order->delivery->house ? $order->delivery->house : '' }}">
            </div>

            <div>
                <label for="flat" class="block font-semibold">Квартира</label>
                <input type="text" id="flat" name="flat" class="w-full border rounded-md py-2 px-3" value="{{ $order->delivery->flat ? $order->delivery->flat : '' }}">
            </div>
        </div>
    </div>
</div>
