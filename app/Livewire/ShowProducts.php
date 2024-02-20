<?php

namespace App\Livewire;

use App\Livewire\Forms\UpdateProduct;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowProducts extends Component
{

    use WithPagination;
    use WithFileUploads;

    public string $campo = "id";
    public string $orden = "desc";

    public string $buscar = "";

    //Update
    public UpdateProduct $form;
    public bool $openUpdate = false;

    //Detalle
    public bool $openShow = false;
    public Product $producto;

    //Para que se actualice la vista al crear un producto y aparezca
    #[On('producto-creado')]
    public function render()
    {
        $productos = Product::where('user_id', auth()->user()->id)
            //->where('nombre', 'like', "%$this->buscar%")
            //->where('nombre', 'like', "$this->buscar%")
            ->where('nombre', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->campo, $this->orden)
            ->paginate(5);
        $misTags = Tag::select('id', 'nombre', 'color')->orderBy('nombre')->get();
        return view('livewire.show-products', compact('productos', 'misTags'));
    }

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    public function aumentarStock(Product $producto)
    {
        $nuevoStock = $producto->stock + 1;

        $producto->update([
            'stock' => $nuevoStock,
            'disponible' => ($nuevoStock > 0) ? "SI" : "NO"
        ]);
    }

    public function disminuirStock(Product $producto)
    {
        if ($producto->stock > 0) {
            $nuevoStock = $producto->stock - 1;

            $producto->update([
                'stock' => $nuevoStock,
                'disponible' => ($nuevoStock > 0) ? "SI" : "NO"
            ]);
        }
    }

    public function ordenar(string $campo)
    {
        $this->orden = ($this->orden == "desc") ? 'asc' : 'desc';
        $this->campo = $campo;
    }

    public function confirmacionBorrar(Product $product)
    {
        $this->authorize('update', $product);
        $this->dispatch("confirmacionBorrar", $product->id);
    }

    #[On('borrarOk')]
    public function borrar(Product $product)
    {
        $this->authorize('delete', $product);

        if (basename($product->imagen) != 'default.jpeg') {
            Storage::delete($product->imagen);
        }

        $product->delete();
        $this->dispatch("mensaje", "Se ha borrado correctamente.");
    }

    public function edit(Product $producto)
    {
        $this->authorize('update', $producto);
        $this->form->setProducto($producto);
        $this->openUpdate = true;
    }

    public function update()
    {
        $this->form->editarProducto();
        $this->cancelarUpdate();
        $this->dispatch("mensaje", 'Producto actualizado correctamente');
    }

    public function cancelarUpdate()
    {
        $this->openUpdate = false;
        $this->form->limpiarCampos();
    }

    //Detalle
    public function detalle(Product $producto)
    {
        $this->producto = $producto;
        $this->openShow = true;
    }

    public function cancelarDetalle()
    {
        $this->reset(['producto', 'openShow']);
    }
}
