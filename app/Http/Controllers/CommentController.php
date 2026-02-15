<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request, Post $post)
    {
        // Verificar que el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para comentar');
        }

        $request->validate([
            'contenido' => 'required|string|min:1|max:1000',
        ]);

        $post->comentarios()->create([
            'user_id' => Auth::id(),
            'contenido' => $request->contenido,
        ]);

        return redirect()->route('posts.show', $post)->with('success', 'Comentario agregado exitosamente');
    }

    /**
     * Delete a comment.
     */
    public function destroy(Comentario $comentario)
    {
        // Verificar que el usuario es el autor del comentario o es admin
        if (Auth::id() !== $comentario->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'No autorizado para eliminar este comentario');
        }

        $post = $comentario->post;
        $comentario->delete();

        return redirect()->route('posts.show', $post)->with('success', 'Comentario eliminado');
    }
}
