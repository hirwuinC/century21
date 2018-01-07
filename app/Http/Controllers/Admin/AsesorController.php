<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Agente;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Crypt;

class AsesorController extends Controller
{
    public function ListarAsesores(){
      $data=\Request::get('data');
      if ($data) {
        $asesores=Agente::where('id',$data)->paginate(20);
      }
      else{
        $asesores= Agente::paginate(20);
      }
    return view('admin.lista_agentes',$this->cargarSidebar(),compact('asesores'));
    }

    public function CrearUsuarioAsesor($id){
      $usuario=User::where('agente_id',$id)->first();
      if ($usuario) {
          $password=Crypt::decryptString($usuario->password);
      }
    	$asesor=Agente::where('id',$id)->first();
    	$fullname=explode(" ", $asesor->fullName);
      $roles=Role::all();
      return view('admin.crear_agente',$this->cargarSidebar(),compact('asesor','fullname','usuario','roles','password'));

    }

    public function guardarEditarUsuario(){
      $file = \Request::file('image');
      $objuser= new User;
      $objasesor = new Agente;
      $usuario = \Request::get('user');
      $email = \Request::get('emailUser');
      $password = Crypt::encryptString(\Request::get('pass'));
      $dateEntry = \Request::get('dateEntry');
      $rif = \Request::get('rifUser');
      $address = \Request::get('addressUser');
      $fechaNac = \Request::get('dateBirth');
      $rol = \Request::get('rolUser');
      $asesorId = \Request::get('argument');
      $certificado = \Request::get('certified');
      $userExist=User::where('agente_id',$asesorId)->first();
      $cNombre= User::where('name',$usuario)->where('agente_id','<>',$asesorId)->first();
      $cEmail= User::where('email',$email)->where('agente_id','<>',$asesorId)->first();
      $cRif= User::where('rif_user',$rif)->where('agente_id','<>',$asesorId)->first();
      $respuesta = 0;
      if(count($userExist)!=0){
        if (count($cNombre)==0 && count($cEmail)==0  && count($cRif)==0) {
          User::where('agente_id',$asesorId)->update(['name' => $usuario,
                                                      'email' => $email,
                                                      'password'=> $password,
                                                      'date_entry'=> $dateEntry,
                                                      'rif_user'=> $rif,
                                                      'address_user'=> $address,
                                                      'date_birth' => $fechaNac,
                                                      'rol_id' => $rol
                                                    ]);
          Agente::where('id',$asesorId)->update(['certified_asesor' => $certificado]);
          $respuesta = 10;// Actualizacion Exitosa
        }
        else{
          if (count($cNombre)==0) {
            if (count($cEmail)==0 && count($cRif)!=0) {
              $respuesta=1;//El rif ya existe para otro usuario
            }
            elseif (count($cEmail)!=0 && count($cRif)==0) {
              $respuesta=2;//El email ya existe para otro usuario
            }
            elseif (count($cEmail)!=0 && count($cRif)!=0) {
              $respuesta=3;//El email y el rif ya existen para otros usuarios
            }
          }
          elseif (count($cNombre)!=0){
            if (count($cEmail)==0 && count($cRif)==0) {
              $respuesta=4;//El nombre ya existe para otro usuario
            }
            elseif(count($cEmail)!=0 && count($cRif)==0){
              $respuesta=5;//El nombre y el email ya existe para otro usuario
            }
            elseif(count($cEmail)==0 && count($cRif)!=0){
              $respuesta=6;//El nombre y el rif ya existe para otro usuario
            }
            elseif(count($cEmail)!=0 && count($cRif)!=0)
              $respuesta=7; // El nombre, el email y el rif ya existen para otro usuario
          }
        }

      }
      elseif(count($cNombre)==0 && count($cEmail)==0  && count($cRif)==0){
        $objuser->name = $usuario;
        $objuser->email = $email;
        $objuser->password = $password;
        $objuser->date_entry = $dateEntry;
        $objuser->rif_user = $rif;
        $objuser->address_user = $address;
        $objuser->date_birth = $fechaNac;
        $objuser->rol_id = $rol;
        $objuser->agente_id = $asesorId;
        $objuser->save();
        Agente::where('id',$asesorId)->update(['certified_asesor' => $certificado]);
        $respuesta=20; // Guardado exitoso del usuario
      }
      else{
        if (count($cNombre)==0) {
          if (count($cEmail)==0 && count($cRif)!=0) {
            $respuesta=1;//El rif ya existe para otro usuario
          }
          elseif (count($cEmail)!=0 && count($cRif)==0) {
            $respuesta=2;//El email ya existe para otro usuario
          }
          elseif (count($cEmail)!=0 && count($cRif)!=0) {
            $respuesta=3;//El email y el rif ya existen para otros usuarios
          }
        }
        elseif (count($cNombre)!=0){
          if (count($cEmail)==0 && count($cRif)==0) {
            $respuesta=4;//El nombre ya existe para otro usuario
          }
          elseif(count($cEmail)!=0 && count($cRif)==0){
            $respuesta=5;//El nombre y el email ya existe para otro usuario
          }
          elseif(count($cEmail)==0 && count($cRif)!=0){
            $respuesta=6;//El nombre y el rif ya existe para otro usuario
          }
          elseif(count($cEmail)!=0 && count($cRif)!=0)
            $respuesta=7; // El nombre, el email y el rif ya existen para otro usuario
        }
      }
      return $respuesta;
    }
   	public function searchAsesor(){
    	$var =\Request::get('data');
    	$result=Agente::searchAsesor($var)->get();
    	return response()->json($result);
    }
    public function pruebaAsesor(){
      return $this->prueba();
    }

}
