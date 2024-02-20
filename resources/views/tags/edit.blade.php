<x-app-layout>
    <x-principal>
        <div class="w-1/3 mx-auto p-6 rounded-xl shadow-xl bg-gray-600 dark:text-gray-200">
            <form method="POST" action="{{ route('tags.update', $tag) }}">
                @csrf
                @method('put')
                <div class="mb-5">
                    <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900">Nombre</label>
                    <input type="text" id="nombre" value="{{ old('nombre', $tag->nombre) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="Nombre..." name="nombre">
                    <x-input-error for="nombre" />
                </div>
                <div class="mb-5">
                    <label for="color" class="block mb-2 text-sm font-medium text-gray-900">Color</label>
                    <input type="color" id="color" value="{{ old('color', $tag->color) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        name="color">
                    <x-input-error for="color" />
                </div>
                <div class="flex flex-row-reverse">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-edit"></i> EDITAR
                    </button>
                    <button type="reset"
                        class="mx-2 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-paintbrush"></i> LIMPIAR
                    </button>
                    <a href="{{ route('tags.index') }}"
                        class="mr-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-xmark"></i> CANCELAR</a>
                </div>
            </form>
        </div>
    </x-principal>
</x-app-layout>
