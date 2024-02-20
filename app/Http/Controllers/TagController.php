<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use LVR\Colour\Hex;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::orderBy('nombre')->paginate(5);
        return view('tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'min:3', 'unique:tags,nombre'],
            'color' => ['required', new Hex()]
        ]);

        Tag::create($request->all());

        return redirect()->route('tags.index')->with('mensaje', "Tag creado correctamente");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return view('tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'min:3', 'unique:tags,nombre,' . $tag->id],
            'color' => ['required', new Hex()]
        ]);

        $tag->update([
            'nombre' => substr($request->nombre, 1),
            'color' => $request->color
        ]);

        return redirect()->route('tags.index')->with('mensaje', "Tag editado correctamente.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('tags.index')->with('mensaje', "Tag borrado correctamente");
    }
}
