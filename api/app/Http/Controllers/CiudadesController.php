<?php

namespace App\Http\Controllers;

use  Illuminate\Http\Request;
use  Illuminate\Http\Response;
use  Illuminate\Support\Fluent;
use  Illuminate\Support\Facades\Storage;
use  Illuminate\Support\Facades\Hash;
use  Illuminate\Support\Facades\DB;
use  App\User;
use  App\Ciudades;

use  Validator;

class CiudadesController extends Controller  {

  private  $withAll  =  [  'estado'];

  public  function  __construct() {
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()  {
    ini_set('memory_limit', '-1');
    $respuesta = Ciudades::with(  $this->withAll)->where(  'estatus',  1)->get();
    return response()->json([ 'error' =>  false,  'mensaje' =>  '', 'respuesta' =>  $respuesta],  200);
  }


  public function complete()  {
    ini_set('memory_limit', '-1');
    $respuesta = Ciudades::with(  $this->withAll)->get();
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
      'ciudad'  =>  'required|min:1|max:50',
      'codigo'  =>  'required|min:1|max:10',
      'estado_id'  =>  'required|integer'
    ]);

    if (  !$validacionObj->fails())  {
      try  {
        $ciudadID  =  "";
        DB::transaction(  function () use(  $request,  &$ciudadID)  {
          $ciudad  =  new  Ciudades;
          
          $ciudad->ciudad  =  $request->ciudad;
          $ciudad->codigo  =  $request->codigo;
          $ciudad->estado_id  = $request->estado_id;

          $ciudad->save();

          $ciudadID  =  $ciudad->id;
        });

        $respuesta  =  Ciudades::with(  $this->withAll)->get();
        $respuesta[  'creado']  =  Ciudades::with(  $this->withAll)->find(  $ciudadID);
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
    $respuesta  =  Ciudades::with(  $this->withAll)->find(  $id);
    return  response()->json([ 'error' =>  false,  'mensaje' =>  '', 'respuesta' =>  $respuesta],  200);
  }

  public function showEstadoID($estado_id)  {
    $respuesta  =  Ciudades::with(  $this->withAll)->where(  'estado_id',  $estado_id)->get();
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
    $ciudad  =  Ciudades::find(  $id);

    $validacionObj  =  Validator::make(  $request->all(),  [
      'ciudad'  =>  'min:1|max:50',
      'codigo'  =>  'min:1|max:10',
      'estado_id'  =>  'integer'
    ]);

    if (  !$ciudad)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'La ciudad no existe',  'respuesta'  =>  ''], 500);

    if (  !$validacionObj->fails())  {
      try  {
        DB::transaction(  function () use(  $request, &$ciudad)  {
          if (  $request->ciudad)
            $ciudad->ciudad  =  $request->ciudad;

          if (  $request->codigo)
            $ciudad->codigo  =  $request->codigo;
          
          if (  $request->estado_id)
            $ciudad->estado_id  =  $request->estado_id;

          $ciudad->save();
        });

        $respuesta  =  Ciudades::with(  $this->withAll)->get();
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
    $ciudad  =  Ciudades::where(  'estatus',  0)->find(  $id);

    if (  !$ciudad)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'La ciudad no existe o ya esta habilitado',  'respuesta'  =>  ''], 500);

    try  {
      $ciudad->estatus  =  1;
      $ciudad->save();
      $respuesta = Ciudades::with(  $this->withAll)->find(  $id);
      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'La ciudad se ha habilitado correctamente',
                                  'respuesta' =>  $respuesta],  200);
    }  catch  (  \Illuminate\Database\QueryException $e) {
      return  response()->json([  'error'  =>  true,
                                  'mensaje' => 'Ha occurido un error en el proceso.',
                                  'respuesta'  =>  $e->errorInfo[2]], 500);
    }
  }

  public  function  deshabilitar(  Request  $request,  $id)  {
    $ciudad  =  Ciudades::where(  'estatus',  1)->find(  $id);

    if (  !$ciudad)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'La ciudad no existe o ya esta deshabilitado',  'respuesta'  =>  ''], 500);

    try {
      $ciudad->estatus  =  0;
      $ciudad->save();
      $respuesta = Ciudades::with(  $this->withAll)->find(  $id);

      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'La ciudad se ha deshabilitado correctamente',
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
    $ciudad  =  Ciudades::find(  $id);

    if (  !$ciudad)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'La ciudad no existe',  'respuesta'  =>  ''], 500);

    try {
      $ciudad->delete();

      $respuesta = Ciudades::with(  $this->withAll)->find(  $id);

      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'La ciudad se ha eliminado correctamente',
                                  'respuesta' =>  $respuesta],  200);
    }  catch  (  \Illuminate\Database\QueryException $e) {
      return  response()->json([  'error'  =>  true,
                                'mensaje' => 'Ha occurido un error en el proceso.',
                                'respuesta'  =>  $e->errorInfo[2]], 500);
    }
  }
}
