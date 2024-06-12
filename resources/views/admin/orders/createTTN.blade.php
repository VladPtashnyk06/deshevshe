<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg p-6 bg-white">
                <h2 class="text-2xl font-semibold mb-4 text-center">Сформувати ТТН</h2>
                <form id="ttnForm">

                    <input type="hidden" name="delivery_id" value="{{ $delivery->id }}">
                    <input type="hidden" name="order_id" value="{{ $order->id }}">

                    <div class="flex grid lg:grid-cols-3">
                        <div class="mb-4 mr-4">
                            @error('width')
                            <span class="text-red-500">{{ htmlspecialchars("Це поле є обо'вязковим для заповнення та унікальким") }}</span>
                            @enderror
                            <label for="width" class="block mb-2 font-bold">Ширина (см)</label>
                            <input type="number" name="width" min="0.1" step="0.1" id="width" class="w-full border rounded px-3 py-2" value="">
                        </div>
                        <div class="mb-4 mr-4">
                            @error('length')
                            <span class="text-red-500">{{ htmlspecialchars("Це поле є обо'вязковим для заповнення та унікальким") }}</span>
                            @enderror
                            <label for="length" class="block mb-2 font-bold">Довжина (см)</label>
                            <input type="number" name="length" min="0.1" step="0.1" id="length" class="w-full border rounded px-3 py-2" value="">
                        </div>
                        <div class="mb-4">
                            @error('height')
                            <span class="text-red-500">{{ htmlspecialchars("Це поле є обо'вязковим для заповнення та унікальким") }}</span>
                            @enderror
                            <label for="height" class="block mb-2 font-bold">Висота (см)</label>
                            <input type="number" name="height" min="0.1" step="0.1" id="height" class="w-full border rounded px-3 py-2" value="">
                        </div>
                    </div>

                    <div class="mb-4">
                        @error('weight')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обо'вязковим для заповнення та унікальким") }}</span>
                        @enderror
                        <label for="weight" class="block mb-2 font-bold">Вага</label>
                        <input type="number" name="weight" min="0.1" step="0.1" id="weight" class="w-full border rounded px-3 py-2" value="">
                    </div>

                    <div class="mb-4">
                        @error('description')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення та унікальним") }}</span>
                        @enderror
                        <label for="description" class="block mb-2 font-bold">Опис</label>
                        <input type="text" name="description" id="description" class="w-full border rounded px-3 py-2" value="">
                    </div>

                    @if($delivery->delivery_method == 'courier')
                        <div class="mb-4">
                            @error('recipient_address_name')
                            <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення та унікальним") }}</span>
                            @enderror
                            <label for="recipient_address_name" class="block mb-2 font-bold">Вулиця</label>
                            <input type="text" name="recipient_address_name" id="recipient_address_name" class="w-full border rounded px-3 py-2" value="{{ $recipientAddressName ? $recipientAddressName : old('recipient_address_name') }}">
                        </div>
                        <div class="mb-4">
                            @error('recipient_house')
                            <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення та унікальним") }}</span>
                            @enderror
                            <label for="recipient_house" class="block mb-2 font-bold">№ Будинку</label>
                            <input type="text" name="recipient_house" id="recipient_house" class="w-full border rounded px-3 py-2" value="{{ $recipientHouse ? $recipientHouse : old('recipient_house') }}">
                        </div>
                        <div class="mb-4">
                            @error('recipient_flat')
                            <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення та унікальним") }}</span>
                            @enderror
                            <label for="recipient_flat" class="block mb-2 font-bold">№ Квартири</label>
                            <input type="text" name="recipient_flat" id="recipient_flat" class="w-full border rounded px-3 py-2" value="{{ $recipientFlat ? $recipientFlat : old('recipient_flat') }}">
                        </div>
                    @endif

                    <div class="mb-4">
                        @error('recipient_type')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення та унікальним") }}</span>
                        @enderror
                        <label for="recipient_type" class="block mb-2 font-bold">Тип отримувача</label>
                        <select name="recipient_type" id="recipient_type" class="w-full border rounded px-3 py-2">
                            <option value=""> Виберіть </option>
                            <option value="PrivatePerson"> Приватна особа </option>
                            <option value="Organization"> Організація </option>
                        </select>
                    </div>

                    <div class="text-center mb-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Сформувати ТТН</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.getElementById('ttnForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const csrfToken = '{{ csrf_token() }}';
        const form = event.target;
        const width = form.width.value;
        const height = form.height.value;
        const length = form.length.value;
        const weight = form.weight.value;
        const description = form.description.value;
        const deliveryId = form.delivery_id.value;
        const orderId = form.order_id.value;
        const recipientType = form.recipient_type.value;
        let recipientAddressName = form.recipient_address_name ? form.recipient_address_name.value : '';
        let recipientHouse = form.recipient_house ? form.recipient_house.value : '';
        let recipientFlat = form.recipient_flat ? form.recipient_flat.value : '';

        console.log(orderId, width, height, length, weight, description)

        fetch(`/operator/orders/ttn/store/${deliveryId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                order_id: orderId,
                width: width,
                length: length,
                height: height,
                weight: weight,
                description: description,
                recipient_address_name: recipientAddressName,
                recipient_house: recipientHouse,
                recipient_flat: recipientFlat,
                recipient_type: recipientType
            })
        })
            .then(response =>
                response.json()
            )
            .then(data => {
                if (data.success) {
                    window.location.href = `/operator/orders/thank-ttn/${orderId}`;
                } else {
                    console.error('Error:', data.message);
                }
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
    });
</script>
