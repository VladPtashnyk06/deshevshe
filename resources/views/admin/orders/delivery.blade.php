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
                <input type="radio" name="delivery_location_type" value="City" checked> Місто
            </label>
        </div>
        <div>
            <label>
                <input type="radio" name="delivery_location_type" value="Village"> Село
            </label>
        </div>
    </div>

    <input type="hidden" id="region" name="region" value="{{ $order->delivery->region ? $order->delivery->region : '' }}">
    <input type="hidden" id="city_name" name="city_name" value="{{ $order->delivery->settlementType == 'місто' ? $order->delivery->settlement : '' }}">
    <input type="hidden" id="city_ref" name="city_ref" value="{{ $order->delivery->settlementType == 'місто' ? $order->delivery->settlementRef : '' }}">
    <input type="hidden" id="branch_number" name="branch_number" value="{{ $order->delivery->branchNumber ? $order->delivery->branchNumber : '' }}">
    <input type="hidden" id="branch_name" name="branch_name" value="{{ $order->delivery->branch ? $order->delivery->branch : '' }}">
    <input type="hidden" id="branch_ref" name="branch_ref" value="{{ $order->delivery->branchRef ? $order->delivery->branchRef : '' }}">
    <div id="nova_poshta_container">
        <div class="space-y-1 mb-4" id="nova_poshta_region_div">
            <label for="nova_poshta_region_ref" class="block font-semibold">Регіон / Область *</label>
            <select name="nova_poshta_region_ref" id="nova_poshta_region_ref" class="w-full border rounded-md py-2 px-3">
                <option value="">--- Виберіть ---</option>
                @foreach($novaPoshtaRegions as $region)
                    <option value="{{ $region->ref }}" {{ $order->delivery->regionRef == $region->ref ? 'selected' : '' }}>{{ $region->description }}</option>
                @endforeach
            </select>
        </div>

        <div id="nova_postha_city_and_branch">
            <div class="space-y-1 relative mb-4 inputCity" id="nova_poshta_city_div">
                <label for="nova_poshta_city_input" class="block font-semibold">Місто *</label>
                <input id="nova_poshta_city_input" name="nova_poshta_city_input" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву міста" value="{{ $order->delivery->settlementType == 'місто' ? $order->delivery->settlement : '' }}">
                <ul id="nova_poshta_city_list" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                    <!-- Міста будуть відображені тут -->
                </ul>
            </div>

            <div class="space-y-1 relative mb-4" id="nova_poshta_branch_div">
                <label for="nova_poshta_branches_input" class="block font-semibold"></label>
                <input id="nova_poshta_branches_input" name="nova_poshta_branches_input" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву відділення" value="{{ $order->delivery->branch ? $order->delivery->branch : '' }}">
                <ul id="nova_poshta_branches_list" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                    <!-- Відділення будуть відображені тут -->
                </ul>
            </div>
        </div>
    </div>

    <div id="meest_container" class="hidden">
        <div class="space-y-1 mb-4">
            <label for="meest_region_ref" class="block font-semibold">Регіон / Область</label>
            <select name="meest_region_ref" id="meest_region_ref" class="w-full border rounded-md py-2 px-3">
                <option value="">--- Виберіть ---</option>
                @foreach($meestRegions as $region)
                    <option value="{{ $region->region_id }}" {{ $order->delivery->regionRef == $region->region_id ? 'selected' : '' }}>{{ ucfirst(strtolower($region->description)) }}</option>
                @endforeach
            </select>
        </div>

        <div id="meest_city_and_branch">
            <div class="space-y-1 relative mb-4 inputCity" id="meest_city_div">
                <label for="meest_city_input" class="block font-semibold">Місто</label>
                <input id="meest_city_input" name="meest_city_input" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву міста" value="{{ $order->delivery->settlementType == 'місто' ? $order->delivery->settlement : '' }}">
                <ul id="meest_city_list" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                    <!-- Міста будуть відображені тут -->
                </ul>
            </div>

            <div class="space-y-1 relative mb-4" id="meest_branch_div">
                <label for="meest_branches_input" class="block font-semibold"></label>
                <input id="meest_branches_input" name="meest_branches_input" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву відділення" value="{{ $order->delivery->branch ? $order->delivery->branch : '' }}">
                <ul id="meest_branches_list" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                    <!-- Відділення будуть відображені тут -->
                </ul>
            </div>
        </div>
    </div>

    <div id="ukr_poshta_container" class="hidden">
        <div class="space-y-1 mb-4">
            <label for="ukr_poshta_region_ref" class="block font-semibold">Регіон / Область</label>
            <select name="ukr_poshta_region_ref" id="ukr_poshta_region_ref" class="w-full border rounded-md py-2 px-3">
                <option value="">--- Виберіть ---</option>
                @foreach($ukrPoshtaRegions as $region)
                    <option value="{{ $region->region_id }}" {{ $region->region_id == $order->delivery->regionRef ? 'selected' : ''}}>{{ ucfirst(strtolower($region->description)) }}</option>
                @endforeach
            </select>
        </div>

        <div id="ukr_postha_city_and_branch">
            <div class="space-y-1 relative mb-4 inputCity" id="ukr_poshta_city_div">
                <label for="ukr_poshta_city_input" class="block font-semibold">Місто</label>
                <input id="ukr_poshta_city_input" name="ukr_poshta_city_input" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву міста" value="{{ $order->delivery->settlementType == 'місто' ? $order->delivery->settlement : '' }}">
                <ul id="ukr_poshta_city_list" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                    <!-- Міста будуть відображені тут -->
                </ul>
            </div>

            <div class="space-y-1 relative mb-4" id="ukr_poshta_branch_div">
                <label for="ukr_poshta_branches_input" class="block font-semibold">Відділення Укр-Пошти</label>
                <input id="ukr_poshta_branches_input" name="ukr_poshta_branches_input" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву відділення" value="{{ $order->delivery->branch ? $order->delivery->branch : '' }}">
                <ul id="ukr_poshta_branches_list" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
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
            <input type="hidden" name="village_ref" id="village_ref" value="{{ ($order->delivery->settlementType !== 'місто' && $order->delivery->settlementType) ? $order->delivery->settlementRef : '' }}">
            <label for="village_input" class="block font-semibold">Село *</label>
            <input id="village_input" name="village_input" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву села" value="{{ ($order->delivery->settlementType !== 'місто' && $order->delivery->settlementType) ? $order->delivery->settlement : '' }}">
            <ul id="village_list" class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                <!-- Відділення будуть відображені тут -->
            </ul>
        </div>
    </div>
    <div class="space-y-1 mb-4" id="address_container">
        <div>
            <div class="space-y-1 relative mb-4" id="">
                <input type="hidden" name="street_ref" id="street_ref" value="{{ $order->delivery->streetRef ? $order->delivery->streetRef : '' }}">
                <label for="street_input" class="block font-semibold">Вулиця *</label>
                <input id="street_input" name="street_input" class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву вулиці" value="{{ $order->delivery->street ? $order->delivery->street : '' }}">
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
