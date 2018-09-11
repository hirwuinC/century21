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
Route::get('/', ['as' => 'home', 'uses' => 'WebController@index']);
Route::any('/enviarCurriculum', ['as' => 'enviarCurriculum', 'uses' => 'WebController@enviarCurriculum']);
Route::any('/nuevoContacto', ['as' => 'nuevoContacto', 'uses' => 'WebController@nuevoContacto']);
Route::get('/buscador', ['as' => 'buscador', 'uses' => 'WebController@buscador']);
Route::get('/proyectos', ['as' => 'proyectos', 'uses' => 'WebController@lista_proyectos']);
Route::get('/contacto', ['as' => 'contacto', 'uses' => 'WebController@contacto']);
Route::get('/nuestra-historia', ['as' => 'nuestra_historia', 'uses' => 'WebController@nuestra_historia']);
Route::get('/inmueble/{id}', ['as' => 'detalle_inmueble', 'uses' => 'WebController@detalle_inmueble']);
Route::get('/proyecto/{id}', ['as' => 'detalle_proyecto', 'uses' => 'WebController@detalle_proyecto']);
Route::any('/interesadoPublicar', ['as' => 'interesadoPublicar', 'uses' => 'WebController@interesadoPublicar']);
Route::any('/compradorInteresado', ['as' => 'compradorInteresado', 'uses' => 'WebController@compradorInteresado']);
Route::any('/compradorInteresadoProyecto', ['as' => 'compradorInteresadoProyecto', 'uses' => 'WebController@compradorInteresadoProyecto']);
Route::any('/buscarInmueblesPublico', ['as' => 'buscarInmueblesPublico', 'uses' => 'WebController@buscarInmueblesPublico']);
Route::any('/listarCiudadesPublico', ['as' => 'listarCiudadesPublico', 'uses' => 'WebController@listarCiudadesPublico']);
Route::any('/listarUrbanizacionesPublico', ['as' => 'listarUrbanizacionesPublico', 'uses' => 'WebController@listarUrbanizacionesPublico']);
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});


                                        //ADMIN


// LOGIN
Route::group(['middleware' => 'relogin'], function () {

	Route::any('/admin/login', ['as' => 'login', 'middleware'=>['guest'],'uses' => 'Admin\AdminController@Login']);
	Route::any('/admin/ingresar', ['as' => 'login-ingresar', 'uses' => 'Admin\AdminController@ingresar']);
});

Route::any('/admin/salir', ['as' => 'login-salir', 'uses' => 'Admin\AdminController@salir']);



Route::group(['middleware' => 'menu'], function () {

	//Perfil
	Route::get('/admin/perfil', ['as' => 'perfil', 'uses' => 'Admin\PerfilController@Perfil']);
	Route::any('/admin/actualizarPerfil', ['as' => 'updatePerfil', 'uses' => 'Admin\PerfilController@actualizarPerfil']);

	//inmuebles asesores y administradores 
	Route::get('/admin/inmuebles', ['as' => 'admin_lista_inmuebles', 'uses' => 'Admin\PropiedadController@ListaInmuebles']);
	Route::get('/admin/inmueble/{id}', ['as' => 'admin_detalle_inmueble', 'uses' => 'Admin\PropiedadController@DetalleInmueble']);
	Route::any('/admin/listarCiudades', ['as' => 'listarCiudades', 'uses' => 'Admin\PropiedadController@listarCiudades']);
	Route::any('/admin/listarUrbanizaciones', ['as' => 'listarUrbanizaciones', 'uses' => 'Admin\PropiedadController@listarUrbanizaciones']);
	Route::any('/admin/buscarInmueble', ['as' => 'buscarInmueble', 'uses' => 'Admin\PropiedadController@buscarInmueble']);


	/// INFORMES DE GESTION
	Route::get('/admin/pruebaInforme',['as'=>'pruebaInforme','uses'=>'Admin\InformeController@pruebaInforme'] );
	Route::any('/admin/nuevoInforme',['as'=>'nuevoInforme','uses'=>'Admin\InformeController@nuevoInforme'] );
	Route::any('/admin/guardarInforme',['as'=>'guardarInforme','uses'=>'Admin\InformeController@guardarInforme'] );
	Route::any('/admin/previewInforme/{id}',['as'=>'previewInforme','uses'=>'Admin\InformeController@previewInforme'] );
	Route::any('/admin/modaleditarinforme',['as'=>'editarInforme','uses'=>'Admin\InformeController@editarInforme'] );
	Route::any('/admin/actualizarInforme',['as'=>'actualizarInforme','uses'=>'Admin\InformeController@actualizarInforme'] );
	Route::any('/admin/enviarCorreo',['as'=>'enviarCorreo','uses'=>'Admin\InformeController@enviarCorreo'] );

	//GESTOR DE EVENTOS DIARIOS
	Route::get('/admin/index',['as'=>'gestorEventos','uses'=>'Admin\GestorEventosController@index']);
	Route::post('/admin/proximoMes',['as'=>'proximoMes','uses'=>'Admin\GestorEventosController@proximoMes']);
	Route::post('/admin/mesAnterior',['as'=>'mesAnterior','uses'=>'Admin\GestorEventosController@mesAnterior']);
	Route::any('/admin/guardarEvento',['as'=>'guardarEvento','uses'=>'Admin\GestorEventosController@guardarEvento']);
	Route::post('/admin/eventoDia',['as'=>'eventoDia','uses'=>'Admin\GestorEventosController@eventoDia']);
	Route::post('/admin/eliminarEvento',['as'=>'eliminarEvento','uses'=>'Admin\GestorEventosController@eliminarEvento']);
	Route::post('/admin/modificarEvento',['as'=>'modificarEvento','uses'=>'Admin\GestorEventosController@modificarEvento']);

});

Route::group(['middleware' => 'administrador'], function () {

		// PRUEBAS
	Route::get('/prueba', ['as' => 'prueba', 'uses' => 'Admin\InformeController@prueba']);
	Route::get('/correo',['as'=>'pruebac','uses'=>'Admin\EstadisticasController@propiedadesCaptadasFiltro']);
	// Ajustes de direcciones
	Route::get('/admin/direcciones',['as'=>'direcciones','uses'=>'Admin\DireccionesController@ajusteDirecciones'] );
	Route::post('/admin/guardarCiudad',['as'=>'guardarCiudad','uses'=>'Admin\DireccionesController@guardarCiudad'] );
	Route::any('/admin/guardarUrbanizacion',['as'=>'guardarUrbanizacion','uses'=>'Admin\DireccionesController@guardarUrbanizacion'] );
	Route::any('/admin/borrarCiudad',['as'=>'borrarCiudad','uses'=>'Admin\DireccionesController@borrarCiudad'] );
	Route::any('/admin/borrarUrbanizacion',['as'=>'borrarUrbanizacion','uses'=>'Admin\DireccionesController@borrarUrbanizacion'] );

	//Asesores
	Route::get('/admin/crear-usuario/{id}', ['as' => 'crear-agente', 'uses' => 'Admin\AsesorController@CrearUsuarioAsesor']);
	Route::get('/admin/agente', ['as' => 'lista-agente', 'uses' => 'Admin\AsesorController@ListarAsesores']);
	Route::get('/admin/buscarasesor',['as'=>'prueba','uses'=>'Admin\AsesorController@searchAsesor'] );
	Route::any('/admin/buscaruser',['as'=>'buscar_user','uses'=>'Admin\AsesorController@guardarEditarUsuario']);
	Route::any('/admin/borrarAsesor',['as'=>'borrarAsesor','uses'=>'Admin\AsesorController@borrarAsesor'] );

	// ESTADISTICAS
	Route::get('/admin/estadisticas', ['as' => 'estadisticas', 'uses' => 'Admin\EstadisticasController@index']);
	Route::post('/admin/listarTipoReporte', ['as' => 'listar', 'uses' => 'Admin\EstadisticasController@tipoReporte']);
	Route::post('/admin/listarAsesores', ['as' => 'listarAsesores', 'uses' => 'Admin\EstadisticasController@listarAsesores']);
	Route::post('/admin/listarCiudadesReportes', ['as' => 'listarCiudadesReportes', 'uses' => 'Admin\EstadisticasController@listarCiudades']);
	Route::post('/admin/listarUrbanizacionesReportes', ['as' => 'listarUrbanizacionesReportes', 'uses' => 'Admin\EstadisticasController@listarUrbanizaciones']);
	Route::any('/admin/distribucionAsesor/{fechaI}/{fechaF}/{data}', ['as' => 'disU', 'uses' => 'Admin\EstadisticasController@distribucionAsesor']);
	Route::any('/admin/distribucionUbicacion/{fechaI}/{fechaF}/{estados}/{ciudades}/{urbanizaciones}', ['as' => 'disUbi', 'uses' => 'Admin\EstadisticasController@distribucionUbicacion']);
	Route::get('/admin/distribucionTipInmAsesor/{fechaI}/{fechaF}/{data}', ['as' => 'disTip', 'uses' => 'Admin\EstadisticasController@distribucionAsesorTipoInmueble']);
	Route::get('/admin/distribucionTipInmUbicacion/{fechaI}/{fechaF}/{estados}/{ciudades}/{urbanizaciones}', ['as' => 'disTip', 'uses' => 'Admin\EstadisticasController@distribucionUbicacionTipoInmueble']);
	Route::get('/admin/captadasAsesor/{fechaI}/{fechaF}/{precioI}-{precioF}/{asesores}', ['as' => 'capFilas', 'uses' => 'Admin\EstadisticasController@captadasAsesorFiltro']);
	Route::get('/admin/captadasUbicacion/{fechaI}/{fechaF}/{precioI}-{precioF}/{estados}/{ciudades}/{urbanizaciones}', ['as' => 'captadasUbicacion', 'uses' => 'Admin\EstadisticasController@captadasUbicacion']);
	Route::get('/admin/vendidasAsesor/{fechaI}/{fechaF}/{precioI}-{precioF}/{asesores}', ['as' => 'vendidasAsesor', 'uses' => 'Admin\EstadisticasController@vendidasAsesorFiltro']);
	Route::get('/admin/vendidasUbicacion/{fechaI}/{fechaF}/{precioI}-{precioF}/{estados}/{ciudades}/{urbanizaciones}', ['as' => 'vendidasUbicacion', 'uses' => 'Admin\EstadisticasController@vendidasUbicacion']);
	Route::get('/admin/distribucionTipoNegocio/{fechaI}/{fechaF}/{data}', ['as' => 'tipoNegocio', 'uses' => 'Admin\EstadisticasController@distribucionTipoNegocio']);
	Route::get('/admin/ventasTipoIntermediacion/{fechaI}/{fechaF}/{data}', ['as' => 'ventasTipoIntermediacion', 'uses' => 'Admin\EstadisticasController@ventasTipoIntermediacion']);
	Route::get('/admin/reporteGeneralVentas/{fechaI}/{fechaF}', ['as' => 'reporteGeneralVentas', 'uses' => 'Admin\EstadisticasController@reporteGeneralVentas']);
	Route::get('/admin/ventasTipoInmuebleAsesor/{fechaI}/{fechaF}/{data}', ['as' => 'ventasTipoInmuebleAsesor', 'uses' => 'Admin\EstadisticasController@ventasTipoInmuebleAsesor']);
	Route::get('/admin/ventasTipoInmuebleUbicacion/{fechaI}/{fechaF}/{estados}/{ciudades}/{urbanizaciones}', ['as' => 'ventasTipoInmuebleUbicacion', 'uses' => 'Admin\EstadisticasController@ventasTipoInmuebleUbicacion']);
	Route::get('/admin/ventasTipoNegocioAsesor/{fechaI}/{fechaF}/{data}', ['as' => 'ventasTipoNegocioAsesor', 'uses' => 'Admin\EstadisticasController@ventasTipoNegocioAsesor']);
	Route::get('/admin/ventasTipoNegocioUbicacion/{fechaI}/{fechaF}/{estados}/{ciudades}/{urbanizaciones}', ['as' => 'ventasTipoInmuebleUbicacion', 'uses' => 'Admin\EstadisticasController@ventasTipoNegocioUbicacion']);
	Route::get('/admin/rendimientoAsesor/{fechaI}/{fechaF}/{data}', ['as' => 'rendimientoAsesor', 'uses' => 'Admin\EstadisticasController@rendimientoAsesor']);
	Route::get('/admin/negociacionesGeneral/{fechaI}/{fechaF}/{data}', ['as' => 'negociacionesGeneral', 'uses' => 'Admin\EstadisticasController@negociacionesGeneral']);
	



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
	Route::any('/admin/compradorCargado', ['as' => 'compradorCargado', 'uses' => 'Admin\NegociacionController@compradorCargado']);
	Route::any('/admin/guardarComprador', ['as' => 'guardarComprador', 'uses' => 'Admin\NegociacionController@guardarComprador']);
	Route::any('/admin/buscarComprador', ['as' => 'buscarComprador', 'uses' => 'Admin\NegociacionController@buscarComprador']);


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
	Route::any('/admin/buscarProyecto', ['as' => 'buscarProyecto', 'uses' => 'Admin\ProyectoController@buscarProyecto']);
	Route::get('/admin/buscarProyectoCodigo',['as'=>'buscarProyectoCodigo','uses'=>'Admin\ProyectoController@buscarProyectoCodigo'] );
	Route::post('/admin/borrarProyecto',['as'=>'borrarProyecto','uses'=>'Admin\ProyectoController@borrarProyecto'] );


//////////////////////// Inmuebles administrador /////////////////////////////////////////////////

	Route::get('/admin/crear-inmueble-1', ['as' => 'crear-inmueble-1', 'uses' => 'Admin\PropiedadController@CrearInmueble1']);
	Route::get('/admin/crear-inmueble-2', ['as' => 'crear-inmueble-2', 'uses' => 'Admin\PropiedadController@CrearInmueble2']);
	Route::any('/admin/cargarPropiedad', ['as' => 'cargarPropiedad', 'uses' => 'Admin\PropiedadController@cargarPropiedad']);
	Route::any('/admin/guardarInmueble', ['as' => 'guardarInmueble', 'uses' => 'Admin\PropiedadController@guardarInmueble']);
	Route::get('/admin/editar-inmueble1/{id}', ['as' => 'editar-inmueble-1', 'uses' => 'Admin\PropiedadController@mostrarEditarInmueble1']);
	Route::post('/admin/actualizarInmueble', ['as' => 'actualizar-inmueble', 'uses' => 'Admin\PropiedadController@actualizarInmueble1']);
	Route::get('/admin/editar-inmueble2/{id}', ['as' => 'editar-inmueble-2', 'uses' => 'Admin\PropiedadController@mostrarEditarInmueble2']);
	Route::any('/admin/guardarImagen', ['as' => 'guardarImagen', 'uses' => 'Admin\PropiedadController@guardarImagen']);
	Route::any('/admin/borrarImagen', ['as' => 'borrarImagen', 'uses' => 'Admin\PropiedadController@borrarImagen']);
	Route::any('/admin/borrarInmueble',['as'=>'borrarInmueble','uses'=>'Admin\PropiedadController@borrarInmueble'] );


	///COMPRADORES
	Route::get('/admin/modificar-comprador/{id}', ['as' => 'modificar-comprador', 'uses' => 'Admin\CompradorController@modificarComprador']);
	Route::get('/admin/compradores', ['as' => 'lista-comprador', 'uses' => 'Admin\CompradorController@listarCompradores']);
	Route::post('/admin/actualizarComprador', ['as' => 'actualizarComprador', 'uses' => 'Admin\CompradorController@actualizarComprador']);
	Route::get('/admin/buscarcomprador',['as'=>'prueba','uses'=>'Admin\CompradorController@searchComprador'] );
});