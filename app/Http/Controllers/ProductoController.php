<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductoController extends Controller
{
    private function ensureAdmin(): void
    {
        abort_unless(Auth::check() && Auth::user()->role === 'admin', 403);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::with('categoria')
            ->orderBy('fecha_creacion', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $categorias = Categoria::orderBy('nombre')->get();

        return view('productos.index', compact('productos', 'categorias'));
    }

    public function catalogo(Request $request)
    {
        $query = Producto::with('categoria')
            ->where('activo', true);

        if ($request->filled('q')) {
            $term = trim($request->input('q'));
            $query->where('nombre', 'like', "%{$term}%");
        }

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->input('categoria_id'));
        }

        $precioMin = $request->input('precio_min');
        $precioMax = $request->input('precio_max');

        if ($precioMin !== null && $precioMin !== '' && is_numeric($precioMin)) {
            $query->where('precio', '>=', (float) $precioMin);
        }

        if ($precioMax !== null && $precioMax !== '' && is_numeric($precioMax)) {
            $query->where('precio', '<=', (float) $precioMax);
        }

        $productos = $query
            ->orderBy('fecha_creacion', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $categorias = Categoria::orderBy('nombre')->get();

        return view('productos.catalogo', compact('productos', 'categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $categorias = Categoria::orderBy('nombre')->get();
        $returnTo = $this->resolveReturnTo($request->query('return_to'));

        return view('productos.create', compact('categorias', 'returnTo'));
    }

    public function storeCategoria(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255', Rule::unique('categorias', 'nombre')],
            'descripcion' => 'nullable|string',
        ]);

        Categoria::create($validated);

        return redirect()
            ->route('productos.index')
            ->with('success', 'Categoría creada correctamente.✅');
    }

    public function destroyCategoria(Categoria $categoria)
    {
        $this->ensureAdmin();

        $productosAfectados = $categoria->productos()->count();

        $categoria->delete();

        $message = 'Categoría eliminada correctamente.✅';

        if ($productosAfectados > 0) {
            $message .= ' ' . $productosAfectados . ' producto(s) quedaron sin categoría.';
        }

        return redirect()
            ->route('productos.index')
            ->with('success', $message);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'nombre' => 'string|max:255',
            'imagen_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'descripcion' => 'nullable|string',
            'precio' => 'numeric|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
            'activo' => 'nullable|boolean',
            'fecha_creacion' => 'nullable|date',
            'return_to' => 'nullable|string|max:2048',
        ]);

        $validate['activo'] = $request->boolean('activo');
        $validate['fecha_creacion'] = $validate['fecha_creacion'] ?? now()->toDateString();

        if ($request->hasFile('imagen_file')) {
            $file = $request->file('imagen_file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('productos', $filename, 'public');
            $validate['imagen'] = 'productos/' . $filename;
        }

        Producto::create($validate);

        $returnTo = $this->resolveReturnTo($validate['return_to'] ?? null);

        return redirect()->to($returnTo)->with('success', 'Producto creado exitosamente.✅');
    }

    private function resolveReturnTo(?string $returnTo): string
    {
        $fallback = route('productos.catalogo');

        if (!$returnTo) {
            return $fallback;
        }

        $allowedBases = [
            route('productos.catalogo'),
            route('productos.index'),
        ];

        $baseUrl = strtok($returnTo, '?');

        return in_array($baseUrl, $allowedBases, true) ? $returnTo : $fallback;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto = Producto::with('categoria')->findOrFail($id);

        return view('productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'nombre' => 'nullable|string|max:255',
            'imagen_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'descripcion' => 'nullable|string',
            'precio' => 'nullable|numeric|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
            'activo' => 'nullable|boolean',
            'fecha_creacion' => 'nullable|date',
        ]);

        $validated['activo'] = $request->boolean('activo');
        $validated['fecha_creacion'] = $validated['fecha_creacion'] ?? $producto->fecha_creacion?->toDateString();

        if ($request->hasFile('imagen_file')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }

            $file = $request->file('imagen_file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('productos', $filename, 'public');
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
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return redirect()
            ->route('productos.catalogo')
            ->with('success', 'Producto eliminado exitosamente.✅');
    }
}
