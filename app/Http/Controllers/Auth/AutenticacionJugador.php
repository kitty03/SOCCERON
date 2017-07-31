<?php

namespace App\Http\Controllers\Auth;
use Auth;
use App\Jugador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class AutenticacionJugador extends Controller{
    use AuthenticatesUsers;
    //puedes hacer restricciones con este middleware y solo es para los que esten autentificados y los invitados
    //hace login
    //funcion para autentificar attempt : correo y passsword , estado

    public function login(Request $request){
        if(Auth::guard('jug')->attempt(['correo_ju'=>$request->correo,'password'=>$request->contrasena,'estado_ju'=>true],true))

          return (['estado'=>true,'mensaje'=>'Credenciales Correctos','vista'=>'inicio','info'=>Auth::user()]);
        else
          return (['estado'=>false,'mensaje'=>'Credenciales Incorrectos','vista'=>'login','url'=>route('login')]);
    }
    //comprobar que esta logueado
    //viaRemember recuerda x defecto al jugador asumiendo que es true
    //guard defines tu propia autentificaciones definido como jug--> config auth
    public function checklog(){
      if (Auth::viaRemember() || Auth::check())
        return (['estado'=>true,'mensaje'=>'Credenciales guardados','vista'=>'inicio','info'=>Auth::user()]);
      else
        return (['estado'=>false,'mensaje'=>'Credenciales no guardados','vista'=>'login','url'=>route('login')]);
    }
    //para logout
    public function logout(){
      Auth::guard('jug')->logout();
      return (['estado'=>false,'mensaje'=>'Sesion cerrada','vista'=>'login']);
    }

    public function fblogin(Request $request){
      $id = Jugador::where('correo_ju',$request->correo)->where('estado_ju',true)->first();
      if($id){
        $id->fb_ju  = $request->fb;
        $id->save();
        Auth::loginUsingId($id->id_ju);
        return (['estado'=>true,'mensaje'=>'Credenciales Correctos','vista'=>'inicio','info'=>Auth::user()]);
      }else{
        $jugador                =  new Jugador();
        $jugador->fb_ju         = $request->fb;
        $jugador->nombre_ju     = $request->nombre;
        $jugador->correo_ju     = $request->correo;
        $jugador->contrasena_ju = bcrypt($request->correo);
        return (['estado'=>true,'mensaje'=>'Credenciales Guardados','vista'=>'inicio','url'=>route('registerfb.submit')]);
      }
    }


    public function redirect(){
        return Socialite::driver('facebook')->redirect();
    }

    public function callback(){

        $usuario    =   Socialite::driver('facebook')->user();
        //return ([$usuario]);

        $nombre     = $usuario->name;
        $correo     = $usuario->email;
        $foto       = $usuario->avatar;


        $id = Jugador::where('correo_ju',$correo)->first();
        if($id){
            $id->fb_ju      = $foto;
            $id->estado_ju  =   true;
            $id->save();
            Auth::loginUsingId($id->id_ju);
            return (['estado'=>true,'mensaje'=>'Credenciales Correctos','vista'=>'inicio','info'=>Auth::user()]);
        }else{
            $jugador                =  new Jugador();
            $jugador->fb_ju         = $foto;
            $jugador->nombre_ju     = $nombre;
            $jugador->correo_ju     = $correo;
            $jugador->contrasena_ju = bcrypt($correo);
            $jugador->save();

            Auth::loginUsingId($jugador->id_ju);
            return (['estado'=>true,'mensaje'=>'Credenciales Guardados','vista'=>'inicio','url'=>route('registerfb.submit')]);
        }
    }
}
