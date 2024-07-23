<x-site-layout>
    <main>
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
        <section class="main">
            <div class="main-bg">
                <div class="new-colection position-center">
                    <p>мультимаркет для усієї родини</p>
                    <p>-30% на усі колекції літніх речей</p>
                    <a class="yellow-cta cta-main" href="catalog.html">в каталог</a>
                </div>
            </div>
        </section>
        <section class="perevagi">
            <div class="wrapper">
                <h2>наші переваги</h2>
                <div class="flex-between">
                    <div class="d-flex item-center">
                        <picture><img alt="" src="{{ asset('img/oplata.svg') }}"></picture>
                        <p>оплата при отриманні</p>
                    </div>
                    <div class="d-flex item-center">
                        <picture><img alt="" src="{{ asset('img/obmin.svg') }}"></picture>
                        <p>обмін та повернення</p>
                    </div>
                    <div class="d-flex item-center">
                        <picture><img alt="" src="{{ asset('img/delivery.svg') }}"></picture>
                        <p>швидка доставка</p>
                    </div>
                    <div class="d-flex item-center">
                        <picture><img alt="" src="{{ asset('img/yakist.svg') }}"></picture>
                        <p>гарантія якості</p>
                    </div>
                    <div class="d-flex item-center">
                        <picture><img alt="" src="{{ asset('img/kupyty.svg') }}"></picture>
                        <p>покупка <span>в 1 клік</span></p>
                    </div>
                </div>
            </div>
        </section>
        <section class="popular">
            <h2>популярні категорії</h2>
            <div class="wrapper flex-between popular-elements">
                <a href="#">
                    <picture><img alt="" src="{{ asset('img/img1.png') }}"></picture>
                    <span>Сумки</span></a> <a href="#">
                    <picture><img alt="" src="{{ asset('img/img2.png') }}"></picture>
                    <span>Футболки</span></a> <a href="#">
                    <picture><img alt="" src="{{ asset('img/img3.png') }}"></picture>
                    <span>Велосипедки</span></a> <a href="#">
                    <picture><img alt="" src="{{ asset('img/img4.png') }}"></picture>
                    <span>Взуття</span></a>
                <a href="#">
                    <picture><img alt="" src="{{ asset('img/img5.png') }}"></picture>
                    <span>Штани</span>
                </a>
                <a href="#">
                    <picture>
                        <img alt="" src="{{ asset('img/img6.png') }}">
                    </picture>
                    <span>Піжами</span>
                </a>
                <a href="#">
                    <picture>
                        <img alt="" src="{{ asset('img/img7.png') }}">
                    </picture>
                    <span>Аксесуари</span>
                </a>
            </div>
        </section>
        <div class="wrapper top-prodaz-main">
            @include('components.top-prodaz')
            <div class="view-all">
                <div class="flex-between">
                    <a class="left-arrow gray-sircle" href="#">
                        <svg fill="none" height="40" viewbox="0 0 40 40" width="40" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23 13L15 20.5L23 28" stroke="#121212" stroke-linecap="round"></path>
                        </svg>
                    </a> <a class="right-arrow gray-sircle" href="#">
                        <svg fill="none" height="40" viewbox="0 0 40 40" width="40" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17 13L25 20.5L17 28" stroke="#121212" stroke-linecap="round"></path>
                        </svg>
                    </a>
                </div>
                <a href="#">показати усі</a>
            </div>
        </div>
    </main>
</x-site-layout>
