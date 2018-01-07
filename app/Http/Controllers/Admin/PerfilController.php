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
use Illuminate\Support\Facades\DB;

class PerfilController extends Controller{

  public function Perfil(){
    $password=Session::get('pass');
    $usuario=Session::get('asesor');
    $asesor=Agente::where('id',$usuario->agente_id)->first();
    $fullname=explode(" ", $asesor->fullName);
    $roles=Role::all();
    $respuesta=0;
    return view('/admin/perfil',$this->cargarSidebar(),compact('password','asesor','fullname','roles'));
  }

  public function actualizarPerfil(){
    $file = Request::file('image');
    $password = Crypt::encryptString(Request::get('pass'));
    $address = Request::get('addressUser');
    $fechaNac = Request::get('dateBirth');
    $asesorId= Request::get('argumento');
    User::where('agente_id',$asesorId)->update([
                                                'password'=> $password,
                                                'address_user'=> $address,
                                                'date_birth' => $fechaNac,
                                              ]);
    $nombre=$file->getClientOriginalName();
    \Storage::disk('local')->put($nombre,  \File::get($file));
    $respuesta=1;
    return $respuesta;
  }
}
