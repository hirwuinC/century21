<?php

namespace App\Http\Controllers\Admin;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Agente;
use App\Models\User;
use App\Models\Role;

class AdminController extends Controller{

  public function __construct(){

        //$this->middleware('auth');
  }

  public function Login(){
      return view('/admin/login');
  }

  public function ingresar(){
    $usuario = Request::get('usuario');
    $pass = Request::get('password');
    $consulta = User::where('name',$usuario)->first();
    $respuesta=0;
    if(count($consulta)!=0){
      $password=Crypt::decryptString($consulta->password);
      if ($pass == $password) {
        $respuesta = 1;
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
        return view('/admin/lista_inmuebles');
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
