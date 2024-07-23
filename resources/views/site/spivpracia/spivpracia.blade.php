<x-site-layout>
    <main class="wrapper">
        <p class="page-look d-flex">
            <a href="{{ route('site.index') }}">головна</a>
            <span>/</span>
            <span class="selected-page">співпраця</span>
        </p>
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
        <div class="head-basket flex-between item-center">
            <h1>співпраця</h1>
        </div>
        <section class="spivpracia-section">
            <div class="description-spivpracia">
                <p class="head-descript">Товари зі складів в Україні:</p>
                <ul class="list-descript">
                    <li>А тут все максимально просто! Замовив – отримав.</li>
                    <li>Відправляємо в найкоротші терміни.</li>
                </ul>
                <hr class="descript-card">
                <p class="head-descript">Умови співпраці по дропшипінгу:</p>
                <p class="umovy-text">Для початку співпраці необхідно зв'язатися з нашим менеджером за допомогою телефону або будь-якого месенджера. Це дозволить обговорити умови партнерства, включаючи формат співпраці та канали продажу, наприклад, інтернет-магазини чи соціальні мережі. Після узгодження умов Ви отримуєте статус Дроппартнера. За Вашим бажанням, ми також можемо налаштувати експорт даних про товари; для цього надішліть необхідну інформацію нашому менеджеру.</p>
                <p class="umovy-text">Замовлення відправляються та доставляються за допомогою перевізників "Нова Пошта" та "Укрпошта" по всій території України. Вартість доставки розраховується за тарифами відповідного перевізника.</p>
                <hr class="descript-card">
                <p class="head-descript">Обов'язкові умови співпраці:</p>
                <ul class="list-descript">
                    <li>Встановлення цін на продаж має відповідати роздрібному типу цін з нашого прейскуранта.</li>
                    <li>Дроппартнер має право розміщувати нашу продукцію на власних платформах та маркетплейсах.</li>
                    <li>Умови повернення продукції визначають, що витрати на повернення покриваються кінцевим покупцем або дроппартнером.</li>
                    <li>Комісійні відсотки за банківські перекази, пов'язані з виплатами між дроппартнером та кінцевим покупцем, лягають на плечі дроппартнера.</li>
                </ul>
                <hr class="descript-card">
                <p class="head-descript">Процедура оформлення замовлення:</p>
                <ul class="list-descript">
                    <li>Отримавши замовлення від покупця, Ви маєте створити відповідне замовлення у системі "Нова Пошта" чи "Укрпошта".</li>
                    <li>Оплатіть товар та&nbsp; надішліть менеджеру чек, сформовану ТТН та код товару.</li>
                    <li>Ми збираємо та відправляємо Ваше замовлення.</li>
                    <li>Покупець оплачує і отримує замовлення.</li>
                </ul>
                <hr class="descript-card last-hr-spvp">
                <div class="flag-order spivpracia-flag">
                    <p>У разі якщо клієнт бажає повернути товар, що залишився у недоторканному стані та має збережений товарний вигляд, можливе оформлення запиту на повернення.</p>
                </div>
            </div>
            <div class="top-prodaz-main">
                @include('components.top-prodaz')
                <div class="view-all">
                    <div class="flex-between">
                        <a class="left-arrow gray-sircle" href="#"><svg fill="none" height="40" viewbox="0 0 40 40" width="40" xmlns="http://www.w3.org/2000/svg">
                                <path d="M23 13L15 20.5L23 28" stroke="#121212" stroke-linecap="round"></path></svg></a> <a class="right-arrow gray-sircle" href="#"><svg fill="none" height="40" viewbox="0 0 40 40" width="40" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17 13L25 20.5L17 28" stroke="#121212" stroke-linecap="round"></path></svg></a>
                    </div><a href="#">показати усі</a>
                </div>
            </div>
        </section>
    </main>
</x-site-layout>
