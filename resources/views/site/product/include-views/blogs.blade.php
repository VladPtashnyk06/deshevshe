<div class="p-6 text-gray-900">
    <h1 class="text-3xl font-semibold mb-6 text-center"><a href="{{ route('site.blog.index') }}">Останні публікації в блозі</a></h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
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
