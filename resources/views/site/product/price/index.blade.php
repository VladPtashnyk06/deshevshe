@if(!$price->promotional_price)
    @if(session()->get('currency') == 'UAH')
{{--        @if($price->pair)--}}
{{--            <p class="text-lg mb-2">Ціна за шт - {{ $price->pair }} {{ session()->get('currency') }}.</p>--}}
{{--        @endif--}}
{{--        @if($price->package)--}}
{{--            <p class="text-lg mb-2">Ціна за пакування - {{ $price->package }} {{ session()->get('currency') }}.</p>--}}
{{--        @endif--}}
    @if($price->retail)
            <p class="text-lg mb-2">Ціна - {{ $price->retail }} {{ session()->get('currency') }}.</p>
        @endif
    @elseif(session()->get('currency') == 'EUR')
{{--        @if($price->pair)--}}
{{--            <p class="text-lg mb-2">Ціна за шт - {{ round($price->pair / session()->get('currency_rate_eur'), 2)}} {{ session()->get('currency') }}.</p>--}}
{{--        @endif--}}
{{--        @if($price->package)--}}
{{--            <p class="text-lg mb-2">Ціна за пакування - {{ round($price->package / session()->get('currency_rate_eur'), 2) }} {{ session()->get('currency') }}.</p>--}}
{{--        @endif--}}
        @if($price->retail)
            <p class="text-lg mb-2">Ціна - {{ round($price->retail / session()->get('currency_rate_eur'), 2) }} {{ session()->get('currency') }}.</p>
        @endif
    @elseif(session()->get('currency') == 'USD')
{{--        @if($price->pair)--}}
{{--            <p class="text-lg mb-2">Ціна за шт - {{ round($price->pair / session()->get('currency_rate_usd'), 2)}} {{ session()->get('currency') }}.</p>--}}
{{--        @endif--}}
{{--        @if($price->package)--}}
{{--            <p class="text-lg mb-2">Ціна за пакування - {{ round($price->package / session()->get('currency_rate_usd'), 2) }} {{ session()->get('currency') }}.</p>--}}
{{--        @endif--}}
        @if($price->retail)
            <p class="text-lg mb-2">Ціна - {{ round($price->retail / session()->get('currency_rate_usd'), 2) }} {{ session()->get('currency') }}.</p>
        @endif
    @endif
@else
    @if(session()->get('currency') == 'UAH')
        <p class="text-lg mb-2">Стара ціна за шт - {{ $price->retail }} {{ session()->get('currency') }}.</p>
        <p class="text-lg mb-2">Акційна ціна за шт - {{ $price->promotional_price }} {{ session()->get('currency') }}.</p>
        <p class="text-lg mb-2">Знижка - {{ $price->promotional_rate }}%.</p>
    @elseif(session()->get('currency') == 'EUR')
        <p class="text-lg mb-2">Стара ціна за шт - {{ round($price->retail / session()->get('currency_rate_eur'), 2)}} {{ session()->get('currency') }}.</p>
        <p class="text-lg mb-2">Акційна ца шт - {{ round($price->promotional_price / session()->get('currency_rate_eur'), 2)}} {{ session()->get('currency') }}.</p>
        <p class="text-lg mb-2">Знижка - {{ $price->promotional_rate }}%.</p>
    @elseif(session()->get('currency') == 'USD')
        <p class="text-lg mb-2">Стара ціна за шт - {{ round($price->retail / session()->get('currency_rate_usd'), 2)}} {{ session()->get('currency') }}.</p>
        <p class="text-lg mb-2">Акційна ціна за шт - {{ round($price->promotional_price / session()->get('currency_rate_usd'), 2)}} {{ session()->get('currency') }}.</p>
        <p class="text-lg mb-2">Знижка - {{ $price->promotional_rate }}%.</p>
    @endif
@endif
