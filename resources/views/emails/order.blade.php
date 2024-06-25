<!DOCTYPE html>
<html>
<head>
    <title>Нове замовлення</title>
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
            max-width: 600px;
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
        .product-image {
            text-align: center;
            margin: 10px 0;
        }
        .product-image img {
            max-width: 100%;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Нове замовлення</h1>
        </div>
        <div class="content">
            <p><strong>Ім'я:</strong> {{ $order->user_name }}</p>
            <p><strong>Прізвище:</strong> {{ $order->user_last_name }}</p>
            <p><strong>По-батькові:</strong> {{ $order->user_middle_name }}</p>
            <p><strong>Телефон:</strong> {{ $order->user_phone }}</p>
            <p><strong>Email:</strong> {{ $order->user_email }}</p>
            <p><strong>Сума замовлення:</strong> {{ $order->total_price }} {{ $order->currency }}</p>
            <p><strong>Спосіб оплати:</strong> {{ $order->paymentMethod->title }}</p>
            <p><strong>Коментар:</strong> {{ $order->comment }}</p>
            <h2>Деталі замовлення:</h2>
            @foreach ($order->orderDetails as $detail)
                <div class="product-image">
                    @foreach($detail->product->getMedia($detail->product->id) as $media)
                        @if($media->getCustomProperty('main_image') === 1)
                            <img src="{{ $imageUrl }}" alt="{{ $media->getCustomProperty('alt') }}" style="max-width:100%;height:auto;border-radius:5px;">
                        @endif
                    @endforeach
                </div>
                <p><strong>Продукт:</strong> {{ $detail->product->title }}</p>
                <p><strong>Код продукту:</strong> {{ $detail->product->code }}</p>
                <p><strong>Ціна:</strong> {{ $detail->product_total_price }}</p>
                <p><strong>Кількість:</strong> {{ $detail->quantity_product }}</p>
                <p><strong>Колір:</strong> {{ $detail->color }}</p>
                <p><strong>Розмір:</strong> {{ $detail->size }}</p>
                <hr>
            @endforeach
        </div>
        <div class="footer">
            <p>Цей лист був згенерований автоматично. Будь ласка, не відповідайте на нього.</p>
        </div>
    </div>
</body>
</html>
