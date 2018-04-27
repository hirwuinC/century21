<?php

namespace App\Http\Controllers\Admin;

//use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Agente;
use App\Models\User;
use App\Models\Role;
use App\Models\Imagen;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AsesorController extends Controller
{
    public function ListarAsesores(){
      $data=\Request::get('data');
      if ($data) {
        $asesores=Agente::join('imagenes','agentes.imagen_id','imagenes.id')->where('agentes.id',$data)->select('agentes.*','imagenes.src as nombreimagen')->paginate(20);
      }
      else{
        $asesores= Agente::join('imagenes','agentes.imagen_id','imagenes.id')->where('agentes.id','<>',5)->select('agentes.*','imagenes.src as nombreimagen')->orderBy('fullName','asc')->paginate(20);
      }
    return view('admin.lista_agentes',$this->cargarSidebar(),compact('asesores'));
    }

    public function CrearUsuarioAsesor($id){
      $usuario=User::where('agente_id',$id)->first();
      if ($usuario) {
          $password=Crypt::decryptstring($usuario->password);
      }
      else {
        $usuario=(object)[
          "name"            =>"",
          "date_entry"      =>"",
          "rif_user"        =>"",
          "cedula"          =>"",
          "address_user"    =>"",
          "date_birth"      =>"",
          "agente_id"       =>"",
          "rol_id"          =>"",
          "certified_asesor"  =>""
        ];
        $password="";
      }
    	$asesor=Agente::where('id',$id)->first();
      $avatar=Imagen::where('id',$asesor->imagen_id)->first();
      $roles=Role::all();
      return view('admin.crear_agente',$this->cargarSidebar(),compact('asesor','usuario','roles','password','avatar'));

    }

    public function guardarEditarUsuario(){
      $file = Request::file('image');
      $usuario = mb_strtolower(Request::get('user'));
      $cedula = ucfirst(Request::get('cedula'));
      $password = Crypt::encryptString(\Request::get('pass'));
      $dateEntry = Request::get('dateEntry');
      $rif = ucfirst(Request::get('rifUser'));
      $address = ucwords(mb_strtolower(Request::get('addressUser')));
      $fechaNac = Request::get('dateBirth');
      $rol = Request::get('rolUser');
      $asesorId = Request::get('argument');
      $certificado = Request::get('certified');
      $objuser= new User;
      $objasesor = new Agente;
      $userExist=User::where('agente_id',$asesorId)->first();
      $cNombre= User::where('name',$usuario)->where('agente_id','<>',$asesorId)->first();
      $cCedula= User::where('cedula',$cedula)->where('agente_id','<>',$asesorId)->first();
      $cRif= User::where('rif_user',$rif)->where('agente_id','<>',$asesorId)->first();
      $respuesta = 0;
      if(count($userExist)!=0){
        if (count($cNombre)==0 && count($cCedula)==0  && count($cRif)==0) {
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
          User::where('agente_id',$asesorId)->update(['name' => $usuario,
                                                      'cedula' => $cedula,
                                                      'password'=> $password,
                                                      'date_entry'=> $dateEntry,
                                                      'rif_user'=> $rif,
                                                      'address_user'=> $address,
                                                      'date_birth' => $fechaNac,
                                                      'rol_id' => $rol,
                                                      'certified_asesor'=>$certificado
                                                    ]);

          $respuesta = 10;// Actualizacion Exitosa
        }
        else{
          if (count($cNombre)==0) {
            if (count($cCedula)==0 && count($cRif)!=0) {
              $respuesta=1;//El rif ya existe para otro usuario
            }
            elseif (count($cCedula)!=0 && count($cRif)==0) {
              $respuesta=2;//La cedula ya existe para otro usuario
            }
            elseif (count($cCedula)!=0 && count($cRif)!=0) {
              $respuesta=3;//La cedula y el rif ya existen para otros usuarios
            }
          }
          elseif (count($cNombre)!=0){
            if (count($cCedula)==0 && count($cRif)==0) {
              $respuesta=4;//El nombre ya existe para otro usuario
            }
            elseif(count($cCedula)!=0 && count($cRif)==0){
              $respuesta=5;//El nombre y la cedula ya existe para otro usuario
            }
            elseif(count($cCedula)==0 && count($cRif)!=0){
              $respuesta=6;//El nombre y el rif ya existe para otro usuario
            }
            elseif(count($cCedula)!=0 && count($cRif)!=0)
              $respuesta=7; // El nombre, la cedula y el rif ya existen para otro usuario
          }
        }

      }
      elseif(count($cNombre)==0 && count($cCedula)==0  && count($cRif)==0){
        if($file) {
          $extension = strtolower($file->getClientOriginalExtension());
          $fileRename = uniqid().'.'.$extension;
          $path = "images/asesores";
          $file->move($path,$fileRename);
          $consulta=Agente::find($asesorId);
          $imagen=DB::table('imagenes')->insertGetId(['src' =>$fileRename]);
          Agente::where('id',$asesorId)->update(['imagen_id' => $imagen]);
        }
        $objuser->name = $usuario;
        $objuser->cedula = $cedula;
        $objuser->password = $password;
        $objuser->date_entry = $dateEntry;
        $objuser->rif_user = $rif;
        $objuser->address_user = $address;
        $objuser->date_birth = $fechaNac;
        $objuser->rol_id = $rol;
        $objuser->agente_id = $asesorId;
        $objuser->certified_asesor = $certificado;
        $objuser->save();
        $respuesta=20; // Guardado exitoso del usuario
      }
      else{
        if (count($cNombre)==0) {
          if (count($cCedula)==0 && count($cRif)!=0) {
            $respuesta=1;//El rif ya existe para otro usuario
          }
          elseif (count($cCedula)!=0 && count($cRif)==0) {
            $respuesta=2;//La cedula ya existe para otro usuario
          }
          elseif (count($cCedula)!=0 && count($cRif)!=0) {
            $respuesta=3;//La cedula y el rif ya existen para otros usuarios
          }
        }
        elseif (count($cNombre)!=0){
          if (count($cCedula)==0 && count($cRif)==0) {
            $respuesta=4;//El nombre ya existe para otro usuario
          }
          elseif(count($cCedula)!=0 && count($cRif)==0){
            $respuesta=5;//El nombre y la cedula ya existe para otro usuario
          }
          elseif(count($cCedula)==0 && count($cRif)!=0){
            $respuesta=6;//El nombre y el rif ya existe para otro usuario
          }
          elseif(count($cCedula)!=0 && count($cRif)!=0)
            $respuesta=7; // El nombre, la cedula y el rif ya existen para otro usuario
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
