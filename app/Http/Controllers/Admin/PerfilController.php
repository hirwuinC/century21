<?php

namespace App\Http\Controllers\Admin;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\Agente;
use App\Models\User;
use App\Models\Role;
use App\Models\Imagen;

use Illuminate\Support\Facades\DB;

class PerfilController extends Controller{

  public function Perfil(){
    $password=Session::get('pass');
    $usuario=Session::get('asesor');
    $asesor=Agente::where('id',$usuario->agente_id)->first();
    $avatar=Imagen::where('id',$asesor->imagen_id)->first();
    $roles=Role::all();
    //dd($usuario);
    $respuesta=0;
    return view('/admin/perfil',$this->cargarSidebar(),compact('password','asesor','roles','avatar','usuario'));
  }

  public function actualizarPerfil(){
    $file = Request::file('image');
    $password = Crypt::encryptString(Request::get('pass'));
    $address = ucfirst(mb_strtolower(Request::get('addressUser')));
    $fechaNac = Request::get('dateBirth');
    $userId= Request::get('argumento');
    $asesorId= Request::get('asesor');
    if($file) {
      $extension = strtolower($file->getClientOriginalExtension());
      $fileRename = uniqid().'.'.$extension;
      $path = "images/asesores";
      $file->move($path,$fileRename);
      $consulta=Agente::find($asesorId);
      if ($consulta->imagen_id!=1) {
          $imagen=Imagen::find($consulta->imagen_id);
          File::delete(public_path('images/asesores/'.$imagen->src));
          Imagen::where('id',$consulta->imagen_id)->update(['src' => $fileRename]);
      }
      else{
        $imagen=DB::table('imagenes')->insertGetId(['src' =>$fileRename]);
        Agente::where('id',$asesorId)->update(['imagen_id' => $imagen]);
      }
    }
    User::where('agente_id',$userId)->update([
                                                'password'=> $password,
                                                'address_user'=> $address,
                                                'date_birth' => $fechaNac,
                                              ]);
    $respuesta=1;
    return $respuesta;
  }
}
