<?php

namespace App\Http\Controllers;

use  Illuminate\Http\Request;
use  Illuminate\Http\Response;
use  Illuminate\Support\Fluent;
use  Illuminate\Support\Facades\Storage;
use  Illuminate\Support\Facades\Hash;
use  Illuminate\Support\Facades\DB;
use  App\User;
use  App\Actividades;
use  App\Usuarioactividad;
use  Validator;

class ActividadesController extends Controller  {

  private  $withAll  =  [  'tipo'];

  public  function  __construct() {
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()  {
      $respuesta = Actividades::with(  $this->withAll)->where(  'estatus',  1)->get();
      return response()->json([ 'error' =>  false,  'mensaje' =>  '', 'respuesta' =>  $respuesta],  200);
  }


  public function complete()  {
      $respuesta = Actividades::with(  $this->withAll)->get();
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
      'actividad'  =>  'required|max:30|min:1',
      'logo'  =>  'required|max:50|min:1',
      'tipo_de_actividad_id'  =>  'required|integer'
    ]);

    if (  !$validacionObj->fails())  {
      try  {
        $actividadID  =  "";
        DB::transaction(  function () use(  $request,  &$actividadID)  {
          $actividad  =  new  Actividades;
          $actividad->actividad  =  $request->actividad;
          $actividad->logo  =  $request->logo;
          $actividad->tipo_de_actividad_id  =  $request->tipo_de_actividad_id;

          $actividad->save();

          $actividadID  =  $actividad->id;
        });

        $respuesta  =  Actividades::with(  $this->withAll)->get();
        $respuesta[  'creado']  =  Actividades::with(  $this->withAll)->find(  $actividadID);
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
    $respuesta  =  Actividades::with(  $this->withAll)->find(  $id);
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
    $actividad  =  Actividades::find(  $id);

    $validacionObj  =  Validator::make(  $request->all(),  [
      'actividad'  =>  'max:30|min:1',
      'logo'  =>  'max:50|min:1',
      'tipo_de_actividad_id'  =>  'integer'
    ]);

    if (  !$actividad)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'La actividad no existe',  'respuesta'  =>  ''], 500);

    if (  !$validacionObj->fails())  {
      try  {
        DB::transaction(  function () use(  $request, &$actividad)  {
          if (  $request->actividad)
            $actividad->actividad  =  $request->actividad;

          if (  $request->logo)
            $actividad->logo  =  $request->logo;

          if (  $request->tipo_de_actividad_id)
            $actividad->tipo_de_actividad_id  =  $request->tipo_de_actividad_id;

          $actividad->save();
        });

        $respuesta  =  Actividades::with(  $this->withAll)->get();
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
    $actividad  =  Actividades::where(  'estatus',  0)->find(  $id);

    if (  !$actividad)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'La actividad no existe o ya esta habilitada',  'respuesta'  =>  ''], 500);


    try  {
      $actividad->estatus  =  1;
      $actividad->save();
      $respuesta = Actividades::with(  $this->withAll)->find(  $id);
      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'La actividad se ha habilitada correctamente',
                                  'respuesta' =>  $respuesta],  200);
    }  catch  (  \Illuminate\Database\QueryException $e) {
      return  response()->json([  'error'  =>  true,
                                'mensaje' => 'Ha occurido un error en el proceso.',
                                'respuesta'  =>  $e->errorInfo[2]], 500);
    }
  }

  public  function  deshabilitar(  Request  $request,  $id)  {
    $actividad  =  Actividades::where(  'estatus',  1)->find(  $id);

    if (  !$actividad)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'La actividad no existe o ya esta deshabilitada',  'respuesta'  =>  ''], 500);

    try {
      $actividad->estatus  =  0;
      $actividad->save();
      $respuesta = Actividades::with(  $this->withAll)->find(  $id);

      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'La actividad se ha deshabilitada correctamente',
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
    $actividad  =  Actividades::find(  $id);

    if (  !$actividad)
      return  response()->json([  'error'  =>  true,  'mensaje' => 'La actividad no existe',  'respuesta'  =>  ''], 500);
    try {
      $actividad->delete();

      $respuesta = Actividades::with(  $this->withAll)->find(  $id);

      return  response()->json([  'error' =>  false,
                                  'mensaje' =>  'La actividad se ha deshabilitada correctamente',
                                  'respuesta' =>  $respuesta],  200);
    }  catch  (  \Illuminate\Database\QueryException $e) {
      return  response()->json([  'error'  =>  true,
                                'mensaje' => 'Ha occurido un error en el proceso.',
                                'respuesta'  =>  $e->errorInfo[2]], 500);
    }
  }
}
