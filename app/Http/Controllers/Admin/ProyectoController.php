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
use App\Models\Agente;
use App\Models\MediaProyecto;
use App\Models\Proyecto;
use App\Models\TipoInmuebleProyecto;
use App\Models\InmuebleProyecto;

class ProyectoController extends Controller{

  public function ListaProyectos(){
        $proyectos=DB::table('mediaProyectos')->Join('proyectos','mediaProyectos.proyecto_id','proyectos.id')
                                           ->select('mediaProyectos.nombre as nombre_imagen','mediaProyectos.proyecto_id','mediaProyectos.id as id_imagen','proyectos.*')
                                           ->where('mediaProyectos.vista',1)
                                           ->paginate(30);

      return view('/admin/lista_proyectos',$this->cargarSidebar(),compact('proyectos'));
  }

  public function CrearProyecto1(){
    $datos=[];
    $consulta=[];
    $usuario=Session::get('asesor');
    $datos=Proyecto::where('cargado',0)->where('cargadoPor',$usuario->id)->first();
    if (count($datos)!=0) {
      $consulta=Ciudad::where('estado_id',$datos->estado_id)->get();
    }
    $estados=Estado::all();
    return view('/admin/crear_proyecto_1',$this->cargarSidebar(),compact('estados','datos','consulta'));
  }

  public function cargarProyecto1(){
    $usuario=Session::get('asesor');
    $inmuebleIncompleto=Request::get('register');
    if (empty($inmuebleIncompleto)==false) {
      $id=Request::get('register');
      Proyecto::where('id',$inmuebleIncompleto)->update([
                  "tipoNegocio"         =>  Request::get('typeBussisness'),
                  "nombreProyecto"      =>  Request::get('nameProyect'),
                  "metrosConstruccion"  =>  Request::get('constructionProyect'),
                  "fechaEntrega"        =>  Request::get('dateEnd'),
                  "descripcionProyecto" =>  Request::get('descriptionProyect'),
                  "estado_id"           =>  Request::get('estateProyect'),
                  "ciudad_id"           =>  Request::get('cityProyect'),
                  "direccionProyecto"   =>  Request::get('addressProyect'),
                  "posicionMapa"        =>  Request::get('positionPropiety'),
                  "cargadoPor"          =>  $usuario->id
                ]);
    }
    else {
      $id=DB::table('proyectos')->insertGetId([
        "tipoNegocio"         =>  Request::get('typeBussisness'),
        "nombreProyecto"      =>  Request::get('nameProyect'),
        "metrosConstruccion"  =>  Request::get('constructionProyect'),
        "fechaEntrega"        =>  Request::get('dateEnd'),
        "descripcionProyecto" =>  Request::get('descriptionProyect'),
        "estado_id"           =>  Request::get('estateProyect'),
        "ciudad_id"           =>  Request::get('cityProyect'),
        "direccionProyecto"   =>  Request::get('addressProyect'),
        "posicionMapa"        =>  Request::get('positionPropiety'),
        "cargadoPor"          =>  $usuario->id
      ]);
    }
    Session::put('proyecto',$id);
    return compact('id');
  }

  public function CrearProyecto2(){
    $consulta=DB::table('inmuebleProyectos')->Join('tipoInmuebleProyectos','inmuebleProyectos.tipoinmueble_id','tipoInmuebleProyectos.id')
                                            ->select('tipoInmuebleProyectos.nombre as nombreTipoInmueble','inmuebleProyectos.*')
                                            ->where('inmuebleProyectos.proyecto_id',Session::get('proyecto'))
                                            ->get();
    $inmuebles=TipoInmuebleProyecto::all();
    return view('/admin/crear_proyecto_2',$this->cargarSidebar(),compact('inmuebles','consulta'));
  }

  public function cargarInmuebleProyectos(){
    $resultado=0;
    $proyecto=Request::get('register');
    $tipoInmueble=Request::get('typeProyect');
    $tipoInmuebleExiste=InmuebleProyecto::where('tipoinmueble_id',$tipoInmueble)
                                        ->where('proyecto_id',$proyecto)
                                        ->first();
    if (count($tipoInmuebleExiste)==0) {
      $id=DB::table('inmuebleProyectos')->insertGetId([
        "tipoinmueble_id"         =>  Request::get('typeProyect'),
        "cantidad"                =>  Request::get('quantityProyect'),
        "precio"                  =>  Request::get('priceProyect'),
        "visible"                 =>  Request::get('visiblePrice'),
        "metrosConstruccion"      =>  Request::get('construction'),
        "habitaciones"            =>  Request::get('roomProyect'),
        "banos"                   =>  Request::get('batroomProyect'),
        "estacionamientos"        =>  Request::get('parkingProyect'),
        "descripcionInmueble"     =>  Request::get('descriptionProyect'),
        "proyecto_id"             =>  Request::get('register')
      ]);
      $consulta=DB::table('inmuebleProyectos')->Join('tipoInmuebleProyectos','inmuebleProyectos.tipoinmueble_id','tipoInmuebleProyectos.id')
                                              ->select('tipoInmuebleProyectos.nombre as nombreTipoInmueble','inmuebleProyectos.*')
                                              ->where('inmuebleProyectos.proyecto_id',$proyecto)
                                              ->get();
      $resultado=view('/admin/partials/tipoInmueble',$this->cargarSidebar(),compact('consulta'));
    }

    return $resultado;
  }
  public function borrarInmuebleProyectos(){
    $proyecto=Request::get('register');
    $inmueble=InmuebleProyecto::find(Request::get('id'));
    $inmueble->delete();
    $consulta=DB::table('inmuebleProyectos')->Join('tipoInmuebleProyectos','inmuebleProyectos.tipoinmueble_id','tipoInmuebleProyectos.id')
                                            ->select('tipoInmuebleProyectos.nombre as nombreTipoInmueble','inmuebleProyectos.*')
                                            ->where('inmuebleProyectos.proyecto_id',$proyecto)
                                            ->get();
    $resultado=view('/admin/partials/tipoInmueble',$this->cargarSidebar(),compact('consulta'));
    return $resultado;
  }

  public function evaluarInmueble(){
    $respuesta=0;
    $inmuebles=InmuebleProyecto::where('proyecto_id',Request::get('id'))->first();
    if (count($inmuebles)!=0){
      $respuesta=1;
    }
    return $respuesta;
  }

  public function CrearProyecto3(){
    $proyecto=Session::get('proyecto');
    $imagenes=MediaProyecto::where('proyecto_id',$proyecto)->get();
    $ultimo=MediaProyecto::where('proyecto_id',$proyecto)->orderBy('id', 'desc')->first();
    return view('/admin/crear_proyecto_3',$this->cargarSidebar(),compact('imagenes','ultimo'));
  }

  public function guardarImagenProyecto(){
    $sesiones=['proyecto','proyectoEdit'];
    $desicion=Request::get('desicion');
    $archivo= Request::file('file');
    $ubicacion=Request::get('register');
    $idImagen=Request::get('valor');
    $inmueble=Session::get($sesiones[$desicion]);
    $extension = strtolower($archivo->getClientOriginalExtension());
    $renombre = uniqid().'.'.$extension;
    $path ="images/proyectos";
    $consulta=MediaProyecto::where('id',$idImagen)->first();
    if (count($consulta)!=0) {
      MediaProyecto::where('id',$idImagen)->update([
        "nombre"        =>  $renombre,
        "proyecto_id"  =>  $inmueble
      ]);
      File::delete(public_path('images/proyectos/'.$consulta->nombre.''));
      $archivo->move($path,$renombre);
    }
    else{
      $idImagen=DB::table('mediaProyectos')->insertGetId([
                  "nombre"        =>  $renombre,
                  "proyecto_id"  =>  $inmueble
      ]);
      $archivo->move($path,$renombre);
    }
    $datos=[$ubicacion,$idImagen];
    return $datos;
  }

  public function borrarImagenProyecto(){
    $sesiones=['proyecto','proyectoEdit'];
    $desicion=Request::get('desicion');
    $respuesta=0;
    $inmueble=Session::get($sesiones[$desicion]);
    $imagen= Request::get('registro');
    $consulta=MediaProyecto::where('id',$imagen)->where('proyecto_id',$inmueble)->first();
    if (count($consulta)!=0) {
      File::delete(public_path('images/proyectos/'.$consulta->nombre.''));
      MediaProyecto::destroy($imagen);
      $respuesta=1;
    }

    return $respuesta;
  }


  public function guardarProyecto(){
    $sesiones=['proyecto','proyectoEdit'];
    $desicion=Request::get('desicion');
    $respuesta=0;
    $inmueble=Session::get($sesiones[$desicion]);
    $seleccionado=Request::get('imgSelected');
    $marcado=MediaProyecto::where('proyecto_id',$inmueble)->where('vista',1)->first();
    $ultimo=MediaProyecto::where('proyecto_id',$inmueble)->first();

    if (count($ultimo)!=0) {
      if (count($marcado)!=0) {
        if ($marcado->id!=$seleccionado) {
          $img=MediaProyecto::find($marcado->id);
          $img->vista=0;
          $img->save();
          $imgNew=MediaProyecto::find($seleccionado);
          $imgNew->vista=1;
          $imgNew->save();
          Proyecto::where('id',$inmueble)->update([
            'cargado'=>1
          ]);
          Session::forget($sesiones[$desicion]);
          $respuesta=1;
        }
        else{
          $imgNew=MediaProyecto::find($seleccionado);
          $imgNew->vista=1;
          $imgNew->save();
          Proyecto::where('id',$inmueble)->update([
            'cargado'=>1
          ]);
          Session::forget($sesiones[$desicion]);
          $respuesta=1;
        }
      }
      else {
        $consulta=MediaProyecto::where('id',$seleccionado)->first();
        if (count($consulta)!=0) {
          $imgNew=MediaProyecto::find($seleccionado);
          $imgNew->vista=1;
          $imgNew->save();
          Proyecto::where('id',$inmueble)->update([
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
