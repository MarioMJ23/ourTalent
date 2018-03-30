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

use  Validator;

class ArchivosController extends Controller  {

  private  $withAll  =  [  'tipo', 'usuario'];

  public  function  __construct() {
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()  {
      $respuesta = Archivos::with(  $this->withAll)->where(  'estatus',  1)->get();
      return response()->json([ 'error' =>  false,  'mensaje' =>  '', 'respuesta' =>  $respuesta],  200);
  }

  public function complete()  {
      $respuesta = Archivos::with(  $this->withAll)->get();
      return response()->json([ 'error' =>  false,  'mensaje' =>  '', 'respuesta' =>  $respuesta],  200);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()  {
      
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)  {
    $validacionObj  =  Validator::make(  $request->all(),  [
      'nombre_del_archivo'  =>  'required|max:50',
      'ruta_del_archivo'  =>  'required|max:400',
      'tipo_de_archivo_id'  =>  'required|integer',
      'usuario_id'  =>  'required|integer'
    ]);

    if (  !$validacionObj->fails())  {
      try  {
        $archivoID  =  "";
        DB::transaction(  function () use(  $request,  &$archivoID)  {
          $archivo  =  new  Archivos;
          $archivo->archivo  =  $request->nombre_del_archivo;
          $archivo->ruta_del_archivo  =  $request->ruta_del_archivo;
          $archivo->tipo_de_archivo_id  =  $request->tipo_de_archivo_id;
          $archivo->usuario_id  =  $request->usuario_id;

          date_default_timezone_set("America/Mexico_City");
          $archivo->fecha_de_creacion  =  date('Y-m-d H:i:s',  strtotime('now'));
          $archivo->save();

          $archivoID  =  $archivo->id;
        });

        $respuesta  =  Archivos::with(  $this->withAll)->get();
        $respuesta[  'creado']  =  Archivos::with(  $this->withAll)->find(  $archivoID);
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
  public function show($id)  {
    $respuesta  =  Archivos::with(  $this->withAll)->find(  $id);
    return  response()->json([ 'error' =>  false,  'mensaje' =>  '', 'respuesta' =>  $respuesta],  200);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)  {

  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request,  $id)  {
    $archivo  =  Archivos::find(  $id);

    $validacionObj  =  Validator::make(  $request->all(),  [
      'nombre_del_archivo'  =>  'max:50',
      'ruta_del_archivo'  =>  'max:400',
      'tipo_de_archivo_id'  =>  'integer',
      'usuario_id'  =>  'integer'
    ]);

    if (  !$archivo)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El archivo no existe',  'respuesta'  =>  ''], 500);

    if (  !$validacionObj->fails())  {
      try  {
        DB::transaction(  function () use(  $request, &$archivo)  {
          if (  $request->nombre_del_archivo)
            $archivo->nombre_del_archivo  =  $request->nombre_del_archivo;

          if (  $request->ruta_del_archivo)
            $archivo->ruta_del_archivo  =  $request->ruta_del_archivo;
          
          if (  $request->tipo_de_archivo_id)
            $archivo->tipo_de_archivo_id  =  $request->tipo_de_archivo_id;

          if (  $request->usuario_id)
            $archivo->usuario_id  =  $request->usuario_id;

          date_default_timezone_set("America/Mexico_City");
          $archivo->fecha_de_actualizacion  =  date('Y-m-d H:i:s',  strtotime('now'));
          $archivo->save();
        });

        $respuesta  =  Archivos::with(  $this->withAll)->get();
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

  public  function  habilitar(  Request  $request,  $id)  {
    $archivo  =  Archivos::where(  'estatus',  0)->find(  $id);

    if (  !$archivo)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El archivo no existe o ya esta habilitado',  'respuesta'  =>  ''], 500);


    try  {
      $archivo->estatus  =  1;
      $archivo->save();
      $respuesta = Archivos::with(  $this->withAll)->find(  $id);
      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'El archivo se ha habilitado correctamente',
                                  'respuesta' =>  $respuesta],  200);
    }  catch  (  \Illuminate\Database\QueryException $e) {
      return  response()->json([  'error'  =>  true,
                                'mensaje' => 'Ha occurido un error en el proceso.',
                                'respuesta'  =>  $e->errorInfo[2]], 500);
    }
  }

  public  function  deshabilitar(  Request  $request,  $id)  {
    $archivo  =  Archivos::where(  'estatus',  1)->find(  $id);

    if (  !$archivo)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El archivo no existe o ya esta deshabilitado',  'respuesta'  =>  ''], 500);

    try {
      $archivo->estatus  =  0;
      $archivo->save();
      $respuesta = Archivos::with(  $this->withAll)->find(  $id);

      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'El archivo se ha deshabilitado correctamente',
                                  'respuesta' =>  $respuesta],  200);
    }  catch  (  \Illuminate\Database\QueryException $e) {
      return  response()->json([  'error'  =>  true,
                                'mensaje' => 'Ha occurido un error en el proceso.',
                                'respuesta'  =>  $e->errorInfo[2]], 500);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)  {
    $archivo  =  Archivos::find(  $id);

    if (  !$archivo)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El archivo no existe',  'respuesta'  =>  ''], 500);

    try {
      $archivo->delete();

      $respuesta = Archivos::with(  $this->withAll)->find(  $id);

      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'El archivo se ha eliminado correctamente',
                                  'respuesta' =>  $respuesta],  200);
    }  catch  (  \Illuminate\Database\QueryException $e) {
      return  response()->json([  'error'  =>  true,
                                'mensaje' => 'Ha occurido un error en el proceso.',
                                'respuesta'  =>  $e->errorInfo[2]], 500);
    }
  }
}
