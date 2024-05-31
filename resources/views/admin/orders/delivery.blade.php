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
