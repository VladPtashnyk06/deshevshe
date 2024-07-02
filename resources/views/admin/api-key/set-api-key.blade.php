<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg p-6 bg-white">
                <h2 class="text-2xl font-semibold mb-4 text-center">Поміняти api</h2>
                <form action="{{ route('api.update') }}" method="post" class="max-w-4xl mx-auto">
                    @csrf

                    <div class="mb-4">
                        @error('category_id')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                        @enderror
                        <label for="delivery" class="block mb-2 font-bold">Доставка</label>
                        <select name="delivery" id="delivery" class="w-full border rounded px-3 py-2">
                            <option value="">Всі доставки</option>
                            <option value="NovaPoshta">Нова Пошта</option>
                            <option value="UkrPoshta">Укр пошта</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('title')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення та унікальним") }}</span>
                        @enderror
                        <label for="apiKey" class="block mb-2 font-bold">Api-key</label>
                        <input type="text" name="apiKey" id="apiKey" class="w-full border rounded px-3 py-2" value="{{ old('apiKey') }}">
                    </div>

                    <div class="text-center mb-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Поміняти api-key</button>
                    </div>

                    <a class="text-center bg-gray-300 py-2 rounded hover:bg-gray-400 transition duration-300" href="{{ route('api.index') }}">
                        Назад
                    </a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
