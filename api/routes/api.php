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
Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
Route::post('/usuarios/crear',  'UsuariosController@store');
Route::middleware(['auth:api', 'estatus'])->group(function () {
	Route::get('/usuarios/miperfil',	'UsuariosController@miPerfil');
	Route::get('/usuarios/complete',	'UsuariosController@complete');
	Route::post('/usuarios/habilitar/{id}',  'UsuariosController@habilitar');
	Route::post('/usuarios/deshabilitar/{id}',  'UsuariosController@deshabilitar');
	Route::post('/usuarios/asignar_actividades',  'UsuariosController@asignarActividades');
	Route::post('/usuarios/subir_archivo',  'UsuariosController@subirArchivo');
	Route::post('/usuarios/crear_medida_peso',  'UsuariosController@crearPeso');
	Route::post('/usuarios/crear_medida_talla',  'UsuariosController@crearTalla');
	Route::resource(	'usuarios',	'UsuariosController',	[	'only'	=>	[	'index',	'show',	'update']]);

	Route::get('/actividades/complete',	'ActividadesController@complete');
	Route::post('/actividades/habilitar/{id}',  'ActividadesController@habilitar');
	Route::post('/actividades/deshabilitar/{id}',  'ActividadesController@deshabilitar');
	Route::resource(	'actividades',	'ActividadesController',	[	'only'	=>	[	'index',	'show',	'create',	'update',	'destroy']]);

	Route::get('/archivos/complete',	'ArchivosController@complete');
	Route::post('/archivos/habilitar/{id}',  'ArchivosController@habilitar');
	Route::post('/archivos/deshabilitar/{id}',  'ArchivosController@deshabilitar');
	Route::resource(	'archivos',	'ArchivosController',	[	'only'	=>	[	'index',	'show',  'store',	'update',	'destroy']]);
	
	Route::get('/ciudades/complete',	'CiudadesController@complete');
	Route::get('/ciudades/estado/{estado_id}',  'CiudadesController@showEstadoID');
	Route::post('/ciudades/habilitar/{id}',  'CiudadesController@habilitar');
	Route::post('/ciudades/deshabilitar/{id}',  'CiudadesController@deshabilitar');
	Route::resource(	'ciudades',	'CiudadesController',	[	'only'	=>	[	'index',	'show',  'store',	'update',	'destroy']]);
	
	Route::get('/estados/complete',	'EstadosController@complete');
	Route::get('/estados/pais/{pais_id}',  'EstadosController@showPaisID');
	Route::post('/estados/habilitar/{id}',  'EstadosController@habilitar');
	Route::post('/estados/deshabilitar/{id}',  'EstadosController@deshabilitar');
	Route::resource(	'estados',	'EstadosController',	[	'only'	=>	[	'index',	'show',  'store',	'update',	'destroy']]);
	
	//Route::get('/instituciones/complete',	'InstitucionesController@complete');	
	//Route::post('/instituciones/habilitar/{id}',  'InstitucionesController@habilitar');
	//Route::post('/instituciones/deshabilitar/{id}',  'InstitucionesController@deshabilitar');
	Route::resource(	'instituciones',	'InstitucionesController',	[	'only'	=>	[	'index',	'show',  'store',	'update',	'destroy']]);
	
	Route::get('/paises/complete',	'PaisesController@complete');	
	Route::post('/paises/habilitar/{id}',  'PaisesController@habilitar');
	Route::post('/paises/deshabilitar/{id}',  'PaisesController@deshabilitar');
	Route::resource(	'paises',	'PaisesController',	[	'only'	=>	[	'index',	'show',  'store',	'update',	'destroy']]);
	

	Route::resource(	'pesos',	'PesosController',	[	'only'	=>	[	'index',	'show',  'store',	'update',	'destroy']]);
	Route::resource(	'tallas',	'TallasController',	[	'only'	=>	[	'index',	'show',  'store',	'update',	'destroy']]);
	
	Route::get('/tipos_de_actividad/complete',	'TiposActividadController@complete');	
	Route::post('/tipos_de_actividad/habilitar/{id}',  'TiposActividadController@habilitar');
	Route::post('/tipos_de_actividad/deshabilitar/{id}',  'TiposActividadController@deshabilitar');
	Route::resource(	'tipos_de_actividad',	'TiposActividadController',	[	'only'	=>	[	'index',	'show',  'store',	'update',	'destroy']]);
	
	Route::get('/tipos_de_archivos/complete',	'TiposArchivoController@complete');	
	Route::post('/tipos_de_archivos/habilitar/{id}',  'TiposArchivoController@habilitar');
	Route::post('/tipos_de_archivos/deshabilitar/{id}',  'TiposArchivoController@deshabilitar');
	Route::resource(	'tipos_de_archivos',	'TiposArchivoController',	[	'only'	=>	[	'index',	'show',  'store',	'update',	'destroy']]);
	
	Route::get('/tipos_de_institucion/complete',	'TiposInstitucionController@complete');	
	Route::post('/tipos_de_institucion/habilitar/{id}',  'TiposInstitucionController@habilitar');
	Route::post('/tipos_de_institucion/deshabilitar/{id}',  'TiposInstitucionController@deshabilitar');
	Route::resource(	'tipos_de_institucion',	'TiposInstitucionController',	[	'only'	=>	[	'index',	'show',  'store',	'update',	'destroy']]);
	
	Route::get('/tipos_de_sangre/complete',	'TiposSangreController@complete');	
	Route::post('/tipos_de_sangre/habilitar/{id}',  'TiposSangreController@habilitar');
	Route::post('/tipos_de_sangre/deshabilitar/{id}',  'TiposSangreController@deshabilitar');
	Route::resource(	'tipos_de_sangre',	'TiposSangreController',	[	'only'	=>	[	'index',	'show',  'store',	'update',	'destroy']]);
	
	Route::get('/tipos_de_usuario/complete',	'TiposUsuarioController@complete');	
	Route::post('/tipos_de_usuario/habilitar/{id}',  'TiposUsuarioController@habilitar');
	Route::post('/tipos_de_usuario/deshabilitar/{id}',  'TiposUsuarioController@deshabilitar');
	Route::resource(	'tipos_de_usuario',	'TiposUsuarioController',	[	'only'	=>	[	'index',	'show',  'store',	'update',	'destroy']]);
});

