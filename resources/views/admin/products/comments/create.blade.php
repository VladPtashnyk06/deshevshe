<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg p-6 bg-white">
                <h2 class="text-2xl font-semibold mb-4 text-center">Надати відповідь до коментаря</h2>
                <form action="{{ route('product.comment.store') }}" method="post" class="max-w-4xl mx-auto" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="parent_comment_id" value="{{ $productComment->id }}">
                    <input type="hidden" name="product_id" value="{{ $productComment->product_id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="level" value="{{ $productComment->level + 1 }}">
                    <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                    <input type="hidden" name="email" value="{{ Auth::user()->email }}">

                    <div class="mb-4">
                        <label for="comment" class="block mb-2 font-bold">Попередній коментар</label>
                        <input type="text" name="comment" id="comment" class="w-full border rounded px-3 py-2" disabled value="{{ $productComment->comment }}">
                    </div>

                    <div class="mb-4">
                        @error('comment')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                        @enderror
                        <label for="comment" class="block mb-2 font-bold">Відповідь на коментар</label>
                        <input type="text" name="comment" id="comment" class="w-full border rounded px-3 py-2"  value="{{ old('title') }}">
                    </div>

                    <div class="text-center mb-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Надати відповідь на коментар</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
