<?php

namespace App\Http\Controllers;

use  Illuminate\Http\Request;
use  Illuminate\Http\Response;
use  Illuminate\Support\Fluent;
use  Illuminate\Support\Facades\Storage;
use  Illuminate\Support\Facades\Hash;
use  Illuminate\Support\Facades\DB;
use  App\User;
use  App\Tiposarchivo;

use  Validator;

class TiposArchivoController extends Controller  {
  private  $withAll  =  [];

  public  function  __construct() {}
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()  {
      $respuesta = Tiposarchivo::with(  $this->withAll)->where(  'estatus',  1)->get();
      return response()->json([ 'error' =>  false,  'mensaje' =>  '', 'respuesta' =>  $respuesta],  200);
  }

  public function complete()  {
      $respuesta = Tiposarchivo::with(  $this->withAll)->get();
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
        $tipoarchivoID  =  "";
        DB::transaction(  function () use(  $request,  &$tipoarchivoID)  {
          $tipoarchivo  =  new  Tiposarchivo;

          $tipoarchivo->tipo  =  $request->tipo;

          $tipoarchivo->save();

          $tipoarchivoID  =  $tipoarchivo->id;
        });

        $respuesta  =  Tiposarchivo::with(  $this->withAll)->get();
        $respuesta[  'creado']  =  Tiposarchivo::with(  $this->withAll)->find(  $tipoarchivoID);
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
    $respuesta  =  Tiposarchivo::with(  $this->withAll)->find(  $id);
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
    $tipoarchivo  =  Tiposarchivo::find(  $id);

    $validacionObj  =  Validator::make(  $request->all(),  [
      'tipo'  =>  'min:1|max:50',
    ]);

    if (  !$tipoarchivo)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El tipo de archivo no existe',  'respuesta'  =>  ''], 500);

    if (  !$validacionObj->fails())  {
      try  {
        DB::transaction(  function () use(  $request, &$tipoarchivo)  {
          if (  $request->tipo)
            $tipoarchivo->tipo  =  $request->tipo;

          $tipoarchivo->save();
        });

        $respuesta  =  Tiposarchivo::with(  $this->withAll)->get();
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
    $tipoarchivo  =  Tiposarchivo::where(  'estatus',  0)->find(  $id);

    if (  !$tipoarchivo)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El tipo de archivo no existe o ya esta habilitado',  'respuesta'  =>  ''], 500);

    try  {
      $tipoarchivo->estatus  =  1;
      $tipoarchivo->save();
      $respuesta = Tiposarchivo::with(  $this->withAll)->find(  $id);
      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'El tipo de archivo se ha habilitado correctamente',
                                  'respuesta' =>  $respuesta],  200);
    }  catch  (  \Illuminate\Database\QueryException $e) {
      return  response()->json([  'error'  =>  true,
                                  'mensaje' => 'Ha occurido un error en el proceso.',
                                  'respuesta'  =>  $e->errorInfo[2]], 500);
    }
  }

  public  function  deshabilitar(  Request  $request,  $id)  {
    $tipoarchivo  =  Tiposarchivo::where(  'estatus',  1)->find(  $id);

    if (  !$tipoarchivo)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El tipo de archivo no existe o ya esta deshabilitado',  'respuesta'  =>  ''], 500);

    try {
      $tipoarchivo->estatus  =  0;
      $tipoarchivo->save();
      $respuesta = Tiposarchivo::with(  $this->withAll)->find(  $id);

      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'El tipo de archivo se ha deshabilitado correctamente',
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
    $tipoarchivo  =  Tiposarchivo::find(  $id);

    if (  !$tipoarchivo)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El tipo de archivo no existe',  'respuesta'  =>  ''], 500);

    try {
      $tipoarchivo->delete();

      $respuesta = Tiposarchivo::with(  $this->withAll)->find(  $id);

      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'El tipo de archivo se ha eliminado correctamente',
                                  'respuesta' =>  $respuesta],  200);
    }  catch  (  \Illuminate\Database\QueryException $e) {
      return  response()->json([  'error'  =>  true,
                                'mensaje' => 'Ha occurido un error en el proceso.',
                                'respuesta'  =>  $e->errorInfo[2]], 500);
    }
  }
}
