@if(session()->get('currency') == 'UAH')
    <p class="text-lg mb-2">Ціна за шт - {{ $price->pair }} {{ session()->get('currency') }}.</p>
    <p class="text-lg mb-2">Ціна за пакування - {{ $price->package }} {{ session()->get('currency') }}.</p>
    <p class="text-lg mb-2">Рекомендована ціна для продажу у роздріб - {{ $price->retail }} {{ session()->get('currency') }}.</p>
@elseif(session()->get('currency') == 'EUR')
    <p class="text-lg mb-2">Ціна за шт - {{ round($price->pair / session()->get('currency_rate_eur'), 1)}} {{ session()->get('currency') }}.</p>
    <p class="text-lg mb-2">Ціна за пакування - {{ round($price->package / session()->get('currency_rate_eur'), 1) }} {{ session()->get('currency') }}.</p>
    <p class="text-lg mb-2">Рекомендована ціна для продажу у роздріб - {{ round($price->retail / session()->get('currency_rate_eur'), 1) }} {{ session()->get('currency') }}.</p>
@elseif(session()->get('currency') == 'USD')
    <p class="text-lg mb-2">Ціна за шт - {{ round($price->pair / session()->get('currency_rate_usd'), 1)}} {{ session()->get('currency') }}.</p>
    <p class="text-lg mb-2">Ціна за пакування - {{ round($price->package / session()->get('currency_rate_usd'), 1) }} {{ session()->get('currency') }}.</p>
    <p class="text-lg mb-2">Рекомендована ціна для продажу у роздріб - {{ round($price->retail / session()->get('currency_rate_usd'), 1) }} {{ session()->get('currency') }}.</p>
@endif
