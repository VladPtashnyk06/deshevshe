<x-site-layout>
    <main class="wrapper">
        <div class="d-flex flex-arrow">
            <a class="arrow-up arrow" href="#body">
                <svg fill="none" height="10" viewbox="0 0 18 10" width="18" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 9L9 0.999999L17 9" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
            </a>
            <a class="arrow-down arrow" href="#footer">
                <svg fill="none" height="10" viewbox="0 0 18 10" width="18" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 0.999999L9 9L17 1" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
            </a>
        </div>
        <p class="page-look d-flex">
            <a href="{{ route('site.index') }}">головна</a>
            <span>/</span>
            <a href="#">особистий кабінет</a>
            <span>/</span>
            <span class="selected-page">профіль</span>
        </p>
        <div class="help-page cabinet-page">
            <div class="help-menu">
                <h1>особистий кабінет</h1>
                <ul class="menu-help-item menu-cabinet-item">
                    <li>
                        <a class="active-cta-help" data-href="profile" href="javascript:void(0)"><span>Профіль</span><svg fill="none" height="12" viewbox="0 0 7 12" width="7" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L6 6L1 11" stroke="#214498" stroke-linecap="round" stroke-linejoin="round"></path></svg></a>
                    </li>
                    <li>
                        <a data-href="mySale" href="javascript:void(0)"><span>Мої знижки</span><svg fill="none" height="12" viewbox="0 0 7 12" width="7" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L6 6L1 11" stroke="#214498" stroke-linecap="round" stroke-linejoin="round"></path></svg></a>
                    </li>
                    <li>
                        <a class="cartCabinet" data-href="cartCabinet" href="javascript:void(0)"><span>Кошик</span><svg fill="none" height="12" viewbox="0 0 7 12" width="7" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L6 6L1 11" stroke="#214498" stroke-linecap="round" stroke-linejoin="round"></path></svg></a>
                    </li>
                    <li>
                        <a data-href="listOrder" href="javascript:void(0)"><span>Список замовлень</span><svg fill="none" height="12" viewbox="0 0 7 12" width="7" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L6 6L1 11" stroke="#214498" stroke-linecap="round" stroke-linejoin="round"></path></svg></a>
                    </li>
                    <li>
                        <a data-href="myReturn" href="javascript:void(0)"><span>Мої повернення</span><svg fill="none" height="12" viewbox="0 0 7 12" width="7" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L6 6L1 11" stroke="#214498" stroke-linecap="round" stroke-linejoin="round"></path></svg></a>
                    </li>
                    <li>
                        <a data-href="myLikeProduct" href="javascript:void(0)"><span>Вподобані товари</span><svg fill="none" height="12" viewbox="0 0 7 12" width="7" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L6 6L1 11" stroke="#214498" stroke-linecap="round" stroke-linejoin="round"></path></svg></a>
                    </li>
                </ul>
            </div>
            <section class="about-us-block active-help help-content cabinet-section" id="profile">
                <div class="description-about-us">
                    <h2>Ваші дані:</h2>
                    <div class="order-form">
                        <form action="#">
                            <div class="personal-form">
                                <div class="flex-between item-center form-flex">
                                    <div class="order-form-personal">
                                        <p><label for="lastname">Прізвище*</label></p>
                                        <p><input id="lastname" name="lastname" placeholder="Прізвище" required="" type="text" value="{{ Auth::user()->last_name ?? '' }}"></p>
                                    </div>
                                    <div class="order-form-personal">
                                        <p><label for="userPhone">Телефон*</label></p>
                                        <p><input id="userPhone" name="userPhone" placeholder="Телефон" required="" type="tel" value="{{ Auth::user()->phone ?? '' }}"></p>
                                    </div>
                                </div>
                                <div class="flex-between item-center form-flex">
                                    <div class="order-form-personal">
                                        <p><label for="nameProfile">Імʼя*</label></p>
                                        <p><input id="nameProfile" name="nameProfile" placeholder="Імʼя" required="" type="text" value="{{ Auth::user()->name ?? '' }}"></p>
                                    </div>
                                    <div class="order-form-personal">
                                        <p><label for="emailProfile">E-mail*</label></p>
                                        <p><input id="emailProfile" name="emailProfile" placeholder="Ваш e-mail" required="" type="email" value="{{ Auth::user()->email ?? '' }}"></p>
                                    </div>
                                </div>
                                <div class="flex-between item-center form-flex">
                                    <div class="order-form-personal">
                                        <p><label for="secondNameProfile">По батькові*</label></p>
                                        <p><input id="secondNameProfile" name="secondNameProfile" placeholder="По батькові" required="" type="text" value="{{ Auth::user()->middle_name ?? '' }}"></p>
                                    </div>
                                    <div class="order-form-personal">
                                        <p><label for="dateBorn">День народження</label></p>
                                        <p><input id="dateBorn" name="dateBorn" placeholder="День народження" required="" type="text"></p>
                                    </div>
                                </div>
                            </div>
                            <h2>Доставка:</h2>
                            <div class="d-flex item-center post-icon">
                                <p><label for="ukrPoshta"><input id="ukrPoshta" name="poshta" type="radio"></label></p>
                                <p><label for="novaPoshta"><input id="novaPoshta" name="poshta" type="radio"></label></p>
                                <p><label for="meest"><input id="meest" name="poshta" type="radio"></label></p>
                            </div>
                            <div class="flex-between post-cabinet">
                                <div class="select-order">
                                    <p>Регіон/Область**</p>
                                    <label class="arrow-select">
                                        <svg fill="none" height="7" viewbox="0 0 12 7" width="12" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11 1L6 6L1 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                        <select class="select-placeholder" id="oblastVillage" name="oblast" placeholder="Область" required="">
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
                                        </select>
                                    </label>
                                </div>
                                <div class="select-order">
                                    <p>Район*</p>
                                    <label class="arrow-select">
                                        <svg fill="none" height="7" viewbox="0 0 12 7" width="12" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11 1L6 6L1 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                        <select class="select-placeholder" id="regionVillage" name="oblast" placeholder="Область" required="">
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
                                        </select>
                                    </label>
                                </div>
                            </div>
                            <div class="flex-between post-cabinet">
                                <div class="select-order">
                                    <p>Село*</p>
                                    <label class="arrow-select"><svg fill="none" height="7" viewbox="0 0 12 7" width="12" xmlns="http://www.w3.org/2000/svg">
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
                                        </select>
                                    </label>
                                </div>
                                <div class="select-order">
                                    <p>Відділення пошти*</p>
                                    <label class="arrow-select">
                                        <svg fill="none" height="7" viewbox="0 0 12 7" width="12" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11 1L6 6L1 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg><select class="select-placeholder" id="oblast" name="oblast" placeholder="Область" required="">
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
                                        </select>
                                    </label>
                                </div>
                            </div>
                        </form>
                        <p class="flag-help flag-order flag-cabinet">Дякуємо за реєстрацію!</p>
                    </div>
                </div>
            </section>
            <section class="help-content cabinet-section" id="mySale">
                <div class="cabinet-sale">
                    <div class="description-about-us">
                        <h2>Мої знижки</h2>
                        @if(Auth::user()->promocodes()->count() > 0)
                            @foreach(Auth::user()->promocodes()->get() as $promocode)
                                <p class="flag-help flag-order sale-flag">Введіть {{ $promocode->title .' і отримаєте знижку на '. $promocode->rate }}%</p>
                            @endforeach
                        @else
                            <p class="flag-help flag-order sale-flag">Знижок поки що немає.</p>
                        @endif
                    </div>
                </div>
            </section>
            <section class="help-content cabinet-section" id="cartCabinet">
                <div class="cabinet-cart basket-main cabinet-cart-product">
                    <div class="description-about-us head-basket flex-between item-center">
                        <h2>кошик</h2>
                        <p class="text-cart">4 товари</p>
                    </div>
                    <div class="bascket-card item-center">
                        <button class="delete-cart-product text-cart d-flex item-center">
                            <span>видалити</span>
                            <svg fill="none" height="8" viewbox="0 0 8 8" width="8" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.99998 1.00002L1 7M0.999975 1L6.99995 6.99998" stroke="#121212" stroke-linecap="round" stroke-linejoin="round" stroke-opacity="0.5"></path>
                            </svg>
                        </button>
                        <div class="img-cart">
                            <picture><img alt="" src="img/catalog-card.png"></picture>
                        </div>
                        <div class="description-cart">
                            <p class="head-cart">Джинсові шорти</p>
                            <p class="text-cart">Артикул: <span>83635337</span></p>
                            <p class="text-cart d-flex item-center"><span>Колір:</span> <span class="color-cart"></span></p>
                            <p class="text-cart">Розмір: <span>S</span></p>
                            <div class="price-cart mobile-price">
                                <p class="text-cart">Ціна:<span class="price-cart-text">800₴</span></p>
                            </div>
                        </div>
                        <div class="count-cart">
                            <p class="d-flex text-cart item-center">
                                <span>Кількість:</span>
                                <a class="min" href="#">
                                    <svg fill="none" height="3" viewbox="0 0 8 3" width="8" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 2.036V0.964001H8V2.036H0Z" fill="black"></path>
                                    </svg>
                                </a>
                                <input class="number" min="1" type="number" value="1">
                                <a class="max" href="#">
                                    <svg fill="none" height="7" viewbox="0 0 8 7" width="8" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.912 7.004V-0.0039978H4.256V7.004H2.912ZM0 4.14V2.876H7.168V4.14H0Z" fill="black"></path>
                                    </svg>
                                </a>
                            </p>
                        </div>
                        <div class="price-cart desctop-price">
                            <p class="text-cart">Ціна:<span class="price-cart-text">800₴</span></p>
                        </div>
                        <div class="sum-cart">
                            <p class="text-cart">Сума:<span class="price-cart-text">800₴</span></p>
                        </div>
                    </div>
                    <div class="bascket-card item-center">
                        <button class="delete-cart-product text-cart d-flex item-center"><span>видалити</span>
                            <svg fill="none" height="8" viewbox="0 0 8 8" width="8" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.99998 1.00002L1 7M0.999975 1L6.99995 6.99998" stroke="#121212" stroke-linecap="round" stroke-linejoin="round" stroke-opacity="0.5"></path>
                            </svg>
                        </button>
                        <div class="img-cart">
                            <picture><img alt="" src="img/catalog-card.png"></picture>
                        </div>
                        <div class="description-cart">
                            <p class="head-cart">Джинсові шорти</p>
                            <p class="text-cart">Артикул: <span>83635337</span></p>
                            <p class="text-cart d-flex item-center"><span>Колір:</span> <span class="color-cart"></span></p>
                            <p class="text-cart">Розмір: <span>S</span></p>
                            <div class="price-cart mobile-price">
                                <p class="text-cart">Ціна:<span class="price-cart-text">800₴</span></p>
                            </div>
                        </div>
                        <div class="count-cart">
                            <p class="d-flex text-cart item-center"><span>Кількість:</span>
                                <a class="min" href="#">
                                    <svg fill="none" height="3" viewbox="0 0 8 3" width="8" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 2.036V0.964001H8V2.036H0Z" fill="black"></path>
                                    </svg>
                                </a>
                                <input class="number" min="1" type="number" value="1">
                                <a class="max" href="#">
                                    <svg fill="none" height="7" viewbox="0 0 8 7" width="8" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.912 7.004V-0.0039978H4.256V7.004H2.912ZM0 4.14V2.876H7.168V4.14H0Z" fill="black"></path>
                                    </svg>
                                </a>
                            </p>
                        </div>
                        <div class="price-cart desctop-price">
                            <p class="text-cart">Ціна:<span class="price-cart-text">800₴</span></p>
                        </div>
                        <div class="sum-cart">
                            <p class="text-cart">Сума:<span class="price-cart-text">800₴</span></p>
                        </div>
                    </div>
                    <div class="bascket-card item-center">
                        <button class="delete-cart-product text-cart d-flex item-center"><span>видалити</span>
                            <svg fill="none" height="8" viewbox="0 0 8 8" width="8" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.99998 1.00002L1 7M0.999975 1L6.99995 6.99998" stroke="#121212" stroke-linecap="round" stroke-linejoin="round" stroke-opacity="0.5"></path>
                            </svg>
                        </button>
                        <div class="img-cart">
                            <picture><img alt="" src="img/catalog-card.png"></picture>
                        </div>
                        <div class="description-cart">
                            <p class="head-cart">Джинсові шорти</p>
                            <p class="text-cart">Артикул: <span>83635337</span></p>
                            <p class="text-cart d-flex item-center"><span>Колір:</span> <span class="color-cart"></span></p>
                            <p class="text-cart">Розмір: <span>S</span></p>
                            <div class="price-cart mobile-price">
                                <p class="text-cart">Ціна:<span class="price-cart-text">800₴</span></p>
                            </div>
                        </div>
                        <div class="count-cart">
                            <p class="d-flex text-cart item-center"><span>Кількість:</span>
                                <a class="min" href="#">
                                    <svg fill="none" height="3" viewbox="0 0 8 3" width="8" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 2.036V0.964001H8V2.036H0Z" fill="black"></path>
                                    </svg>
                                </a>
                                <input class="number" min="1" type="number" value="1">
                                <a class="max" href="#">
                                    <svg fill="none" height="7" viewbox="0 0 8 7" width="8" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.912 7.004V-0.0039978H4.256V7.004H2.912ZM0 4.14V2.876H7.168V4.14H0Z" fill="black"></path>
                                    </svg>
                                </a>
                            </p>
                        </div>
                        <div class="price-cart desctop-price">
                            <p class="text-cart">Ціна:<span class="price-cart-text">800₴</span></p>
                        </div>
                        <div class="sum-cart">
                            <p class="text-cart">Сума:<span class="price-cart-text">800₴</span></p>
                        </div>
                    </div>
                    <div class="bascket-card item-center">
                        <button class="delete-cart-product text-cart d-flex item-center"><span>видалити</span>
                            <svg fill="none" height="8" viewbox="0 0 8 8" width="8" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.99998 1.00002L1 7M0.999975 1L6.99995 6.99998" stroke="#121212" stroke-linecap="round" stroke-linejoin="round" stroke-opacity="0.5"></path>
                            </svg>
                        </button>
                        <div class="img-cart">
                            <picture><img alt="" src="img/catalog-card.png"></picture>
                        </div>
                        <div class="description-cart">
                            <p class="head-cart">Джинсові шорти</p>
                            <p class="text-cart">Артикул: <span>83635337</span></p>
                            <p class="text-cart d-flex item-center"><span>Колір:</span> <span class="color-cart"></span></p>
                            <p class="text-cart">Розмір: <span>S</span></p>
                            <div class="price-cart mobile-price">
                                <p class="text-cart">Ціна:<span class="price-cart-text">800₴</span></p>
                            </div>
                        </div>
                        <div class="count-cart">
                            <p class="d-flex text-cart item-center"><span>Кількість:</span>
                                <a class="min" href="#"><svg fill="none" height="3" viewbox="0 0 8 3" width="8" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 2.036V0.964001H8V2.036H0Z" fill="black"></path>
                                    </svg>
                                </a>
                                <input class="number" min="1" type="number" value="1"> <a class="max" href="#">
                                    <svg fill="none" height="7" viewbox="0 0 8 7" width="8" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.912 7.004V-0.0039978H4.256V7.004H2.912ZM0 4.14V2.876H7.168V4.14H0Z" fill="black"></path>
                                    </svg>
                                </a>
                            </p>
                        </div>
                        <div class="price-cart desctop-price">
                            <p class="text-cart">Ціна:<span class="price-cart-text">800₴</span></p>
                        </div>
                        <div class="sum-cart">
                            <p class="text-cart">Сума:<span class="price-cart-text">800₴</span></p>
                        </div>
                    </div>
                    <div class="cta-cabinet-cart">
                        <button class="btn-card yellow-cta basket-cta" type="submit">оформити замовлення</button>
                    </div>
                </div>
            </section>
            <section class="help-content cabinet-section" id="listOrder">
                <div class="description-about-us">
                    <h2>Список замовлень</h2>
                    <div class="table-cabinet">
                        <table>
                            <thead>
                            <tr>
                                <th>дата</th>
                                <th>номер</th>
                                <th>ТТН</th>
                                <th>сума</th>
                                <th>повернення</th>
                                <th>сума знижок</th>
                                <th>стан</th>
                                <th>стан оплати</th>
                                <th>дії</th>
                                <th>промо акція</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach(Auth::user()->orders()->get() as $order)
                                    <tr>
                                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->int_doc_number }}</td>
                                        <td>{{ $order->status }}</td>
                                        <td>–</td>
                                        <td>120₴</td>
                                        <td>120₴</td>
                                        <td>відхилено</td>
                                        <td>–</td>
                                        <td>–</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            <section class="help-content cabinet-section" id="myReturn">
                <div class="description-about-us">
                    <h2>Мої повернення</h2>
                    <p class="text-cart text-return">4 товари</p>
                    <div class="table-cabinet table-return">
                        <table>
                            <thead>
                                <tr>
                                    <th>дата</th>
                                    <th>повернення до замовлення</th>
                                    <th>кількість</th>
                                    <th>сума повернення</th>
                                    <th>дії</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>09/12/2023</td>
                                    <td>4647</td>
                                    <td>1</td>
                                    <td>990₴</td>
                                    <td>повернено</td>
                                </tr>
                                <tr>
                                    <td>09/12/2023</td>
                                    <td>4647</td>
                                    <td>1</td>
                                    <td>990₴</td>
                                    <td>повернено</td>
                                </tr>
                                <tr>
                                    <td>09/12/2023</td>
                                    <td>4647</td>
                                    <td>1</td>
                                    <td>990₴</td>
                                    <td>повернено</td>
                                </tr>
                                <tr>
                                    <td>09/12/2023</td>
                                    <td>4647</td>
                                    <td>1</td>
                                    <td>990₴</td>
                                    <td>повернено</td>
                                </tr>
                                <tr class="footer-table">
                                    <td>всього</td>
                                    <td></td>
                                    <td>4</td>
                                    <td>3960₴</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            <section class="help-content cabinet-section" id="myLikeProduct">
                <div class="description-about-us cabinet-like-description">
                    <h2>Вподобані товари</h2>
                    <div class="full-like-product">
                        <div class="top-prodaz-cabinetLike">
                            <figure class="card">
                                <a href="card.html"></a>
                                <figcaption>
                                    <div class="card-view-block item-center">
                                        <div class="main-info-card item-center">
                                            <div class="image-block-card">
                                                <span class="flag"><span>new</span></span>
                                                <picture><img alt="" src="img/catalog-card.png"></picture>
                                            </div>
                                            <div class="haracteristic-block-card">
                                                <div class="hover-card">
                                                    <h3>Шорти джинсові жіночі, колір блакитний</h3>
                                                    <form action="#">
                                                        <div class="color d-flex item-center">
                                                            <label>
                                                                <input name="color" type="radio" value="black">
                                                            </label>
                                                            <label>
                                                                <input disabled name="color" type="radio" value="red">
                                                            </label>
                                                            <label>
                                                                <input name="color" type="radio" value="blue">
                                                            </label>
                                                            <label>
                                                                <input disabled name="color" type="radio" value="gray">
                                                            </label>
                                                            <label>
                                                                <input name="color" type="radio" value="white">
                                                            </label>
                                                        </div>
                                                    </form>
                                                    <p class="article">Артикул: 83635337</p>
                                                </div>
                                                <form action="#">
                                                    <div class="size d-flex item-center">
                                                        <p><input id="xs" name="size" type="radio"><label for="xs">xs</label></p>
                                                        <p><input id="s" name="size" type="radio"><label for="s">s</label></p>
                                                        <p><input id="m" name="size" type="radio"><label for="m">m</label></p>
                                                        <p><input id="l" name="size" type="radio"><label for="l">l</label></p>
                                                        <p><input id="xl" name="size" type="radio"><label for="xl">xl</label></p>
                                                        <p><input id="xxl" name="size" type="radio"><label for="xxl">xxl</label></p>
                                                    </div>
                                                    <p class="d-flex price-block item-center"><span class="price">800₴</span><span class="old-price">1200₴</span></p>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="btn-like">
                                            <div class="btn-view-block d-flex">
                                                <button class="blue-btn submit-btn orderCtaCard" type="submit">купити</button>
                                                <button class="oneClickBtn" title="Купити в 1 клік" type="submit">
                                                    <svg style="enable-background:new 0 0 15 15;" version="1.1" viewbox="0 0 17 17" x="0px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" y="0px">
                                                        <g>
                                                            <g>
                                                                <path class="st0" d="M6.9,0.5c-0.1-0.1-0.2-0.1-0.4,0c-0.1,0-0.1,0.1-0.2,0.1H7C7,0.5,7,0.5,6.9,0.5z"></path>
                                                                <path class="st0" d="M7.2,1.3l-1.6,5C5.5,6.5,5.3,6.7,5.1,6.7c-0.1,0-0.1,0-0.2,0l-0.1,0v0C4.6,6.5,4.5,6.1,4.6,5.8l1.6-5 c0-0.1,0.1-0.2,0.2-0.3H7C7.2,0.7,7.3,1,7.2,1.3z"></path>
                                                            </g>
                                                            <g>
                                                                <path class="st0" d="M8.5,0.4c-0.1,0-0.3,0-0.4,0c0,0-0.1,0-0.1,0.1h0.7C8.6,0.5,8.5,0.5,8.5,0.4z"></path>
                                                                <path class="st0" d="M10.1,6.6c0,0-0.1,0.1-0.2,0.1c-0.2,0-0.4-0.2-0.5-0.4l-1.6-5C7.7,1,7.8,0.7,8,0.5h0.7 c0.1,0.1,0.1,0.2,0.2,0.3l1.6,5C10.5,6.1,10.4,6.5,10.1,6.6z"></path>
                                                            </g>
                                                            <g>
                                                                <path class="st0" d="M14.6,6v0.8c0,0.2,0,0.4-0.1,0.6C14.3,7.7,14,8,13.6,8.2c-0.4,0.1-1.6,0.1-2.3,0.1H2.6l0.7,4.9 c0,0.2,0.2,0.4,0.5,0.4h4.6c0.1,0.4,0.3,0.7,0.5,1c0,0,0.1,0.1,0.1,0.1H3.8c-0.2,0-0.5,0-0.7-0.1c-0.5-0.2-0.9-0.7-1-1.2L1.4,8.2 C1,8,0.7,7.7,0.5,7.4C0.5,7.2,0.4,7,0.4,6.8V6c0-0.2,0-0.4,0.1-0.6c0.2-0.5,0.8-0.8,1.4-0.8h1.9c0.3,0,0.6,0.2,0.6,0.5 c0,0.3-0.3,0.6-0.6,0.6H1.9C1.8,5.7,1.6,5.8,1.6,6v0.8c0,0.2,0.2,0.3,0.3,0.3h11.1c0.2,0,0.3-0.1,0.3-0.3V6c0-0.1-0.2-0.3-0.3-0.3 h-1.9c-0.3,0-0.6-0.2-0.6-0.6c0-0.3,0.3-0.5,0.6-0.5h1.9c0.6,0,1.2,0.3,1.4,0.8C14.5,5.6,14.6,5.8,14.6,6z"></path>
                                                                <path class="st0" d="M8,10.1v2.5c0,0.3-0.2,0.6-0.5,0.6S7,12.9,7,12.6v-2.5c0-0.3,0.2-0.6,0.5-0.6S8,9.7,8,10.1z"></path>
                                                                <path class="st0" d="M6,10.1v2.5c0,0.3-0.2,0.6-0.5,0.6S5,12.9,5,12.6v-2.5c0-0.3,0.2-0.6,0.5-0.6S6,9.7,6,10.1z"></path>
                                                            </g>
                                                        </g>
                                                        <path class="st0" d="M12.2,15.7c-1.9,0-3.5-1.6-3.5-3.5s1.6-3.5,3.5-3.5s3.5,1.6,3.5,3.5S14.2,15.7,12.2,15.7z M12.2,9.2 c-1.7,0-3,1.4-3,3s1.4,3,3,3s3-1.4,3-3S13.9,9.2,12.2,9.2z"></path>
                                                        <g>
                                                            <path class="st0" d="M12.4,10.7V12h1.2v0.3h-1.2v1.3H12v-1.3h-1.2V12H12v-1.3H12.4z"></path>
                                                        </g>
                                                    </svg>
                                                </button>
                                            </div>
                                            <button class="transparent-cta submit-btn delete-cta" type="submit"><span>видалити</span>
                                                <svg fill="none" height="12" viewbox="0 0 12 12" width="12" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11 1.00004L1 11M0.999958 1L10.9999 11" stroke stroke-linecap="round" stroke-linejoin="round" stroke-opacity></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </figcaption>
                            </figure>
                            <figure class="card">
                                <a href="card.html"></a>
                                <figcaption>
                                    <div class="card-view-block item-center">
                                        <div class="main-info-card item-center">
                                            <div class="image-block-card">
                                                <span class="flag"><span>new</span></span> <picture><img alt="" src="img/catalog-card.png"></picture>
                                            </div>
                                            <div class="haracteristic-block-card">
                                                <div class="hover-card">
                                                    <h3>Шорти джинсові жіночі, колір блакитний</h3>
                                                    <form action="#">
                                                        <div class="color d-flex item-center">
                                                            <label><input name="color" type="radio" value="black"></label>
                                                            <label><input disabled name="color" type="radio" value="red"></label>
                                                            <label><input name="color" type="radio" value="blue"></label>
                                                            <label><input disabled name="color" type="radio" value="gray"></label>
                                                            <label><input name="color" type="radio" value="white"></label>
                                                        </div>
                                                    </form>
                                                    <p class="article">Артикул: 83635337</p>
                                                </div>
                                                <form action="#">
                                                    <div class="size d-flex item-center">
                                                        <p><input id="xs" name="size" type="radio"><label for="xs">xs</label></p>
                                                        <p><input id="s" name="size" type="radio"><label for="s">s</label></p>
                                                        <p><input id="m" name="size" type="radio"><label for="m">m</label></p>
                                                        <p><input id="l" name="size" type="radio"><label for="l">l</label></p>
                                                        <p><input id="xl" name="size" type="radio"><label for="xl">xl</label></p>
                                                        <p><input id="xxl" name="size" type="radio"><label for="xxl">xxl</label></p>
                                                    </div>
                                                    <p class="d-flex price-block item-center"><span class="price">800₴</span><span class="old-price">1200₴</span></p>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="btn-like">
                                            <div class="btn-view-block d-flex">
                                                <button class="blue-btn submit-btn orderCtaCard" type="submit">купити</button>
                                                <button class="oneClickBtn" title="Купити в 1 клік" type="submit">
                                                    <svg style="enable-background:new 0 0 15 15;" version="1.1" viewbox="0 0 17 17" x="0px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" y="0px">
                                                        <g>
                                                            <g>
                                                                <path class="st0" d="M6.9,0.5c-0.1-0.1-0.2-0.1-0.4,0c-0.1,0-0.1,0.1-0.2,0.1H7C7,0.5,7,0.5,6.9,0.5z"></path>
                                                                <path class="st0" d="M7.2,1.3l-1.6,5C5.5,6.5,5.3,6.7,5.1,6.7c-0.1,0-0.1,0-0.2,0l-0.1,0v0C4.6,6.5,4.5,6.1,4.6,5.8l1.6-5 c0-0.1,0.1-0.2,0.2-0.3H7C7.2,0.7,7.3,1,7.2,1.3z"></path>
                                                            </g>
                                                            <g>
                                                                <path class="st0" d="M8.5,0.4c-0.1,0-0.3,0-0.4,0c0,0-0.1,0-0.1,0.1h0.7C8.6,0.5,8.5,0.5,8.5,0.4z"></path>
                                                                <path class="st0" d="M10.1,6.6c0,0-0.1,0.1-0.2,0.1c-0.2,0-0.4-0.2-0.5-0.4l-1.6-5C7.7,1,7.8,0.7,8,0.5h0.7 c0.1,0.1,0.1,0.2,0.2,0.3l1.6,5C10.5,6.1,10.4,6.5,10.1,6.6z"></path>
                                                            </g>
                                                            <g>
                                                                <path class="st0" d="M14.6,6v0.8c0,0.2,0,0.4-0.1,0.6C14.3,7.7,14,8,13.6,8.2c-0.4,0.1-1.6,0.1-2.3,0.1H2.6l0.7,4.9 c0,0.2,0.2,0.4,0.5,0.4h4.6c0.1,0.4,0.3,0.7,0.5,1c0,0,0.1,0.1,0.1,0.1H3.8c-0.2,0-0.5,0-0.7-0.1c-0.5-0.2-0.9-0.7-1-1.2L1.4,8.2 C1,8,0.7,7.7,0.5,7.4C0.5,7.2,0.4,7,0.4,6.8V6c0-0.2,0-0.4,0.1-0.6c0.2-0.5,0.8-0.8,1.4-0.8h1.9c0.3,0,0.6,0.2,0.6,0.5 c0,0.3-0.3,0.6-0.6,0.6H1.9C1.8,5.7,1.6,5.8,1.6,6v0.8c0,0.2,0.2,0.3,0.3,0.3h11.1c0.2,0,0.3-0.1,0.3-0.3V6c0-0.1-0.2-0.3-0.3-0.3 h-1.9c-0.3,0-0.6-0.2-0.6-0.6c0-0.3,0.3-0.5,0.6-0.5h1.9c0.6,0,1.2,0.3,1.4,0.8C14.5,5.6,14.6,5.8,14.6,6z"></path>
                                                                <path class="st0" d="M8,10.1v2.5c0,0.3-0.2,0.6-0.5,0.6S7,12.9,7,12.6v-2.5c0-0.3,0.2-0.6,0.5-0.6S8,9.7,8,10.1z"></path>
                                                                <path class="st0" d="M6,10.1v2.5c0,0.3-0.2,0.6-0.5,0.6S5,12.9,5,12.6v-2.5c0-0.3,0.2-0.6,0.5-0.6S6,9.7,6,10.1z"></path>
                                                            </g>
                                                        </g>
                                                        <path class="st0" d="M12.2,15.7c-1.9,0-3.5-1.6-3.5-3.5s1.6-3.5,3.5-3.5s3.5,1.6,3.5,3.5S14.2,15.7,12.2,15.7z M12.2,9.2 c-1.7,0-3,1.4-3,3s1.4,3,3,3s3-1.4,3-3S13.9,9.2,12.2,9.2z"></path>
                                                        <g>
                                                            <path class="st0" d="M12.4,10.7V12h1.2v0.3h-1.2v1.3H12v-1.3h-1.2V12H12v-1.3H12.4z"></path>
                                                        </g>
                                                    </svg>
                                                </button>
                                            </div>
                                            <button class="transparent-cta submit-btn delete-cta" type="submit"><span>видалити</span>
                                                <svg fill="none" height="12" viewbox="0 0 12 12" width="12" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11 1.00004L1 11M0.999958 1L10.9999 11" stroke stroke-linecap="round" stroke-linejoin="round" stroke-opacity></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </figcaption>
                            </figure>
                            <figure class="card">
                                <a href="card.html"></a>
                                <figcaption>
                                    <div class="card-view-block item-center">
                                        <div class="main-info-card item-center">
                                            <div class="image-block-card">
                                                <span class="flag"><span>new</span></span> <picture><img alt="" src="img/catalog-card.png"></picture>
                                            </div>
                                            <div class="haracteristic-block-card">
                                                <div class="hover-card">
                                                    <h3>Шорти джинсові жіночі, колір блакитний</h3>
                                                    <form action="#">
                                                        <div class="color d-flex item-center">
                                                            <label><input name="color" type="radio" value="black"></label>
                                                            <label><input disabled name="color" type="radio" value="red">
                                                            </label><label><input name="color" type="radio" value="blue">
                                                            </label><label><input disabled name="color" type="radio" value="gray"></label>
                                                            <label><input name="color" type="radio" value="white"></label>
                                                        </div>
                                                    </form>
                                                    <p class="article">Артикул: 83635337</p>
                                                </div>
                                                <form action="#">
                                                    <div class="size d-flex item-center">
                                                        <p><input id="xs" name="size" type="radio"><label for="xs">xs</label></p>
                                                        <p><input id="s" name="size" type="radio"><label for="s">s</label></p>
                                                        <p><input id="m" name="size" type="radio"><label for="m">m</label></p>
                                                        <p><input id="l" name="size" type="radio"><label for="l">l</label></p>
                                                        <p><input id="xl" name="size" type="radio"><label for="xl">xl</label></p>
                                                        <p><input id="xxl" name="size" type="radio"><label for="xxl">xxl</label></p>
                                                    </div>
                                                    <p class="d-flex price-block item-center"><span class="price">800₴</span><span class="old-price">1200₴</span></p>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="btn-like">
                                            <div class="btn-view-block d-flex">
                                                <button class="blue-btn submit-btn orderCtaCard" type="submit">купити</button>
                                                <button class="oneClickBtn" title="Купити в 1 клік" type="submit">
                                                    <svg style="enable-background:new 0 0 15 15;" version="1.1" viewbox="0 0 17 17" x="0px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" y="0px">
                                                        <g>
                                                            <g>
                                                                <path class="st0" d="M6.9,0.5c-0.1-0.1-0.2-0.1-0.4,0c-0.1,0-0.1,0.1-0.2,0.1H7C7,0.5,7,0.5,6.9,0.5z"></path>
                                                                <path class="st0" d="M7.2,1.3l-1.6,5C5.5,6.5,5.3,6.7,5.1,6.7c-0.1,0-0.1,0-0.2,0l-0.1,0v0C4.6,6.5,4.5,6.1,4.6,5.8l1.6-5 c0-0.1,0.1-0.2,0.2-0.3H7C7.2,0.7,7.3,1,7.2,1.3z"></path>
                                                            </g>
                                                            <g>
                                                                <path class="st0" d="M8.5,0.4c-0.1,0-0.3,0-0.4,0c0,0-0.1,0-0.1,0.1h0.7C8.6,0.5,8.5,0.5,8.5,0.4z"></path>
                                                                <path class="st0" d="M10.1,6.6c0,0-0.1,0.1-0.2,0.1c-0.2,0-0.4-0.2-0.5-0.4l-1.6-5C7.7,1,7.8,0.7,8,0.5h0.7 c0.1,0.1,0.1,0.2,0.2,0.3l1.6,5C10.5,6.1,10.4,6.5,10.1,6.6z"></path>
                                                            </g>
                                                            <g>
                                                                <path class="st0" d="M14.6,6v0.8c0,0.2,0,0.4-0.1,0.6C14.3,7.7,14,8,13.6,8.2c-0.4,0.1-1.6,0.1-2.3,0.1H2.6l0.7,4.9 c0,0.2,0.2,0.4,0.5,0.4h4.6c0.1,0.4,0.3,0.7,0.5,1c0,0,0.1,0.1,0.1,0.1H3.8c-0.2,0-0.5,0-0.7-0.1c-0.5-0.2-0.9-0.7-1-1.2L1.4,8.2 C1,8,0.7,7.7,0.5,7.4C0.5,7.2,0.4,7,0.4,6.8V6c0-0.2,0-0.4,0.1-0.6c0.2-0.5,0.8-0.8,1.4-0.8h1.9c0.3,0,0.6,0.2,0.6,0.5 c0,0.3-0.3,0.6-0.6,0.6H1.9C1.8,5.7,1.6,5.8,1.6,6v0.8c0,0.2,0.2,0.3,0.3,0.3h11.1c0.2,0,0.3-0.1,0.3-0.3V6c0-0.1-0.2-0.3-0.3-0.3 h-1.9c-0.3,0-0.6-0.2-0.6-0.6c0-0.3,0.3-0.5,0.6-0.5h1.9c0.6,0,1.2,0.3,1.4,0.8C14.5,5.6,14.6,5.8,14.6,6z"></path>
                                                                <path class="st0" d="M8,10.1v2.5c0,0.3-0.2,0.6-0.5,0.6S7,12.9,7,12.6v-2.5c0-0.3,0.2-0.6,0.5-0.6S8,9.7,8,10.1z"></path>
                                                                <path class="st0" d="M6,10.1v2.5c0,0.3-0.2,0.6-0.5,0.6S5,12.9,5,12.6v-2.5c0-0.3,0.2-0.6,0.5-0.6S6,9.7,6,10.1z"></path>
                                                            </g>
                                                        </g>
                                                        <path class="st0" d="M12.2,15.7c-1.9,0-3.5-1.6-3.5-3.5s1.6-3.5,3.5-3.5s3.5,1.6,3.5,3.5S14.2,15.7,12.2,15.7z M12.2,9.2 c-1.7,0-3,1.4-3,3s1.4,3,3,3s3-1.4,3-3S13.9,9.2,12.2,9.2z"></path>
                                                        <g>
                                                            <path class="st0" d="M12.4,10.7V12h1.2v0.3h-1.2v1.3H12v-1.3h-1.2V12H12v-1.3H12.4z"></path>
                                                        </g></svg></button>
                                            </div>
                                            <button class="transparent-cta submit-btn delete-cta" type="submit"><span>видалити</span>
                                                <svg fill="none" height="12" viewbox="0 0 12 12" width="12" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11 1.00004L1 11M0.999958 1L10.9999 11" stroke stroke-linecap="round" stroke-linejoin="round" stroke-opacity></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </figcaption>
                            </figure>
                        </div>
                    </div>
                    <div class="empty-like-cabinet">
                        <div>
                            <p>Створюйте та зберігайте свої приватні списки товарів.</p>
                            <p>Додавайте товари, які хочете зберегти особисто для себе та зручно керуйте ними.</p>
                        </div><a class="yellow-cta btn-card cabinet-cta" href="#">в каталог</a>
                    </div>
                </div>
            </section>
        </div>
        <div class="top-prodaz-main cabinet-top-prodaz">
            <section class="view-product">
                <h2>доповніть свій образ</h2>
                <div class="top-prodaz-card">
                    <figure class="card">
                        <a href="card.html"></a>
                        <figcaption>
                            <div class="card-view-block item-center">
                                <div class="main-info-card item-center">
                                    <div class="image-block-card">
                                        <span class="flag"><span>new</span></span><picture><img alt="" src="img/catalog-card.png"></picture>
                                    </div>
                                    <form action="#">
                                        <div class="haracteristic-block-card">
                                            <div class="hover-card">
                                                <h3>Шорти джинсові жіночі, колір блакитний</h3>
                                                <div class="color d-flex item-center">
                                                    <label><input name="color" required="" type="radio" value="black"></label>
                                                    <label><input disabled name="color" required="" type="radio" value="red">
                                                    </label><label><input name="color" required="" type="radio" value="blue">
                                                    </label><label><input disabled name="color" required="" type="radio" value="gray"></label>
                                                    <label><input name="color" required="" type="radio" value="white"></label>
                                                </div>
                                                <p class="article">Артикул: 83635337</p>
                                                <div class="size d-flex item-center">
                                                    <p><input id="xs" name="size" required="" type="radio"><label for="xs">xs</label></p>
                                                    <p><input id="s" name="size" required="" type="radio"><label for="s">s</label></p>
                                                    <p><input id="m" name="size" required="" type="radio"><label for="m">m</label></p>
                                                    <p><input id="l" name="size" required="" type="radio"><label for="l">l</label></p>
                                                    <p><input id="xl" name="size" required="" type="radio"><label for="xl">xl</label></p>
                                                    <p><input id="xxl" name="size" required="" type="radio"><label for="xxl">xxl</label></p>
                                                </div>
                                                <p class="d-flex price-block item-center"><span class="price">800₴</span><span class="old-price">1200₴</span></p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="btn-view-block d-flex">
                                    <button class="blue-btn submit-btn orderCtaCard" type="submit">купити</button>
                                    <button class="oneClickBtn" title="Купити в 1 клік" type="submit">
                                        <svg style="enable-background:new 0 0 15 15;" version="1.1" viewbox="0 0 17 17" x="0px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" y="0px">
                                            <g>
                                                <g>
                                                    <path class="st0" d="M6.9,0.5c-0.1-0.1-0.2-0.1-0.4,0c-0.1,0-0.1,0.1-0.2,0.1H7C7,0.5,7,0.5,6.9,0.5z"></path>
                                                    <path class="st0" d="M7.2,1.3l-1.6,5C5.5,6.5,5.3,6.7,5.1,6.7c-0.1,0-0.1,0-0.2,0l-0.1,0v0C4.6,6.5,4.5,6.1,4.6,5.8l1.6-5 c0-0.1,0.1-0.2,0.2-0.3H7C7.2,0.7,7.3,1,7.2,1.3z"></path>
                                                </g>
                                                <g>
                                                    <path class="st0" d="M8.5,0.4c-0.1,0-0.3,0-0.4,0c0,0-0.1,0-0.1,0.1h0.7C8.6,0.5,8.5,0.5,8.5,0.4z"></path>
                                                    <path class="st0" d="M10.1,6.6c0,0-0.1,0.1-0.2,0.1c-0.2,0-0.4-0.2-0.5-0.4l-1.6-5C7.7,1,7.8,0.7,8,0.5h0.7 c0.1,0.1,0.1,0.2,0.2,0.3l1.6,5C10.5,6.1,10.4,6.5,10.1,6.6z"></path>
                                                </g>
                                                <g>
                                                    <path class="st0" d="M14.6,6v0.8c0,0.2,0,0.4-0.1,0.6C14.3,7.7,14,8,13.6,8.2c-0.4,0.1-1.6,0.1-2.3,0.1H2.6l0.7,4.9 c0,0.2,0.2,0.4,0.5,0.4h4.6c0.1,0.4,0.3,0.7,0.5,1c0,0,0.1,0.1,0.1,0.1H3.8c-0.2,0-0.5,0-0.7-0.1c-0.5-0.2-0.9-0.7-1-1.2L1.4,8.2 C1,8,0.7,7.7,0.5,7.4C0.5,7.2,0.4,7,0.4,6.8V6c0-0.2,0-0.4,0.1-0.6c0.2-0.5,0.8-0.8,1.4-0.8h1.9c0.3,0,0.6,0.2,0.6,0.5 c0,0.3-0.3,0.6-0.6,0.6H1.9C1.8,5.7,1.6,5.8,1.6,6v0.8c0,0.2,0.2,0.3,0.3,0.3h11.1c0.2,0,0.3-0.1,0.3-0.3V6c0-0.1-0.2-0.3-0.3-0.3 h-1.9c-0.3,0-0.6-0.2-0.6-0.6c0-0.3,0.3-0.5,0.6-0.5h1.9c0.6,0,1.2,0.3,1.4,0.8C14.5,5.6,14.6,5.8,14.6,6z"></path>
                                                    <path class="st0" d="M8,10.1v2.5c0,0.3-0.2,0.6-0.5,0.6S7,12.9,7,12.6v-2.5c0-0.3,0.2-0.6,0.5-0.6S8,9.7,8,10.1z"></path>
                                                    <path class="st0" d="M6,10.1v2.5c0,0.3-0.2,0.6-0.5,0.6S5,12.9,5,12.6v-2.5c0-0.3,0.2-0.6,0.5-0.6S6,9.7,6,10.1z"></path>
                                                </g>
                                            </g>
                                            <path class="st0" d="M12.2,15.7c-1.9,0-3.5-1.6-3.5-3.5s1.6-3.5,3.5-3.5s3.5,1.6,3.5,3.5S14.2,15.7,12.2,15.7z M12.2,9.2 c-1.7,0-3,1.4-3,3s1.4,3,3,3s3-1.4,3-3S13.9,9.2,12.2,9.2z"></path>
                                            <g>
                                                <path class="st0" d="M12.4,10.7V12h1.2v0.3h-1.2v1.3H12v-1.3h-1.2V12H12v-1.3H12.4z"></path>
                                            </g>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </figcaption>
                    </figure>
                    <figure class="card">
                        <a href="card.html"></a>
                        <figcaption>
                            <div class="card-view-block item-center">
                                <div class="main-info-card item-center">
                                    <div class="image-block-card">
                                        <span class="flag"><span>new</span></span><picture><img alt="" src="img/catalog-card.png"></picture>
                                    </div>
                                    <form action="#">
                                        <div class="haracteristic-block-card">
                                            <div class="hover-card">
                                                <h3>Шорти джинсові жіночі, колір блакитний</h3>
                                                <div class="color d-flex item-center">
                                                    <label><input name="color" required="" type="radio" value="black"></label>
                                                    <label><input disabled name="color" required="" type="radio" value="red"></label>
                                                    <label><input name="color" required="" type="radio" value="blue"></label>
                                                    <label><input disabled name="color" required="" type="radio" value="gray"></label>
                                                    <label><input name="color" required="" type="radio" value="white"></label>
                                                </div>
                                                <p class="article">Артикул: 83635337</p>
                                                <div class="size d-flex item-center">
                                                    <p><input id="xs" name="size" required="" type="radio"><label for="xs">xs</label></p>
                                                    <p><input id="s" name="size" required="" type="radio"><label for="s">s</label></p>
                                                    <p><input id="m" name="size" required="" type="radio"><label for="m">m</label></p>
                                                    <p><input id="l" name="size" required="" type="radio"><label for="l">l</label></p>
                                                    <p><input id="xl" name="size" required="" type="radio"><label for="xl">xl</label></p>
                                                    <p><input id="xxl" name="size" required="" type="radio"><label for="xxl">xxl</label></p>
                                                </div>
                                                <p class="d-flex price-block item-center"><span class="price">800₴</span><span class="old-price">1200₴</span></p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="btn-view-block d-flex">
                                    <button class="blue-btn submit-btn orderCtaCard" type="submit">купити</button>
                                    <button class="oneClickBtn" title="Купити в 1 клік" type="submit">
                                        <svg style="enable-background:new 0 0 15 15;" version="1.1" viewbox="0 0 17 17" x="0px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" y="0px">
                                            <g>
                                                <g>
                                                    <path class="st0" d="M6.9,0.5c-0.1-0.1-0.2-0.1-0.4,0c-0.1,0-0.1,0.1-0.2,0.1H7C7,0.5,7,0.5,6.9,0.5z"></path>
                                                    <path class="st0" d="M7.2,1.3l-1.6,5C5.5,6.5,5.3,6.7,5.1,6.7c-0.1,0-0.1,0-0.2,0l-0.1,0v0C4.6,6.5,4.5,6.1,4.6,5.8l1.6-5 c0-0.1,0.1-0.2,0.2-0.3H7C7.2,0.7,7.3,1,7.2,1.3z"></path>
                                                </g>
                                                <g>
                                                    <path class="st0" d="M8.5,0.4c-0.1,0-0.3,0-0.4,0c0,0-0.1,0-0.1,0.1h0.7C8.6,0.5,8.5,0.5,8.5,0.4z"></path>
                                                    <path class="st0" d="M10.1,6.6c0,0-0.1,0.1-0.2,0.1c-0.2,0-0.4-0.2-0.5-0.4l-1.6-5C7.7,1,7.8,0.7,8,0.5h0.7 c0.1,0.1,0.1,0.2,0.2,0.3l1.6,5C10.5,6.1,10.4,6.5,10.1,6.6z"></path>
                                                </g>
                                                <g>
                                                    <path class="st0" d="M14.6,6v0.8c0,0.2,0,0.4-0.1,0.6C14.3,7.7,14,8,13.6,8.2c-0.4,0.1-1.6,0.1-2.3,0.1H2.6l0.7,4.9 c0,0.2,0.2,0.4,0.5,0.4h4.6c0.1,0.4,0.3,0.7,0.5,1c0,0,0.1,0.1,0.1,0.1H3.8c-0.2,0-0.5,0-0.7-0.1c-0.5-0.2-0.9-0.7-1-1.2L1.4,8.2 C1,8,0.7,7.7,0.5,7.4C0.5,7.2,0.4,7,0.4,6.8V6c0-0.2,0-0.4,0.1-0.6c0.2-0.5,0.8-0.8,1.4-0.8h1.9c0.3,0,0.6,0.2,0.6,0.5 c0,0.3-0.3,0.6-0.6,0.6H1.9C1.8,5.7,1.6,5.8,1.6,6v0.8c0,0.2,0.2,0.3,0.3,0.3h11.1c0.2,0,0.3-0.1,0.3-0.3V6c0-0.1-0.2-0.3-0.3-0.3 h-1.9c-0.3,0-0.6-0.2-0.6-0.6c0-0.3,0.3-0.5,0.6-0.5h1.9c0.6,0,1.2,0.3,1.4,0.8C14.5,5.6,14.6,5.8,14.6,6z"></path>
                                                    <path class="st0" d="M8,10.1v2.5c0,0.3-0.2,0.6-0.5,0.6S7,12.9,7,12.6v-2.5c0-0.3,0.2-0.6,0.5-0.6S8,9.7,8,10.1z"></path>
                                                    <path class="st0" d="M6,10.1v2.5c0,0.3-0.2,0.6-0.5,0.6S5,12.9,5,12.6v-2.5c0-0.3,0.2-0.6,0.5-0.6S6,9.7,6,10.1z"></path>
                                                </g>
                                            </g>
                                            <path class="st0" d="M12.2,15.7c-1.9,0-3.5-1.6-3.5-3.5s1.6-3.5,3.5-3.5s3.5,1.6,3.5,3.5S14.2,15.7,12.2,15.7z M12.2,9.2 c-1.7,0-3,1.4-3,3s1.4,3,3,3s3-1.4,3-3S13.9,9.2,12.2,9.2z"></path>
                                            <g>
                                                <path class="st0" d="M12.4,10.7V12h1.2v0.3h-1.2v1.3H12v-1.3h-1.2V12H12v-1.3H12.4z"></path>
                                            </g>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </figcaption>
                    </figure>
                    <figure class="card">
                        <a href="card.html"></a>
                        <figcaption>
                            <div class="card-view-block item-center">
                                <div class="main-info-card item-center">
                                    <div class="image-block-card">
                                        <span class="flag"><span>new</span></span><picture><img alt="" src="img/catalog-card.png"></picture>
                                    </div>
                                    <form action="#">
                                        <div class="haracteristic-block-card">
                                            <div class="hover-card">
                                                <h3>Шорти джинсові жіночі, колір блакитний</h3>
                                                <div class="color d-flex item-center">
                                                    <label><input name="color" required="" type="radio" value="black"></label>
                                                    <label><input disabled name="color" required="" type="radio" value="red"></label>
                                                    <label><input name="color" required="" type="radio" value="blue"></label>
                                                    <label><input disabled name="color" required="" type="radio" value="gray"></label>
                                                    <label><input name="color" required="" type="radio" value="white"></label>
                                                </div>
                                                <p class="article">Артикул: 83635337</p>
                                                <div class="size d-flex item-center">
                                                    <p><input id="xs" name="size" required="" type="radio"><label for="xs">xs</label></p>
                                                    <p><input id="s" name="size" required="" type="radio"><label for="s">s</label></p>
                                                    <p><input id="m" name="size" required="" type="radio"><label for="m">m</label></p>
                                                    <p><input id="l" name="size" required="" type="radio"><label for="l">l</label></p>
                                                    <p><input id="xl" name="size" required="" type="radio"><label for="xl">xl</label></p>
                                                    <p><input id="xxl" name="size" required="" type="radio"><label for="xxl">xxl</label></p>
                                                </div>
                                                <p class="d-flex price-block item-center"><span class="price">800₴</span><span class="old-price">1200₴</span></p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="btn-view-block d-flex">
                                    <button class="blue-btn submit-btn orderCtaCard" type="submit">купити</button>
                                    <button class="oneClickBtn" title="Купити в 1 клік" type="submit">
                                        <svg style="enable-background:new 0 0 15 15;" version="1.1" viewbox="0 0 17 17" x="0px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" y="0px">
                                            <g>
                                                <g>
                                                    <path class="st0" d="M6.9,0.5c-0.1-0.1-0.2-0.1-0.4,0c-0.1,0-0.1,0.1-0.2,0.1H7C7,0.5,7,0.5,6.9,0.5z"></path>
                                                    <path class="st0" d="M7.2,1.3l-1.6,5C5.5,6.5,5.3,6.7,5.1,6.7c-0.1,0-0.1,0-0.2,0l-0.1,0v0C4.6,6.5,4.5,6.1,4.6,5.8l1.6-5 c0-0.1,0.1-0.2,0.2-0.3H7C7.2,0.7,7.3,1,7.2,1.3z"></path>
                                                </g>
                                                <g>
                                                    <path class="st0" d="M8.5,0.4c-0.1,0-0.3,0-0.4,0c0,0-0.1,0-0.1,0.1h0.7C8.6,0.5,8.5,0.5,8.5,0.4z"></path>
                                                    <path class="st0" d="M10.1,6.6c0,0-0.1,0.1-0.2,0.1c-0.2,0-0.4-0.2-0.5-0.4l-1.6-5C7.7,1,7.8,0.7,8,0.5h0.7 c0.1,0.1,0.1,0.2,0.2,0.3l1.6,5C10.5,6.1,10.4,6.5,10.1,6.6z"></path>
                                                </g>
                                                <g>
                                                    <path class="st0" d="M14.6,6v0.8c0,0.2,0,0.4-0.1,0.6C14.3,7.7,14,8,13.6,8.2c-0.4,0.1-1.6,0.1-2.3,0.1H2.6l0.7,4.9 c0,0.2,0.2,0.4,0.5,0.4h4.6c0.1,0.4,0.3,0.7,0.5,1c0,0,0.1,0.1,0.1,0.1H3.8c-0.2,0-0.5,0-0.7-0.1c-0.5-0.2-0.9-0.7-1-1.2L1.4,8.2 C1,8,0.7,7.7,0.5,7.4C0.5,7.2,0.4,7,0.4,6.8V6c0-0.2,0-0.4,0.1-0.6c0.2-0.5,0.8-0.8,1.4-0.8h1.9c0.3,0,0.6,0.2,0.6,0.5 c0,0.3-0.3,0.6-0.6,0.6H1.9C1.8,5.7,1.6,5.8,1.6,6v0.8c0,0.2,0.2,0.3,0.3,0.3h11.1c0.2,0,0.3-0.1,0.3-0.3V6c0-0.1-0.2-0.3-0.3-0.3 h-1.9c-0.3,0-0.6-0.2-0.6-0.6c0-0.3,0.3-0.5,0.6-0.5h1.9c0.6,0,1.2,0.3,1.4,0.8C14.5,5.6,14.6,5.8,14.6,6z"></path>
                                                    <path class="st0" d="M8,10.1v2.5c0,0.3-0.2,0.6-0.5,0.6S7,12.9,7,12.6v-2.5c0-0.3,0.2-0.6,0.5-0.6S8,9.7,8,10.1z"></path>
                                                    <path class="st0" d="M6,10.1v2.5c0,0.3-0.2,0.6-0.5,0.6S5,12.9,5,12.6v-2.5c0-0.3,0.2-0.6,0.5-0.6S6,9.7,6,10.1z"></path>
                                                </g>
                                            </g>
                                            <path class="st0" d="M12.2,15.7c-1.9,0-3.5-1.6-3.5-3.5s1.6-3.5,3.5-3.5s3.5,1.6,3.5,3.5S14.2,15.7,12.2,15.7z M12.2,9.2 c-1.7,0-3,1.4-3,3s1.4,3,3,3s3-1.4,3-3S13.9,9.2,12.2,9.2z"></path>
                                            <g>
                                                <path class="st0" d="M12.4,10.7V12h1.2v0.3h-1.2v1.3H12v-1.3h-1.2V12H12v-1.3H12.4z"></path>
                                            </g>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </figcaption>
                    </figure>
                    <figure class="card">
                        <a href="card.html"></a>
                        <figcaption>
                            <div class="card-view-block item-center">
                                <div class="main-info-card item-center">
                                    <div class="image-block-card">
                                        <span class="flag"><span>new</span></span><picture><img alt="" src="img/catalog-card.png"></picture>
                                    </div>
                                    <form action="#">
                                        <div class="haracteristic-block-card">
                                            <div class="hover-card">
                                                <h3>Шорти джинсові жіночі, колір блакитний</h3>
                                                <div class="color d-flex item-center">
                                                    <label><input name="color" required="" type="radio" value="black"></label>
                                                    <label><input disabled name="color" required="" type="radio" value="red"></label>
                                                    <label><input name="color" required="" type="radio" value="blue"></label>
                                                    <label><input disabled name="color" required="" type="radio" value="gray"></label>
                                                    <label><input name="color" required="" type="radio" value="white"></label>
                                                </div>
                                                <p class="article">Артикул: 83635337</p>
                                                <div class="size d-flex item-center">
                                                    <p><input id="xs" name="size" required="" type="radio"><label for="xs">xs</label></p>
                                                    <p><input id="s" name="size" required="" type="radio"><label for="s">s</label></p>
                                                    <p><input id="m" name="size" required="" type="radio"><label for="m">m</label></p>
                                                    <p><input id="l" name="size" required="" type="radio"><label for="l">l</label></p>
                                                    <p><input id="xl" name="size" required="" type="radio"><label for="xl">xl</label></p>
                                                    <p><input id="xxl" name="size" required="" type="radio"><label for="xxl">xxl</label></p>
                                                </div>
                                                <p class="d-flex price-block item-center"><span class="price">800₴</span><span class="old-price">1200₴</span></p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="btn-view-block d-flex">
                                    <button class="blue-btn submit-btn orderCtaCard" type="submit">купити</button>
                                    <button class="oneClickBtn" title="Купити в 1 клік" type="submit">
                                        <svg style="enable-background:new 0 0 15 15;" version="1.1" viewbox="0 0 17 17" x="0px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" y="0px">
                                            <g>
                                                <g>
                                                    <path class="st0" d="M6.9,0.5c-0.1-0.1-0.2-0.1-0.4,0c-0.1,0-0.1,0.1-0.2,0.1H7C7,0.5,7,0.5,6.9,0.5z"></path>
                                                    <path class="st0" d="M7.2,1.3l-1.6,5C5.5,6.5,5.3,6.7,5.1,6.7c-0.1,0-0.1,0-0.2,0l-0.1,0v0C4.6,6.5,4.5,6.1,4.6,5.8l1.6-5 c0-0.1,0.1-0.2,0.2-0.3H7C7.2,0.7,7.3,1,7.2,1.3z"></path>
                                                </g>
                                                <g>
                                                    <path class="st0" d="M8.5,0.4c-0.1,0-0.3,0-0.4,0c0,0-0.1,0-0.1,0.1h0.7C8.6,0.5,8.5,0.5,8.5,0.4z"></path>
                                                    <path class="st0" d="M10.1,6.6c0,0-0.1,0.1-0.2,0.1c-0.2,0-0.4-0.2-0.5-0.4l-1.6-5C7.7,1,7.8,0.7,8,0.5h0.7 c0.1,0.1,0.1,0.2,0.2,0.3l1.6,5C10.5,6.1,10.4,6.5,10.1,6.6z"></path>
                                                </g>
                                                <g>
                                                    <path class="st0" d="M14.6,6v0.8c0,0.2,0,0.4-0.1,0.6C14.3,7.7,14,8,13.6,8.2c-0.4,0.1-1.6,0.1-2.3,0.1H2.6l0.7,4.9 c0,0.2,0.2,0.4,0.5,0.4h4.6c0.1,0.4,0.3,0.7,0.5,1c0,0,0.1,0.1,0.1,0.1H3.8c-0.2,0-0.5,0-0.7-0.1c-0.5-0.2-0.9-0.7-1-1.2L1.4,8.2 C1,8,0.7,7.7,0.5,7.4C0.5,7.2,0.4,7,0.4,6.8V6c0-0.2,0-0.4,0.1-0.6c0.2-0.5,0.8-0.8,1.4-0.8h1.9c0.3,0,0.6,0.2,0.6,0.5 c0,0.3-0.3,0.6-0.6,0.6H1.9C1.8,5.7,1.6,5.8,1.6,6v0.8c0,0.2,0.2,0.3,0.3,0.3h11.1c0.2,0,0.3-0.1,0.3-0.3V6c0-0.1-0.2-0.3-0.3-0.3 h-1.9c-0.3,0-0.6-0.2-0.6-0.6c0-0.3,0.3-0.5,0.6-0.5h1.9c0.6,0,1.2,0.3,1.4,0.8C14.5,5.6,14.6,5.8,14.6,6z"></path>
                                                    <path class="st0" d="M8,10.1v2.5c0,0.3-0.2,0.6-0.5,0.6S7,12.9,7,12.6v-2.5c0-0.3,0.2-0.6,0.5-0.6S8,9.7,8,10.1z"></path>
                                                    <path class="st0" d="M6,10.1v2.5c0,0.3-0.2,0.6-0.5,0.6S5,12.9,5,12.6v-2.5c0-0.3,0.2-0.6,0.5-0.6S6,9.7,6,10.1z"></path>
                                                </g>
                                            </g>
                                            <path class="st0" d="M12.2,15.7c-1.9,0-3.5-1.6-3.5-3.5s1.6-3.5,3.5-3.5s3.5,1.6,3.5,3.5S14.2,15.7,12.2,15.7z M12.2,9.2 c-1.7,0-3,1.4-3,3s1.4,3,3,3s3-1.4,3-3S13.9,9.2,12.2,9.2z"></path>
                                            <g>
                                                <path class="st0" d="M12.4,10.7V12h1.2v0.3h-1.2v1.3H12v-1.3h-1.2V12H12v-1.3H12.4z"></path>
                                            </g>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </figcaption>
                    </figure>
                </div>
                <div class="view-all">
                    <div class="flex-between">
                        <a class="left-arrow gray-sircle" href="#">
                            <svg fill="none" height="40" viewbox="0 0 40 40" width="40" xmlns="http://www.w3.org/2000/svg">
                                <path d="M23 13L15 20.5L23 28" stroke="#121212" stroke-linecap="round"></path>
                            </svg>
                        </a>
                        <a class="right-arrow gray-sircle" href="#">
                            <svg fill="none" height="40" viewbox="0 0 40 40" width="40" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17 13L25 20.5L17 28" stroke="#121212" stroke-linecap="round"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </main>
</x-site-layout>
