<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg p-6 bg-white">
                <h2 class="text-2xl font-semibold mb-4 text-center">Створити категорію</h2>
                <form action="{{ route('category.store') }}" method="post" class="max-w-4xl mx-auto" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="parent_id" class="block mb-2 font-bold">Виберіть батьківську категорію</label>
                        <select name="parent_id" id="parent_id" class="w-full border rounded px-3 py-2">
                            <option value="">Без категорії</option>
                            @foreach($categories as $category)
                                @include('admin.categories.options-category', ['category' => $category, 'prefix' => ''])
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        @error('title')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле обов'язкове і унікальне") }}</span>
                        @enderror
                        <label for="title" class="block mb-2 font-bold">Категорія</label>
                        <input type="text" name="title" id="title" class="w-full border rounded px-3 py-2" value="{{ old('title') }}">
                    </div>

                    <div class="mb-4">
                        @error('title')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле обов'язкове і унікальне") }}</span>
                        @enderror
                        <label for="level" class="block mb-2 font-bold">Порядок сортування</label>
                        <input type="text" name="level" id="level" class="w-full border rounded px-3 py-2" placeholder="За замовчуванням 1" value="{{ !empty(old('level')) ? old('level') : 1 }}">
                    </div>

                    <div class="text-center mb-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Створити категорію</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
