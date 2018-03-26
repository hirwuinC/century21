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
	    $agentes=[];
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
	    $consultarPropiedades=DB::table('propiedades')
	    							->join('estados','propiedades.estado_id','=','estados.id')
	    							->join('ciudades','propiedades.ciudad_id','=','ciudades.id')
	    							->select('propiedades.urbanizacion AS urbanizacion','propiedades.direccion AS direccion',
	    									 'propiedades.tipoNegocio AS negocio','propiedades.proximoInforme AS proximoInforme','propiedades.agente_id 
	    									 AS agente','estados.nombre AS estado','ciudades.nombre AS ciudad')
	    							->where('propiedades.estatus','<>',11)->get();

	    // ///Recorrer lista de propiedades e identificar si la fecha del informe
	    // ///caduco o esta dentro del rango de alerta
	    foreach ($consultarPropiedades as $propiedad) 
	    {
	    	
	    	if($propiedad->proximoInforme>=$fechaInicio && $propiedad->proximoInforme<$fechaActual)//por vencerse
	    	{
	    		array_push($porVencerse,$propiedad);
	    		if(!in_array($propiedad->agente,$agentes))
	    		{
	    			array_push($agentes,$propiedad->agente);
	    		}

	    	}
	    	else if($propiedad->proximoInforme<$fechaInicio)//vencidos
	    	{
	    		array_push($vencidos,$propiedad);
	    		if(!in_array($propiedad->agente,$agentes))
	    		{
	    			array_push($agentes,$propiedad->agente);
	    		}
	    	
	    	}
	    	else if($propiedad->proximoInforme==$fechaActual)
	    	{
	    		array_push($vencenHoy,$propiedad);
	    		if(!in_array($propiedad->agente,$agentes))
	    		{
	    			array_push($agentes,$propiedad->agente);
	    		}
	    		
	    	}

	    }
	    ////Obtener datos del agente 
	    $listaAgentes=[];
	    foreach ($agentes as $agente) 
	    {
	    	$agenteVencidos=[];
	    	$agenteVenceHoy=[];
	    	$agentePorVencerse=[];
	    	$borrar=[];
	    	$longitudVencidos=count($vencidos);
	    	$longitudVenceHoy=count($vencenHoy);
	    	$longitudPorVencerse=count($porVencerse);

	    	$consulta=DB::table('agentes')
	    					->join('users','agentes.id','=','users.agente_id')
	    					->select('agentes.fullName AS nombreAgente','agentes.cedula AS cedulaAgente','users.email AS correoAgente','agentes.telefono AS telefonoAgente','agentes.celular AS celularAgente')
	    					->where('agentes.id',$agente)
	    					->first();

	    	for ($i=0; $i <$longitudVencidos ; $i++) 
	    	{ 
	    		echo $i;
	    		if($vencidos[$i]->agente==$agente)
	    		{
	    			array_push($borrar,$i);//guarda los indices que hay que borrar en la lista de vencidos
	    			array_push($agenteVencidos,$vencidos[$i]);//agrega al arreglo de vencidos del agente
	    		}
	    	}
	    	echo 'Longitud : '.count($vencidos);
	    	foreach ($borrar as $borrador) 
	    	{
	    		unset($vencidos[$borrador]);
	    	}
	    	echo 'Longitud : '.count($vencidos);
	    }

	  	
	  	// $codigo='<p>También procesa (reemplaza por su valor) las $variables que hubiera dentro del código. </p><p>Nueva linea</p>';
	  					
	  				

	  	// echo $codigo;
	    
	    dd($agentes);


	}



}
