<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// URL http://localhost:8080/tallerlaravel7/public/mantenimientos/empleados

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


#Mantenimientos
Route::prefix('mantenimientos')->group(function () {
  
    /*Route::get('empleados', function () {
        // Matches The "/admin/users" URL
        return 'vista de empleados';
    });*/

    Route::resource('empleados','EmpleadoController')->middleware('auth');


});