<div class="description-about-us">
    <h2>Мої повернення</h2>
    @php
        $totalCount = 0;
    @endphp
    <p class="text-cart text-return">{{ $totalCount }} товари</p>
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
            @php
                $totalAmount = 0;
            @endphp
            @foreach(Auth::user()->orders()->get() as $return)
                @if($return->orderStatus()->title == 'Повернення')
                    @php
                        $totalAmount += $return->total_price;
                        $totalCount += 1;
                    @endphp
                    <tr>
                        <td>{{ $return->created_at->format('d/m/Y') }}</td>
                        <td>{{ $return->order_id }}</td>
                        <td>1</td>
                        <td>{{ $return->total_price }}₴</td>
                        <td>{{ $return->orderStatus()->title }}</td>
                    </tr>
                @endif
            @endforeach
            <tr class="footer-table">
                <td>всього</td>
                <td></td>
                <td>{{ $totalCount }}</td>
                <td>{{ $totalAmount }}₴</td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
