<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg p-6 bg-white">
                <h2 class="text-2xl font-semibold mb-4 text-center">Додати ттн до замовлення</h2>
                <form action="{{ route('operator.order.updateTTNtoOrder', $order->id) }}" method="post" class="max-w-4xl mx-auto" enctype="multipart/form-data">
                    @csrf

                    <h2>Замовлення №{{ $order->id }}</h2>

                    <div class="mb-4">
                        @error('ttn')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення та унікальним") }}</span>
                        @enderror
                        <label for="ttn" class="block mb-2 font-bold">ТТН</label>
                        <input type="text" name="ttn" id="ttn" class="w-full border rounded px-3 py-2" value="{{ old('ttn') }}">
                    </div>

                    <div class="text-center mb-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Додати ттн</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
