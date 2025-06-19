<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    //Es index es lo que se abre como ruta principal
    public function index()
    {
        //Traer los datos de base de datos
        //Pero solo los 5 primeros registros
        $datos['empleados']=Empleado::paginate(5);
        //
        return view('empleado.index',$datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        //Le damos al controlador la vista 
        return view('empleado.create');
        
    }

    
    /*El store se usa para mandar los datos al modelo de la base de datos */
    public function store(Request $request)
    { 
        //
        //$datosEmpelado = request()->all();
        $datosEmpelado = request()->except('_token'); //Asi se recolecta todo lo del form menos el token

        // Verifica si en la petición viene un archivo con el nombre 'Foto'
        if ($request->hasFile('Foto')) {

            // Si hay archivo, lo guarda en la carpeta 'storage/app/public/uploads'
            // El método store() guarda el archivo con un nombre único automáticamente
            // El primer parámetro 'uploads' es el subdirectorio dentro de 'public'
            // El segundo parámetro 'public' indica que se debe guardar en 'storage/app/public'
            // Y que el archivo será accesible públicamente desde 'public/storage'

            $datosEmpelado['Foto'] = $request->file('Foto')->store('uploads', 'public');
        }



        //use App\Models\Empleado; la funcion de abajo se conecta a eso
        Empleado::insert($datosEmpelado); //Y inserta los datos en la base de datos
        return response()->json($datosEmpelado);

        /*
        tambien se puede suar esto que es mejor para mandr datos
        $request->validate([
        'nombre' => 'required|string|max:255',
        'correo' => 'required|email|unique:empleados',
        'foto' => 'nullable|string',
        'puesto' => 'required|string|max:255',
        ]);
        $empleado = Empleado::create($request->all());
        return response()->json($empleado); */

        /*
        o esta otra forma que es mejor
        $request->validate([
        'nombre' => 'required|string|max:255',
        'correo' => 'required|email|unique:empleados',
        'foto' => 'nullable|string',
        'puesto' => 'required|string',
        ]);

        o omitir lo de validate
        de esta forma es dato por dato
        $empleado = new Empleado();
        $empleado->nombre = $request->nombre;
        $empleado->correo = $request->correo;
        $empleado->foto = $request->foto;
        $empleado->puesto = $request->puesto;
        $empleado->save();
        return response()->json($empleado);
         */
    }

    /**
     * Display the specified resource.
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $empleado = Empleado::findOrFail($id);
        return view('empleado.edit', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $datosEmpelado = request()->except(['_token','_method']);
        if ($request->hasFile('Foto')) {
            $empleado = Empleado::findOrFail($id);
            
// Verificar si tiene una foto y si existe en el disco 'public'
        if ($empleado->Foto && Storage::disk('public')->exists($empleado->Foto)) {
            Storage::disk('public')->delete($empleado->Foto); // Borrar foto vieja
        }

            $datosEmpelado['Foto'] = $request->file('Foto')->store('uploads', 'public');
        }

        Empleado::where('id','=',$id)->update($datosEmpelado);

        $empleado = Empleado::findOrFail($id);
        return view('empleado.edit', compact('empleado'));
    }

    /**
     * Remove the specified resource from storage.
     */

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
public function destroy($id)
{
    $empleado = Empleado::findOrFail($id);

    if ($empleado->Foto && Storage::disk('public')->exists($empleado->Foto)) {
        Storage::disk('public')->delete($empleado->Foto);
    }

    Empleado::destroy($id);

    return redirect('empleado')->with('mensaje', 'Empleado eliminado correctamente');
}
}
