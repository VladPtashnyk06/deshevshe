<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-semibold mb-4 text-center">Редагувати дані користувача</h2>
                <form action="{{ route('user.update', $user->id) }}" method="post" class="max-w-4xl mx-auto" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        @error('name')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення та унікальним") }}</span>
                        @enderror
                        <label for="name" class="block mb-2 font-bold">Ім'я користувача</label>
                        <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2" value="{{ $user->name }}">
                    </div>

                    <div class="mb-4">
                        @error('last_name')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення та унікальним") }}</span>
                        @enderror
                        <label for="last_name" class="block mb-2 font-bold">Прізвище користувача</label>
                        <input type="text" name="last_name" id="last_name" class="w-full border rounded px-3 py-2" value="{{ $user->last_name }}">
                    </div>

                    <div class="mb-4">
                        @error('phone')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення та унікальним") }}</span>
                        @enderror
                        <label for="phone" class="block mb-2 font-bold">Номер телефону користувача</label>
                        <input type="text" name="phone" id="phone" class="w-full border rounded px-3 py-2" value="{{ $user->phone }}">
                    </div>

                    <div class="mb-4">
                        @error('email')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення та унікальним") }}</span>
                        @enderror
                        <label for="email" class="block mb-2 font-bold">Електорна адреса користувача</label>
                        <input type="text" name="email" id="email" class="w-full border rounded px-3 py-2" value="{{ $user->email }}">
                    </div>

                    <div class="mb-4">
                        @error('region')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення та унікальним") }}</span>
                        @enderror
                        <label for="region" class="block mb-2 font-bold">Область користувача</label>
                        <input type="text" name="region" id="region" class="w-full border rounded px-3 py-2" value="{{ isset($userAddress->region) ? $userAddress->region : 'Немає' }}">
                    </div>

                    <div class="mb-4">
                        @error('city')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення та унікальним") }}</span>
                        @enderror
                        <label for="city" class="block mb-2 font-bold">Місто користувача</label>
                        <input type="text" name="city" id="city" class="w-full border rounded px-3 py-2" value="{{ isset($userAddress->city) ? $userAddress->city : 'Немає' }}">
                    </div>

                    <div class="mb-4">
                        @error('address')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення та унікальним") }}</span>
                        @enderror
                        <label for="address" class="block mb-2 font-bold">Адреса користувача</label>
                        <input type="text" name="address" id="address" class="w-full border rounded px-3 py-2" value="{{ isset($userAddress->address) ? $userAddress->address : 'Немає' }}">
                    </div>

                    <div class="mb-4">
                        @error('role')
                        <span class="text-red-500">{{ htmlspecialchars("Це поле є обов'язковим для заповнення та унікальним") }}</span>
                        @enderror
                        <label for="role" class="block mb-2 font-bold">Роль користувача</label>
                        <select name="role" id="role" class="w-full border rounded px-3 py-2">
                            <option value="user" @if($user->role == 'user' ) selected @endif>User</option>
                            <option value="admin" @if($user->role == 'admin' ) selected @endif>Admin</option>
                            <option value="admin" @if($user->role == 'operator' ) selected @endif>Operator</option>
                        </select>
                    </div>

                    <div class="text-center mb-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Оновити дані користувача</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
