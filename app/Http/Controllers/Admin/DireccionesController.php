<?php

namespace App\Http\Controllers\Admin;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Models\Estado;
use App\Models\Ciudad;
use App\Models\Urbanizacion;

class DireccionesController extends Controller{

  public function ajusteDirecciones(){
    $estados=Estado::all();
    return view('admin.direcciones',$this->cargarsidebar(),compact('estados'));
  }
  public function guardarCiudad(){
    $nombreCiudad=ucwords(mb_strtolower(Request::get('ciudad')));
    $estado=Request::get('estado');
    $consulta=Ciudad::where('nombre',$nombreCiudad)->where('estado_id',$estado)->first();
    if (count($consulta)==0) {
      $ciudad=new Ciudad;
      $ciudad->nombre=$nombreCiudad;
      $ciudad->estado_id=$estado;
      $ciudad->save();
      $lista=Ciudad::where('estado_id',$estado)->orderBy('nombre','asc')->get();
      $respuesta=1;
      $valores=[$respuesta,$lista];
    }
    else{
      $respuesta=0;
      $valores=[$respuesta,0];
    }
    return $valores;
  }
  public function guardarUrbanizacion(){
    $nombreUrbanizacion=ucwords(mb_strtolower(Request::get('urbanizacion')));
    $ciudad=Request::get('ciudadId');
    $consulta=Urbanizacion::where('nombre',$nombreUrbanizacion)->where('ciudad_id',$ciudad)->first();
    if (count($consulta)==0) {
      $urbanizacion=new Urbanizacion;
      $urbanizacion->nombre=$nombreUrbanizacion;
      $urbanizacion->ciudad_id=$ciudad;
      $urbanizacion->save();
      $lista=Urbanizacion::where('ciudad_id',$ciudad)->orderBy('nombre','asc')->get();
      $respuesta=1;
      $valores=[$respuesta,$lista];
    }
    else{
      $respuesta=0;
      $valores=[$respuesta,0];
    }
    return $valores;
  }
  public function borrarCiudad(){
    $estado=Request::get('estado');
    $ciudad=Request::get('ciudad');
    $consultaCiudad=Propiedad::where('ciudad_id','')
    //Urbanizacion::where('ciudad_id',$ciudad)->delete();
    //Ciudad::where('id',$ciudad)->delete();
    $ciudades=Ciudad::where('estado_id',$estado)->get();
    return $ciudades;
  }
}
