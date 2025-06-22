@extends('layouts.app')
@section('content')
<h1>Mostrar la lista de empleados </h1>
<div class="container">


@if(Session::has('mensaje'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ Session::get('mensaje') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif





<a href="{{url('empleado/create')}}" class="btn btn-success">Registrar nuevo empleado</a>
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>ID:</th>
            <th>Foto:</th>
            <th>Nombre:</th>
            <th>Apellido paterno:</th>
            <th>Apellido materno:</th>
            <th>Correo:</th>
            <th>Accriones:</th>
        </tr>
    </thead>
    <tbody>
<!--Lo que esta en index de EmpleadoController se trae aqui mediante
empleados -->
        @foreach($empleados as $empleado)
        <tr>
            <td>{{$empleado->id}}</td>

            <td>
                <img class="img-thumbnail img-fluid" src="{{asset('storage').'/'.$empleado->Foto}}" width="100" alt="">
            </td>

            <td>{{$empleado->Nombre}}</td>
            <td>{{$empleado->ApellidoPaterno}}</td>
            <td>{{$empleado->ApellidoMaterno}}</td>
            <td>{{$empleado->correo}}</td>
            <td>
                <a href="{{ url('/empleado/'.$empleado->id.'/edit')}}" class="btn btn-warning">
                    Editar
                </a>
                
                

            <form action="{{ url('/empleado/'.$empleado->id)}}" class="d-inline" method="post">
                @csrf
                {{method_field('DELETE')}}
            <input class="btn btn-danger" type="submit" onclick="return confirm('Quieres borrar?')" value="Borrar">
            </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{!!$empleados->links()!!}
</div>
@endsection