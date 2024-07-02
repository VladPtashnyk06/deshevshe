<!DOCTYPE html>
<html>
<head>
    <title>Нове замовлення №{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8fafc;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #eeeeee;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .content {
            padding: 20px 0;
        }
        .content p {
            margin: 0 0 10px;
        }
        .content p strong {
            color: #555;
        }
        .order-details, .product-details {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .order-details th, .product-details th,
        .order-details td, .product-details td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        .product-image {
            text-align: center;
            margin: 10px 0;
        }
        .product-image img {
            max-width: 100px;
            height: auto;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #eeeeee;
            font-size: 12px;
            color: #777;
        }
        .two-table {
            display: flex;
            justify-content: space-between;
        }
        .mar {
            margin-right: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Нове замовлення №{{ $order->id }}</h1>
    </div>
    <div class="content">
        <div class="two-table">
            <table class="order-details mar">
                <tr>
                    <th>Ім'я</th>
                    <td>{{ $order->user_name }}</td>
                </tr>
                <tr>
                    <th>Прізвище</th>
                    <td>{{ $order->user_last_name }}</td>
                </tr>
                <tr>
                    <th>По-батькові</th>
                    <td>{{ $order->user_middle_name }}</td>
                </tr>
                <tr>
                    <th>Телефон</th>
                    <td>{{ $order->user_phone }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $order->user_email }}</td>
                </tr>
                <tr>
                    <th>Сума замовлення</th>
                    <td>{{ $order->total_price }} {{ $order->currency }}</td>
                </tr>
                <tr>
                    <th>Спосіб оплати</th>
                    <td>{{ $order->paymentMethod->title }}</td>
                </tr>
                <tr>
                    <th>Коментар</th>
                    <td>{{ $order->comment }}</td>
                </tr>
            </table>
            <table class="order-details">
                <tr>
                    <th>Служба доставки</th>
                    <td>{{ $order->delivery->delivery_name == 'NovaPoshta' ? 'Нова Пошта' : ($order->delivery->delivery_name == 'Meest' ? 'Meest' : ($order->delivery->delivery_name == 'UkrPoshta' ? 'Укр Пошта' : '')) }}</td>
                </tr>
                <tr>
                    <th>Метод доставки</th>
                    <td>{{ ( $order->delivery->delivery_method == 'branch' || $order->delivery->delivery_method == 'exspresBranch') ? 'Відділення' : (($order->delivery->delivery_method == 'courier' || $order->delivery->delivery_method == 'exspresCourier') ? 'Кур`єр' : ($order->delivery->delivery_method == 'postomat' ? 'Поштомат' : '')) }}</td>
                </tr>
                @if($order->delivery->region)
                    <tr>
                        <th>Область</th>
                        <td>{{ $order->delivery->region }}</td>
                    </tr>
                @endif
                @if($order->delivery->district)
                    <tr>
                        <th>Район</th>
                        <td>{{ $order->delivery->district }}</td>
                    </tr>
                @endif
                @if($order->delivery->settlement)
                    <tr>
                        <th>{{ ucfirst($order->delivery->settlementType) }}</th>
                        <td>{{ $order->delivery->settlement }}</td>
                    </tr>
                @endif
                @if($order->delivery->branch)
                    <tr>
                        <th>Відділення</th>
                        <td>{{ $order->delivery->branch }}</td>
                    </tr>
                @endif
                @if($order->delivery->street)
                    <tr>
                        <th>Вулиця</th>
                        <td>{{ $order->delivery->street }}</td>
                    </tr>
                @endif
                @if($order->delivery->house)
                    <tr>
                        <th>Будинок</th>
                        <td>{{ $order->delivery->house }}</td>
                    </tr>
                @endif
                @if($order->delivery->flat)
                    <tr>
                        <th>Квартира</th>
                        <td>{{ $order->delivery->flat }}</td>
                    </tr>
                @endif
            </table>
        </div>
        <h2>Деталі замовлення:</h2>
        <table class="product-details">
            <thead>
            <tr>
                <th>Продукт</th>
                <th>Код продукту</th>
                <th>Кількість</th>
                <th>Колір</th>
                <th>Розмір</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($order->orderDetails as $detail)
                <tr>
                    <td>{{ $detail->product->title }}</td>
                    <td>{{ $detail->product->code }}</td>
                    <td>{{ $detail->quantity_product }}</td>
                    <td>{{ $detail->color }}</td>
                    <td>{{ $detail->size }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="footer">
        <p>Цей лист був згенерований автоматично. Будь ласка, не відповідайте на нього.</p>
    </div>
</div>
</body>
</html>
