<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use Carbon\Carbon;

///////////controlador para probar backend para detectar

class Correo extends Controller
{

	///////////////////////////busca las propieddes vencidas, por vencerse y las que se vencen el dia actual. Segun la lista que se pase
	public function buscarPropiedad($lista,$agente)
	{
		$propiedades=[];
		$nuevaLista=[];
		foreach($lista as $propiedad)
		{
			if($propiedad->agente==$agente)
			{
				array_push($propiedades,$propiedad);
			}
			else if($propiedad->agente!=$agente)
			{
				array_push($nuevaLista,$propiedad);
			}
		}

		return [$propiedades,$nuevaLista];
	}



	public function consultarAgente($agente){
		$consulta=DB::table('agentes')
						->select('agentes.fullName AS nombre','agentes.codigo_id AS codigo','agentes.email AS correo','agentes.telefono AS telefono','agentes.celular AS celular')
						->where('agentes.id',$agente)
						->first();
		return $consulta;
	}

	public function consultaPropiedades($statusVendido,$asesorGenerico)
	{

		$consulta=DB::table('propiedades')
	    							->join('estados','propiedades.estado_id','=','estados.id')
	    							->join('ciudades','propiedades.ciudad_id','=','ciudades.id')
	    							->join('urbanizaciones','propiedades.urbanizacion','=','urbanizaciones.id')
	    							->select('urbanizaciones.nombre AS urbanizacion','propiedades.direccion AS direccion',
	    									 'propiedades.tipoNegocio AS negocio','propiedades.proximoInforme AS proximoInforme','propiedades.agente_id
	    									 AS agente','estados.nombre AS estado','ciudades.nombre AS ciudad','propiedades.id AS id','propiedades.id_mls AS mls')
	    							->where('propiedades.estatus','<>',$statusVendido)->where('propiedades.agente_id','<>',$asesorGenerico)->get();
		return $consulta;
	}
	public function colores($registros)
	{
		$colores=['#FFFFFF','#DCDBDB'];
		$color=0;
		$lista=[];
		foreach ($registros as $key => $registro)
		{
			$lista[$key]=$colores[$color];
			if($color==0)
			{
				$color=1;
			}
			else
			{
				$color=0;
			}
		}

		return $lista;
	}

	public function listarPropiedades()
	{
	    $reporte=[];
	    $agentes=[];
	    $vencidos=[];
	    $porVencerse=[];
	    $vencenHoy=[];
	    $colores=['#FFFFFF','#EDEBEB'];


	    $inicio=3;//limite de mensajes de alerta, para propiedades que estan por vencerse

	    $fechaInicio=Carbon::now();
	    $fechaInicio=$fechaInicio->addDays($inicio);
	    $fechaInicio=$fechaInicio->toDateString();
	    $fechaActual=Carbon::now();
	    $fechaActual=$fechaActual->toDateString();

	    // ////Obtener propiedades////////////////////////
	    $consultarPropiedades=$this->consultaPropiedades(11,5);

	    // ///Recorrer lista de propiedades e identificar si la fecha del informe
	    // ///caduco o esta dentro del rango de alerta
	    foreach ($consultarPropiedades as $propiedad)
	    {

	    	if($propiedad->proximoInforme>$fechaActual&& $propiedad->proximoInforme<$fechaInicio)//por vencerse
	    	{
	    		array_push($porVencerse,$propiedad);
	    		if(!in_array($propiedad->agente,$agentes))
	    		{
	    			array_push($agentes,$propiedad->agente);
	    		}

	    	}
	    	else if($propiedad->proximoInforme<$fechaActual)//vencidos
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

	    $registrosAgente=[];

	   //////////////////////obtener las propiedades vencidas por agente/////////////////////
	   foreach ($agentes as $agente)
	   {

	   	 ////////////////////Obtener las propiedades vencidas para un agente ///////////////////////////
	   	 $aux=$this->buscarPropiedad($vencidos,$agente);
	   	 $vencidosAgente=$aux[0];
	   	 $vencidos=$aux[1];
	   	 $coloresVencidos=$this->colores($vencidosAgente);
	   	 //////////////////////////////////////////////////////////////////////////////////////////////////

	   	 //////////////////Obtener las propiedades por vencerse para un agente////////////////////////////
	   	 $aux=$this->buscarPropiedad($porVencerse,$agente);
	   	 $porVencerseAgente=$aux[0];
	   	 $porVencerse=$aux[1];
	   	 $coloresPorVencerse=$this->colores($porVencerseAgente);
	   	 ////////////////////////////////////////////////////////////////////////////////////////////////

	   	 //////////////////Obtener las propiedades que vencen hoy///////////////////////////////////////
	   	 $aux=$this->buscarPropiedad($vencenHoy,$agente);
	   	 $vencenHoyAgente=$aux[0];
	   	 $vencenHoy=$aux[1];
	   	 $coloresVencenHoy=$this->colores($vencenHoyAgente);
	   	 ///////////////////////////////////////////////////////////////////////////////////////////////
	   	 $datosAgente=$this->consultarAgente($agente);


	   	 $registro=[$agente=>['nombre'=>$datosAgente->nombre,'codigo'=>$datosAgente->codigo,'correo'=>$datosAgente->correo,'telefono'=>$datosAgente->telefono,'celular'=>$datosAgente->celular,'vencidos'=>$vencidosAgente,'coloresVencidos'=>$coloresVencidos,'porVencerse'=>$porVencerseAgente,'coloresPorVencerse'=>$coloresPorVencerse,'vencenHoy'=>$vencenHoyAgente,'coloresVencenHoy'=>$coloresVencenHoy]];
	   	///////////////////Enviar correo al agente de turno //////////////////////////////////////////

	   	/////////////////////////////////////////////////////////////////////////////////////////////

	   	 //return view('emails.informeAsesor',['asesor'=>$registro,'agente'=>$agente]);
	     array_push($registrosAgente,$registro);


	   }
	   return view('emails.informeAdministrador',['registros'=>$registrosAgente]);

	 	



	}



}
