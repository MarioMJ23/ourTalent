<?php

namespace App\Http\Controllers;

use  Illuminate\Http\Request;
use  Illuminate\Http\Response;
use  Illuminate\Support\Fluent;
use  Illuminate\Support\Facades\Storage;
use  Illuminate\Support\Facades\Hash;
use  Illuminate\Support\Facades\DB;
use  App\User;
use  App\Tiposusuario;

use  Validator;

class TiposUsuarioController extends Controller  {
  private  $withAll  =  [];

  public  function  __construct() {}
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()  {
      $respuesta = Tiposusuario::with(  $this->withAll)->where(  'estatus',  1)->get();
      return response()->json([ 'error' =>  false,  'mensaje' =>  '', 'respuesta' =>  $respuesta],  200);
  }

  public function complete()  {
      $respuesta = Tiposusuario::with(  $this->withAll)->get();
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
        'tipo'  =>  'required|min:1|max:50'
    ]);

    if (  !$validacionObj->fails())  {
      try  {
        $tipousuarioID  =  "";
        DB::transaction(  function () use(  $request,  &$tipousuarioID)  {
          $tipousuario  =  new  Tiposusuario;

          $tipousuario->tipo  =  $request->tipo;

          date_default_timezone_set("America/Mexico_City");
          $tipousuario->fecha_de_creacion  =  date('Y-m-d H:i:s',  strtotime('now'));
          $tipousuario->save();

          $tipousuarioID  =  $tipousuario->id;
        });

        $respuesta  =  Tiposusuario::with(  $this->withAll)->get();
        $respuesta[  'creado']  =  Tiposusuario::with(  $this->withAll)->find(  $tipousuarioID);
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
    $respuesta  =  Tiposusuario::with(  $this->withAll)->find(  $id);
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
    $tipousuario  =  Tiposusuario::find(  $id);

    $validacionObj  =  Validator::make(  $request->all(),  [
      'tipo'  =>  'min:1|max:50'
    ]);

    if (  !$tipousuario)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El tipo de usuario no existe',  'respuesta'  =>  ''], 500);

    if (  !$validacionObj->fails())  {
      try  {
        DB::transaction(  function () use(  $request, &$tipousuario)  {
          if (  $request->tipo)
            $tipousuario->tipo  =  $request->tipo;

          date_default_timezone_set("America/Mexico_City");
          $tipousuario->fecha_de_actualizacion  =  date('Y-m-d H:i:s',  strtotime('now'));
          $tipousuario->save();
        });

        $respuesta  =  Tiposusuario::with(  $this->withAll)->get();
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
    $tipousuario  =  Tiposusuario::where(  'estatus',  0)->find(  $id);

    if (  !$tipousuario)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El tipo de usuario no existe o ya esta habilitado',  'respuesta'  =>  ''], 500);

    try  {
      $tipousuario->estatus  =  1;
      date_default_timezone_set("America/Mexico_City");
      $tipousuario->fecha_de_actualizacion  =  date('Y-m-d H:i:s',  strtotime('now'));
      $tipousuario->save();
      $respuesta = Tiposusuario::with(  $this->withAll)->find(  $id);
      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'El tipo de usuario se ha habilitado correctamente',
                                  'respuesta' =>  $respuesta],  200);
    }  catch  (  \Illuminate\Database\QueryException $e) {
      return  response()->json([  'error'  =>  true,
                                  'mensaje' => 'Ha occurido un error en el proceso.',
                                  'respuesta'  =>  $e->errorInfo[2]], 500);
    }
  }

  public  function  deshabilitar(  Request  $request,  $id)  {
    $tipousuario  =  Tiposusuario::where(  'estatus',  1)->find(  $id);

    if (  !$tipousuario)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El tipo de usuario no existe o ya esta deshabilitado',  'respuesta'  =>  ''], 500);

    try {
      $tipousuario->estatus  =  0;
      date_default_timezone_set("America/Mexico_City");
      $tipousuario->fecha_de_actualizacion  =  date('Y-m-d H:i:s',  strtotime('now'));
      $tipousuario->save();
      $respuesta = Tiposusuario::with(  $this->withAll)->find(  $id);

      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'El tipo de usuario se ha deshabilitado correctamente',
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
    $tipousuario  =  Tiposusuario::find(  $id);

    if (  !$tipousuario)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El tipo de usuario no existe',  'respuesta'  =>  ''], 500);

    try {
      $tipousuario->delete();

      $respuesta = Tiposusuario::with(  $this->withAll)->find(  $id);

      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'El tipo de usuario se ha eliminado correctamente',
                                  'respuesta' =>  $respuesta],  200);
    }  catch  (  \Illuminate\Database\QueryException $e) {
      return  response()->json([  'error'  =>  true,
                                'mensaje' => 'Ha occurido un error en el proceso.',
                                'respuesta'  =>  $e->errorInfo[2]], 500);
    }
  }
}
