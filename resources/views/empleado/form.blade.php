<!--Formulario que tendra los datos en comun con create y edit
-->
    <label for="Nombre">Nombre:</label>
    <input type="text" name="Nombre" 
    value="{{isset($empleado->Nombre)?$empleado->Nombre:''}}" id="Nombre"><br>

    <label for="ApellidoPaterno">Apellido Paterno:</label>
    <input type="text" name="ApellidoPaterno" 
   value="{{isset($empleado->ApellidoPaterno)?$empleado->ApellidoPaterno:''}}" id="ApellidoPaterno"><br>

    <label for="ApellidoMaterno">Apellido Materno:</label>
    <input type="text" name="ApellidoMaterno" 
    value="{{isset($empleado->ApellidoMaterno)?$empleado->ApellidoMaterno:''}}" id="ApellidoMaterno"><br>

    <label for="Correo">Correo:</label>
    <input type="email" name="Correo" 
    value="{{isset($empleado->correo)?$empleado->correo:''}}" id="Correo"><br>

    <label for="Foto">Foto:</label>
    @if(isset($empleado->Foto))
    {{$empleado->Foto}}
    <img src="{{asset('storage').'/'.$empleado->Foto}}" width="100" alt="">
    @endif
    <input type="file" name="Foto" value="" id="Foto"><br>

    <button type="submit">Enviar</button>
<a href="{{url('empleado/')}}">Regresar</a>