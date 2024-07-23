<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg p-6 bg-white">
                <h2 class="text-2xl font-semibold mb-4 text-center">Створити сертифікат</h2>
                <form action="{{ route('certificate.store') }}" method="post" class="max-w-4xl mx-auto" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        @error('title')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення та унікальним") }}</span>
                        @enderror
                        <label for="title" class="block mb-2 font-bold">Сертифікат</label>
                        <input type="text" name="title" id="title" class="w-full border rounded px-3 py-2" value="{{ old('title') }}">
                    </div>

                    <div class="mb-4">
                        @error('rate')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення та унікальним") }}</span>
                        @enderror
                        <label for="rate" class="block mb-2 font-bold">Знижка</label>
                        <input type="number" min="1" max="80" name="rate" id="rate" class="w-full border rounded px-3 py-2" value="{{ old('rate') }}">
                    </div>

                    <div class="mb-4">
                        @error('quantity')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення та унікальним") }}</span>
                        @enderror
                        <label for="quantity" class="block mb-2 font-bold">Максимальна кількість використань</label>
                        <input type="number" min="1" name="quantity" id="quantity" class="w-full border rounded px-3 py-2" value="{{ old('quantity') }}">
                    </div>

                    <div class="text-center mb-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Створити сертифікат</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
