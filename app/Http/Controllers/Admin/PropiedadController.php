<?php

namespace App\Http\Controllers\Admin;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Models\Estado;
use App\Models\Estatus;
use App\Models\Ciudad;
use App\Models\Urbanizacion;
use App\Models\TipoInmueble;
use App\Models\Agente;
use App\Models\Propiedad;
use App\Models\Negociacion;
use App\Models\Informe;
use App\Models\Media;
use App\Models\NegociacionEstatus;
use App\Models\CompradorPropiedades;

class PropiedadController extends Controller{

  public function ListaInmuebles(){
      $arreglo=array();
      $inmuebles=DB::table('medias')->Join('propiedades','medias.propiedad_id','propiedades.id')
                                    ->Join('tipoinmueble','propiedades.tipo_inmueble','tipoinmueble.id')
                                    ->Join('agentes','propiedades.agente_id','agentes.id')
                                    ->Join('urbanizaciones','propiedades.urbanizacion','urbanizaciones.id')
                                    ->select('medias.nombre as nombre_imagen','medias.propiedad_id','medias.id as id_imagen','propiedades.*','tipoinmueble.nombre as nombreInmueble','agentes.fullName as nombreAsesor','urbanizaciones.nombre as nombreUrbanizacion')
                                    ->where('medias.vista',1)
                                    ->paginate(30);

      $usuario=Session::get('asesor');
      $asesores=Agente::orderBy('fullName','asc')->get();
      $estados=Estado::join('propiedades','estados.id','propiedades.estado_id')
                    ->select('estados.*')
                    ->whereNotNull('propiedades.estado_id')
                    ->distinct()
                    ->orderBy('estados.nombre','asc')
                    ->get();
      $estatus=Estatus::where('familia',1)->get();
      return view('/admin/lista_inmuebles',$this->cargarSidebar(),compact('inmuebles','usuario','asesores','estados','estatus','arreglo'));
  }
  public function buscarInmueble(){
    $consulta=array();
    $arreglo=array();
    $contador=Request::get('codigo');
    if (strlen($contador)==6) {
      $arreglo['propiedades.id_mls']=Request::get('codigo');

    }
    else {
      $arreglo['propiedades.id']=Request::get('codigo');
    }
    $arreglo['propiedades.agente_id']=Request::get('asesor');
    $arreglo['propiedades.estatus']=Request::get('estatus');
    $arreglo['propiedades.estado_id']=Request::get('estatePropiety');
    $arreglo['propiedades.ciudad_id']=Request::get('cityPropiety');
    $arreglo['propiedades.urbanizacion']=Request::get('namePropiety');
    foreach ($arreglo as $key => $value) {
      if ($value!='') {
        $consulta[$key]=$value;
      }
    }
    //dd($arreglo);
    $inmuebles=DB::table('medias')->Join('propiedades','medias.propiedad_id','propiedades.id')
                                  ->Join('tipoinmueble','propiedades.tipo_inmueble','tipoinmueble.id')
                                  ->Join('agentes','propiedades.agente_id','agentes.id')
                                  ->Join('urbanizaciones','propiedades.urbanizacion','urbanizaciones.id')
                                  ->select('medias.nombre as nombre_imagen','medias.propiedad_id','medias.id as id_imagen','propiedades.*','tipoinmueble.nombre as nombreInmueble','agentes.fullName as nombreAsesor','urbanizaciones.nombre as nombreUrbanizacion')
                                  ->where('medias.vista',1)
                                  ->where($consulta)
                                  ->paginate(30);
    $inmuebles->withPath('?asesor='.$arreglo['propiedades.agente_id'].'&estatus='.$arreglo['propiedades.estatus'].'&estatePropiety='.$arreglo['propiedades.estado_id'].'&cityPropiety='.$arreglo['propiedades.ciudad_id'].'&namePropiety='.$arreglo['propiedades.urbanizacion'].'');
    $usuario=Session::get('asesor');
    $asesores=Agente::all();
    $estados=Estado::join('propiedades','estados.id','propiedades.estado_id')
                  ->select('estados.*')
                  ->whereNotNull('propiedades.estado_id')
                  ->distinct()
                  ->orderBy('estados.nombre','asc')
                  ->get();
    if ($arreglo['propiedades.estado_id']!='') {
      $ciudades=Ciudad::where('estado_id',$arreglo['propiedades.estado_id'])->get();
    }
    else {
      $ciudad=(object)[
        'id'=>'',
        'nombre'=>'',
        'estado_id'=>''
      ];
      $ciudades=collect([$ciudad]);
    }
    if ($arreglo['propiedades.ciudad_id']!='') {
      $urbanizaciones=Urbanizacion::where('ciudad_id',$arreglo['propiedades.ciudad_id'])->get();
    }
    else {
      $urbanizacion=(object)[
        'id'=>'',
        'nombre'=>'',
        'estado_id'=>''
      ];
      $urbanizaciones=collect([$urbanizacion]);
    }
    $estatus=Estatus::where('familia',1)->get();
    return view('/admin/lista_inmuebles',$this->cargarSidebar(),compact('inmuebles','usuario','asesores','estados','estatus','arreglo','ciudades','urbanizaciones'));
  }

  public function CrearInmueble1(){
    $datos=[];
    $consulta=[];
    $usuario=Session::get('asesor');
    $datos=Propiedad::where('cargado',0)->where('cargadoPor',$usuario->id)->first();
    if (count($datos)!=0) {
      $consulta=Ciudad::where('estado_id',$datos->estado_id)->orderBy('nombre','asc')->get();
      $urbanizaciones=Urbanizacion::where('ciudad_id',$datos->ciudad_id)->orderBy('nombre','asc')->get();
    }
    $tiposIn=TipoInmueble::all();
    $estados=Estado::orderBy('nombre','asc')->get();
    $asesores=Agente::orderBy('fullName','asc')->get();
    return view('/admin/crear_inmueble_1',$this->cargarSidebar(),compact('tiposIn','estados','asesores','datos','consulta','urbanizaciones'));
  }

  public function listarCiudades(){
    $estado=Request::get('estado');
    return $this->cargarCiudades($estado);
  }

  public function listarUrbanizaciones(){
    $ciudad=Request::get('ciudad');
    return $this->cargarUrbanizaciones($ciudad);
  }
  public function cargarPropiedad(){
    sleep(1);
    $usuario=Session::get('asesor');
    $proximoInforme=date('Y-m-d', strtotime('+1 month'));
    $inmuebleIncompleto=Request::get('register');
    if (empty($inmuebleIncompleto)==false) {
      $id=Request::get('register');
      Propiedad::where('id',$inmuebleIncompleto)->update([
                  "tipo_inmueble"       =>  (int)Request::get('typePropiety'),
                  "estado_id"           =>  (int)Request::get('estatePropiety'),
                  "ciudad_id"           =>  (int)Request::get('cityPropiety'),
                  "urbanizacion"        =>  (int)Request::get('namePropiety'),
                  "direccion"           =>  ucfirst(mb_strtolower(Request::get('addressPropiety'))),
                  "posicionMapa"        =>  Request::get('positionPropiety'),
                  "mostrarMapa"         =>  (int)Request::get('visibleMapa'),
                  "destacado"           =>  (int)Request::get('destacado'),
                  "visible"             =>  (int)Request::get('visiblePrice'),
                  "precio"              =>  Request::get('pricePropiety'),
                  "porcentajeCaptacion" =>  Request::get('porcentajeCaptacion'),
                  "referenciaDolares"   =>  Request::get('refDolares'),
                  "metros_construccion" =>  Request::get('constructionPropiety'),
                  "metros_terreno"      =>  Request::get('areaPropiety'),
                  "habitaciones"        =>  Request::get('roomPropiety'),
                  "banos"               =>  Request::get('batroomPropiety'),
                  "estacionamientos"    =>  Request::get('parkingPropiety'),
                  "comentario"          =>  ucfirst(mb_strtolower(Request::get('descriptionPropiety'))),
                  "agente_id"           =>  Request::get('asesorPropiety'),
                  "tipoNegocio"         =>  Request::get('typeBussisness'),
                  "cargadoPor"          =>  $usuario->id,
                  "estatus"             =>  1
                ]);
    }
    else {
      $id=DB::table('propiedades')->insertGetId([
                  "tipo_inmueble"       =>  (int)Request::get('typePropiety'),
                  "estado_id"           =>  (int)Request::get('estatePropiety'),
                  "ciudad_id"           =>  (int)Request::get('cityPropiety'),
                  "urbanizacion"        =>  (int)Request::get('namePropiety'),
                  "direccion"           =>  ucfirst(mb_strtolower(Request::get('addressPropiety'))),
                  "posicionMapa"        =>  Request::get('positionPropiety'),
                  "mostrarMapa"         =>  (int)Request::get('visibleMapa'),
                  "destacado"           =>  (int)Request::get('destacado'),
                  "visible"             =>  (int)Request::get('visiblePrice'),
                  "precio"              =>  Request::get('pricePropiety'),
                  "porcentajeCaptacion" =>  Request::get('porcentajeCaptacion'),
                  "referenciaDolares"   =>  Request::get('refDolares'),
                  "metros_construccion" =>  Request::get('constructionPropiety'),
                  "metros_terreno"      =>  Request::get('areaPropiety'),
                  "habitaciones"        =>  Request::get('roomPropiety'),
                  "banos"               =>  Request::get('batroomPropiety'),
                  "estacionamientos"    =>  Request::get('parkingPropiety'),
                  "comentario"          =>  ucfirst(mb_strtolower(Request::get('descriptionPropiety'))),
                  "agente_id"           =>  Request::get('asesorPropiety'),
                  "tipoNegocio"         =>  Request::get('typeBussisness'),
                  "cargadoPor"          =>  $usuario->id,
                  "estatus"             =>  1,
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
    $dominio=Request::get('dominio');
    $inmueble=Session::get($sesiones[$desicion]);
    $extension = mb_strtolower($archivo->getClientOriginalExtension());
    $renombre = uniqid().'.'.$extension;
    $path ="images/inmuebles";
    $rutaImagenBD=$dominio.$path.'/'.$renombre;
    //dd($rutaImagenBD);
    $consulta=Media::where('id',$idImagen)->first();
    if (count($consulta)!=0) {
      Media::where('id',$idImagen)->update([
        "nombre"        =>  $rutaImagenBD,
        "propiedad_id"  =>  $inmueble,
        "alias"         =>  $renombre
      ]);
      File::delete(public_path('/images/inmuebles/'.$consulta->alias));
      $archivo->move($path,$renombre);
    }
    else{
      $idImagen=DB::table('medias')->insertGetId([
                  "nombre"        =>  $rutaImagenBD,
                  "propiedad_id"  =>  $inmueble,
                  "alias"         =>  $renombre
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
      if ($consulta->vista==1) {
        $respuesta=2;
      }
      else{
        File::delete(public_path('/images/inmuebles/'.$consulta->alias));
        Media::destroy($imagen);
        $respuesta=1;
      }
    }
    return $respuesta;
  }

  public function CrearInmueble2(){
    $inmueble=Session::get('inmueble');
    $imagenes=Media::where('propiedad_id',$inmueble)->get();
    $ultimo=Media::where('propiedad_id',$inmueble)->orderBy('id', 'desc')->first();
    $propiedad=Propiedad::find($inmueble);
    return view('/admin/crear_inmueble_2',$this->cargarSidebar(),compact('imagenes','ultimo','propiedad'));
  }

  public function guardarInmueble(){
    $sesiones=['inmueble','inmuebleEdit'];
    $desicion=Request::get('desicion');
    $respuesta=0;
    $inmueble=Session::get($sesiones[$desicion]);
    $seleccionado=Request::get('imgSelected');
    $marcado=Media::where('propiedad_id',$inmueble)->where('vista',1)->first();
    $ultimo=Media::where('propiedad_id',$inmueble)->first();
    if ($desicion==0) {
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
              'cargado'=>1,
              'fechaCreado'=>date('Y-m-d')
            ]);
            Session::forget($sesiones[$desicion]);
            $respuesta=1;
          }
          else{
            $imgNew=Media::find($seleccionado);
            $imgNew->vista=1;
            $imgNew->save();
            Propiedad::where('id',$inmueble)->update([
              'cargado'=>1,
              'fechaCreado'=>date('Y-m-d')
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
              'cargado'=>1,
              'fechaCreado'=>date('Y-m-d')
            ]);
            Session::forget($sesiones[$desicion]);
            $respuesta=1;
          }
          else{
            $respuesta=2;//El elemento marcado no tiene imagen asociada
          }
        }
      }
    }
    else{
      if (count($ultimo)!=0) {
        if (count($marcado)!=0) {
          if ($marcado->id!=$seleccionado) {
            $img=Media::find($marcado->id);
            $img->vista=0;
            $img->save();
            $imgNew=Media::find($seleccionado);
            $imgNew->vista=1;
            $imgNew->save();
            Session::forget($sesiones[$desicion]);
            $respuesta=1;
          }
          else{
            $imgNew=Media::find($seleccionado);
            $imgNew->vista=1;
            $imgNew->save();
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

            Session::forget($sesiones[$desicion]);
            $respuesta=1;
          }
          else{
            $respuesta=2;//El elemento marcado no tiene imagen asociada
          }
        }
      }
    }
    
    return $respuesta;
  }


  public function DetalleInmueble($id){
    $usuario=Session::get('asesor');
    $negociacion=DB::table('negociaciones')->join('estatus','negociaciones.estatus','estatus.id')
                                           ->where('negociaciones.propiedad_id',$id)
                                           ->select('negociaciones.*','estatus.descripcionEstatus')
                                           ->orderBy('id','desc')
                                           ->first();
    if ($negociacion==null) {
      $negociacion=(object)[
             "asesorCaptador"       => "",
             "asesorCerrador"       => "",
             "precioFinal"          => "",
             "porcentajeCaptacion"  => "",
             "porcentajeCierre"     => "",
            "porcentajeCompartido"  => "",
            "compartidoCon"         => "",
             "comisionBruta"        => "",
             "pagoCasaMatriz"       => "",
             "ingresoNeto"          => "",
             "fechaCreacion"        => "",
             "descripcionEstatus"   => ""
           ];
    }
    $inmueble=DB::table('propiedades')->join('tipoinmueble','propiedades.tipo_inmueble','tipoinmueble.id')
                                       ->join('agentes','propiedades.agente_id','agentes.id')
                                       ->join('estados','propiedades.estado_id','estados.id')
                                       ->join('ciudades','propiedades.ciudad_id','ciudades.id')
                                       ->join('urbanizaciones','propiedades.urbanizacion','urbanizaciones.id')
                                       ->join('estatus','propiedades.estatus','estatus.id')
                                       ->select('propiedades.*','agentes.fullname','estados.nombre as nombre_estado','ciudades.nombre as nombre_ciudad','tipoinmueble.id as idTipo', 'tipoinmueble.nombre as nombreTipo','urbanizaciones.nombre as nombreUrbanizacion','estatus.descripcionEstatus')
                                       ->where('propiedades.id',$id)
                                       ->first();
   $fecha=date("d-m-Y", strtotime($inmueble->proximoInforme));
   $datetime1 = date_create($inmueble->proximoInforme);
   $datetime2 = date_create();
   $diaTranscurrido= date_diff($datetime1, $datetime2);
   $dia=$diaTranscurrido->format('%R%a días');

    $imagen=Media::where('propiedad_id',$id)->where('vista',1)->first();
    $informes=Informe::where('propiedad_id',$id)->orderBy('id','DESC')->get();
    return view('/admin/detalle_inmueble',$this->cargarSidebar(),compact('inmueble','usuario','negociacion','imagen','informes','dia','fecha'));
  }

  public function mostrarEditarInmueble1($id){
    Session::forget('inmuebleEdit');
    $propiedad=Propiedad::where('id',$id)->first();
    $tiposIn=TipoInmueble::all();
    $estados=Estado::all();
    $asesores=Agente::orderBy('fullName','asc')->get();
    $consulta=Ciudad::where('estado_id',$propiedad->estado_id)->orderBy('nombre','asc')->get();
    $urbanizaciones=Urbanizacion::where('ciudad_id',$propiedad->ciudad_id)->orderBy('nombre','asc')->get();
    $estatus=Estatus::where('familia',1)->where('id','<>','11')->get();
    return view('/admin/editar_inmueble_1',$this->cargarSidebar(),compact('tiposIn','estados','asesores','consulta','propiedad','urbanizaciones','estatus'));
  }

  public function actualizarInmueble1(){
    sleep(1);
    $id=Request::get('register');
    $consulta=Negociacion::where('estatus','<>',9)->where('propiedad_id',$id)->first();
    if (count($consulta)==0) {
      Propiedad::where('id',$id)->update([
        "tipo_inmueble"       =>  (int)Request::get('typePropiety'),
        "estado_id"           =>  (int)Request::get('estatePropiety'),
        "ciudad_id"           =>  (int)Request::get('cityPropiety'),
        "urbanizacion"        =>  (int)Request::get('namePropiety'),
        "direccion"           =>  ucfirst(mb_strtolower(Request::get('addressPropiety'))),
        "posicionMapa"        =>  Request::get('positionPropiety'),
        "mostrarMapa"         =>  (int)Request::get('visibleMapa'),
        "destacado"           =>  (int)Request::get('destacado'),
        "visible"             =>  (int)Request::get('visiblePrice'),
        "precio"              =>  Request::get('pricePropiety'),
        "porcentajeCaptacion" =>  Request::get('porcentajeCaptacion'),
        "referenciaDolares"   =>  Request::get('refDolares'),
        "metros_construccion" =>  Request::get('constructionPropiety'),
        "metros_terreno"      =>  Request::get('areaPropiety'),
        "habitaciones"        =>  Request::get('roomPropiety'),
        "banos"               =>  Request::get('batroomPropiety'),
        "estacionamientos"    =>  Request::get('parkingPropiety'),
        "comentario"          =>  ucfirst(mb_strtolower(Request::get('descriptionPropiety'))),
        "agente_id"           =>  Request::get('asesorPropiety'),
        "tipoNegocio"         =>  Request::get('typeBussisness'),
        "estatus"             =>  Request::get('estatusPropiedad')
      ]);
      $respuesta=[1,$id];
    }
    else{
      $respuesta=[2,$id];
    }


    Session::put('inmuebleEdit',$id);
    return $respuesta;
  }

  public function mostrarEditarInmueble2(){
    $inmueble=Session::get('inmuebleEdit');
    $imagenes=Media::where('propiedad_id',$inmueble)->get();
    $ultimo=Media::where('propiedad_id',$inmueble)->orderBy('id', 'desc')->first();
    $propiedad=Propiedad::find($inmueble);
    return view('/admin/editar_inmueble_2',$this->cargarSidebar(),compact('inmueble','imagenes','ultimo','propiedad'));
  }

  public function borrarInmueble(){
    $idInmueble=Request::get('id');
///////////////////////////////  Borrar informes del Inmueble /////////////////////////////////////////

    Informe::where('propiedad_id',$idInmueble)->delete();

///////////////////////////////////////////////  Borrar Negociaciones y etapas de negociaciones /////////////////////////////////////////////////
    $negociaciones=Negociacion::where('propiedad_id',$idInmueble)->get();
      if (count($negociaciones)!=0) {
        foreach ($negociaciones as $negociacion) {
            NegociacionEstatus::where('negociacion_id',$negociacion->id)->delete();
            Negociacion::destroy($negociacion->id);
        }
      }
///////////////////////////////  Borrar asociacion entre comprador e inmueble /////////////////////////////////////////

    CompradorPropiedades::where('propiedad_id',$idInmueble)->delete();
    $respuesta=1;

///////////////////////////////  Borrar fotos del inmueble /////////////////////////////////////////
    $imagenes=Media::where('propiedad_id',$idInmueble)->get();
    foreach ($imagenes as $imagen) {
      File::delete(public_path('images/inmuebles/'.$imagen->alias.''));
      Media::destroy($imagen->id);
    }
///////////////////////////////  Borrar inmueble /////////////////////////////////////////
    Propiedad::destroy($idInmueble);
    $respuesta=1;
    return $respuesta;
  }
}
