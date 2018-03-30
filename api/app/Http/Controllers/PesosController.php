<?php

namespace App\Http\Controllers;

use  Illuminate\Http\Request;
use  Illuminate\Http\Response;
use  Illuminate\Support\Fluent;
use  Illuminate\Support\Facades\Storage;
use  Illuminate\Support\Facades\Hash;
use  Illuminate\Support\Facades\DB;
use  App\User;
use  App\Pesos;

use  Validator;


class PesosController extends Controller  {

  private  $withAll  =  [];

  public  function  __construct() {}
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()  {
    $respuesta = Pesos::with(  $this->withAll)->get();
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
      'peso'  =>  'required|numeric',
      'peso_en'  =>  'required|numeric',
      'usuario_id'  =>  'required|integer'
    ]);


    if (  !$validacionObj->fails())  {
      if (  ($request->peso  *  2.205)  !=  $request->peso_en)
        return  response()->json([  'error'  =>  true,  'mensaje' => 'Los patametros estan errones, pesos no equivalentes 1 KG = 2.205 lb',  'respuesta'  =>  ''], 400);
      try  {
        $pesoID  =  "";
        DB::transaction(  function () use(  $request,  &$pesoID)  {
          $peso  =  new  Pesos;
          
          $peso->peso  =  $request->peso;
          $peso->peso_en  =  $request->peso_en;
          $peso->usuario_id  =  $request->usuario_id;

          $peso->save();

          $pesoID  =  $peso->id;
        });

        $respuesta  =  Pesos::with(  $this->withAll)->get();
        $respuesta[  'creado']  =  Pesos::with(  $this->withAll)->find(  $pesoID);
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
    $respuesta  =  Pesos::with(  $this->withAll)->find(  $id);
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
    $peso  =  Pesos::find(  $id);

    $validacionObj  =  Validator::make(  $request->all(),  [
      'peso'  =>  'required|numeric',
      'peso_en'  =>  'required|numeric',
      'usuario_id'  =>  'integer'
    ]);

    if (  !$peso)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'La medida de peso no existe',  'respuesta'  =>  ''], 500);

    if (  !$validacionObj->fails())  {
      if (  ($request->peso  *  2.205)  !=  $request->peso_en)
        return  response()->json([  'error'  =>  true,  'mensaje' => 'Los patametros estan errones, pesos no equivalentes 1 KG = 2.205 lb',  'respuesta'  =>  ''], 400);

      try  {
        DB::transaction(  function () use(  $request, &$peso)  {
          if (  $request->peso)
            $peso->pais  =  $request->pais;

          if (  $request->peso_en)
            $peso->peso_en  =  $request->peso_en;

          if  (  $request->usuario_id)
            $peso->usuario_id  =  $request->usuario_id;

          $peso->save();
        });

        $respuesta  =  Pesos::with(  $this->withAll)->get();
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
    $peso  =  Pesos::find(  $id);

    if (  !$peso)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'La medida de peso no existe',  'respuesta'  =>  ''], 500);

    try {
      $peso->delete();

      $respuesta = Pesos::with(  $this->withAll)->find(  $id);

      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'La medida de peso se ha eliminado correctamente',
                                  'respuesta' =>  $respuesta],  200);
    }  catch  (  \Illuminate\Database\QueryException $e) {
      return  response()->json([  'error'  =>  true,
                                'mensaje' => 'Ha occurido un error en el proceso.',
                                'respuesta'  =>  $e->errorInfo[2]], 500);
    }
  }
}
