<x-app-layout>
    <main itemscope itemtype="http://schema.org/ItemList">
        <section class="max-w-4xl mx-auto py-12">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h1 class="text-3xl font-semibold mb-6 text-center" itemprop="name">Запит на зворотній дзвінок</h1>
                @if(session('success'))
                    <div class="mb-4 text-green-500">
                        {{ session('success') }}
                    </div>
                @endif
                <form method="POST" action="/send-callback">
                    @csrf

                    <!-- Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-medium mb-2">Ім'я</label>
                        <input type="text" id="name" name="name" class="block w-full border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <!-- Phone Number -->
                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700 font-medium mb-2">Телефон</label>
                        <input type="text" id="phone" name="phone" class="block w-full border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <!-- Message -->
                    <div class="mb-4">
                        <label for="message" class="block text-gray-700 font-medium mb-2">Повідомлення</label>
                        <textarea id="message" name="message" rows="4" class="block w-full border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <x-primary-button class="ml-3">
                            {{ __('Відправити запит') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </section>
    </main>
</x-app-layout>
