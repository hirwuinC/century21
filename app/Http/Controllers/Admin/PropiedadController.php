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
use App\Models\NegociacionEstatus;

class PropiedadController extends Controller{

  public function ListaInmuebles(){
      $usuario=Session::get('asesor');
      if ($usuario->rol_id==1) {
        $inmuebles=DB::table('medias')->Join('propiedades','medias.propiedad_id','propiedades.id')
                                           ->select('medias.nombre as nombre_imagen','medias.propiedad_id','medias.id as id_imagen','propiedades.*')
                                           ->where('medias.vista',1)
                                           ->paginate(30);
      }
      else {
        $inmuebles=DB::table('medias')->Join('propiedades','medias.propiedad_id','propiedades.id')
                                           ->select('medias.nombre as nombre_imagen','medias.propiedad_id','medias.id as id_imagen','propiedades.*')
                                           ->where('medias.vista',1)
                                           ->where('propiedades.agente_id',$usuario->agente_id)
                                           ->paginate(30);
      }
      return view('/admin/lista_inmuebles',$this->cargarSidebar(),compact('inmuebles','usuario'));
  }

  public function CrearInmueble1(){
    $datos=[];
    $consulta=[];
    $usuario=Session::get('asesor');
    $datos=Propiedad::where('cargado',0)->where('cargadoPor',$usuario->id)->first();
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
    $usuario=Session::get('asesor');
    $proximoInforme=date('Y-m-d', strtotime('+1 month'));
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
                  "posicionMapa"        =>  Request::get('positionPropiety'),
                  "destacado"           =>  Request::get('destacado'),
                  "cargadoPor"          =>  $usuario->id
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
                  "posicionMapa"        =>  Request::get('positionPropiety'),
                  "destacado"           =>  Request::get('destacado'),
                  "cargadoPor"          =>  $usuario->id,
                  "proximoInforme"      =>  $proximoInforme
      ]);
    }
    Session::put('inmueble',$id);
    return compact('id');
  }

  public function guardarImagen(){
    $sesiones=['inmueble','inmuebleEdit'];
    $desicion=Request::get('desicion');
    $archivo= Request::file('file');
    $ubicacion=Request::get('register');
    $idImagen=Request::get('valor');
    $inmueble=Session::get($sesiones[$desicion]);
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
    $sesiones=['inmueble','inmuebleEdit'];
    $desicion=Request::get('desicion');
    $respuesta=0;
    $inmueble=Session::get($sesiones[$desicion]);
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
    $sesiones=['inmueble','inmuebleEdit'];
    $desicion=Request::get('desicion');
    $respuesta=0;
    $inmueble=Session::get($sesiones[$desicion]);
    $seleccionado=Request::get('imgSelected');
    $marcado=Media::where('propiedad_id',$inmueble)->where('vista',1)->first();
    $ultimo=Media::where('propiedad_id',$inmueble)->first();

    if (count($ultimo)!=0) {
      if (count($marcado)!=0) {
        if ($marcado->id!=$seleccionado) {
          $img=Media::find($marcado->id);
          $img->vista=0;
          $img->save();
          $imgNew=Media::find($seleccionado);
          $imgNew->vista=1;
          $imgNew->save();
          Propiedad::where('id',$inmueble)->update([
            'cargado'=>1
          ]);
          Session::forget($sesiones[$desicion]);
          $respuesta=1;
        }
        else{
          $imgNew=Media::find($seleccionado);
          $imgNew->vista=1;
          $imgNew->save();
          Propiedad::where('id',$inmueble)->update([
            'cargado'=>1
          ]);
          Session::forget($sesiones[$desicion]);
          $respuesta=1;
        }
      }
      else {
        $consulta=Media::where('id',$seleccionado)->first();
        if (count($consulta)!=0) {
          $imgNew=Media::find($seleccionado);
          $imgNew->vista=1;
          $imgNew->save();
          Propiedad::where('id',$inmueble)->update([
            'cargado'=>1
          ]);
          Session::forget($sesiones[$desicion]);
          $respuesta=1;
        }
        else{
          $respuesta=2;//El elemento marcado no tiene imagen asociada
        }

      }
    }
    return $respuesta;
  }
  public function llenarModalNegociacion(){
    $propuesta=(object)["negociacion_id"=>"","estatus_id"=>"","fechaEstatus"=>""];
    $idInmueble=Request::get('parametro');
    $consulta=Negociacion::where('propiedad_id',$idInmueble)->where('estatus',8)->first();
    if(count($consulta)!=0){
      $propuesta=(object)["negociacion_id"=>"","estatus_id"=>"","fechaEstatus"=>""];
      $deposito=(object)["negociacion_id"=>"","estatus_id"=>"","fechaEstatus"=>""];
      $promesa=(object)["negociacion_id"=>"","estatus_id"=>"","fechaEstatus"=>""];
      $protocolo=(object)["negociacion_id"=>"","estatus_id"=>"","fechaEstatus"=>""];
      $reporte=(object)["negociacion_id"=>"","estatus_id"=>"","fechaEstatus"=>""];
      // $propuesta=NegociacionEstatus::where('negociacion_id',$consulta->id)->where('estatus_id',3)->first();
      // $deposito=NegociacionEstatus::where('negociacion_id',$consulta->id)->where('estatus_id',4)->first();
      // $promesa=NegociacionEstatus::where('negociacion_id',$consulta->id)->where('estatus_id',5)->first();
      // $protocolo=NegociacionEstatus::where('negociacion_id',$consulta->id)->where('estatus_id',6)->first();
      // $reporte=NegociacionEstatus::where('negociacion_id',$consulta->id)->where('estatus_id',7)->first();
    }
    return $propuesta;
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

    $imagen=Media::where('propiedad_id',$id)->where('vista',1)->first();
    return view('/admin/detalle_inmueble',$this->cargarSidebar(),compact('inmuebles','usuario','negociacion','imagen'));
  }

  public function mostrarEditarInmueble1($id){
    Session::forget('inmuebleEdit');
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
              "destacado"               =>  Request::get('destacado'),
              "tipo_inmueble"           =>  Request::get('typePropiety')
    ]);
    $respuesta=[1,$id];
    Session::put('inmuebleEdit',$id);
    return $respuesta;
  }
  public function mostrarEditarInmueble2(){
    $inmueble=Session::get('inmuebleEdit');
    $imagenes=Media::where('propiedad_id',$inmueble)->get();
    $ultimo=Media::where('propiedad_id',$inmueble)->orderBy('id', 'desc')->first();
    return view('/admin/editar_inmueble_2',$this->cargarSidebar(),compact('inmueble','imagenes','ultimo'));
  }
  public function prueba(){
        $consulta=uniqid();
        return $consulta;
  }
}
