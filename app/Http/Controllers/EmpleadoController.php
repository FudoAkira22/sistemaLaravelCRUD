<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; //Esto es para utilizar Store de las fotos

class EmpleadoController extends Controller
{
    //Es index es lo que se abre como ruta principal
    public function index()
    {
        // Obtiene los empleados de la base de datos con paginación (1 por página)
        $datos['empleados'] = Empleado::paginate(1);
        // Retorna la vista 'empleado.index' con los datos obtenidos
        return view('empleado.index', $datos);
    }

    //Muestra el formulario para crear un nuevo empleado.
    public function create()
    {
        //Le damos al controlador la vista 
        return view('empleado.create');
    }


    //Guarda un nuevo empleado en la base de datos.
    public function store(Request $request)
    {
        // Reglas de validación para los campos del formulario
        $campos = [
            'Nombre' => 'required|string|max:100',
            'ApellidoPaterno' => 'required|string|max:100',
            'ApellidoMaterno' => 'required|string|max:100',
            'Correo' => 'required|email',
            'Foto' => 'required|max:1000|mimes:jpeg,png,jpg',
        ];
        // Mensajes personalizados de validación
        $mensaje = [
            'required' => 'El :attribute es requerido', //Estes es para todos los campos
            'Foto.required' => 'La foto es requerida' //Este es para uno solo
            /*
            esto es para algo mas es
            $mensaje['Foto.required'] = 'La foto es requerida';
            $mensaje['Foto.mimes'] = 'La foto debe ser formato jpeg, png o jpg';
            $mensaje['Foto.max'] = 'La foto no debe pesar más de 1MB';
            */
        ];
        // Valida la solicitud con las reglas y mensajes definidos
        $this->validate($request, $campos, $mensaje);


        // Obtiene todos los datos excepto el token CSRF
        $datosEmpelado = request()->except('_token'); //Asi se recolecta todo lo del form menos el token

        // Si se subió una foto, se guarda en 'storage/app/public/uploads'
        if ($request->hasFile('Foto')) {

            // Si hay archivo, lo guarda en la carpeta 'storage/app/public/uploads'
            // El método store() guarda el archivo con un nombre único automáticamente
            // El primer parámetro 'uploads' es el subdirectorio dentro de 'public'
            // El segundo parámetro 'public' indica que se debe guardar en 'storage/app/public'
            // Y que el archivo será accesible públicamente desde 'public/storage'

            $datosEmpelado['Foto'] = $request->file('Foto')->store('uploads', 'public');
        }



        //use App\Models\Empleado; la funcion de abajo se conecta a eso
        Empleado::insert($datosEmpelado); // Inserta el nuevo registro en la base de datos
        //return response()->json($datosEmpelado); esto mustra lo que se registro en tipo json
        // Redirige a la vista principal con un mensaje de éxito
        return redirect('empleado')->with('mensaje', 'Empleado agregado con exito');

        /*
        Alternativas:
        
        1. Validación y creación automática:
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:empleados',
            'foto' => 'nullable|string',
            'puesto' => 'required|string|max:255',
        ]);
        $empleado = Empleado::create($request->all());
        return response()->json($empleado);

        2. Inserción manual campo por campo:
        $empleado = new Empleado();
        $empleado->nombre = $request->nombre;
        $empleado->correo = $request->correo;
        $empleado->foto = $request->foto;
        $empleado->puesto = $request->puesto;
        $empleado->save();
        */
    }

    //Muestra la información de un empleado específico.
    //Es para buscar
    public function show(Empleado $empleado)
    {
        //
    }

    //Muestra el formulario para editar un empleado específico.
    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('empleado.edit', compact('empleado'));
    }

    //Actualiza los datos de un empleado existente.
    public function update(Request $request, $id)
    {
        // Reglas de validación básicas
        $campos = [
            'Nombre' => 'required|string|max:100',
            'ApellidoPaterno' => 'required|string|max:100',
            'ApellidoMaterno' => 'required|string|max:100',
            'Correo' => 'required|email',

        ];
        $mensaje = [
            'required' => 'El :attribute es requerido', //Estes es para todos los campos   
        ];
        // Si se sube una nueva foto, se agregan reglas para ella
        if ($request->hasFile('Foto')) {
            $campos = ['Foto' => 'required|max:1000|mimes:jpeg,png,jpg'];
            $mensaje = ['Foto.required' => 'La foto es requerida'];
        }
        //Validar la petición
        $this->validate($request, $campos, $mensaje);
        // Obtener los datos del formulario, excepto _token y _method
        $datosEmpelado = request()->except(['_token', '_method']);

        // Si se subió una nueva foto
        if ($request->hasFile('Foto')) {
            $empleado = Empleado::findOrFail($id);

            // Borrar la foto anterior si existe
            if ($empleado->Foto && Storage::disk('public')->exists($empleado->Foto)) {
                Storage::disk('public')->delete($empleado->Foto); // Borrar foto vieja
            }
            // Guardar la nueva foto
            $datosEmpelado['Foto'] = $request->file('Foto')->store('uploads', 'public');
        }
        // Actualizar los datos del empleado
        Empleado::where('id', '=', $id)->update($datosEmpelado);
        $empleado = Empleado::findOrFail($id);
        //return view('empleado.edit', compact('empleado'));
        return redirect('empleado')->with('mensaje', 'Empleado modificado correctamente');
    }

    /*
    public function destroy($id)
    {
        //
        $empleado = Empleado::findOrFail($id);
        if (Storage::delete($empleado->Foto)){
            Empleado::destroy($id);
        }
        
        return redirect('empleado');
    }*/
    //Elimina un empleado de la base de datos.
    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);

        // Si tiene una foto, eliminarla del almacenamiento
        if ($empleado->Foto && Storage::disk('public')->exists($empleado->Foto)) {
            Storage::disk('public')->delete($empleado->Foto);
        }
        // Eliminar el registro de la base de datos
        Empleado::destroy($id);

        return redirect('empleado')->with('mensaje', 'Empleado eliminado correctamente');
    }
}
