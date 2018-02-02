<?php

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

Auth::routes();

// Cliente
Route::get('/prueba', ['as' => 'home', 'uses' => 'Admin\PropiedadController@prueba']);
Route::get('/', ['as' => 'home', 'uses' => 'WebController@index']);
Route::get('/buscador', ['as' => 'buscador', 'uses' => 'WebController@buscador']);
Route::get('/proyectos', ['as' => 'proyectos', 'uses' => 'WebController@lista_proyectos']);
Route::get('/contacto', ['as' => 'contacto', 'uses' => 'WebController@contacto']);
Route::get('/nuestra-historia', ['as' => 'nuestra_historia', 'uses' => 'WebController@nuestra_historia']);
Route::get('/inmueble/{id}', ['as' => 'detalle_inmueble', 'uses' => 'WebController@detalle_inmueble']);
Route::get('/proyecto/{id}', ['as' => 'detalle_proyecto', 'uses' => 'WebController@detalle_proyecto']);

                                        //ADMIN
// LOGIN
Route::any('/admin/login', ['as' => 'login', 'uses' => 'Admin\AdminController@Login']);
Route::any('/admin/ingresar', ['as' => 'login-ingresar', 'uses' => 'Admin\AdminController@ingresar']);



//Asesores
Route::get('/admin/crear-usuario/{id}', ['as' => 'crear-agente', 'uses' => 'Admin\AsesorController@CrearUsuarioAsesor']);
Route::get('/admin/agente', ['as' => 'lista-agente', 'uses' => 'Admin\AsesorController@ListarAsesores']);
Route::get('/admin/buscarasesor',['as'=>'prueba','uses'=>'Admin\AsesorController@searchAsesor'] );
Route::any('/admin/buscaruser',['as'=>'buscar_user','uses'=>'Admin\AsesorController@guardarEditarUsuario']);
Route::get('/admin/prueba',['as'=>'pruebaAsesor','uses'=>'Admin\AsesorController@pruebaAsesor'] );

//Perfil
Route::get('/admin/perfil', ['as' => 'perfil', 'uses' => 'Admin\PerfilController@Perfil']);
Route::any('/admin/actualizarPerfil', ['as' => 'updatePerfil', 'uses' => 'Admin\PerfilController@actualizarPerfil']);

//inmuebles
Route::get('/admin', ['as' => 'dashboard', 'uses' => 'Admin\PropiedadController@ListaInmuebles']);
Route::get('/admin/inmuebles', ['as' => 'admin_lista_inmuebles', 'uses' => 'Admin\PropiedadController@ListaInmuebles']);
Route::get('/admin/inmueble/{id}', ['as' => 'admin_detalle_inmueble', 'uses' => 'Admin\PropiedadController@DetalleInmueble']);
Route::get('/admin/crear-inmueble-1', ['as' => 'crear-inmueble-1', 'uses' => 'Admin\PropiedadController@CrearInmueble1']);
Route::get('/admin/crear-inmueble-2', ['as' => 'crear-inmueble-2', 'uses' => 'Admin\PropiedadController@CrearInmueble2']);
Route::any('/admin/listarCiudades', ['as' => 'listarCiudades', 'uses' => 'Admin\PropiedadController@listarCiudades']);
Route::any('/admin/cargarPropiedad', ['as' => 'cargarPropiedad', 'uses' => 'Admin\PropiedadController@cargarPropiedad']);
Route::any('/admin/guardarInmueble', ['as' => 'guardarInmueble', 'uses' => 'Admin\PropiedadController@guardarInmueble']);
Route::get('/admin/editar-inmueble1/{id}', ['as' => 'editar-inmueble-1', 'uses' => 'Admin\PropiedadController@mostrarEditarInmueble1']);
Route::post('/admin/actualizarInmueble', ['as' => 'actualizar-inmueble', 'uses' => 'Admin\PropiedadController@actualizarInmueble1']);
Route::get('/admin/editar-inmueble2/{id}', ['as' => 'editar-inmueble-2', 'uses' => 'Admin\PropiedadController@mostrarEditarInmueble2']);
Route::any('/admin/guardarImagen', ['as' => 'guardarImagen', 'uses' => 'Admin\PropiedadController@guardarImagen']);
Route::any('/admin/borrarImagen', ['as' => 'borrarImagen', 'uses' => 'Admin\PropiedadController@borrarImagen']);
