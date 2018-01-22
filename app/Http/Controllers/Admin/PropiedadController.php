<?php

namespace App\Http\Controllers\Admin;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\Estado;
use App\Models\Ciudad;
use App\Models\TipoInmueble;
use App\Models\Agente;

class PropiedadController extends Controller{

  public function ListaInmuebles(){

      return view('/admin/lista_inmuebles',$this->cargarSidebar());
  }

  public function CrearInmueble1(){
    $datos=[];
    $tiposIn=TipoInmueble::all();
    $estados=Estado::all();
    $asesores=Agente::all();
    $datos=Session::get('data');
    $consulta=Ciudad::where('estado_id',$datos["estado"])->get();
    return view('/admin/crear_inmueble_1',$this->cargarSidebar(),compact('tiposIn','estados','asesores','datos','consulta'));
    //return $datos;
  }
  public function listarCiudades(){
    $estado=Request::get('estado');
    return $this->cargarCiudades($estado);
  }
  public function cargarPropiedad(){
    $data=[
            "nombre"            =>  Request::get('namePropiety'),
            "tipoNegocio"       =>  Request::get('typeBussisness'),
            "posicionMapa"      =>  Request::get('positionPropiety'),
            "estado"            =>  Request::get('estatePropiety'),
            "ciudad"            =>  Request::get('cityPropiety'),
            "direccion"         =>  Request::get('addressPropiety'),
            "precio"            =>  Request::get('pricePropiety'),
            "visible"           =>  Request::get('visiblePrice'),
            "construccion"      =>  Request::get('constructionPropiety'),
            "terreno"           =>  Request::get('areaPropiety'),
            "habitacion"        =>  Request::get('roomPropiety'),
            "bano"              =>  Request::get('batroomPropiety'),
            "estacionamiento"   =>  Request::get('parkingPropiety'),
            "descripcion"       =>  Request::get('descriptionPropiety'),
            "asesor"            =>  Request::get('asesorPropiety'),
            "tipoPropiedad"     =>  Request::get('typePropiety')
          ];
    Session::put('data',$data);
    $datos=Session::get('data');
    return compact('datos');
  }
  public function CrearInmueble2(){
      return view('/admin/crear_inmueble_2',$this->cargarSidebar());
  }

  public function DetalleInmueble(){
      return view('/admin/detalle_inmueble',$this->cargarSidebar());
  }
}
