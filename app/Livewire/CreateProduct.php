<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Tag;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateProduct extends Component
{
    use WithFileUploads;

    public bool $openCrear = false;

    //Validaciones
    #[Validate(['required', 'string', 'min:3', 'unique:products,nombre'])]
    public $nombre;

    #[Validate(['required', 'string', 'min:10'])]
    public $descripcion;

    #[Validate(['nullable', 'image', 'max:2048'])]
    public $imagen;

    #[Validate(['required', 'integer', 'min:0'])]
    public $stock;

    #[Validate(['required', 'decimal:0,2', 'min:0', 'max:9999.99'])]
    public $pvp;

    #[Validate(['required', 'array', 'min:1', 'exists:tags,id'])]
    public $tags = [];

    public function render()
    {
        $misTags = Tag::select('id', 'nombre', 'color')->orderBy('nombre')->get();
        return view('livewire.create-product', compact('misTags'));
    }

    public function store()
    {
        $this->validate();

        $producto = Product::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'imagen' => ($this->imagen) ? $this->imagen->store('productos') : 'default.jpeg',
            'stock' => $this->stock,
            'pvp' => $this->pvp,
            'disponible' => ($this->stock  > 0) ? "SI" : "NO",
            'user_id' => auth()->user()->id
        ]);

        $producto->tags()->attach($this->tags);

        $this->dispatch('producto-creado')->to(ShowProducts::class);
        $this->dispatch("mensaje", "Producto creado correctamente");

        $this->cancelarCrear();
    }

    public function cancelarCrear()
    {
        $this->reset(['openCrear', 'nombre', 'descripcion', 'imagen', 'stock', 'pvp', 'tags']);
    }
}
