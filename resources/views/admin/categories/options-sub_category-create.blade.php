@if($cat->id != $category->parent_id)
    @if ($cat->children->isNotEmpty())
        @foreach ($cat->children as $child)
            @include('admin.categories.options-sub_category-create', ['cat' => $child, 'category' => $category, 'prefix' => $prefix . $cat->title . ' > '])
        @endforeach
    @endif
@else
    <input type="text" name="title_parent" id="title_parent" class="w-full border rounded px-3 py-2" value="{{ $prefix. $cat->title }}" disabled>
    <input type="hidden" name="parent_id" id="parent_id" value="{{ $cat->id }}">
@endif
