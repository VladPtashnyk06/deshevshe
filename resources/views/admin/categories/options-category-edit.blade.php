<option value="{{ $cat->id }}" {{ $cat->id == $category->parent_id ? 'selected' : '' }}>{{ $prefix }}{{ $cat->title }}</option>
@if ($cat->children->isNotEmpty())
    @foreach ($cat->children as $child)
        @include('admin.categories.options-category-edit', ['cat' => $child, 'prefix' => $prefix . $cat->title . ' > '])
    @endforeach
@endif
