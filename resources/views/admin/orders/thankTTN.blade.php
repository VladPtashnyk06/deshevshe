<x-app-layout>
    <main itemscope itemtype="http://schema.org/ItemList">
        <section class="mx-auto py-12" style="max-width: 105rem">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-4 text-center">ТТН успішно створено</h1>
                <p class="text-gray-700 text-center">Ваш номер ТТН: {{ $order->int_doc_number }}</p>
                <div class="text-center mt-6">
                    @if($order->delivery->delivery_name == 'NovaPoshta')
                        <a href="{{ route('operator.order.novaPoshta.ttnPdf', $order->id) }}" target="_blank" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Переглянути документ
                        </a>
                    @else
                        <a href="{{ route('operator.order.ukrPoshta.ttnPdf', $order->id) }}" target="_blank" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Переглянути документ
                        </a>
                    @endif
                </div>
                <div class="text-center mt-6">
                    <a href="{{ route('operator.order.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        До замовлень
                    </a>
                </div>
            </div>
        </section>
    </main>
</x-app-layout>
