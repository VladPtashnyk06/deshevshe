<style>
    /* Tailwind CSS classes are used for general styling. Additional styles can be added here. */
    .group:hover .group-hover\:block {
        display: block;
    }
    .group:hover .group-hover\:rotate-180 {
        transform: rotate(180deg);
    }
</style>

<li class="border-b border-gray-200 py-4 relative group category-item">
    <div class="flex justify-between items-center">
        <a href="{{ route('site.product.show', $category->id) }}"><span class="text-lg font-semibold">{{ $category->title }}</span></a>
        @if($category->children->isNotEmpty())
            <svg class="w-6 h-6 text-gray-500 cursor-pointer transition-transform transform group-hover:rotate-180" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10 3.333C5.733 3.333 2.167 6.9 2.167 11.167c0 4.267 3.566 7.833 7.833 7.833 4.267 0 7.833-3.566 7.833-7.833 0-4.267-3.566-7.834-7.833-7.834zm0 1.5c3.42 0 6.333 2.796 6.333 6.334 0 3.538-2.913 6.333-6.333 6.333-3.42 0-6.333-2.795-6.333-6.333 0-3.538 2.913-6.334 6.333-6.334zm0 4.166a.75.75 0 011.5 0v3.167h3.166a.75.75 0 010 1.5H10a.75.75 0 01-.75-.75V8zm-1.5 0a.75.75 0 00-1.5 0v3.167H4.584a.75.75 0 000 1.5H8a.75.75 0 00.75-.75V8z" clip-rule="evenodd"/>
            </svg>
        @endif
    </div>
    <ul class="pl-6 mt-4 ml-2 border-l border-gray-200 hidden sub-category-list">
        @foreach($category->children as $child)
            @include('site.filter.filter', ['category' => $child])
        @endforeach
    </ul>
</li>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categories = document.querySelectorAll('.category-item');

        categories.forEach(category => {
            category.addEventListener('mouseover', function () {
                const sublist = category.querySelector('.sub-category-list');
                if (sublist) {
                    sublist.classList.remove('hidden');
                }
            });

            category.addEventListener('mouseout', function () {
                const sublist = category.querySelector('.sub-category-list');
                if (sublist) {
                    sublist.classList.add('hidden');
                }
            });
        });
    });
</script>
