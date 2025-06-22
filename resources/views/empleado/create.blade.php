@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Formulario de creación de empleado</h1>

    <!--
        El atributo 'action' indica la URL a la que se enviará el formulario.
        En este caso, es '/empleado', que corresponde al método 'store' del EmpleadoController.
        El método es POST porque estamos creando un nuevo recurso.
        El atributo 'enctype="multipart/form-data"' permite enviar archivos (en este caso, una imagen).
    -->
    <form action="{{ url('/empleado') }}" method="post" enctype="multipart/form-data">
<!--Token de seguridad de Laravel para evitar ataques CSRF -->
    @csrf  

        <!--
            Se incluye la vista parcial 'empleado.form', que contiene los campos reutilizables
            del formulario. Se le pasa una variable 'modo' con valor 'Crear' para indicar que
            estamos en el modo de creación.
        -->
        @include('empleado.form', ['modo' => 'Crear'])
    </form>
</div>
@endsection
