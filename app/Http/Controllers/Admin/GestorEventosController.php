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
//use Carbon\Carbon;

class GestorEventosController extends Controller
{
  function ultimoDia() {
      $mes = date('m');
      $año = date('Y');
      $dia = date("d", mktime(0,0,0, $mes+1, 0, $año));
      return date("d",(mktime(0,0,0,$mes+1,1,$año)-1));
  }

  /** Actual month first day **/
  function primerDia() {
      $mes = date('m');
      $año = date('Y');
      return date('N', mktime(0,0,0, $mes, 1, $año));
  }
  public function traductorDia($clave){
    $dias=['1'=>'Lunes',
           '2'=>'Martes',
           '3'=>'Miércoles',
           '4'=>'Jueves',
           '5'=>'Viernes',
           '6'=>'Sábado',
           '7'=>'Domingo'
          ];
    return $dias[$clave];
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
    public function index(){
      //$month=date("n");
      //$year=date("Y");
      $diaActual=date("j");
      $primerDia=self::primerDia();
      $ultimoDiaMes=self::ultimoDia();
      $mes=self::traductorMes(date('m'));
      $dias=[1=>'Lúnes',
             2=>'Martes',
             3=>'Miércoles',
             4=>'Jueves',
             5=>'Viernes',
             6=>'Sábado',
             7=>'Domingo'
            ];

      return view('.admin.gestor_eventos',$this->cargarSidebar(),compact('dias','mes','primerDia','ultimoDiaMes','diaActual'));
    }
}
