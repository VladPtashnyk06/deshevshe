<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="mx-auto sm:px-6 lg:px-8 max-w-7xl">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @foreach($blogs as $blog)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden ml-2 mb-2">
                        @if($blog->getMedia('blog'.$blog->id)->count() > 0)
                            @foreach($blog->getMedia('blog'.$blog->id) as $media)
                                <img src="{{ $media->getUrl() }}" alt="{{ $media->getCustomProperty('alt') }}" class="h-48 w-full object-cover">
                            @endforeach
                        @endif
                        <div class="p-6">
                            <h1 class="text-lg font-semibold mb-2">{{ $blog->title }}</h1>
                            <p class="text-gray-600 mb-4">{{ Str::limit($blog->description, 80) }}</p>
                            <a href="{{ route('site.blog.show', $blog->id) }}" class="block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md text-center transition duration-300 ease-in-out">Читати більше</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
