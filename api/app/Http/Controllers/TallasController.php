<?php

namespace App\Http\Controllers;

use  Illuminate\Http\Request;
use  Illuminate\Http\Response;
use  Illuminate\Support\Fluent;
use  Illuminate\Support\Facades\Storage;
use  Illuminate\Support\Facades\Hash;
use  Illuminate\Support\Facades\DB;
use  App\User;
use  App\Tallas;

use  Validator;

class TallasController extends Controller  {
    private  $withAll  =  [];

  public  function  __construct() {}
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()  {
    $respuesta = Tallas::with(  $this->withAll)->get();
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
      'talla'  =>  'required|numeric',
      'talla_en'  =>  'required|numeric',
      'usuario_id'  =>  'required|integer'
    ]);


    if (  !$validacionObj->fails())  {
      if (  ($request->talla  *  3.28084)  !=  $request->talla_en)
        return  response()->json([  'error'  =>  true,  'mensaje' => 'Los patametros estan errones, tallas no equivalentes 1 M = 3.28084 ft',  'respuesta'  =>  ''], 400);

      try  {
        $tallaID  =  "";
        DB::transaction(  function () use(  $request,  &$tallaID)  {
          $talla  =  new  Tallas;

          $talla->talla  =  $request->talla;
          $talla->talla_en  =  $request->talla_en;
          $talla->usuario_id  =  $request->usuario_id;

          date_default_timezone_set("America/Mexico_City");
          $talla->fecha_de_creacion  =  date('Y-m-d H:i:s',  strtotime('now'));
          $talla->save();

          $tallaID  =  $talla->id;
        });

        $respuesta  =  Tallas::with(  $this->withAll)->get();
        $respuesta[  'creado']  =  Tallas::with(  $this->withAll)->find(  $tallaID);
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
    $respuesta  =  Tallas::with(  $this->withAll)->find(  $id);
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
    $talla  =  Tallas::find(  $id);

    $validacionObj  =  Validator::make(  $request->all(),  [
      'talla'  =>  'required|numeric',
      'talla_en'  =>  'required|numeric',
      'usuario_id'  =>  'integer'
    ]);

    if (  !$talla)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'La medida de talla no existe',  'respuesta'  =>  ''], 500);

    if (  !$validacionObj->fails())  {
      if (  ($request->talla  *  3.28084)  !=  $request->talla_en)
        return  response()->json([  'error'  =>  true,  'mensaje' => 'Los patametros estan errones, tallas no equivalentes 1 M = 3.28084 ft',  'respuesta'  =>  ''], 400);

      try  {
        DB::transaction(  function () use(  $request, &$talla)  {
          if (  $request->talla)
            $talla->pais  =  $request->pais;

          if (  $request->talla_en)
            $talla->talla_en  =  $request->talla_en;

          if  (  $request->usuario_id)
            $talla->usuario_id  =  $request->usuario_id;

          date_default_timezone_set("America/Mexico_City");
          $talla->fecha_de_actualizacion  =  date('Y-m-d H:i:s',  strtotime('now'));
          $talla->save();
        });

        $respuesta  =  Tallas::with(  $this->withAll)->get();
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
    $talla  =  Tallas::find(  $id);

    if (  !$talla)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'La medida de talla no existe',  'respuesta'  =>  ''], 500);

    try {
      $talla->delete();

      $respuesta = Tallas::with(  $this->withAll)->find(  $id);

      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'La medida de talla se ha eliminado correctamente',
                                  'respuesta' =>  $respuesta],  200);
    }  catch  (  \Illuminate\Database\QueryException $e) {
      return  response()->json([  'error'  =>  true,
                                  'mensaje' => 'Ha occurido un error en el proceso.',
                                  'respuesta'  =>  $e->errorInfo[2]], 500);
    }
  }
}
