<x-app-layout>
    <main itemscope itemtype="http://schema.org/ItemList">
        <section class="max-w-4xl mx-auto py-12">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h1 class="text-3xl font-semibold mb-6 text-center" itemprop="name">Вхід</h1>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Hidden input for login method -->
                    <input type="hidden" id="hidden_login_method" name="login_method" value="name">

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-medium mb-2">Логін</label>
                        <input type="text" id="name" name="name" class="block w-full border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500" required autocomplete="name" value="{{ old('name') }}">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
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
