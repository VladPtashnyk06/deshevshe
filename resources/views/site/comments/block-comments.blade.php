<div class="p-6 text-gray-900">
    <h1 class="text-3xl font-semibold mb-6 text-center"><a href="{{ route('site.comment.index') }}">Коментарі до сайту</a></h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @if($comments->isNotEmpty())
            @foreach($comments as $comment)
                <div class="bg-white p-4 rounded-lg shadow-lg flex flex-col items-center relative">
                    <div class="text-center">
                        <div class="mb-4 bg-gray-100 p-4 rounded-lg">
                            <p class="font-semibold mb-2">{{ ucfirst($comment->name) . ' ' . ucfirst($comment->last_name) }}</p>
                            <p class="text-gray-600 mb-2">{{ $comment->created_at }}</p>
                            <p>{{ Str::limit(ucfirst($comment->comment), 80) }}</p>
                        </div>
                        <p><a href="#" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border open-popup" data-name="{{ ucfirst($comment->name) . ' ' . ucfirst($comment->last_name) }}" data-date="{{ $comment->created_at }}" data-comment="{{ ucfirst($comment->comment) }}">Весь коментар</a></p>
                    </div>
                </div>
            @endforeach
        @else
            Поки немає коментарів
        @endif
    </div>
</div>

<!-- Попап -->
<div id="comment-popup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50 bg-gray-500">
    <div class="bg-white p-8 rounded-lg shadow-lg mx-auto max-w-4xl relative">
        <button class="close-popup absolute text-gray-600 hover:text-gray-900 transition duration-300 ease-in-out" style="top: 4px; right: 4px;">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <div class="p-6 text-gray-900">
            <div class="text-center" style="margin: 4px">
                <div class="mb-4 bg-gray-100 p-4 rounded-lg">
                    <p class="font-semibold mb-2" id="popup-comment-name"></p>
                    <p class="text-gray-600 mb-2" id="popup-comment-date"></p>
                    <p id="popup-comment-content"></p>
                </div>
            </div>
        </div>
    </div>
</div>
