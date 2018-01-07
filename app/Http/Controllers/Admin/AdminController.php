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
        $submodulos=DB::table('submoduloRole')->join('submodulos', 'submoduloRole.submodulo_id', '=', 'submodulos.id')
                                          ->select('submodulos.*')
                                          ->where('submoduloRole.role_id',$consulta->rol_id)
                                          ->get();
        Session::put('asesor',$consulta);
        Session::put('usuario',$usuario);
        Session::put('pass',$pass);
        Session::put('permisos',$permisos);
        Session::put('submodulos',$submodulos);
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
        return view('/admin/lista_inmuebles',$this->cargarSidebar());
    }

    public function CrearInmueble1()
    {
        return view('/admin/crear_inmueble_1',$this->cargarSidebar());
    }

    public function CrearInmueble2()
    {
        return view('/admin/crear_inmueble_2',$this->cargarSidebar());
    }

    public function CrearAgente()
    {
        return view('/admin/crear_agente',$this->cargarSidebar());
    }
    
    public function DetalleInmueble()
    {
        return view('/admin/detalle_inmueble',$this->cargarSidebar());
    }

    public function ListarAgente()
    {
        return view('/admin/lista_agentes',$this->cargarSidebar());
    }


}
