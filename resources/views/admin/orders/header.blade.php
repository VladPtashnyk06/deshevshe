<h1 class="text-3xl font-semibold mb-6 text-left" itemprop="name">Редагувати замовлення №{{ $order->id }}</h1>
<div class="flex justify-center text-center">
    <a href="{{ route('operator.order.editFirst', $order->id) }}" class="bg-gray-300 flex-grow border-b-4 border-transparent {{ Request::is('operator/order/edit_first/*') ? 'border-black' : '' }}">1. Дані клієнта</a>
    <a href="{{ route('operator.order.editSecond', $order->id) }}" class="bg-gray-300 flex-grow border-b-4 border-transparent" {{ Request::is('operator/order/edit_second/*') ? 'border-black' : '' }}">2. Товари</a>
    <a href="{{ route('operator.order.editThird', $order->id) }}" class="bg-gray-300 flex-grow border-b-4 border-transparent">3. Платіжні реквізити</a>
    <a href="{{ route('operator.order.editFourth', $order->id) }}" class="bg-gray-300 flex-grow border-b-4 border-transparent">4. Загалом</a>
</div>
