<x-app-layout>
    <main itemscope itemtype="http://schema.org/ItemList">
        <section class="max-w-7xl mx-auto py-12">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h1 class="text-3xl font-semibold mb-6 text-center" itemprop="name">Реєстрація</h1>
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Last Name -->
                    <div class="mb-4">
                        <label for="last_name" class="block text-gray-700 font-medium mb-2">Прізвище*</label>
                        <input type="text" id="last_name" name="last_name" class="block w-full border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500" required autocomplete="last_name" value="{{ old('last_name') }}">
                        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                    </div>

                    <!-- Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-medium mb-2">Ім'я*</label>
                        <input type="text" id="name" name="name" class="block w-full border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500" required autofocus autocomplete="name" value="{{ old('name') }}">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <label for="middle_name" class="block text-gray-700 font-medium mb-2">По батькові</label>
                        <input type="text" id="middle_name" name="middle_name" class="block w-full border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500" autocomplete="middle_name" value="{{ old('middle_name') }}">
                    </div>

                    <!-- Phone -->
                    <div class="mb-4">
                        @error('phone')
                        <span class="text-red-500">{{ htmlspecialchars("Ви ввели не правильний номер, він не відповідає вимогам українського номеру") }}</span>
                        @enderror
                        <label for="phone" class="block text-gray-700 font-medium mb-2">Номер телефону*</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-100 text-gray-900 text-sm">
                                +380
                            </span>
                            <input type="text" id="phone" name="phone" class="block w-full pl-2 border border-gray-300 rounded-r-md focus:border-indigo-500 focus:ring-indigo-500" required autocomplete="username" value="{{ old('phone') }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-medium mb-2">Електрона пошта*</label>
                        <input type="text" id="email" name="email" class="block w-full border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500" required autocomplete="email" value="{{ old('email') }}">
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 font-medium mb-2">Пароль*</label>
                        <input type="password" id="password" name="password" class="block w-full border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500" required autocomplete="new-password">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Підтвердження пароля*</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="block w-full border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500" required autocomplete="new-password">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                            {{ __('Вже зареєстровані?') }}
                        </a>
                        <x-primary-button class="ml-4">
                            {{ __('Зареєструватися') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </section>
    </main>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const phoneInput = document.getElementById('phone');

        phoneInput.addEventListener('input', function (e) {
            if (!/^\d*$/.test(phoneInput.value)) {
                phoneInput.value = phoneInput.value.replace(/[^\d]/g, '');
            }
        });
    });
</script>
