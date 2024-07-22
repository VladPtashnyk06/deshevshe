<x-site-layout>
    <main class="wrapper">
        <p class="page-look d-flex"><a href="index.html">головна</a><span>/</span> <a href="#">кошик</a><span>/</span><span class="selected-page">оформлення замовлення</span></p>
        <div class="grid basket-grid order-grid">
            <div class="basket-main">
                <div class="head-basket order-head flex-between item-center">
                    <h1>Оформлення замовлення</h1>
                </div>
                <div class="order-block">
                    <p class="flag-order"><span>Увійдіть в акаунт,</span> щоб використовувати збережені дані і відслідковувати замовлення в особистому кабінеті</p>
                    <div class="order-form">
                        <form action="#">
                            <div class="flex-between filter-header-block">
                                <h2>Ваші дані:</h2><a class="d-flex item-center" href="#"><span>очистити</span><svg fill="none" height="8" viewbox="0 0 8 8" width="8" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.99998 1.00002L1 7M0.999975 1L6.99995 6.99998" stroke="#121212" stroke-linecap="round" stroke-linejoin="round" stroke-opacity="0.5"></path></svg></a>
                            </div>
                            <div class="personal-form">
                                <div class="flex-between item-center form-flex">
                                    <div class="order-form-personal">
                                        <p><label for="name">Імʼя*</label></p>
                                        <p><input id="name" name="name" placeholder="Імʼя" required="" type="text"></p>
                                    </div>
                                    <div class="order-form-personal">
                                        <p><label for="lastname">Прізвище*</label></p>
                                        <p><input id="lastname" name="lastname" placeholder="Прізвище" required="" type="text"></p>
                                    </div>
                                </div>
                                <div class="flex-between item-center form-flex">
                                    <div class="order-form-personal">
                                        <p><label for="secondName">По батькові*</label></p>
                                        <p><input id="secondName" name="secondName" placeholder="По батькові" required="" type="text"></p>
                                    </div>
                                    <div class="order-form-personal">
                                        <p><label for="userPhone">Телефон*</label></p>
                                        <p><input class="inputMask" id="userPhone" name="userPhone" placeholder="Телефон" required="" type="tel"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="filter-header-block">
                                <h2>Оберіть спосіб доставки:</h2>
                                <div class="d-flex item-center post-icon">
                                    <p><label for="ukrPoshta"><input id="ukrPoshta" name="poshta" type="radio"></label></p>
                                    <p><label for="novaPoshta"><input id="novaPoshta" name="poshta" type="radio"></label></p>
                                    <p><label for="meest"><input id="meest" name="poshta" type="radio"></label></p>
                                </div>
                                <div class="item-center post-radio" id="novaPostMeest">
                                    <p class="d-flex item-center"><input id="viddilenia" name="adress" type="radio"><label for="viddilenia"></label><span>Відділення</span></p>
                                    <p class="d-flex item-center"><input id="adress" name="adress" type="radio"><label for="adress"></label><span>Курʼєр</span></p>
                                    <p class="d-flex item-center" id="postomatOption"><input id="poshtomat" name="adress" type="radio"><label for="poshtomat"></label><span>Поштомат</span></p>
                                </div>
                                <div class="item-center post-radio" id="ukrPostRadio">
                                    <p class="d-flex item-center"><input id="viddileniaExpres" name="adress" type="radio"><label for="viddileniaExpres"></label><span>Експрес доставка у відділення</span></p>
                                    <p class="d-flex item-center"><input id="viddileniaUkr" name="adress" type="radio"><label for="viddileniaUkr"></label><span>Доставка у відділення</span></p>
                                    <p class="d-flex item-center" id="postomatOption"><input id="curierExpres" name="adress" type="radio"><label for="curierExpres"></label><span>Експрес доставка кур'єром</span></p>
                                    <p class="d-flex item-center" id="postomatOption"><input id="curierUkr" name="adress" type="radio"><label for="curierUkr"></label><span>Доставка кур'єром</span></p>
                                </div>
                                <div class="item-center post-radio cityVilage" id="cityVilageOptions">
                                    <p class="d-flex item-center"><input id="city" name="cityVilage" type="radio"><label for="city"></label><span>Місто</span></p>
                                    <p class="d-flex item-center"><input id="vilage" name="cityVilage" type="radio"><label for="vilage"></label><span>Село</span></p>
                                </div>
                            </div>
                            <div class="filter-header-block" id="forCityAdress">
                                <h2>Адреса одержувача:</h2>
                                <div class="flex-between">
                                    <div class="select-order">
                                        <p>Область*</p><label class="arrow-select"><svg fill="none" height="7" viewbox="0 0 12 7" width="12" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 1L6 6L1 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path></svg><select class="select-placeholder" id="oblastAdress" name="oblast" placeholder="Область" required="">
                                                <option disabled hidden="" selected value="0">
                                                    Область
                                                </option>
                                                <option value="1">
                                                    Хмельницька
                                                </option>
                                                <option value="2">
                                                    Вінницька
                                                </option>
                                                <option value="3">
                                                    Тернопільська
                                                </option>
                                            </select></label>
                                    </div>
                                    <div class="select-order">
                                        <p>Район*</p><label class="arrow-select"><svg fill="none" height="7" viewbox="0 0 12 7" width="12" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 1L6 6L1 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path></svg><select class="select-placeholder" id="regionAdress" name="oblast" placeholder="Область" required="">
                                                <option disabled hidden="" selected value="0">
                                                    Район
                                                </option>
                                                <option value="1">
                                                    Хмельницька
                                                </option>
                                                <option value="2">
                                                    Вінницька
                                                </option>
                                                <option value="3">
                                                    Тернопільська
                                                </option>
                                            </select></label>
                                    </div>
                                </div>
                                <div class="flex-between">
                                    <div class="select-order">
                                        <p>Населений пункт*</p><label class="arrow-select"><svg fill="none" height="7" viewbox="0 0 12 7" width="12" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 1L6 6L1 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path></svg><select class="select-placeholder" id="nasPunktAdress" name="oblast" placeholder="Область" required="">
                                                <option disabled hidden="" selected value="0">
                                                    Населений пункт
                                                </option>
                                                <option value="1">
                                                    Хмельницька
                                                </option>
                                                <option value="2">
                                                    Вінницька
                                                </option>
                                                <option value="3">
                                                    Тернопільська
                                                </option>
                                            </select></label>
                                    </div>
                                    <div class="select-order">
                                        <p>Вулиця*</p><label class="arrow-select"><svg fill="none" height="7" viewbox="0 0 12 7" width="12" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 1L6 6L1 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path></svg><select class="select-placeholder" id="streetAdress" name="oblast" placeholder="Область" required="">
                                                <option disabled hidden="" selected value="0">
                                                    Вулиця
                                                </option>
                                                <option value="1">
                                                    Хмельницька
                                                </option>
                                                <option value="2">
                                                    Вінницька
                                                </option>
                                                <option value="3">
                                                    Тернопільська
                                                </option>
                                            </select></label>
                                    </div>
                                </div>
                                <div class="flex-between">
                                    <div class="select-order">
                                        <p>Номер будинку</p><label class="arrow-select"><svg fill="none" height="7" viewbox="0 0 12 7" width="12" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 1L6 6L1 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path></svg><select class="select-placeholder" id="numberHouseAdress" name="oblast" placeholder="Область" required="">
                                                <option class="gray" disabled hidden="" selected value="0">
                                                    Номер будинку
                                                </option>
                                                <option value="1">
                                                    Хмельницька
                                                </option>
                                                <option value="2">
                                                    Вінницька
                                                </option>
                                                <option value="3">
                                                    Тернопільська
                                                </option>
                                            </select></label>
                                    </div>
                                    <div class="order-form-personal form-flex">
                                        <p><label for="numbApart">Номер квартири</label></p>
                                        <p><input id="numbApart" name="numbApart" placeholder="Номер квартири" type="number"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="filter-header-block" id="forCityViddilenia">
                                <h2>Адреса одержувача:</h2>
                                <div class="grid form-post-grid">
                                    <div class="select-order">
                                        <div class="select-order"></div>
                                        <p>Регіон/Область**</p><label class="arrow-select"><svg fill="none" height="7" viewbox="0 0 12 7" width="12" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 1L6 6L1 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path></svg><select class="select-placeholder" id="oblastViddilenia" name="oblast" placeholder="Область" required="">
                                                <option disabled hidden="" selected value="0">
                                                    Область
                                                </option>
                                                <option value="1">
                                                    Хмельницька
                                                </option>
                                                <option value="2">
                                                    Вінницька
                                                </option>
                                                <option value="3">
                                                    Тернопільська
                                                </option>
                                            </select></label>
                                    </div>
                                    <div class="select-order">
                                        <p>Населений пункт*</p><label class="arrow-select"><svg fill="none" height="7" viewbox="0 0 12 7" width="12" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 1L6 6L1 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path></svg><select class="select-placeholder" id="oblastViddileniaPunkt" name="oblast" placeholder="Область" required="">
                                                <option disabled hidden="" selected value="0">
                                                    Населений пункт
                                                </option>
                                                <option value="1">
                                                    Хмельницька
                                                </option>
                                                <option value="2">
                                                    Вінницька
                                                </option>
                                                <option value="3">
                                                    Тернопільська
                                                </option>
                                            </select></label>
                                    </div>
                                    <div class="select-order">
                                        <p>Відділення пошти*</p><label class="arrow-select"><svg fill="none" height="7" viewbox="0 0 12 7" width="12" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 1L6 6L1 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path></svg><select class="select-placeholder" id="viddileniaPostCity" name="oblast" placeholder="Область" required="">
                                                <option disabled hidden="" selected value="0">
                                                    Населений пункт
                                                </option>
                                                <option value="1">
                                                    Хмельницька
                                                </option>
                                                <option value="2">
                                                    Вінницька
                                                </option>
                                            </select></label>
                                    </div>
                                </div>
                            </div>
                            <div class="filter-header-block" id="forVilage">
                                <h2>Адреса одержувача:</h2>
                                <div class="flex-between">
                                    <div class="select-order">
                                        <p>Регіон/Область**</p><label class="arrow-select"><svg fill="none" height="7" viewbox="0 0 12 7" width="12" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 1L6 6L1 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path></svg><select class="select-placeholder" id="oblastVillage" name="oblast" placeholder="Область" required="">
                                                <option disabled hidden="" selected value="0">
                                                    Область
                                                </option>
                                                <option value="1">
                                                    Хмельницька
                                                </option>
                                                <option value="2">
                                                    Вінницька
                                                </option>
                                                <option value="3">
                                                    Тернопільська
                                                </option>
                                            </select></label>
                                    </div>
                                    <div class="select-order">
                                        <p>Район*</p><label class="arrow-select"><svg fill="none" height="7" viewbox="0 0 12 7" width="12" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 1L6 6L1 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path></svg><select class="select-placeholder" id="regionVillage" name="oblast" placeholder="Область" required="">
                                                <option disabled hidden="" selected value="0">
                                                    Район
                                                </option>
                                                <option value="1">
                                                    Хмельницька
                                                </option>
                                                <option value="2">
                                                    Вінницька
                                                </option>
                                                <option value="3">
                                                    Тернопільська
                                                </option>
                                            </select></label>
                                    </div>
                                </div>
                                <div class="flex-between">
                                    <div class="select-order">
                                        <p>Село*</p><label class="arrow-select"><svg fill="none" height="7" viewbox="0 0 12 7" width="12" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 1L6 6L1 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path></svg><select class="select-placeholder" id="vilageSelect" name="oblast" placeholder="Область" required="">
                                                <option disabled hidden="" selected value="0">
                                                    Населений пункт
                                                </option>
                                                <option value="1">
                                                    Хмельницька
                                                </option>
                                                <option value="2">
                                                    Вінницька
                                                </option>
                                                <option value="3">
                                                    Тернопільська
                                                </option>
                                            </select></label>
                                    </div>
                                    <div class="select-order">
                                        <p>Відділення пошти*</p><label class="arrow-select"><svg fill="none" height="7" viewbox="0 0 12 7" width="12" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 1L6 6L1 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path></svg><select class="select-placeholder" id="oblast" name="oblast" placeholder="Область" required="">
                                                <option disabled hidden="" selected value="0">
                                                    Вулиця
                                                </option>
                                                <option value="1">
                                                    Хмельницька
                                                </option>
                                                <option value="2">
                                                    Вінницька
                                                </option>
                                                <option value="3">
                                                    Тернопільська
                                                </option>
                                            </select></label>
                                    </div>
                                </div>
                            </div>
                            <div class="filter-header-block" id="forPostomat">
                                <h2>Адреса одержувача:</h2>
                                <div class="grid form-post-grid">
                                    <div class="select-order">
                                        <p>Регіон/Область**</p><label class="arrow-select"><svg fill="none" height="7" viewbox="0 0 12 7" width="12" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 1L6 6L1 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path></svg><select class="select-placeholder" id="oblastPoshtomat" name="oblast" placeholder="Область" required="">
                                                <option disabled hidden="" selected value="0">
                                                    Область
                                                </option>
                                                <option value="1">
                                                    Хмельницька
                                                </option>
                                                <option value="2">
                                                    Вінницька
                                                </option>
                                                <option value="3">
                                                    Тернопільська
                                                </option>
                                            </select></label>
                                    </div>
                                    <div class="select-order">
                                        <p>Населений пункт*</p><label class="arrow-select"><svg fill="none" height="7" viewbox="0 0 12 7" width="12" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 1L6 6L1 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path></svg><select class="select-placeholder" id="punktPostomat" name="oblast" placeholder="Область" required="">
                                                <option disabled hidden="" selected value="0">
                                                    Район
                                                </option>
                                                <option value="1">
                                                    Хмельницька
                                                </option>
                                                <option value="2">
                                                    Вінницька
                                                </option>
                                                <option value="3">
                                                    Тернопільська
                                                </option>
                                            </select></label>
                                    </div>
                                    <div class="select-order">
                                        <p>Адреса поштомату*</p><label class="arrow-select"><svg fill="none" height="7" viewbox="0 0 12 7" width="12" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 1L6 6L1 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path></svg><select class="select-placeholder" id="postomatAdressSelect" name="oblast" placeholder="Область" required="">
                                                <option disabled hidden="" selected value="0">
                                                    вулиця
                                                </option>
                                                <option value="1">
                                                    Хмельницька
                                                </option>
                                                <option value="2">
                                                    Вінницька
                                                </option>
                                                <option value="3">
                                                    Тернопільська
                                                </option>
                                            </select></label>
                                    </div>
                                </div>
                            </div>
                            <div class="filter-header-block order-checkbox">
                                <h2>Оберіть спосіб Оплати:</h2>
                                <p class="d-flex item-center"><input id="liqpay" name="liqpay" type="checkbox"><label for="liqpay">Liqpay одразу при оформленні замовлення</label></p>
                                <p class="d-flex item-center"><input id="iban" name="iban" type="checkbox"><label for="iban">Оплата на рахунок (за реквізитами IBAN)</label></p>
                                <p class="d-flex item-center"><input id="oplata3" name="oplata3" type="checkbox"><label for="oplata3">Оплата на місці (готівкою чи терміналом)</label></p>
                                <p class="d-flex item-center"><input id="viddileniaNP" name="viddileniaNP" type="checkbox"><label for="viddileniaNP">На відділенні Нової Пошти при отриманні</label></p>
                                <p class="d-flex item-center"><input id="PayPal" name="PayPal" type="checkbox"><label for="PayPal">PayPal</label></p>
                            </div>
                            <div class="order-checkbox callBack">
                                <p class="d-flex item-center"><input id="callBack" name="callBack" type="checkbox"><label class="fw" for="callBack">Мені можна не телефонувати для підтвердження замовлення.</label></p>
                            </div><button class="btn-card yellow-cta order-cta-mobile" type="submit">оформити замовлення</button>
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
                                    <p class="img-order"><picture><img alt="" src="img/catalog-card.png"></picture></p>
                                    <div class="description-order">
                                        <p class="head-cart">Джинсові шорти</p>
                                        <p class="text-cart d-flex item-center"><span>Колір:</span> <span class="color-cart"></span></p>
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
                                    <p class="img-order"><picture><img alt="" src="img/catalog-card.png"></picture></p>
                                    <div class="description-order">
                                        <p class="head-cart">Джинсові шорти</p>
                                        <p class="text-cart d-flex item-center"><span>Колір:</span> <span class="color-cart"></span></p>
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
                                    <p class="img-order"><picture><img alt="" src="img/catalog-card.png"></picture></p>
                                    <div class="description-order">
                                        <p class="head-cart">Джинсові шорти</p>
                                        <p class="text-cart d-flex item-center"><span>Колір:</span> <span class="color-cart"></span></p>
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
                                    <p class="img-order"><picture><img alt="" src="img/catalog-card.png"></picture></p>
                                    <div class="description-order">
                                        <p class="head-cart">Джинсові шорти</p>
                                        <p class="text-cart d-flex item-center"><span>Колір:</span> <span class="color-cart"></span></p>
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
                    </div><button class="btn-card yellow-cta order-cta-desctop" type="submit">оформити замовлення</button>
                </form>
            </div>
        </div>
    </main>
</x-site-layout>
