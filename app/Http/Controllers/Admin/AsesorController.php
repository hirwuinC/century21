<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Agente;

class AsesorController extends Controller
{
    public function ListarAsesores(){
    	$asesores= Agente::all();
    	return view('admin.lista_agentes',compact('asesores'));
    }

    public function CrearUsuarioAsesor($id){
    	$asesor=Agente::where('id',$id)->first();
    	$fullname=explode(" ", $asesor->fullName);
    	return view('admin.crear_agente',compact('asesor','fullname'));
    }
   	public function nuevo(){
    	$var =\Request::get('data');
    	//parent::Prueba();
    	return $var;
    }
    
}