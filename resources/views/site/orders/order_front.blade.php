<x-site-layout>
    <main class="wrapper">
        <p class="page-look d-flex"><a href="index.html">головна</a><span>/</span> <a
                href="#">кошик</a><span>/</span><span class="selected-page">оформлення замовлення</span></p>
        <div class="grid basket-grid order-grid">
            <div class="basket-main">
                <div class="head-basket order-head flex-between item-center">
                    <h1>Оформлення замовлення</h1>
                </div>
                <div class="order-block">
                    <p class="flag-order"><span>Увійдіть в акаунт,</span> щоб використовувати збережені дані і
                        відслідковувати замовлення в особистому кабінеті</p>
                    <div class="order-form">
                        <form action="#">
                            <div class="flex-between filter-header-block">
                                <h2>Ваші дані:</h2><a class="d-flex item-center" href="#"><span>очистити</span><svg
                                        fill="none" height="8" viewbox="0 0 8 8" width="8"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.99998 1.00002L1 7M0.999975 1L6.99995 6.99998" stroke="#121212"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-opacity="0.5"></path>
                                    </svg></a>
                            </div>
                            <div class="personal-form">
                                <div class="flex-between item-center form-flex">
                                    <div class="order-form-personal">
                                        <p><label for="name">Імʼя*</label></p>
                                        <p><input id="name" name="name" placeholder="Імʼя" required="" type="text"></p>
                                    </div>
                                    <div class="order-form-personal">
                                        <p><label for="lastname">Прізвище*</label></p>
                                        <p><input id="lastname" name="lastname" placeholder="Прізвище" required=""
                                                type="text"></p>
                                    </div>
                                </div>
                                <div class="flex-between item-center form-flex">
                                    <div class="order-form-personal">
                                        <p><label for="secondName">По батькові*</label></p>
                                        <p><input id="secondName" name="secondName" placeholder="По батькові"
                                                required="" type="text"></p>
                                    </div>
                                    <div class="order-form-personal">
                                        <p><label for="userPhone">Телефон*</label></p>
                                        <p><input class="inputMask" id="userPhone" name="userPhone"
                                                placeholder="Телефон" required="" type="tel"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="filter-header-block">
                                <h2>Оберіть спосіб доставки:</h2>
                                <div class="d-flex item-center post-icon">
                                    <p><label for="ukrPoshta"><input id="ukrPoshta" name="poshta" type="radio"></label>
                                    </p>
                                    <p><label for="novaPoshta"><input id="novaPoshta" name="poshta" type="radio"
                                                ></label></p>
                                    <p><label for="meest"><input id="meest" name="poshta" type="radio"></label></p>
                                </div>
                                <div class="item-center post-radio" id="novaPost">
                                    <p class="d-flex item-center"><input id="viddilenia" name="delivery_type"
                                            type="radio" value="NovaPoshta_branch"><label
                                            for="viddilenia"></label><span>Відділення</span></p>
                                    <p class="d-flex item-center"><input id="adress" name="delivery_type" type="radio"
                                            value="NovaPoshta_courier"><label for="adress"></label><span>Курʼєр</span>
                                    </p>
                                    <p class="d-flex item-center" id="postomatOption"><input id="poshtomat"
                                            name="delivery_type" type="radio" value="NovaPoshta_postomat"><label
                                            for="poshtomat"></label><span>Поштомат</span></p>
                                </div>
                                <div class="item-center post-radio" id="ukrPostRadio">
                                    <p class="d-flex item-center"><input id="viddileniaExpres" name="delivery_type"
                                            type="radio" value="UkrPoshta_exspresBranch"><label for="viddileniaExpres"></label><span>Експрес доставка у
                                            відділення</span></p>
                                    <p class="d-flex item-center"><input id="viddileniaUkr" name="delivery_type"
                                            type="radio" value="UkrPoshta_exspresCourier"><label for="viddileniaUkr"
                                            value="UkrPoshta_exspresCourier"></label><span>Доставка у відділення</span>
                                    </p>
                                    <p class="d-flex item-center" id="postomatOption"><input id="curierExpres"
                                            name="delivery_type" type="radio" value="UkrPoshta_branch"><label
                                            for="curierExpres"></label><span>Експрес доставка кур'єром</span></p>
                                    <p class="d-flex item-center" id="postomatOption"><input id="curierUkr"
                                            name="delivery_type" type="radio" value="UkrPoshta_courier"><label
                                            for="curierUkr"></label><span>Доставка кур'єром</span></p>
                                </div>
                                <div class="item-center post-radio" id="meestPostRadioBtn">
                                    <p class="d-flex item-center"><input id="meestPostRadio1" name="delivery_type"
                                            value="Meest_branch" type="radio"><label
                                            for="meestPostRadio1"></label><span>Відділення</span>
                                    </p>
                                    <p class="d-flex item-center"><input id="Meest_courier" name="delivery_type"
                                            type="radio" value="Meest_courier"><label
                                            for="Meest_courier"></label><span>Кур'єр</span></p>
                                </div>
                                <input type="hidden" name="categoryOfWarehouse" id="categoryOfWarehouse" value="Branch">
                                <div class="item-center post-radio cityVilage" id="delivery_location_type_container">
                                    <p class="d-flex item-center"><input id="city" value="City"
                                            name="delivery_location_type" type="radio"><label
                                            for="city"></label><span>Місто</span></p>
                                    <p class="d-flex item-center"><input id="vilage" value="Village"
                                            name="delivery_location_type" type="radio"><label
                                            for="vilage"></label><span>Село</span></p>
                                </div>
                                <input type="hidden" id="region" name="region" value="">
                                <input type="hidden" id="city_name" name="city_name" value="">
                                <input type="hidden" id="branch_number" name="branch_number" value="">
                                <input type="hidden" id="city_ref" name="city_ref" value="">
                                <input type="hidden" id="branch_ref" name="branch_ref" value="">
                            </div>
                            <div class="form-order-container">
                                <div id="nova_poshta_container" class="text-gray-700">
                                    <div class="space-y-1 mb-4" id="nova_poshta_region_div">
                                        <div class="grid form-post-grid" id="nova_postha_city_and_branch">
                                            <div class="select-order">
                                                <p>Регіон/Область *</p>
                                                <label for="nova_poshta_region_ref"
                                                    class="block font-semibold arrow-select">
                                                    <svg fill="none" height="7" viewbox="0 0 12 7" width="12"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M11 1L6 6L1 1" stroke="#121212" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                    <select class="select-placeholder" name="nova_poshta_region_ref"
                                                        id="nova_poshta_region_ref"
                                                        class="w-full border rounded-md py-2 px-3">
                                                        <option value="" selected>Обрати</option>
                                                        @foreach($novaPoshtaRegions as $region)
                                                            <option value="{{ $region->ref }}">{{ $region->description }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </label>
                                            </div>
                                            <div class="space-y-1 relative mb-4 inputCity" id="nova_poshta_city_div">
                                                <label for="nova_poshta_city_input" class="block font-semibold">Населений пункт*</label>
                                                <input id="nova_poshta_city_input" name="nova_poshta_city_input"
                                                    class="w-full border rounded-md py-2 px-3"
                                                    placeholder="Район">
                                                <ul id="nova_poshta_city_list"
                                                    class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                                    <!-- Міста будуть відображені тут -->
                                                </ul>
                                            </div>
                                            <div class="space-y-1 relative mb-4" id="nova_poshta_branch_div">
                                                <label for="nova_poshta_branches_input" class="block font-semibold">Відділення пошти*</label>
                                                <input id="nova_poshta_branches_input" name="nova_poshta_branches_input"
                                                    class="w-full border rounded-md py-2 px-3"
                                                    placeholder="Вулиця">
                                                <ul id="nova_poshta_branches_list"
                                                    class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                                    <!-- Відділення будуть відображені тут -->
                                                </ul>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div>
                                </div>
                                <div id="meest_container" class="hidden text-gray-700">
                                    <!-- <div class="grid form-post-grid"> -->
                                        <div class="select-order">
                                            <p>Регіон/Область*</p>
                                            <div class="space-y-1 mb-4">
                                                <label for="meest_region_ref" class="block font-semibold arrow-select">
                                                    <select name="meest_region_ref" id="meest_region_ref"
                                                        class="w-full border rounded-md py-2 px-3">
                                                        <option value="">Обрати</option>
                                                        @foreach($meestRegions as $region)
                                                            <option value="{{ $region->region_id }}">{{ strtolower($region->description) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </label>
                                            </div>
                                        </div>
                                
                                    <!-- <div id="meest_city_and_branch"> -->
                                        <div class="space-y-1 relative mb-4 inputCity" id="meest_city_div">
                                            <label for="meest_city_input" class="block font-semibold">Місто</label>
                                            <input id="meest_city_input" name="meest_city_input"
                                                class="w-full border rounded-md py-2 px-3"
                                                placeholder="Введіть назву міста">
                                            <ul id="meest_city_list"
                                                class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                                <!-- Міста будуть відображені тут -->
                                            </ul>
                                        </div>
                                        <div class="space-y-1 relative mb-4" id="meest_branch_div">
                                            <label for="meest_branches_input" class="block font-semibold"></label>
                                            <input id="meest_branches_input" name="meest_branches_input"
                                                class="w-full border rounded-md py-2 px-3"
                                                placeholder="Введіть назву відділення">
                                            <ul id="meest_branches_list"
                                                class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                                <!-- Відділення будуть відображені тут -->
                                            </ul>
                                        </div>
                                    <!-- </div> -->
                                    <!-- </div> -->
                                </div>
                                <div id="ukr_poshta_container" class="hidden text-gray-700 grid form-post-grid">
                                    <div class="space-y-1 mb-4">
                                        <label for="ukr_poshta_region_ref" class="block font-semibold">Регіон /
                                            Область</label>
                                        <select name="ukr_poshta_region_ref" id="ukr_poshta_region_ref"
                                            class="w-full border rounded-md py-2 px-3">
                                            <option value="">--- Виберіть ---</option>
                                            @foreach($ukrPoshtaRegions as $region)
                                                <option value="{{ $region->region_id }}">
                                                    {{ ucfirst(strtolower($region->description)) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="ukr_postha_city_and_branch">
                                        <div class="space-y-1 relative mb-4 inputCity" id="ukr_poshta_city_div">
                                            <label for="ukr_poshta_city_input" class="block font-semibold">Місто</label>
                                            <input id="ukr_poshta_city_input" name="ukr_poshta_city_input"
                                                class="w-full border rounded-md py-2 px-3"
                                                placeholder="Введіть назву міста">
                                            <ul id="ukr_poshta_city_list"
                                                class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                                <!-- Міста будуть відображені тут -->
                                            </ul>
                                        </div>
                                        <div class="space-y-1 relative mb-4" id="ukr_poshta_branch_div">
                                            <label for="ukr_poshta_branches_input" class="block font-semibold">Відділення
                                                Укр-Пошти</label>
                                            <input id="ukr_poshta_branches_input" name="ukr_poshta_branches_input"
                                                class="w-full border rounded-md py-2 px-3"
                                                placeholder="Введіть назву відділення">
                                            <ul id="ukr_poshta_branches_list"
                                                class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                                <!-- Відділення будуть відображені тут -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div id="delivery_location_village" class="hidden"> -->
                                    <div class="space-y-1 relative mb-4" id="delivery_location_village-district">
                                        <input type="hidden" name="district_ref" id="district_ref" value="">
                                        <label for="district_input" class="block font-semibold">Район *</label>
                                        <input id="district_input" name="district_input"
                                            class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву района">
                                        <ul id="district_list"
                                            class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                            <!-- Відділення будуть відображені тут -->
                                        </ul>
                                    </div>
                                    <div class="space-y-1 relative mb-4" id="delivery_location_village-ref">
                                        <input type="hidden" name="village_ref" id="village_ref" value="">
                                        <label for="village_input" class="block font-semibold">Село *</label>
                                        <input id="village_input" name="village_input"
                                            class="w-full border rounded-md py-2 px-3" placeholder="Введіть назву села">
                                        <ul id="village_list"
                                            class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                            <!-- Відділення будуть відображені тут -->
                                        </ul>
                                    </div>
                                <!-- </div> -->
                                <div class="space-y-1 mb-4 text-gray-700" id="address_container">
                                    <!-- <div class="grid form-post-grid"> -->
                                        <div class="space-y-1 relative mb-4" id="address_container-street">
                                            <input type="hidden" name="street_ref" id="street_ref" value="">
                                            <label for="street_input" class="block font-semibold">Вулиця *</label>
                                            <input id="street_input" name="street_input"
                                                class="w-full border rounded-md py-2 px-3"
                                                placeholder="Введіть назву вулиці">
                                            <ul id="street_list"
                                                class="absolute z-10 mt-1 bg-white border rounded-md shadow-md hidden w-full max-h-48 overflow-y-auto">
                                                <!-- Відділення будуть відображені тут -->
                                            </ul>
                                        </div>
                                        <div class="space-y-1 relative mb-4" id="address_container-build">
                                            <label for="house" class="block font-semibold">Будинок *</label>
                                            <input id="house" name="house" class="w-full border rounded-md py-2 px-3"
                                                placeholder="Введіть номер будинку">
                                        </div>
                                        <div id="address_container-kv">
                                            <label for="flat" class="block font-semibold">Квартира</label>
                                            <input type="text" id="flat" name="flat"
                                                class="w-full border rounded-md py-2 px-3">
                                        </div>
                                    <!-- </div> -->
                                </div>
                            </div>
                                <div class="filter-header-block order-checkbox">
                                    <h2>Оберіть спосіб Оплати:</h2>
                                    <p class="d-flex item-center"><input id="liqpay" name="liqpay" type="checkbox"><label
                                            for="liqpay">Liqpay одразу при оформленні замовлення</label></p>
                                    <p class="d-flex item-center"><input id="iban" name="iban" type="checkbox"><label
                                            for="iban">Оплата на рахунок (за реквізитами IBAN)</label></p>
                                    <p class="d-flex item-center"><input id="oplata3" name="oplata3" type="checkbox"><label
                                            for="oplata3">Оплата на місці (готівкою чи терміналом)</label></p>
                                    <p class="d-flex item-center"><input id="viddileniaNP" name="viddileniaNP"
                                            type="checkbox"><label for="viddileniaNP">На відділенні Нової Пошти при
                                            отриманні</label></p>
                                    <p class="d-flex item-center"><input id="PayPal" name="PayPal" type="checkbox"><label
                                            for="PayPal">PayPal</label></p>
                                </div>
                                <div class="order-checkbox callBack">
                                    <p class="d-flex item-center"><input id="callBack" name="callBack"
                                            type="checkbox"><label class="fw" for="callBack">Мені можна не телефонувати для
                                            підтвердження замовлення.</label></p>
                                </div><button class="btn-card yellow-cta order-cta-mobile" type="submit">оформити
                                    замовлення</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
            <div class="form-comment order-aside-form">
                <form action="#">
                    <div class="head-comment-form order-form-card">
                        <p>ваше замовлення</p>
                        <div class="order-succes-form">
                            <div class="flex-between item-center order-card">
                                <div class="order-descr-card">
                                    <p class="img-order">
                                        <picture><img alt="" src="img/catalog-card.png"></picture>
                                    </p>
                                    <div class="description-order">
                                        <p class="head-cart">Джинсові шорти</p>
                                        <p class="text-cart d-flex item-center"><span>Колір:</span> <span
                                                class="color-cart"></span></p>
                                        <p class="text-cart">Розмір: <span>S</span></p>
                                        <p class="text-cart">Кількість: <span>1</span></p>
                                        <div class="order-price mobile-price">
                                            <p>800₴</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="order-price desctop-price">
                                    <p>800₴</p>
                                </div>
                            </div>
                            <hr class="order-hr">
                            <div class="flex-between item-center order-card">
                                <div class="order-descr-card">
                                    <p class="img-order">
                                        <picture><img alt="" src="img/catalog-card.png"></picture>
                                    </p>
                                    <div class="description-order">
                                        <p class="head-cart">Джинсові шорти</p>
                                        <p class="text-cart d-flex item-center"><span>Колір:</span> <span
                                                class="color-cart"></span></p>
                                        <p class="text-cart">Розмір: <span>S</span></p>
                                        <p class="text-cart">Кількість: <span>1</span></p>
                                        <div class="order-price mobile-price">
                                            <p>800₴</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="order-price desctop-price">
                                    <p>800₴</p>
                                </div>
                            </div>
                            <hr class="order-hr">
                            <div class="flex-between item-center order-card">
                                <div class="order-descr-card">
                                    <p class="img-order">
                                        <picture><img alt="" src="img/catalog-card.png"></picture>
                                    </p>
                                    <div class="description-order">
                                        <p class="head-cart">Джинсові шорти</p>
                                        <p class="text-cart d-flex item-center"><span>Колір:</span> <span
                                                class="color-cart"></span></p>
                                        <p class="text-cart">Розмір: <span>S</span></p>
                                        <p class="text-cart">Кількість: <span>1</span></p>
                                        <div class="order-price mobile-price">
                                            <p>800₴</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="order-price desctop-price">
                                    <p>800₴</p>
                                </div>
                            </div>
                            <hr class="order-hr">
                            <div class="flex-between item-center order-card">
                                <div class="order-descr-card">
                                    <p class="img-order">
                                        <picture><img alt="" src="img/catalog-card.png"></picture>
                                    </p>
                                    <div class="description-order">
                                        <p class="head-cart">Джинсові шорти</p>
                                        <p class="text-cart d-flex item-center"><span>Колір:</span> <span
                                                class="color-cart"></span></p>
                                        <p class="text-cart">Розмір: <span>S</span></p>
                                        <p class="text-cart">Кількість: <span>1</span></p>
                                        <div class="order-price mobile-price">
                                            <p>800₴</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="order-price desctop-price">
                                    <p>800₴</p>
                                </div>
                            </div>
                            <hr class="order-hr">
                        </div>
                    </div>
                    <div class="sum-basket flex-between item-center">
                        <p class="text-sum">Разом:</p>
                        <p class="sum">3200₴</p>
                    </div><button class="btn-card yellow-cta order-cta-desctop" type="submit">оформити
                        замовлення</button>
                </form>
            </div>
        </div>
    </main>
</x-site-layout>