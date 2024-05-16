<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg p-6 bg-white">
                <h2 class="text-2xl font-semibold mb-4 text-center">Створити блог</h2>
                <form action="{{ route('blog.store') }}" method="post" class="max-w-4xl mx-auto" enctype="multipart/form-data">
                    @csrf

                    <div>
                        <div class="mb-4">
                            @error('main_image')
                            <span class="text-red-500">{{ htmlspecialchars("Ви повинні вибрати фотографію") }}</span>
                            @enderror
                            <label for="main_image" class="block mb-2 font-bold">Головна фотографія</label>
                            <input type="file" name="main_image" id="main_image" class="w-full border rounded px-3 py-2">
                        </div>

                        <div class="w-full grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                @error('alt')
                                <span class="text-red-500">{{ htmlspecialchars("Будь ласка, не більше 255 символів") }}</span>
                                @enderror
                                <label for="alt" class="block mb-2 font-bold">Alt для головної фотографії</label>
                                <input type="text" name="alt" id="alt" class="w-full border rounded px-3 py-2" value="{{ old('alt') }}">
                            </div>
                        </div>
                    </div>

                    <div class="w-full grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            @error('title')
                            <span class="text-red-500">{{ htmlspecialchars("Будь ласка, не більше 255 символів") }}</span>
                            @enderror
                            <label for="title" class="block mb-2 font-bold">Назва блогу</label>
                            <input type="text" name="title" id="title" class="w-full border rounded px-3 py-2" value="{{ old('title') }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        @error('description')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                        @enderror
                        <label for="description" class="block mb-2 font-bold">Стаття блогу</label>
                        <textarea name="description" id="description" class="w-full border rounded px-3 py-2 h-32">{{ old('description') }}</textarea>
                    </div>

                    <div class="text-center mb-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Створити блог</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
