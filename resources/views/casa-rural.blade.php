@extends('layouts.app')

@section('titol', 'Agrivall')

@section('contingut')
<div class="d-flex justify-content-between align-items-center mb-3">
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<h2 class="h4">Bienvenido a Casa rural</h2>
<p>Su plataforma de gestión agrícola.</p>
@endsection
