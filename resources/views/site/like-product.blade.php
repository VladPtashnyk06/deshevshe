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
            <span class="selected-page">вподобані товари</span>
        </p>
        <div class="head-basket flex-between item-center">
            <h1>вподобані товари</h1>
        </div>
        @if(Auth::user())
            @include('components.liked-products')
            <div class="empty-like-product d-flex item-center">
                <div class="descript-empty">
                    <p>Створюйте та зберігайте свої приватні списки товарів.</p>
                    <p>Додавайте товари, які хочете зберегти особисто для себе та зручно керуйте ними.</p>
                </div>
                <a class="yellow-cta btn-card cabinet-cta" href="#">в каталог</a>
            </div>
        @else
            <div class="empty-like-product d-flex item-center">
                <div class="descript-empty">
                    <p>Створюйте та зберігайте свої приватні списки товарів.</p>
                    <p>Додавайте товари, які хочете зберегти особисто для себе та зручно керуйте ними.</p>
                </div>
                <a class="yellow-cta btn-card contact-cta" href="#">увійти або зареєструватися</a>
            </div>
        @endif
    </main>
</x-site-layout>
