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
