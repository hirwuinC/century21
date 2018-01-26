<?php

namespace App\Http\Controllers\Admin;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Estado;
use App\Models\Ciudad;
use App\Models\TipoInmueble;
use App\Models\Agente;
use App\Models\Propiedad;
use App\Models\Negociacion;

class PropiedadController extends Controller{

  public function ListaInmuebles(){
      $usuario=Session::get('asesor');
      if ($usuario->rol_id==1) {
        $inmuebles=Propiedad::all();
      }
      else {
        $inmuebles=Propiedad::where('agente_id',$usuario->agente_id)->get();
      }
      return view('/admin/lista_inmuebles',$this->cargarSidebar(),compact('inmuebles','usuario'));
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

  public function guardarInmueble(){
    $datos=Session::get('data');
    $propiedad= new Propiedad;
    $propiedad->id_mls=0;
    $propiedad->tipo_inmueble=$datos['tipoPropiedad'];
    $propiedad->tipoNegocio=$datos['tipoNegocio'];
    $propiedad->urbanizacion=$datos['nombre'];
    $propiedad->precio=$datos['precio'];
    $propiedad->visible=$datos['visible'];
    $propiedad->habitaciones=$datos['habitacion'];
    $propiedad->banos=$datos['bano'];
    $propiedad->estacionamientos=$datos['estacionamiento'];
    $propiedad->metros_construccion=$datos['construccion'];
    $propiedad->metros_terreno=$datos['terreno'];
    $propiedad->comentario=$datos['descripcion'];
    $propiedad->agente_id=$datos['asesor'];
    $propiedad->estado_id=$datos['estado'];
    $propiedad->ciudad_id=$datos['ciudad'];
    $propiedad->direccion=$datos['direccion'];
    $propiedad->posicionMapa=$datos['posicionMapa'];
    $propiedad->save();
    Session::forget('data');
    $respuesta=1;
    return $respuesta;
  }

  public function DetalleInmueble($id){
    $usuario=Session::get('asesor');
    $negociacion=DB::table('negociaciones')->where('negociaciones.propiedad_id',$id)
                                           ->where('negociaciones.estatus',1)
                                           ->first();
    if ($negociacion==null) {
      $negociacion=(object)[
             "asesorCaptador"       => "",
             "asesorCerrador"       => "",
             "precioFinal"          => "",
             "porcentajeCaptacion"  => "",
             "porcentajeCierre"     => "",
             "comisionBruta"        => "",
             "pagoCasaMatriz"       => "",
             "ingresoNeto"          => "",
             "estatus"              => ""
           ];
    }
    $inmuebles=DB::table('propiedades')->join('tipoInmueble','propiedades.tipo_inmueble','=','tipoInmueble.id')
                                       ->join('agentes','propiedades.agente_id','=','agentes.id')
                                       ->join('estados','propiedades.estado_id','=','estados.id')
                                       ->join('ciudades','propiedades.ciudad_id','=','ciudades.id')
                                       ->select('propiedades.*','agentes.fullname','estados.nombre as nombre_estado','ciudades.nombre as nombre_ciudad','tipoInmueble.*')
                                       ->where('propiedades.id',$id)
                                       ->get();
      //return dd((object)$data);
      return view('/admin/detalle_inmueble',$this->cargarSidebar(),compact('inmuebles','usuario','negociacion'));
  }

  public function mostrarEditarInmueble1($id){
    $propiedad=Propiedad::where('id',$id)->first();
    $tiposIn=TipoInmueble::all();
    $estados=Estado::all();
    $asesores=Agente::all();
    $consulta=Ciudad::where('estado_id',$propiedad->estado_id)->get();
    return view('/admin/editar_inmueble_1',$this->cargarSidebar(),compact('tiposIn','estados','asesores','consulta','propiedad'));
  }

  public function actualizarInmueble1(){
    $id=Request::get('register');
    Propiedad::where('id',$id)->update([
              "urbanizacion"            =>  Request::get('namePropiety'),
              "tipoNegocio"             =>  Request::get('typeBussisness'),
              "posicionMapa"            =>  Request::get('positionPropiety'),
              "estado_id"               =>  Request::get('estatePropiety'),
              "ciudad_id"               =>  Request::get('cityPropiety'),
              "direccion"               =>  Request::get('addressPropiety'),
              "precio"                  =>  Request::get('pricePropiety'),
              "visible"                 =>  Request::get('visiblePrice'),
              "metros_construccion"     =>  Request::get('constructionPropiety'),
              "metros_terreno"          =>  Request::get('areaPropiety'),
              "habitaciones"            =>  Request::get('roomPropiety'),
              "banos"                   =>  Request::get('batroomPropiety'),
              "estacionamientos"        =>  Request::get('parkingPropiety'),
              "comentario"              =>  Request::get('descriptionPropiety'),
              "agente_id"               =>  Request::get('asesorPropiety'),
              "tipo_inmueble"           =>  Request::get('typePropiety')
    ]);
    $respuesta=[1,$id];
    return $respuesta;
  }
  public function mostrarEditarInmueble2(){
    return view('/admin/editar_inmueble_2',$this->cargarSidebar());
  }
  public function prueba(){
        $opcion=3;
        $segundoselect=["1"=>["valor"=>"1","descripcion"=>"opcion 1"],"2"=>["valor"=>"2","descripcion"=>"opcion 2"],"3"=>["valor"=>"3","descripcion"=>"opcion 3"]];
        $consulta=$segundoselect[$opcion];
        return $consulta;
  }
}
