<x-site-layout>
    <main class="wrapper">
        <div class="d-flex flex-arrow">
            <a class="arrow-up arrow" href="#body">
                <svg fill="none" height="10" viewbox="0 0 18 10" width="18" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 9L9 0.999999L17 9" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
            </a>
            <a class="arrow-down arrow" href="#footer">
                <svg fill="none" height="10" viewbox="0 0 18 10" width="18" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 0.999999L9 9L17 1" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
            </a>
        </div>
        <p class="page-look d-flex">
            <a href="{{ route('site.index') }}">головна</a>
            <span>/</span>
            <span class="selected-page">відгуки</span>
        </p>
        <section class="comment-section-page">
            <div class="flex-between comment-card-block">
                <div class="comment-block">
                    <h1 class="comment-head-page">відгуки про магазин:</h1>
                    <div class="comment-items">
                        @if(!empty($comments))
                            @foreach($comments as $comment)
                                <div class="comment">
                                    <div class="flex-between item-center head-comment">
                                        <p>{{ ucfirst($comment->name) . ' ' . ucfirst($comment->last_name) }}</p>
                                        <p>{{ date_format($comment->created_at, 'Y-m-d') }}</p>
                                    </div>
                                    <div class="descript-comment">
                                        <p>{{ ucfirst($comment->comment) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="catalog-cta-center">
                        <div class="cta-more">
                            <a href="#">переглянути ще</a>
                        </div>
                    </div>
                    <div class="item-center d-flex pagination">
                        <a class="pagination-button to-start" href="#">
                            <svg fill="none" height="14" viewbox="0 0 13 14" width="13" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 13L1 7L7 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M12 13L6 7L12 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                        <a class="pagination-button cta-prev" href="#">
                            <svg fill="none" height="14" viewbox="0 0 8 14" width="8" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 13L1 7L7 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                        <a class="pagination-button page" href="#">
                            <span>1</span>
                        </a>
                        <a class="pagination-button page" href="#">
                            <span>2</span>
                        </a>
                        <a class="pagination-button page" href="#">
                            <span>3</span>
                        </a> <a class="pagination-button page current-page" href="#">
                            <span>4</span>
                        </a>
                        <a class="pagination-button page" href="#">
                            <span>5</span>
                        </a> <a class="pagination-button page" href="#">
                            <span>6</span>
                        </a>
                        <a class="pagination-button cta-next" href="#">
                            <svg fill="none" height="14" viewbox="0 0 8 14" width="8" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 13L7 7L1 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                        <a class="pagination-button to-end" href="#">
                            <svg fill="none" height="14" viewbox="0 0 13 14" width="13" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 13L12 7L6 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M1 13L7 7L1 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="form-comment">
                    <form action="{{ route('site.comment.store') }}" method="post">
                        @csrf

                        <p class="head-comment-form">Залишити відгук</p>
                        <p>
                            <label for="name">Імʼя та прізвище*</label>
                        </p>
                        <p>
                            <input id="name" name="name" placeholder="Імʼя та прізвище" required="" type="text">
                        </p>
                        <p>
                            <label for="mail">E-mail*</label>
                        </p>
                        <p>
                            <input id="mail" name="email" placeholder="E-mail" required="" type="email">
                        </p>
                        <p>
                            <label for="comment">Відгук</label>
                        </p>
                        <p>
                            <textarea id="comment" name="comment" placeholder="Написати відгук"></textarea>
                        </p>
                        <button class="btn-card yellow-cta" type="submit">надіслати</button>
                    </form>
                </div>
            </div>
        </section>

        <section class="comment-section-page">
            <div class="comment-card-block">
                <div class="comment-block">
                    <h1 class="comment-head-page">відгуки про магазин:</h1>
                    <div class="comment-items">
                        @if(!empty($comments))
                            @foreach($comments as $comment)
                                <div class="comment">
                                    <div class="flex-between item-center head-comment">
                                        <p>{{ ucfirst($comment->name) . ' ' . ucfirst($comment->last_name) }}</p>
                                        <p>{{ date_format($comment->created_at, 'Y-m-d') }}</p>
                                    </div>
                                    <div class="descript-comment">
                                        <p>{{ ucfirst($comment->comment) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="catalog-cta-center">
                        <div class="cta-more">
                            <a href="#">переглянути ще</a>
                        </div>
                    </div>
                    <div class="item-center d-flex pagination">
                        <a class="pagination-button to-start" href="#"><svg fill="none" height="14" viewbox="0 0 13 14" width="13" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 13L1 7L7 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M12 13L6 7L12 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path></svg></a> <a class="pagination-button cta-prev" href="#"><svg fill="none" height="14" viewbox="0 0 8 14" width="8" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 13L1 7L7 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path></svg></a> <a class="pagination-button page" href="#"><span>1</span></a> <a class="pagination-button page" href="#"><span>2</span></a> <a class="pagination-button page" href="#"><span>3</span></a> <a class="pagination-button page current-page" href="#"><span>4</span></a> <a class="pagination-button page" href="#"><span>5</span></a> <a class="pagination-button page" href="#"><span>6</span></a> <a class="pagination-button cta-next" href="#"><svg fill="none" height="14" viewbox="0 0 8 14" width="8" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 13L7 7L1 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path></svg></a> <a class="pagination-button to-end" href="#"><svg fill="none" height="14" viewbox="0 0 13 14" width="13" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 13L12 7L6 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M1 13L7 7L1 1" stroke="#121212" stroke-linecap="round" stroke-linejoin="round"></path></svg></a>
                    </div>
                </div>
                <div class="form-comment">
                    <form action="#">
                        <p class="head-comment-form">Залишити відгук</p>
                        <p class="form-to-add_comment"></p>
                        <p></p>
                        <p><label for="name">Імʼя та прізвище*</label></p>
                        <p><input id="name" name="name" placeholder="Імʼя та прізвище" required="" type="text"></p>
                        <p></p>
                        <p></p>
                        <p><label for="mail">E-mail*</label></p>
                        <p><input id="mail" name="mail" placeholder="E-mail" required="" type="email"></p>
                        <p></p>
                        <p></p>
                        <p><label for="comment">Відгук</label></p>
                        <p>
                            <textarea id="comment" name="comment" placeholder="Написати відгук"></textarea></p>
                        <p></p><button class="btn-card yellow-cta" type="submit">надіслати</button>
                        <p></p>
                    </form>
                </div>
            </div>
        </section>
    </main>
</x-site-layout>
