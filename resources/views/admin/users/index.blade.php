<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8" style="max-width: 95rem">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg bg-white">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-semibold mb-2 text-center">Користувачі</h1>
                    <form action="{{ route('user.index') }}" method="GET" style="display: flex; align-items: center; justify-content: center;">
                        <div class="mb-4" style="flex: 1;">
                            <label for="name_and_last_name" class="block mb-2 font-bold">Ім'я Прізвище:</label>
                            <input type="text" name="name_and_last_name" id="name_and_last_name" value="{{ !empty(request()->input('name_and_last_name')) ? request()->input('name_and_last_name') : '' }}">
                        </div>
                        <div class="mb-4" style="flex: 1;">
                            <label for="phone" class="block mb-2 font-bold">Номер телефону:</label>
                            <input type="text" name="phone" id="phone" value="{{ !empty(request()->input('phone')) ? request()->input('phone') : '' }}">
                        </div>
                        <div class="mb-4" style="flex: 1;">
                            <label for="email" class="block mb-2 font-bold">Електрона адреса:</label>
                            <input type="text" name="email" id="email" value="{{ !empty(request()->input('email')) ? request()->input('email') : '' }}">
                        </div>
                        <div class="mb-4 ml-4" style="flex: 1;">
                            <label for="role" class="block mb-2 font-bold">Роль:</label>
                            <select name="role" id="role" class="w-full border rounded px-3 py-2">
                                <option value=""> Всі </option>
                                <option value="admin" @if(request()->input('role') == 'admin') selected @endif> Admin </option>
                                <option value="user" @if(request()->input('role') == 'user') selected @endif> User </option>
                            </select>
                        </div>
                        <div class="ml-2 mb-4">
                            <div class="mt-4">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border">Застосувати фільтри</button>
                                <button type="button" onclick="window.location='{{ route('user.index') }}'" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out border ml-2">Очистити фільтри</button>
                            </div>
                        </div>
                    </form>
                    <table class="w-full mb-5">
                        <thead>
                            <tr class="text-center border-b-2 border-gray-700">
                                <th class="p-2 text-lg">Ім'я Прізвище</th>
                                <th class="p-2 text-lg">Телефон</th>
                                <th class="p-2 text-lg">Електрона адреса</th>
                                <th class="p-2 text-lg">Область</th>
                                <th class="p-2 text-lg">Місто</th>
                                <th class="p-2 text-lg">Адреса</th>
                                <th class="p-2 text-lg">Роль</th>
                                <th class="p-2 text-lg">Дії</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr class="text-center odd:bg-gray-200">
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $user->name }} {{ $user->last_name }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $user->phone }}</td>
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $user->email }}</td>
                                @if(!count($usersAddresses) == 0)
                                    @foreach($usersAddresses as $usersAddress)
                                        @if($usersAddress->user_id == $user->id)
                                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $usersAddress->region }}</td>
                                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $usersAddress->city }}</td>
                                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $usersAddress->address }}</td>
                                        @else
                                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">Немає</td>
                                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">Немає</td>
                                            <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">Немає</td>
                                        @endif
                                    @endforeach
                                @else
                                    <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">Немає</td>
                                    <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">Немає</td>
                                    <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">Немає</td>
                                @endif
                                <td class="px-6 py-4" style="word-wrap:break-word; max-width: 15rem; vertical-align: top;">{{ $user->role }}</td>
                                <td class="px-6 py-4 text-right" style="vertical-align: top;">
                                    <a href="{{ route('user.edit', $user->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border" style="max-width: 120px">Редагувати</a>
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out mb-2 mt-3 w-full border" style="max-width: 120px">Видалити</button>
                                    </form>
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
