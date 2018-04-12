<?php

namespace App\Http\Controllers\Admin;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
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
    $respuesta=0;
    return view('/admin/perfil',$this->cargarSidebar(),compact('password','asesor','fullname','roles','avatar'));
  }

  public function actualizarPerfil(){
    $file = Request::file('image');
    $password = Crypt::encryptString(Request::get('pass'));
    $address = ucfirst(mb_strtolower(Request::get('addressUser')));
    $fechaNac = Request::get('dateBirth');
    $asesorId= Request::get('argumento');

    if($file) {
      $extension = strtolower($file->getClientOriginalExtension());
      $fileRename = uniqid().'.'.$extension;
      $path = "asesores";
      $file->move($path,$fileRename);
    }
    User::where('agente_id',$asesorId)->update([
                                                'password'=> $password,
                                                'address_user'=> $address,
                                                'date_birth' => $fechaNac,
                                              ]);
    $respuesta=1;
    return $asesorId;
  }
}
