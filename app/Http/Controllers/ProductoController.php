<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\ProductoVariedad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductoController extends Controller
{
    private function ensureAdmin(): void
    {
        abort_unless(Auth::check() && Auth::user()->role === 'admin', 403);
    }

    public function index(Request $request)
    {
        $this->ensureAdmin();

        $productos = Producto::with(['categoria', 'variedades'])
            ->orderBy('fecha_creacion', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $categorias = Categoria::orderBy('nombre')->get();
        $categoriaEditando = null;

        if ($request->filled('edit_categoria')) {
            $categoriaEditando = Categoria::find($request->input('edit_categoria'));
        }

        return view('admin.productos.index', compact('productos', 'categorias', 'categoriaEditando'));
    }

    public function catalogo(Request $request)
    {
        $query = Producto::with(['categoria', 'variedades'])
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

    public function create(Request $request)
    {
        $this->ensureAdmin();

        $categorias = Categoria::orderBy('nombre')->get();
        $returnTo = $this->resolveReturnTo($request->query('return_to'));

        return view('admin.productos.create', compact('categorias', 'returnTo'));
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
            ->route('admin.productos.index')
            ->with('success', 'Categoría creada correctamente.✅');
    }

    public function updateCategoria(Request $request, Categoria $categoria)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255', Rule::unique('categorias', 'nombre')->ignore($categoria->id)],
            'descripcion' => 'nullable|string',
        ]);

        $categoria->update($validated);

        return redirect()
            ->route('admin.productos.index')
            ->with('success', 'Categoría actualizada correctamente.✅');
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
            ->route('admin.productos.index')
            ->with('success', $message);
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();
        $validated = $this->validateProducto($request);
        $validated['activo'] = $request->boolean('activo');
        $validated['fecha_creacion'] = $validated['fecha_creacion'] ?? now()->toDateString();
        $validated = $this->normalizeSaleFields($validated);
        $variedades = $this->extractVariedades($request);

        if ($request->hasFile('imagen_file')) {
            $file = $request->file('imagen_file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('productos', $filename, 'public');
            $validated['imagen'] = 'productos/' . $filename;
        }

        DB::transaction(function () use ($validated, $variedades) {
            $producto = Producto::create($validated);
            $this->syncVariedades($producto, $variedades);
        });

        $returnTo = $this->resolveReturnTo($validated['return_to'] ?? null);

        return redirect()->to($returnTo)->with('success', 'Producto creado exitosamente.✅');
    }

    private function resolveReturnTo(?string $returnTo): string
    {
        $fallback = route('admin.productos.index');

        if (!$returnTo) {
            return $fallback;
        }

        $allowedBases = [
            route('admin.productos.index'),
        ];

        $baseUrl = strtok($returnTo, '?');

        return in_array($baseUrl, $allowedBases, true) ? $returnTo : $fallback;
    }

    public function show(Request $request, Producto $producto)
    {
        if ($request->routeIs('admin.productos.show')) {
            $this->ensureAdmin();
        }

        $producto->load(['categoria', 'variedades' => fn ($query) => $query->orderBy('orden')->orderBy('id')]);

        return view('productos.show', compact('producto'));
    }

    public function edit(Producto $producto)
    {
        $this->ensureAdmin();

        $categorias = Categoria::orderBy('nombre')->get();
        $producto->load('variedades');

        return view('admin.productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, Producto $producto)
    {
        $this->ensureAdmin();
        $validated = $this->validateProducto($request);
        $validated['activo'] = $request->boolean('activo');
        $validated['fecha_creacion'] = $validated['fecha_creacion'] ?? $producto->fecha_creacion?->toDateString();
        $validated = $this->normalizeSaleFields($validated);
        $variedades = $this->extractVariedades($request);

        if ($request->hasFile('imagen_file')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }

            $file = $request->file('imagen_file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('productos', $filename, 'public');
            $validated['imagen'] = 'productos/' . $filename;
        }

        DB::transaction(function () use ($producto, $validated, $variedades) {
            $producto->update($validated);
            $this->syncVariedades($producto, $variedades);
        });

        return redirect()
            ->route('admin.productos.index')
            ->with('success', 'Producto actualizado ✅');
    }

    public function destroy(Producto $producto)
    {
        $this->ensureAdmin();

        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return redirect()
            ->route('admin.productos.index')
            ->with('success', 'Producto eliminado correctamente ✅');
    }

    private function validateProducto(Request $request): array
    {
        return $request->validate([
            'nombre' => 'required|string|max:255',
            'imagen_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'tipo_venta' => 'required|in:unidad,peso',
            'unidad_medida' => 'required|in:ud,kg',
            'step_cantidad' => 'required|numeric|min:0.01',
            'categoria_id' => 'nullable|exists:categorias,id',
            'activo' => 'nullable|boolean',
            'fecha_creacion' => 'nullable|date',
            'return_to' => 'nullable|string|max:2048',
            'variedades' => 'nullable|array',
            'variedades.*.id' => 'nullable|integer|exists:producto_variedades,id',
            'variedades.*.nombre' => 'nullable|string|max:255|required_with:variedades.*.precio',
            'variedades.*.precio' => 'nullable|numeric|min:0|required_with:variedades.*.nombre',
            'variedades.*.activo' => 'nullable|boolean',
            'variedades.*.orden' => 'nullable|integer|min:0',
        ]);
    }


    private function normalizeSaleFields(array $validated): array
    {
        if (($validated['tipo_venta'] ?? 'unidad') === 'unidad') {
            $validated['unidad_medida'] = 'ud';
            $validated['step_cantidad'] = 1;
        } else {
            $validated['unidad_medida'] = 'kg';
        }

        return $validated;
    }

    private function extractVariedades(Request $request): array
    {
        $variedades = $request->input('variedades', []);

        return collect($variedades)
            ->map(function ($variedad, $index) {
                $nombre = trim((string) ($variedad['nombre'] ?? ''));
                $precio = $variedad['precio'] ?? null;

                if ($nombre === '' && ($precio === null || $precio === '')) {
                    return null;
                }

                return [
                    'id' => $variedad['id'] ?? null,
                    'nombre' => $nombre,
                    'precio' => $precio,
                    'activo' => filter_var($variedad['activo'] ?? false, FILTER_VALIDATE_BOOLEAN),
                    'orden' => (int) ($variedad['orden'] ?? $index),
                ];
            })
            ->filter()
            ->values()
            ->all();
    }

    private function syncVariedades(Producto $producto, array $variedades): void
    {
        $existingIds = $producto->variedades()->pluck('id')->all();
        $keptIds = [];

        foreach ($variedades as $variedadData) {
            $payload = [
                'nombre' => $variedadData['nombre'],
                'precio' => $variedadData['precio'],
                'activo' => $variedadData['activo'],
                'orden' => $variedadData['orden'],
            ];

            if (!empty($variedadData['id']) && in_array((int) $variedadData['id'], $existingIds, true)) {
                $variedad = ProductoVariedad::where('producto_id', $producto->id)
                    ->findOrFail($variedadData['id']);
                $variedad->update($payload);
                $keptIds[] = $variedad->id;
                continue;
            }

            $variedad = $producto->variedades()->create($payload);
            $keptIds[] = $variedad->id;
        }

        $deleteIds = array_diff($existingIds, $keptIds);
        if (!empty($deleteIds)) {
            $producto->variedades()->whereIn('id', $deleteIds)->delete();
        }
    }
}
