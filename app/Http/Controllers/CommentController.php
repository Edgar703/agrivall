<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        // Verificar que el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para comentar');
        }

        // Validar contenido del comentario
        $request->validate([
            'contenido' => 'required|string|min:1|max:1000',
        ]);

        // Crear comentario asociado al post y al usuario
        $post->comentarios()->create([
            'user_id' => Auth::id(),
            'contenido' => $request->contenido,
        ]);

        // Volver al post
        return redirect()->route('posts.show', $post)->with('success', 'Comentario agregado exitosamente');
    }

    public function destroy(Comentario $comentario)
    {
        // Verificar que el usuario es el autor del comentario o es admin
        if (Auth::id() !== $comentario->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'No autorizado para eliminar este comentario');
        }

        // Guardar post antes de eliminar comentario
        $post = $comentario->post;

        // Eliminar comentario
        $comentario->delete();

        // Volver al post
        return redirect()->route('posts.show', $post)->with('success', 'Comentario eliminado');
    }
}
