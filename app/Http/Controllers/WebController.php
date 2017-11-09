<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

const INMUEBLE_EXAMPLE = ["direccion" => "Avenida Eugenio Mendoza, La Castellana" , "precio"=> "100.000.000"];
const PROYECTO_EXAMPLE = [];

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
        return view('home');
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
    public function detalle_inmueble()
    {
        return view('detalle_inmueble');
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
