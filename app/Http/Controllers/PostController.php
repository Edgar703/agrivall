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
        $posts = $this->buildFilteredPosts($request);
        return view('posts.index', compact('posts'));
    }

    public function index2(Request $request)
    {
        $posts = $this->buildFilteredPosts($request);
        return view('posts.index', compact('posts'));
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
        $request->validate
        ([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string|max:5000',
            'categoria' => 'required|string|max:50'
        ]);

        $dataToCreate = [
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'categoria' => $request->categoria,
            'publicado_en' => now(),
        ];

        /** @var Usuario $user */
        $user = Auth::user();
        $user->posts()->create($dataToCreate);

        return redirect()->route('posts.index')->with('success', 'Post creado');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        // Si no está logueado, Laravel ya lo corta con middleware auth (lo veremos abajo)
        if (Auth::id() !== $post->user_id && Auth::user()->role !== 'admin') {
            abort(403); // Prohibido
        }

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);

        if (Auth::id() !== $post->user_id && Auth::user()->role !== 'admin') {
            abort(403); // Prohibido
        }

        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required',
            'categoria' => 'required'
        ]);
        
        $dataToUpdate = [
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'categoria' => $request->categoria,
        ];
        
        $post->update($dataToUpdate);

        return redirect()->route('posts.show', $post)->with('success', 'Post actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        if (Auth::id() !== $post->user_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post eliminado');
    }

    private function buildFilteredPosts(Request $request)
    {
        $query = Post::query()->with('usuario');

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

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->input('categoria'));
        }

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
            $preset = $request->input('preset');
            if (in_array($preset, ['7', '30', '90'], true)) {
                $query->where('created_at', '>=', now()->subDays((int) $preset));
            }
        }

        return $query->orderBy('created_at', 'desc')->paginate(6);
    }
}
