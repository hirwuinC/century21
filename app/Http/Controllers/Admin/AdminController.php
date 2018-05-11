<?php

namespace App\Http\Controllers\Admin;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use App\Models\Agente;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller{

  public function Login(){
      return view('/admin/login');
  }

  public function ingresar(){
    $usuario = Request::get('usuario');
    $pass = Request::get('password');
    $consulta = DB::table('users')->join('agentes','users.agente_id','agentes.id')
                                  ->join('imagenes','agentes.imagen_id','=','imagenes.id')
                                  ->select('users.*','imagenes.id as id_imagen','imagenes.src as nombre_imagen','agentes.id as asesor_id','agentes.fullname as nombre_asesor')
                                  ->where('users.name',$usuario)
                                  ->first();
    $respuesta=[0];
    if(!empty($consulta)){
      $password=Crypt::decryptstring($consulta->password);
      if ($pass == $password) {
        $permisos=DB::table('permisorole')->join('permisos', 'permisorole.permiso_id','permisos.id')
                                          ->select('permisos.*')
                                          ->where('permisorole.role_id',$consulta->rol_id)
                                          ->orderBy('orden','asc')
                                          ->get();
        $submodulos=DB::table('submodulorole')->join('submodulos', 'submodulorole.submodulo_id', '=', 'submodulos.id')
                                              ->select('submodulos.*')
                                              ->where('submodulorole.role_id',$consulta->rol_id)
                                              ->get();
        Session::put('asesor',$consulta);
        Session::put('usuario',$usuario);
        Session::put('pass',$pass);
        Session::put('permisos',$permisos);
        Session::put('submodulos',$submodulos);
        $respuesta = [1,$consulta->name];
      }
    }
    return Response::json($respuesta);
  }
    public function Dasboard()
    {
        return redirect(route('login'));
    }

    public function CrearAgente()
    {
        return view('/admin/crear_agente',$this->cargarSidebar());
    }

    public function ListarAgente()
    {
        return view('/admin/lista_agentes',$this->cargarSidebar());
    }
    public function salir(){
      Session::forget('asesor');
      Session::forget('usuario');
      Session::forget('pass');
      Session::forget('permisos');
      Session::forget('submodulos');
      $respuesta =1;
      return $respuesta;
    }


}
