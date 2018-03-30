<?php

namespace App\Http\Controllers;

use  Illuminate\Http\Request;
use  Illuminate\Http\Response;
use  Illuminate\Support\Fluent;
use  Illuminate\Support\Facades\Storage;
use  Illuminate\Support\Facades\Hash;
use  Illuminate\Support\Facades\DB;
use  App\User;
use  App\Tiposinstitucion;

use  Validator;

class TiposInstitucionController extends Controller  {
  private  $withAll  =  [];

  public  function  __construct() {}
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()  {
      $respuesta = Tiposinstitucion::with(  $this->withAll)->where(  'estatus',  1)->get();
      return response()->json([ 'error' =>  false,  'mensaje' =>  '', 'respuesta' =>  $respuesta],  200);
  }

  public function complete()  {
      $respuesta = Tiposinstitucion::with(  $this->withAll)->get();
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
        'descripcion'  =>  'required|min:1'
    ]);

    if (  !$validacionObj->fails())  {
      try  {
        $tipoinstitucionID  =  "";
        DB::transaction(  function () use(  $request,  &$tipoinstitucionID)  {
          $tipoinstitucion  =  new  Tiposinstitucion;

          $tipoinstitucion->tipo  =  $request->tipo;
          $tipoinstitucion->descripcion  =  $request->descripcion;

          date_default_timezone_set("America/Mexico_City");
          $tipoinstitucion->fecha_de_creacion  =  date('Y-m-d H:i:s',  strtotime('now'));
          $tipoinstitucion->save();

          $tipoinstitucionID  =  $tipoinstitucion->id;
        });

        $respuesta  =  Tiposinstitucion::with(  $this->withAll)->get();
        $respuesta[  'creado']  =  Tiposinstitucion::with(  $this->withAll)->find(  $tipoinstitucionID);
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
    $respuesta  =  Tiposinstitucion::with(  $this->withAll)->find(  $id);
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
    $tipoinstitucion  =  Tiposinstitucion::find(  $id);

    $validacionObj  =  Validator::make(  $request->all(),  [
      'tipo'  =>  'min:1|max:50',
      'descripcion'  =>  'min:1'
    ]);

    if (  !$tipoinstitucion)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El tipo de institución no existe',  'respuesta'  =>  ''], 500);

    if (  !$validacionObj->fails())  {
      try  {
        DB::transaction(  function () use(  $request, &$tipoinstitucion)  {
          if (  $request->tipo)
            $tipoinstitucion->tipo  =  $request->tipo;

          if (  $request->descripcion)
            $tipoinstitucion->descripcion  =  $request->descripcion;

          date_default_timezone_set("America/Mexico_City");
          $tipoinstitucion->fecha_de_actualizacion  =  date('Y-m-d H:i:s',  strtotime('now'));
          $tipoinstitucion->save();
        });

        $respuesta  =  Tiposinstitucion::with(  $this->withAll)->get();
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
    $tipoinstitucion  =  Tiposinstitucion::where(  'estatus',  0)->find(  $id);

    if (  !$tipoinstitucion)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El tipo de institución no existe o ya esta habilitado',  'respuesta'  =>  ''], 500);

    try  {
      $tipoinstitucion->estatus  =  1;

      date_default_timezone_set("America/Mexico_City");
      $tipoinstitucion->fecha_de_actualizacion  =  date('Y-m-d H:i:s',  strtotime('now'));
      $tipoinstitucion->save();
      $respuesta = Tiposinstitucion::with(  $this->withAll)->find(  $id);
      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'El tipo de institución se ha habilitado correctamente',
                                  'respuesta' =>  $respuesta],  200);
    }  catch  (  \Illuminate\Database\QueryException $e) {
      return  response()->json([  'error'  =>  true,
                                  'mensaje' => 'Ha occurido un error en el proceso.',
                                  'respuesta'  =>  $e->errorInfo[2]], 500);
    }
  }

  public  function  deshabilitar(  Request  $request,  $id)  {
    $tipoinstitucion  =  Tiposinstitucion::where(  'estatus',  1)->find(  $id);

    if (  !$tipoinstitucion)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El tipo de institución no existe o ya esta deshabilitado',  'respuesta'  =>  ''], 500);

    try {
      $tipoinstitucion->estatus  =  0;

      date_default_timezone_set("America/Mexico_City");
      $tipoinstitucion->fecha_de_actualizacion  =  date('Y-m-d H:i:s',  strtotime('now'));
      $tipoinstitucion->save();
      $respuesta = Tiposinstitucion::with(  $this->withAll)->find(  $id);

      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'El tipo de institución se ha deshabilitado correctamente',
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
    $tipoinstitucion  =  Tiposinstitucion::find(  $id);

    if (  !$tipoinstitucion)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El tipo de institución no existe',  'respuesta'  =>  ''], 500);

    try {
      $tipoinstitucion->delete();

      $respuesta = Tiposinstitucion::with(  $this->withAll)->find(  $id);

      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'El tipo de institución se ha eliminado correctamente',
                                  'respuesta' =>  $respuesta],  200);
    }  catch  (  \Illuminate\Database\QueryException $e) {
      return  response()->json([  'error'  =>  true,
                                'mensaje' => 'Ha occurido un error en el proceso.',
                                'respuesta'  =>  $e->errorInfo[2]], 500);
    }
  }
}
