<?php

namespace App\Http\Controllers\Auth;

use App\Jugador;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegistrarJugador extends Controller{
    public function __construct(){
        $this->middleware('guest');
    }
/*para registrar con facebook*/
    public function fb(Request $datos){
      $validacion = Validator::make($datos->all(), [
          'nombre'      => 'required',
          'correo'      => 'required|email',
      ]);
          $jugador = new Jugador;
          $jugador->nombre_ju     = $datos['nombre'];
          $jugador->correo_ju     = $datos['correo'];
          $jugador->fb_ju         = true;
          if($jugador->save())
            return (['return'=>true,'mensaje'=>'Se registro con exito']);
          else
            return (['return'=>false,'mensaje'=>'No se pudo registrar reintente']);//funciona
    }
    public function crear(Request $datos){
      $validacion = Validator::make($datos->all(), [
          'nombre'      => 'required',
          'correo'      => 'required|email',
          'contrasena'  => 'required',
      ]);
      if ($validacion->fails()) {
        return (['return'=>false,'mensaje'=>'Faltan campos']);
      }else{
        $jugador  = Jugador::where('correo_ju',$datos->correo)->get();
        if(count($jugador))
          return (['return'=>false,'mensaje'=>'El correo ya existe']);
        else{
          $jugador = new Jugador;
          $jugador->nombre_ju     = $datos['nombre'];
          $jugador->correo_ju     = $datos['correo'];
          $jugador->contrasena_ju = bcrypt($datos['contrasena']);
          if($jugador->save())
            return (['return'=>true,'mensaje'=>'Se registro con exito']);
          else
            return (['return'=>false,'mensaje'=>'No se pudo registrar reintente']);
        }
      }
    }
}
