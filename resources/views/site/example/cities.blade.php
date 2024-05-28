<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Address</title>
</head>
<body>
<h1>Адреса доставки</h1>
<form action="{{ route('delivery.submit') }}" method="post">
    @csrf

    <div>
        <label for="region">Регіон / Область</label>
        <select name="region" id="region">
            <option value="">--- Виберіть ---</option>
            @foreach($regions as $region)
                <option value="{{ $region['Ref'] }}">{{ $region['Description'] }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="city">Місто</label>
        <select name="city" id="city">
            <option value="">--- Виберіть ---</option>
        </select>
    </div>

    <div>
        <label for="nova_poshta_branch">Відділення Нової пошти</label>
        <select name="nova_poshta_branch" id="nova_poshta_branch">
            <option value="">--- Виберіть ---</option>
        </select>
    </div>

    <div>
        <label for="address">Адреса</label>
        <input type="text" name="address" id="address">
    </div>

    <button type="submit">Submit</button>
</form>
</body>
</html>
