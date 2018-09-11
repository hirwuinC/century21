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
use App\Models\Urbanizacion;
use App\Models\TipoInmueble;
use App\Models\Agente;
use App\Models\User;
use App\Models\Propiedad;
use App\Models\Negociacion;
use App\Models\Media;
use App\Models\NegociacionEstatus;
use App\Models\Reporte;
use DateTime;

class EstadisticasController extends Controller
{
    public function index(){
      $reportes=Reporte::where('padre',0)->get();
      $estados=Estado::all();
      return view('.admin.estadisticas_filtro',$this->cargarSidebar(),compact('reportes','estados'));
    }

    public function tipoReporte(){
      $elemento=Request::get('elemento');
      $tipoReporte=Reporte::where('padre',$elemento)->get();
      return Response::json($tipoReporte);
    }

    public function listarAsesores(){
      $elemento=Request::get('elemento');
      $asesores=Agente::orderBy('fullName','asc')->get();
      return Response::json($asesores);
    }

    public function listarCiudades(){
      $estados=Request::get('estados');
      for ($i=0; $i <count($estados) ; $i++) {
        $ciudades[]=Ciudad::where('estado_id',$estados[$i])->orderBy('nombre','asc')->get();
      }
      return compact('ciudades');
    }

    public function listarUrbanizaciones(){
      $ciudades=Request::get('ciudades');
      for ($i=0; $i <count($ciudades) ; $i++) {
        $urbanizaciones[]=Urbanizacion::where('ciudad_id',$ciudades[$i])->orderBy('nombre','asc')->get();
      }
      return compact('urbanizaciones');
    }

    public function transformar_fecha($fecha){
        $fecha_f=explode('-', $fecha);
        $fecha_f=Carbon::create($fecha_f[0],$fecha_f[1],$fecha_f[2]);
        return $fecha_f;
    }


    public function distribucionAsesor($fechaI,$fechaF,$data){
        $seleccionados=explode(",", $data);
        $asesores=Agente::all();
        $fechaFormatoInicial=date("d/m/Y", strtotime($fechaI));
        $fechaFormatoFinal=date("d/m/Y", strtotime($fechaF));
        $titulo="Distribución de propiedades captadas segun asesores por estatus: ".$fechaFormatoInicial." - ".$fechaFormatoFinal;
        if ($data!=0) {
            $cantidades=['Activos'=>0,'Inactivos'=>0,'Vendidos'=>0];
            for($i=0; $i<count($seleccionados); $i++) { 
                $cantidades['Activos']=$cantidades['Activos']+count(Propiedad::where('estatus',1)->where('agente_id',$seleccionados[$i])->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                $cantidades['Inactivos']=$cantidades['Inactivos']+count(Propiedad::where('estatus',2)->where('agente_id',$seleccionados[$i])->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                $cantidades['Vendidos']=$cantidades['Vendidos']+count(Propiedad::where('estatus',11)->where('agente_id',$seleccionados[$i])->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
            };

            for($i=0; $i<count($seleccionados); $i++) { 
                $estatus[$i]['id']=$seleccionados[$i];
                $estatus[$i]['Activos']=count(Propiedad::where('estatus',1)->where('agente_id',$seleccionados[$i])->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                $estatus[$i]['Inactivos']=count(Propiedad::where('estatus',2)->where('agente_id',$seleccionados[$i])->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                $estatus[$i]['Vendidos']=count(Propiedad::where('estatus',11)->where('agente_id',$seleccionados[$i])->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
            };
        }
        else {
            $cantidades['Activos']=count(Propiedad::where('estatus',1)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
            $cantidades['Inactivos']=count(Propiedad::where('estatus',2)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
            $cantidades['Vendidos']=count(Propiedad::where('estatus',11)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());

            foreach ($asesores as $i => $value) {
                $estatus[$i]['id']=$asesores[$i]->id;
                $estatus[$i]['Activos']=count(Propiedad::where('estatus',1)->where('agente_id',$asesores[$i]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                $estatus[$i]['Inactivos']=count(Propiedad::where('estatus',2)->where('agente_id',$asesores[$i]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                $estatus[$i]['Vendidos']=count(Propiedad::where('estatus',11)->where('agente_id',$asesores[$i]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
            } 
        }
        return view('reportes.DistribucionEstatusAsesor',compact('titulo','asesores','estatus','cantidades'));
           
    }

    public function EstadosCiudadesEstatus($estadosSelect,$ciudadesSelect){
        $citySinSelect=[];
        $estadoSinCiudad=[];
        $padresCiudad=[];

        for ($a=0; $a <count($estadosSelect) ; $a++) { 
            $aux1[]=Estado::where('id',$estadosSelect[$a])->first();
            $estateSelect[$a]['id']=$aux1[$a]->id;
            $estateSelect[$a]['nombre']=$aux1[$a]->nombre;
            $estateSelect[$a]['activos']=0;
            $estateSelect[$a]['inactivos']=0;
            $estateSelect[$a]['vendidos']=0;
        }

        for ($b=0; $b <count($ciudadesSelect) ; $b++) { 
            $aux2[]=Ciudad::where('id',$ciudadesSelect[$b])->first();
            $citySelect[$b]['id']=$aux2[$b]->id;
            $citySelect[$b]['padre']=$aux2[$b]->estado_id;
            $citySelect[$b]['nombre']=$aux2[$b]->nombre;
            $citySelect[$b]['activos']=0;
            $citySelect[$b]['inactivos']=0;
            $citySelect[$b]['vendidos']=0;
            $padresCiudad[]= $citySelect[$b]['padre'];
        }

        for ($c=0; $c <count($estadosSelect) ; $c++) { 
            if (!in_array($estadosSelect[$c],$padresCiudad)) {
                if (!in_array($estadosSelect[$c], $estadoSinCiudad)) {
                    $estadoSinCiudad[]=$estadosSelect[$c];
                }
            }
        }

        for ($d=0; $d <count($estadoSinCiudad) ; $d++) { 
           $cityAll[]=Ciudad::where('estado_id',$estadoSinCiudad[$d])->get();
           for ($e=0; $e <count( $cityAll[$d]) ; $e++) { 
                $aux3[$e]['id']= $cityAll[$d][$e]->id;
                $aux3[$e]['padre']= $cityAll[$d][$e]->estado_id;
                $aux3[$e]['nombre']= $cityAll[$d][$e]->nombre;
                $aux3[$e]['activos']= 0;
                $aux3[$e]['inactivos']= 0;
                $aux3[$e]['vendidos']= 0;
                $citySinSelect[]=$aux3[$e];
           }
        }
        for ($f=0; $f <count($citySinSelect) ; $f++ ){ 
            $citySelect[]=$citySinSelect[$f];
        }
        return compact('citySelect','estateSelect');
    }

    public function distribucionUbicacion($fechaI,$fechaF,$estados,$ciudades,$urbanizaciones){
        $estadosSelect=explode(",", $estados);
        $ciudadesSelect=explode(",", $ciudades);
        $urbanizacionesSelect=explode(",", $urbanizaciones);
        $fechaFormatoInicial=date("d/m/Y", strtotime($fechaI));
        $fechaFormatoFinal=date("d/m/Y", strtotime($fechaF));
        $titulo="Distribución de propiedades captadas segun ubicación por estatus: ".$fechaFormatoInicial." - ".$fechaFormatoFinal;
        $urbSinSelect=[];
        $padresUrb=[];
        $ciudadSinUrb=[];
        $urbSelect=[];

        if ($ciudades!=0 && $urbanizaciones!=0) {

            $resultado=self::EstadosCiudadesEstatus($estadosSelect,$ciudadesSelect);
            $citySelect=$resultado['citySelect'];
            $estateSelect=$resultado['estateSelect'];
            
            for ($g=0; $g <count($urbanizacionesSelect) ; $g++) { 
                $aux4[]=Urbanizacion::where('id',$urbanizacionesSelect[$g])->first();
                $urbSelect[$g]['id']=$aux4[$g]->id;
                $urbSelect[$g]['padre']=$aux4[$g]->ciudad_id;
                $urbSelect[$g]['nombre']=$aux4[$g]->nombre;
                $urbSelect[$g]['activos']=count(Propiedad::where('estatus',1)->where('urbanizacion',$aux4[$g]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                $urbSelect[$g]['inactivos']=count(Propiedad::where('estatus',2)->where('urbanizacion',$aux4[$g]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                $urbSelect[$g]['vendidos']=count(Propiedad::where('estatus',11)->where('urbanizacion',$aux4[$g]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                $padresUrb[]= $urbSelect[$g]['padre'];
            }

            for ($h=0; $h <count($citySelect) ; $h++) { 
                if (!in_array($citySelect[$h]['id'],$padresUrb)) {
                    if (!in_array($citySelect[$h]['id'], $ciudadSinUrb)) {
                        $ciudadSinUrb[]=$citySelect[$h];
                    }
                }
            }
            for ($i=0; $i <count($ciudadSinUrb) ; $i++) { 
               $urbTodas[]=Urbanizacion::where('ciudad_id',$ciudadSinUrb[$i])->get();
               for ($j=0; $j <count($urbTodas[$i]) ; $j++) { 
                    $aux5[$j]['id']=$urbTodas[$i][$j]->id;
                    $aux5[$j]['padre']=$urbTodas[$i][$j]->ciudad_id;
                    $aux5[$j]['nombre']=$urbTodas[$i][$j]->nombre;
                    $aux5[$j]['activos']=count(Propiedad::where('estatus',1)->where('urbanizacion',$urbTodas[$i][$j]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                    $aux5[$j]['inactivos']=count(Propiedad::where('estatus',2)->where('urbanizacion',$urbTodas[$i][$j]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                    $aux5[$j]['vendidos']=count(Propiedad::where('estatus',11)->where('urbanizacion',$urbTodas[$i][$j]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                    $urbSinSelect[]=$aux5[$j];
               }
            }
            for ($k=0; $k <count($urbSinSelect) ; $k++ ){ 
                $urbSelect[]=$urbSinSelect[$k];
            }
        }

        else if($ciudades!=0 && $urbanizaciones==0){

            $resultado=self::EstadosCiudadesEstatus($estadosSelect,$ciudadesSelect);
            $citySelect=$resultado['citySelect'];
            $estateSelect=$resultado['estateSelect'];

            for ($i=0; $i <count($citySelect) ; $i++) { 
               $urbTodas[]=Urbanizacion::where('ciudad_id',$citySelect[$i])->get();
               for ($j=0; $j <count($urbTodas[$i]) ; $j++) { 
                    $aux5[$j]['id']=$urbTodas[$i][$j]->id;
                    $aux5[$j]['padre']=$urbTodas[$i][$j]->ciudad_id;
                    $aux5[$j]['nombre']=$urbTodas[$i][$j]->nombre;
                    $aux5[$j]['activos']=count(Propiedad::where('estatus',1)->where('urbanizacion',$urbTodas[$i][$j]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                    $aux5[$j]['inactivos']=count(Propiedad::where('estatus',2)->where('urbanizacion',$urbTodas[$i][$j]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                    $aux5[$j]['vendidos']=count(Propiedad::where('estatus',11)->where('urbanizacion',$urbTodas[$i][$j]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                    $urbSelect[]=$aux5[$j];
               }
            }
        }
        else if($ciudades==0 && $urbanizaciones==0){

            for ($a=0; $a <count($estadosSelect) ; $a++) { 
                $aux1[]=Estado::where('id',$estadosSelect[$a])->first();
                $estateSelect[$a]['id']=$aux1[$a]->id;
                $estateSelect[$a]['nombre']=$aux1[$a]->nombre;
                $estateSelect[$a]['activos']=0;
                $estateSelect[$a]['inactivos']=0;
                $estateSelect[$a]['vendidos']=0;
            }

            for ($d=0; $d <count($estateSelect) ; $d++) { 
               $cityAll[]=Ciudad::where('estado_id',$estateSelect[$d])->get();
               for ($e=0; $e <count( $cityAll[$d]) ; $e++) { 
                    $aux3[$e]['id']= $cityAll[$d][$e]->id;
                    $aux3[$e]['padre']= $cityAll[$d][$e]->estado_id;
                    $aux3[$e]['nombre']= $cityAll[$d][$e]->nombre;
                    $aux3[$e]['activos']= 0;
                    $aux3[$e]['inactivos']= 0;
                    $aux3[$e]['vendidos']= 0;
                    $citySelect[]=$aux3[$e];
               }
            }

            for ($i=0; $i <count($citySelect) ; $i++) { 
               $urbTodas[]=Urbanizacion::where('ciudad_id',$citySelect[$i])->get();
               for ($j=0; $j <count($urbTodas[$i]) ; $j++) { 
                    $aux5[$j]['id']=$urbTodas[$i][$j]->id;
                    $aux5[$j]['padre']=$urbTodas[$i][$j]->ciudad_id;
                    $aux5[$j]['nombre']=$urbTodas[$i][$j]->nombre;
                    $aux5[$j]['activos']=count(Propiedad::where('estatus',1)->where('urbanizacion',$urbTodas[$i][$j]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                    $aux5[$j]['inactivos']=count(Propiedad::where('estatus',2)->where('urbanizacion',$urbTodas[$i][$j]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                    $aux5[$j]['vendidos']=count(Propiedad::where('estatus',11)->where('urbanizacion',$urbTodas[$i][$j]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                    $urbSelect[]=$aux5[$j];
               }
            }

        }


        for ($l=0; $l <count($citySelect) ; $l++) { 
            for ($m=0; $m < count($urbSelect); $m++) { 
                if ($citySelect[$l]['id']==$urbSelect[$m]['padre']) {
                    $citySelect[$l]['activos']=$citySelect[$l]['activos']+$urbSelect[$m]['activos'];
                    $citySelect[$l]['inactivos']=$citySelect[$l]['inactivos']+$urbSelect[$m]['inactivos'];
                    $citySelect[$l]['vendidos']=$citySelect[$l]['vendidos']+$urbSelect[$m]['vendidos'];
                }
            }
        }

        for ($o=0; $o <count($estateSelect) ; $o++) { 
            for ($p=0; $p < count($citySelect); $p++) { 
                if ($estateSelect[$o]['id']==$citySelect[$p]['padre']) {
                    $estateSelect[$o]['activos']=$estateSelect[$o]['activos']+$citySelect[$p]['activos'];
                    $estateSelect[$o]['inactivos']=$estateSelect[$o]['inactivos']+$citySelect[$p]['inactivos'];
                    $estateSelect[$o]['vendidos']=$estateSelect[$o]['vendidos']+$citySelect[$p]['vendidos'];
                }
            }
        }

        $cantidades=['Activos'=>0,'Inactivos'=>0,'Vendidos'=>0];
        for($q=0; $q<count($estateSelect); $q++) { 
            $cantidades['Activos']=$cantidades['Activos']+$estateSelect[$q]['activos'];
            $cantidades['Inactivos']=$cantidades['Inactivos']+$estateSelect[$q]['inactivos'];
            $cantidades['Vendidos']=$cantidades['Vendidos']+$estateSelect[$q]['vendidos'];
        };

        return view('reportes.DistribucionEstatusUbicacion',compact('urbSelect','citySelect','estateSelect','titulo','cantidades'));
    }

    public function distribucionAsesorTipoInmueble($fechaI,$fechaF,$data){
        $seleccionados=explode(",", $data);
        $asesores=Agente::all();
        $titulo="Distribución de propiedades segun asesores por tipo de inmueble.";
        if ($data!=0) {
            $cantidades=['terreno'=>0,'local'=>0,'residencial'=>0,'vacacional'=>0,'industrial'=>0];
            for($i=0; $i<count($seleccionados); $i++) { 
                $cantidades['terreno']=$cantidades['terreno']+count(Propiedad::where('tipo_inmueble',1)->where('agente_id',$seleccionados[$i])->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                $cantidades['local']=$cantidades['local']+count(Propiedad::where('tipo_inmueble',2)->where('agente_id',$seleccionados[$i])->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                $cantidades['residencial']=$cantidades['residencial']+count(Propiedad::where('tipo_inmueble',3)->where('agente_id',$seleccionados[$i])->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                $cantidades['vacacional']=$cantidades['vacacional']+count(Propiedad::where('tipo_inmueble',4)->where('agente_id',$seleccionados[$i])->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                $cantidades['industrial']=$cantidades['industrial']+count(Propiedad::where('tipo_inmueble',5)->where('agente_id',$seleccionados[$i])->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
            };

            for($i=0; $i<count($seleccionados); $i++) { 
                $estatus[$i]['id']=$seleccionados[$i];
                $estatus[$i]['terreno']=count(Propiedad::where('tipo_inmueble',1)->where('agente_id',$seleccionados[$i])->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                $estatus[$i]['local']=count(Propiedad::where('tipo_inmueble',2)->where('agente_id',$seleccionados[$i])->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                $estatus[$i]['residencial']=count(Propiedad::where('tipo_inmueble',3)->where('agente_id',$seleccionados[$i])->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                $estatus[$i]['vacacional']=count(Propiedad::where('tipo_inmueble',4)->where('agente_id',$seleccionados[$i])->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                $estatus[$i]['industrial']=count(Propiedad::where('tipo_inmueble',5)->where('agente_id',$seleccionados[$i])->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
            };
        }
        else {
            $cantidades['terreno']=count(Propiedad::where('tipo_inmueble',1)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
            $cantidades['local']=count(Propiedad::where('tipo_inmueble',2)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
            $cantidades['residencial']=count(Propiedad::where('tipo_inmueble',3)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
            $cantidades['vacacional']=count(Propiedad::where('tipo_inmueble',4)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
            $cantidades['industrial']=count(Propiedad::where('tipo_inmueble',5)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());

            foreach ($asesores as $i => $value) {
                $estatus[$i]['id']=$asesores[$i]->id;
                $estatus[$i]['terreno']=count(Propiedad::where('tipo_inmueble',1)->where('agente_id',$asesores[$i]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                $estatus[$i]['local']=count(Propiedad::where('tipo_inmueble',2)->where('agente_id',$asesores[$i]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                $estatus[$i]['residencial']=count(Propiedad::where('tipo_inmueble',3)->where('agente_id',$asesores[$i]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                $estatus[$i]['vacacional']=count(Propiedad::where('tipo_inmueble',4)->where('agente_id',$asesores[$i]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                $estatus[$i]['industrial']=count(Propiedad::where('tipo_inmueble',5)->where('agente_id',$asesores[$i]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
            } 
        }
        return view('reportes.DistribucionTipoInmuebleAsesor',compact('titulo','asesores','estatus','cantidades'));
           
    }

    public function EstadosCiudadesTipoInmueble($estadosSelect,$ciudadesSelect){
        $citySinSelect=[];
        $estadoSinCiudad=[];
        $padresCiudad=[];

        for ($a=0; $a <count($estadosSelect) ; $a++) { 
            $aux1[]=Estado::where('id',$estadosSelect[$a])->first();
            $estateSelect[$a]['id']=$aux1[$a]->id;
            $estateSelect[$a]['nombre']=$aux1[$a]->nombre;
            $estateSelect[$a]['terreno']=0;
            $estateSelect[$a]['local']=0;
            $estateSelect[$a]['residencial']=0;
            $estateSelect[$a]['vacacional']=0;
            $estateSelect[$a]['industrial']=0;
        }

        for ($b=0; $b <count($ciudadesSelect) ; $b++) { 
            $aux2[]=Ciudad::where('id',$ciudadesSelect[$b])->first();
            $citySelect[$b]['id']=$aux2[$b]->id;
            $citySelect[$b]['padre']=$aux2[$b]->estado_id;
            $citySelect[$b]['nombre']=$aux2[$b]->nombre;
            $citySelect[$b]['terreno']=0;
            $citySelect[$b]['local']=0;
            $citySelect[$b]['residencial']=0;
            $citySelect[$b]['vacacional']=0;
            $citySelect[$b]['industrial']=0;
            $padresCiudad[]= $citySelect[$b]['padre'];
        }

        for ($c=0; $c <count($estadosSelect) ; $c++) { 
            if (!in_array($estadosSelect[$c],$padresCiudad)) {
                if (!in_array($estadosSelect[$c], $estadoSinCiudad)) {
                    $estadoSinCiudad[]=$estadosSelect[$c];
                }
            }
        }

        for ($d=0; $d <count($estadoSinCiudad) ; $d++) { 
           $cityAll[]=Ciudad::where('estado_id',$estadoSinCiudad[$d])->get();
           for ($e=0; $e <count( $cityAll[$d]) ; $e++) { 
                $aux3[$e]['id']= $cityAll[$d][$e]->id;
                $aux3[$e]['padre']= $cityAll[$d][$e]->estado_id;
                $aux3[$e]['nombre']= $cityAll[$d][$e]->nombre;
                $aux3[$e]['terreno']= 0;
                $aux3[$e]['local']= 0;
                $aux3[$e]['residencial']= 0;
                $aux3[$e]['vacacional']= 0;
                $aux3[$e]['industrial']= 0;
                $citySinSelect[]=$aux3[$e];
           }
        }
        for ($f=0; $f <count($citySinSelect) ; $f++ ){ 
            $citySelect[]=$citySinSelect[$f];
        }
        return compact('citySelect','estateSelect');
    }

    public function distribucionUbicacionTipoInmueble($fechaI,$fechaF,$estados,$ciudades,$urbanizaciones){
        $estadosSelect=explode(",", $estados);
        $ciudadesSelect=explode(",", $ciudades);
        $urbanizacionesSelect=explode(",", $urbanizaciones);
        $fechaFormatoInicial=date("d/m/Y", strtotime($fechaI));
        $fechaFormatoFinal=date("d/m/Y", strtotime($fechaF));
        $titulo="Distribución de propiedades captadas segun ubicación por tipo de Inmueble ".$fechaFormatoInicial." - ".$fechaFormatoFinal;
        $urbSinSelect=[];
        $padresUrb=[];
        $ciudadSinUrb=[];
        $urbSelect=[];

        if ($ciudades!=0 && $urbanizaciones!=0) {

            $resultado=self::EstadosCiudadesTipoInmueble($estadosSelect,$ciudadesSelect);
            $citySelect=$resultado['citySelect'];
            $estateSelect=$resultado['estateSelect'];
            
            for ($g=0; $g <count($urbanizacionesSelect) ; $g++) { 
                $aux4[]=Urbanizacion::where('id',$urbanizacionesSelect[$g])->first();
                $urbSelect[$g]['id']=$aux4[$g]->id;
                $urbSelect[$g]['padre']=$aux4[$g]->ciudad_id;
                $urbSelect[$g]['nombre']=$aux4[$g]->nombre;
                $urbSelect[$g]['terreno']=count(Propiedad::where('tipo_inmueble',1)->where('urbanizacion',$aux4[$g]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                $urbSelect[$g]['local']=count(Propiedad::where('tipo_inmueble',2)->where('urbanizacion',$aux4[$g]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                $urbSelect[$g]['residencial']=count(Propiedad::where('tipo_inmueble',3)->where('urbanizacion',$aux4[$g]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                $urbSelect[$g]['vacacional']=count(Propiedad::where('tipo_inmueble',4)->where('urbanizacion',$aux4[$g]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                $urbSelect[$g]['industrial']=count(Propiedad::where('tipo_inmueble',5)->where('urbanizacion',$aux4[$g]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                $padresUrb[]= $urbSelect[$g]['padre'];
            }

            for ($h=0; $h <count($citySelect) ; $h++) { 
                if (!in_array($citySelect[$h]['id'],$padresUrb)) {
                    if (!in_array($citySelect[$h]['id'], $ciudadSinUrb)) {
                        $ciudadSinUrb[]=$citySelect[$h];
                    }
                }
            }
            for ($i=0; $i <count($ciudadSinUrb) ; $i++) { 
               $urbTodas[]=Urbanizacion::where('ciudad_id',$ciudadSinUrb[$i])->get();
               for ($j=0; $j <count($urbTodas[$i]) ; $j++) { 
                    $aux5[$j]['id']=$urbTodas[$i][$j]->id;
                    $aux5[$j]['padre']=$urbTodas[$i][$j]->ciudad_id;
                    $aux5[$j]['nombre']=$urbTodas[$i][$j]->nombre;
                    $aux5[$j]['terreno']=count(Propiedad::where('tipo_inmueble',1)->where('urbanizacion',$urbTodas[$i][$j]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                    $aux5[$j]['local']=count(Propiedad::where('tipo_inmueble',2)->where('urbanizacion',$urbTodas[$i][$j]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                    $aux5[$j]['residencial']=count(Propiedad::where('tipo_inmueble',3)->where('urbanizacion',$urbTodas[$i][$j]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                    $aux5[$j]['vacacional']=count(Propiedad::where('tipo_inmueble',4)->where('urbanizacion',$urbTodas[$i][$j]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                    $aux5[$j]['industrial']=count(Propiedad::where('tipo_inmueble',5)->where('urbanizacion',$urbTodas[$i][$j]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                    $urbSinSelect[]=$aux5[$j];
               }
            }
            for ($k=0; $k <count($urbSinSelect) ; $k++ ){ 
                $urbSelect[]=$urbSinSelect[$k];
            }
        }

        else if($ciudades!=0 && $urbanizaciones==0){

            $resultado=self::EstadosCiudadesTipoInmueble($estadosSelect,$ciudadesSelect);
            $citySelect=$resultado['citySelect'];
            $estateSelect=$resultado['estateSelect'];

            for ($i=0; $i <count($citySelect) ; $i++) { 
               $urbTodas[]=Urbanizacion::where('ciudad_id',$citySelect[$i])->get();
               for ($j=0; $j <count($urbTodas[$i]) ; $j++) { 
                    $aux5[$j]['id']=$urbTodas[$i][$j]->id;
                    $aux5[$j]['padre']=$urbTodas[$i][$j]->ciudad_id;
                    $aux5[$j]['nombre']=$urbTodas[$i][$j]->nombre;
                    $aux5[$j]['terreno']=count(Propiedad::where('tipo_inmueble',1)->where('urbanizacion',$urbTodas[$i][$j]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                    $aux5[$j]['local']=count(Propiedad::where('tipo_inmueble',2)->where('urbanizacion',$urbTodas[$i][$j]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                    $aux5[$j]['residencial']=count(Propiedad::where('tipo_inmueble',3)->where('urbanizacion',$urbTodas[$i][$j]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                    $aux5[$j]['vacacional']=count(Propiedad::where('tipo_inmueble',4)->where('urbanizacion',$urbTodas[$i][$j]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                    $aux5[$j]['industrial']=count(Propiedad::where('tipo_inmueble',5)->where('urbanizacion',$urbTodas[$i][$j]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                    $urbSelect[]=$aux5[$j];
               }
            }
        }
        else if($ciudades==0 && $urbanizaciones==0){

            for ($a=0; $a <count($estadosSelect) ; $a++) { 
                $aux1[]=Estado::where('id',$estadosSelect[$a])->first();
                $estateSelect[$a]['id']=$aux1[$a]->id;
                $estateSelect[$a]['nombre']=$aux1[$a]->nombre;
                $estateSelect[$a]['terreno']=0;
                $estateSelect[$a]['local']=0;
                $estateSelect[$a]['residencial']=0;
                $estateSelect[$a]['vacacional']=0;
                $estateSelect[$a]['industrial']=0;
            }

            for ($d=0; $d <count($estateSelect) ; $d++) { 
               $cityAll[]=Ciudad::where('estado_id',$estateSelect[$d])->get();
               for ($e=0; $e <count( $cityAll[$d]) ; $e++) { 
                    $aux3[$e]['id']= $cityAll[$d][$e]->id;
                    $aux3[$e]['padre']= $cityAll[$d][$e]->estado_id;
                    $aux3[$e]['nombre']= $cityAll[$d][$e]->nombre;
                    $aux3[$e]['terreno']= 0;
                    $aux3[$e]['local']= 0;
                    $aux3[$e]['residencial']= 0;
                    $aux3[$e]['vacacional']= 0;
                    $aux3[$e]['industrial']= 0;
                    $citySelect[]=$aux3[$e];
               }
            }

            for ($i=0; $i <count($citySelect) ; $i++) { 
               $urbTodas[]=Urbanizacion::where('ciudad_id',$citySelect[$i])->get();
               for ($j=0; $j <count($urbTodas[$i]) ; $j++) { 
                    $aux5[$j]['id']=$urbTodas[$i][$j]->id;
                    $aux5[$j]['padre']=$urbTodas[$i][$j]->ciudad_id;
                    $aux5[$j]['nombre']=$urbTodas[$i][$j]->nombre;
                    $aux5[$j]['terreno']=count(Propiedad::where('tipo_inmueble',1)->where('urbanizacion',$urbTodas[$i][$j]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                    $aux5[$j]['local']=count(Propiedad::where('tipo_inmueble',2)->where('urbanizacion',$urbTodas[$i][$j]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                    $aux5[$j]['residencial']=count(Propiedad::where('tipo_inmueble',3)->where('urbanizacion',$urbTodas[$i][$j]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                    $aux5[$j]['vacacional']=count(Propiedad::where('tipo_inmueble',4)->where('urbanizacion',$urbTodas[$i][$j]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                    $aux5[$j]['industrial']=count(Propiedad::where('tipo_inmueble',5)->where('urbanizacion',$urbTodas[$i][$j]->id)->whereBetween('fechaCreado', [$fechaI,$fechaF])->get());
                    $urbSelect[]=$aux5[$j];
               }
            }

        }


        for ($l=0; $l <count($citySelect) ; $l++) { 
            for ($m=0; $m < count($urbSelect); $m++) { 
                if ($citySelect[$l]['id']==$urbSelect[$m]['padre']) {
                    $citySelect[$l]['terreno']=$citySelect[$l]['terreno']+$urbSelect[$m]['terreno'];
                    $citySelect[$l]['local']=$citySelect[$l]['local']+$urbSelect[$m]['local'];
                    $citySelect[$l]['residencial']=$citySelect[$l]['residencial']+$urbSelect[$m]['residencial'];
                    $citySelect[$l]['vacacional']=$citySelect[$l]['vacacional']+$urbSelect[$m]['vacacional'];
                    $citySelect[$l]['industrial']=$citySelect[$l]['industrial']+$urbSelect[$m]['industrial'];
                }
            }
        }

        for ($o=0; $o <count($estateSelect) ; $o++) { 
            for ($p=0; $p < count($citySelect); $p++) { 
                if ($estateSelect[$o]['id']==$citySelect[$p]['padre']) {
                    $estateSelect[$o]['terreno']=$estateSelect[$o]['terreno']+$citySelect[$p]['terreno'];
                    $estateSelect[$o]['local']=$estateSelect[$o]['local']+$citySelect[$p]['local'];
                    $estateSelect[$o]['residencial']=$estateSelect[$o]['residencial']+$citySelect[$p]['residencial'];
                    $estateSelect[$o]['vacacional']=$estateSelect[$o]['vacacional']+$citySelect[$p]['vacacional'];
                    $estateSelect[$o]['industrial']=$estateSelect[$o]['industrial']+$citySelect[$p]['industrial'];
                }
            }
        }

        $cantidades=['terreno'=>0,'local'=>0,'residencial'=>0,'vacacional'=>0,'industrial'=>0];
        for($q=0; $q<count($estateSelect); $q++) { 
            $cantidades['terreno']=$cantidades['terreno']+$estateSelect[$q]['terreno'];
            $cantidades['local']=$cantidades['local']+$estateSelect[$q]['local'];
            $cantidades['residencial']=$cantidades['residencial']+$estateSelect[$q]['residencial'];
            $cantidades['vacacional']=$cantidades['vacacional']+$estateSelect[$q]['vacacional'];
            $cantidades['industrial']=$cantidades['industrial']+$estateSelect[$q]['industrial'];
        };

        return view('reportes.DistribucionTipoInmuebleUbicacion',compact('urbSelect','citySelect','estateSelect','titulo','cantidades'));
    }


    public function captadasAsesorFiltro($fechaI,$fechaF,$precioI,$precioF,$asesores){
        
        $seleccionados=explode(",", $asesores);
        $fechaFormatoInicial=date("d/m/Y", strtotime($fechaI));
        $fechaFormatoFinal=date("d/m/Y", strtotime($fechaF));
        $titulo="Propiedades captadas por asesor segun rango de fechas: ".$fechaFormatoInicial." - ".$fechaFormatoFinal;
        $propiedadesT=[];
        $totales=['totalPropiedades'=>0,'visitas'=>0,'precioPromedio'=>0,'comisionPromedio'=>0,'sumaPrecio'=>0,'sumaComision'=>0];

        if ($asesores!=0) {
            
            for($i=0; $i<count($seleccionados); $i++) { 
                $asesor=Agente::where('id',$seleccionados[$i])->first();
                $listaAsesores[$i]['id']=$asesor->id;
                $listaAsesores[$i]['codigo']=$asesor->codigo_id;
                $listaAsesores[$i]['nombre']=$asesor->fullName;
                $listaAsesores[$i]['precioPromedio']=0;
                $listaAsesores[$i]['sumaPrecio']=0;
                $listaAsesores[$i]['comisionPromedio']=0;
                $listaAsesores[$i]['sumaComision']=0;
                $listaAsesores[$i]['visitas']=0;

                
                $inmuebles=Propiedad::join('tipoinmueble','propiedades.tipo_inmueble','tipoinmueble.id')
                                    ->join('ciudades','propiedades.ciudad_id','ciudades.id')
                                    ->newQuery();
                $inmuebles->select('propiedades.*','ciudades.nombre as nombreCiudad','tipoinmueble.nombre as nombreInmueble');
                $inmuebles->where('propiedades.agente_id', $seleccionados[$i]);
                $inmuebles->whereBetween('propiedades.fechaCreado', [$fechaI,$fechaF]);
                if ($precioF!=0) {
                    $inmuebles->whereBetween('propiedades.precio', [$precioI,$precioF]);
                }
                $inmuebles=$inmuebles->get();
                $listaAsesores[$i]['cantidadPropiedades']=count($inmuebles);    
                    foreach ($inmuebles as $inmueble){
                        for ($c=0; $c <count($inmueble); $c++) { 
                            $propiedades[$c]['id']=$inmueble->id;
                            $propiedades[$c]['mls']=$inmueble->id_mls;
                            $propiedades[$c]['tipoInmueble']=$inmueble->nombreInmueble;
                            $propiedades[$c]['tipoNegocio']=$inmueble->tipoNegocio;
                            $propiedades[$c]['ciudad']=$inmueble->nombreCiudad;
                            $propiedades[$c]['precio']=$inmueble->precio;
                            $propiedades[$c]['comisionCaptacion']=(float)$inmueble->porcentajeCaptacion;
                            $propiedades[$c]['fecha']=$inmueble->fechaCreado;
                            $propiedades[$c]['visitas']=$inmueble->visitas;
                            $propiedades[$c]['agente']=$inmueble->agente_id; 
                            $propiedadesT[]=$propiedades[$c];
                        }
                    }
            }
        }
        else{

            $asesores=Agente::all();
            foreach ($asesores as $i=>$value) {
                $listaAsesores[$i]['id']=$asesores[$i]->id;
                $listaAsesores[$i]['codigo']=$asesores[$i]->codigo_id;
                $listaAsesores[$i]['nombre']=$asesores[$i]->fullName;
                $listaAsesores[$i]['precioPromedio']=0;
                $listaAsesores[$i]['sumaPrecio']=0;
                $listaAsesores[$i]['comisionPromedio']=0;
                $listaAsesores[$i]['sumaComision']=0;
                $listaAsesores[$i]['visitas']=0;
            
                $inmuebles=Propiedad::join('tipoinmueble','propiedades.tipo_inmueble','tipoinmueble.id')
                                    ->join('ciudades','propiedades.ciudad_id','ciudades.id')
                                    ->newQuery();
                $inmuebles->select('propiedades.*','ciudades.nombre as nombreCiudad','tipoinmueble.nombre as nombreInmueble');
                $inmuebles->where('propiedades.agente_id', $asesores[$i]->id);
                $inmuebles->whereBetween('propiedades.fechaCreado', [$fechaI,$fechaF]);
                if ($precioF!=0) {
                    $inmuebles->whereBetween('propiedades.precio', [$precioMin,$precioMax]);
                }
                $inmuebles=$inmuebles->get();
                $listaAsesores[$i]['cantidadPropiedades']=count($inmuebles);    
                    foreach ($inmuebles as $inmueble){
                        for ($c=0; $c <count($inmueble); $c++) { 
                            $propiedades[$c]['id']=$inmueble->id;
                            $propiedades[$c]['mls']=$inmueble->id_mls;
                            $propiedades[$c]['tipoInmueble']=$inmueble->nombreInmueble;
                            $propiedades[$c]['tipoNegocio']=$inmueble->tipoNegocio;
                            $propiedades[$c]['ciudad']=$inmueble->nombreCiudad;
                            $propiedades[$c]['precio']=$inmueble->precio;
                            $propiedades[$c]['comisionCaptacion']=(float)$inmueble->porcentajeCaptacion;
                            $propiedades[$c]['fecha']=$inmueble->fechaCreado;
                            $propiedades[$c]['visitas']=$inmueble->visitas;
                            $propiedades[$c]['agente']=$inmueble->agente_id; 
                            $propiedadesT[]=$propiedades[$c];
                        }
                    }



            }
        }

        for ($a=0; $a < count($listaAsesores); $a++) { 
            for ($b=0; $b < count($propiedadesT); $b++) { 
                if ($listaAsesores[$a]['id']==$propiedadesT[$b]['agente']) {
                    $listaAsesores[$a]['sumaPrecio']=$listaAsesores[$a]['sumaPrecio']+$propiedadesT[$b]['precio'];
                    $listaAsesores[$a]['sumaComision']=$listaAsesores[$a]['sumaComision']+$propiedadesT[$b]['comisionCaptacion'];
                    $listaAsesores[$a]['visitas']=$listaAsesores[$a]['visitas']+$propiedadesT[$b]['visitas'];
                }
            }
            if ($listaAsesores[$a]['cantidadPropiedades']!=0) {
                $listaAsesores[$a]['precioPromedio']=$listaAsesores[$a]['sumaPrecio']/$listaAsesores[$a]['cantidadPropiedades'];
                $listaAsesores[$a]['comisionPromedio']=$listaAsesores[$a]['sumaComision']/$listaAsesores[$a]['cantidadPropiedades'];
            }
            
        }
            
        for($i=0; $i<count($listaAsesores); $i++) { 
            $totales['totalPropiedades']=$totales['totalPropiedades']+$listaAsesores[$i]['cantidadPropiedades'];
            $totales['visitas']=$totales['visitas']+$listaAsesores[$i]['visitas'];
            $totales['sumaPrecio']=$totales['sumaPrecio']+$listaAsesores[$i]['sumaPrecio'];
            $totales['sumaComision']=$totales['sumaComision']+$listaAsesores[$i]['sumaComision'];
        };
        if ($totales['totalPropiedades']!=0) {
            $totales['precioPromedio']=$totales['sumaPrecio']/$totales['totalPropiedades'];
            $totales['comisionPromedio']=$totales['sumaComision']/$totales['totalPropiedades'];
        }

        return view('reportes.PropiedadesCaptadasAsesor',compact('titulo','listaAsesores','propiedadesT','totales'));
           
    }

    public function EstadosCiudadesUrbPropCaptada($estadosSelect,$ciudadesSelect){
        $citySinSelect=[];
        $estadoSinCiudad=[];
        $padresCiudad=[];

        for ($a=0; $a <count($estadosSelect) ; $a++) { 
            $aux1[]=Estado::where('id',$estadosSelect[$a])->first();
            $estateSelect[$a]['id']=$aux1[$a]->id;
            $estateSelect[$a]['nombre']=$aux1[$a]->nombre;
            $estateSelect[$a]['cantidadPropiedades']=0;
            $estateSelect[$a]['precioPromedio']=0;
            $estateSelect[$a]['sumaPrecio']=0;
            $estateSelect[$a]['comisionPromedio']=0;
            $estateSelect[$a]['sumaComision']=0;
            $estateSelect[$a]['visitas']=0;
        }

        for ($b=0; $b <count($ciudadesSelect) ; $b++) { 
            $aux2[]=Ciudad::where('id',$ciudadesSelect[$b])->first();
            $citySelect[$b]['id']=$aux2[$b]->id;
            $citySelect[$b]['padre']=$aux2[$b]->estado_id;
            $citySelect[$b]['nombre']=$aux2[$b]->nombre;
            $citySelect[$b]['cantidadPropiedades']=0;
            $citySelect[$b]['precioPromedio']=0;
            $citySelect[$b]['sumaPrecio']=0;
            $citySelect[$b]['comisionPromedio']=0;
            $citySelect[$b]['sumaComision']=0;
            $citySelect[$b]['visitas']=0;
            $padresCiudad[]= $citySelect[$b]['padre'];
        }


        for ($c=0; $c <count($estadosSelect) ; $c++) { 
            if (!in_array($estadosSelect[$c],$padresCiudad)) {
                if (!in_array($estadosSelect[$c], $estadoSinCiudad)) {
                    $estadoSinCiudad[]=$estadosSelect[$c];
                }
            }
        }

        for ($d=0; $d <count($estadoSinCiudad) ; $d++) { 
           $cityAll[]=Ciudad::where('estado_id',$estadoSinCiudad[$d])->get();
           for ($e=0; $e <count( $cityAll[$d]) ; $e++) { 
                $aux3[$e]['id']= $cityAll[$d][$e]->id;
                $aux3[$e]['padre']= $cityAll[$d][$e]->estado_id;
                $aux3[$e]['nombre']= $cityAll[$d][$e]->nombre;
                $aux3[$e]['cantidadPropiedades']= 0;
                $aux3[$e]['precioPromedio']= 0;
                $aux3[$e]['sumaPrecio']= 0;
                $aux3[$e]['comisionPromedio']= 0;
                $aux3[$e]['sumaComision']= 0;
                $aux3[$e]['visitas']= 0;
                $citySinSelect[]=$aux3[$e];
           }
        }
        for ($f=0; $f <count($citySinSelect) ; $f++ ){ 
            $citySelect[]=$citySinSelect[$f];
        }

        return compact('estateSelect','citySelect');
    }

    public function captadasUbicacion($fechaI,$fechaF,$precioI,$precioF,$estados,$ciudades,$urbanizaciones){
        $estadosSelect=explode(",", $estados);
        $ciudadesSelect=explode(",", $ciudades);
        $urbanizacionesSelect=explode(",", $urbanizaciones);
        $fechaFormatoInicial=date("d/m/Y", strtotime($fechaI));
        $fechaFormatoFinal=date("d/m/Y", strtotime($fechaF));
        $titulo="Propiedades captadas por ubicación segun rango de fechas: ".$fechaFormatoInicial." - ".$fechaFormatoFinal;
        $propiedadesT=[];
        $padresUrb=[];
        $ciudadSinUrb=[];
        $urbSelect=[];
        $urbSinSelect=[];
        $totales=['totalPropiedades'=>0,'visitas'=>0,'precioPromedio'=>0,'comisionPromedio'=>0,'sumaPrecio'=>0,'sumaComision'=>0];
  
        

        if ($ciudades!=0 && $urbanizaciones!=0) {

            $resultado=self::EstadosCiudadesUrbPropCaptada($estadosSelect,$ciudadesSelect);
            $estateSelect=$resultado['estateSelect'];
            $citySelect=$resultado['citySelect'];

            for ($f=0; $f <count($urbanizacionesSelect) ; $f++) { 
                $aux4[]=Urbanizacion::where('id',$urbanizacionesSelect[$f])->first();
                $urbSelect[$f]['id']=$aux4[$f]->id;
                $urbSelect[$f]['padre']=$aux4[$f]->ciudad_id;
                $urbSelect[$f]['nombre']=$aux4[$f]->nombre;
                $urbSelect[$f]['cantidadPropiedades']=0;
                $urbSelect[$f]['precioPromedio']=0;
                $urbSelect[$f]['sumaPrecio']=0;
                $urbSelect[$f]['comisionPromedio']=0;
                $urbSelect[$f]['sumaComision']=0;
                $urbSelect[$f]['visitas']=0;
                $padresUrb[]= $urbSelect[$f]['padre'];
            }
            for ($h=0; $h <count($citySelect) ; $h++) { 
                if (!in_array($citySelect[$h]['id'],$padresUrb)) {
                    if (!in_array($citySelect[$h]['id'], $ciudadSinUrb)) {
                        $ciudadSinUrb[]=$citySelect[$h];
                    }
                }
            }
            for ($i=0; $i <count($ciudadSinUrb) ; $i++) { 
               $urbTodas[]=Urbanizacion::where('ciudad_id',$ciudadSinUrb[$i])->get();
               for ($j=0; $j <count($urbTodas[$i]) ; $j++) { 
                    $aux5[$j]['id']=$urbTodas[$i][$j]->id;
                    $aux5[$j]['padre']=$urbTodas[$i][$j]->ciudad_id;
                    $aux5[$j]['nombre']=$urbTodas[$i][$j]->nombre;
                    $aux5[$j]['cantidadPropiedades']=0;
                    $aux5[$j]['precioPromedio']=0;
                    $aux5[$j]['sumaPrecio']=0;
                    $aux5[$j]['comisionPromedio']=0;
                    $aux5[$j]['sumaComision']=0;
                    $aux5[$j]['visitas']=0;
                    $urbSinSelect[]=$aux5[$j];
               }
            }
            for ($k=0; $k <count($urbSinSelect) ; $k++ ){ 
                $urbSelect[]=$urbSinSelect[$k];
            }
        } 
        else if($ciudades!=0 && $urbanizaciones==0){

            $resultado=self::EstadosCiudadesUrbPropCaptada($estadosSelect,$ciudadesSelect);
            $estateSelect=$resultado['estateSelect'];
            $citySelect=$resultado['citySelect'];

            for ($i=0; $i <count($citySelect) ; $i++) { 
               $urbTodas[]=Urbanizacion::where('ciudad_id',$citySelect[$i])->get();
               for ($j=0; $j <count($urbTodas[$i]) ; $j++) { 
                    $aux5[$j]['id']=$urbTodas[$i][$j]->id;
                    $aux5[$j]['padre']=$urbTodas[$i][$j]->ciudad_id;
                    $aux5[$j]['nombre']=$urbTodas[$i][$j]->nombre;
                    $aux5[$j]['cantidadPropiedades']=0;
                    $aux5[$j]['precioPromedio']=0;
                    $aux5[$j]['sumaPrecio']=0;
                    $aux5[$j]['comisionPromedio']=0;
                    $aux5[$j]['sumaComision']=0;
                    $aux5[$j]['visitas']=0;
                    $urbSelect[]=$aux5[$j];
               }
            }


        }
        else if($ciudades==0 && $urbanizaciones==0){
            for ($a=0; $a <count($estadosSelect) ; $a++) { 
                $aux1[]=Estado::where('id',$estadosSelect[$a])->first();
                $estateSelect[$a]['id']=$aux1[$a]->id;
                $estateSelect[$a]['nombre']=$aux1[$a]->nombre;
                $estateSelect[$a]['cantidadPropiedades']=0;
                $estateSelect[$a]['precioPromedio']=0;
                $estateSelect[$a]['sumaPrecio']=0;
                $estateSelect[$a]['comisionPromedio']=0;
                $estateSelect[$a]['sumaComision']=0;
                $estateSelect[$a]['visitas']=0;
            }

            for ($d=0; $d <count($estateSelect) ; $d++) { 
               $cityAll[]=Ciudad::where('estado_id',$estateSelect[$d])->get();
               for ($e=0; $e <count( $cityAll[$d]) ; $e++) { 
                    $aux3[$e]['id']= $cityAll[$d][$e]->id;
                    $aux3[$e]['padre']= $cityAll[$d][$e]->estado_id;
                    $aux3[$e]['nombre']= $cityAll[$d][$e]->nombre;
                    $aux3[$e]['cantidadPropiedades']= 0;
                    $aux3[$e]['precioPromedio']= 0;
                    $aux3[$e]['sumaPrecio']= 0;
                    $aux3[$e]['comisionPromedio']= 0;
                    $aux3[$e]['sumaComision']= 0;
                    $aux3[$e]['visitas']= 0;
                    $citySelect[]=$aux3[$e];
               }
            }

            for ($i=0; $i <count($citySelect) ; $i++) { 
               $urbTodas[]=Urbanizacion::where('ciudad_id',$citySelect[$i])->get();
               for ($j=0; $j <count($urbTodas[$i]) ; $j++) { 
                    $aux5[$j]['id']=$urbTodas[$i][$j]->id;
                    $aux5[$j]['padre']=$urbTodas[$i][$j]->ciudad_id;
                    $aux5[$j]['nombre']=$urbTodas[$i][$j]->nombre;
                    $aux5[$j]['cantidadPropiedades']=0;
                    $aux5[$j]['precioPromedio']=0;
                    $aux5[$j]['sumaPrecio']=0;
                    $aux5[$j]['comisionPromedio']=0;
                    $aux5[$j]['sumaComision']=0;
                    $aux5[$j]['visitas']=0;
                    $urbSelect[]=$aux5[$j];
               }
            }
        }

        for($i=0; $i<count($urbSelect); $i++) { 
            $inmuebles=Propiedad::join('tipoinmueble','propiedades.tipo_inmueble','tipoinmueble.id')
                                ->join('agentes','propiedades.agente_id','agentes.id')
                                ->newQuery();
            $inmuebles->select('propiedades.*','agentes.fullName','tipoinmueble.nombre as nombreInmueble');
            $inmuebles->where('propiedades.urbanizacion', $urbSelect[$i]['id']);
            $inmuebles->whereBetween('propiedades.fechaCreado', [$fechaI,$fechaF]);
            if ($precioF!=0) {
                $inmuebles->whereBetween('propiedades.precio', [$precioI,$precioF]);
            }
            $inmuebles=$inmuebles->get();
            $urbSelect[$i]['cantidadPropiedades']=count($inmuebles);    
                foreach ($inmuebles as $inmueble){
                    for ($c=0; $c <count($inmueble); $c++) { 
                        $propiedades[$c]['id']=$inmueble->id;
                        $propiedades[$c]['mls']=$inmueble->id_mls;
                        $propiedades[$c]['tipoInmueble']=$inmueble->nombreInmueble;
                        $propiedades[$c]['tipoNegocio']=$inmueble->tipoNegocio;
                        $propiedades[$c]['fullName']=$inmueble->fullName;
                        $propiedades[$c]['precio']=$inmueble->precio;
                        $propiedades[$c]['comisionCaptacion']=(float)$inmueble->porcentajeCaptacion;
                        $propiedades[$c]['fecha']=$inmueble->fechaCreado;
                        $propiedades[$c]['visitas']=$inmueble->visitas;
                        $propiedades[$c]['padre']=$inmueble->urbanizacion; 
                        $propiedadesT[]=$propiedades[$c];
                    }
                }
        }

        for ($a=0; $a < count($urbSelect); $a++) { 
            for ($b=0; $b < count($propiedadesT); $b++) { 
                if ($urbSelect[$a]['id']==$propiedadesT[$b]['padre']) {
                    $urbSelect[$a]['sumaPrecio']=$urbSelect[$a]['sumaPrecio']+$propiedadesT[$b]['precio'];
                    $urbSelect[$a]['sumaComision']=$urbSelect[$a]['sumaComision']+$propiedadesT[$b]['comisionCaptacion'];
                    $urbSelect[$a]['visitas']=$urbSelect[$a]['visitas']+$propiedadesT[$b]['visitas'];
                }
            }
            if ($urbSelect[$a]['cantidadPropiedades']!=0) {
                $urbSelect[$a]['precioPromedio']=$urbSelect[$a]['sumaPrecio']/$urbSelect[$a]['cantidadPropiedades'];
                $urbSelect[$a]['comisionPromedio']=$urbSelect[$a]['sumaComision']/$urbSelect[$a]['cantidadPropiedades'];
            }
        }
        for ($a=0; $a < count($citySelect); $a++) { 
            for ($b=0; $b < count($urbSelect); $b++) { 
                if ($citySelect[$a]['id']==$urbSelect[$b]['padre']) {
                    $citySelect[$a]['sumaPrecio']=$citySelect[$a]['sumaPrecio']+$urbSelect[$b]['sumaPrecio'];
                    $citySelect[$a]['sumaComision']=$citySelect[$a]['sumaComision']+$urbSelect[$b]['sumaComision'];
                    $citySelect[$a]['visitas']=$citySelect[$a]['visitas']+$urbSelect[$b]['visitas'];
                    $citySelect[$a]['cantidadPropiedades']=$citySelect[$a]['cantidadPropiedades']+$urbSelect[$b]['cantidadPropiedades'];
                }
            }
            if ($citySelect[$a]['cantidadPropiedades']!=0) {
                $citySelect[$a]['precioPromedio']=$citySelect[$a]['sumaPrecio']/$citySelect[$a]['cantidadPropiedades'];
                $citySelect[$a]['comisionPromedio']=$citySelect[$a]['sumaComision']/$citySelect[$a]['cantidadPropiedades'];
            }
        }
        for ($a=0; $a < count($estateSelect); $a++) { 
            for ($b=0; $b < count($citySelect); $b++) { 
                if ($estateSelect[$a]['id']==$citySelect[$b]['padre']) {
                    $estateSelect[$a]['sumaPrecio']=$estateSelect[$a]['sumaPrecio']+$citySelect[$b]['sumaPrecio'];
                    $estateSelect[$a]['sumaComision']=$estateSelect[$a]['sumaComision']+$citySelect[$b]['sumaComision'];
                    $estateSelect[$a]['visitas']=$estateSelect[$a]['visitas']+$citySelect[$b]['visitas'];
                    $estateSelect[$a]['cantidadPropiedades']=$estateSelect[$a]['cantidadPropiedades']+$citySelect[$b]['cantidadPropiedades'];
                }
            }
            if ($estateSelect[$a]['cantidadPropiedades']!=0) {
                $estateSelect[$a]['precioPromedio']=$estateSelect[$a]['sumaPrecio']/$estateSelect[$a]['cantidadPropiedades'];
                $estateSelect[$a]['comisionPromedio']=$estateSelect[$a]['sumaComision']/$estateSelect[$a]['cantidadPropiedades'];
            }
        }
        for ($b=0; $b < count($estateSelect); $b++) { 
            $totales['sumaPrecio']=$totales['sumaPrecio']+$estateSelect[$b]['sumaPrecio'];
            $totales['sumaComision']=$totales['sumaComision']+$estateSelect[$b]['sumaComision'];
            $totales['visitas']=$totales['visitas']+$estateSelect[$b]['visitas'];
            $totales['totalPropiedades']=$totales['totalPropiedades']+$estateSelect[$b]['cantidadPropiedades'];

            if ($totales['totalPropiedades']!=0) {
                $totales['precioPromedio']=$totales['sumaPrecio']/$totales['totalPropiedades'];
                $totales['comisionPromedio']=$totales['sumaComision']/$totales['totalPropiedades'];
            }
        }
        

        return view('reportes.PropiedadesCaptadasUbicacion',compact('urbSelect','citySelect','estateSelect','titulo','totales','propiedadesT')); 
    }

    public function vendidasAsesorFiltro($fechaI,$fechaF,$precioI,$precioF,$asesores){
        
        $seleccionados=explode(",", $asesores);
        $fechaFormatoInicial=date("d/m/Y", strtotime($fechaI));
        $fechaFormatoFinal=date("d/m/Y", strtotime($fechaF));
        $titulo="Propiedades vendidas por asesor segun rango de fechas: ".$fechaFormatoInicial." - ".$fechaFormatoFinal;
        $propiedadesT=[];
        $totales=['totalPropiedades'=>0,'precioCAPromedio'=>0,'precioCIPromedio'=>0,'comisionCAPromedio'=>0,'comisionCIPromedio'=>0,'sumaCAPrecio'=>0,'sumaCIPrecio'=>0,'sumaCAComision'=>0,'sumaCIComision'=>0,'ganancia'=>0];

        if ($asesores!=0) {
            
            for($i=0; $i<count($seleccionados); $i++) { 
                $asesor=Agente::where('id',$seleccionados[$i])->first();
                $listaAsesores[$i]['id']=$asesor->id;
                $listaAsesores[$i]['codigo']=$asesor->codigo_id;
                $listaAsesores[$i]['nombre']=$asesor->fullName;
                $listaAsesores[$i]['precioCAPromedio']=0;
                $listaAsesores[$i]['precioCIPromedio']=0;
                $listaAsesores[$i]['comisionPromedio']=0;
                $listaAsesores[$i]['comisionCAPromedio']=0;
                $listaAsesores[$i]['comisionCIPromedio']=0;
                $listaAsesores[$i]['sumaCAPrecio']=0;
                $listaAsesores[$i]['sumaCIPrecio']=0;
                $listaAsesores[$i]['sumaCAComision']=0;
                $listaAsesores[$i]['sumaCIComision']=0;
                $listaAsesores[$i]['ganancia']=0;

                
                $inmuebles=Propiedad::join('tipoinmueble','propiedades.tipo_inmueble','tipoinmueble.id')
                                    ->join('ciudades','propiedades.ciudad_id','ciudades.id')
                                    ->join('negociaciones','propiedades.id','negociaciones.propiedad_id')
                                    ->join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                    ->newQuery();
                $inmuebles->select('propiedades.*','ciudades.nombre as nombreCiudad','tipoinmueble.nombre as nombreInmueble','negociaciones.id as id_negociacion','negociaciones.asesorCerrador','negociaciones.precioFinal','negociaciones.porcentajeCierre','negociacion_estatus.fechaEstatus','negociaciones.ingresoNeto');
                $inmuebles->where('propiedades.agente_id', $seleccionados[$i]);
                $inmuebles->where('negociacion_estatus.comisionPagada',1);
                $inmuebles->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF]);
                if ($precioF!=0) {
                    $inmuebles->whereBetween('negociaciones.precioFinal', [$precioI,$precioF]);
                }
                $inmuebles=$inmuebles->get();
                $listaAsesores[$i]['cantidadPropiedades']=count($inmuebles);    
                foreach ($inmuebles as $inmueble){
                    for ($c=0; $c <count($inmueble); $c++) { 
                        $propiedades[$c]['id']=$inmueble->id;
                        $propiedades[$c]['mls']=$inmueble->id_mls;
                        $propiedades[$c]['tipoInmueble']=$inmueble->nombreInmueble;
                        $propiedades[$c]['tipoNegocio']=$inmueble->tipoNegocio;
                        $propiedades[$c]['ciudad']=$inmueble->nombreCiudad;
                        $propiedades[$c]['cerrador']=$inmueble->asesorCerrador; 
                        $propiedades[$c]['precioCA']=$inmueble->precio;
                        $propiedades[$c]['precioCI']=$inmueble->precioFinal;
                        $propiedades[$c]['comisionCA']=(float)$inmueble->porcentajeCaptacion;
                        $propiedades[$c]['comisionCI']=(float)$inmueble->porcentajeCierre;
                        $propiedades[$c]['ganancia']=(float)$inmueble->ingresoNeto;
                        $propiedades[$c]['agente']=$inmueble->agente_id; 
                        $propiedades[$c]['fechaAlquiler']=$inmueble->fechaEstatus;
                        $propiedadesT[]=$propiedades[$c];
                    }
                }
            }
            //dd($seleccionados);
        }
        else{

            $asesores=Agente::all();
            foreach ($asesores as $i=>$value) {
                $listaAsesores[$i]['id']=$asesores[$i]->id;
                $listaAsesores[$i]['codigo']=$asesores[$i]->codigo_id;
                $listaAsesores[$i]['nombre']=$asesores[$i]->fullName;
                $listaAsesores[$i]['precioCAPromedio']=0;
                $listaAsesores[$i]['precioCIPromedio']=0;
                $listaAsesores[$i]['comisionPromedio']=0;
                $listaAsesores[$i]['comisionCAPromedio']=0;
                $listaAsesores[$i]['comisionCIPromedio']=0;
                $listaAsesores[$i]['sumaCAPrecio']=0;
                $listaAsesores[$i]['sumaCIPrecio']=0;
                $listaAsesores[$i]['sumaCAComision']=0;
                $listaAsesores[$i]['sumaCIComision']=0;
                $listaAsesores[$i]['ganancia']=0;
            
                $inmuebles=Propiedad::join('tipoinmueble','propiedades.tipo_inmueble','tipoinmueble.id')
                                    ->join('ciudades','propiedades.ciudad_id','ciudades.id')
                                    ->join('negociaciones','propiedades.id','negociaciones.propiedad_id')
                                    ->join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                    ->newQuery();
                $inmuebles->select('propiedades.*','ciudades.nombre as nombreCiudad','tipoinmueble.nombre as nombreInmueble','negociaciones.id as id_negociacion','negociaciones.asesorCerrador','negociaciones.precioFinal','negociaciones.porcentajeCierre','negociacion_estatus.fechaEstatus','negociaciones.ingresoNeto');
                $inmuebles->where('propiedades.agente_id', $asesores[$i]->id);
                $inmuebles->where('negociacion_estatus.comisionPagada',1);
                $inmuebles->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF]);
                if ($precioF!=0) {
                    $inmuebles->whereBetween('negociaciones.precioFinal', [$precioI,$precioF]);
                }
                $inmuebles=$inmuebles->get();
                $listaAsesores[$i]['cantidadPropiedades']=count($inmuebles);    
                    foreach ($inmuebles as $inmueble){
                        for ($c=0; $c <count($inmueble); $c++) { 
                            $propiedades[$c]['id']=$inmueble->id;
                            $propiedades[$c]['mls']=$inmueble->id_mls;
                            $propiedades[$c]['tipoInmueble']=$inmueble->nombreInmueble;
                            $propiedades[$c]['tipoNegocio']=$inmueble->tipoNegocio;
                            $propiedades[$c]['ciudad']=$inmueble->nombreCiudad;
                            $propiedades[$c]['cerrador']=$inmueble->asesorCerrador; 
                            $propiedades[$c]['precioCA']=$inmueble->precio;
                            $propiedades[$c]['precioCI']=$inmueble->precioFinal;
                            $propiedades[$c]['comisionCA']=(float)$inmueble->porcentajeCaptacion;
                            $propiedades[$c]['comisionCI']=(float)$inmueble->porcentajeCierre;
                            $propiedades[$c]['ganancia']=(float)$inmueble->ingresoNeto;
                            $propiedades[$c]['agente']=$inmueble->agente_id; 
                            $propiedades[$c]['fechaVenta']=$inmueble->fechaEstatus;
                            $propiedadesT[]=$propiedades[$c];
                        }
                    }



            }
        }

        for ($a=0; $a < count($listaAsesores); $a++) { 
            for ($b=0; $b < count($propiedadesT); $b++) { 
                if ($listaAsesores[$a]['id']==$propiedadesT[$b]['agente']) {
                    $listaAsesores[$a]['sumaCAPrecio']=$listaAsesores[$a]['sumaCAPrecio']+$propiedadesT[$b]['precioCA'];
                    $listaAsesores[$a]['sumaCIPrecio']=$listaAsesores[$a]['sumaCIPrecio']+$propiedadesT[$b]['precioCI'];
                    $listaAsesores[$a]['sumaCAComision']=$listaAsesores[$a]['sumaCAComision']+$propiedadesT[$b]['comisionCA'];
                    $listaAsesores[$a]['sumaCIComision']=$listaAsesores[$a]['sumaCIComision']+$propiedadesT[$b]['comisionCI'];
                    $listaAsesores[$a]['ganancia']=$listaAsesores[$a]['ganancia']+$propiedadesT[$b]['ganancia'];
                }
            }
            if ($listaAsesores[$a]['cantidadPropiedades']!=0) {
                $listaAsesores[$a]['precioCAPromedio']=$listaAsesores[$a]['sumaCAPrecio']/$listaAsesores[$a]['cantidadPropiedades'];
                $listaAsesores[$a]['precioCIPromedio']=$listaAsesores[$a]['sumaCIPrecio']/$listaAsesores[$a]['cantidadPropiedades'];
                $listaAsesores[$a]['comisionCAPromedio']=$listaAsesores[$a]['sumaCAComision']/$listaAsesores[$a]['cantidadPropiedades'];
                $listaAsesores[$a]['comisionCIPromedio']=$listaAsesores[$a]['sumaCIComision']/$listaAsesores[$a]['cantidadPropiedades'];
            }
            
        }

        for($i=0; $i<count($listaAsesores); $i++) { 
            $totales['totalPropiedades']=$totales['totalPropiedades']+$listaAsesores[$i]['cantidadPropiedades'];
            $totales['sumaCAPrecio']=$totales['sumaCAPrecio']+$listaAsesores[$i]['sumaCAPrecio'];
            $totales['sumaCIPrecio']=$totales['sumaCIPrecio']+$listaAsesores[$i]['sumaCIPrecio'];
            $totales['sumaCAComision']=$totales['sumaCAComision']+$listaAsesores[$i]['sumaCAComision'];
            $totales['sumaCIComision']=$totales['sumaCIComision']+$listaAsesores[$i]['sumaCIComision'];
            $totales['ganancia']=$totales['ganancia']+$listaAsesores[$i]['ganancia'];
        };
        if ($totales['totalPropiedades']!=0) {
            $totales['precioCAPromedio']=$totales['sumaCAPrecio']/$totales['totalPropiedades'];
            $totales['precioCIPromedio']=$totales['sumaCIPrecio']/$totales['totalPropiedades'];
            $totales['comisionCAPromedio']=$totales['sumaCAComision']/$totales['totalPropiedades'];
            $totales['comisionCIPromedio']=$totales['sumaCIComision']/$totales['totalPropiedades'];
        }

        return view('reportes.PropiedadesVendidasAsesor',compact('titulo','listaAsesores','propiedadesT','totales'));
           
    }

 public function EstadosCiudadesUrbPropVendida($estadosSelect,$ciudadesSelect){
        $citySinSelect=[];
        $estadoSinCiudad=[];
        $padresCiudad=[];

        for ($a=0; $a <count($estadosSelect) ; $a++) { 
            $aux1[]=Estado::where('id',$estadosSelect[$a])->first();
            $estateSelect[$a]['id']=$aux1[$a]->id;
            $estateSelect[$a]['nombre']=$aux1[$a]->nombre;
            $estateSelect[$a]['cantidadPropiedades']=0;
            $estateSelect[$a]['precioCAPromedio']=0;
            $estateSelect[$a]['precioCIPromedio']=0;
            $estateSelect[$a]['comisionPromedio']=0;
            $estateSelect[$a]['comisionCAPromedio']=0;
            $estateSelect[$a]['comisionCIPromedio']=0;
            $estateSelect[$a]['sumaCAPrecio']=0;
            $estateSelect[$a]['sumaCIPrecio']=0;
            $estateSelect[$a]['sumaCAComision']=0;
            $estateSelect[$a]['sumaCIComision']=0;
            $estateSelect[$a]['ganancia']=0;
        }

        for ($b=0; $b <count($ciudadesSelect) ; $b++) { 
            $aux2[]=Ciudad::where('id',$ciudadesSelect[$b])->first();
            $citySelect[$b]['id']=$aux2[$b]->id;
            $citySelect[$b]['padre']=$aux2[$b]->estado_id;
            $citySelect[$b]['nombre']=$aux2[$b]->nombre;
            $citySelect[$b]['cantidadPropiedades']=0;
            $citySelect[$b]['precioCAPromedio']=0;
            $citySelect[$b]['precioCIPromedio']=0;
            $citySelect[$b]['comisionPromedio']=0;
            $citySelect[$b]['comisionCAPromedio']=0;
            $citySelect[$b]['comisionCIPromedio']=0;
            $citySelect[$b]['sumaCAPrecio']=0;
            $citySelect[$b]['sumaCIPrecio']=0;
            $citySelect[$b]['sumaCAComision']=0;
            $citySelect[$b]['sumaCIComision']=0;
            $citySelect[$b]['ganancia']=0;
            $padresCiudad[]= $citySelect[$b]['padre'];
        }


        for ($c=0; $c <count($estadosSelect) ; $c++) { 
            if (!in_array($estadosSelect[$c],$padresCiudad)) {
                if (!in_array($estadosSelect[$c], $estadoSinCiudad)) {
                    $estadoSinCiudad[]=$estadosSelect[$c];
                }
            }
        }

        for ($d=0; $d <count($estadoSinCiudad) ; $d++) { 
           $cityAll[]=Ciudad::where('estado_id',$estadoSinCiudad[$d])->get();
           for ($e=0; $e <count( $cityAll[$d]) ; $e++) { 
                $aux3[$e]['id']= $cityAll[$d][$e]->id;
                $aux3[$e]['padre']= $cityAll[$d][$e]->estado_id;
                $aux3[$e]['nombre']= $cityAll[$d][$e]->nombre;
                $aux3[$e]['cantidadPropiedades']= 0;
                $aux3[$e]['precioCAPromedio']=0;
                $aux3[$e]['precioCIPromedio']=0;
                $aux3[$e]['comisionPromedio']=0;
                $aux3[$e]['comisionCAPromedio']=0;
                $aux3[$e]['comisionCIPromedio']=0;
                $aux3[$e]['sumaCAPrecio']=0;
                $aux3[$e]['sumaCIPrecio']=0;
                $aux3[$e]['sumaCAComision']=0;
                $aux3[$e]['sumaCIComision']=0;
                $aux3[$e]['ganancia']=0;
                $citySinSelect[]=$aux3[$e];
           }
        }
        for ($f=0; $f <count($citySinSelect) ; $f++ ){ 
            $citySelect[]=$citySinSelect[$f];
        }

        return compact('estateSelect','citySelect');
    }

    public function vendidasUbicacion($fechaI,$fechaF,$precioI,$precioF,$estados,$ciudades,$urbanizaciones){
        $estadosSelect=explode(",", $estados);
        $ciudadesSelect=explode(",", $ciudades);
        $urbanizacionesSelect=explode(",", $urbanizaciones);
        $fechaFormatoInicial=date("d/m/Y", strtotime($fechaI));
        $fechaFormatoFinal=date("d/m/Y", strtotime($fechaF));
        $titulo="Propiedades vendidas por ubicación segun rango de fechas: ".$fechaFormatoInicial." - ".$fechaFormatoFinal;
        $propiedadesT=[];
        $padresUrb=[];
        $ciudadSinUrb=[];
        $urbSelect=[];
        $urbSinSelect=[];
        $totales=['totalPropiedades'=>0,'precioCAPromedio'=>0,'precioCIPromedio'=>0,'comisionCAPromedio'=>0,'comisionCIPromedio'=>0,'sumaCAPrecio'=>0,'sumaCIPrecio'=>0,'sumaCAComision'=>0,'sumaCIComision'=>0,'ganancia'=>0];
  
        

        if ($ciudades!=0 && $urbanizaciones!=0) {

            $resultado=self::EstadosCiudadesUrbPropVendida($estadosSelect,$ciudadesSelect);
            $estateSelect=$resultado['estateSelect'];
            $citySelect=$resultado['citySelect'];

            for ($f=0; $f <count($urbanizacionesSelect) ; $f++) { 
                $aux4[]=Urbanizacion::where('id',$urbanizacionesSelect[$f])->first();
                $urbSelect[$f]['id']=$aux4[$f]->id;
                $urbSelect[$f]['padre']=$aux4[$f]->ciudad_id;
                $urbSelect[$f]['nombre']=$aux4[$f]->nombre;
                $urbSelect[$f]['cantidadPropiedades']=0;
                $urbSelect[$f]['precioCAPromedio']=0;
                $urbSelect[$f]['precioCIPromedio']=0;
                $urbSelect[$f]['comisionPromedio']=0;
                $urbSelect[$f]['comisionCAPromedio']=0;
                $urbSelect[$f]['comisionCIPromedio']=0;
                $urbSelect[$f]['sumaCAPrecio']=0;
                $urbSelect[$f]['sumaCIPrecio']=0;
                $urbSelect[$f]['sumaCAComision']=0;
                $urbSelect[$f]['sumaCIComision']=0;
                $urbSelect[$f]['ganancia']=0;
                $padresUrb[]= $urbSelect[$f]['padre'];
            }
            for ($h=0; $h <count($citySelect) ; $h++) { 
                if (!in_array($citySelect[$h]['id'],$padresUrb)) {
                    if (!in_array($citySelect[$h]['id'], $ciudadSinUrb)) {
                        $ciudadSinUrb[]=$citySelect[$h];
                    }
                }
            }
            for ($i=0; $i <count($ciudadSinUrb) ; $i++) { 
               $urbTodas[]=Urbanizacion::where('ciudad_id',$ciudadSinUrb[$i])->get();
               for ($j=0; $j <count($urbTodas[$i]) ; $j++) { 
                    $aux5[$j]['id']=$urbTodas[$i][$j]->id;
                    $aux5[$j]['padre']=$urbTodas[$i][$j]->ciudad_id;
                    $aux5[$j]['nombre']=$urbTodas[$i][$j]->nombre;
                    $aux5[$j]['cantidadPropiedades']=0;
                    $aux5[$j]['precioCAPromedio']=0;
                    $aux5[$j]['precioCIPromedio']=0;
                    $aux5[$j]['comisionPromedio']=0;
                    $aux5[$j]['comisionCAPromedio']=0;
                    $aux5[$j]['comisionCIPromedio']=0;
                    $aux5[$j]['sumaCAPrecio']=0;
                    $aux5[$j]['sumaCIPrecio']=0;
                    $aux5[$j]['sumaCAComision']=0;
                    $aux5[$j]['sumaCIComision']=0;
                    $aux5[$j]['ganancia']=0;
                    $urbSinSelect[]=$aux5[$j];
               }
            }
            for ($k=0; $k <count($urbSinSelect) ; $k++ ){ 
                $urbSelect[]=$urbSinSelect[$k];
            }
        } 
        else if($ciudades!=0 && $urbanizaciones==0){

            $resultado=self::EstadosCiudadesUrbPropVendida($estadosSelect,$ciudadesSelect);
            $estateSelect=$resultado['estateSelect'];
            $citySelect=$resultado['citySelect'];

            for ($i=0; $i <count($citySelect) ; $i++) { 
               $urbTodas[]=Urbanizacion::where('ciudad_id',$citySelect[$i])->get();
               for ($j=0; $j <count($urbTodas[$i]) ; $j++) { 
                    $aux5[$j]['id']=$urbTodas[$i][$j]->id;
                    $aux5[$j]['padre']=$urbTodas[$i][$j]->ciudad_id;
                    $aux5[$j]['nombre']=$urbTodas[$i][$j]->nombre;
                    $aux5[$j]['cantidadPropiedades']=0;
                    $aux5[$j]['precioCAPromedio']=0;
                    $aux5[$j]['precioCIPromedio']=0;
                    $aux5[$j]['comisionPromedio']=0;
                    $aux5[$j]['comisionCAPromedio']=0;
                    $aux5[$j]['comisionCIPromedio']=0;
                    $aux5[$j]['sumaCAPrecio']=0;
                    $aux5[$j]['sumaCIPrecio']=0;
                    $aux5[$j]['sumaCAComision']=0;
                    $aux5[$j]['sumaCIComision']=0;
                    $aux5[$j]['ganancia']=0;
                    $urbSelect[]=$aux5[$j];
               }
            }


        }
        else if($ciudades==0 && $urbanizaciones==0){
            for ($a=0; $a <count($estadosSelect) ; $a++) { 
                $aux1[]=Estado::where('id',$estadosSelect[$a])->first();
                $estateSelect[$a]['id']=$aux1[$a]->id;
                $estateSelect[$a]['nombre']=$aux1[$a]->nombre;
                $estateSelect[$a]['cantidadPropiedades']=0;
                $estateSelect[$a]['precioCAPromedio']=0;
                $estateSelect[$a]['precioCIPromedio']=0;
                $estateSelect[$a]['comisionPromedio']=0;
                $estateSelect[$a]['comisionCAPromedio']=0;
                $estateSelect[$a]['comisionCIPromedio']=0;
                $estateSelect[$a]['sumaCAPrecio']=0;
                $estateSelect[$a]['sumaCIPrecio']=0;
                $estateSelect[$a]['sumaCAComision']=0;
                $estateSelect[$a]['sumaCIComision']=0;
                $estateSelect[$a]['ganancia']=0;
            }

            for ($d=0; $d <count($estateSelect) ; $d++) { 
               $cityAll[]=Ciudad::where('estado_id',$estateSelect[$d])->get();
               for ($e=0; $e <count( $cityAll[$d]) ; $e++) { 
                    $aux3[$e]['id']= $cityAll[$d][$e]->id;
                    $aux3[$e]['padre']= $cityAll[$d][$e]->estado_id;
                    $aux3[$e]['nombre']= $cityAll[$d][$e]->nombre;
                    $aux3[$e]['cantidadPropiedades']= 0;
                    $aux3[$e]['precioCAPromedio']=0;
                    $aux3[$e]['precioCIPromedio']=0;
                    $aux3[$e]['comisionPromedio']=0;
                    $aux3[$e]['comisionCAPromedio']=0;
                    $aux3[$e]['comisionCIPromedio']=0;
                    $aux3[$e]['sumaCAPrecio']=0;
                    $aux3[$e]['sumaCIPrecio']=0;
                    $aux3[$e]['sumaCAComision']=0;
                    $aux3[$e]['sumaCIComision']=0;
                    $aux3[$e]['ganancia']=0;
                    $citySelect[]=$aux3[$e];
               }
            }

            for ($i=0; $i <count($citySelect) ; $i++) { 
               $urbTodas[]=Urbanizacion::where('ciudad_id',$citySelect[$i])->get();
               for ($j=0; $j <count($urbTodas[$i]) ; $j++) { 
                    $aux5[$j]['id']=$urbTodas[$i][$j]->id;
                    $aux5[$j]['padre']=$urbTodas[$i][$j]->ciudad_id;
                    $aux5[$j]['nombre']=$urbTodas[$i][$j]->nombre;
                    $aux5[$j]['cantidadPropiedades']=0;
                    $aux5[$j]['precioCAPromedio']=0;
                    $aux5[$j]['precioCIPromedio']=0;
                    $aux5[$j]['comisionPromedio']=0;
                    $aux5[$j]['comisionCAPromedio']=0;
                    $aux5[$j]['comisionCIPromedio']=0;
                    $aux5[$j]['sumaCAPrecio']=0;
                    $aux5[$j]['sumaCIPrecio']=0;
                    $aux5[$j]['sumaCAComision']=0;
                    $aux5[$j]['sumaCIComision']=0;
                    $aux5[$j]['ganancia']=0;
                    $urbSelect[]=$aux5[$j];
               }
            }
        }
        //dd($citySelect);
        for($i=0; $i<count($urbSelect); $i++) { 

            $inmuebles=Propiedad::join('tipoinmueble','propiedades.tipo_inmueble','tipoinmueble.id')
                                    ->join('negociaciones','propiedades.id','negociaciones.propiedad_id')
                                    ->join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                    ->newQuery();
            $inmuebles->select('propiedades.*','tipoinmueble.nombre as nombreInmueble','negociaciones.id as id_negociacion','negociaciones.asesorCerrador','negociaciones.precioFinal','negociaciones.porcentajeCierre','negociacion_estatus.fechaEstatus','negociaciones.ingresoNeto','negociaciones.asesorCaptador');
            $inmuebles->where('propiedades.urbanizacion', $urbSelect[$i]['id']);
            $inmuebles->where('negociacion_estatus.comisionPagada',1);
            $inmuebles->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF]);
            if ($precioF!=0) {
                $inmuebles->whereBetween('negociaciones.precioFinal', [$precioI,$precioF]);
            }
            $inmuebles=$inmuebles->get();

            $urbSelect[$i]['cantidadPropiedades']=count($inmuebles);    
                foreach ($inmuebles as $inmueble){
                    for ($c=0; $c <count($inmueble); $c++) { 
                        $propiedades[$c]['id']=$inmueble->id;
                        $propiedades[$c]['mls']=$inmueble->id_mls;
                        $propiedades[$c]['tipoInmueble']=$inmueble->nombreInmueble;
                        $propiedades[$c]['tipoNegocio']=$inmueble->tipoNegocio;
                        $propiedades[$c]['captador']=$inmueble->asesorCaptador;
                        $propiedades[$c]['cerrador']=$inmueble->asesorCerrador; 
                        $propiedades[$c]['precioCA']=$inmueble->precio;
                        $propiedades[$c]['precioCI']=$inmueble->precioFinal;
                        $propiedades[$c]['comisionCA']=(float)$inmueble->porcentajeCaptacion;
                        $propiedades[$c]['comisionCI']=(float)$inmueble->porcentajeCierre;
                        $propiedades[$c]['ganancia']=(float)$inmueble->ingresoNeto;
                        $propiedades[$c]['agente']=$inmueble->agente_id; 
                        $propiedades[$c]['fechaVenta']=$inmueble->fechaEstatus;
                        $propiedades[$c]['padre']=$inmueble->urbanizacion;
                        $propiedadesT[]=$propiedades[$c];
                    }
                }
        }

        for ($a=0; $a < count($urbSelect); $a++) { 
            for ($b=0; $b < count($propiedadesT); $b++) { 
                if ($urbSelect[$a]['id']==$propiedadesT[$b]['padre']) {
                    $urbSelect[$a]['sumaCAPrecio']=$urbSelect[$a]['sumaCAPrecio']+$propiedadesT[$b]['precioCA'];
                    $urbSelect[$a]['sumaCIPrecio']=$urbSelect[$a]['sumaCIPrecio']+$propiedadesT[$b]['precioCI'];
                    $urbSelect[$a]['sumaCAComision']=$urbSelect[$a]['sumaCAComision']+$propiedadesT[$b]['comisionCA'];
                    $urbSelect[$a]['sumaCIComision']=$urbSelect[$a]['sumaCIComision']+$propiedadesT[$b]['comisionCI'];
                    $urbSelect[$a]['ganancia']=$urbSelect[$a]['ganancia']+$propiedadesT[$b]['ganancia'];
                    
                }
            }
            if ($urbSelect[$a]['cantidadPropiedades']!=0) {
                $urbSelect[$a]['precioCAPromedio']=$urbSelect[$a]['sumaCAPrecio']/$urbSelect[$a]['cantidadPropiedades'];
                $urbSelect[$a]['precioCIPromedio']=$urbSelect[$a]['sumaCIPrecio']/$urbSelect[$a]['cantidadPropiedades'];
                $urbSelect[$a]['comisionCAPromedio']=$urbSelect[$a]['sumaCAComision']/$urbSelect[$a]['cantidadPropiedades'];
                $urbSelect[$a]['comisionCIPromedio']=$urbSelect[$a]['sumaCIComision']/$urbSelect[$a]['cantidadPropiedades'];
            }

        }

        for ($a=0; $a < count($citySelect); $a++) { 
            for ($b=0; $b < count($urbSelect); $b++) { 
                if ($citySelect[$a]['id']==$urbSelect[$b]['padre']) {
                    $citySelect[$a]['sumaCAPrecio']=$citySelect[$a]['sumaCAPrecio']+$urbSelect[$b]['sumaCAPrecio'];
                    $citySelect[$a]['sumaCIPrecio']=$citySelect[$a]['sumaCIPrecio']+$urbSelect[$b]['sumaCIPrecio'];
                    $citySelect[$a]['sumaCAComision']=$citySelect[$a]['sumaCAComision']+$urbSelect[$b]['sumaCAComision'];
                    $citySelect[$a]['sumaCIComision']=$citySelect[$a]['sumaCIComision']+$urbSelect[$b]['sumaCIComision'];
                    $citySelect[$a]['ganancia']=$citySelect[$a]['ganancia']+$urbSelect[$b]['ganancia'];
                    $citySelect[$a]['cantidadPropiedades']=$citySelect[$a]['cantidadPropiedades']+$urbSelect[$b]['cantidadPropiedades'];
                    
                }
            }
            if ($citySelect[$a]['cantidadPropiedades']!=0) {
                $citySelect[$a]['precioCAPromedio']=$citySelect[$a]['sumaCAPrecio']/$citySelect[$a]['cantidadPropiedades'];
                $citySelect[$a]['precioCIPromedio']=$citySelect[$a]['sumaCIPrecio']/$citySelect[$a]['cantidadPropiedades'];
                $citySelect[$a]['comisionCAPromedio']=$citySelect[$a]['sumaCAComision']/$citySelect[$a]['cantidadPropiedades'];
                $citySelect[$a]['comisionCIPromedio']=$citySelect[$a]['sumaCIComision']/$citySelect[$a]['cantidadPropiedades'];

            }
        }

        for ($a=0; $a < count($estateSelect); $a++) { 
            for ($b=0; $b < count($citySelect); $b++) { 
                if ($estateSelect[$a]['id']==$citySelect[$b]['padre']) {
                    $estateSelect[$a]['sumaCAPrecio']=$estateSelect[$a]['sumaCAPrecio']+$citySelect[$b]['sumaCAPrecio'];
                    $estateSelect[$a]['sumaCIPrecio']=$estateSelect[$a]['sumaCIPrecio']+$citySelect[$b]['sumaCIPrecio'];
                    $estateSelect[$a]['sumaCAComision']=$estateSelect[$a]['sumaCAComision']+$citySelect[$b]['sumaCAComision'];
                    $estateSelect[$a]['sumaCIComision']=$estateSelect[$a]['sumaCIComision']+$citySelect[$b]['sumaCIComision'];
                    $estateSelect[$a]['ganancia']=$estateSelect[$a]['ganancia']+$citySelect[$b]['ganancia'];
                    $estateSelect[$a]['cantidadPropiedades']=$estateSelect[$a]['cantidadPropiedades']+$citySelect[$b]['cantidadPropiedades'];

                }
            }
            if ($estateSelect[$a]['cantidadPropiedades']!=0) {

                $estateSelect[$a]['precioCAPromedio']=$estateSelect[$a]['sumaCAPrecio']/$estateSelect[$a]['cantidadPropiedades'];
                $estateSelect[$a]['precioCIPromedio']=$estateSelect[$a]['sumaCIPrecio']/$estateSelect[$a]['cantidadPropiedades'];
                $estateSelect[$a]['comisionCAPromedio']=$estateSelect[$a]['sumaCAComision']/$estateSelect[$a]['cantidadPropiedades'];
                $estateSelect[$a]['comisionCIPromedio']=$estateSelect[$a]['sumaCIComision']/$estateSelect[$a]['cantidadPropiedades'];
            }
        }

        for ($b=0; $b < count($estateSelect); $b++) { 
            $totales['sumaCAPrecio']=$totales['sumaCAPrecio']+$estateSelect[$b]['sumaCAPrecio'];
            $totales['sumaCIPrecio']=$totales['sumaCIPrecio']+$estateSelect[$b]['sumaCIPrecio'];
            $totales['sumaCAComision']=$totales['sumaCAComision']+$estateSelect[$b]['sumaCAComision'];
            $totales['sumaCIComision']=$totales['sumaCIComision']+$estateSelect[$b]['sumaCIComision'];
            $totales['ganancia']=$totales['ganancia']+$estateSelect[$b]['ganancia'];
            $totales['totalPropiedades']=$totales['totalPropiedades']+$estateSelect[$b]['cantidadPropiedades'];

            if ($totales['totalPropiedades']!=0) {

                $totales['precioCAPromedio']=$totales['sumaCAPrecio']/$totales['totalPropiedades'];
                $totales['precioCIPromedio']=$totales['sumaCIPrecio']/$totales['totalPropiedades'];
                $totales['comisionCAPromedio']=$totales['sumaCAComision']/$totales['totalPropiedades'];
                $totales['comisionCIPromedio']=$totales['sumaCIComision']/$totales['totalPropiedades'];

            }
        }
        return view('reportes.PropiedadesVendidasUbicacion',compact('urbSelect','citySelect','estateSelect','titulo','totales','propiedadesT')); 
    }

    public function distribucionTipoNegocio($fechaI,$fechaF,$data){
        $fechaFormatoInicial=date("d/m/Y", strtotime($fechaI));
        $fechaFormatoFinal=date("d/m/Y", strtotime($fechaF));
        $titulo="Propiedades captadas por asesor para tipo de negocio segun rango de fechas: ".$fechaFormatoInicial." - ".$fechaFormatoFinal;
        $asesores=Agente::all();
        $aux3=[];
        $cantidades=['prueba'=>0,'propiedadVenta'=>0,'precioPromedioVenta'=>0,'sumaPrecioVenta'=>0,'sumaPrecioAlquiler'=>0,'propiedadAlquiler'=>0,'precioPromedioAlquiler'=>0];

        if ($data!=0) {
            $seleccionados=explode(",", $data);
            for($i=0; $i<count($seleccionados); $i++) { 
                $resultado[$i]['id']=$seleccionados[$i];
                $resultado[$i]['precioPromedioVenta']=Propiedad::where('tipoNegocio','venta')->where('agente_id',$seleccionados[$i])->whereBetween('fechaCreado',[$fechaI,$fechaF])->avg('precio');
                $resultado[$i]['precioPromedioAlquiler']=Propiedad::where('tipoNegocio','alquiler')->where('agente_id',$seleccionados[$i])->whereBetween('fechaCreado',[$fechaI,$fechaF])->avg('precio');
                $resultado[$i]['propiedadVenta']=count(Propiedad::where('tipoNegocio','venta')->where('agente_id',$seleccionados[$i])->whereBetween('fechaCreado',[$fechaI,$fechaF])->get());
                $resultado[$i]['propiedadAlquiler']=count(Propiedad::where('tipoNegocio','alquiler')->where('agente_id',$seleccionados[$i])->whereBetween('fechaCreado',[$fechaI,$fechaF])->get());
            };

        }
        else {
            foreach ($asesores as $key=>$value) {
                $resultado[$key]['id']=$asesores[$key]->id;
                $resultado[$key]['precioPromedioVenta']=Propiedad::where('tipoNegocio','venta')->where('agente_id',$asesores[$key]->id)->whereBetween('fechaCreado',[$fechaI,$fechaF])->avg('precio');
                $resultado[$key]['precioPromedioAlquiler']=Propiedad::where('tipoNegocio','alquiler')->where('agente_id',$asesores[$key]->id)->whereBetween('fechaCreado',[$fechaI,$fechaF])->avg('precio');
                $resultado[$key]['propiedadVenta']=count(Propiedad::where('tipoNegocio','venta')->where('agente_id',$asesores[$key]->id)->whereBetween('fechaCreado',[$fechaI,$fechaF])->get());
                $resultado[$key]['propiedadAlquiler']=count(Propiedad::where('tipoNegocio','alquiler')->where('agente_id',$asesores[$key]->id)->whereBetween('fechaCreado',[$fechaI,$fechaF])->get());
                $seleccionados[$key]=$asesores[$key]->id;
            }
        }

        for ($i=0; $i < count($seleccionados); $i++) { 
             $aux1[$i]=Propiedad::where('agente_id',$seleccionados[$i])->whereBetween('fechaCreado',[$fechaI,$fechaF])->get();
             
             foreach ($aux1[$i] as $key => $value) {
                 $aux2[$key]['asesor']=$aux1[$i][$key]->agente_id;
                 $aux2[$key]['negocio']=$aux1[$i][$key]->tipoNegocio;
                 $aux2[$key]['precio']=$aux1[$i][$key]->precio;
                 $aux3[]=$aux2[$key];
             }
        }

        for ($i=0; $i <count($aux3) ; $i++) { 
           if ($aux3[$i]['negocio']=='Venta') {
               $cantidades['propiedadVenta']= ++$cantidades['propiedadVenta'];
               $cantidades['sumaPrecioVenta']=$cantidades['sumaPrecioVenta']+$aux3[$i]['precio'];
           }
           else if ($aux3[$i]['negocio']=='Alquiler') {
               $cantidades['propiedadAlquiler']= ++$cantidades['propiedadAlquiler'];
               $cantidades['sumaPrecioAlquiler']=$cantidades['sumaPrecioAlquiler']+$aux3[$i]['precio'];
           }
        }
        if ($cantidades['propiedadVenta']!=0) {
           $cantidades['precioPromedioVenta']= $cantidades['sumaPrecioVenta']/$cantidades['propiedadVenta'];
        }
        if ($cantidades['propiedadAlquiler']!=0) {
            $cantidades['precioPromedioAlquiler']= $cantidades['sumaPrecioAlquiler']/$cantidades['propiedadAlquiler'];
        }
        
        return view('reportes.DistribucionTipoNegocio',compact('titulo','asesores','resultado','cantidades'));       
    }

    public function ventasTipoIntermediacion($fechaI,$fechaF,$data){
        $seleccionados=explode(",", $data);
        $fechaFormatoInicial=date("d/m/Y", strtotime($fechaI));
        $fechaFormatoFinal=date("d/m/Y", strtotime($fechaF));
        $titulo="Ventas por tipo de intermediación segun rango de fechas: ".$fechaFormatoInicial." - ".$fechaFormatoFinal;
        $cantidades=['operaciones'=>0,'ingresoBruto'=>0,'pagoMatriz'=>0,'ingresoNeto'=>0];
        if ($data!=0) { 
            for($i=0; $i<count($seleccionados); $i++){ 
                $asesor=Agente::where('id',$seleccionados[$i])->first();
                $aux1[$i]['id']=$asesor->id;
                $aux1[$i]['nombre']=$asesor->fullName;
                $aux1[$i]['codigo']=$asesor->codigo_id;
            }
        }
        else{
            $seleccionados=Agente::all();
            foreach ($seleccionados as $key=>$value) {
                $aux1[$key]['id']=$seleccionados[$key]->id;
                $aux1[$key]['nombre']=$seleccionados[$key]->fullName;
                $aux1[$key]['codigo']=$seleccionados[$key]->codigo_id;
            }
        }
        for ($i=0; $i<count($aux1) ; $i++) {
            $resultado[$i]['padre']=$aux1[$i]['id'];
            $valoresCA=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                             ->where([['negociaciones.asesorCaptador', $aux1[$i]['nombre']],['negociaciones.asesorCerrador','<>', $aux1[$i]['nombre']]])
                                                             ->where('negociacion_estatus.comisionPagada',1)
                                                             ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                             ->select(DB::raw('avg(negociaciones.porcentajeCaptacion) as promedioCaptacionCA,avg(negociaciones.porcentajeCierre) as promedioCierreCA, avg(negociaciones.porcentajeCompartido) as promedioCompartidoCA, count(*) as operaciones,sum(negociaciones.comisionBruta) as ingresoBruto,sum(negociaciones.pagoCasaMatriz) as pagoMatriz,sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                             ->first(); 
            $valoresCI=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                             ->where([['negociaciones.asesorCerrador', $aux1[$i]['nombre']],['negociaciones.asesorCaptador','<>', $aux1[$i]['nombre']]])
                                                             ->where('negociacion_estatus.comisionPagada',1)
                                                             ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                             ->select(DB::raw('avg(negociaciones.porcentajeCaptacion) as promedioCaptacionCI,avg(negociaciones.porcentajeCierre) as promedioCierreCI, avg(negociaciones.porcentajeCompartido) as promedioCompartidoCI, count(*) as operaciones,sum(negociaciones.comisionBruta) as ingresoBruto,sum(negociaciones.pagoCasaMatriz) as pagoMatriz,sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                             ->first();
            $valoresCACI=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                             ->where([['negociaciones.asesorCerrador', $aux1[$i]['nombre']],['negociaciones.asesorCaptador',$aux1[$i]['nombre']]])
                                                             ->where('negociacion_estatus.comisionPagada',1)
                                                             ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                             ->select(DB::raw('avg(negociaciones.porcentajeCaptacion) as promedioCaptacionCACI,avg(negociaciones.porcentajeCierre) as promedioCierreCACI, count(*) as operaciones,sum(negociaciones.comisionBruta) as ingresoBruto,sum(negociaciones.pagoCasaMatriz) as pagoMatriz,sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                             ->first(); 

            $resultado[$i]['promedioCaptacionCA']=$valoresCA->promedioCaptacionCA;
            $resultado[$i]['promedioCierreCA']=$valoresCA->promedioCierreCA;
            $resultado[$i]['promedioCompartidoCA']=$valoresCA->promedioCompartidoCA;
            $resultado[$i]['operacionesCA']=$valoresCA->operaciones;
            $resultado[$i]['ingresoBrutoCA']=$valoresCA->ingresoBruto;
            $resultado[$i]['pagoMatrizCA']=$valoresCA->pagoMatriz;      
            $resultado[$i]['ingresoNetoCA']=$valoresCA->ingresoNeto;                                                
            $resultado[$i]['promedioCaptacionCI']=$valoresCI->promedioCaptacionCI;
            $resultado[$i]['promedioCierreCI']=$valoresCI->promedioCierreCI;
            $resultado[$i]['promedioCompartidoCI']=$valoresCI->promedioCompartidoCI;
            $resultado[$i]['operacionesCI']=$valoresCI->operaciones;
            $resultado[$i]['ingresoBrutoCI']=$valoresCI->ingresoBruto;
            $resultado[$i]['pagoMatrizCI']=$valoresCI->pagoMatriz;      
            $resultado[$i]['ingresoNetoCI']=$valoresCI->ingresoNeto;   
            $resultado[$i]['promedioCaptacionCACI']=$valoresCACI->promedioCaptacionCACI;
            $resultado[$i]['promedioCierreCACI']=$valoresCACI->promedioCierreCACI;
            $resultado[$i]['operacionesCACI']=$valoresCACI->operaciones;
            $resultado[$i]['ingresoBrutoCACI']=$valoresCACI->ingresoBruto;
            $resultado[$i]['pagoMatrizCACI']=$valoresCACI->pagoMatriz;      
            $resultado[$i]['ingresoNetoCACI']=$valoresCACI->ingresoNeto;   
                                                                                              
        }  
        for ($i=0; $i <count($aux1) ; $i++) { 
            for ($e=0; $e <count($resultado); $e++) { 
                if ($aux1[$i]['id']==$resultado[$e]['padre']) {
                    $aux1[$i]['operaciones']=$resultado[$e]['operacionesCA']+$resultado[$e]['operacionesCI']+$resultado[$e]['operacionesCACI'];
                    $aux1[$i]['ingresoBruto']=$resultado[$e]['ingresoBrutoCA']+$resultado[$e]['ingresoBrutoCI']+$resultado[$e]['ingresoBrutoCACI'];
                    $aux1[$i]['pagoMatriz']=$resultado[$e]['pagoMatrizCA']+$resultado[$e]['pagoMatrizCI']+$resultado[$e]['pagoMatrizCACI'];
                    $aux1[$i]['ingresoNeto']=$resultado[$e]['ingresoNetoCA']+$resultado[$e]['ingresoNetoCI']+$resultado[$e]['ingresoNetoCACI'];
                }
            }
        }
        $valores=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones,sum(negociaciones.comisionBruta) as ingresoBruto,sum(negociaciones.pagoCasaMatriz) as pagoMatriz,sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first(); 
        $cantidades['operaciones']=$valores->operaciones;
        $cantidades['ingresoBruto']=$valores->ingresoBruto;   
        $cantidades['pagoMatriz']=$valores->pagoMatriz;
        $cantidades['ingresoNeto']=$valores->ingresoNeto;

        return view('reportes.VentasTipoIntermediacion',compact('titulo','cantidades','aux1','resultado'));
    }

    public function reporteGeneralVentas($fechaI,$fechaF){
        $fechaFormatoInicial=date("d/m/Y", strtotime($fechaI));
        $fechaFormatoFinal=date("d/m/Y", strtotime($fechaF));
        $titulo="Reporte de Ventas General segun rango de fechas: ".$fechaFormatoInicial." - ".$fechaFormatoFinal;
        $valores=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones,sum(negociaciones.comisionBruta) as ingresoBruto,sum(negociaciones.pagoCasaMatriz) as pagoMatriz,sum(negociaciones.precioFinal) as totalVentas, sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first(); 

        $valores1=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where([['negociaciones.asesorCaptador','<>','Asesor Generico'],['negociaciones.asesorCerrador','Asesor Generico']])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as captadas'))
                                                    ->first();

        $valores2=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where([['negociaciones.asesorCaptador','Asesor Generico'],['negociaciones.asesorCerrador','<>','Asesor Generico']])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as cerradas'))
                                                    ->first();

       $valores3=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where([['negociaciones.asesorCaptador','<>','Asesor Generico'],['negociaciones.asesorCerrador','<>','Asesor Generico']])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as CACI'))
                                                    ->first();                                               

        $valores4=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.tipo_inmueble',1)
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones, avg(negociaciones.precioFinal) as promedioPrecio, sum(negociaciones.precioFinal) as totalVentas, sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first();
        $valores5=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.tipo_inmueble',2)
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones, avg(negociaciones.precioFinal) as promedioPrecio, sum(negociaciones.precioFinal) as totalVentas, sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first(); 
        $valores6=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.tipo_inmueble',3)
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones, avg(negociaciones.precioFinal) as promedioPrecio, sum(negociaciones.precioFinal) as totalVentas, sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first(); 
        $valores7=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.tipo_inmueble',4)
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones, avg(negociaciones.precioFinal) as promedioPrecio, sum(negociaciones.precioFinal) as totalVentas, sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first(); 
        $valores8=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.tipo_inmueble',5)
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones, avg(negociaciones.precioFinal) as promedioPrecio, sum(negociaciones.precioFinal) as totalVentas, sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first();                                             
        $valores9=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.tipoNegocio','venta')
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones,sum(negociaciones.comisionBruta) as ingresoBruto,sum(negociaciones.pagoCasaMatriz) as pagoMatriz,sum(negociaciones.precioFinal) as totalVentas, sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first();
        $valores10=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.tipoNegocio','alquiler')
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones,sum(negociaciones.comisionBruta) as ingresoBruto,sum(negociaciones.pagoCasaMatriz) as pagoMatriz,sum(negociaciones.precioFinal) as totalVentas, sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first();

        $valores11=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->where('negociacion_estatus.estatus_id',7)
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as reportadas'))
                                                    ->first(); 
                                                             

        $cantidades['operaciones']=$valores->operaciones;
        $cantidades['ingresoBruto']=$valores->ingresoBruto;   
        $cantidades['pagoMatriz']=$valores->pagoMatriz;
        $cantidades['ingresoNeto']=$valores->ingresoNeto;
        $cantidades['totalVentas']=$valores->totalVentas;
        $cantidades['captadas']=$valores1->captadas;
        $cantidades['cerradas']=$valores2->cerradas;
        $cantidades['CACI']=$valores3->CACI;
        $cantidades['operacionesTerreno']=$valores4->operaciones;
        $cantidades['promedioPrecioTerreno']=$valores4->promedioPrecio;
        $cantidades['totalVentasTerreno']=$valores4->totalVentas;
        $cantidades['ingresoNetoTerreno']=$valores4->ingresoNeto;
        $cantidades['operacionesComercial']=$valores5->operaciones;
        $cantidades['promedioPrecioComercial']=$valores5->promedioPrecio;
        $cantidades['totalVentasComercial']=$valores5->totalVentas;
        $cantidades['ingresoNetoComercial']=$valores5->ingresoNeto;
        $cantidades['operacionesResidencial']=$valores6->operaciones;
        $cantidades['promedioPrecioResidencial']=$valores6->promedioPrecio;
        $cantidades['totalVentasResidencial']=$valores6->totalVentas;
        $cantidades['ingresoNetoResidencial']=$valores6->ingresoNeto;
        $cantidades['operacionesVacacional']=$valores7->operaciones;
        $cantidades['promedioPrecioVacacional']=$valores7->promedioPrecio;
        $cantidades['totalVentasVacacional']=$valores7->totalVentas;
        $cantidades['ingresoNetoVacacional']=$valores7->ingresoNeto;
        $cantidades['operacionesIndustrial']=$valores8->operaciones;
        $cantidades['promedioPrecioIndustrial']=$valores8->promedioPrecio;
        $cantidades['totalVentasIndustrial']=$valores8->totalVentas;
        $cantidades['ingresoNetoIndustrial']=$valores8->ingresoNeto;
        $cantidades['operacionesVenta']=$valores9->operaciones;
        $cantidades['ingresoBrutoVenta']=$valores9->ingresoBruto;   
        $cantidades['pagoMatrizVenta']=$valores9->pagoMatriz;
        $cantidades['ingresoNetoVenta']=$valores9->ingresoNeto;
        $cantidades['totalVentasVenta']=$valores9->totalVentas;
        $cantidades['operacionesAlquiler']=$valores10->operaciones;
        $cantidades['ingresoBrutoAlquiler']=$valores10->ingresoBruto;   
        $cantidades['pagoMatrizAlquiler']=$valores10->pagoMatriz;
        $cantidades['ingresoNetoAlquiler']=$valores10->ingresoNeto;
        $cantidades['totalVentasAlquiler']=$valores10->totalVentas;
        $cantidades['reportadas']=$valores11->reportadas;
        //dd($cantidades);
        return view('reportes.ReporteGeneralVentas',compact('cantidades','titulo'));
    }

    public function ventasTipoInmuebleAsesor($fechaI,$fechaF,$data){
        $seleccionados=explode(",", $data);
        $fechaFormatoInicial=date("d/m/Y", strtotime($fechaI));
        $fechaFormatoFinal=date("d/m/Y", strtotime($fechaF));
        $titulo="Ventas por tipo de Inmuebles segun rango de fechas: ".$fechaFormatoInicial." - ".$fechaFormatoFinal;
        $cantidades=['operaciones'=>0,'promedioPrecio'=>0,'totalVentas'=>0,'ingresoBruto'=>0,'pagoMatriz'=>0,'ingresoNeto'=>0];
        if ($data!=0) { 
            for($i=0; $i<count($seleccionados); $i++){ 
                $asesor=Agente::where('id',$seleccionados[$i])->first();
                $aux1[$i]['id']=$asesor->id;
                $aux1[$i]['nombre']=$asesor->fullName;
                $aux1[$i]['codigo']=$asesor->codigo_id;

            }
        }
        else{
            $seleccionados=Agente::all();
            foreach ($seleccionados as $key=>$value) {
                $aux1[$key]['id']=$seleccionados[$key]->id;
                $aux1[$key]['nombre']=$seleccionados[$key]->fullName;
                $aux1[$key]['codigo']=$seleccionados[$key]->codigo_id;
            }
        }

        for ($i=0; $i <count($aux1) ; $i++) { 
            $valores1=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.tipo_inmueble',1)
                                                    ->where('propiedades.agente_id',$aux1[$i]['id'])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones, avg(negociaciones.precioFinal) as promedioPrecio, sum(negociaciones.precioFinal) as totalVentas,sum(negociaciones.comisionBruta) as ingresoBruto,sum(negociaciones.pagoCasaMatriz) as pagoMatriz ,sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first();
            $valores2=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.tipo_inmueble',2)
                                                    ->where('propiedades.agente_id',$aux1[$i]['id'])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones, avg(negociaciones.precioFinal) as promedioPrecio, sum(negociaciones.precioFinal) as totalVentas,sum(negociaciones.comisionBruta) as ingresoBruto,sum(negociaciones.pagoCasaMatriz) as pagoMatriz ,sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first();
            $valores3=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.tipo_inmueble',3)
                                                    ->where('propiedades.agente_id',$aux1[$i]['id'])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones, avg(negociaciones.precioFinal) as promedioPrecio, sum(negociaciones.precioFinal) as totalVentas,sum(negociaciones.comisionBruta) as ingresoBruto,sum(negociaciones.pagoCasaMatriz) as pagoMatriz ,sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first(); 
            $valores4=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.tipo_inmueble',4)
                                                    ->where('propiedades.agente_id',$aux1[$i]['id'])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones, avg(negociaciones.precioFinal) as promedioPrecio, sum(negociaciones.precioFinal) as totalVentas,sum(negociaciones.comisionBruta) as ingresoBruto,sum(negociaciones.pagoCasaMatriz) as pagoMatriz ,sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first(); 
            $valores5=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.tipo_inmueble',5)
                                                    ->where('propiedades.agente_id',$aux1[$i]['id'])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones, avg(negociaciones.precioFinal) as promedioPrecio, sum(negociaciones.precioFinal) as totalVentas,sum(negociaciones.comisionBruta) as ingresoBruto,sum(negociaciones.pagoCasaMatriz) as pagoMatriz ,sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first(); 
            $valores6=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.agente_id',$aux1[$i]['id'])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones, avg(negociaciones.precioFinal) as promedioPrecio, sum(negociaciones.precioFinal) as totalVentas,sum(negociaciones.comisionBruta) as ingresoBruto,sum(negociaciones.pagoCasaMatriz) as pagoMatriz ,sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first(); 

            $aux1[$i]['operacionesTerreno']=$valores1->operaciones;
            $aux1[$i]['promedioPrecioTerreno']=$valores1->promedioPrecio;
            $aux1[$i]['totalVentasTerreno']=$valores1->totalVentas;
            $aux1[$i]['ingresoBrutoTerreno']=$valores1->ingresoBruto;
            $aux1[$i]['pagoMatrizTerreno']=$valores1->pagoMatriz;
            $aux1[$i]['ingresoNetoTerreno']=$valores1->ingresoNeto;
            $aux1[$i]['operacionesComercial']=$valores2->operaciones;
            $aux1[$i]['promedioPrecioComercial']=$valores2->promedioPrecio;
            $aux1[$i]['totalVentasComercial']=$valores2->totalVentas;
            $aux1[$i]['ingresoBrutoComercial']=$valores2->ingresoBruto;
            $aux1[$i]['pagoMatrizComercial']=$valores2->pagoMatriz;
            $aux1[$i]['ingresoNetoComercial']=$valores2->ingresoNeto;    
            $aux1[$i]['operacionesResidencial']=$valores3->operaciones;
            $aux1[$i]['promedioPrecioResidencial']=$valores3->promedioPrecio;
            $aux1[$i]['totalVentasResidencial']=$valores3->totalVentas;
            $aux1[$i]['ingresoBrutoResidencial']=$valores3->ingresoBruto;
            $aux1[$i]['pagoMatrizResidencial']=$valores3->pagoMatriz;
            $aux1[$i]['ingresoNetoResidencial']=$valores3->ingresoNeto; 
            $aux1[$i]['operacionesVacacional']=$valores4->operaciones;
            $aux1[$i]['promedioPrecioVacacional']=$valores4->promedioPrecio;
            $aux1[$i]['totalVentasVacacional']=$valores4->totalVentas;
            $aux1[$i]['ingresoBrutoVacacional']=$valores4->ingresoBruto;
            $aux1[$i]['pagoMatrizVacacional']=$valores4->pagoMatriz;
            $aux1[$i]['ingresoNetoVacacional']=$valores4->ingresoNeto;
            $aux1[$i]['operacionesIndustrial']=$valores5->operaciones;
            $aux1[$i]['promedioPrecioIndustrial']=$valores5->promedioPrecio;
            $aux1[$i]['totalVentasIndustrial']=$valores5->totalVentas;
            $aux1[$i]['ingresoBrutoIndustrial']=$valores5->ingresoBruto;
            $aux1[$i]['pagoMatrizIndustrial']=$valores5->pagoMatriz;
            $aux1[$i]['ingresoNetoIndustrial']=$valores5->ingresoNeto;
            $aux1[$i]['operacionesTotal']=$valores6->operaciones;
            $aux1[$i]['promedioPrecioTotal']=$valores6->promedioPrecio;
            $aux1[$i]['totalVentasTotal']=$valores6->totalVentas;
            $aux1[$i]['ingresoBrutoTotal']=$valores6->ingresoBruto;
            $aux1[$i]['pagoMatrizTotal']=$valores6->pagoMatriz;
            $aux1[$i]['ingresoNetoTotal']=$valores6->ingresoNeto;                                       
            $cantidades['operaciones']=$cantidades['operaciones']+$valores6->operaciones;
            $cantidades['totalVentas']=$cantidades['totalVentas']+$valores6->totalVentas;
            $cantidades['ingresoBruto']=$cantidades['ingresoBruto']+$valores6->ingresoBruto;
            $cantidades['pagoMatriz']=$cantidades['pagoMatriz']+$valores6->pagoMatriz;
            $cantidades['ingresoNeto']=$cantidades['ingresoNeto']+$valores6->ingresoNeto;
        }

        if ($cantidades['operaciones']!=0) {
           $cantidades['promedioPrecio']=$cantidades['totalVentas']/$cantidades['operaciones'];
        }
        return view('reportes.VentasTipoInmuebleAsesor',compact('aux1','titulo','cantidades'));
    }

    public function EstadosCiudadesVentasTipoInmueble($estadosSelect,$ciudadesSelect){
        $citySinSelect=[];
        $estadoSinCiudad=[];
        $padresCiudad=[];

        for ($a=0; $a <count($estadosSelect) ; $a++) { 
            $aux1[]=Estado::where('id',$estadosSelect[$a])->first();
            $estateSelect[$a]['id']=$aux1[$a]->id;
            $estateSelect[$a]['nombre']=$aux1[$a]->nombre;
            $estateSelect[$a]['operaciones']=0;
            $estateSelect[$a]['promedioPrecio']=0;
            $estateSelect[$a]['totalVentas']=0;
            $estateSelect[$a]['ingresoBruto']=0;
            $estateSelect[$a]['pagoMatriz']=0;
            $estateSelect[$a]['ingresoNeto']=0;
        }

        for ($b=0; $b <count($ciudadesSelect) ; $b++) { 
            $aux2[]=Ciudad::where('id',$ciudadesSelect[$b])->first();
            $citySelect[$b]['id']=$aux2[$b]->id;
            $citySelect[$b]['padre']=$aux2[$b]->estado_id;
            $citySelect[$b]['nombre']=$aux2[$b]->nombre;
            $citySelect[$b]['operaciones']=0;
            $citySelect[$b]['promedioPrecio']=0;
            $citySelect[$b]['totalVentas']=0;
            $citySelect[$b]['ingresoBruto']=0;
            $citySelect[$b]['pagoMatriz']=0;
            $citySelect[$b]['ingresoNeto']=0;
            $padresCiudad[]= $citySelect[$b]['padre'];
        }


        for ($c=0; $c <count($estadosSelect) ; $c++) { 
            if (!in_array($estadosSelect[$c],$padresCiudad)) {
                if (!in_array($estadosSelect[$c], $estadoSinCiudad)) {
                    $estadoSinCiudad[]=$estadosSelect[$c];
                }
            }
        }

        for ($d=0; $d <count($estadoSinCiudad) ; $d++) { 
           $cityAll[]=Ciudad::where('estado_id',$estadoSinCiudad[$d])->get();
           for ($e=0; $e <count( $cityAll[$d]) ; $e++) { 
                $aux3[$e]['id']= $cityAll[$d][$e]->id;
                $aux3[$e]['padre']= $cityAll[$d][$e]->estado_id;
                $aux3[$e]['nombre']= $cityAll[$d][$e]->nombre;
                $aux3[$e]['operaciones']=0;
                $aux3[$a]['promedioPrecio']=0;
                $aux3[$e]['totalVentas']=0;
                $aux3[$e]['ingresoBruto']=0;
                $aux3[$e]['pagoMatriz']=0;
                $aux3[$e]['ingresoNeto']=0;
                $citySinSelect[]=$aux3[$e];
           }
        }
        for ($f=0; $f <count($citySinSelect) ; $f++ ){ 
            $citySelect[]=$citySinSelect[$f];
        }

        return compact('estateSelect','citySelect');
    }


    public function ventasTipoInmuebleUbicacion($fechaI,$fechaF,$estados,$ciudades,$urbanizaciones){
        $estadosSelect=explode(",", $estados);
        $ciudadesSelect=explode(",", $ciudades);
        $urbanizacionesSelect=explode(",", $urbanizaciones);
        $fechaFormatoInicial=date("d/m/Y", strtotime($fechaI));
        $fechaFormatoFinal=date("d/m/Y", strtotime($fechaF));
        $titulo="Ventas por tipo de Inmueble segun ubicación y segun rango de fechas: ".$fechaFormatoInicial." - ".$fechaFormatoFinal;
        $propiedadesT=[];
        $padresUrb=[];
        $ciudadSinUrb=[];
        $urbSelect=[];
        $urbSinSelect=[];
        $totales=['operaciones'=>0,'promedioPrecio'=>0,'totalVentas'=>0,'ingresoBruto'=>0,'pagoMatriz'=>0,'ingresoNeto'=>0];
  

        if ($ciudades!=0 && $urbanizaciones!=0) {

            $resultado=self::EstadosCiudadesVentasTipoInmueble($estadosSelect,$ciudadesSelect);
            $estateSelect=$resultado['estateSelect'];
            $citySelect=$resultado['citySelect'];

            for ($f=0; $f <count($urbanizacionesSelect) ; $f++) { 
                $aux4[]=Urbanizacion::where('id',$urbanizacionesSelect[$f])->first();
                $urbSelect[$f]['id']=$aux4[$f]->id;
                $urbSelect[$f]['padre']=$aux4[$f]->ciudad_id;
                $urbSelect[$f]['nombre']=$aux4[$f]->nombre;
                $urbSelect[$f]['operaciones']=0;
                $urbSelect[$f]['promedioPrecio']=0;
                $urbSelect[$f]['totalVentas']=0;
                $urbSelect[$f]['ingresoBruto']=0;
                $urbSelect[$f]['pagoMatriz']=0;
                $urbSelect[$f]['ingresoNeto']=0;
                
                $padresUrb[]= $urbSelect[$f]['padre'];
            }
            for ($h=0; $h <count($citySelect) ; $h++) { 
                if (!in_array($citySelect[$h]['id'],$padresUrb)) {
                    if (!in_array($citySelect[$h]['id'], $ciudadSinUrb)) {
                        $ciudadSinUrb[]=$citySelect[$h];
                    }
                }
            }
            for ($i=0; $i <count($ciudadSinUrb) ; $i++) { 
               $urbTodas[]=Urbanizacion::where('ciudad_id',$ciudadSinUrb[$i])->get();
               for ($j=0; $j <count($urbTodas[$i]) ; $j++) { 
                    $aux5[$j]['id']=$urbTodas[$i][$j]->id;
                    $aux5[$j]['padre']=$urbTodas[$i][$j]->ciudad_id;
                    $aux5[$j]['nombre']=$urbTodas[$i][$j]->nombre;
                    $aux5[$j]['operaciones']=0;
                    $aux5[$j]['promedioPrecio']=0;
                    $aux5[$j]['totalVentas']=0;
                    $aux5[$j]['ingresoBruto']=0;
                    $aux5[$j]['pagoMatriz']=0;
                    $aux5[$j]['ingresoNeto']=0;
                    $urbSinSelect[]=$aux5[$j];
               }
            }
            for ($k=0; $k <count($urbSinSelect) ; $k++ ){ 
                $urbSelect[]=$urbSinSelect[$k];
            }
        } 
        else if($ciudades!=0 && $urbanizaciones==0){

            $resultado=self::EstadosCiudadesVentasTipoInmueble($estadosSelect,$ciudadesSelect);
            $estateSelect=$resultado['estateSelect'];
            $citySelect=$resultado['citySelect'];

            for ($i=0; $i <count($citySelect) ; $i++) { 
               $urbTodas[]=Urbanizacion::where('ciudad_id',$citySelect[$i])->get();
               for ($j=0; $j <count($urbTodas[$i]) ; $j++) { 
                    $aux5[$j]['id']=$urbTodas[$i][$j]->id;
                    $aux5[$j]['padre']=$urbTodas[$i][$j]->ciudad_id;
                    $aux5[$j]['nombre']=$urbTodas[$i][$j]->nombre;
                    $aux5[$j]['operaciones']=0;
                    $aux5[$j]['promedioPrecio']=0;
                    $aux5[$j]['totalVentas']=0;
                    $aux5[$j]['ingresoBruto']=0;
                    $aux5[$j]['pagoMatriz']=0;
                    $aux5[$j]['ingresoNeto']=0;
                    $urbSelect[]=$aux5[$j];
               }
            }


        }
        else if($ciudades==0 && $urbanizaciones==0){
            for ($a=0; $a <count($estadosSelect) ; $a++) { 
                $aux1[]=Estado::where('id',$estadosSelect[$a])->first();
                $estateSelect[$a]['id']=$aux1[$a]->id;
                $estateSelect[$a]['nombre']=$aux1[$a]->nombre;
                $estateSelect[$a]['operaciones']=0;
                $estateSelect[$a]['promedioPrecio']=0;
                $estateSelect[$a]['totalVentas']=0;
                $estateSelect[$a]['ingresoBruto']=0;
                $estateSelect[$a]['pagoMatriz']=0;
                $estateSelect[$a]['ingresoNeto']=0;
            }

            for ($d=0; $d <count($estateSelect) ; $d++) { 
               $cityAll[]=Ciudad::where('estado_id',$estateSelect[$d])->get();
               for ($e=0; $e <count( $cityAll[$d]) ; $e++) { 
                    $aux3[$e]['id']= $cityAll[$d][$e]->id;
                    $aux3[$e]['padre']= $cityAll[$d][$e]->estado_id;
                    $aux3[$e]['nombre']= $cityAll[$d][$e]->nombre;
                    $aux3[$e]['operaciones']=0;
                    $aux3[$e]['promedioPrecio']=0;
                    $aux3[$e]['totalVentas']=0;
                    $aux3[$e]['ingresoBruto']=0;
                    $aux3[$e]['pagoMatriz']=0;
                    $aux3[$e]['ingresoNeto']=0;
                    $citySelect[]=$aux3[$e];
               }
            }

            for ($i=0; $i <count($citySelect) ; $i++) { 
               $urbTodas[]=Urbanizacion::where('ciudad_id',$citySelect[$i])->get();
               for ($j=0; $j <count($urbTodas[$i]) ; $j++) { 
                    $aux5[$j]['id']=$urbTodas[$i][$j]->id;
                    $aux5[$j]['padre']=$urbTodas[$i][$j]->ciudad_id;
                    $aux5[$j]['nombre']=$urbTodas[$i][$j]->nombre;
                    $aux5[$j]['operaciones']=0;
                    $aux5[$j]['promedioPrecio']=0;
                    $aux5[$j]['totalVentas']=0;
                    $aux5[$j]['ingresoBruto']=0;
                    $aux5[$j]['pagoMatriz']=0;
                    $aux5[$j]['ingresoNeto']=0;
                    $urbSelect[]=$aux5[$j];
               }
            }
        }
        
        for($i=0; $i<count($urbSelect); $i++) { 

            $valores1=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.tipo_inmueble',1)
                                                    ->where('propiedades.urbanizacion',$urbSelect[$i]['id'])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones, avg(negociaciones.precioFinal) as promedioPrecio, sum(negociaciones.precioFinal) as totalVentas,sum(negociaciones.comisionBruta) as ingresoBruto,sum(negociaciones.pagoCasaMatriz) as pagoMatriz ,sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first();
            $valores2=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.tipo_inmueble',2)
                                                    ->where('propiedades.urbanizacion',$urbSelect[$i]['id'])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones, avg(negociaciones.precioFinal) as promedioPrecio, sum(negociaciones.precioFinal) as totalVentas,sum(negociaciones.comisionBruta) as ingresoBruto,sum(negociaciones.pagoCasaMatriz) as pagoMatriz ,sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first();
            $valores3=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.tipo_inmueble',3)
                                                    ->where('propiedades.urbanizacion',$urbSelect[$i]['id'])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones, avg(negociaciones.precioFinal) as promedioPrecio, sum(negociaciones.precioFinal) as totalVentas,sum(negociaciones.comisionBruta) as ingresoBruto,sum(negociaciones.pagoCasaMatriz) as pagoMatriz ,sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first(); 
            $valores4=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.tipo_inmueble',4)
                                                    ->where('propiedades.urbanizacion',$urbSelect[$i]['id'])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones, avg(negociaciones.precioFinal) as promedioPrecio, sum(negociaciones.precioFinal) as totalVentas,sum(negociaciones.comisionBruta) as ingresoBruto,sum(negociaciones.pagoCasaMatriz) as pagoMatriz ,sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first(); 
            $valores5=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.tipo_inmueble',5)
                                                    ->where('propiedades.urbanizacion',$urbSelect[$i]['id'])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones, avg(negociaciones.precioFinal) as promedioPrecio, sum(negociaciones.precioFinal) as totalVentas,sum(negociaciones.comisionBruta) as ingresoBruto,sum(negociaciones.pagoCasaMatriz) as pagoMatriz ,sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first(); 
            $valores6=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.urbanizacion',$urbSelect[$i]['id'])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones, avg(negociaciones.precioFinal) as promedioPrecio, sum(negociaciones.precioFinal) as totalVentas,sum(negociaciones.comisionBruta) as ingresoBruto,sum(negociaciones.pagoCasaMatriz) as pagoMatriz ,sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first(); 

            $aux20[$i]['operacionesTerreno']=$valores1->operaciones;
            $aux20[$i]['promedioPrecioTerreno']=$valores1->promedioPrecio;
            $aux20[$i]['totalVentasTerreno']=$valores1->totalVentas;
            $aux20[$i]['ingresoBrutoTerreno']=$valores1->ingresoBruto;
            $aux20[$i]['pagoMatrizTerreno']=$valores1->pagoMatriz;
            $aux20[$i]['ingresoNetoTerreno']=$valores1->ingresoNeto;
            $aux20[$i]['operacionesComercial']=$valores2->operaciones;
            $aux20[$i]['promedioPrecioComercial']=$valores2->promedioPrecio;
            $aux20[$i]['totalVentasComercial']=$valores2->totalVentas;
            $aux20[$i]['ingresoBrutoComercial']=$valores2->ingresoBruto;
            $aux20[$i]['pagoMatrizComercial']=$valores2->pagoMatriz;
            $aux20[$i]['ingresoNetoComercial']=$valores2->ingresoNeto;    
            $aux20[$i]['operacionesResidencial']=$valores3->operaciones;
            $aux20[$i]['promedioPrecioResidencial']=$valores3->promedioPrecio;
            $aux20[$i]['totalVentasResidencial']=$valores3->totalVentas;
            $aux20[$i]['ingresoBrutoResidencial']=$valores3->ingresoBruto;
            $aux20[$i]['pagoMatrizResidencial']=$valores3->pagoMatriz;
            $aux20[$i]['ingresoNetoResidencial']=$valores3->ingresoNeto; 
            $aux20[$i]['operacionesVacacional']=$valores4->operaciones;
            $aux20[$i]['promedioPrecioVacacional']=$valores4->promedioPrecio;
            $aux20[$i]['totalVentasVacacional']=$valores4->totalVentas;
            $aux20[$i]['ingresoBrutoVacacional']=$valores4->ingresoBruto;
            $aux20[$i]['pagoMatrizVacacional']=$valores4->pagoMatriz;
            $aux20[$i]['ingresoNetoVacacional']=$valores4->ingresoNeto;
            $aux20[$i]['operacionesIndustrial']=$valores5->operaciones;
            $aux20[$i]['promedioPrecioIndustrial']=$valores5->promedioPrecio;
            $aux20[$i]['totalVentasIndustrial']=$valores5->totalVentas;
            $aux20[$i]['ingresoBrutoIndustrial']=$valores5->ingresoBruto;
            $aux20[$i]['pagoMatrizIndustrial']=$valores5->pagoMatriz;
            $aux20[$i]['ingresoNetoIndustrial']=$valores5->ingresoNeto;
            $aux20[$i]['padre']=$urbSelect[$i]['id'];
            $urbSelect[$i]['operaciones']=$urbSelect[$i]['operaciones']+$valores6->operaciones;
            $urbSelect[$i]['totalVentas']=$urbSelect[$i]['totalVentas']+$valores6->totalVentas;
            $urbSelect[$i]['ingresoBruto']=$urbSelect[$i]['ingresoBruto']+$valores6->ingresoBruto;
            $urbSelect[$i]['pagoMatriz']=$urbSelect[$i]['pagoMatriz']+$valores6->pagoMatriz;
            $urbSelect[$i]['ingresoNeto']=$urbSelect[$i]['ingresoNeto']+$valores6->ingresoNeto;
            if ($urbSelect[$i]['operaciones']!=0) {
                $urbSelect[$i]['promedioPrecio']=$urbSelect[$i]['totalVentas']/$urbSelect[$i]['operaciones'];
            }
        }

    
        for ($a=0; $a < count($citySelect); $a++) { 
            for ($b=0; $b < count($urbSelect); $b++) { 
                if ($citySelect[$a]['id']==$urbSelect[$b]['padre']) {
                    $citySelect[$a]['operaciones']=$citySelect[$a]['operaciones']+$urbSelect[$b]['operaciones'];
                    $citySelect[$a]['totalVentas']=$citySelect[$a]['totalVentas']+$urbSelect[$b]['totalVentas'];
                    $citySelect[$a]['ingresoBruto']=$citySelect[$a]['ingresoBruto']+$urbSelect[$b]['ingresoBruto'];
                    $citySelect[$a]['pagoMatriz']=$citySelect[$a]['pagoMatriz']+$urbSelect[$b]['pagoMatriz'];
                    $citySelect[$a]['ingresoNeto']=$citySelect[$a]['ingresoNeto']+$urbSelect[$b]['ingresoNeto'];
                    
                }
            }
            if ($citySelect[$a]['operaciones']!=0) {
                $citySelect[$a]['promedioPrecio']=$citySelect[$a]['totalVentas']/$citySelect[$a]['operaciones'];

            }
        }

        

        for ($a=0; $a < count($estateSelect); $a++) { 
            for ($b=0; $b < count($citySelect); $b++) { 
                if ($estateSelect[$a]['id']==$citySelect[$b]['padre']) {
                    $estateSelect[$a]['operaciones']=$estateSelect[$a]['operaciones']+$citySelect[$b]['operaciones'];
                    $estateSelect[$a]['totalVentas']=$estateSelect[$a]['totalVentas']+$citySelect[$b]['totalVentas'];
                    $estateSelect[$a]['ingresoBruto']=$estateSelect[$a]['ingresoBruto']+$citySelect[$b]['ingresoBruto'];
                    $estateSelect[$a]['pagoMatriz']=$estateSelect[$a]['pagoMatriz']+$citySelect[$b]['pagoMatriz'];
                    $estateSelect[$a]['ingresoNeto']=$estateSelect[$a]['ingresoNeto']+$citySelect[$b]['ingresoNeto'];
                }
            }
            if ($estateSelect[$a]['operaciones']!=0) {
                $estateSelect[$a]['promedioPrecio']=$estateSelect[$a]['totalVentas']/$estateSelect[$a]['operaciones'];
            }
        }

        

        for ($b=0; $b < count($estateSelect); $b++) { 
            $totales['operaciones']=$totales['operaciones']+$estateSelect[$b]['operaciones'];
            $totales['totalVentas']=$totales['totalVentas']+$estateSelect[$b]['totalVentas'];
            $totales['ingresoBruto']=$totales['ingresoBruto']+$estateSelect[$b]['ingresoBruto'];
            $totales['pagoMatriz']=$totales['pagoMatriz']+$estateSelect[$b]['pagoMatriz'];
            $totales['ingresoNeto']=$totales['ingresoNeto']+$estateSelect[$b]['ingresoNeto'];

            if ($totales['operaciones']!=0) {
                $totales['promedioPrecio']=$totales['totalVentas']/$totales['operaciones'];
            }
        }
        //dd($totales);
        return view('reportes.VentasTipoInmuebleUbicacion',compact('urbSelect','citySelect','estateSelect','titulo','totales','aux20')); 
    }

    public function ventasTipoNegocioAsesor($fechaI,$fechaF,$data){
        $seleccionados=explode(",", $data);
        $fechaFormatoInicial=date("d/m/Y", strtotime($fechaI));
        $fechaFormatoFinal=date("d/m/Y", strtotime($fechaF));
        $titulo="Ventas por tipo de Negocio segun rango de fechas: ".$fechaFormatoInicial." - ".$fechaFormatoFinal;
        $cantidades=['operaciones'=>0,'promedioPrecio'=>0,'totalVentas'=>0,'ingresoBruto'=>0,'pagoMatriz'=>0,'ingresoNeto'=>0];
        if ($data!=0) { 
            for($i=0; $i<count($seleccionados); $i++){ 
                $asesor=Agente::where('id',$seleccionados[$i])->first();
                $aux1[$i]['id']=$asesor->id;
                $aux1[$i]['nombre']=$asesor->fullName;
                $aux1[$i]['codigo']=$asesor->codigo_id;

            }
        }
        else{
            $seleccionados=Agente::all();
            foreach ($seleccionados as $key=>$value) {
                $aux1[$key]['id']=$seleccionados[$key]->id;
                $aux1[$key]['nombre']=$seleccionados[$key]->fullName;
                $aux1[$key]['codigo']=$seleccionados[$key]->codigo_id;
            }
        }

        for ($i=0; $i <count($aux1) ; $i++) { 
            $valores1=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.tipoNegocio','Venta')
                                                    ->where('propiedades.agente_id',$aux1[$i]['id'])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones, avg(negociaciones.precioFinal) as promedioPrecio, sum(negociaciones.precioFinal) as totalVentas,sum(negociaciones.comisionBruta) as ingresoBruto,sum(negociaciones.pagoCasaMatriz) as pagoMatriz ,sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first();
            $valores2=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.tipoNegocio','Alquiler')
                                                    ->where('propiedades.agente_id',$aux1[$i]['id'])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones, avg(negociaciones.precioFinal) as promedioPrecio, sum(negociaciones.precioFinal) as totalVentas,sum(negociaciones.comisionBruta) as ingresoBruto,sum(negociaciones.pagoCasaMatriz) as pagoMatriz ,sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first();
            $valores3=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.agente_id',$aux1[$i]['id'])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones, avg(negociaciones.precioFinal) as promedioPrecio, sum(negociaciones.precioFinal) as totalVentas,sum(negociaciones.comisionBruta) as ingresoBruto,sum(negociaciones.pagoCasaMatriz) as pagoMatriz ,sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first(); 

            $aux1[$i]['operacionesVentas']=$valores1->operaciones;
            $aux1[$i]['promedioPrecioVentas']=$valores1->promedioPrecio;
            $aux1[$i]['totalVentasVentas']=$valores1->totalVentas;
            $aux1[$i]['ingresoBrutoVentas']=$valores1->ingresoBruto;
            $aux1[$i]['pagoMatrizVentas']=$valores1->pagoMatriz;
            $aux1[$i]['ingresoNetoVentas']=$valores1->ingresoNeto;
            $aux1[$i]['operacionesAlquiler']=$valores2->operaciones;
            $aux1[$i]['promedioPrecioAlquiler']=$valores2->promedioPrecio;
            $aux1[$i]['totalVentasAlquiler']=$valores2->totalVentas;
            $aux1[$i]['ingresoBrutoAlquiler']=$valores2->ingresoBruto;
            $aux1[$i]['pagoMatrizAlquiler']=$valores2->pagoMatriz;
            $aux1[$i]['ingresoNetoAlquiler']=$valores2->ingresoNeto; 
            $aux1[$i]['operacionesTotal']=$valores3->operaciones;
            $aux1[$i]['promedioPrecioTotal']=$valores3->promedioPrecio;
            $aux1[$i]['totalVentasTotal']=$valores3->totalVentas;
            $aux1[$i]['ingresoBrutoTotal']=$valores3->ingresoBruto;
            $aux1[$i]['pagoMatrizTotal']=$valores3->pagoMatriz;
            $aux1[$i]['ingresoNetoTotal']=$valores3->ingresoNeto;                         
            $cantidades['operaciones']=$cantidades['operaciones']+$valores3->operaciones;
            $cantidades['totalVentas']=$cantidades['totalVentas']+$valores3->totalVentas;
            $cantidades['ingresoBruto']=$cantidades['ingresoBruto']+$valores3->ingresoBruto;
            $cantidades['pagoMatriz']=$cantidades['pagoMatriz']+$valores3->pagoMatriz;
            $cantidades['ingresoNeto']=$cantidades['ingresoNeto']+$valores3->ingresoNeto;
        }

        if ($cantidades['operaciones']!=0) {
           $cantidades['promedioPrecio']=$cantidades['totalVentas']/$cantidades['operaciones'];
        }
        //dd($aux1);
        return view('reportes.VentasTipoNegocioAsesor',compact('aux1','titulo','cantidades'));
    }

    public function ventasTipoNegocioUbicacion($fechaI,$fechaF,$estados,$ciudades,$urbanizaciones){
        $estadosSelect=explode(",", $estados);
        $ciudadesSelect=explode(",", $ciudades);
        $urbanizacionesSelect=explode(",", $urbanizaciones);
        $fechaFormatoInicial=date("d/m/Y", strtotime($fechaI));
        $fechaFormatoFinal=date("d/m/Y", strtotime($fechaF));
        $titulo="Ventas por tipo de Negocio segun ubicación y segun rango de fechas: ".$fechaFormatoInicial." - ".$fechaFormatoFinal;
        $propiedadesT=[];
        $padresUrb=[];
        $ciudadSinUrb=[];
        $urbSelect=[];
        $urbSinSelect=[];
        $totales=['operaciones'=>0,'promedioPrecio'=>0,'totalVentas'=>0,'ingresoBruto'=>0,'pagoMatriz'=>0,'ingresoNeto'=>0];
  

        if ($ciudades!=0 && $urbanizaciones!=0) {

            $resultado=self::EstadosCiudadesVentasTipoInmueble($estadosSelect,$ciudadesSelect);
            $estateSelect=$resultado['estateSelect'];
            $citySelect=$resultado['citySelect'];

            for ($f=0; $f <count($urbanizacionesSelect) ; $f++) { 
                $aux4[]=Urbanizacion::where('id',$urbanizacionesSelect[$f])->first();
                $urbSelect[$f]['id']=$aux4[$f]->id;
                $urbSelect[$f]['padre']=$aux4[$f]->ciudad_id;
                $urbSelect[$f]['nombre']=$aux4[$f]->nombre;
                $urbSelect[$f]['operaciones']=0;
                $urbSelect[$f]['promedioPrecio']=0;
                $urbSelect[$f]['totalVentas']=0;
                $urbSelect[$f]['ingresoBruto']=0;
                $urbSelect[$f]['pagoMatriz']=0;
                $urbSelect[$f]['ingresoNeto']=0;
                
                $padresUrb[]= $urbSelect[$f]['padre'];
            }
            for ($h=0; $h <count($citySelect) ; $h++) { 
                if (!in_array($citySelect[$h]['id'],$padresUrb)) {
                    if (!in_array($citySelect[$h]['id'], $ciudadSinUrb)) {
                        $ciudadSinUrb[]=$citySelect[$h];
                    }
                }
            }
            for ($i=0; $i <count($ciudadSinUrb) ; $i++) { 
               $urbTodas[]=Urbanizacion::where('ciudad_id',$ciudadSinUrb[$i])->get();
               for ($j=0; $j <count($urbTodas[$i]) ; $j++) { 
                    $aux5[$j]['id']=$urbTodas[$i][$j]->id;
                    $aux5[$j]['padre']=$urbTodas[$i][$j]->ciudad_id;
                    $aux5[$j]['nombre']=$urbTodas[$i][$j]->nombre;
                    $aux5[$j]['operaciones']=0;
                    $aux5[$j]['promedioPrecio']=0;
                    $aux5[$j]['totalVentas']=0;
                    $aux5[$j]['ingresoBruto']=0;
                    $aux5[$j]['pagoMatriz']=0;
                    $aux5[$j]['ingresoNeto']=0;
                    $urbSinSelect[]=$aux5[$j];
               }
            }
            for ($k=0; $k <count($urbSinSelect) ; $k++ ){ 
                $urbSelect[]=$urbSinSelect[$k];
            }
        } 
        else if($ciudades!=0 && $urbanizaciones==0){

            $resultado=self::EstadosCiudadesVentasTipoInmueble($estadosSelect,$ciudadesSelect);
            $estateSelect=$resultado['estateSelect'];
            $citySelect=$resultado['citySelect'];

            for ($i=0; $i <count($citySelect) ; $i++) { 
               $urbTodas[]=Urbanizacion::where('ciudad_id',$citySelect[$i])->get();
               for ($j=0; $j <count($urbTodas[$i]) ; $j++) { 
                    $aux5[$j]['id']=$urbTodas[$i][$j]->id;
                    $aux5[$j]['padre']=$urbTodas[$i][$j]->ciudad_id;
                    $aux5[$j]['nombre']=$urbTodas[$i][$j]->nombre;
                    $aux5[$j]['operaciones']=0;
                    $aux5[$j]['promedioPrecio']=0;
                    $aux5[$j]['totalVentas']=0;
                    $aux5[$j]['ingresoBruto']=0;
                    $aux5[$j]['pagoMatriz']=0;
                    $aux5[$j]['ingresoNeto']=0;
                    $urbSelect[]=$aux5[$j];
               }
            }


        }
        else if($ciudades==0 && $urbanizaciones==0){
            for ($a=0; $a <count($estadosSelect) ; $a++) { 
                $aux1[]=Estado::where('id',$estadosSelect[$a])->first();
                $estateSelect[$a]['id']=$aux1[$a]->id;
                $estateSelect[$a]['nombre']=$aux1[$a]->nombre;
                $estateSelect[$a]['operaciones']=0;
                $estateSelect[$a]['promedioPrecio']=0;
                $estateSelect[$a]['totalVentas']=0;
                $estateSelect[$a]['ingresoBruto']=0;
                $estateSelect[$a]['pagoMatriz']=0;
                $estateSelect[$a]['ingresoNeto']=0;
            }

            for ($d=0; $d <count($estateSelect) ; $d++) { 
               $cityAll[]=Ciudad::where('estado_id',$estateSelect[$d])->get();
               for ($e=0; $e <count( $cityAll[$d]) ; $e++) { 
                    $aux3[$e]['id']= $cityAll[$d][$e]->id;
                    $aux3[$e]['padre']= $cityAll[$d][$e]->estado_id;
                    $aux3[$e]['nombre']= $cityAll[$d][$e]->nombre;
                    $aux3[$e]['operaciones']=0;
                    $aux3[$e]['promedioPrecio']=0;
                    $aux3[$e]['totalVentas']=0;
                    $aux3[$e]['ingresoBruto']=0;
                    $aux3[$e]['pagoMatriz']=0;
                    $aux3[$e]['ingresoNeto']=0;
                    $citySelect[]=$aux3[$e];
               }
            }

            for ($i=0; $i <count($citySelect) ; $i++) { 
               $urbTodas[]=Urbanizacion::where('ciudad_id',$citySelect[$i])->get();
               for ($j=0; $j <count($urbTodas[$i]) ; $j++) { 
                    $aux5[$j]['id']=$urbTodas[$i][$j]->id;
                    $aux5[$j]['padre']=$urbTodas[$i][$j]->ciudad_id;
                    $aux5[$j]['nombre']=$urbTodas[$i][$j]->nombre;
                    $aux5[$j]['operaciones']=0;
                    $aux5[$j]['promedioPrecio']=0;
                    $aux5[$j]['totalVentas']=0;
                    $aux5[$j]['ingresoBruto']=0;
                    $aux5[$j]['pagoMatriz']=0;
                    $aux5[$j]['ingresoNeto']=0;
                    $urbSelect[]=$aux5[$j];
               }
            }
        }
        
        for($i=0; $i<count($urbSelect); $i++) { 

            $valores1=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.tipoNegocio','Venta')
                                                    ->where('propiedades.urbanizacion',$urbSelect[$i]['id'])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones, avg(negociaciones.precioFinal) as promedioPrecio, sum(negociaciones.precioFinal) as totalVentas,sum(negociaciones.comisionBruta) as ingresoBruto,sum(negociaciones.pagoCasaMatriz) as pagoMatriz ,sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first();
            $valores2=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.tipoNegocio','Alquiler')
                                                    ->where('propiedades.urbanizacion',$urbSelect[$i]['id'])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones, avg(negociaciones.precioFinal) as promedioPrecio, sum(negociaciones.precioFinal) as totalVentas,sum(negociaciones.comisionBruta) as ingresoBruto,sum(negociaciones.pagoCasaMatriz) as pagoMatriz ,sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first();
            $valores3=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.urbanizacion',$urbSelect[$i]['id'])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones, avg(negociaciones.precioFinal) as promedioPrecio, sum(negociaciones.precioFinal) as totalVentas,sum(negociaciones.comisionBruta) as ingresoBruto,sum(negociaciones.pagoCasaMatriz) as pagoMatriz ,sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first(); 

            $aux20[$i]['operacionesVenta']=$valores1->operaciones;
            $aux20[$i]['promedioPrecioVenta']=$valores1->promedioPrecio;
            $aux20[$i]['totalVentasVenta']=$valores1->totalVentas;
            $aux20[$i]['ingresoBrutoVenta']=$valores1->ingresoBruto;
            $aux20[$i]['pagoMatrizVenta']=$valores1->pagoMatriz;
            $aux20[$i]['ingresoNetoVenta']=$valores1->ingresoNeto;
            $aux20[$i]['operacionesAlquiler']=$valores2->operaciones;
            $aux20[$i]['promedioPrecioAlquiler']=$valores2->promedioPrecio;
            $aux20[$i]['totalVentasAlquiler']=$valores2->totalVentas;
            $aux20[$i]['ingresoBrutoAlquiler']=$valores2->ingresoBruto;
            $aux20[$i]['pagoMatrizAlquiler']=$valores2->pagoMatriz;
            $aux20[$i]['ingresoNetoAlquiler']=$valores2->ingresoNeto;    
            $aux20[$i]['padre']=$urbSelect[$i]['id'];
            $urbSelect[$i]['operaciones']=$urbSelect[$i]['operaciones']+$valores3->operaciones;
            $urbSelect[$i]['totalVentas']=$urbSelect[$i]['totalVentas']+$valores3->totalVentas;
            $urbSelect[$i]['ingresoBruto']=$urbSelect[$i]['ingresoBruto']+$valores3->ingresoBruto;
            $urbSelect[$i]['pagoMatriz']=$urbSelect[$i]['pagoMatriz']+$valores3->pagoMatriz;
            $urbSelect[$i]['ingresoNeto']=$urbSelect[$i]['ingresoNeto']+$valores3->ingresoNeto;
            if ($urbSelect[$i]['operaciones']!=0) {
                $urbSelect[$i]['promedioPrecio']=$urbSelect[$i]['totalVentas']/$urbSelect[$i]['operaciones'];
            }
        }

    
        for ($a=0; $a < count($citySelect); $a++) { 
            for ($b=0; $b < count($urbSelect); $b++) { 
                if ($citySelect[$a]['id']==$urbSelect[$b]['padre']) {
                    $citySelect[$a]['operaciones']=$citySelect[$a]['operaciones']+$urbSelect[$b]['operaciones'];
                    $citySelect[$a]['totalVentas']=$citySelect[$a]['totalVentas']+$urbSelect[$b]['totalVentas'];
                    $citySelect[$a]['ingresoBruto']=$citySelect[$a]['ingresoBruto']+$urbSelect[$b]['ingresoBruto'];
                    $citySelect[$a]['pagoMatriz']=$citySelect[$a]['pagoMatriz']+$urbSelect[$b]['pagoMatriz'];
                    $citySelect[$a]['ingresoNeto']=$citySelect[$a]['ingresoNeto']+$urbSelect[$b]['ingresoNeto'];
                    
                }
            }
            if ($citySelect[$a]['operaciones']!=0) {
                $citySelect[$a]['promedioPrecio']=$citySelect[$a]['totalVentas']/$citySelect[$a]['operaciones'];

            }
        }

        

        for ($a=0; $a < count($estateSelect); $a++) { 
            for ($b=0; $b < count($citySelect); $b++) { 
                if ($estateSelect[$a]['id']==$citySelect[$b]['padre']) {
                    $estateSelect[$a]['operaciones']=$estateSelect[$a]['operaciones']+$citySelect[$b]['operaciones'];
                    $estateSelect[$a]['totalVentas']=$estateSelect[$a]['totalVentas']+$citySelect[$b]['totalVentas'];
                    $estateSelect[$a]['ingresoBruto']=$estateSelect[$a]['ingresoBruto']+$citySelect[$b]['ingresoBruto'];
                    $estateSelect[$a]['pagoMatriz']=$estateSelect[$a]['pagoMatriz']+$citySelect[$b]['pagoMatriz'];
                    $estateSelect[$a]['ingresoNeto']=$estateSelect[$a]['ingresoNeto']+$citySelect[$b]['ingresoNeto'];
                }
            }
            if ($estateSelect[$a]['operaciones']!=0) {
                $estateSelect[$a]['promedioPrecio']=$estateSelect[$a]['totalVentas']/$estateSelect[$a]['operaciones'];
            }
        }

        

        for ($b=0; $b < count($estateSelect); $b++) { 
            $totales['operaciones']=$totales['operaciones']+$estateSelect[$b]['operaciones'];
            $totales['totalVentas']=$totales['totalVentas']+$estateSelect[$b]['totalVentas'];
            $totales['ingresoBruto']=$totales['ingresoBruto']+$estateSelect[$b]['ingresoBruto'];
            $totales['pagoMatriz']=$totales['pagoMatriz']+$estateSelect[$b]['pagoMatriz'];
            $totales['ingresoNeto']=$totales['ingresoNeto']+$estateSelect[$b]['ingresoNeto'];

            if ($totales['operaciones']!=0) {
                $totales['promedioPrecio']=$totales['totalVentas']/$totales['operaciones'];
            }
        }
        //dd($totales);
        return view('reportes.VentasTipoNegocioUbicacion',compact('urbSelect','citySelect','estateSelect','titulo','totales','aux20')); 
    }

    public function rendimientoAsesor($fechaI,$fechaF,$data){
        $seleccionados=explode(",", $data);
        $fechaFormatoInicial=date("d/m/Y", strtotime($fechaI));
        $fechaFormatoFinal=date("d/m/Y", strtotime($fechaF));
        $titulo="Reporte General del Asesor segun rango de fechas: ".$fechaFormatoInicial." - ".$fechaFormatoFinal;
        $cantidades=['operaciones'=>0,'promedioPrecio'=>0,'totalVentas'=>0,'ingresoBruto'=>0,'pagoMatriz'=>0,'ingresoNeto'=>0];
        if ($data!=0) { 
            for($i=0; $i<count($seleccionados); $i++){ 
                $asesor=Agente::where('id',$seleccionados[$i])->first();
                $aux1[$i]['id']=$asesor->id;
                $aux1[$i]['nombre']=$asesor->fullName;
                $aux1[$i]['codigo']=$asesor->codigo_id;
                $aux1[$i]['antiguedad']=0;

            }
        }
        else{
            $seleccionados=Agente::all();
            foreach ($seleccionados as $key=>$value) {
                $aux1[$key]['id']=$seleccionados[$key]->id;
                $aux1[$key]['nombre']=$seleccionados[$key]->fullName;
                $aux1[$key]['codigo']=$seleccionados[$key]->codigo_id;
                $aux1[$key]['antiguedad']=0;
            }
        }

        for ($i=0; $i <count($aux1) ; $i++) { 
            $antiguedad=User::where('agente_id',$aux1[$i]['id'])->select('date_entry')->first();
            if (count($antiguedad)!=0) {
                $fechaInicial = new DateTime($antiguedad->date_entry);
                $actualidad = new DateTime();
                $interval = $fechaInicial->diff($actualidad);
                $aux1[$i]['antiguedad']=$interval->format('%m');   
            }
            



            $valores1=Propiedad::where('agente_id',$aux1[$i]['id'])
                                                     ->where('id_mls',0)
                                                     ->whereBetween('fechaCreado', [$fechaI,$fechaF])
                                                     ->select(DB::raw('count(*) as propiedades'))
                                                     ->first();

            $valores2=Propiedad::where('agente_id',$aux1[$i]['id'])
                                                     ->where('id_mls','<>',0)
                                                     ->whereBetween('fechaCreado', [$fechaI,$fechaF])
                                                     ->select(DB::raw('count(*) as propiedades'))
                                                     ->first();

            $valores3=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.agente_id',$aux1[$i]['id'])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as propiedades'))
                                                    ->first();

            $valores4=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where([['negociaciones.asesorCaptador','<>',$aux1[$i]['nombre']],['negociaciones.asesorCerrador',$aux1[$i]['nombre']]])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as cerradas'))
                                                    ->first();

            $valores5=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where([['negociaciones.asesorCaptador',$aux1[$i]['nombre']],['negociaciones.asesorCerrador','<>',$aux1[$i]['nombre']]])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as captadas'))
                                                    ->first();

            $valores6=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where([['negociaciones.asesorCaptador',$aux1[$i]['nombre']],['negociaciones.asesorCerrador',$aux1[$i]['nombre']]])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as CACI'))
                                                    ->first();  

            $valores7=Propiedad::where('agente_id',$aux1[$i]['id'])
                                                     ->whereBetween('fechaCreado', [$fechaI,$fechaF])
                                                     ->select(DB::raw('avg(precio) as precioPromedio'))
                                                     ->first();

            $valores8=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.agente_id',$aux1[$i]['id'])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones, avg(negociaciones.precioFinal) as promedioPrecio, sum(negociaciones.precioFinal) as totalVentas,sum(negociaciones.comisionBruta) as ingresoBruto,sum(negociaciones.pagoCasaMatriz) as pagoMatriz ,sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first();       

            $tipoInmueble=TipoInmueble::all();
            for ($e=0; $e <count($tipoInmueble) ; $e++) { 
                $inmueble=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.tipo_inmueble',$tipoInmueble[$e]->id)
                                                    ->where('propiedades.tipoNegocio','Venta')
                                                    ->where('propiedades.agente_id',$aux1[$i]['id'])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones, avg(negociaciones.precioFinal) as promedioPrecio, sum(negociaciones.precioFinal) as totalVentas,sum(negociaciones.comisionBruta) as ingresoBruto,sum(negociaciones.pagoCasaMatriz) as pagoMatriz ,sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first();

                $inmueble2=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where('propiedades.tipo_inmueble',$tipoInmueble[$e]->id)
                                                    ->where('propiedades.tipoNegocio','Alquiler')
                                                    ->where('propiedades.agente_id',$aux1[$i]['id'])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as operaciones, avg(negociaciones.precioFinal) as promedioPrecio, sum(negociaciones.precioFinal) as totalVentas,sum(negociaciones.comisionBruta) as ingresoBruto,sum(negociaciones.pagoCasaMatriz) as pagoMatriz ,sum(negociaciones.ingresoNeto) as ingresoNeto'))
                                                    ->first();         

                                   



                $aux2[$i][$e]['nombreTipo']=$tipoInmueble[$e]->nombre;
                $aux2[$i][$e]['padre']=$aux1[$i]['id'];
                $aux2[$i][$e]['propiedadVenta']=$inmueble->operaciones;
                $aux2[$i][$e]['promedioVenta']=$inmueble->promedioPrecio;
                $aux2[$i][$e]['totalVenta']=$inmueble->totalVentas;
                $aux2[$i][$e]['comisionBrutaVenta']=$inmueble->ingresoBruto;
                $aux2[$i][$e]['pagoMatrizVenta']=$inmueble->pagoMatriz;
                $aux2[$i][$e]['ingresoNetoVenta']=$inmueble->ingresoNeto;
                $aux2[$i][$e]['propiedadAlquiler']=$inmueble2->operaciones;
                $aux2[$i][$e]['promedioAlquiler']=$inmueble2->promedioPrecio;
                $aux2[$i][$e]['totalAlquiler']=$inmueble2->totalVentas;
                $aux2[$i][$e]['comisionBrutaAlquiler']=$inmueble2->ingresoBruto;
                $aux2[$i][$e]['pagoMatrizAlquiler']=$inmueble2->pagoMatriz;
                $aux2[$i][$e]['ingresoNetoAlquiler']=$inmueble2->ingresoNeto;
            }
            
    

                                                 
            $aux1[$i]['propiedadSinExclusiva']=$valores1->propiedades;
            $aux1[$i]['propiedadExclusiva']=$valores2->propiedades;
            $aux1[$i]['propiedadesCaptadas']= $aux1[$i]['propiedadExclusiva']+$aux1[$i]['propiedadSinExclusiva'];
            $aux1[$i]['propiedadesVendidas']=$valores3->propiedades;
            $aux1[$i]['cerrador']=$valores4->cerradas;
            $aux1[$i]['captador']=$valores5->captadas;
            $aux1[$i]['ambos']=$valores6->CACI;
            $aux1[$i]['precioPromedioCaptacion']=$valores7->precioPromedio;
            $cantidades['operaciones']=$cantidades['operaciones']+$valores8->operaciones;
            $cantidades['totalVentas']=$cantidades['totalVentas']+$valores8->totalVentas;
            $cantidades['ingresoBruto']=$cantidades['ingresoBruto']+$valores8->ingresoBruto;
            $cantidades['pagoMatriz']=$cantidades['pagoMatriz']+$valores8->pagoMatriz;
            $cantidades['ingresoNeto']=$cantidades['ingresoNeto']+$valores8->ingresoNeto;

            
        }

        
       // dd($aux2);



        return view('reportes.RendimientoAsesor',compact('aux1','aux2','titulo','cantidades'));
    }



    public function negociacionesGeneral($fechaI,$fechaF,$data){
        $seleccionados=explode(",", $data);
        $fechaFormatoInicial=date("d/m/Y", strtotime($fechaI));
        $fechaFormatoFinal=date("d/m/Y", strtotime($fechaF));
        $titulo="Reporte General de negociaciones segun rango de fechas: ".$fechaFormatoInicial." - ".$fechaFormatoFinal;
        $cantidades=['operaciones'=>0,'promedioPrecio'=>0,'totalVentas'=>0,'ingresoBruto'=>0,'pagoMatriz'=>0,'ingresoNeto'=>0];
        if ($data!=0) { 
            for($i=0; $i<count($seleccionados); $i++){ 
                $asesor=Agente::where('id',$seleccionados[$i])->first();
                $aux1[$i]['id']=$asesor->id;
                $aux1[$i]['nombre']=$asesor->fullName;
                $aux1[$i]['codigo']=$asesor->codigo_id;
                $aux1[$i]['propuesta']=0;
                $aux1[$i]['deposito']=0;
                $aux1[$i]['promesa']=0;
                $aux1[$i]['firma']=0;  
            }
        }
        else{
            $seleccionados=Agente::all();
            foreach ($seleccionados as $key=>$value) {
                $aux1[$key]['id']=$seleccionados[$key]->id;
                $aux1[$key]['nombre']=$seleccionados[$key]->fullName;
                $aux1[$key]['codigo']=$seleccionados[$key]->codigo_id;
                $aux1[$key]['propuesta']=0;
                $aux1[$key]['deposito']=0;
                $aux1[$key]['promesa']=0;
                $aux1[$key]['firma']=0;  
            }
        }

        for ($i=0; $i <count($aux1) ; $i++) { 

            $negociacionesActivas=Negociacion::where('estatus',8)
                                        ->where('asesorCaptador',$aux1[$i]['nombre'])
                                        ->whereBetween('fechaCreacion', [$fechaI,$fechaF])
                                        ->get();
            $negociacionesCanceladas=Negociacion::where('estatus',9)
                                        ->where('asesorCaptador',$aux1[$i]['nombre'])
                                        ->whereBetween('fechaCreacion', [$fechaI,$fechaF])
                                        ->get();
            $negociacionesFinalizadas=Negociacion::where('estatus',10)
                                        ->where('asesorCaptador',$aux1[$i]['nombre'])
                                        ->whereBetween('fechaCreacion', [$fechaI,$fechaF])
                                        ->get();

            $aux2[]=Negociacion::join('estatus','negociaciones.estatus','estatus.id')
                                        ->join('propiedades','negociaciones.propiedad_id','propiedades.id')
                                        ->where('asesorCaptador',$aux1[$i]['nombre'])
                                        ->whereBetween('fechaCreacion', [$fechaI,$fechaF])
                                        ->select('negociaciones.*','estatus.descripcionEstatus as nombreEstatus','propiedades.agente_id as agente','propiedades.id_mls as mls')
                                        ->get();

            $valores4=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where([['negociaciones.asesorCaptador','<>',$aux1[$i]['nombre']],['negociaciones.asesorCerrador',$aux1[$i]['nombre']]])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as cerradas'))
                                                    ->first();

            $valores5=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where([['negociaciones.asesorCaptador',$aux1[$i]['nombre']],['negociaciones.asesorCerrador','<>',$aux1[$i]['nombre']]])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as captadas'))
                                                    ->first();

            $valores6=Negociacion::join('negociacion_estatus','negociaciones.id','negociacion_estatus.negociacion_id')
                                                    ->where('negociacion_estatus.comisionPagada',1)
                                                    ->where([['negociaciones.asesorCaptador',$aux1[$i]['nombre']],['negociaciones.asesorCerrador',$aux1[$i]['nombre']]])
                                                    ->whereBetween('negociacion_estatus.fechaEstatus', [$fechaI,$fechaF])
                                                    ->select(DB::raw('count(*) as CACI'))
                                                    ->first();  

            $aux1[$i]['activas']=count($negociacionesActivas);
            $aux1[$i]['canceladas']=count($negociacionesCanceladas);
            $aux1[$i]['finalizadas']=count($negociacionesFinalizadas);
            $aux1[$i]['cerrador']=$valores4->cerradas;
            $aux1[$i]['captador']=$valores5->captadas;
            $aux1[$i]['ambos']=$valores6->CACI;     
            foreach ($negociacionesActivas as $e => $value) {
                $estatus=NegociacionEstatus::where('negociacion_id',$negociacionesActivas[$e]->id)->orderBy('id','desc')->first();
                if (count($estatus)!=0) {
                    if ($estatus->estatus_id==3) {
                        ++$aux1[$i]['propuesta'];
                    }
                    else if($estatus->estatus_id==4){
                        ++$aux1[$i]['deposito'];
                    }
                    else if($estatus->estatus_id==5){
                        ++$aux1[$i]['promesa'];
                    }
                    else if ($estatus->estatus_id==6) {
                        ++$aux1[$i]['firma'];
                    }
                } 
            }
        }

        //dd($aux2);


        return view('reportes.ReporteGeneralNegociaciones',compact('aux1','aux2','titulo','cantidades'));
    }


}