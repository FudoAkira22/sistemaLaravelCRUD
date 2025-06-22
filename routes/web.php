<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController; //Asi se enlaza empleado controller a la web
//el app siempre ponerlo en App con mayusculas o como esta el namespace

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí se registran las rutas web de la aplicación. Estas rutas son
| cargadas por el RouteServiceProvider dentro de un grupo que
| contiene el middleware "web". ¡Ahora crea algo grandioso!
|
*/



// Ruta raíz que redirige al formulario de inicio de sesión
Route::get('/', function () {
    return view('auth.login');
});

/* 
// Forma manual de definir rutas individuales:
Route::get('/empleado', function () {
    return view('empleado.index');
});

// Ruta que accede directamente al método create del controlador:
Route::get('/empleado/create', [EmpleadoController::class, 'create']);
*/

// Ruta que registra automáticamente todas las rutas del recurso EmpleadoController (index, create, store, etc.)
// Se protege con el middleware 'auth' para requerir inicio de sesión
Route::resource('empleado',EmpleadoController::class)->middleware('auth');


/*
|--------------------------------------------------------------------------
| Autenticación
|--------------------------------------------------------------------------
|
| Aquí se configuran las rutas generadas por Auth::routes().
| Se desactivan las rutas de registro y restablecimiento de contraseña.
|
*/
Auth::routes([
    'register' => false,  // Desactiva la opción de registro de usuarios
    'reset' => false      // Desactiva la opción de recuperación de contraseña
]);

// Ruta para redirigir a /home una vez autenticado (usa el método index del controlador Empleado)
Route::get('/home', [EmpleadoController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Grupo protegido por middleware
|--------------------------------------------------------------------------
|
| Este grupo asegura que todas las rutas internas solo sean accesibles si el usuario está autenticado.
| La ruta '/' redirige a la vista principal de empleados una vez iniciada la sesión.
|
*/

Route::group(['middleware'=>'auth'], function(){
    Route::get('/', [EmpleadoController::class, 'index'])->name('home');
});