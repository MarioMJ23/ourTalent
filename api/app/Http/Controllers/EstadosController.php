<?php

namespace App\Http\Controllers;

use  Illuminate\Http\Request;
use  Illuminate\Http\Response;
use  Illuminate\Support\Fluent;
use  Illuminate\Support\Facades\Storage;
use  Illuminate\Support\Facades\Hash;
use  Illuminate\Support\Facades\DB;
use  App\User;
use  App\Estados;

use  Validator;

class EstadosController extends Controller  {

  private  $withAll  =  [  'pais'];

  public  function  __construct() {}
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()  {
    ini_set('memory_limit', '-1');
    $respuesta = Estados::with(  $this->withAll)->where(  'estatus',  1)->get();
    return response()->json([ 'error' =>  false,  'mensaje' =>  '', 'respuesta' =>  $respuesta],  200);
  }


  public function complete()  {
    ini_set('memory_limit', '-1');
    $respuesta = Estados::with(  $this->withAll)->get();
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
      'estado'  =>  'required|min:1|max:50',
      'codigo'  =>  'required|min:1|max:10',
      'pais_id'  =>  'required|integer'
    ]);

    if (  !$validacionObj->fails())  {
      try  {
        $estadoID  =  "";
        DB::transaction(  function () use(  $request,  &$estadoID)  {
          $estado  =  new  estadoes;
          
          $estado->estado  =  $request->estado;
          $estado->codigo  =  $request->codigo;
          $estado->pais_id  = $request->pais_id;

          $estado->save();

          $estadoID  =  $estado->id;
        });

        $respuesta  =  Estados::with(  $this->withAll)->get();
        $respuesta[  'creado']  =  Estados::with(  $this->withAll)->find(  $estadoID);
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
    $respuesta  =  Estados::with(  $this->withAll)->find(  $id);
    return  response()->json([ 'error' =>  false,  'mensaje' =>  '', 'respuesta' =>  $respuesta],  200);
  }

  public function showPaisID($pais_id)  {
    $respuesta  =  Estados::with(  $this->withAll)->where(  'pais_id',  $pais_id)->get();
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
    $estado  =  Estados::find(  $id);

    $validacionObj  =  Validator::make(  $request->all(),  [
      'estado'  =>  'min:1|max:50',
      'codigo'  =>  'min:1|max:10',
      'pais_id'  =>  'integer'
    ]);

    if (  !$estado)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El estado no existe',  'respuesta'  =>  ''], 500);

    if (  !$validacionObj->fails())  {
      try  {
        DB::transaction(  function () use(  $request, &$estado)  {
          if (  $request->estado)
            $estado->estado  =  $request->estado;

          if (  $request->codigo)
            $estado->codigo  =  $request->codigo;
          
          if (  $request->pais_id)
            $estado->pais_id  =  $request->pais_id;

          $estado->save();
        });

        $respuesta  =  Estados::with(  $this->withAll)->get();
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
    $estado  =  Estados::where(  'estatus',  0)->find(  $id);

    if (  !$estado)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El estado no existe o ya esta habilitado',  'respuesta'  =>  ''], 500);

    try  {
      $estado->estatus  =  1;
      $estado->save();
      $respuesta = Estados::with(  $this->withAll)->find(  $id);
      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'El estado se ha habilitado correctamente',
                                  'respuesta' =>  $respuesta],  200);
    }  catch  (  \Illuminate\Database\QueryException $e) {
      return  response()->json([  'error'  =>  true,
                                  'mensaje' => 'Ha occurido un error en el proceso.',
                                  'respuesta'  =>  $e->errorInfo[2]], 500);
    }
  }

  public  function  deshabilitar(  Request  $request,  $id)  {
    $estado  =  Estados::where(  'estatus',  1)->find(  $id);

    if (  !$estado)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El estado no existe o ya esta deshabilitado',  'respuesta'  =>  ''], 500);

    try {
      $estado->estatus  =  0;
      $estado->save();
      $respuesta = Estados::with(  $this->withAll)->find(  $id);

      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'El estado se ha deshabilitado correctamente',
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
    $estado  =  Estados::find(  $id);

    if (  !$estado)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'El estado no existe',  'respuesta'  =>  ''], 500);

    try {
      $estado->delete();

      $respuesta = Estados::with(  $this->withAll)->find(  $id);

      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'El estado se ha eliminado correctamente',
                                  'respuesta' =>  $respuesta],  200);
    }  catch  (  \Illuminate\Database\QueryException $e) {
      return  response()->json([  'error'  =>  true,
                                'mensaje' => 'Ha occurido un error en el proceso.',
                                'respuesta'  =>  $e->errorInfo[2]], 500);
    }
  }
}
