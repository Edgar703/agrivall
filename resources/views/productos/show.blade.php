@extends('layouts.app')

@section('titol', ' Detalle del Producto')

@section('contingut')

    <div style="display: flex;">
        <h1 class="h3 m-3">Producto: <strong style="color: #715122;">{{ $producto->nombre }}</strong></h1>
        @auth
            @if (auth()->user()->role === 'admin')
                <div style="display: flex; align-items: center;">
                    <a href="{{ route('productos.edit', $producto) }}" class="btn btn-sm d-flex" style="background-color: #715122; color: white;">
                        Editar
                    </a>
            @endif
        @endauth
    </div>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; height: 40vh">
        <div style="border-radius: 15px;">
            <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Imagen del producto"
                style="height: 100%; width: 100%; object-fit: cover; border-radius: 15px;">
        </div>
        <div style="border-radius: 15px;">
            <table class="table table-bordered h-100" style="border-radius: 15px;">
                <tbody>
                    <tr>
                        <th>Variedad</th>
                        <td style="text-align: center;">{{ $producto->variedad }}</td>
                    </tr>
                    <tr>
                        <th>Formato</th>
                        <td style="text-align: center;">{{ $producto->formato }}</td>
                    </tr>
                    <tr>
                        <th>Precio</th>
                        <td style="text-align: center;">{{ number_format($producto->precio, 2) }} €</td>
                    </tr>
                    <tr>
                        <th>Disponible</th>
                        <td style="text-align: center;">
                            @if($producto->disponible)
                                <span class="badge bg-success">Sí</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection