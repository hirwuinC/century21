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
Route::get('/pdf', ['as' => 'pdf', 'uses' => 'Controller@pruebaPDF']);
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
Route::any('/admin/salir', ['as' => 'login-salir', 'uses' => 'Admin\AdminController@salir']);



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
Route::any('/admin/listarUrbanizaciones', ['as' => 'listarUrbanizaciones', 'uses' => 'Admin\PropiedadController@listarUrbanizaciones']);
Route::any('/admin/cargarPropiedad', ['as' => 'cargarPropiedad', 'uses' => 'Admin\PropiedadController@cargarPropiedad']);
Route::any('/admin/guardarInmueble', ['as' => 'guardarInmueble', 'uses' => 'Admin\PropiedadController@guardarInmueble']);
Route::get('/admin/editar-inmueble1/{id}', ['as' => 'editar-inmueble-1', 'uses' => 'Admin\PropiedadController@mostrarEditarInmueble1']);
Route::post('/admin/actualizarInmueble', ['as' => 'actualizar-inmueble', 'uses' => 'Admin\PropiedadController@actualizarInmueble1']);
Route::get('/admin/editar-inmueble2/{id}', ['as' => 'editar-inmueble-2', 'uses' => 'Admin\PropiedadController@mostrarEditarInmueble2']);
Route::any('/admin/guardarImagen', ['as' => 'guardarImagen', 'uses' => 'Admin\PropiedadController@guardarImagen']);
Route::any('/admin/borrarImagen', ['as' => 'borrarImagen', 'uses' => 'Admin\PropiedadController@borrarImagen']);

/// NEGOCIACIONES
Route::any('/admin/llenarModalNegociacion', ['as' => 'llenarModalNegociacion', 'uses' => 'Admin\NegociacionController@llenarModalNegociacion']);
Route::any('/admin/guardarNegociacion', ['as' => 'guardarNegociacion', 'uses' => 'Admin\NegociacionController@guardarNegociacion']);
Route::any('/admin/guardarPaso', ['as' => 'guardarPaso', 'uses' => 'Admin\NegociacionController@guardarPaso']);
Route::any('/admin/guardarDeposito', ['as' => 'guardarDeposito', 'uses' => 'Admin\NegociacionController@guardarDeposito']);
Route::any('/admin/guardarBilateral', ['as' => 'guardarBilateral', 'uses' => 'Admin\NegociacionController@guardarBilateral']);
Route::any('/admin/guardarRegistro', ['as' => 'guardarRegistro', 'uses' => 'Admin\NegociacionController@guardarRegistro']);
Route::any('/admin/guardarReporte', ['as' => 'guardarReporte', 'uses' => 'Admin\NegociacionController@guardarReporte']);
Route::any('/admin/historialNegociaciones', ['as' => 'historialNegociaciones', 'uses' => 'Admin\NegociacionController@historialNegociaciones']);
Route::any('/admin/cancelarNegociacion', ['as' => 'cancelarNegociacion', 'uses' => 'Admin\NegociacionController@cancelarNegociacion']);
Route::any('/admin/cambiarEstatusInmueble', ['as' => 'cambiarEstatusInmueble', 'uses' => 'Admin\NegociacionController@cambiarEstatusInmueble']);

/// INFORMES DE GESTION
Route::get('/admin/pruebaInforme',['as'=>'pruebaInforme','uses'=>'Admin\InformeController@pruebaInforme'] );
Route::any('/admin/nuevoInforme',['as'=>'nuevoInforme','uses'=>'Admin\InformeController@nuevoInforme'] );
Route::any('/admin/guardarInforme',['as'=>'guardarInforme','uses'=>'Admin\InformeController@guardarInforme'] );
Route::any('/admin/previewInforme/{id}',['as'=>'previewInforme','uses'=>'Admin\InformeController@previewInforme'] );
Route::any('/admin/modaleditarinforme',['as'=>'editarInforme','uses'=>'Admin\InformeController@editarInforme'] );
Route::any('/admin/actualizarInforme',['as'=>'actualizarInforme','uses'=>'Admin\InformeController@actualizarInforme'] );
Route::any('/admin/enviarCorreo',['as'=>'enviarCorreo','uses'=>'Admin\InformeController@enviarCorreo'] );

//PROYECTOS
Route::get('/admin/proyectos', ['as' => 'admin_lista_proyectos', 'uses' => 'Admin\ProyectoController@ListaProyectos']);
Route::get('/admin/crear-proyectos-1', ['as' => 'crear-proyecto-1', 'uses' => 'Admin\ProyectoController@CrearProyecto1']);
Route::get('/admin/crear-proyectos-2', ['as' => 'crear-proyecto-2', 'uses' => 'Admin\ProyectoController@CrearProyecto2']);
Route::get('/admin/crear-proyectos-3', ['as' => 'crear-proyecto-3', 'uses' => 'Admin\ProyectoController@CrearProyecto3']);
Route::any('/admin/cargarProyecto1', ['as' => 'cargarProyecto1', 'uses' => 'Admin\ProyectoController@cargarProyecto1']);
Route::any('/admin/cargarInmuebleProyectos', ['as' => 'cargarInmuebleProyectos', 'uses' => 'Admin\ProyectoController@cargarInmuebleProyectos']);
Route::any('/admin/borrarInmuebleProyectos', ['as' => 'borrarInmuebleProyectos', 'uses' => 'Admin\ProyectoController@borrarInmuebleProyectos']);
Route::any('/admin/evaluarInmueble', ['as' => 'evaluarInmueble', 'uses' => 'Admin\ProyectoController@evaluarInmueble']);
Route::any('/admin/guardarImagenProyecto', ['as' => 'guardarImagenProyecto', 'uses' => 'Admin\ProyectoController@guardarImagenProyecto']);
Route::any('/admin/borrarImagenProyecto', ['as' => 'borrarImagenProyecto', 'uses' => 'Admin\ProyectoController@borrarImagenProyecto']);
Route::any('/admin/guardarProyecto', ['as' => 'guardarProyecto', 'uses' => 'Admin\ProyectoController@guardarProyecto']);
Route::get('/admin/editar-proyectos-1/{id}', ['as' => 'editar-proyecto-1', 'uses' => 'Admin\ProyectoController@editarProyecto1']);
Route::get('/admin/editar-proyectos-2/{id}', ['as' => 'editar-proyecto-2', 'uses' => 'Admin\ProyectoController@editarProyecto2']);
Route::get('/admin/editar-proyectos-3/{id}', ['as' => 'editar-proyecto-3', 'uses' => 'Admin\ProyectoController@editarProyecto3']);
Route::any('/admin/actualizarProyecto1', ['as' => 'actualizarProyecto1', 'uses' => 'Admin\ProyectoController@actualizarProyecto1']);
Route::get('/admin/proyecto/{id}', ['as' => 'admin_detalle_proyecto', 'uses' => 'Admin\ProyectoController@detalleProyecto']);

// ESTADISTICAS
Route::get('/admin/estadisticas', ['as' => 'estadisticas', 'uses' => 'Admin\EstadisticasController@index']);
Route::post('/admin/listarTipoReporte', ['as' => 'listar', 'uses' => 'Admin\EstadisticasController@tipoReporte']);

// PRUEBAS

Route::get('/prueba', ['as' => 'prueba', 'uses' => 'Admin\InformeController@prueba']);
Route::get('/correo',['as'=>'pruebac','uses'=>'Correo@listarPropiedades']);

//GESTOR DE EVENTOS DIARIOS
Route::get('/admin/index',['as'=>'gestorEventos','uses'=>'Admin\GestorEventosController@index']);
Route::post('/admin/proximoMes',['as'=>'proximoMes','uses'=>'Admin\GestorEventosController@proximoMes']);
Route::post('/admin/mesAnterior',['as'=>'mesAnterior','uses'=>'Admin\GestorEventosController@mesAnterior']);
Route::any('/admin/guardarEvento',['as'=>'guardarEvento','uses'=>'Admin\GestorEventosController@guardarEvento']);
Route::get('/admin/pruebaEvento',['as'=>'guardarEvento','uses'=>'Admin\GestorEventosController@prueba']);
Route::post('/admin/eventoDia',['as'=>'eventoDia','uses'=>'Admin\GestorEventosController@eventoDia']);
