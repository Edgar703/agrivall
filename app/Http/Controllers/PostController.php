<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Post::orderBy('created_at', 'desc')->get();
        return view('posts.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'nombre'     => 'string|max:255',
            'variedad'   => 'string|max:255',
            'formato'    => 'string|max:255',
            'precio'     => 'numeric|min:0',
            'imagen'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'disponible' => 'nullable',
        ]);

        $validate['disponible'] = $request->has('disponible');

        if ($request->hasFile('imagen_file')) {
            $path = $request->file('imagen_file')->store('productos', 'public');
            $validate['imagen'] = $path;
        }

        Producto::create($validate);
        return redirect()->route('productos.catalogo')->with('success', 'Producto creado exitosamente.✅');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
