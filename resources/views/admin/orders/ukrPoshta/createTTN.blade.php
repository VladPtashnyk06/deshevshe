<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8 max-w-7xl">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg p-6 bg-white">
                <h2 class="text-2xl font-semibold mb-4 text-center">Сформувати ТТН</h2>
                <form id="ttnForm">

                    @if($sender)
                        <h2 class="text-xl font-semibold mb-4 text-left">Відправник</h2>
                        <input type="hidden" name="sender_uuid" id="sender_uuid" value="{{ $sender['uuid'] }}">
                        <div class="flex grid lg:grid-cols-2">
                            <div class="mb-4 mr-4">
                                <label class="block mb-2 font-bold">Назва фірми</label>
                                <input type="text" class="w-full border rounded px-3 py-2" value="{{ $sender['name'] }}" disabled>
                            </div>
                            <div class="mb-4">
                                <label class="block mb-2 font-bold">Тип</label>
                                <input type="text" class="w-full border rounded px-3 py-2" value="{{ $sender['type'] }}" disabled>
                            </div>
                            <div class="mb-4 mr-4">
                                <label class="block mb-2 font-bold">Номер телефону</label>
                                <input type="text" class="w-full border rounded px-3 py-2" value="{{ $sender['phoneNumber'] }}" disabled>
                            </div>
                            <div class="mb-4">
                                <label class="block mb-2 font-bold">EDRPOU</label>
                                <input type="text" class="w-full border rounded px-3 py-2" value="{{ $sender['edrpou'] }}" disabled>
                            </div>
                        </div>
                    @else
                        <h2 class="text-xl font-semibold mb-4 text-left">Cтворити відправника</h2>
                        <div class="flex grid lg:grid-cols-2">
                            <div class="mb-4 mr-4">
                                @error('sender_postcode')
                                <span class="text-red-500">{{ htmlspecialchars("Це поле є обо'вязковим для заповнення та унікальким") }}</span>
                                @enderror
                                <label for="sender_postcode" class="block mb-2 font-bold">Індекс</label>
                                <input type="number" name="sender_postcode" id="sender_postcode" class="w-full border rounded px-3 py-2" value="">
                            </div>
                            <div class="mb-4">
                                @error('sender_city')
                                <span class="text-red-500">{{ htmlspecialchars("Це поле є обо'вязковим для заповнення та унікальким") }}</span>
                                @enderror
                                <label for="sender_city" class="block mb-2 font-bold">Місто відправника(місто з якого будуть відправляти)</label>
                                <input type="text" name="sender_city" id="sender_city" class="w-full border rounded px-3 py-2" value="">
                            </div>
                            <div class="mb-4 mr-4">
                                @error('sender_name')
                                <span class="text-red-500">{{ htmlspecialchars("Це поле є обо'вязковим для заповнення та унікальким") }}</span>
                                @enderror
                                <label for="sender_name" class="block mb-2 font-bold">Назва компанії</label>
                                <input type="text" name="sender_name" id="sender_name" class="w-full border rounded px-3 py-2" value="">
                            </div>
                            <div class="mb-4">
                                @error('sender_phone_number')
                                <span class="text-red-500">{{ htmlspecialchars("Це поле є обо'вязковим для заповнення та унікальким") }}</span>
                                @enderror
                                <label for="sender_phone_number" class="block mb-2 font-bold">Телефон відправника</label>
                                <input type="text" name="sender_phone_number" id="sender_phone_number" class="w-full border rounded px-3 py-2" value="{{ Str::startsWith($phone, '+') ? Str::replaceFirst('+', '', $phone) : $phone }}" disabled>
                            </div>
                            <div class="mb-4 mr-4">
                                @error('sender_edrpou')
                                <span class="text-red-500">{{ htmlspecialchars("Це поле є обо'вязковим для заповнення та унікальким") }}</span>
                                @enderror
                                <label for="sender_edrpou" class="block mb-2 font-bold">EDRPOU</label>
                                <input type="number" name="sender_edrpou" min="1" id="sender_edrpou" class="w-full border rounded px-3 py-2" value="">
                            </div>
                        </div>
                    @endif

                    <h2 class="text-xl font-semibold mb-4 text-left">Надання інформації про ттн</h2>
                    <div class="flex grid lg:grid-cols-3">
                        <div class="mb-4 mr-4">
                            @error('width')
                            <span class="text-red-500">{{ htmlspecialchars("Це поле є обо'вязковим для заповнення та унікальким") }}</span>
                            @enderror
                            <label for="width" class="block mb-2 font-bold">Ширина (см)</label>
                            <input type="number" name="width" min="1" step="0.1" id="width" required class="w-full border rounded px-3 py-2" value="">
                        </div>
                        <div class="mb-4 mr-4">
                            @error('length')
                            <span class="text-red-500">{{ htmlspecialchars("Це поле є обо'вязковим для заповнення та унікальким") }}</span>
                            @enderror
                            <label for="length" class="block mb-2 font-bold">Довжина (см)</label>
                            <input type="number" name="length" min="1" step="0.1" id="length" required class="w-full border rounded px-3 py-2" value="">
                        </div>
                        <div class="mb-4">
                            @error('height')
                            <span class="text-red-500">{{ htmlspecialchars("Це поле є обо'вязковим для заповнення та унікальким") }}</span>
                            @enderror
                            <label for="height" class="block mb-2 font-bold">Висота (см)</label>
                            <input type="number" name="height" min="1" step="0.1" id="height" required class="w-full border rounded px-3 py-2" value="">
                        </div>
                    </div>

                    <div class="mb-4">
                        @error('weight')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обо'вязковим для заповнення та унікальким") }}</span>
                        @enderror
                        <label for="weight" class="block mb-2 font-bold">Вага (кг)</label>
                        <input type="number" name="weight" min="0.1" step="0.1" max="30" id="weight" required class="w-full border rounded px-3 py-2" value="">
                    </div>

                    <div class="mb-4">
                        @error('description')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення та унікальним") }}</span>
                        @enderror
                        <label for="description" class="block mb-2 font-bold">Опис</label>
                        <input type="text" name="description" id="description" class="w-full border rounded px-3 py-2" value="">
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
        const postcode = form.sender_postcode ? form.sender_postcode.value : '';
        const senderCity = form.sender_city ? form.sender_city.value : '';
        const senderName = form.sender_name ? form.sender_name.value : '';
        const senderUuid = form.sender_uuid ? form.sender_uuid.value : '';
        let senderPhoneNumber = form.sender_phone_number ? form.sender_phone_number.value : '';
        let senderEdrpou = form.sender_edrpou ? form.sender_edrpou.value : '';

        console.log(width, height, length, weight, description, postcode, senderCity, senderName, senderPhoneNumber, senderEdrpou)
        console.log(senderUuid)

        fetch(`/operator/orders/ukrposhta/ttn/store/{{$order->delivery->id}}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                width: width,
                length: length,
                height: height,
                weight: weight,
                description: description,
                sender_postcode: postcode,
                sender_city: senderCity,
                sender_name: senderName,
                sender_phone_number: senderPhoneNumber,
                sender_edrpou: senderEdrpou,
                sender_uuid: senderUuid
            })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log(data)
                if (data) {
                    window.location.href = `/operator/orders/ukrposhta/thank-ttn/{{$order->id}}`;
                }
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
    });
</script>
