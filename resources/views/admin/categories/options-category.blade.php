<option value="{{ $category->id }}">{{ $prefix }}{{ $category->title }}</option>
@if ($category->children->isNotEmpty())
    @foreach ($category->children as $child)
        @include('admin.categories.options-category', ['category' => $child, 'prefix' => $prefix . $category->title . ' > '])
    @endforeach
@endif
