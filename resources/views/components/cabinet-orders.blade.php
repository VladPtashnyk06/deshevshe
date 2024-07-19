<div class="description-about-us">
    <h2>Список замовлень</h2>
    <div class="table-cabinet">
        <table>
            <thead>
            <tr>
                <th>дата</th>
                <th>номер</th>
                <th>ТТН</th>
                <th>сума</th>
                <th>повернення</th>
                <th>знижка</th>
                <th>статус</th>
                <th>стан оплати</th>
                <th>дії</th>
                <th>промо акція</th>
            </tr>
            </thead>
            <tbody>
            @php
                $totalSum = 0;
                $countOrders = 1;
            @endphp
            @foreach(Auth::user()->orders()->get() as $order)
                @php
                    $totalSum += $order->total_price;
                @endphp
                <tr>
                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                    <td>{{ $countOrders }}</td>
                    <td>{{ $order->int_doc_number }}</td>
                    <td>{{ $order->total_price }}</td>
                    <td>{{ $order->orderStatus->title == 'повернення' ? 'так' : '-' }}</td>
                    <td>{{ $order->promoCode->rate ?? 0 }}%</td>
                    <td>-</td>
                    <td>{{ $order->order_status_id >= 4 ? 'оплачено' : 'відхилено' }}</td>
                    <td>{{ $order->orderStatus->title }}</td>
                    <td>–</td>
                </tr>
                @php($countOrders++)
            @endforeach
            <tr class="footer-table">
                <td>всього</td>
                <td></td>
                <td></td>
                <td>{{ $totalSum }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
