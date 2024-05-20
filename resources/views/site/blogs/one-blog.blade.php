<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8 max-w-7xl">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-semibold mb-8 text-center">Блоги</h1>
                    <div class="flex flex-col items-center mb-8">
                        @if($blog->getMedia('blog'.$blog->id)->count() > 0)
                            @foreach($blog->getMedia('blog'.$blog->id) as $media)
                                <img src="{{ $media->getUrl() }}" alt="{{ $media->getCustomProperty('alt') }}" class="h-16 w-auto rounded-md object-cover mb-4">
                            @endforeach
                        @endif
                        <h1 class="text-2xl font-semibold">{{ $blog->title }}</h1>
                        <h2 class="text-lg">{{ $blog->description }}</h2>
                        <a href="{{ route('site.blog.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out mt-4 w-max">Назад</a>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold mb-4">Коментарі</h2>
                        @if($blog->comments->count() > 0)
                            @foreach($blog->comments as $comment)
                                <div class="mb-6 bg-gray-100 p-4 rounded-lg">
                                    <p class="font-semibold mb-2">{{ $comment->name }}</p>
                                    <p class="text-gray-600 mb-2">{{ $comment->created_at }}</p>
                                    <p>{{ $comment->comment }}</p>
                                    <button type="button" onclick="addFormAnswer(this, {{ $comment->id }})" class="mt-4 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">Відповісти на коментар</button>
                                </div>
                            @endforeach
                        @endif
                        <button type="button" onclick="addForm(this, {{ $blog->id }})" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">Додати коментар</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function addFormAnswer(element) {
        const form = `
            <form action="{{ route('blog.commentAnswerStore') }}" method="post" class="max-w-lg mx-auto bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf

                @if(isset($comment))
                    <input type="hidden" name="parent_comment_id" value="{{ $comment->id }}">
                    <input type="hidden" name="blog_id" value="{{ $comment->blog_id }}">
                    <input type="hidden" name="level" value="{{ $comment->level + 1}}">
                @endif

                <div class="w-full grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        @error('name')
                            <span class="text-red-500">{{ htmlspecialchars("Будь ласка, не більше 255 символів") }}</span>
                        @enderror
                        <label for="name" class="block mb-2 font-bold">Ім'я</label>
                        <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2" value="{{ old('alt') }}">
                    </div>
                </div>

                <div class="w-full grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        @error('email')
                            <span class="text-red-500">{{ htmlspecialchars("Будь ласка, не більше 255 символів") }}</span>
                        @enderror
                        <label for="email" class="block mb-2 font-bold">Електрона адреса</label>
                        <input type="text" name="email" id="email" class="w-full border rounded px-3 py-2" value="{{ old('alt') }}">
                    </div>
                </div>

                <div class="mb-4">
                    @error('comment')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                    @enderror
                    <label for="comment" class="block mb-2 font-bold">Відповідь на коментар</label>
                    <textarea name="comment" id="comment" rows="4" class="w-full border rounded px-3 py-2"></textarea>
                </div>

                <div class="text-center mb-4">
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full">Надати відповідь</button>
                </div>
            </form>
        `;
        element.insertAdjacentHTML('afterend', form);
        element.remove();
    }

    function addForm(element) {
        const form = `
            <form action="{{ route('site.blog.commentStore') }}" method="post" class="max-w-lg mx-auto bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf

                <input type="hidden" name="parent_comment_id" value="">
                <input type="hidden" name="blog_id" value="{{ $comment->blog_id }}">
                <input type="hidden" name="level" value="1">

                <div class="w-full grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        @error('name')
                            <span class="text-red-500">{{ htmlspecialchars("Будь ласка, не більше 255 символів") }}</span>
                        @enderror
                        <label for="name" class="block mb-2 font-bold">Ім'я</label>
                        <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2" value="{{ old('alt') }}">
                    </div>
                </div>

                <div class="w-full grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        @error('email')
                            <span class="text-red-500">{{ htmlspecialchars("Будь ласка, не більше 255 символів") }}</span>
                        @enderror
                        <label for="email" class="block mb-2 font-bold">Електрона адреса</label>
                        <input type="text" name="email" id="email" class="w-full border rounded px-3 py-2" value="{{ old('alt') }}">
                    </div>
                </div>

                <div class="mb-4">
                    @error('comment')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення") }}</span>
                    @enderror
                    <label for="comment" class="block mb-2 font-bold">Відповідь на коментар</label>
                    <textarea name="comment" id="comment" rows="4" class="w-full border rounded px-3 py-2"></textarea>
                </div>

                <div class="text-center mb-4">
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full">Написати коментарій</button>
                </div>
            </form>
        `;
        element.insertAdjacentHTML('beforebegin', form);
        element.remove();
    }
</script>
