<x-principal>
    <div class="flex w-full mb-1  items-center">
        <div class="w-3/4 flex-1">
            <x-input type="search" placeholder="Buscar..." wire:model.live="buscar" class="w-3/4" /><i
                class="mr-2 fas fa-search"></i>
        </div>
        <div>
            @livewire('create-product')
        </div>
    </div>
    <table class="w-full text-sm text-left">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">
                    INFO
                </th>
                <th scope="col" class="px-6 py-3">
                    IMAGEN
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('nombre')">
                    NOMBRE
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('disponible')">
                    DISPONIBLE
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('stock')">
                    STOCK
                </th>
                <th scope="col" class="px-6 py-3">
                    ACCIÓN
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $item)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="w-4 p-4">
                        <button wire:click="detalle({{ $item->id }})">
                            <i class="fas fa-info text-lg hover:text-2xl"></i>
                        </button>
                    </td>
                    <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap">
                        <img class="w-24 h-24 rounded bg-center bg-cover" src="{{ Storage::url($item->imagen) }}"
                            alt={{ $item->nombre }}>
                    </th>
                    <td class="px-6 py-4">
                        {{ $item->nombre }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $item->disponible }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <button wire:click='disminuirStock({{ $item->id }})'
                                class="inline-flex items-center justify-center p-1 me-3 text-sm font-medium h-6 w-6
                                 text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none
                                  hover:bg-gray-100 focus:ring-4 focus:ring-gray-200"
                                type="button">
                                <span class="sr-only">Quantity button</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 18 2">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 1h16" />
                                </svg>
                            </button>
                            <div>
                                <p @class([
                                    'bg-gray-50 w-14 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1',
                                    'text-red-500' => $item->stock < 10,
                                    'text-green-500' => $item->stock > 10,
                                    'line-through font-bold' => $item->stock == 0,
                                ])>
                                    {{ $item->stock }}
                                </p>
                            </div>
                            <button wire:click='aumentarStock({{ $item->id }})'
                                class="inline-flex items-center justify-center h-6 w-6 p-1 ms-3 text-sm font-medium
                                 text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none
                                  hover:bg-gray-100 focus:ring-4 focus:ring-gray-200"
                                type="button">
                                <span class="sr-only">Quantity button</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 18 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M9 1v16M1 9h16" />
                                </svg>
                            </button>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <button wire:click="confirmacionBorrar({{ $item->id }})">
                            <i class="fas fa-trash text-red-500 hover:text-2l"></i>
                        </button>
                        <button wire:click="edit({{ $item->id }})">
                            <i class="fas fa-edit text-green-500 hover:text-2l"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-1">
        {{ $productos->links() }}
    </div>

    <!-- MODAL para el update -->
    @isset($form->producto)
        <x-dialog-modal wire:model="openUpdate">
            <x-slot name="title">
                Actualizar Producto
            </x-slot>
            <x-slot name="content">
                <x-label for="nombre">
                    Nombre
                </x-label>
                <x-input class="w-full" id="nombre" placeholder="Nombre..." wire:model="form.nombre" />
                <x-input-error for="form.nombre" />

                <x-label class="mt-4" for="descripcion">
                    Descripción
                </x-label>
                <textarea id="descripcion" placeholder="Descripcion..." class="w-full" wire:model="form.descripcion"></textarea>
                <x-input-error for="form.descripcion" />

                <x-label class="mt-4" for="stock">
                    Stock
                </x-label>
                <x-input id="stock" placeholder="Stock..." class="w-full" step="1" min="0"
                    wire:model="form.stock" />
                <x-input-error for="form.stock" />

                <x-label class=" mt-4" for="pvp">
                    PVP (€)
                </x-label>
                <x-input class="w-full" id="number" placeholder="Pvp..." step="0.01" min="0" max="9999.99"
                    wire:model="form.pvp" />
                <x-input-error for="form.pvp" />

                <x-label class="mt-4" for="tags">
                    Etiquetas
                </x-label>

                <div class="flex flex-wrap mt-4">
                    @foreach ($misTags as $tag)
                        <div class="flex items-center me-4">
                            <input id="{{ $tag->id }}" type="checkbox" value="{{ $tag->id }}"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded
                             focus:ring-blue-500 focus:ring-2"
                                wire:model="form.tags">
                            <label for="{{ $tag->id }}"
                                class="ms-2 text-sm font-medium text-gray-900 p-2 rounded-xl"
                                style="background-color: {{ $tag->color }}">{{ $tag->nombre }}</label>
                        </div>
                    @endforeach
                </div>

                <x-input-error for="form.tags" />

                <x-label class="mt-4" for="imagenUpdate">
                    Imagen
                </x-label>

                <div class=" relative w-full h-72 bg-gray-200 rounded">
                    <input type="file" wire:model="form.imagen" accept="image/*" hidden id="imagenUpdate">
                    <label for="imagenUpdate"
                        class="absolute bottom-2 end-2 bg-gray-700 hover:bg-gray-800
                 text-white font-bold py-2 px-4 rounded">
                        <i class="fa-solid fa-upload mr-2"></i>SUBIR
                    </label>
                    @if ($form->imagen)
                        <img src="{{ $form->imagen->temporaryUrl() }}" class="w-full h-full bg-no-repeat"
                            alt="Imagen subida">
                </div>
                @endif
                <x-input-error for="form.imagen" />

            </x-slot>
            <x-slot name="footer">
                <div class="flex flex-row-reverse">
                    <button wire:click="update" wire:loading.attr="disabled"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-save"></i> EDITAR
                    </button>
                    <button wire:click="cancelarUpdate"
                        class="mr-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-xmark"></i> CANCELAR
                    </button>
                </div>
            </x-slot>
        </x-dialog-modal>
    @endisset

    <!-- MODAL para detalle -->
    @isset($producto->nombre)
        <x-dialog-modal wire:model="openShow">
            <x-slot name="title">
                Detalle Producto
            </x-slot>
            <x-slot name="content">
                <div
                    class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <img class="rounded-t-lg" src="{{ Storage::url($producto->imagen) }}" alt="" />
                    <div class="p-5">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            {{ $producto->nombre }}
                        </h5>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                            {{ $producto->descripcion }}
                        </p>
                        <div>
                            @foreach ($producto->tags as $tag)
                                <div style="background-color: {{ $tag->color }}">
                                    {{ $tag->nombre }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </x-slot>
            <x-slot name="footer">
                <button wire:click="cancelarDetalle"
                    class="mr-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-xmark"></i> CANCELAR
                </button>
            </x-slot>
        </x-dialog-modal>
    @endisset
</x-principal>
