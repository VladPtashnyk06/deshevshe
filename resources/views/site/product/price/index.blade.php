@if(session()->get('currency') == 'UAH')
    @if($price->pair)
        <p class="text-lg mb-2">Ціна за шт - {{ $price->pair }} {{ session()->get('currency') }}.</p>
    @endif
    @if($price->package)
        <p class="text-lg mb-2">Ціна за пакування - {{ $price->package }} {{ session()->get('currency') }}.</p>
    @endif
    @if($price->retail)
        <p class="text-lg mb-2">Рекомендована ціна для продажу у роздріб - {{ $price->retail }} {{ session()->get('currency') }}.</p>
    @endif
@elseif(session()->get('currency') == 'EUR')
    @if($price->pair)
        <p class="text-lg mb-2">Ціна за шт - {{ round($price->pair / session()->get('currency_rate_eur'), 2)}} {{ session()->get('currency') }}.</p>
    @endif
    @if($price->package)
        <p class="text-lg mb-2">Ціна за пакування - {{ round($price->package / session()->get('currency_rate_eur'), 2) }} {{ session()->get('currency') }}.</p>
    @endif
    @if($price->retail)
        <p class="text-lg mb-2">Рекомендована ціна для продажу у роздріб - {{ round($price->retail / session()->get('currency_rate_eur'), 2) }} {{ session()->get('currency') }}.</p>
    @endif
@elseif(session()->get('currency') == 'USD')
    @if($price->pair)
        <p class="text-lg mb-2">Ціна за шт - {{ round($price->pair / session()->get('currency_rate_usd'), 2)}} {{ session()->get('currency') }}.</p>
    @endif
    @if($price->package)
        <p class="text-lg mb-2">Ціна за пакування - {{ round($price->package / session()->get('currency_rate_usd'), 2) }} {{ session()->get('currency') }}.</p>
    @endif
    @if($price->retail)
        <p class="text-lg mb-2">Рекомендована ціна для продажу у роздріб - {{ round($price->retail / session()->get('currency_rate_usd'), 2) }} {{ session()->get('currency') }}.</p>
    @endif
@endif
