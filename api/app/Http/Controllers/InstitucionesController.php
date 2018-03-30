<?php

namespace App\Http\Controllers;

use  Illuminate\Http\Request;
use  Illuminate\Http\Response;
use  Illuminate\Support\Fluent;
use  Illuminate\Support\Facades\Storage;
use  Illuminate\Support\Facades\Hash;
use  Illuminate\Support\Facades\DB;
use  App\User;
use  App\Instituciones;

use  Validator;

class InstitucionesController extends Controller  {

  private  $withAll  =  [  'tipo'];

  public  function  __construct() {}
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()  {
      $respuesta = Instituciones::with(  $this->withAll)->get();
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
        'nombre'  =>  'required|min:1|max:50',
        'nombre_corto'  =>  'required|min:1|max:25'
    ]);

    if (  !$validacionObj->fails())  {
      try  {
        $institucionID  =  "";
        DB::transaction(  function () use(  $request,  &$institucionID)  {
          $institucion  =  new  Instituciones;

          $institucion->nombre  =  $request->nombre;
          $institucion->nombre_corto  =  $request->nombre_corto;

          date_default_timezone_set("America/Mexico_City");
          $institucion->fecha_de_creacion  =  date('Y-m-d H:i:s',  strtotime('now'));
          $institucion->save();

          $institucionID  =  $institucion->id;
        });

        $respuesta  =  Instituciones::with(  $this->withAll)->get();
        $respuesta[  'creado']  =  Instituciones::with(  $this->withAll)->find(  $institucionID);
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
    $respuesta  =  Instituciones::with(  $this->withAll)->find(  $id);
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
    $institucion  =  Instituciones::find(  $id);

    $validacionObj  =  Validator::make(  $request->all(),  [
      'nombre'  =>  'min:1|max:50',
      'nombre_corto'  =>  'min:1|max:25'
    ]);

    if (  !$institucion)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'La institución no existe',  'respuesta'  =>  ''], 500);

    if (  !$validacionObj->fails())  {
      try  {
        DB::transaction(  function () use(  $request, &$institucion)  {
          if (  $request->nombre)
            $institucion->nombre  =  $request->nombre;

          if (  $request->nombre_corto)
            $institucion->nombre_corto  =  $request->nombre_corto;

          date_default_timezone_set("America/Mexico_City");
          $institucion->fecha_de_actualizacion  =  date('Y-m-d H:i:s',  strtotime('now'));
          $institucion->save();
        });

        $respuesta  =  Instituciones::with(  $this->withAll)->get();
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
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)  {
    $institucion  =  Instituciones::find(  $id);

    if (  !$institucion)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'La institución no existe',  'respuesta'  =>  ''], 500);

    try {
      $institucion->delete();

      $respuesta = Instituciones::with(  $this->withAll)->find(  $id);

      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'La institución se ha eliminado correctamente',
                                  'respuesta' =>  $respuesta],  200);
    }  catch  (  \Illuminate\Database\QueryException $e) {
      return  response()->json([  'error'  =>  true,
                                'mensaje' => 'Ha occurido un error en el proceso.',
                                'respuesta'  =>  $e->errorInfo[2]], 500);
    }
  }
}
