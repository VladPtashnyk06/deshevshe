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
