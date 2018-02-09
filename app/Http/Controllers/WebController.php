<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Propiedad;
use App\Models\Media;
use Illuminate\Support\Facades\DB;
class WebController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $inmuebles=DB::table('medias')->Join('propiedades','medias.propiedad_id','propiedades.id')
                                           ->select('medias.nombre as nombre_imagen','medias.propiedad_id','medias.id as id_imagen','propiedades.*')
                                           ->where('medias.vista',1)
                                           ->where('destacado',1)
                                           ->inRandomOrder()
                                           ->get()
                                           ->take(30);
                                           
     $proyectos=DB::table('proyectos')->Join('mediaProyectos','proyectos.id','mediaProyectos.proyecto_id')
                                           ->join('ciudades','proyectos.ciudad_id','ciudades.id')
                                           ->select('mediaProyectos.nombre as nombre_imagen','mediaProyectos.proyecto_id','mediaProyectos.id as id_imagen','proyectos.*','ciudades.nombre as nombre_ciudad')
                                           ->where('mediaProyectos.vista',1)
                                           ->where('destacado',1)
                                           ->inRandomOrder()
                                           ->get()
                                           ->take(3);
     return view('home',compact('inmuebles','proyectos'));

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function buscador()
    {
        return view('buscador');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function lista_proyectos()
    {
        return view('lista_proyectos');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function detalle_inmueble($id)
    {
      $contVisita = Propiedad::find($id);
      $contVisita->visitas =$contVisita->visitas+1;
      $contVisita->save();
      $inmueble=DB::table('propiedades')->join('tipoInmueble','propiedades.tipo_inmueble','=','tipoInmueble.id')
                                         ->join('agentes','propiedades.agente_id','=','agentes.id')
                                         ->join('estados','propiedades.estado_id','=','estados.id')
                                         ->join('ciudades','propiedades.ciudad_id','=','ciudades.id')
                                         ->select('propiedades.*','agentes.fullname','estados.nombre as nombre_estado','ciudades.nombre as nombre_ciudad','tipoInmueble.*')
                                         ->where('propiedades.id',$id)
                                         ->first();
      $imagenes=Media::where('propiedad_id',$id)->get();
      $destacados=DB::table('medias')->Join('propiedades','medias.propiedad_id','propiedades.id')
                                     ->select('medias.nombre as nombre_imagen','medias.propiedad_id','medias.id as id_imagen','propiedades.*')
                                     ->where('medias.vista',1)
                                     ->inRandomOrder()
                                     ->get()
                                     ->take(3);
      //return $destacados;
      return view('detalle_inmueble',compact('inmueble','imagenes','destacados'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function detalle_proyecto()
    {

      return view('detalle_proyecto');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function contacto()
    {
        return view('contacto');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function nuestra_historia()
    {
        return view('nuestra_historia');
    }

}
