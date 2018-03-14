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
}
