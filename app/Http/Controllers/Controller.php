<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Agente;
use App\Models\User;
use App\Models\Ciudad;
use App\Models\Urbanizacion;
use Illuminate\Support\Facades\Session;
//use Illuminate\Support\Facades\Request;
use App\Http\Requests;
use Illuminate\Http\Request;
use PDF;

class Controller extends BaseController{

  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function cargarSidebar(){
    $userall=Session::get('asesor');
    $permisos=Session::get('permisos');
    $submodulos=Session::get('submodulos');
    return compact('permisos','submodulos','userall');
  }

  public function cargarCiudades($estado){
    $ciudades=Ciudad::where('estado_id',$estado)->orderBy('nombre','asc')->get();
    return compact('ciudades');
  }
  public function cargarUrbanizaciones($ciudad){
    $urbanizaciones=Urbanizacion::where('ciudad_id',$ciudad)->orderBy('nombre','asc')->get();
    return compact('urbanizaciones');
  }
}
