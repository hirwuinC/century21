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
use App\Models\TipoInmueble;
use App\Models\Agente;
use App\Models\Propiedad;
use App\Models\Negociacion;
use App\Models\Media;

class PropiedadController extends Controller{

  public function ListaInmuebles(){
      $usuario=Session::get('asesor');
      if ($usuario->rol_id==1) {
        $inmuebles=Propiedad::paginate(30);
      }
      else {
        $inmuebles=Propiedad::where('agente_id',$usuario->agente_id)->paginate(30);
      }
      return view('/admin/lista_inmuebles',$this->cargarSidebar(),compact('inmuebles','usuario'));
      //return $imagenes;
  }

  public function CrearInmueble1(){
    $datos=[];
    $consulta=[];
    $datos=Propiedad::where('cargado',0)->first();
    if (count($datos)!=0) {
      $consulta=Ciudad::where('estado_id',$datos->estado_id)->get();
    }
    $tiposIn=TipoInmueble::all();
    $estados=Estado::all();
    $asesores=Agente::all();
    return view('/admin/crear_inmueble_1',$this->cargarSidebar(),compact('tiposIn','estados','asesores','datos','consulta'));
  }
  public function listarCiudades(){
    $estado=Request::get('estado');
    return $this->cargarCiudades($estado);
  }


  public function cargarPropiedad(){
    $inmuebleIncompleto=Request::get('register');
    if (empty($inmuebleIncompleto)==false) {
      $id=Request::get('register');
      Propiedad::where('id',$inmuebleIncompleto)->update([
                  "tipo_inmueble"       =>  Request::get('typePropiety'),
                  "tipoNegocio"         =>  Request::get('typeBussisness'),
                  "urbanizacion"        =>  Request::get('namePropiety'),
                  "precio"              =>  Request::get('pricePropiety'),
                  "visible"             =>  Request::get('visiblePrice'),
                  "habitaciones"        =>  Request::get('roomPropiety'),
                  "banos"               =>  Request::get('batroomPropiety'),
                  "estacionamientos"    =>  Request::get('parkingPropiety'),
                  "metros_construccion" =>  Request::get('constructionPropiety'),
                  "metros_terreno"      =>  Request::get('areaPropiety'),
                  "comentario"          =>  Request::get('descriptionPropiety'),
                  "agente_id"           =>  Request::get('asesorPropiety'),
                  "estado_id"           =>  Request::get('estatePropiety'),
                  "ciudad_id"           =>  Request::get('cityPropiety'),
                  "direccion"           =>  Request::get('addressPropiety'),
                  "posicionMapa"        =>  Request::get('positionPropiety')
                ]);
    }
    else {
      $id=DB::table('propiedades')->insertGetId([
                  "tipo_inmueble"       =>  Request::get('typePropiety'),
                  "tipoNegocio"         =>  Request::get('typeBussisness'),
                  "urbanizacion"        =>  Request::get('namePropiety'),
                  "precio"              =>  Request::get('pricePropiety'),
                  "visible"             =>  Request::get('visiblePrice'),
                  "habitaciones"        =>  Request::get('roomPropiety'),
                  "banos"               =>  Request::get('batroomPropiety'),
                  "estacionamientos"    =>  Request::get('parkingPropiety'),
                  "metros_construccion" =>  Request::get('constructionPropiety'),
                  "metros_terreno"      =>  Request::get('areaPropiety'),
                  "comentario"          =>  Request::get('descriptionPropiety'),
                  "agente_id"           =>  Request::get('asesorPropiety'),
                  "estado_id"           =>  Request::get('estatePropiety'),
                  "ciudad_id"           =>  Request::get('cityPropiety'),
                  "direccion"           =>  Request::get('addressPropiety'),
                  "posicionMapa"        =>  Request::get('positionPropiety')
      ]);
    }
    Session::put('inmueble',$id);
    return compact('id');
  }

  public function guardarImagen(){
    $archivo= Request::file('file');
    $ubicacion=Request::get('register');
    $idImagen=Request::get('valor');
    $inmueble=Session::get('inmueble');
    $extension = strtolower($archivo->getClientOriginalExtension());
    $renombre = uniqid().'.'.$extension;
    $path ="images/inmuebles";
    $consulta=Media::where('id',$idImagen)->first();
    if (count($consulta)!=0) {
      Media::where('id',$idImagen)->update([
        "nombre"        =>  $renombre,
        "propiedad_id"  =>  $inmueble
      ]);
      File::delete(public_path('images/inmuebles/'.$consulta->nombre.''));
      $archivo->move($path,$renombre);
    }
    else{
      $idImagen=DB::table('medias')->insertGetId([
                  "nombre"        =>  $renombre,
                  "propiedad_id"  =>  $inmueble
      ]);
      $archivo->move($path,$renombre);
    }
    $datos=[$ubicacion,$idImagen];
    return $datos;
  }

  public function borrarImagen(){
    $respuesta=0;
    $inmueble=Session::get('inmueble');
    $imagen= Request::get('registro');
    $consulta=Media::where('id',$imagen)->where('propiedad_id',$inmueble)->first();
    if (count($consulta)!=0) {
      File::delete(public_path('images/inmuebles/'.$consulta->nombre.''));
      Media::destroy($imagen);
      $respuesta=1;
    }

    return $respuesta;
  }

  public function CrearInmueble2(){
    $inmueble=Session::get('inmueble');
    $imagenes=Media::where('propiedad_id',$inmueble)->get();
    $ultimo=Media::where('propiedad_id',$inmueble)->orderBy('id', 'desc')->first();
    return view('/admin/crear_inmueble_2',$this->cargarSidebar(),compact('imagenes','ultimo'));
  }

  public function guardarInmueble(){
    /*$respuesta=0;
    $inmueble=Session::get('inmueble');
    $seleccionado=Request::get('imgSelected');
    $marcado=Media::where('id',$seleccionado)->first();
    $ultimo=Media::where('propiedad_id',$inmueble)->first();
    if ($marcado->vista!=1) {
      $img=Media::find($seleccionado);
      $img->vista=1;
      $img->save();
      $cambio=
    }
    if (count($ultimo)!=0) {
      Propiedad::where('id',$inmueble)->update([
        'cargado'=>1
      ]);
      Session::forget('inmueble');
      $respuesta=1;
    }*/
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
        $consulta=uniqid();
        return $consulta;
  }
}
