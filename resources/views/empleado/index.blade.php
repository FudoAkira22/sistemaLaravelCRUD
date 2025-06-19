Mostrar la lista de empleados 
<button><a href="{{url('empleado/create')}}">Registrar nuevo empleado</a></button>
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
                <img src="{{asset('storage').'/'.$empleado->Foto}}" width="100" alt="">
            </td>

            <td>{{$empleado->Nombre}}</td>
            <td>{{$empleado->ApellidoPaterno}}</td>
            <td>{{$empleado->ApellidoMaterno}}</td>
            <td>{{$empleado->correo}}</td>
            <td>
                <a href="{{ url('/empleado/'.$empleado->id.'/edit')}}">
                    Editar
                </a>
                
            <form action="{{ url('/empleado/'.$empleado->id)}}" method="post">
                @csrf
                {{method_field('DELETE')}}
            <input type="submit" onclick="return confirm('Quieres borrar?')" value="Borrar">
            </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>