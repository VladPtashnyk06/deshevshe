<x-app-layout>
    <main itemscope itemtype="http://schema.org/ItemList">
        <section class="max-w-4xl mx-auto py-12">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h1 class="text-3xl font-semibold mb-6 text-center" itemprop="name">Вхід</h1>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Hidden input for login method -->
                    <input type="hidden" id="hidden_login_method" name="login_method" value="phone">

                    <!-- Login Method -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Метод входу</label>
                        <div class="flex justify-between">
                            <div>
                                <input type="radio" id="login_phone" name="login_method_radio" value="phone" class="mr-2" checked>
                                <label for="login_phone" class="mr-4">Номер телефону</label>
                            </div>
                            <div>
                                <input type="radio" id="login_email" name="login_method_radio" value="email" class="mr-2">
                                <label for="login_email">Електронна пошта</label>
                            </div>
                        </div>
                    </div>

                    <!-- Phone Number -->
                    <div class="mb-4" id="phone_div">
                        @error('user_phone')
                        <span class="text-red-500">{{ htmlspecialchars("Ви ввели не правильний номер, він не відповідає вимогам українського номеру") }}</span>
                        @enderror
                        <label for="phone" class="block text-gray-700 font-medium mb-2">Номер телефону</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-100 text-gray-900 text-sm">
                                +380
                            </span>
                            <input type="text" id="phone" name="phone" class="block w-full pl-2 border border-gray-300 rounded-r-md focus:border-indigo-500 focus:ring-indigo-500" autofocus autocomplete="username" value="{{ old('phone') }}">
                        </div>
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div class="mb-4 hidden" id="email_div">
                        <label for="email" class="block text-gray-700 font-medium mb-2">Електронна пошта</label>
                        <input type="email" id="email" name="email" class="block w-full border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('email') }}">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 font-medium mb-2">Пароль</label>
                        <input type="password" id="password" name="password" class="block w-full border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500" required autocomplete="current-password">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" name="remember">
                            <span class="ml-2 text-sm text-gray-600">{{ __('Запам`ятати мене') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                {{ __('Забули свій пароль ?') }}
                            </a>
                        @endif

                        <x-primary-button class="ml-3">
                            {{ __('Увійти') }}
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
        const emailInput = document.getElementById('email');
        const phoneDiv = document.getElementById('phone_div');
        const emailDiv = document.getElementById('email_div');
        const loginPhoneRadio = document.getElementById('login_phone');
        const loginEmailRadio = document.getElementById('login_email');
        const hiddenLoginMethod = document.getElementById('hidden_login_method');

        phoneInput.addEventListener('input', function (e) {
            if (!/^\d*$/.test(phoneInput.value)) {
                phoneInput.value = phoneInput.value.replace(/[^\d]/g, '');
            }
        });

        loginPhoneRadio.addEventListener('change', function () {
            if (this.checked) {
                phoneDiv.classList.remove('hidden');
                emailDiv.classList.add('hidden');
                hiddenLoginMethod.value = 'phone';
            }
        });

        loginEmailRadio.addEventListener('change', function () {
            if (this.checked) {
                emailDiv.classList.remove('hidden');
                phoneDiv.classList.add('hidden');
                hiddenLoginMethod.value = 'email';
            }
        });
    });
</script>
