<!DOCTYPE html>
<html>
<head>
    <title>Запит на зворотній дзвінок</title>
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
        <h1>Запит на зворотній дзвінок</h1>
    </div>
    <div class="content">
        <p><strong>Ім'я:</strong> {{ $details['name'] }}</p>
        <p><strong>Телефон:</strong> {{ $details['phone'] }}</p>
        <p><strong>Повідомлення:</strong> {{ $details['message'] }}</p>
    </div>
    <div class="footer">
        <p>Цей лист був згенерований автоматично. Будь ласка, не відповідайте на нього.</p>
    </div>
</div>
</body>
</html>
