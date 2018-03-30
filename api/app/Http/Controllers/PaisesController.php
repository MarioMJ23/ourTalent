<?php

namespace App\Http\Controllers;

use  Illuminate\Http\Request;
use  Illuminate\Http\Response;
use  Illuminate\Support\Fluent;
use  Illuminate\Support\Facades\Storage;
use  Illuminate\Support\Facades\Hash;
use  Illuminate\Support\Facades\DB;
use  App\User;
use  App\Paises;

use  Validator;


class PaisesController extends Controller  {

  private  $withAll  =  [];

  public  function  __construct() {}
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()  {
    ini_set('memory_limit', '-1');
    $respuesta = Paises::with(  $this->withAll)->where(  'estatus',  1)->get();
    return response()->json([ 'error' =>  false,  'mensaje' =>  '', 'respuesta' =>  $respuesta],  200);
  }


  public function complete()  {
    ini_set('memory_limit', '-1');
    $respuesta = Paises::with(  $this->withAll)->get();
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
      'pais'  =>  'required|min:1|max:50',
      'codigo'  =>  'required|min:1|max:10'
    ]);

    if (  !$validacionObj->fails())  {
      try  {
        $paisID  =  "";
        DB::transaction(  function () use(  $request,  &$paisID)  {
          $pais  =  new  Paises;
          
          $pais->pais  =  $request->pais;
          $pais->codigo  =  $request->codigo;

          $pais->save();

          $paisID  =  $pais->id;
        });

        $respuesta  =  Paises::with(  $this->withAll)->get();
        $respuesta[  'creado']  =  Paises::with(  $this->withAll)->find(  $paisID);
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
    $respuesta  =  Paises::with(  $this->withAll)->find(  $id);
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
    $pais  =  Paises::find(  $id);

    $validacionObj  =  Validator::make(  $request->all(),  [
      'pais'  =>  'min:1|max:50',
      'codigo'  =>  'min:1|max:10'
    ]);

    if (  !$pais)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El país no existe',  'respuesta'  =>  ''], 500);

    if (  !$validacionObj->fails())  {
      try  {
        DB::transaction(  function () use(  $request, &$pais)  {
          if (  $request->pais)
            $pais->pais  =  $request->pais;

          if (  $request->codigo)
            $pais->codigo  =  $request->codigo;
         

          $pais->save();
        });

        $respuesta  =  Paises::with(  $this->withAll)->get();
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
    $pais  =  Paises::where(  'estatus',  0)->find(  $id);

    if (  !$pais)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El país no existe o ya esta habilitado',  'respuesta'  =>  ''], 500);

    try  {
      $pais->estatus  =  1;
      $pais->save();
      $respuesta = Paises::with(  $this->withAll)->find(  $id);
      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'El país se ha habilitado correctamente',
                                  'respuesta' =>  $respuesta],  200);
    }  catch  (  \Illuminate\Database\QueryException $e) {
      return  response()->json([  'error'  =>  true,
                                  'mensaje' => 'Ha occurido un error en el proceso.',
                                  'respuesta'  =>  $e->errorInfo[2]], 500);
    }
  }

  public  function  deshabilitar(  Request  $request,  $id)  {
    $pais  =  Paises::where(  'estatus',  1)->find(  $id);

    if (  !$pais)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El país no existe o ya esta deshabilitado',  'respuesta'  =>  ''], 500);

    try {
      $pais->estatus  =  0;
      $pais->save();
      $respuesta = Paises::with(  $this->withAll)->find(  $id);

      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'El país se ha deshabilitado correctamente',
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
    $pais  =  Paises::find(  $id);

    if (  !$pais)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El país no existe',  'respuesta'  =>  ''], 500);

    try {
      $pais->delete();

      $respuesta = Paises::with(  $this->withAll)->find(  $id);

      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'El país se ha eliminado correctamente',
                                  'respuesta' =>  $respuesta],  200);
    }  catch  (  \Illuminate\Database\QueryException $e) {
      return  response()->json([  'error'  =>  true,
                                'mensaje' => 'Ha occurido un error en el proceso.',
                                'respuesta'  =>  $e->errorInfo[2]], 500);
    }
  }
}
