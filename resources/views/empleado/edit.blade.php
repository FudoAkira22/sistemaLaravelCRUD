@extends('layouts.app')
@section('content')
<div class="container">
<h1>Formulario de edicion de empleado</h1>
<!--
        Formulario que permite editar un empleado existente.
        La URL incluye el ID del empleado para actualizar el registro específico.
        El método POST se combina con @method('PATCH') para simular una solicitud PATCH (actualización parcial).
        El atributo 'enctype="multipart/form-data"' permite el envío de archivos (en este caso, una foto).
    -->
<form action="{{url('/empleado/'.$empleado->id)}}" method="post" enctype="multipart/form-data">
<!--Token CSRF necesario para seguridad-->
@csrf
<!--Spoofing del método PATCH, ya que HTML solo permite GET y POST-->
{{method_field('PATCH')}}
<!--
            Se incluye el formulario reutilizable que contiene los campos del empleado.
            Se pasa la variable 'modo' con el valor 'Editar' para ajustar los textos de botones o títulos si es necesario.
        -->
@include('empleado.form',['modo'=>'Editar'])
</form>
</div>
@endsection
