@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="text-center">
        <h1 class="display-3 fw-bold">¡Bienvenido a tu App Laravel! 🚀</h1>
        <p class="lead">Una aplicación construida con Laravel, Bootstrap y amor de Amo y Señor de Todo 😎</p>

        @guest
            <div class="mt-4">
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-2">Iniciar sesión</a>
                <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg">Registrarse</a>
            </div>
        @else
            <div class="mt-4">
                <h4 class="mb-3">Hola, {{ Auth::user()->name }} 👋</h4>
                <a href="{{ url('/home') }}" class="btn btn-success btn-lg">Ir al Panel Principal</a>
            </div>
        @endguest
    </div>
</div>
@endsection
