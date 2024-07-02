<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg p-6 bg-white">
                <h2 class="text-2xl font-semibold mb-4 text-center">Створити під-категорію</h2>
                <form action="{{ route('category.store') }}" method="post" class="max-w-4xl mx-auto" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        @error('id')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле обов'язкове і унікальне") }}</span>
                        @enderror
                        <label for="id" class="block mb-2 font-bold">ID</label>
                        <input type="number" name="id" id="id" class="w-full border rounded px-3 py-2" value="{{ old('id') }}">
                    </div>

                    <div class="mb-4">
                        @error('title')
                        <span class="text-red-500">Це поле обов'язкове і унікальне</span>
                        @enderror
                        <label for="title_parent" class="block mb-2 font-bold">Категорія</label>
                        <input type="text" name="title_parent" id="title_parent" class="w-full border rounded px-3 py-2" value="{{ $categoryChain }}" disabled>
                        <input type="hidden" name="parent_id" id="parent_id" value="{{ $category->id }}">
                    </div>

                    <div class="mb-4">
                        @error('title')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле обов'язкове і унікальне") }}</span>
                        @enderror
                        <label for="title" class="block mb-2 font-bold">Під-категорія</label>
                        <input type="text" name="title" id="title" class="w-full border rounded px-3 py-2" value="{{ old('title') }}">
                    </div>

                    <div class="mb-4">
                        @error('level')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле обов'язкове і унікальне") }}</span>
                        @enderror
                        <label for="level" class="block mb-2 font-bold">Порядок сортування</label>
                        <input type="number" name="level" id="level" class="w-full border rounded px-3 py-2" placeholder="За замовчуванням 1" value="{{ old('level', 1) }}">
                    </div>

                    <div class="text-center mb-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Створити під-категорію</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
