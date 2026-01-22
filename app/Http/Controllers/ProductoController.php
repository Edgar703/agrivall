<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\File;


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
            'imagen_file'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'disponible' => 'nullable',
        ]);

        $validate['disponible'] = $request->has('disponible');

        if ($request->hasFile('imagen_file')) {
            $file = $request->file('imagen_file');

            // nombre único para evitar colisiones
            $filename = time() . '_' . $file->getClientOriginalName();

            // guarda directamente en public/storage/productos
            $file->move(public_path('storage/productos'), $filename);

            // guarda en BD la ruta que luego usarás con asset('storage/...')
            $validate['imagen'] = 'productos/' . $filename;
        }


        Producto::create($validate);
        return redirect()->route('productos.catalogo')->with('success', 'Producto creado exitosamente.✅');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.show', compact('producto'));
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

            // 1) borrar imagen antigua si existe
            if ($producto->imagen) {
                $oldPath = public_path('storage/' . $producto->imagen);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            // 2) guardar la nueva en public/storage/productos
            $file = $request->file('imagen_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/productos'), $filename);

            // 3) guardar la ruta en BD (IMPORTANTE: $validated)
            $validated['imagen'] = 'productos/' . $filename;
        }

        $producto->update($validated);

        return redirect()
            ->route('productos.catalogo')
            ->with('success', 'Producto actualizado ✅');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        // $producto->imagen guarda algo como: "productos/1769099215_manzana.jpg"
        if ($producto->imagen) {
            $fullPath = public_path('storage/' . $producto->imagen);

            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
        }

        $producto->delete();

        return redirect()
            ->route('productos.catalogo')
            ->with('success', 'Producto eliminado exitosamente.✅');
    }
}
