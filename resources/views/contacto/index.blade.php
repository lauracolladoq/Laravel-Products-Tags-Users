<x-app-layout>
    <x-principal>
        <div class="w-1/2 mx-auto p-6 rounded-xl shadow-xl bg-gray-600 text-gray-900">
            <form method="POST" action="{{ route('contacto.procesar') }}">
                @csrf
                <div class="mb-5">
                    <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900">Nombre</label>
                    <input type="text" id="nombre" value="{{ old('nombre') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 
                    text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="Nombre..." name="nombre">
                    <x-input-error for="nombre" />
                </div>
                <div class="mb-5">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                    @auth
                        <textarea id="email" name="email" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm 
                    rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Email...">{{ auth()->user()->email }}</textarea>
                    @else
                        <textarea id="email" name="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm 
                    rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Email...">{{ old('email') }}</textarea>
                    @endauth
                    <x-input-error for="email" />
                </div>
                <div class="mb-5">
                    <label for="contenido" class="block mb-2 text-sm font-medium text-gray-900">Contenido</label>
                    <textarea id="contenido" name="contenido"
                        class="bg-gray-50 border border-gray-300 text-gray-900 
                    text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="Contenido...">{{ old('contenido') }}</textarea>
                    <x-input-error for="contenido" />
                </div>
                <div class="flex flex-row-reverse">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fa-solid fa-paper-plane"></i> ENVIAR
                    </button>
                    <button type="reset"
                        class="mx-2 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-paintbrush"></i> LIMPIAR
                    </button>
                    <a href="{{ route('inicio') }}"
                        class="mr-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-xmark"></i> CANCELAR</a>
                </div>
            </form>
        </div>
    </x-principal>
</x-app-layout>
