<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-semibold mb-4 text-center">Редагувати розмір</h2>
                <form action="{{ route('comment.update', $comment->id) }}" method="post" class="max-w-4xl mx-auto" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        @error('name')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення та унікальним") }}</span>
                        @enderror
                        <label for="name" class="block mb-2 font-bold">Ім'я</label>
                        <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2" value="{{ $comment->name }}">
                    </div>

                    <div class="mb-4">
                        @error('last_name')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення та унікальним") }}</span>
                        @enderror
                        <label for="last_name" class="block mb-2 font-bold">Прізвище</label>
                        <input type="text" name="last_name" id="last_name" class="w-full border rounded px-3 py-2" value="{{ $comment->last_name }}">
                    </div>

                    <div class="mb-4">
                        @error('comment')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення та унікальним") }}</span>
                        @enderror
                        <label for="comment" class="block mb-2 font-bold">Коментар</label>
                        <textarea class="w-full border rounded px-3 py-2" name="comment" id="comment">{{ $comment->comment }}</textarea>
                    </div>

                    <div class="text-center mb-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Оновити коментар</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
