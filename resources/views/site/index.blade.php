<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="mx-auto sm:px-6 lg:px-8 max-w-7xl">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @include('site.product.include-views.rec-products')
                @include('site.product.include-views.viewed-products')
                @include('site.product.include-views.new-products')
                @include('site.product.include-views.blogs')
                @include('site.comments.block-comments')
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const heartLinks = document.querySelectorAll('.heartLink');

        heartLinks.forEach(heartLink => {
            const productId = heartLink.getAttribute('data-product-id');
            let isLiked = heartLink.querySelector('svg').id === 'Capa_1';

            function updateHeartIcon() {
                if (isLiked) {
                    heartLink.innerHTML = `<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             width="18px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
                                            <path d="M14.708,15.847C14.252,14.864,14,13.742,14,12.5s0.252-2.489,0.708-3.659c0.455-1.171,1.114-2.266,1.929-3.205
                                            c0.814-0.938,1.784-1.723,2.86-2.271C20.574,2.814,21.758,2.5,23,2.5s2.426,0.252,3.503,0.707c1.077,0.456,2.046,1.115,2.86,1.929
                                            c0.813,0.814,1.474,1.784,1.929,2.861C31.749,9.073,32,10.258,32,11.5s-0.252,2.427-0.708,3.503
                                            c-0.455,1.077-1.114,2.047-1.929,2.861C28.55,18.678,17.077,29.044,16,29.5l0,0l0,0C14.923,29.044,3.45,18.678,2.636,17.864
                                            c-0.814-0.814-1.473-1.784-1.929-2.861C0.252,13.927,0,12.742,0,11.5s0.252-2.427,0.707-3.503
                                            C1.163,6.92,1.821,5.95,2.636,5.136C3.45,4.322,4.42,3.663,5.497,3.207C6.573,2.752,7.757,2.5,9,2.5s2.427,0.314,3.503,0.863
                                            c1.077,0.55,2.046,1.334,2.861,2.272c0.814,0.939,1.473,2.034,1.929,3.205C17.748,10.011,18,11.258,18,12.5s-0.252,2.364-0.707,3.347
                                            c-0.456,0.983-1.113,1.828-1.929,2.518"/>
                                        </svg>`;
                } else {
                    heartLink.innerHTML = `<svg version="1.1" id="Layer_2" xmlns="http://www.w3.org/2000/svg" width="18px" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve">
                                        <path d="M50,91.5C50,91.5,50,91.5,50,91.5c-0.8,0-1.6-0.3-2.2-0.9L8.5,51.1c-4.9-4.8-7.5-11.6-7.3-18.7c0.4-7.1,3.7-13.8,9.1-18.4
                                            c4.5-3.6,9.9-5.5,15.6-5.5c6.9,0,13.7,2.8,18.6,7.7l5.5,5.5l5.5-5.4c9.6-9.6,24.3-10.5,34.2-2c5.4,4.3,8.7,10.8,9.1,17.9
                                            c0.4,7.1-2.3,14.1-7.3,19.1L52.1,90.7C51.6,91.2,50.8,91.5,50,91.5z M48.6,87.1C48.6,87.1,48.6,87.1,48.6,87.1L48.6,87.1z
                                            M25.9,13.5c-4.6,0-8.9,1.5-12.5,4.4c-4.3,3.7-7,9-7.3,14.7C6,38.3,8.1,43.7,12,47.5l38,38.2l38-38c4-4,6.1-9.7,5.8-15.3
                                            c-0.3-5.6-2.9-10.8-7.3-14.3c-7.9-6.8-19.7-6.1-27.5,1.7l-9,8.9l-9-9C37.1,15.7,31.5,13.5,25.9,13.5z"/>
                                    </svg>`;
                }
            }

            heartLink.addEventListener('click', (event) => {
                event.preventDefault();
                if (isLiked) {
                    removeProductFromLiked();
                } else {
                    addProductToLiked();
                }
            });

            function addProductToLiked() {
                fetch(`/product/likedProduct/${productId}`)
                    .then(response => response.json())
                    .catch(error => {
                        console.error('Error fetching product:', error);
                    });
                isLiked = true;
                updateHeartIcon();
            }

            function removeProductFromLiked() {
                fetch(`/product/unlinkedProduct/${productId}`)
                    .then(response => response.json())
                    .catch(error => {
                        console.error('Error fetching product:', error);
                    });
                isLiked = false;
                updateHeartIcon();
            }

            updateHeartIcon();
        });

        const openPopupLinks = document.querySelectorAll('.open-popup');
        const popup = document.getElementById('comment-popup');
        const popupContent = document.getElementById('popup-comment-content');
        const popupName = document.getElementById('popup-comment-name');
        const popupDate = document.getElementById('popup-comment-date');
        const closePopupButton = document.querySelector('.close-popup');

        openPopupLinks.forEach(link => {
            link.addEventListener('click', (event) => {
                event.preventDefault();
                const comment = link.getAttribute('data-comment');
                const name = link.getAttribute('data-name');
                const date = link.getAttribute('data-date');

                popupContent.textContent = comment;
                popupName.textContent = name;
                popupDate.textContent = date;
                popup.classList.remove('hidden');
            });
        });

        closePopupButton.addEventListener('click', () => {
            popup.classList.add('hidden');
        });

        popup.addEventListener('click', (event) => {
            if (event.target === popup) {
                popup.classList.add('hidden');
            }
        });
    });
</script>
