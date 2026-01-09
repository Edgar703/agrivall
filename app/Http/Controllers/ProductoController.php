<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::orderBy('created_at', 'desc')->get();
        return view('productos.index', compact('productos'));
    }

    public function catalogo()
    {
        $productos = Producto::orderBy('created_at', 'desc')->get();
        return view('productos.catalogo', compact('productos'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('productos.create');
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
    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'nombre'      => 'nullable|string|max:255',
            'variedad'    => 'nullable|string|max:255',
            'formato'     => 'nullable|string|max:255',
            'precio'      => 'nullable|numeric|min:0',
            'imagen_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'disponible'  => 'nullable',
        ]);

        $validated['disponible'] = $request->has('disponible');

        if ($request->hasFile('imagen_file')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }

            $validated['imagen'] = $request->file('imagen_file')->store('productos', 'public');
        }

        $producto->update($validated);

        return redirect()->route('productos.catalogo')->with('success', 'Producto actualizado ✅');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        if($producto->imagen){
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return redirect()->route('productos.catalogo')->with('success', 'Producto eliminado exitosamente.✅');
    }
}
