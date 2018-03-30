<?php

namespace App\Http\Middleware;

use  Illuminate\Http\Response;
use Closure;

class VerificarEtatus
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)  {
    if (  $request->user()->estatus  == 1)
      return $next($request);
    else 
      return  response()->json([  'error'  =>  true,  'mensaje' => 'No estas registrado o no tienes los permisos para acceder al servicio solicitado',  'respuesta'  =>  ''], 401);
  }
}
