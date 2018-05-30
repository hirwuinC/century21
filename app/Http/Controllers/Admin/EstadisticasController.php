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

    		
                if ($total>0) 
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
    	$cantidades['Sincronizadas, otras']=count($propiedadesTot);
    	$cantidades['Cargadas, otras']=count($propiedadesNoGenSis);
    	$cantidades['Cargadas, propias']=count($propiedadesGenSis);
    	$totalOficina=$cantidades['Sincronizadas, propias']+$cantidades['Cargadas, propias'];
    	$totalGeneral=array_sum($cantidades);

    	$fecha=Carbon::now();
    	return view('reportes.NumeroPropiedadesCaptadas',['cantidades'=>$cantidades,'titulo'=>'Reporte de propiedades captadas','fecha'=>$fecha->toDateTimeString(),'totalOficina'=>$totalOficina,'total'=>$totalGeneral]);


    }


    //////////Inicio reporte //////////////////////////////////////
    
    public function captadasAsesorFiltro($fechaI="2018-05-20",$fechaF="2018-05-21",$check=0)
    {
        //los muestra todos incluso los que no tienen nada
        $agentes=agente::all();
        $agentesReto=[];

        foreach ($agentes as $agente) 
        {
            $propiedades=count(Propiedad::where('agente_id',$agente->id)->where('fechaCreado','>=',$fechaI)->where('fechaCreado','<=',$fechaF)->get());

            if ($check==0) 
            {
                $agentesReto[$agente->fullName.' / '.$agente->codigo_id]=$propiedades;
            }
            else
            {
                if ($propiedades>0) 
                {
                     $agentesReto[$agente->fullName.' / '.$agente->codigo_id]=$propiedades;
                }
            }

            
        }
        arsort($agentesReto);

        return $agentesReto;
    }

    public function CaptadasCiudadFiltro($fechaI="2018-05-20",$fechaF="2018-05-21",$check)
    {
        $ciudades=Ciudad::all();
        $ciudadesReto=[];
        $retorno=[];
        $ciudadesGen=[];
        $oficina_id=23646;

        foreach ($ciudades as $ciudad)
        {
            $propiedades=count(Propiedad::where('ciudad_id',$ciudad->id)->where('fechaCreado','>=',$fechaI)->where('fechaCreado','<=',$fechaF)->where('oficina_id','=',$oficina_id)->get());

            $propiedadesGen=count(Propiedad::where('ciudad_id',$ciudad->id)->where('fechaCreado','>=',$fechaI)->where('fechaCreado','<=',$fechaF)->get());

            if ($check==0) 
            {
                $ciudadesReto[$ciudad->nombre.' / '.$ciudad->codigo_id]=$propiedades;
                $ciudadesGen[$ciudad->nombre.' / '.$ciudad->codigo_id]=$propiedadesGen;
            }
            else
            {
                if ($propiedades>0) 
                {
                     $ciudadesReto[$ciudad->nombre.' / '.$ciudad->codigo_id]=$propiedades;
                     $ciudadesGen[$ciudad->nombre.' / '.$ciudad->codigo_id]=$propiedadesGen;
                }
            }

            

        }
        arsort($ciudadesReto);

        foreach ($ciudadesReto as $key =>$value) 
        {
            $retorno[$key]=$value.' | '.$ciudadesGen[$key];
        }

        return $retorno;
    }

    public function CaptadasPrecioFiltro($fechaI="2018-05-20",$fechaF="2018-05-21",$precioI,$precioF)
    {

        $oficina_id=23646;
        $propiedadesGen=count(Propiedad::where('fechaCreado','>=',$fechaI)->where('fechaCreado','<=',$fechaF)->where('precio','>=',$precioI)->where('precio','<=',$precioF)->get());

        $propiedadesImbCss=count(Propiedad::where('fechaCreado','>=',$fechaI)->where('fechaCreado','<=',$fechaF)->where('precio','>=',$precioI)->where('precio','<=',$precioF)->where('oficina_id','=',$oficina_id)->get());


        return (string) $propiedadesImbCss.' Inmuebles caracas | '.$propiedadesGen.' General';
    }

    public function propiedadesCaptadasFiltro($fechaI="2018-05-20",$fechaF="2018-05-21",$tipoR=1,$precioI=0,$precioF=1000000000,$check=0)
    {
        
        $titulos=['por asesores','por ciudades',''];
        $retorno=[];
        
        if ($tipoR==0) 
        {
            $retorno=$this->captadasAsesorFiltro($fechaI,$fechaF,$check);
        }
        else if ($tipoR==1) 
        {
            $retorno=$this->CaptadasCiudadFiltro($fechaI,$fechaF,$check);
        }
        else if ($tipoR==2) 
        {
            $retorno=$this->CaptadasPrecioFiltro($fechaI,$fechaF,$precioI,$precioF);
            $titulos[2]='por precios entre: '.$precioI.' $ y : '.$precioF;
        }
        
        
        $fecha=Carbon::now();
        
        return view('reportes.NumeroPropiedadesCaptadasFiltro',['cantidades'=>$retorno,'titulo'=>'Reporte de propiedades captadas '.$titulos[$tipoR].' , entre '.$fechaI.' y '.$fechaF,'fecha'=>$fecha->toDateTimeString(),'tipo'=>$tipoR]);


    }
      ////////////////////////////////////////////////////////////////////////////Fin reporte///////////


    /////Inicio reporte////////////////////////////////////////////////////////////////////////////
    
    public function visitasAsesor($check)
    {
        $agentes=agente::where('id','<>',5)->get();
        $visitasAsesor=[];
        $titulos=['Nro. de visitas en el portal por asesor','Nro. de visitas en el portal por propiedad','Nro. de visitas en el portal por tipo de inmueble'];
        $tipoR=0;

        

        foreach ($agentes as $agente) 
        {
            $propiedades=(integer) DB::table('propiedades')->where('agente_id', '=' ,$agente->id)->sum('visitas'); 
            if ($check==0) 
            {
                $visitasAsesor[$agente->fullName." / ".$agente->codigo_id]=$propiedades;
            }
            else if ($check==1 && $propiedades>0) 
            {
                $visitasAsesor[$agente->fullName." / ".$agente->codigo_id]=$propiedades;
            }
            
        }

        arsort($visitasAsesor);
       $fecha=Carbon::now();
        return view('reportes.VisitasFiltro',['cantidades'=>$visitasAsesor,'titulo'=>$titulos[$tipoR],'fecha'=>$fecha->toDateTimeString(),'tipo'=>$tipoR]);$fecha=Carbon::now();
        
    }


    public function visitasTipoInmueble($check=0)
    {
        $tipoInmueble=DB::table('tipoinmueble')->get();
        $visitasTipoInmueble=[];
        $titulos=['Nro. de visitas en el portal por asesor','Nro. de visitas en el portal por propiedad','Nro. de visitas en el portal por tipo de inmueble'];
        $tipoR=2;

        foreach ($tipoInmueble as $tipoIn) 
        {
            $propiedades=DB::table('propiedades')->where('tipo_inmueble',$tipoIn->id)->where('agente_id','<>',5)->sum('visitas'); 
                       
            if ($check==0) 
            {
                $visitasTipoInmueble[$tipoIn->nombre]=$propiedades;
            }
            else 
            {
                if ($propiedades>0) 
                {
                    $visitasTipoInmueble[$tipoIn->nombre]=$propiedades;
                }
                
            }
        }

        arsort($visitasTipoInmueble);
        $fecha=Carbon::now();
        return view('reportes.VisitasFiltro',['cantidades'=>$visitasTipoInmueble,'titulo'=>$titulos[$tipoR],'fecha'=>$fecha->toDateTimeString(),'tipo'=>$tipoR]);$fecha=Carbon::now();

    }


    public function visitasPropiedad($check=0)
    {
        $titulos=['Nro. de visitas en el portal por asesor','Nro. de visitas en el portal por propiedad','Nro. de visitas en el portal por tipo de inmueble'];
        $tipoR=1;

        $propiedades=Propiedad::where('agente_id','<>',5)->get();
        $visitasPropiedad=[];

        foreach ($propiedades as $propiedad) 
        {
            $cantidad=(integer) DB::table('propiedades')->where('id', '=' ,$propiedad->id)->sum('visitas'); 

            if ($check==0) 
            {
                $visitasPropiedad[$propiedad->id_mls]=$cantidad;
            }
            else if ($check==1 && $cantidad>0) 
            {
                $visitasPropiedad[$propiedad->id_mls]=$cantidad;
            }
        }
        arsort($visitasPropiedad);
           $fecha=Carbon::now();
        return view('reportes.VisitasFiltro',['cantidades'=>$visitasPropiedad,'titulo'=>$titulos[$tipoR],'fecha'=>$fecha->toDateTimeString(),'tipo'=>$tipoR]);
    }

    public function visitasFiltro($filtro)//0 visitas por asesor, 1 propiedad , 2 por tipo inmueble $check=1,$tipoR=2
    {
        $titulos=['Nro. de visitas en el portal por asesor','Nro. de visitas en el portal por propiedad','Nro. de visitas en el portal por tipo de inmueble'];

        if ($tipoR==0) 
        {
            $retorno=$this->visitasAsesor($check);
        }
        else if ($tipoR==1) 
        {
            $retorno=$this->visitasPropiedad($check);
        }
        else if ($tipoR==2) 
        {
            $retorno=$this->visitasTipoInmueble($check);
        }


         $fecha=Carbon::now();
        
        return view('reportes.VisitasFiltro',['cantidades'=>$retorno,'titulo'=>$titulos[$tipoR],'fecha'=>$fecha->toDateTimeString(),'tipo'=>$tipoR]);
        
    }

   ////////fin reporte///////////////////////////////////

//////////inicio reporte///////////////////////////////////////////////////

public function promedioPrecioAsesor($check)
{
    $asesores=agente::all();
    $promedioAsesor=[];

    foreach ($asesores as $asesor) 
    {
        $promedioVenta=(integer)DB::table('propiedades')->where('agente_id',$asesor->id)->where('tipoNegocio','Venta')->avg('precio');
        $promedioAlquiler=(integer)DB::table('propiedades')->where('agente_id',$asesor->id)->where('tipoNegocio','Alquiler')->avg('precio');

        if ($check==0) 
        {
            $promedioAsesor[$asesor->fullName." / ".$asesor->codigo_id]=$promedioVenta.' / '.$promedioAlquiler;
        }
        else
        {
            if ($promedioVenta>0 || $promedioAlquiler>0) 
            {
                $promedioAsesor[$asesor->fullName." / ".$asesor->codigo_id]=$promedioVenta.' / '.$promedioAlquiler;
            }
        }
        
    }

    return $promedioAsesor;
}  


function promedioPrecioTipoInmueble($check)
{
    $tipoInmueble=DB::table('tipoinmueble')->get();
    $promedioTipo=[];

    foreach ($tipoInmueble as $tipoIn) 
    {
        $promedioInmCssV=(integer)DB::table('propiedades')->where('tipo_inmueble',$tipoIn->id)->where('agente_id','<>',5)->where('tipoNegocio','Venta')->avg('precio');

        $promedioInmCssA=(integer)DB::table('propiedades')->where('tipo_inmueble',$tipoIn->id)->where('agente_id','<>',5)->where('tipoNegocio','Alquiler')->avg('precio');

        $promedioGenV=(integer)DB::table('propiedades')->where('tipo_inmueble',$tipoIn->id)->where('tipoNegocio','Venta')->avg('precio');

         $promedioGenA=(integer)DB::table('propiedades')->where('tipo_inmueble',$tipoIn->id)->where('tipoNegocio','Alquiler')->avg('precio');

         if ($check==0)
         {
             $promedioTipo[$tipoIn->nombre]=$promedioInmCssV.'  Bs.  |  '.$promedioGenV."  Bs. / ".$promedioInmCssA.' Bs. |  '.$promedioGenA.' Bs. ';
         }
         else
        {
            if (($promedioInmCssV>0 ||  $promedioGenV>0) || ($promedioInmCssA>0 || $promedioGenA>0))
            {
                $promedioTipo[$tipoIn->nombre]=$promedioInmCssV.'  Bs.  |  '.$promedioGenV."  Bs.  / ".$promedioInmCssA.' Bs. |  '.$promedioGenA.' Bs. ';
            }
        }

        
    }

    return $promedioTipo;
}

public function promedioPrecioFiltro($tipoR=0,$check=0)//0 por asesor , 1 por tipo de inmueble
{
    
    $titulos=['Precio promedio por asesor','Precio Promedio por tipo de inmueble'];

    $promedioGenVen=(integer)DB::table('propiedades')->where('tipoNegocio','Venta')->avg('precio');
    $promedioGenAlq=(integer)DB::table('propiedades')->where('tipoNegocio','Alquiler')->avg('precio');

    if ($tipoR==0) 
    {
        $retorno=$this->promedioPrecioAsesor($check);
    }
    else if ($tipoR==1) 
    {
        $retorno=$this->promedioPrecioTipoInmueble($check);
    }

    $fecha=Carbon::now();
        
    return view('reportes.PrecioPromedioFiltro',['cantidades'=>$retorno,'titulo'=>$titulos[$tipoR],'fecha'=>$fecha->toDateTimeString(),'tipo'=>$tipoR,'promedioV'=>$promedioGenVen,'promedioA'=>$promedioGenAlq]);

}
//////////fin reporte /////////////////////////////////////////////////////

/////////Inicio de reporte ////////////////////////////////////////////////
public function listaInmuebles($check=0)//si se muestra el asesor generico o no
{
    $propiedadesAgente=[];

    if ($check==0) 
    {
        $asesores=agente::all();
    }
    else
    {
        $asesores=agente::where('id','<>',5)->get();
    }

    foreach ($asesores as $asesor) 
    {
            $propiedades=DB::table('propiedades')->join('tipoinmueble','propiedades.tipo_inmueble','=','tipoinmueble.id')->select('propiedades.id_mls AS mls','propiedades.fechaCreado AS fecha','tipoinmueble.nombre AS tipo_inmueble','propiedades.id AS propiedad_id','propiedades.tipoNegocio AS tipo_negocio')->where(['propiedades.agente_id'=>$asesor->id])->get();
        
                if (count($propiedades)>0) 
                {
                    $propiedadesAgente['# '.$asesor->fullName.' - '.$asesor->codigo_id]=$propiedades;
                }
    }


    return $propiedadesAgente;


}

public function tiempoOfertaPublica($check=1)//cargar los inmuebles y mostrar la fecha de creacion el check indica si se muestran todos o solo los de inmuebles caracas
{
    $retorno=$this->listaInmuebles($check);

    $fecha=Carbon::now();
        
    return view('reportes.TiempoOfertaPublica',['cantidades'=>$retorno,'titulo'=>'Lista de propiedades por asesor, con su fecha de creacion en el sistema','fecha'=>$fecha->toDateTimeString()]);


}

////////Fin reporte///////////////////////////////////////////////////////// 

////////Inicio de reporte /////////////////////////////////////////////////////


///////Fin de reporte /////////////////////////////////////////////////////////////



////////reportes asesores//////////////////////////////////////////////////////////////////


}
