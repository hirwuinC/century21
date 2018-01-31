<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Propiedad;
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
        $inmuebles=Propiedad::paginate(30);
        return view('home',compact('inmuebles'));
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
      return view('detalle_inmueble',compact('inmueble'));
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
