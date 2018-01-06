<?php

namespace App\Http\Controllers\Admin;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
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
    $consulta = User::where('name',$usuario)->first();
    $respuesta=[0];
    if(count($consulta)!=0){
      $password=Crypt::decryptString($consulta->password);
      if ($pass == $password) {
        $permisos=DB::table('permisoRole')->join('permisos', 'permisoRole.permiso_id', '=', 'permisos.id')
                                          ->select('permisos.*')
                                          ->where('permisoRole.role_id',$consulta->rol_id)
                                          ->get();
        Session::put('usuario',$usuario);
        Session::put('pass',$pass);
        Session::put('permisos',$permisos);
        $respuesta = [1,$consulta->name];
      }
    }
    return $respuesta;
  }






    public function Dasboard()
    {
        return redirect(route('login'));
    }

    public function ListaInmuebles()
    {
        $permisos=Session::get('permisos');
        return view('/admin/lista_inmuebles',compact('permisos'));
    }

    public function CrearInmueble1()
    {
        return view('/admin/crear_inmueble_1');
    }

    public function CrearInmueble2()
    {
        return view('/admin/crear_inmueble_2');
    }

    public function CrearAgente()
    {
        return view('/admin/crear_agente');
    }

    public function Perfil()
    {
        return view('/admin/perfil');
    }

    public function DetalleInmueble()
    {
        return view('/admin/detalle_inmueble');
    }

    public function ListarAgente()
    {
        return view('/admin/lista_agentes');
    }


}
