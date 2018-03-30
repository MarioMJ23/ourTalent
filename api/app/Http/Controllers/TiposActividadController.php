<?php

namespace App\Http\Controllers;

use  Illuminate\Http\Request;
use  Illuminate\Http\Response;
use  Illuminate\Support\Fluent;
use  Illuminate\Support\Facades\Storage;
use  Illuminate\Support\Facades\Hash;
use  Illuminate\Support\Facades\DB;
use  App\User;
use  App\Tiposactividad;

use  Validator;

class TiposActividadController extends Controller  {
  private  $withAll  =  [];

  public  function  __construct() {}
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()  {
      $respuesta = Tiposactividad::with(  $this->withAll)->where(  'estatus',  1)->get();
      return response()->json([ 'error' =>  false,  'mensaje' =>  '', 'respuesta' =>  $respuesta],  200);
  }

  public function complete()  {
      $respuesta = Tiposactividad::with(  $this->withAll)->get();
      return response()->json([ 'error' =>  false,  'mensaje' =>  '', 'respuesta' =>  $respuesta],  200);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()  {}

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)  {
    $validacionObj  =  Validator::make(  $request->all(),  [
        'tipo'  =>  'required|min:1|max:50',
    ]);

    if (  !$validacionObj->fails())  {
      try  {
        $tipoactividadID  =  "";
        DB::transaction(  function () use(  $request,  &$tipoactividadID)  {
          $tipoactividad  =  new  Tiposactividad;

          $tipoactividad->tipo  =  $request->tipo;

          date_default_timezone_set("America/Mexico_City");
          $tipoactividad->fecha_de_creacion  =  date('Y-m-d H:i:s',  strtotime('now'));
          $tipoactividad->save();

          $tipoactividadID  =  $tipoactividad->id;
        });

        $respuesta  =  Tiposactividad::with(  $this->withAll)->get();
        $respuesta[  'creado']  =  Tiposactividad::with(  $this->withAll)->find(  $tipoactividadID);
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
    $respuesta  =  Tiposactividad::with(  $this->withAll)->find(  $id);
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
    $tipoactividad  =  Tiposactividad::find(  $id);

    $validacionObj  =  Validator::make(  $request->all(),  [
      'tipo'  =>  'min:1|max:50',
    ]);

    if (  !$tipoactividad)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El tipo de actividad no existe',  'respuesta'  =>  ''], 500);

    if (  !$validacionObj->fails())  {
      try  {
        DB::transaction(  function () use(  $request, &$tipoactividad)  {
          if (  $request->tipo)
            $tipoactividad->tipo  =  $request->tipo;

          date_default_timezone_set("America/Mexico_City");
          $tipoactividad->fecha_de_actualizacion  =  date('Y-m-d H:i:s',  strtotime('now'));
          $tipoactividad->save();
        });

        $respuesta  =  Tiposactividad::with(  $this->withAll)->get();
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
    $tipoactividad  =  Tiposactividad::where(  'estatus',  0)->find(  $id);

    if (  !$tipoactividad)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El tipo de actividad no existe o ya esta habilitado',  'respuesta'  =>  ''], 500);

    try  {
      $tipoactividad->estatus  =  1;

      date_default_timezone_set("America/Mexico_City");
      $tipoactividad->fecha_de_actualizacion  =  date('Y-m-d H:i:s',  strtotime('now'));
      $tipoactividad->save();
      $respuesta = Tiposactividad::with(  $this->withAll)->find(  $id);
      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'El tipo de actividad se ha habilitado correctamente',
                                  'respuesta' =>  $respuesta],  200);
    }  catch  (  \Illuminate\Database\QueryException $e) {
      return  response()->json([  'error'  =>  true,
                                  'mensaje' => 'Ha occurido un error en el proceso.',
                                  'respuesta'  =>  $e->errorInfo[2]], 500);
    }
  }

  public  function  deshabilitar(  Request  $request,  $id)  {
    $tipoactividad  =  Tiposactividad::where(  'estatus',  1)->find(  $id);

    if (  !$tipoactividad)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El tipo de actividad no existe o ya esta deshabilitado',  'respuesta'  =>  ''], 500);

    try {
      $tipoactividad->estatus  =  0;

      date_default_timezone_set("America/Mexico_City");
      $tipoactividad->fecha_de_actualizacion  =  date('Y-m-d H:i:s',  strtotime('now'));
      $tipoactividad->save();
      $respuesta = Tiposactividad::with(  $this->withAll)->find(  $id);

      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'El tipo de actividad se ha deshabilitado correctamente',
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
    $tipoactividad  =  Tiposactividad::find(  $id);

    if (  !$tipoactividad)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El tipo de actividad no existe',  'respuesta'  =>  ''], 500);

    try {
      $tipoactividad->delete();

      $respuesta = Tiposactividad::with(  $this->withAll)->find(  $id);

      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'El tipo de actividad se ha eliminado correctamente',
                                  'respuesta' =>  $respuesta],  200);
    }  catch  (  \Illuminate\Database\QueryException $e) {
      return  response()->json([  'error'  =>  true,
                                'mensaje' => 'Ha occurido un error en el proceso.',
                                'respuesta'  =>  $e->errorInfo[2]], 500);
    }
  }
}