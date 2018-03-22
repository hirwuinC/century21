<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

///////////controlador para probar backend para detectar 

class Correo extends Controller
{
	public function listarPropiedades()
	{
	    $reporte=[];
	    $vencidos=[];
	    $porVencerse=[];
	    $vencenHoy=[];
	    // $agentes=DB::table('agentes')
	    // 			 ->join('users','agentes.id','=','users.agente_id')
	    // 			 ->where('agentes.id','<>',5)->get();

	    $inicio=3;
	    
	    $fechaInicio=Carbon::now();;
	    $fechaInicio=$fechaInicio->subDays($inicio);
	    $fechaInicio=$fechaInicio->toDateString();
	    $fechaActual=Carbon::now();
	    $fechaActual=$fechaActual->toDateString();

	    // ////Obtener propiedades////////////////////////
	    $consultarPropiedades=DB::table('propiedades')->where('estatus','<>',11)->get();

	    // ///Recorrer lista de propiedades e identificar si la fecha del informe
	    // ///caduco o esta dentro del rango de alerta
	    foreach ($consultarPropiedades as $propiedad) 
	    {
	    	
	    	if($propiedad->proximoInforme>=$fechaInicio && $propiedad->proximoInforme<$fechaActual)//por vencerse
	    	{
	    		array_push($porVencerse,$propiedad);

	    	}
	    	else if($propiedad->proximoInforme<$fechaInicio)//vencidos
	    	{
	    		array_push($vencidos,$propiedad);
	    	
	    	}
	    	else if($propiedad->proximoInforme==$fechaActual)
	    	{
	    		array_push($vencenHoy,$propiedad);
	    		
	    	}

	    }

	  	
	  	// $codigo='<p>También procesa (reemplaza por su valor) las $variables que hubiera dentro del código. </p><p>Nueva linea</p>';
	  					
	  				

	  	// echo $codigo;
	    
	    dd([$vencidos,$vencenHoy,$porVencerse]);


	}



}
