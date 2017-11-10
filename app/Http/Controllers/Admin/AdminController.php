<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


class AdminController extends Controller
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
    public function Login()
    {
        return view('/admin/login');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function Dasboard()
    {
        return view('/admin/dashboard');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function ListaInmuebles()
    {
        return view('/admin/lista_inmuebles');
    }
}
