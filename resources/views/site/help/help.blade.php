<x-site-layout>
    <main class="wrapper">
        <div class="d-flex flex-arrow">
            <a class="arrow-up arrow" href="#body"><svg fill="none" height="10" viewbox="0 0 18 10" width="18" xmlns="http://www.w3.org/2000/svg">
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
            <a href="{{ route('help', '#') }}">допомога</a>
            <span>/</span>
            <span class="selected-page">питання та відповіді</span>
        </p>
        <div class="help-page">
            <div class="help-menu">
                <h1>допомога</h1>
                <ul class="menu-help-item">
                    <li>
                        <a class="active-cta-help" data-href="aboutUs" href="javascript:void(0)">
                            <span>Про нас</span>
                            <svg fill="none" height="12" viewbox="0 0 7 12" width="7" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L6 6L1 11" stroke="#214498" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a data-href="payDelivery" href="javascript:void(0)">
                            <span>Оплата та доставка</span>
                            <svg fill="none" height="12" viewbox="0 0 7 12" width="7" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L6 6L1 11" stroke="#214498" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a data-href="povernenia" href="javascript:void(0)">
                            <span>Повернення та обмін</span>
                            <svg fill="none" height="12" viewbox="0 0 7 12" width="7" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L6 6L1 11" stroke="#214498" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a data-href="question" href="javascript:void(0)">
                            <span>Питання та відповіді</span>
                            <svg fill="none" height="12" viewbox="0 0 7 12" width="7" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L6 6L1 11" stroke="#214498" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
            <section class="about-us-block help-content" id="aboutUs">
                @include('components.about-us')
            </section>
            <section class="help-content question" id="question">
                @include('components.question')
            </section>
            <section class="help-content povernenia" id="povernenia">
                @include('components.povernenia')
            </section>
            <section class="help-content pay-delivery" id="payDelivery">
                @include('components.pay-delivery')
            </section>
        </div>
    </main>
</x-site-layout>
