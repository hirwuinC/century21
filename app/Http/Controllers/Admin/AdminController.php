<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


class AdminController extends Controller
{

    public function __construct()
    {
        
        //$this->middleware('auth');
    }

    public function Login()
    {
        return view('/admin/login');
    }

    public function Dasboard()
    {
        return redirect(route('admin_lista_inmuebles'));
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
}
