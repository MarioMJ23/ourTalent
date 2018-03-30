<?php

namespace App\Http\Controllers;

use  Illuminate\Http\Request;
use  Illuminate\Http\Response;
use  Illuminate\Support\Fluent;
use  Illuminate\Support\Facades\Storage;
use  Illuminate\Support\Facades\Hash;
use  Illuminate\Support\Facades\DB;
use  App\User;
use  App\Archivos;
use  App\Instituciones;
use  App\Usuarioactividad;
use  App\Pesos;
use  App\Tallas;
use  Validator;
use  File;

class UsuariosController extends Controller  {

  private  $withAll  =  ['tipo', 'pais','estado', 'ciudad', 'archivos.tipo',  'actividades.tipo',  'institucion.tipo',  'tipo', 'pesos',  'tallas'];

  public  function  __construct() {

  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public  function index() {
    $respuesta = User::with(  $this->withAll)->where(  'estatus',  1)->get();
    return response()->json([ 'error' =>  false,  'mensaje' =>  '', 'respuesta' =>  $respuesta],  200);
  }


  public  function complete() {
    $respuesta = User::with(  $this->withAll)->get();
    return response()->json([ 'error' =>  false,  'mensaje' =>  '', 'respuesta' =>  $respuesta],  200);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public  function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */ 
  public  function store(Request $request)  {
    $validacionObj = Validator::make(  $request->all(),  [
      'tipo_de_usuario_id'  =>  'required|integer',
      'email'  =>  'required|email',
      'password'  =>  'required',
      'telefono_movil'  =>  'required|min:10',
      'actividades'  =>  'required|array',
      'pais_id'  =>  'required|integer',
      'imagen_de_perfil'  =>  'image|mimes:jpeg,png,jpg',
      'estado_id' =>  'integer',
      'descripcion'  =>  'max:2000',
      'ciudad_id' =>  'integer',
      'apodo' =>  'max:50'
    ]);

    $validacionObj->sometimes([  'institucion.nombre', 'institucion.nombre_corto'],  'required|min:5', function( $input) {
      return  $input->tipo_de_usuario_id  == 2;
    });

    $validacionObj->sometimes('institucion.tipo_de_institucion_id',  'required|integer', function( $input) {
      return  $input->tipo_de_usuario_id  == 2;
    });

    $validacionObj->sometimes(['nombre', 'apellido_paterno',  'apellido_materno'], 'required|max:50', function( $input) {
      return  $input->tipo_de_usuario_id == 3;
    });

    $validacionObj->sometimes('tipo_de_sangre_id', 'required|integer', function( $input) {
      return  $input->tipo_de_usuario_id == 3;
    });

    $validacionObj->sometimes('genero', 'required|integer', function( $input) {
      return  $input->tipo_de_usuario_id == 3;
    });

    $validacionObj->sometimes('fecha_de_nacimiento', 'required|date_format:Y-m-d', function( $input) {
      return  $input->tipo_de_usuario_id == 3;
    });

    $validacionObj->sometimes('actividades.*.id', 'required|integer', function( $input)  {
      return  isset($input->actividades);
    });

    if ( !$validacionObj->fails()) {
      $userID  =  null;
      try {
        DB::transaction(  function () use( $request, &$userID) {
          $userData  =  new User;
          $userData->email  =  $request->email;
          $userData->password  =  Hash::make( $request->password);
          $userData->tipo_de_usuario_id  =   $request->tipo_de_usuario_id;
          $userData->telefono_movil  =  $request->telefono_movil;
          $userData->pais_id  =   $request->pais_id;

          if (  $request->estado_id)
            $userData->estado_id  =  $request->estado_id;

          if (  $request->ciudad_id)
            $userData->ciudad_id  =  $request->ciudad_id;

          if (  $request->descripcion)
            $userData->descripcion  =  $request->descripcion;

          switch ($request->tipo_de_usuario_id) {
            case 2:
                $institucionData  =  new  Instituciones;

                $institucionData->nombre  =  $request->institucion['nombre'];
                $institucionData->nombre_corto  =  $request->institucion['nombre_corto'];
                $institucionData->tipo_de_institucion_id  =  $request->institucion['tipo_de_institucion_id'];

                $institucionData->save();
                
                $userData->institucion_id  =  $institucionData->id;
              break;
            case 3:
                if (  $request->apodo)
                  $userData->apodo  =  $request->apodo;

                $userData->nombre  =  $request->nombre;
                $userData->apellido_paterno  =   $request->apellido_paterno;
                $userData->apellido_materno  =   $request->apellido_materno;
                $userData->tipo_de_sangre_id  =   $request->tipo_de_sangre_id;
                $userData->fecha_de_nacimiento  =   $request->fecha_de_nacimiento;
                $userData->genero  =  $request->genero;
              break;
          };
          date_default_timezone_set("America/Mexico_City");
          $userData->fecha_de_creacion  =  date('Y-m-d H:i:s',  strtotime('now'));
          $userData->save();

          foreach ($request->actividades as $key_actividades => $actividad) {
            $usuarioActividadData  =  new Usuarioactividad;
            $usuarioActividadData->usuario_id  =  $userData->id;
            $usuarioActividadData->actividad_id  =  $actividad['id'];
            $usuarioActividadData->save();
          }

          $userCreatedData  =  User::find(  $userData->id);
          if (  $request->imagen_de_perfil) {
            $userCreatedData->imagen_de_perfil  =  $this->_guardarImagenPerfil(  $request);
            $userCreatedData->save();
          }

          $userID  =  $userData->id;
        });

        $respuesta  =  User::with(  $this->withAll)->get();
        $respuesta[  'creado']  =  User::with(  $this->withAll)->find(  $userID);
        return  response()->json([ 'error' =>  false,  'mensaje' =>  '', 'respuesta' =>  $respuesta],  200);
      }  catch  (  \Illuminate\Database\QueryException $e) {
        return  response()->json([  'error'  =>  true,
                                  'mensaje' => 'Ha occurido un error en el proceso.',
                                  'respuesta'  =>  $e->errorInfo[2]], 500);
      }
    }  else {
      return  response()->json([  'error'  =>  true,
                                  'mensaje' => 'Los patametros estan errones',
                                  'respuesta'  =>  $validacionObj->errors()], 400);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public  function show($id)
  {
    $respuesta = User::with(  $this->withAll)->find(  $id);

    return response()->json([ 'error' =>  false,  'mensaje' =>  '', 'respuesta' =>  $respuesta],  200);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public  function edit($id)
  {
      //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public  function update(Request $request, $id)  {
    $usuario = User::find(  $id);

    $validacionObj = Validator::make(  $request->all(),  [
      'telefono_movil'  =>  'min:10',
      'pais_id'  =>  'integer',
      'estado_id' =>  'integer',
      'ciudad_id' =>  'integer',
      'descripcion'  =>  'max:2000',
      'apodo' =>  'max:50'
    ]);

    $validacionObj->sometimes(  'institucion.id',  
                                'required|integer',  
                                function(  $input)  use  ($usuario)  {
                                  return  $usuario->tipo_de_usuario_id  == 2;
                                }
    );

    $validacionObj->sometimes([  'institucion.nombre'],  'min:5', function( $input) use (  $usuario) {
      return  $usuario->tipo_de_usuario_id  == 2;
    });

    $validacionObj->sometimes(['nombre', 'apellido_paterno',  'apellido_materno'], 'max:50', function( $input)  use (  $usuario) {
      return  $usuario->tipo_de_usuario_id  == 3;
    });

    $validacionObj->sometimes('tipo_de_sangre_id', 'integer', function( $input)  use (  $usuario){
      return  $usuario->tipo_de_usuario_id  == 3;
    });

    $validacionObj->sometimes('genero', 'integer', function( $input) {
      return  $input->tipo_de_usuario_id == 3;
    });

    $validacionObj->sometimes('fecha_de_nacimiento', 'date_format:Y-m-d', function( $input)  use (  $usuario){
      return  $usuario->tipo_de_usuario_id  == 3;
    });

    if (  !$usuario)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El usuario no existe',  'respuesta'  =>  ''], 500);

    if ( !$validacionObj->fails()) {
      try {
        DB::transaction(  function () use( $request, &$usuario) {
          if (  $request->telefono_movil)
            $usuario->telefono_movil  =  $request->telefono_movil;

          if (  $request->pais_id)
            $usuario->pais_id  =   $request->pais_id;

          if (  $request->estado_id)
            $usuario->estado_id  =  $request->estado_id;

          if (  $request->ciudad_id)
            $usuario->ciudad_id  =  $request->ciudad_id;

          if (  $request->descripcion)
            $userData->descripcion  =  $request->descripcion;

          switch ($usuario->tipo_de_usuario_id) {
            case 2:
                $institucionData  =  Instituciones::find(  $usuario->institucion['id']);

                if (  $request->institucion['nombre'])
                  $institucionData->nombre  =  $request->institucion['nombre'];

                if (  $request->institucion['nombre_corto'])
                  $institucionData->nombre_corto  =  $request->institucion['nombre_corto'];

                date_default_timezone_set("America/Mexico_City");
                $institucionData->fecha_de_actualizacion  =  date('Y-m-d H:i:s',  strtotime('now'));
                $institucionData->save();
              break;
            case 3:
                if (  $request->apodo)
                  $usuario->apodo  =  $request->apodo;

                if (  $request->nombre)
                  $usuario->nombre  =  $request->nombre;
                
                if (  $request->apellido_paterno)
                  $usuario->apellido_paterno  =   $request->apellido_paterno;

                if (  $request->apellido_materno)
                  $usuario->apellido_materno  =   $request->apellido_materno;

                if (  $request->tipo_de_sangre_id)
                  $usuario->tipo_de_sangre_id  =   $request->tipo_de_sangre_id;

                if (  $request->fecha_de_nacimiento)
                  $usuario->fecha_de_nacimiento  =   $request->fecha_de_nacimiento;

                if  (  $request->genero)
                  $usuario->genero  =  $request->genero;
              break;
          };

          date_default_timezone_set("America/Mexico_City");
          $usuario->fecha_de_actualizacion  =  date('Y-m-d H:i:s',  strtotime('now'));
          $usuario->save();
        });

        $respuesta  =  User::with(  $this->withAll)->find(  $id);
        return  response()->json([  'error' =>  false,
                                    'mensaje' =>  'La información se ha actualizado correctamente',
                                    'respuesta' =>  $respuesta],  200);
      }  catch  (  \Illuminate\Database\QueryException $e) {
        return  response()->json([  'error'  =>  true,
                                  'mensaje' => 'Ha occurido un error en el proceso.',
                                  'respuesta'  =>  $e->errorInfo[2]], 500);
      }
    }  else {
      return  response()->json([  'error'  =>  true,
                                  'mensaje' => 'Los patametros estan errones',
                                  'respuesta'  =>  $validacionObj->errors()], 400);
    } 
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public  function destroy($id)  {
  }

  public  function miPerfil( Request $request)  {
    $usuario =  $request->user();
    $respuesta = User::with(  $this->withAll)->find(  $usuario['id']);

    return response()->json([ 'error' =>  false,  'mensaje' =>  '', 'respuesta' =>  $respuesta],  200);
  }

  public  function  habilitar(  Request  $request,  $id)  {
    $usuario  =  User::where(  'estatus',  0)->find(  $id);

    if (  !$usuario)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El usuario no existe o ya esta habilitado',  'respuesta'  =>  ''], 500);


    try  {
      $usuario->estatus  =  1;
      date_default_timezone_set("America/Mexico_City");
      $usuario->fecha_de_actualizacion  =  date('Y-m-d H:i:s',  strtotime('now'));
      $usuario->save();
      $respuesta = User::with(  $this->withAll)->find(  $id);
      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'El usuario se ha habilitado correctamente',
                                  'respuesta' =>  $respuesta],  200);
    }  catch  (  \Illuminate\Database\QueryException $e) {
      return  response()->json([  'error'  =>  true,
                                'mensaje' => 'Ha occurido un error en el proceso.',
                                'respuesta'  =>  $e->errorInfo[2]], 500);
    }
  }

  public  function  deshabilitar(  Request  $request,  $id)  {
    $usuario  =  User::where(  'estatus',  1)->find(  $id);

    if (  !$usuario)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El usuario no existe o ya esta deshabilitado',  'respuesta'  =>  ''], 500);


    try {
      $usuario->estatus  =  0;
      date_default_timezone_set("America/Mexico_City");
      $usuario->fecha_de_actualizacion  =  date('Y-m-d H:i:s',  strtotime('now'));
      $usuario->save();
      $respuesta = User::with(  $this->withAll)->find(  $id);
      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'El usuario se ha deshabilitado correctamente',
                                  'respuesta' =>  $respuesta],  200);
    }  catch  (  \Illuminate\Database\QueryException $e) {
      return  response()->json([  'error'  =>  true,
                                'mensaje' => 'Ha occurido un error en el proceso.',
                                'respuesta'  =>  $e->errorInfo[2]], 500);
    }
  }

  public  function  asignarActividades(  Request  $request)  {
    $validacionObj = Validator::make(  $request->all(),  [
      'actividades'  =>  'required|array'
    ]);

    $validacionObj->sometimes('actividades.*.id', 'required|integer|min:1', function( $input)  {
      return  isset($input->actividades);
    });

    if ( !$validacionObj->fails()) {
      try {
        DB::transaction(  function () use(  $request) {
          $acividadesEleminiadas  =  Usuarioactividad::where(  'usuario_id',  $request->user()->id)->delete();

          foreach ($request->actividades as $key_actividades => $actividad) {
            $usuarioActividadData  =  new Usuarioactividad;
            $usuarioActividadData->usuario_id  =  $request->user()->id;
            $usuarioActividadData->actividad_id  =  $actividad['id'];

            date_default_timezone_set("America/Mexico_City");
            $usuarioActividadData->fecha_de_creacion  =  date('Y-m-d H:i:s',  strtotime('now'));
            $usuarioActividadData->save();
          }
        });

        $respuesta  =  User::with(  $this->withAll)->find(  $request->user()->id);
        return  response()->json([ 'error' =>  false,  'mensaje' =>  '', 'respuesta' =>  $respuesta],  200);
      }  catch  (  \Illuminate\Database\QueryException $e) {
        return  response()->json([  'error'  =>  true,
                                  'mensaje' => 'Ha occurido un error en el proceso.',
                                  'respuesta'  =>  $e->errorInfo[2]], 500);
      }
    }  else {
      return  response()->json([  'error'  =>  true,
                                  'mensaje' => 'Los patametros estan errones',
                                  'respuesta'  =>  $validacionObj->errors()], 400);
    }
  }

  public  function  crearPeso(  Request  $request)  {
    $validacionObj  =  Validator::make( $request->all(),[
      'peso'  =>  'required|numeric',
      'peso_en'  =>  'required|numeric'
    ]);

    if ( !$validacionObj->fails()) {
      if (  ($request->peso  *  2.205)  !=  $request->peso_en)
        return  response()->json([  'error'  =>  true,  'mensaje' => 'Los patametros estan errones, pesos no equivalentes 1 KG = 2.205 lb',  'respuesta'  =>  ''], 400);

      try  {
        DB::transaction(  function ()  use(  $request)  {
          $peso  =  new  Pesos;

          $peso->peso  =  $request->peso;
          $peso->peso_en  =  $request->peso_en;
          $peso->usuario_id  =  $request->user()->id;

          date_default_timezone_set("America/Mexico_City");
          $peso->fecha_de_creacion  =  date('Y-m-d H:i:s',  strtotime('now'));
          $peso->save();
        });

        $respuesta  =  Pesos::where(  'id',  $request->user()->id)->get();
        return  response()->json([ 'error' =>  false,  'mensaje' =>  '', 'respuesta' =>  $respuesta],  200);
      }  catch  (  \Illuminate\Database\QueryException $e) {
        return  response()->json([  'error'  =>  true,
                                  'mensaje' => 'Ha occurido un error en el proceso.',
                                  'respuesta'  =>  $e->errorInfo[2]], 500);
      }
    }  else {
      return  response()->json([  'error'  =>  true,
                                  'mensaje' => 'Los patametros estan errones',
                                  'respuesta'  =>  $validacionObj->errors()], 400);
    }
  }

  public  function  crearTalla(  Request  $request)  {
    $validacionObj  =  Validator::make( $request->all(),[
      'talla'  =>  'required|numeric',
      'talla_en'  =>  'required|numeric'
    ]);

    if ( !$validacionObj->fails()) {
      if (  ($request->talla  *  3.28084)  !=  $request->talla_en)
        return  response()->json([  'error'  =>  true,  'mensaje' => 'Los patametros estan errones, tallas no equivalentes 1 M = 3.28084 ft',  'respuesta'  =>  ''], 400);

      try  {
        DB::transaction(  function ()  use(  $request)  {
          $talla  =  new  Tallas;

          $talla->talla  =  $request->talla;
          $talla->talla_en  =  $request->talla_en;
          $talla->usuario_id  =  $request->user()->id;

          date_default_timezone_set("America/Mexico_City");
          $talla->fecha_de_creacion  =  date('Y-m-d H:i:s',  strtotime('now'));
          $talla->save();
        });

        $respuesta  =  Tallas::where(  'id',  $request->user()->id)->get();
        return  response()->json([ 'error' =>  false,  'mensaje' =>  '', 'respuesta' =>  $respuesta],  200);
      }  catch  (  \Illuminate\Database\QueryException $e) {
        return  response()->json([  'error'  =>  true,
                                  'mensaje' => 'Ha occurido un error en el proceso.',
                                  'respuesta'  =>  $e->errorInfo[2]], 500);
      }
    }  else {
      return  response()->json([  'error'  =>  true,
                                  'mensaje' => 'Los patametros estan errones',
                                  'respuesta'  =>  $validacionObj->errors()], 400);
    }
  }

  public  function  subirArchivo(  Request  $request)  {
    $validacionObj = Validator::make(  $request->all(),  [
      'archivo'  =>  'required|max:204800',
      'nombre_del_archivo'  => 'required',
      'tipo_de_archivo_id'  =>  'required|integer|max:3|min:1'
    ]);

    $validacionObj->sometimes('archivo',  'image|mimes:jpeg,png,jpg', function( $input)  {
      return  $input->tipo_de_archivo_id  ==  1;
    });

    $validacionObj->sometimes('archivo',  'mimes:3gp,mp4,ts,m4v,mov,avi,m4a,mpg,wav,wmv', function( $input)  use  (  $request)  {
      $validations  =  [  '3gp','mp4','ts','m4v','mov','avi','m4a','mpg','wav','wmv'];
      $explodeNombre  =  explode(  '.',  $request->archivo->getClientOriginalName());

      $ext  =  $explodeNombre[1];
      return  $input->tipo_de_archivo_id  ==  2  &&  !in_array(  $ext,  $validations);
    });

    $validacionObj->sometimes('archivo',  'mimes:mp3,ogg,wav', function( $input) use( $request) {
      $validations  =  [  'mp3',  'ogg',  'wav'];
      $explodeNombre  =  explode(  '.',  $request->archivo->getClientOriginalName());

      $ext  =  $explodeNombre[1];
      return  $input->tipo_de_archivo_id  ==  3  &&  !in_array(  $ext,  $validations);
    });

    if ( !$validacionObj->fails()) {
      try {
        DB::transaction(  function () use(  $request) {
          $nuevoArchivo  =  new  Archivos;

          $nuevoArchivo->nombre_del_archivo  =  $request->nombre_del_archivo;
          $nuevoArchivo->tipo_de_archivo_id  =  $request->tipo_de_archivo_id;
          $nuevoArchivo->usuario_id  =  $request->user()->id;
          $nuevoArchivo->ruta_del_archivo  =  $this->_guardarArchivo(  $request,  $request->tipo_de_archivo_id);

          date_default_timezone_set("America/Mexico_City");
          $nuevoArchivo->fecha_de_creacion  =  date('Y-m-d H:i:s',  strtotime('now'));
          $nuevoArchivo->save();
        });

        $respuesta  =  Archivos::with(  [  'usuario',  'tipo'])->where(  'usuario_id',  $request->user()->id)->get();
        return  response()->json([ 'error' =>  false,  'mensaje' =>  '', 'respuesta' =>  $respuesta],  200);
      }  catch  (  \Illuminate\Database\QueryException $e) {
        return  response()->json([  'error'  =>  true,
                                  'mensaje' => 'Ha occurido un error en el proceso.',
                                  'respuesta'  =>  $e->errorInfo[2]], 500);
      }
    }  else {
      return  response()->json([  'error'  =>  true,
                                  'mensaje' => 'Los patametros estan errones',
                                  'respuesta'  =>  $validacionObj->errors()], 400);
    }
  }

  private  function _guardarArchivo(  $request,  $tipoDeArchivo)  {
    $splitEmail = explode(  '@',  $request->user()->email);
    $folderFile = md5(  $splitEmail[0]);
    if (  $tipoDeArchivo  ==  3)  {
      $rutaDelArchivo  =  'storage/audios/';
    } else {
      if (  $tipoDeArchivo  ==  2) {
        $rutaDelArchivo  =  'storage/videos/';
      }  else  {
        $rutaDelArchivo  =  'storage/imagenes/';
      }
    }

    $explodeNombre  =  explode(  '.',  $request->archivo->getClientOriginalName());
    $ext  =  $explodeNombre[1];

    File::makeDirectory(  $rutaDelArchivo . $folderFile, 0777, true, true);

    $archivoName = strtotime('now') . '.' . $ext;
    $pathUploadedFile = $request->archivo->move( $rutaDelArchivo . $folderFile, $archivoName);
    
    return $pathUploadedFile;
  }

  private  function _guardarImagenPerfil(  $request)  {
    $splitEmail = explode(  '@',  $request->email);
    $folderFile = md5(  $splitEmail[0]);

    File::makeDirectory(  'storage/imagenes/' . $folderFile, 0777, true, true);
    File::makeDirectory(  'storage/imagenes/' . $folderFile . '/perfil', 0777, true, true);

    $imgName = strtotime('now') . '.' . $request->imagen_de_perfil->extension();
    $pathUploadedFile = $request->imagen_de_perfil->move( 'storage/imagenes/' . $folderFile . '/perfil', $imgName);
    
    return $pathUploadedFile;
  }
}
