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
        //$posts = Post::orderBy('created_at', 'desc')->get();
        $posts = Post::orderBy('created_at', 'desc')->paginate(6);
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
            $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required',
            'categoria' => 'required'
        ]);

        Post::create([
            'user_id' => auth()->id(),
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'categoria' => $request->categoria,
            'publicado_en' => now()
        ]);

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
        if (auth()->id() !== $post->user_id && auth()->user()->role !== 'admin') {
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

        if (auth()->id() !== $post->user_id && auth()->user()->role !== 'admin') {
            abort(403); // Prohibido
        }

        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required',
            'categoria' => 'required'
        ]);

        $post->update([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'categoria' => $request->categoria,
        ]);

        return redirect()->route('posts.show', $post)->with('success', 'Post actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        if (auth()->id() !== $post->user_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post eliminado');
    }
}
