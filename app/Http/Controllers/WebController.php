<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Models\Propiedad;
use App\Models\Media;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
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
                                   ->join('tipoinmueble','propiedades.tipo_inmueble','tipoinmueble.id')
                                   ->join('ciudades','propiedades.ciudad_id','ciudades.id')
                                   ->select('medias.nombre as nombre_imagen','medias.propiedad_id','medias.id as id_imagen','propiedades.*','ciudades.nombre as nombreCiudad','tipoinmueble.nombre as nombreInmueble')
                                   ->where('medias.vista',1)
                                   ->where('destacado',1)
                                   ->inRandomOrder()
                                   ->get()
                                   ->take(30);

     $proyectos=DB::table('proyectos')->Join('mediaproyectos','proyectos.id','mediaproyectos.proyecto_id')
                                           ->join('ciudades','proyectos.ciudad_id','ciudades.id')
                                           ->select('mediaproyectos.nombre as nombre_imagen','mediaproyectos.proyecto_id','mediaproyectos.id as id_imagen','proyectos.*','ciudades.nombre as nombre_ciudad')
                                           ->where('mediaproyectos.vista',1)
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
      $propiedad=Request::get('propiedad');
      $proyectos=DB::table('proyectos')->Join('mediaproyectos','proyectos.id','mediaproyectos.proyecto_id')
                                            ->join('ciudades','proyectos.ciudad_id','ciudades.id')
                                            ->select('mediaproyectos.nombre as nombre_imagen','mediaproyectos.proyecto_id','mediaproyectos.id as id_imagen','proyectos.*','ciudades.nombre as nombre_ciudad')
                                            ->where('mediaproyectos.vista',1)
                                            ->where('destacado',1)
                                            ->inRandomOrder()
                                            ->get()
                                            ->take(3);
      $inmuebles=DB::table('medias')->Join('propiedades','medias.propiedad_id','propiedades.id')
                                   ->join('tipoinmueble','propiedades.tipo_inmueble','tipoinmueble.id')
                                   ->join('ciudades','propiedades.ciudad_id','ciudades.id')
                                   ->select('medias.nombre as nombre_imagen','medias.propiedad_id','medias.id as id_imagen','propiedades.*','ciudades.nombre as nombreCiudad','tipoinmueble.nombre as nombreInmueble')
                                   ->where('medias.vista',1)
                                   ->where('destacado',1)
                                   ->where(['tipo_inmueble'=>$propiedad,'tipoNegocio'=>'venta'])
                                   ->inRandomOrder()
                                   ->paginate(10);
      return view('buscador',compact('proyectos','inmuebles'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function lista_proyectos()
    {
      $proyectos=DB::table('proyectos')->Join('mediaproyectos','proyectos.id','mediaproyectos.proyecto_id')
                                            ->join('ciudades','proyectos.ciudad_id','ciudades.id')
                                            ->select('mediaproyectos.nombre as nombre_imagen','mediaproyectos.proyecto_id','mediaproyectos.id as id_imagen','proyectos.*','ciudades.nombre as nombre_ciudad')
                                            ->where('mediaproyectos.vista',1)
                                            ->where('destacado',1)
                                            ->paginate(10);
        return view('lista_proyectos',compact('proyectos'));
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
      $inmueble=DB::table('propiedades')->join('tipoinmueble','propiedades.tipo_inmueble','tipoinmueble.id')
                                         ->join('urbanizaciones','propiedades.urbanizacion','urbanizaciones.id')
                                         ->join('estados','propiedades.estado_id','estados.id')
                                         ->join('ciudades','propiedades.ciudad_id','ciudades.id')
                                         ->select('propiedades.*','urbanizaciones.nombre as nombre_urbanizacion','estados.nombre as nombre_estado','ciudades.nombre as nombre_ciudad','tipoinmueble.nombre as nombre_tipo')
                                         ->where('propiedades.id',$id)
                                         ->first();
      $imagenes=Media::where('propiedad_id',$id)->get();
      $inmuebles=DB::table('medias')->Join('propiedades','medias.propiedad_id','propiedades.id')
                                     ->join('tipoinmueble','propiedades.tipo_inmueble','tipoinmueble.id')
                                     ->join('ciudades','propiedades.ciudad_id','ciudades.id')
                                     ->select('medias.nombre as nombre_imagen','medias.propiedad_id','medias.id as id_imagen','propiedades.*','ciudades.nombre as nombreCiudad','tipoinmueble.nombre as nombreInmueble')
                                     ->where('medias.vista',1)
                                     ->inRandomOrder()
                                     ->get()
                                     ->take(3);
      //return $destacados;
      return view('detalle_inmueble',compact('inmueble','imagenes','inmuebles'));
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
      $proyectos=DB::table('proyectos')->Join('mediaproyectos','proyectos.id','mediaproyectos.proyecto_id')
                                            ->join('ciudades','proyectos.ciudad_id','ciudades.id')
                                            ->select('mediaproyectos.nombre as nombre_imagen','mediaproyectos.proyecto_id','mediaproyectos.id as id_imagen','proyectos.*','ciudades.nombre as nombre_ciudad')
                                            ->where('mediaproyectos.vista',1)
                                            ->where('destacado',1)
                                            ->inRandomOrder()
                                            ->get()
                                            ->take(3);
      $inmuebles=DB::table('medias')->Join('propiedades','medias.propiedad_id','propiedades.id')
                                     ->join('tipoinmueble','propiedades.tipo_inmueble','tipoinmueble.id')
                                     ->join('ciudades','propiedades.ciudad_id','ciudades.id')
                                     ->select('medias.nombre as nombre_imagen','medias.propiedad_id','medias.id as id_imagen','propiedades.*','ciudades.nombre as nombreCiudad','tipoinmueble.nombre as nombreInmueble')
                                     ->where('medias.vista',1)
                                     ->inRandomOrder()
                                     ->get()
                                     ->take(3);
        return view('contacto',compact('proyectos','inmuebles'));
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function nuestra_historia()
    {
      $proyectos=DB::table('proyectos')->Join('mediaproyectos','proyectos.id','mediaproyectos.proyecto_id')
                                            ->join('ciudades','proyectos.ciudad_id','ciudades.id')
                                            ->select('mediaproyectos.nombre as nombre_imagen','mediaproyectos.proyecto_id','mediaproyectos.id as id_imagen','proyectos.*','ciudades.nombre as nombre_ciudad')
                                            ->where('mediaproyectos.vista',1)
                                            ->where('destacado',1)
                                            ->inRandomOrder()
                                            ->get()
                                            ->take(3);
      $inmuebles=DB::table('medias')->Join('propiedades','medias.propiedad_id','propiedades.id')
                                     ->join('tipoinmueble','propiedades.tipo_inmueble','tipoinmueble.id')
                                     ->join('ciudades','propiedades.ciudad_id','ciudades.id')
                                     ->select('medias.nombre as nombre_imagen','medias.propiedad_id','medias.id as id_imagen','propiedades.*','ciudades.nombre as nombreCiudad','tipoinmueble.nombre as nombreInmueble')
                                     ->where('medias.vista',1)
                                     ->inRandomOrder()
                                     ->get()
                                     ->take(3);
        return view('nuestra_historia',compact('proyectos','inmuebles'));
    }

}
