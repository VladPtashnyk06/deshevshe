<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-semibold mb-4 text-center">Edit Characteristic</h2>
                <form action="{{ route('characteristic.update', $characteristic->id) }}" method="post" class="max-w-4xl mx-auto" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        @error('height')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required and unique") }}</span>
                        @enderror
                        <label for="height" class="block mb-2 font-bold">Height</label>
                        <input type="text" name="height" id="height" class="w-full border rounded px-3 py-2" value="{{ $characteristic->height }}">
                    </div>

                    <div class="mb-4">
                        @error('width')
                        <span class="text-red-500">{{ htmlspecialchars("This field is required and unique") }}</span>
                        @enderror
                        <label for="width" class="block mb-2 font-bold">Width</label>
                        <input type="text" name="width" id="width" class="w-full border rounded px-3 py-2" value="{{ $characteristic->width }}">
                    </div>

                    <div class="text-center mb-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full border">Update Characteristic</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
