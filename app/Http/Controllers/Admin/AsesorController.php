<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Agente;
use App\Models\User;

class AsesorController extends Controller
{
    public function ListarAsesores(){
      $data=\Request::get('data');
      if ($data) {
        $asesores=Agente::where('id',$data)->paginate(20);
      }
      else{
        $asesores= Agente::paginate(20);
      }
    return view('admin.lista_agentes',compact('asesores'));
    }

    public function CrearUsuarioAsesor($id){
        $usuario=User::where('agente_id',$id)->first();
    	$asesor=Agente::where('id',$id)->first();
    	$fullname=explode(" ", $asesor->fullName);

        return view('admin.crear_agente',compact('asesor','fullname','usuario'));

    }
   	public function searchAsesor(){
    	$var =\Request::get('data');
    	$result=Agente::searchAsesor($var)->get();
    	return response()->json($result);
    }
    public function insertarAsersor(){

    }

}
