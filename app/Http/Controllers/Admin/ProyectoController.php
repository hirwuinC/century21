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
use App\Models\Estatus;
use App\Models\MediaProyecto;
use App\Models\Proyecto;
use App\Models\TipoInmuebleProyecto;
use App\Models\InmuebleProyecto;

class ProyectoController extends Controller{

  public function ListaProyectos(){
    $data=\Request::get('data');
    $arreglo=array();
      if ($data) {
        $proyectos=DB::table('mediaproyectos')->Join('proyectos','mediaproyectos.proyecto_id','proyectos.id')
                                           ->select('mediaproyectos.nombre as nombre_imagen','mediaproyectos.proyecto_id','mediaproyectos.id as id_imagen','proyectos.*')
                                           ->where('mediaproyectos.vista',1)
                                           ->where('proyectos.id',$data)
                                           ->paginate(30);
      }
      else{
        $proyectos=DB::table('mediaproyectos')->Join('proyectos','mediaproyectos.proyecto_id','proyectos.id')
                                           ->select('mediaproyectos.nombre as nombre_imagen','mediaproyectos.proyecto_id','mediaproyectos.id as id_imagen','proyectos.*')
                                           ->where('mediaproyectos.vista',1)
                                           ->paginate(30);
      }


       $usuario=Session::get('asesor');
       $asesores=Agente::orderBy('fullName','asc')->get();
       $estados=Estado::all();
      return view('/admin/lista_proyectos',$this->cargarSidebar(),compact('proyectos','arreglo','estados','usuario'));
  }

  public function buscarProyecto(){
    $consulta=array();
    $arreglo=array();
    $arreglo['proyectos.estado_id']=Request::get('estatePropiety');
    $arreglo['proyectos.ciudad_id']=Request::get('cityPropiety');
    foreach ($arreglo as $key => $value) {
      if ($value!='') {
        $consulta[$key]=$value;
      }
    }
    //dd($arreglo);
    $proyectos=DB::table('mediaproyectos')->Join('proyectos','mediaproyectos.proyecto_id','proyectos.id')
                                          ->select('mediaproyectos.nombre as nombre_imagen','mediaproyectos.proyecto_id','mediaproyectos.id as id_imagen','proyectos.*')
                                          ->where('mediaproyectos.vista',1)
                                          ->where($consulta)
                                          ->paginate(30);
    $proyectos->withPath('?estatePropiety='.$arreglo['proyectos.estado_id'].'&cityPropiety='.$arreglo['proyectos.ciudad_id'].'');
    $usuario=Session::get('asesor');
    $estados=Estado::all();
    if ($arreglo['proyectos.estado_id']!='') {
      $ciudades=Ciudad::where('estado_id',$arreglo['proyectos.estado_id'])->get();
    }
    else {
      $ciudad=(object)[
        'id'=>'',
        'nombre'=>'',
        'estado_id'=>''
      ];
      $ciudades=collect([$ciudad]);
    }
    //dd($arreglo);
    return view('/admin/lista_proyectos',$this->cargarSidebar(),compact('proyectos','usuario','estados','arreglo','ciudades'));
  }

  public function buscarProyectoCodigo(){
   $var =\Request::get('data');
   $result=Proyecto::searchProyecto($var)->get();
   return response()->json($result);
  }

  public function CrearProyecto1(){
    $datos=[];
    $consulta=[];
    $usuario=Session::get('asesor');
    $datos=Proyecto::where('cargado',0)->where('cargadoPor',$usuario->id)->first();
    if (count($datos)!=0) {
      $consulta=Ciudad::where('estado_id',$datos->estado_id)->orderBy('nombre','asc')->get();
    }
    else{
      $datos=(object)[
        "id"                  =>  '',
        "tipoNegocio"         =>  '',
        "nombreProyecto"      =>  '',
        "metrosConstruccion"  =>  '',
        "fechaEntrega"        =>  '',
        "descripcionProyecto" =>  '',
        "estado_id"           =>  '',
        "ciudad_id"           =>  '',
        "direccionProyecto"   =>  '',
        "posicionMapa"        =>  '',
        "destacado"           =>  '',
        "cargadoPor"          =>  ''
            ];
    }
    //dd($datos);
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
                  "nombreProyecto"      =>  ucwords(mb_strtolower(Request::get('nameProyect'))),
                  "metrosConstruccion"  =>  Request::get('constructionProyect'),
                  "fechaEntrega"        =>  Request::get('dateEnd'),
                  "descripcionProyecto" =>  ucfirst(mb_strtolower(Request::get('descriptionProyect'))),
                  "estado_id"           =>  Request::get('estateProyect'),
                  "ciudad_id"           =>  Request::get('cityProyect'),
                  "direccionProyecto"   =>  Request::get('addressProyect'),
                  "posicionMapa"        =>  Request::get('positionPropiety'),
                  "destacado"           =>  Request::get('destacado'),
                  "cargadoPor"          =>  $usuario->id
                ]);
    }
    else {
      $id=DB::table('proyectos')->insertGetId([
        "tipoNegocio"         =>  Request::get('typeBussisness'),
        "nombreProyecto"      =>  ucwords(mb_strtolower(Request::get('nameProyect'))),
        "metrosConstruccion"  =>  Request::get('constructionProyect'),
        "fechaEntrega"        =>  Request::get('dateEnd'),
        "descripcionProyecto" =>  ucfirst(mb_strtolower(Request::get('descriptionProyect'))),
        "estado_id"           =>  Request::get('estateProyect'),
        "ciudad_id"           =>  Request::get('cityProyect'),
        "direccionProyecto"   =>  ucfirst(mb_strtolower(Request::get('addressProyect'))),
        "posicionMapa"        =>  Request::get('positionPropiety'),
        "destacado"           =>  Request::get('destacado'),
        "cargadoPor"          =>  $usuario->id
      ]);
    }
    Session::put('proyecto',$id);
    return compact('id');
  }

  public function CrearProyecto2(){
    $consulta=DB::table('inmuebleproyectos')->Join('tipoinmuebleproyectos','inmuebleproyectos.tipoinmueble_id','tipoinmuebleproyectos.id')
                                            ->select('tipoinmuebleproyectos.nombre as nombreTipoInmueble','inmuebleproyectos.*')
                                            ->where('inmuebleproyectos.proyecto_id',Session::get('proyecto'))
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
      $id=DB::table('inmuebleproyectos')->insertGetId([
        "tipoinmueble_id"         =>  Request::get('typeProyect'),
        "cantidad"                =>  Request::get('quantityProyect'),
        "precio"                  =>  Request::get('priceProyect'),
        "visible"                 =>  Request::get('visiblePrice'),
        "metrosConstruccion"      =>  Request::get('construction'),
        "habitaciones"            =>  Request::get('roomProyect'),
        "banos"                   =>  Request::get('batroomProyect'),
        "estacionamientos"        =>  Request::get('parkingProyect'),
        "descripcionInmueble"     =>  ucfirst(mb_strtolower(Request::get('descriptionProyect'))),
        "proyecto_id"             =>  Request::get('register')
      ]);
      $consulta=DB::table('inmuebleproyectos')->Join('tipoinmuebleproyectos','inmuebleproyectos.tipoinmueble_id','tipoinmuebleproyectos.id')
                                              ->select('tipoinmuebleproyectos.nombre as nombreTipoInmueble','inmuebleproyectos.*')
                                              ->where('inmuebleproyectos.proyecto_id',$proyecto)
                                              ->get();
      $resultado=view('/admin/partials/tipoInmueble',compact('consulta'));
    }

    return $resultado;
  }
  public function borrarInmuebleProyectos(){
    $proyecto=Request::get('register');
    $inmueble=InmuebleProyecto::find(Request::get('id'));
    $inmueble->delete();
    $consulta=DB::table('inmuebleproyectos')->Join('tipoinmuebleproyectos','inmuebleproyectos.tipoinmueble_id','tipoinmuebleproyectos.id')
                                            ->select('tipoinmuebleproyectos.nombre as nombreTipoInmueble','inmuebleproyectos.*')
                                            ->where('inmuebleproyectos.proyecto_id',$proyecto)
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
      $idImagen=DB::table('mediaproyectos')->insertGetId([
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
      if ($consulta->vista==1) {
        $respuesta=2;
      }
      else{
      File::delete(public_path('images/proyectos/'.$consulta->nombre.''));
      MediaProyecto::destroy($imagen);
      $respuesta=1;
      }
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

  public function detalleProyecto($id){
    $proyecto=DB::table('proyectos')->join('mediaproyectos','proyectos.id','mediaproyectos.proyecto_id')
                                     ->join('estados','proyectos.estado_id','=','estados.id')
                                     ->join('ciudades','proyectos.ciudad_id','=','ciudades.id')
                                     ->select('proyectos.*','mediaproyectos.nombre as nombre_imagen','estados.nombre as nombre_estado','ciudades.nombre as nombre_ciudad')
                                     ->where('proyectos.id',$id)
                                     ->where('mediaproyectos.vista',1)
                                     ->where('mediaproyectos.proyecto_id',$id)
                                     ->first();

    $inmuebles=DB::table('inmuebleproyectos')->join('tipoinmuebleproyectos','inmuebleproyectos.tipoinmueble_id','tipoinmuebleproyectos.id')
                                             ->select('inmuebleproyectos.*','tipoinmuebleproyectos.nombre as nombre_tipo')
                                             ->where('inmuebleproyectos.proyecto_id',$id)
                                             ->get();

    return view('/admin/detalle_proyecto',$this->cargarSidebar(),compact('inmuebles','proyecto'));
  }

  public function editarProyecto1($id){
    Session::forget('proyectoEdit');
    $proyecto=Proyecto::where('id',$id)->first();
    $estados=Estado::all();
    $consulta=Ciudad::where('estado_id',$proyecto->estado_id)->get();
    return view('/admin/editar_proyecto_1',$this->cargarSidebar(),compact('estados','consulta','proyecto'));
  }

  public function actualizarProyecto1(){
    $id=Request::get('register');
    Proyecto::where('id',$id)->update([
                "tipoNegocio"         =>  Request::get('typeBussisness'),
                "nombreProyecto"      =>  ucwords(mb_strtolower(Request::get('nameProyect'))),
                "metrosConstruccion"  =>  Request::get('constructionProyect'),
                "fechaEntrega"        =>  Request::get('dateEnd'),
                "descripcionProyecto" =>  ucfirst(mb_strtolower(Request::get('descriptionProyect'))),
                "estado_id"           =>  Request::get('estateProyect'),
                "ciudad_id"           =>  Request::get('cityProyect'),
                "direccionProyecto"   =>  ucfirst(mb_strtolower(Request::get('addressProyect'))),
                "posicionMapa"        =>  Request::get('positionPropiety'),
                "destacado"           =>  Request::get('destacado'),
              ]);
    $respuesta=$id;
    Session::put('proyectoEdit',$id);
    return Session::get('proyectoEdit');
  }
  public function editarProyecto2($id){
    $proyecto=$id;
    $consulta=DB::table('inmuebleproyectos')->Join('tipoinmuebleproyectos','inmuebleproyectos.tipoinmueble_id','tipoinmuebleproyectos.id')
                                            ->select('tipoinmuebleproyectos.nombre as nombreTipoInmueble','inmuebleproyectos.*')
                                            ->where('inmuebleproyectos.proyecto_id',$id)
                                            ->get();
    $inmuebles=TipoInmuebleProyecto::all();
    return view('/admin/editar_proyecto_2',$this->cargarSidebar(),compact('inmuebles','consulta','proyecto'));
  }

  public function editarProyecto3(){
    $proyecto=Session::get('proyectoEdit');
    $imagenes=MediaProyecto::where('proyecto_id',$proyecto)->get();
    $ultimo=MediaProyecto::where('proyecto_id',$proyecto)->orderBy('id', 'desc')->first();
    return view('/admin/editar_proyecto_3',$this->cargarSidebar(),compact('imagenes','ultimo'));

  }
  public function prueba(){
        return Session::get('proyectoEdit');
  }
}
