<x-app-layout>
    <main itemscope itemtype="http://schema.org/ItemList">
        <section class="max-w-4xl mx-auto py-12">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <div class="mb-4 text-sm">
                    {{ __('Забули пароль? Немає проблем. Просто дайте нам знати вашу адресу електронної пошти, і ми надішлемо вам посилання для скидання пароля, яке дозволить вам ввести новий.') }}
                </div>

                 <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button>
                            {{ __('Посилання для скидання пароля електронної пошти') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </section>
    </main>
</x-app-layout>
