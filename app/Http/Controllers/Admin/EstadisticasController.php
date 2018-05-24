<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Estado;
use App\Models\Ciudad;
use App\Models\TipoInmueble;
use App\Models\Agente;
use App\Models\Propiedad;
use App\Models\Negociacion;
use App\Models\Media;
use App\Models\NegociacionEstatus;
use App\Models\Reporte;


class EstadisticasController extends Controller
{
    public function index(){
      $reportes=Reporte::where('padre',0)->get();
      return view('.admin.estadisticas_filtro',$this->cargarSidebar(),compact('reportes'));
    }

    public function tipoReporte(){
      $elemento=Request::get('elemento');
      $tipoReporte=Reporte::where('padre',$elemento)->get();
      return Response::json($tipoReporte);
    }




    ////////////////// metodos comunes //////////////////////////////////////
    public function transformar_fecha($fecha)
		{
			 $fecha_f=explode('-', $fecha);
			 $fecha_f=Carbon::create($fecha_f[0],$fecha_f[1],$fecha_f[2]);
 			return $fecha_f;
		}

    //////////////////reportes de propiedades/////////////////////////////////

    public function distribucionAsesor()
    {
    	$cantidades=['Activos'=>0,'Inactivos'=>0,'Vendidos'=>0];
    	$status=['Activo'=>1,'Inactivo'=>2,'Vendido'=>11];
    	$agentes=[];

    	////cantidades totales del sistema
    	$cantidades['Activos']=count(Propiedad::where('estatus',$status['Activo'])->get());
    	$cantidades['Inactivos']=count(Propiedad::where('estatus',$status['Inactivo'])->get());
    	$cantidades['Vendidos']=count(Propiedad::where('estatus',$status['Vendido'])->get());

    	//cantidades por asesor
    	$asesores=Agente::all();
    	foreach ($asesores as $asesor) 
    	{
    		$aux=['Activos'=>0,'Inactivos'=>0,'Vendidos'=>0];
    		$aux['Activos']= count(Propiedad::where('agente_id',$asesor->id)->where('estatus',$status['Activo'])->get());
    		$aux['Inactivos']= count(Propiedad::where('agente_id',$asesor->id)->where('estatus',$status['Inactivo'])->get());
    		$aux['Vendidos']= count(Propiedad::where('agente_id',$asesor->id)->where('estatus',$status['Vendido'])->get());

    		$total=array_sum($aux);

    		if ($total>0) //si se encontraron propiedades para el asesor de turno
    		{
    			if ($asesor->id==5) {$codigo=' Cod. : NA';}
    			else
    			{$codigo=' Cod. : '.$asesor->codigo_id;}

    			$agentes[$asesor->fullName.' - '.$codigo.' , Total:  '.$total]=$aux;
    		}

    	}

    	$fecha=Carbon::now();

    	return view('reportes.ReporteGeneral',['cantidades'=>$cantidades,'asesores'=>$agentes,'titulo'=>'Reporte de distribución de propiedades por asesor','fecha'=>$fecha->toDateTimeString()]);




    }



    public function distribucionTipoInmueble()//solo inmuebles caracas
    {
    	$cantidades=['Activos'=>0,'Inactivos'=>0,'Vendidos'=>0];
    	$totalOficina=['Activos'=>0,'Inactivos'=>0,'Vendidos'=>0];
    	$status=['Activo'=>1,'Inactivo'=>2,'Vendido'=>11];
    	$tiposInmueble=TipoInmueble::all();
    	$oficina_id=23646;
    	$inmueblesTipo=[];
    	

    	////cantidades totales del sistema
    	$cantidades['Activos']=count(Propiedad::where('estatus',$status['Activo'])->get());
    	$cantidades['Inactivos']=count(Propiedad::where('estatus',$status['Inactivo'])->get());
    	$cantidades['Vendidos']=count(Propiedad::where('estatus',$status['Vendido'])->get());

    	foreach ($tiposInmueble as $tipo) 
    	{
    		$aux=['Activos'=>0,'Inactivos'=>0,'Vendidos'=>0];
    		$aux['Activos']=count(Propiedad::where(['tipo_inmueble'=>$tipo->id,'oficina_id'=>$oficina_id,'estatus'=>$status['Activo']])->get());
    		$aux['Inactivos']=count(Propiedad::where(['tipo_inmueble'=>$tipo->id,'oficina_id'=>$oficina_id,'estatus'=>$status['Inactivo']])->get());
    		$aux['Vendidos']=count(Propiedad::where(['tipo_inmueble'=>$tipo->id,'oficina_id'=>$oficina_id,'estatus'=>$status['Vendido']])->get());

    		$total=array_sum($aux);

    		if ($total>0) 
    		{
    			$totalOficina['Activos']+=$aux['Activos'];
    			$totalOficina['Inactivos']+=$aux['Inactivos'];
    			$totalOficina['Vendidos']+=$aux['Vendidos'];
    			$inmueblesTipo[$tipo->nombre.' - Total: '.$total]=$aux;
    		}

    	}
    	$fecha=Carbon::now();
    	return view('reportes.DistribucionTipoInmueble',['cantidades'=>$cantidades,'inmueblesTipos'=>$inmueblesTipo,'titulo'=>'Reporte de distribución de propiedades por tipo de inmueble','fecha'=>$fecha->toDateTimeString(),'totalOficina'=>$totalOficina]);

    }



    public function distribucionCiudad()
    {
    	$cantidades=['Activos'=>0,'Inactivos'=>0,'Vendidos'=>0];
    	$totalOficina=['Activos'=>0,'Inactivos'=>0,'Vendidos'=>0];
    	$status=['Activo'=>1,'Inactivo'=>2,'Vendido'=>11];
    	$ciudades=Ciudad::all();
    	$oficina_id=23646;
    	$ciudadesTipo=[];
    	

    	////cantidades totales del sistema
    	$cantidades['Activos']=count(Propiedad::where('estatus',$status['Activo'])->get());
    	$cantidades['Inactivos']=count(Propiedad::where('estatus',$status['Inactivo'])->get());
    	$cantidades['Vendidos']=count(Propiedad::where('estatus',$status['Vendido'])->get());

    	foreach ($ciudades as $ciudad) 
    	{
    		$aux=['Activos'=>0,'Inactivos'=>0,'Vendidos'=>0];
    		$aux['Activos']=count(Propiedad::where(['ciudad_id'=>$ciudad->id,'oficina_id'=>$oficina_id,'estatus'=>$status['Activo']])->get());
    		$aux['Inactivos']=count(Propiedad::where(['ciudad_id'=>$ciudad->id,'oficina_id'=>$oficina_id,'estatus'=>$status['Inactivo']])->get());
    		$aux['Vendidos']=count(Propiedad::where(['ciudad_id'=>$ciudad->id,'oficina_id'=>$oficina_id,'estatus'=>$status['Vendido']])->get());

    		$total=array_sum($aux);

    		if ($total>0) 
    		{
    			$totalOficina['Activos']+=$aux['Activos'];
    			$totalOficina['Inactivos']+=$aux['Inactivos'];
    			$totalOficina['Vendidos']+=$aux['Vendidos'];
    			$ciudadesTipo[$ciudad->nombre.' - Total: '.$total]=$aux;
    		}

    	}
    	$fecha=Carbon::now();
    	return view('reportes.DistribucionCiudad',['cantidades'=>$cantidades,'ciudadesTipo'=>$ciudadesTipo,'titulo'=>'Reporte de distribución de propiedades por ciudad','fecha'=>$fecha->toDateTimeString(),'totalOficina'=>$totalOficina]);
    }



    public function propiedadesCaptadas($fechaI="2018-05-20",$fechaF="2018-05-21")
    {
    	
    	$fechaInicio=$fechaI;
    	$fechaFin=$fechaF;
    	$oficina_id=23646;
    	$cantidades=[];
    	$totalOficina=0;
    	
    	///propiedades captadas -provenientes de casa matriz, pertenecientes a inmuebles caracas
    	$propiedadesInCss=Propiedad::where('fechaCreado','>=',$fechaInicio)->where('fechaCreado','<=',$fechaFin)->where('id_mls','<>',0)->where('oficina_id','=',$oficina_id)->get();

    	
        //propiedades captadas - provenientes de casa matriz, pertenecientes a otras oficinas
    	$propiedadesTot=Propiedad::where('fechaCreado','>=',$fechaInicio)->where('fechaCreado','<=',$fechaFin)->where('id_mls','<>',0)->get();

    	//propiedades cargadas en el sistema de inmuebles caracas pertenecientes a otras oficinas
    	$propiedadesGenSis=Propiedad::where('fechaCreado','>=',$fechaInicio)->where('fechaCreado','<=',$fechaFin)->where('id_mls','=',0)->where('agente_id','=',5)->get();

    	// //propiedades cargadas en el sistema de inmuebles caracas, pertenecientes a los asesores propios

    	$propiedadesNoGenSis=Propiedad::where('fechaCreado','>=',$fechaInicio)->where('fechaCreado','<=',$fechaFin)->where('id_mls','=',0)->where('agente_id','<>',5)->get();

    	$cantidades['Sincronizadas, propias']=count($propiedadesInCss);
    	$cantidades['Sincroniadas, otras']=count($propiedadesTot);
    	$cantidades['Cargadas, otras']=count($propiedadesNoGenSis);
    	$cantidades['Cargadas, propias']=count($propiedadesGenSis);
    	$totalOficina=$cantidades['Sincronizadas, propias']+$cantidades['Cargadas, propias'];
    	$totalGeneral=array_sum($cantidades);

    	$fecha=Carbon::now();
    	return view('reportes.NumeroPropiedadesCaptadas',['cantidades'=>$cantidades,'titulo'=>'Reporte de propiedades captadas','fecha'=>$fecha->toDateTimeString(),'totalOficina'=>$totalOficina,'total'=>$totalGeneral]);


    }


}
