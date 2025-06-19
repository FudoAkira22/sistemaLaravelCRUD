<h1>Formulario de creacion de empleado</h1>
<!--action="{{url('/empleado')}}" esto es hacia donde se va a mandar esto-->
<form action="{{url('/empleado')}}" method="post" enctype="multipart/form-data"><!--enctype="multipart/form-data" permite mandar imagenes -->
@csrf
@include('empleado.form')<!--Trae lo de form de empleado-->
</form>