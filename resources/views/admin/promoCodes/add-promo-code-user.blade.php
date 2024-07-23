<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8" style="max-width: 114rem">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg bg-white">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-semibold mb-2 text-center">Додати промокод до користувача</h1>
                    <table class="w-full mb-5">
                        <thead>
                        <tr class="text-center border-b-2 border-gray-700">
                            <th class="p-2 text-lg">Промокод</th>
                            <th class="p-2 text-lg">Знижка</th>
                            <th class="p-2 text-lg">Вже використанно</th>
                            <th class="p-2 text-lg">Максимальна кількість використань</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center odd:bg-gray-200">
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $promoCode->title }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $promoCode->rate }} %</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $promoCode->quantity_now }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $promoCode->quantity }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <h1 class="text-2xl font-semibold mb-2 text-center">Користувачі</h1>
                    <div class="text-center mb-4">
                        <form action="{{ route('promoCode.add-promocode', $promoCode->id ) }}" method="GET" style="display: flex; align-items: center; justify-content: center;">
                            <div class="mb-4" style="flex: 1;">
                                <label for="user_name" class="block mb-2 font-bold">Ім'я:</label>
                                <input type="text" name="user_name" id="user_name" value="{{ !empty(request()->input('user_name')) ? request()->input('user_name') : '' }}">
                            </div>
                            <div class="mb-4 ml-4" style="flex: 1;">
                                <label for="user_last_name" class="block mb-2 font-bold">Прізвище:</label>
                                <input type="text" name="user_last_name" id="user_last_name" value="{{ !empty(request()->input('user_last_name')) ? request()->input('user_last_name') : '' }}">
                            </div>
                            <div class="mb-4 ml-4" style="flex: 1;">
                                <label for="user_phone" class="block mb-2 font-bold">Номер телефону:</label>
                                <input type="text" name="user_phone" id="user_phone" value="{{ !empty(request()->input('user_phone')) ? request()->input('user_phone') : '' }}">
                            </div>
                            <div class="mb-4 ml-4" style="flex: 1;">
                                <label for="user_gmail" class="block mb-2 font-bold">Електрона адреса:</label>
                                <input type="text" name="user_gmail" id="user_gmail" value="{{ !empty(request()->input('user_gmail')) ? request()->input('user_gmail') : '' }}">
                            </div>
                            <div class="mb-4 ml-4" style="flex: 1;">
                                <label for="promocod_status" class="block mb-2 font-bold">Промокод:</label>
                                <select name="promocod_status" id="promocod_status" class="w-full border rounded px-3 py-2">
                                    <option value=""> Всі </option>
                                    <option value="Використанний" @if(request()->input('promocod_status') == 'Використанний') selected @endif> Використанний </option>
                                    <option value="Не використанний" @if(request()->input('promocod_status') == 'Не використанний') selected @endif> Не використанний </option>
                                    <option value="Немає" @if(request()->input('promocod_status') == 'Немає') selected @endif> Немає </option>
                                </select>
                            </div>
                            <div class="ml-2 mb-4">
                                <div class="mt-4">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border">Застосувати фільтри</button>
                                    <button type="button" onclick="window.location='{{ route('promoCode.add-promocode', $promoCode->id) }}'" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border ml-2">Очистити фільтри</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <table class="w-full mb-5">
                        <thead>
                        <tr class="text-center border-b-2 border-gray-700">
                            <th class="p-2 text-lg">Ім'я</th>
                            <th class="p-2 text-lg">Прізвище</th>
                            <th class="p-2 text-lg">Номер телефону</th>
                            <th class="p-2 text-lg">Е-mail</th>
                            <th class="p-2 text-lg">Промокод</th>
                            <th class="p-2 text-lg">Статус Промокоду</th>
                            <th class="p-2 text-lg">Дії</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr class="text-center odd:bg-gray-200">
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $user->name }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $user->last_name }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $user->phone}}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $user->email}}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
                                    @if($user->promocodes->contains('promo_code_id', $promoCode->id))
                                        {{ $user->promocodes->firstWhere('promo_code_id', $promoCode->id)->promoCode->title }}
                                    @else
                                        Немає
                                    @endif
                                </td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">
                                    @if($user->promocodes->contains('promo_code_id', $promoCode->id))
                                        {{ $user->promocodes->firstWhere('promo_code_id', $promoCode->id)->status }}
                                    @else
                                        Немає
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right" style="vertical-align: top;">
                                    <div class="mr-4 w-full" style="max-width: 25px;">
                                        @if(!$user->promocodes->contains('promo_code_id', $promoCode->id))
                                            <form action="{{ route('promoCode.store-promocde-user', $promoCode->id) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <button type="submit" title="Додати">
                                                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                         width="25px" viewBox="0 0 401.994 401.994" style="enable-background:new 0 0 401.994 401.994; fill: green"
                                                         xml:space="preserve">
                                                        <g>
                                                            <path d="M394,154.175c-5.331-5.33-11.806-7.994-19.417-7.994H255.811V27.406c0-7.611-2.666-14.084-7.994-19.414
                                                                C242.488,2.666,236.02,0,228.398,0h-54.812c-7.612,0-14.084,2.663-19.414,7.993c-5.33,5.33-7.994,11.803-7.994,19.414v118.775
                                                                H27.407c-7.611,0-14.084,2.664-19.414,7.994S0,165.973,0,173.589v54.819c0,7.618,2.662,14.086,7.992,19.411
                                                                c5.33,5.332,11.803,7.994,19.414,7.994h118.771V374.59c0,7.611,2.664,14.089,7.994,19.417c5.33,5.325,11.802,7.987,19.414,7.987
                                                                h54.816c7.617,0,14.086-2.662,19.417-7.987c5.332-5.331,7.994-11.806,7.994-19.417V255.813h118.77
                                                                c7.618,0,14.089-2.662,19.417-7.994c5.329-5.325,7.994-11.793,7.994-19.411v-54.819C401.991,165.973,399.332,159.502,394,154.175z"
                                                            />
                                                        </g>
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('promoCode.delete-promocode-user', $promoCode->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <button type="submit" title="Видалити">
                                                    <svg width="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 96 96" xmlns:xlink="http://www.w3.org/1999/xlink" style="fill: red">
                                                        <path d="m24,78c0,4.968 4.029,9 9,9h30c4.968,0 9-4.032 9-9l6-48h-60l6,48zm33-39h6v39h-6v-39zm-12,0h6v39h-6v-39zm-12,0h6v39h-6v-39zm43.5-21h-19.5c0,0-1.344-6-3-6h-12c-1.659,0-3,6-3,6h-19.5c-2.487,0-4.5,2.013-4.5,4.5s0,4.5 0,4.5h66c0,0 0-2.013 0-4.5s-2.016-4.5-4.5-4.5z"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
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
