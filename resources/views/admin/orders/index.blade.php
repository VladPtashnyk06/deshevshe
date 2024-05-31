<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8" style="max-width: 114rem">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg bg-white">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-semibold mb-2 text-center">Замовлення</h1>
                    <div class="text-center mb-4">
                        <form action="{{ route('operator.order.index') }}" method="GET" class="flex flex-wrap justify-center">
                            <div class="mb-4 mr-2">
                                <label for="id" class="block mb-2 font-bold">Код замовлення:</label>
                                <input type="text" name="id" id="id" class="border rounded px-3 py-2 text-sm" value="{{ request()->input('id') }}">
                            </div>
                            <div class="mb-4 mr-2">
                                <label for="name_and_last_name" class="block mb-2 font-bold">Клієнт:</label>
                                <input type="text" name="name_and_last_name" id="name_and_last_name" class="border rounded px-3 py-2 text-sm" value="{{ request()->input('name_and_last_name') }}">
                            </div>
                            <div class="mb-4 mr-2">
                                <label for="phone" class="block mb-2 font-bold">Телефон:</label>
                                <input type="text" name="phone" id="phone" class="border rounded px-3 py-2 text-sm" value="{{ request()->input('phone') }}">
                            </div>
                            <div class="mb-4 mr-2">
                                <label for="email" class="block mb-2 font-bold">Електрона адреса:</label>
                                <input type="text" name="email" id="email" class="border rounded px-3 py-2 text-sm" value="{{ request()->input('email') }}">
                            </div>
                            <div class="mb-4 mr-2">
                                <label for="status" class="block mb-2 font-bold">Статус замовлення:</label>
                                <select name="status" id="status" class="border rounded px-3 py-2 text-sm">
                                    <option value="">Виберіть статус</option>
                                    @foreach($orderStatuses as $orderStatus)
                                        <option value="{{ $orderStatus->id }}" {{ request()->input('status') == $orderStatus->id ? 'selected' : '' }}>{{ $orderStatus->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4 mr-2">
                                <label for="created_at" class="block mb-2 font-bold">Дата додавання:</label>
                                <input type="date" name="created_at" id="created_at" class="border rounded px-3 py-2 text-sm" value="{{ request()->input('created_at') }}">
                            </div>
                            <div class="mb-4 mr-2">
                                <label for="updated_at" class="block mb-2 font-bold">Дата оновлення:</label>
                                <input type="date" name="updated_at" id="updated_at" class="border rounded px-3 py-2 text-sm" value="{{ request()->input('updated_at') }}">
                            </div>
                            <div class="mb-4 mr-2 w-full" style="max-width: 180px">
                                <label for="operator" class="block mb-2 font-bold">Оператор:</label>
                                <select name="operator" id="operator" class="border rounded px-3 py-2 text-sm w-full">
                                    <option value="">Виберіть оператора</option>
                                    @foreach($operators as $operator)
                                        <option value="{{ $operator->id }}" {{ request()->input('operator') == $operator->id ? 'selected' : '' }}>{{ $operator->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border">Застосувати фільтри</button>
                                <button type="button" onclick="window.location='{{ route('operator.order.index') }}'" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border ml-2">Очистити фільтри</button>
                            </div>
                        </form>
                    </div>
                    <table class="w-full mb-5 border-collapse">
                        <thead>
                        <tr class="text-center border-b-2 border-gray-700">
                            <th class="p-2 text-sm">№</th>
                            <th class="p-2 text-sm">Клієнт</th>
                            <th class="p-2 text-sm">Товар</th>
                            <th class="p-2 text-sm">Менеджер</th>
                            <th class="p-2 text-sm">Статус</th>
                            <th class="py-2 text-sm">Разом</th>
                            <th class="py-2 text-sm">Дата <br> додавання</th>
                            <th class="py-2 text-sm">Дата зміни</th>
                            <th class="p-2 text-sm">Дії</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders as $order)
                            <tr class="text-center odd:bg-gray-200">
                                <td class="px-4 py-2 break-words max-w-xs text-xs">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span>{{ $order->id }}</span>
                                        <a href="{{ route('operator.order.small-edit', $order->id) }}" onclick="return isOperator()">
                                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                 width="20px" height="20px" viewBox="0 0 497.25 497.25" style="fill: green;">
                                                <path d="M248.625,172.125c-42.075,0-76.5,34.425-76.5,76.5s34.425,76.5,76.5,76.5s76.5-34.425,76.5-76.5
                                            S290.7,172.125,248.625,172.125z M248.625,306c-32.513,0-57.375-24.862-57.375-57.375s24.862-57.375,57.375-57.375
                                            S306,216.112,306,248.625S281.138,306,248.625,306z"/>
                                                <path d="M248.625,114.75C76.5,114.75,0,248.625,0,248.625S76.5,382.5,248.625,382.5S497.25,248.625,497.25,248.625
                                            S420.75,114.75,248.625,114.75z M248.625,363.375c-153,0-225.675-114.75-225.675-114.75s72.675-114.75,225.675-114.75
                                            S474.3,248.625,474.3,248.625S401.625,363.375,248.625,363.375z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                                <td class="py-4 break-words max-w-xs text-left text-xs">
                                    <p>
                                        <svg id="Icons_User" overflow="hidden" version="1.1" viewBox="0 0 96 96" width="15px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="inline-block">
                                            <g>
                                                <circle cx="48" cy="30" r="16" style="fill: black;"/>
                                                <path d=" M 80 82 L 80 66 C 80 63.6 78.8 61.2 76.8 59.6 C 72.4 56 66.8 53.6 61.2 52 C 57.2 50.8 52.8 50 48 50 C 43.6 50 39.2 50.8 34.8 52 C 29.2 53.6 23.6 56.4 19.2 59.6 C 17.2 61.2 16 63.6 16 66 L 16 82 L 80 82 Z"/>
                                            </g>
                                        </svg>
                                        <a href="{{ route('operator.order.showUserOrders', $order->user_id ? $order->user_id : '') }}">{{ $order->user_name . ' ' . $order->user_last_name }}</a>
                                    </p>
                                    <p>
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="12" height="12" viewBox="0 0 16 16" class="inline-block" style="fill: black">
                                            <path d="M8 0c-4.4 0-8 3.6-8 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zM13.2 5.3c0.4 0 0.7 0.3 1.1 0.3-0.3 0.4-1.6 0.4-2-0.1 0.3-0.1 0.5-0.2 0.9-0.2zM1 8c0-0.4 0-0.8 0.1-1.3 0.1 0 0.2 0.1 0.3 0.1 0 0 0.1 0.1 0.1 0.2 0 0.3 0.3 0.5 0.5 0.5 0.8 0.1 1.1 0.8 1.8 1 0.2 0.1 0.1 0.3 0 0.5-0.6 0.8-0.1 1.4 0.4 1.9 0.5 0.4 0.5 0.8 0.6 1.4 0 0.7 0.1 1.5 0.4 2.2-2.5-1.2-4.2-3.6-4.2-6.5zM8 15c-0.7 0-1.5-0.1-2.1-0.3-0.1-0.2-0.1-0.4 0-0.6 0.4-0.8 0.8-1.5 1.3-2.2 0.2-0.2 0.4-0.4 0.4-0.7 0-0.2 0.1-0.5 0.2-0.7 0.3-0.5 0.2-0.8-0.2-0.9-0.8-0.2-1.2-0.9-1.8-1.2s-1.2-0.5-1.7-0.2c-0.2 0.1-0.5 0.2-0.5-0.1 0-0.4-0.5-0.7-0.4-1.1-0.1 0-0.2 0-0.3 0.1s-0.2 0.2-0.4 0.1c-0.2-0.2-0.1-0.4-0.1-0.6 0.1-0.2 0.2-0.3 0.4-0.4 0.4-0.1 0.8-0.1 1 0.4 0.3-0.9 0.9-1.4 1.5-1.8 0 0 0.8-0.7 0.9-0.7s0.2 0.2 0.4 0.3c0.2 0 0.3 0 0.3-0.2 0.1-0.5-0.2-1.1-0.6-1.2 0-0.1 0.1-0.1 0.1-0.1 0.3-0.1 0.7-0.3 0.6-0.6 0-0.4-0.4-0.6-0.8-0.6-0.2 0-0.4 0-0.6 0.1-0.4 0.2-0.9 0.4-1.5 0.4 1.1-0.8 2.5-1.2 3.9-1.2 0.3 0 0.5 0 0.8 0-0.6 0.1-1.2 0.3-1.6 0.5 0.6 0.1 0.7 0.4 0.5 0.9-0.1 0.2 0 0.4 0.2 0.5s0.4 0.1 0.5-0.1c0.2-0.3 0.6-0.4 0.9-0.5 0.4-0.1 0.7-0.3 1-0.7 0-0.1 0.1-0.1 0.2-0.2 0.6 0.2 1.2 0.6 1.8 1-0.1 0-0.1 0.1-0.2 0.1-0.2 0.2-0.5 0.3-0.2 0.7 0.1 0.2 0 0.3-0.1 0.4-0.2 0.1-0.3 0-0.4-0.1s-0.1-0.3-0.4-0.3c-0.1 0.2-0.4 0.3-0.4 0.6 0.5 0 0.4 0.4 0.5 0.7-0.6 0.1-0.8 0.4-0.5 0.9 0.1 0.2-0.1 0.3-0.2 0.4-0.4 0.6-0.8 1-0.8 1.7s0.5 1.4 1.3 1.3c0.9-0.1 0.9-0.1 1.2 0.7 0 0.1 0.1 0.2 0.1 0.3 0.1 0.2 0.2 0.4 0.1 0.6-0.3 0.8 0.1 1.4 0.4 2 0.1 0.2 0.2 0.3 0.3 0.4-1.3 1.4-3 2.2-5 2.2z"></path>
                                        </svg>
                                        Червоне(Кіровоградська обл).
                                    </p>
                                    <p>
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="12" height="12" viewBox="0 0 16 16" class="inline-block" style="fill: black">
                                            <path d="M8 1.4l-2 1.3v-1.7h-2v3l-4 2.6 0.6 0.8 7.4-4.8 7.4 4.8 0.6-0.8z"></path>
                                            <path d="M8 4l-6 4v7h5v-3h2v3h5v-7z"></path>
                                        </svg>
                                        Пункт приймання-видачі (до 30 кг); вул, Перемоги, 3
                                    </p>
                                    <p>
                                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                              height="10px" viewBox="0 0 477.156 477.156" class="inline-block" xml:space="preserve">
                                            <path d="M475.009,380.316l-2.375-7.156c-5.625-16.719-24.062-34.156-41-38.75l-62.688-17.125c-17-4.625-41.25,1.594-53.688,14.031
		l-22.688,22.688c-82.453-22.28-147.109-86.938-169.359-169.375L145.9,161.94c12.438-12.438,18.656-36.656,14.031-53.656
		l-17.094-62.719c-4.625-16.969-22.094-35.406-38.781-40.969L96.9,2.19c-16.719-5.563-40.563,0.063-53,12.5L9.962,48.659
		C3.899,54.69,0.024,71.94,0.024,72.003c-1.187,107.75,41.063,211.562,117.281,287.781
		c76.031,76.031,179.454,118.219,286.891,117.313c0.562,0,18.312-3.813,24.375-9.845l33.938-33.938
		C474.946,420.878,480.571,397.035,475.009,380.316z"/>
                                        </svg>
                                        {{ $order->user_phone }}
                                    </p>
                                    <p>
                                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             height="12px" viewBox="0 0 485.211 485.211" class="inline-block"
                                             xml:space="preserve">
                                            <path d="M485.211,363.906c0,10.637-2.992,20.498-7.785,29.174L324.225,221.67l151.54-132.584
		c5.895,9.355,9.446,20.344,9.446,32.219V363.906z M242.606,252.793l210.863-184.5c-8.653-4.737-18.397-7.642-28.908-7.642H60.651
		c-10.524,0-20.271,2.905-28.889,7.642L242.606,252.793z M301.393,241.631l-48.809,42.734c-2.855,2.487-6.41,3.729-9.978,3.729
		c-3.57,0-7.125-1.242-9.98-3.729l-48.82-42.736L28.667,415.23c9.299,5.834,20.197,9.329,31.983,9.329h363.911
		c11.784,0,22.687-3.495,31.983-9.329L301.393,241.631z M9.448,89.085C3.554,98.44,0,109.429,0,121.305v242.602
		c0,10.637,2.978,20.498,7.789,29.174l153.183-171.44L9.448,89.085z"/>
                                        </svg>
                                        {{ $order->user_email ? $order->user_email : 'Немає' }}
                                    </p>
                                    <p>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 16 16" class="inline-block">
                                            <path fill-rule="evenodd" d="M12 9H2V8h10v1zm4-6v9c0 .55-.45 1-1 1H1c-.55 0-1-.45-1-1V3c0-.55.45-1 1-1h14c.55 0 1 .45 1 1zm-1 3H1v6h14V6zm0-3H1v1h14V3zm-9 7H2v1h4v-1z"/>
                                        </svg>
                                        Доставка - {{ $order->cost_delivery }} <br>Оплата за товар - {{ $order->paymentMethod->title }}
                                    </p>
                                    <p>
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-truck" width="12" height="12" viewBox="0 0 24 24" class="inline-block">
                                            <path d="M18,18.5A1.5,1.5 0 0,1 16.5,17A1.5,1.5 0 0,1 18,15.5A1.5,1.5 0 0,1 19.5,17A1.5,1.5 0 0,1 18,18.5M19.5,9.5L21.46,12H17V9.5M6,18.5A1.5,1.5 0 0,1 4.5,17A1.5,1.5 0 0,1 6,15.5A1.5,1.5 0 0,1 7.5,17A1.5,1.5 0 0,1 6,18.5M20,8H17V4H3C1.89,4 1,4.89 1,6V17H3A3,3 0 0,0 6,20A3,3 0 0,0 9,17H15A3,3 0 0,0 18,20A3,3 0 0,0 21,17H23V12L20,8Z" />
                                        </svg>
                                        Доставка у відділення - Нова пошта
                                    </p>
                                </td>
                                <td class="py-4 max-w-xs text-xs">
                                    @foreach($order->orderDetails()->take(1)->get() as $orderDetail)
                                        <div class="mb-4 text-xs items-center">
                                            <div class="text-left text-sm">{{ $orderDetail->product->title }}</div>
                                            <div class="flex">
                                                <div class="flex-shrink-0">
                                                    @foreach($orderDetail->product->getMedia($orderDetail->product->id) as $media)
                                                        @if($media->getCustomProperty('main_image') === 1)
                                                            <img src="{{ $media->getUrl() }}" alt="{{ $media->getCustomProperty('alt') }}" class="h-20 w-auto rounded-md object-cover mb-2">
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-gray-500 text-xs">Код: {{ $orderDetail->product->code }}</p>
                                                    <p class="text-gray-500 text-xs">Колір: {{ $orderDetail->color }}</p>
                                                    <p class="text-gray-500 text-xs">Розмір: {{ $orderDetail->size }}</p>
                                                    <p class="text-gray-500 text-xs">Ціна: {{ $orderDetail->product->price->pair }}грн x1</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    @if ($order->orderDetails()->count() > 1)
                                        <p class="mt-4">Це не всі товари відкрийте замовлення</p>
                                    @endif
                                </td>
                                <td>
                                    <select name="operator_id" id="operator_id" class="border rounded px-3 py-2 text-sm w-full" disabled>
                                        <option value="null">Всі оператори</option>
                                        @foreach($operators as $operator)
                                            <option value="{{ $operator->id }}" {{ $operator->id == $order->operator_id ? 'selected'  : '' }}>{{ $operator->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="break-words max-w-xs">
                                    <input type="hidden" name="user_operator_id" id="user_operator_id" value="{{ Auth::user()->role == 'operator' ? Auth::user()->id : '' }} ">
                                    <select name="status_id" id="status_id" class="border rounded px-3 py-2 text-sm status-select" data-order-id="{{ $order->id }}">
                                        @foreach($orderStatuses as $orderStatus)
                                            <option value="{{ $orderStatus->id }}" {{ $orderStatus->id == $order->order_status_id ? 'selected' : '' }}>{{ $orderStatus->title }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="break-words max-w-xs text-xs">{{ $order->total_price }} {{ $order->currency }}</td>
                                <td class="break-words max-w-60 text-xs">{{ $order->created_at }}</td>
                                <td class="break-words max-w-60 text-xs">{{ $order->updated_at }}</td>
                                <td class="break-words max-w-xs text-center">
                                    <a href="{{ route('operator.order.editFirst', $order->id) }}" class="inline-block text-blue-500 hover:text-blue-700" onclick="return isOperator()">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 0 128 128">
                                            <g>
                                                <path d="M36.108,110.473l70.436-70.436L87.963,21.457L17.526,91.893c-0.378,0.302-0.671,0.716-0.803,1.22   l-5.476,20.803c-0.01,0.04-0.01,0.082-0.019,0.121c-0.018,0.082-0.029,0.162-0.039,0.247c-0.007,0.075-0.009,0.147-0.009,0.222   c-0.001,0.077,0.001,0.147,0.009,0.225c0.01,0.084,0.021,0.166,0.039,0.246c0.008,0.04,0.008,0.082,0.019,0.121   c0.007,0.029,0.021,0.055,0.031,0.083c0.023,0.078,0.053,0.154,0.086,0.23c0.029,0.067,0.057,0.134,0.09,0.196   c0.037,0.066,0.077,0.127,0.121,0.189c0.041,0.063,0.083,0.126,0.13,0.184c0.047,0.059,0.1,0.109,0.152,0.162   c0.053,0.054,0.105,0.105,0.163,0.152c0.056,0.048,0.119,0.09,0.182,0.131c0.063,0.043,0.124,0.084,0.192,0.12   c0.062,0.033,0.128,0.062,0.195,0.09c0.076,0.033,0.151,0.063,0.23,0.087c0.028,0.009,0.054,0.023,0.083,0.031   c0.04,0.01,0.081,0.01,0.121,0.02c0.081,0.017,0.162,0.028,0.246,0.037c0.077,0.009,0.148,0.011,0.224,0.01   c0.075,0,0.147-0.001,0.223-0.008c0.084-0.011,0.166-0.022,0.247-0.039c0.04-0.01,0.082-0.01,0.121-0.02l20.804-5.475   C35.393,111.146,35.808,110.853,36.108,110.473z M19.651,108.349c-0.535-0.535-1.267-0.746-1.964-0.649l3.183-12.094l11.526,11.525   L20.3,110.313C20.398,109.616,20.188,108.884,19.651,108.349z" style="fill: orangered;"/>
                                                <path d="M109.702,36.879l-18.58-18.581l7.117-7.117c0,0,12.656,4.514,18.58,18.582L109.702,36.879z" style="fill: orangered;"/>
                                            </g>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    const csrfToken = "{{ csrf_token() }}";

    var selectElements = document.getElementsByClassName("status-select");

    for (var i = 0; i < selectElements.length; i++) {
        selectElements[i].addEventListener("change", function() {
            var selectedOption = this.options[this.selectedIndex];
            var statusId = selectedOption.value;
            var orderId = this.getAttribute("data-order-id");
            const operatorId = document.getElementById('user_operator_id').value;

            fetch(`/operator/orders/update-order-status/${orderId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    status_id: statusId,
                    operator_id: operatorId
                })
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response from server:', data);
                    window.location.reload();
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        });
    }

    // setInterval(function() {
    //     window.location.reload();
    // }, 3 * 60 * 1000);

    // function isOperator() {
    //     var operator = document.getElementById('operator_id');
    //     if (operator.value == 'null') {
    //         alert('Помилка: поміняйте статус, не вказаний оператор.');
    //         return false;
    //     }
    //     return true;
    // }
</script>
