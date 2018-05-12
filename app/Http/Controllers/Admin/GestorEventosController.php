<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
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
use App\Models\Calendario;


class GestorEventosController extends Controller{
  function ultimoDia($var1,$var2) {
      $mes = $var1;
      $año = $var2;
      return date("d",(mktime(0,0,0,$mes+1,1,$año)-1));
  }

  function primerDia($var1,$var2) {
      $mes = $var1;
      $año = $var2;
      return date('N', mktime(0,0,0, $mes, 1, $año));
  }
  public function traductorMes($clave){
    $meses=['01' =>'Enero',
            '02' =>'Febrero',
            '03' =>'Marzo',
            '04' =>'Abril',
            '05' =>'Mayo',
            '06' =>'Junio',
            '07' =>'Julio',
            '08' =>'Agosto',
            '09' =>'Septiembre',
            '10'=>'Octubre',
            '11'=>'Noviembre',
            '12'=>'Diciembre'
           ];
    return $meses[$clave];
  }
    public function eventoMes($var1,$var2){
      $mes=$var1;
      $año=$var2;
      $arreglo=array();
      $ultimodia=date("d",(mktime(0,0,0,$mes+1,1,$año)-1));
      $fechaInicio=$año.'-'.$mes.'-1';
      $fechaFin=$año.'-'.$mes.'-'.$ultimodia;
      $userall=Session::get('asesor');
      if ($userall->rol_id==1) {
        $consulta=Calendario::whereBetween('fechaAgendado', [$fechaInicio,$fechaFin])->get();
        for ($i=1; $i <=31 ; $i++) {
          $prueba=0;
          foreach ($consulta as $evento) {
            $dia=date("j", strtotime ( $evento->fechaAgendado));
            if ($dia==$i) {
              $arreglo[$i]=++$prueba;
            }
          }
        }
      }
      else{
        $consulta=Calendario::whereBetween('fechaAgendado', [$fechaInicio,$fechaFin])->where('creador',$userall->agente_id)->get();
        for ($i=1; $i <=31 ; $i++) {
          $prueba=0;
          foreach ($consulta as $evento) {
            $dia=date("j", strtotime ( $evento->fechaAgendado));
            if ($dia==$i) {
              $arreglo[$i]=++$prueba;
            }
          }
        }
      }
      return $arreglo;
    }
    public function index(){
      //dd(Session::get('asesor'));
      $month=date("m");
      $year=date("Y");
      $primerDia=self::primerDia(date('m'),date('Y'));
      $ultimoDiaMes=self::ultimoDia(date('m'),date('Y'));
      $mes=self::traductorMes(date('m'));
      $dias=[1=>'Lúnes',
             2=>'Martes',
             3=>'Miércoles',
             4=>'Jueves',
             5=>'Viernes',
             6=>'Sábado',
             7=>'Domingo'
            ];
      $arreglo=self::eventoMes($month,$year);
      return view('.admin.gestor_eventos',$this->cargarSidebar(),compact('dias','mes','primerDia','ultimoDiaMes','year','arreglo'));
    }

    public function proximoMes(){
      $fecha=Request::get('parametro');
      $nuevafecha = strtotime ( '+1  month' , strtotime ( $fecha ));
      $nuevoMes =date('m',$nuevafecha);
      $nuevoAno =date('Y',$nuevafecha);
      $nuevo=date('Y-m-d',$nuevafecha);
      $primerDia=self::primerDia($nuevoMes,$nuevoAno);
      $ultimoDiaMes=self::ultimoDia($nuevoMes,$nuevoAno);
      $mes=self::traductorMes($nuevoMes);
      $dias=[1=>'Lúnes',
             2=>'Martes',
             3=>'Miércoles',
             4=>'Jueves',
             5=>'Viernes',
             6=>'Sábado',
             7=>'Domingo'
            ];
      $arreglo=self::eventoMes($nuevoMes,$nuevoAno);
      return view('.admin.partials.calendario',$this->cargarSidebar(),compact('dias','mes','primerDia','ultimoDiaMes','nuevoAno','nuevo','arreglo'));
    }

    public function mesAnterior(){
      $fecha=Request::get('parametro');
      $nuevafecha = strtotime ( '-1  month' , strtotime ( $fecha ));
      $nuevoMes =date('m',$nuevafecha);
      $nuevoAno =date('Y',$nuevafecha);
      $nuevo=date('Y-m-d',$nuevafecha);
      $primerDia=self::primerDia($nuevoMes,$nuevoAno);
      $ultimoDiaMes=self::ultimoDia($nuevoMes,$nuevoAno);
      $mes=self::traductorMes($nuevoMes);
      $dias=[1=>'Lúnes',
             2=>'Martes',
             3=>'Miércoles',
             4=>'Jueves',
             5=>'Viernes',
             6=>'Sábado',
             7=>'Domingo'
            ];
      $arreglo=self::eventoMes($nuevoMes,$nuevoAno);
      return view('.admin.partials.calendario',$this->cargarSidebar(),compact('dias','mes','primerDia','ultimoDiaMes','nuevoAno','nuevo','arreglo'));
    }

    public function guardarEvento(){
      $evento=ucfirst(mb_strtolower(Request::get('evento')));
      $fechaEvento=Request::get('fechaCompletaModal');
      $userall=Session::get('asesor');
      $nuevoEvento= new Calendario;
      $nuevoEvento->descripcion=$evento;
      $nuevoEvento->fechaAgendado=$fechaEvento;
      $nuevoEvento->creador=$userall->agente_id;
      $nuevoEvento->save();
      $nuevo=date("Y-m-d", strtotime ( $fechaEvento ));
      $nuevoAno=date("Y", strtotime ( $fechaEvento ));
      $month= date( 'm' , strtotime ( $fechaEvento ));
      $primerDia=self::primerDia($month,$nuevoAno);
      $ultimoDiaMes=self::ultimoDia($month,$nuevoAno);
      $mes=self::traductorMes($month);
      $dias=[1=>'Lúnes',
             2=>'Martes',
             3=>'Miércoles',
             4=>'Jueves',
             5=>'Viernes',
             6=>'Sábado',
             7=>'Domingo'
           ];
      $arreglo=self::eventoMes($month,$nuevoAno);
      return view('.admin.partials.calendario',$this->cargarSidebar(),compact('dias','mes','primerDia','ultimoDiaMes','nuevoAno','nuevo','arreglo'));
  }
  public function eventoDia(){
    $dia=Request::get('fechaDia');
    $userall=Session::get('asesor');
    $agente=$userall->agente_id;
    $arreglo =array();
    if ($userall->rol_id==1) {
      $consulta=Calendario::join('agentes','calendario.creador','agentes.id')
                          ->where('fechaAgendado',$dia)
                          ->select('agentes.fullname','calendario.*')
                          ->get();
      foreach ($consulta as $evento ) {
        $arreglo[$evento->fullname][]=$evento;
      }
    }
    else{
      $consulta=Calendario::join('agentes','calendario.creador','agentes.id')
                          ->where('fechaAgendado',$dia)
                          ->where('creador',$userall->agente_id)
                          ->select('agentes.fullname','calendario.*')
                          ->get();
      foreach ($consulta as $evento ) {
        $arreglo[$evento->fullname][]=$evento;
      }
    }
    $asesores=Agente::all();
    return view('.admin.partials.historial_eventos',compact('arreglo','asesores','agente'));
  }
  public function eliminarEvento(){
    $registro=Request::get('registro');
    $consulta=Calendario::find($registro);
    $consulta->delete();
    $respuesta=1;
    return $respuesta;
  }
  public function modificarEvento(){
    $registro=Request::get('registro');
    $texto=Request::get('texto');
    $consulta=Calendario::find($registro);
    $consulta->descripcion=$texto;
    $consulta->save();
    $respuesta=1;
    return $respuesta;
  }
  public function prueba(){
    return view('.admin.partials.historial_eventos');
  }
}
