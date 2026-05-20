<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener posts filtrados
        $posts = $this->buildFilteredPosts($request);

        // Mostrar listado de posts
        return view('posts.index', compact('posts'));
    }

    public function index2(Request $request)
    {
        // Obtener posts filtrados
        $posts = $this->buildFilteredPosts($request);

        // Mostrar listado de posts
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Mostrar formulario para crear post
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar datos del formulario
        $request->validate
        ([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string|max:5000',
            'categoria' => 'required|string|max:50'
        ]);

        // Preparar datos para crear el post
        $dataToCreate = [
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'categoria' => $request->categoria,
            'publicado_en' => now(),
        ];

        // Crear post asociado al usuario logueado
        /** @var Usuario $user */
        $user = Auth::user();
        $user->posts()->create($dataToCreate);

        // Volver al listado
        return redirect()->route('posts.index')->with('success', 'Post creado');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Buscar post o mostrar error 404
        $post = Post::findOrFail($id);

        // Mostrar detalle del post
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Buscar post o mostrar error 404
        $post = Post::findOrFail($id);

        // Si no está logueado, Laravel ya lo corta con middleware auth (lo veremos abajo)
        if (Auth::id() !== $post->user_id && Auth::user()->role !== 'admin') {
            abort(403); // Prohibido
        }

        // Mostrar formulario de edición
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Buscar post o mostrar error 404
        $post = Post::findOrFail($id);

        // Permitir editar solo al autor o admin
        if (Auth::id() !== $post->user_id && Auth::user()->role !== 'admin') {
            abort(403); // Prohibido
        }

        // Validar datos del formulario
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required',
            'categoria' => 'required'
        ]);
        
        // Preparar datos para actualizar
        $dataToUpdate = [
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'categoria' => $request->categoria,
        ];
        
        // Guardar cambios del post
        $post->update($dataToUpdate);

        // Volver al detalle del post
        return redirect()->route('posts.show', $post)->with('success', 'Post actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Buscar post o mostrar error 404
        $post = Post::findOrFail($id);

        // Solo admin puede eliminar posts
        abort_unless(Auth::user()?->role === 'admin', 403);

        // Eliminar post
        $post->delete();

        // Volver al listado
        return redirect()->route('posts.index')->with('success', 'Post eliminado');
    }

    private function buildFilteredPosts(Request $request)
    {
        // Crear consulta base con usuario
        $query = Post::query()->with('usuario');

        // Filtrar por texto en título, contenido o autor
        if ($request->filled('q')) {
            $term = trim($request->input('q'));
            $query->where(function ($subQuery) use ($term) {
                $subQuery->where('titulo', 'like', "%{$term}%")
                    ->orWhere('contenido', 'like', "%{$term}%")
                    ->orWhereHas('usuario', function ($userQuery) use ($term) {
                        $userQuery->where('name', 'like', "%{$term}%");
                    });
            });
        }

        // Filtrar por categoría
        if ($request->filled('categoria')) {
            $query->where('categoria', $request->input('categoria'));
        }

        // Filtrar por fechas personalizadas
        $from = $request->input('from');
        $to = $request->input('to');
        if ($from || $to) {
            if ($from) {
                $query->whereDate('created_at', '>=', $from);
            }
            if ($to) {
                $query->whereDate('created_at', '<=', $to);
            }
        } else {
            // Si no hay fechas, aplicar preset rápido
            $preset = $request->input('preset');
            if (in_array($preset, ['7', '30', '90'], true)) {
                $query->where('created_at', '>=', now()->subDays((int) $preset));
            }
        }

        // Devolver posts paginados
        return $query->orderBy('created_at', 'desc')->paginate(6);
    }
}
