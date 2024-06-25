<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg p-6 bg-white">
                <h2 class="text-2xl font-semibold mb-4 text-center">Створити оператора</h2>
                <form action="{{ route('user.storeOperator') }}" method="post" class="max-w-4xl mx-auto" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block mb-2 font-bold">Логін</label>
                        <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2" required value="{{ old('name') }}">
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block mb-2 font-bold">Пароль</label>
                        <input type="text" name="password" id="password" class="w-full border rounded px-3 py-2" required value="{{ old('password') }}">
                    </div>

                    <div class="text-center mb-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Створити Оператора</button>
                    </div>
                    <a href="{{ route('user.index') }}" class="block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border text-center">Назад</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
