<x-app-layout>
    <main itemscope itemtype="http://schema.org/ItemList">
        <section class="max-w-7xl mx-auto py-12">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h1 class="text-3xl font-semibold mb-6 text-left" itemprop="name">Редагувати замовлення №{{ $order->id }}</h1>
                <div class="flex flex-col md:flex-row md:justify-between">
                    <form action="{{ route('operator.order.smallUpdate', $order->id) }}" method="post" class="w-full">
                        @csrf

                        <div class="mb-4">
                            <label for="operator_comment" class="block mb-2 font-bold w-full">Коментар</label>
                            <input type="text" name="operator_comment" id="operator_comment" class="w-full border rounded px-3 py-2" value="{{ $order->operator_comment }}">
                        </div>

                        <div class="mb-4">
                            <label for="return_payment" class="block mb-2 font-bold">Сума повернення</label>
                            <input type="text" name="return_payment" id="return_payment" class="w-full border rounded px-3 py-2" value="{{ $order->return_payment }}">
                        </div>

                        <div class="mt-4">
                            <a class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border" href="{{ route('operator.order.index') }}">
                                Назад
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border">Оновити дані замовлення</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
</x-app-layout>
