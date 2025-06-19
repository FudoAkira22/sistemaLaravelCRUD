<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController; //Asi se enlaza empleado controller a la web
//el app siempre ponerlo en App con mayusculas o como esta el namespace

Route::get('/', function () {
    return view('welcome');
});

/*Route::get('/empleado', function(){// lo que esta en /empleado es la ruta
    return view('empleado.index');//empelado es la carpeta del view y index es el doc
});
//Se accede al controlador en especifico a create
//Route::get('/empleado/create', [EmpleadoController::class,'create']);
*/

//Si en lugar de hacer cada una de las routes como la que esta arriba
//se quiere acceder a todas se hace esto
Route::resource('empleado',EmpleadoController::class);
