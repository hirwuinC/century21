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
use App\Models\Proyecto;
use App\Models\Propiedad;

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
    $paraBorrar=array();
    $noBorrar=array();
    $consultaCiudadPropiedad=Propiedad::where('ciudad_id',$ciudad)->first();
    $consultaCiudadProyecto=Proyecto::where('ciudad_id',$ciudad)->first();
    $consultaUrbanizacion=Urbanizacion::where('ciudad_id',$ciudad)->get();
    if (count($consultaCiudadPropiedad)==0 && count($consultaCiudadProyecto)==0) {
      for ($i=0; $i<count($consultaUrbanizacion); $i++) {
        $urbUsada=Propiedad::where('urbanizacion',$consultaUrbanizacion[$i]->id)->get();
        if (count($urbUsada)==0) {
          $paraBorrar[]=$consultaUrbanizacion[$i]->id;
        }
        else{
          $noBorrar[]=$consultaUrbanizacion[$i]->id;
        }
      }
      if (count($noBorrar)==0) {
        if (count($paraBorrar)!=0 ) {
          for ($b=0; $b < count($paraBorrar); $b++) {
            Urbanizacion::where('id',$paraBorrar[$b])->delete();
          }
          Ciudad::where('id',$ciudad)->delete();
          $respuesta=1;
        }
        else {
          Ciudad::where('id',$ciudad)->delete();
          $respuesta=2;
        }
      }
      else {
        $respuesta=10;
      }
    }
    else {
      $respuesta=0;
    }
    $ciudades=Ciudad::where('estado_id',$estado)->get();
    $valores=[$respuesta,$ciudades];
    return $valores;
  }
  public function borrarUrbanizacion(){
    $respuesta=0;
    $ciudad=Request::get('ciudad');
    $urbanizacion=Request::get('urbanizacion');
    $consultaUrbanizacion=Propiedad::where('urbanizacion',$urbanizacion)->first();
    if (count($consultaUrbanizacion)==0) {
      Urbanizacion::where('id',$urbanizacion)->delete();
      $respuesta=1;
    }
    $urbanizaciones=Urbanizacion::where('ciudad_id',$ciudad)->get();
    $valores=[$respuesta,$urbanizaciones];
    return $valores;
  }
}
