<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:jue')->get('/jugador', function (Request $request) {
    return $request->user();
});*/

//realizamos qui porque la aplicacion da un servicio
//si fuera en web es porque ocupo servicios ya exsistentes
Route::group(['middleware'=>'cors'],function(){


Route::get('/','RutasController@index')->name('inicio');

Route::get('/comprobar', 'Auth\AutenticacionJugador@checklog')->name('comprobar');
Route::get('/ingresar', 'Auth\AutenticacionJugador@checklog')->name('login');
Route::post('/ingresar', 'Auth\AutenticacionJugador@login')->name('login.submit');
Route::post('/ingresarfb','Auth\AutenticacionJugador@fblogin')->name('loginfb.submit');
Route::delete('/ingresar', 'Auth\AutenticacionJugador@logout')->name('logout');
Route::post('/registrar', 'Auth\RegistrarJugador@crear')->name('register.submit');
Route::post('/registrarfb', 'Auth\RegistrarJugador@fb')->name('registerfb.submit');

Route::post('/jugador/activar','JugadoresController@activarjugador')->name('activar');
//verifica que primero hayan iniciado session
Route::group(['middleware' => 'auth:jug'], function () {
  Route::get('/jugador', 'RutasController@funcionesjugador')->name('funciones');//muestra todas las funciones del jugador
  Route::get('/jugador/desactivar','JugadoresController@desactivarjugador')->name('desactivar');
  Route::post('/jugador/modificar', 'JugadoresController@modificarjugador')->name('modificar');
  Route::get('/jugador/ver', 'JugadoresController@verjugador')->name('ver');

  //rutas de canchas
  Route::get('/jugador/cancha', 'CanchasController@index')-> name('ver.cancha');
  Route::post('/jugador/cancha', 'CanchasController@store')-> name('guardar.cancha');
  Route::delete('/jugador/cancha', 'CanchasController@delete')-> name('eliminar.cancha');

  //rutas de partidas
  Route::get('/jugador/partida', 'PartidasController@index')-> name('ver.partida');
  Route::post('/jugador/partida', 'PartidasController@store')-> name('guardar.partida');
  Route::delete('/jugador/partida', 'PartidasController@delete')-> name('eliminar.partida');
  Route::get('/jugador/partida/ver', 'PartidasController@index')-> name('lista');

  //rutas de equipo
  Route::post('/jugador/partida/unir', 'EquiposController@store')-> name('unir');
  Route::delete('/jugador/partida/desunir', 'EquiposController@delete')-> name('desunir');
  Route::get('/jugador/partida/desactivar','EquiposController@status')->name('estado');
});
});


//dar de baja partidas
Route::get('verificar','PartidasController@dardebaja');