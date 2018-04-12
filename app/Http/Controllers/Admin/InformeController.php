<?php

namespace App\Http\Controllers\Admin;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\Estado;
use App\Models\Ciudad;
use App\Models\TipoInmueble;
use App\Models\Agente;
use App\Models\Propiedad;
use App\Models\Negociacion;
use App\Models\Media;
use App\Models\Informe;
use App\Models\NegociacionEstatus;
use Codedge\Fpdf\Facades\Fpdf;

class InformeController extends Controller{

  public function Header($dia,$mes,$ano){
    // Logo
    Fpdf::Image('images/logo-header.png',10,8,50);
    // Arial bold 15
    Fpdf::SetFont('Arial','B',12);
    // Movernos a la derecha
    Fpdf::Cell(80);
    // Título
    Fpdf::Cell(30,80,utf8_decode('Informe de Gestión de Inmueble'),0,0,'C');
    // Movernos a la derecha
    Fpdf::Cell(10);
    Fpdf::Cell(30,60,'Caracas, '.$dia.' de '.$mes.' de '.$ano,0,0,'D');
    // Salto de línea
    Fpdf::Ln(20);
  }
  public function traductor($mes){
    $meses=['1'=>'Enero',
            '2'=>'Febrero',
            '3'=>'Marzo',
            '4'=>'Abril',
            '5'=>'Mayo',
            '6'=>'Junio',
            '7'=>'Julio',
            '8'=>'Agosto',
            '9'=>'Septiembre',
            '10'=>'Octubre',
            '11'=>'Noviembre',
            '12'=>'Diciembre'
            ];
      return $meses[$mes];
  }
  public function informe($id){
    $consulta=Informe::where('id',$id)->first();
    $propiedad=Propiedad::join('estados','propiedades.estado_id','estados.id')
                        ->join('ciudades','propiedades.ciudad_id','ciudades.id')
                        ->join('agentes','propiedades.agente_id','agentes.id')
                        ->join('urbanizaciones','propiedades.urbanizacion','urbanizaciones.id')
                        ->where('propiedades.id',$consulta->propiedad_id)
                        ->select('propiedades.*','estados.nombre as nombreEstado','ciudades.nombre as nombreCiudad','agentes.fullname','urbanizaciones.nombre as nombreUrbanizacion')
                        ->first();
    $datetime1 = date_create($propiedad->fechaCreado);
    $datetime2 = date_create();
    $diaTranscurrido= date_diff($datetime1, $datetime2);
    $dia=date("j", strtotime($propiedad->fechaCreado));
    $ano=date("Y", strtotime($propiedad->fechaCreado));
    $mes=self::traductor(date("n", strtotime($propiedad->fechaCreado)));
    Fpdf::SetTextColor(78,84,82);
    Fpdf::AddPage();
    self::Header($dia,$mes,$ano);
    Fpdf::Ln(30);
    Fpdf::Cell(0,12, utf8_decode('Estimado Sr(a).'.$consulta->nombre_cliente));
    Fpdf::Ln();
    Fpdf::MultiCell(0,7,utf8_decode("Me es grato dirigirme a usted en esta oportunidad para informarle las actividades que han ocurrido en relación a la comercialización de su inmueble ubicado en : ".$propiedad->direccion.", de la urbanización ".$propiedad->nombreUrbanizacion.", en la ciudad de " .$propiedad->nombreCiudad. " del estado ".$propiedad->nombreEstado."."),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(10);
    Fpdf::Cell(0,7, "Fecha de inicio de los Contratos de Exclusiva: ".date("d-m-Y", strtotime($consulta->fechaExclusiva)));
    Fpdf::Ln();
    Fpdf::Cell(10);
    Fpdf::Cell(0,7, utf8_decode('Promoción del inmueble'));
    Fpdf::Ln();
    Fpdf::Cell(15);
    Fpdf::MultiCell(0,7,utf8_decode('Colocación de rótulo comercial: '.$consulta->promocionRotulo.'.'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(15);
    Fpdf::MultiCell(0,7,utf8_decode('Volanteo digital a base de datos del sistema: '.$consulta->promocionVolanteo.'.'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(15);
    Fpdf::MultiCell(0,7,utf8_decode('Se han realizado actividades de canvaseo (búsqueda de potenciales compradores persona a persona) a través de la red de relaciones de la oficina y de Century 21 Venezuela.'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(15);
    Fpdf::MultiCell(0,7,utf8_decode('Publicación en portales de Internet'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(20);
    Fpdf::MultiCell(0,7,utf8_decode('century21.com.ve código: '.$consulta->publicacionVenezuela.'.'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(20);
    Fpdf::MultiCell(0,7,utf8_decode('century21caracas.com código: '.$consulta->publicacionCaracas.'.'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(20);
    Fpdf::MultiCell(0,7,utf8_decode('tuinmueble.com código: '.$consulta->publicacionTuInmueble.'.'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(20);
    Fpdf::MultiCell(0,7,utf8_decode('conlallave.com código: '.$consulta->publicacionLlave.'.'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(15);
    Fpdf::MultiCell(0,7,utf8_decode('Mediante este informe le referimos los datos estadísticos que nos arrojan las páginas web desde el '.date("d-m-Y", strtotime($propiedad->fechaCreado)).' al '.date("d-m-Y").' contabilizando '.$consulta->visitasDigitalesTotales.' visitas en '.$diaTranscurrido->format('%a').' días de gestión'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(15);
    Fpdf::MultiCell(0,7,utf8_decode('La exposición del inmueble desde la ultima comunicación a generado '.$consulta->cantidadCompradoresInteresados.' nuevos compradores interesados.'),0,'J',false);
    if ($consulta->existeCompradores!=0) {
      Fpdf::Ln(1);
      Fpdf::Cell(15);
      Fpdf::MultiCell(0,7,utf8_decode('A continuación se presenta una lista de las ultimas personas interesadas en su inmueble:'),0,'J',false);
      Fpdf::Ln(1);
      Fpdf::Cell(20);
      Fpdf::MultiCell(0,7,utf8_decode($consulta->primerInteresado),0,'J',false);
      if ($consulta->segundoInteresado!='') {
        Fpdf::Ln(1);
        Fpdf::Cell(20);
        Fpdf::MultiCell(0,7,utf8_decode($consulta->segundoInteresado),0,'J',false);
      }
      if ($consulta->tercerInteresado!='') {
        Fpdf::Ln(1);
        Fpdf::Cell(20);
        Fpdf::MultiCell(0,7,utf8_decode($consulta->tercerInteresado),0,'J',false);
      }
      if ($consulta->cuartoInteresado!='') {
        Fpdf::Ln(1);
        Fpdf::Cell(20);
        Fpdf::MultiCell(0,7,utf8_decode($consulta->cuartoInteresado),0,'J',false);
      }
      if ($consulta->quintoInteresado!='') {
        Fpdf::Ln(1);
        Fpdf::Cell(20);
        Fpdf::MultiCell(0,7,utf8_decode($consulta->quintoInteresado),0,'J',false);
      }
      Fpdf::Ln(1);
      Fpdf::Cell(15);
      Fpdf::MultiCell(0,7,utf8_decode('A los cuales se les suministró la información a través de nuestras oficinas en caracas, produciéndose finalmente, '.$consulta->cantidadVisitasFisicas.' visitas de clientes potenciales al mismo, generando el siguiente resultado:'),0,'J',false);
      Fpdf::Ln(1);
      Fpdf::Cell(20);
      Fpdf::MultiCell(0,7,utf8_decode('Muy caro: '.$consulta->evaluacionCaro),0,'J',false);
      Fpdf::Ln(1);
      Fpdf::Cell(20);
      Fpdf::MultiCell(0,7,utf8_decode('En malas condiciones: '.$consulta->evaluacionMalaCondicion),0,'J',false);
      Fpdf::Ln(1);
      Fpdf::Cell(20);
      Fpdf::MultiCell(0,7,utf8_decode('Mal ubicado: '.$consulta->evaluacionMalUbicado),0,'J',false);
      Fpdf::Ln(1);
      Fpdf::Cell(20);
      Fpdf::MultiCell(0,7,utf8_decode('Forma de pago N/A: '.$consulta->evaluacionFormaPago),0,'J',false);
      Fpdf::Ln(1);
      Fpdf::Cell(20);
      Fpdf::MultiCell(0,7,utf8_decode('En espera: '.$consulta->evaluacionEnEspera),0,'J',false);
      Fpdf::Ln(1);
      Fpdf::Cell(20);
      Fpdf::MultiCell(0,7,utf8_decode('Quiero volver a visitar: '.$consulta->evaluacionVolverVisita),0,'J',false);
      Fpdf::Ln(1);
      Fpdf::Cell(20);
      Fpdf::MultiCell(0,7,utf8_decode('Otro: '.$consulta->evaluacionOtro),0,'J',false);
    }
    Fpdf::Ln();
    Fpdf::Cell(10);
    Fpdf::Cell(0,7, utf8_decode('Observaciones:'));
    Fpdf::Ln();
    Fpdf::Cell(15);
    Fpdf::MultiCell(0,7,utf8_decode($consulta->observaciones),0,'J',false);
    Fpdf::Ln();
    Fpdf::Cell(10);
    Fpdf::Cell(0,7, utf8_decode('Recomendaciones:'));
    Fpdf::Ln();
    Fpdf::Cell(15);
    Fpdf::MultiCell(0,7,utf8_decode($consulta->recomendaciones),0,'J',false);
    Fpdf::Ln();
    Fpdf::MultiCell(0,7,utf8_decode('Espero que esta información pueda ser de su utilidad y consideración y que contribuya al logro de los objetivos que nos hemos propuesto.'),0,'J',false);
    Fpdf::Ln();
    Fpdf::MultiCell(0,7,utf8_decode('Sin otro particular al que referirme, quedo de Ud. muy atentamente,'),0,'J',false);
    Fpdf::Ln();
    Fpdf::MultiCell(0,7,utf8_decode('Por Inmobiliaria CENTURY 21 INMUEBLES CARACAS'),0,'J',false);
    Fpdf::Ln();
    Fpdf::MultiCell(0,7,utf8_decode($propiedad->fullname),0,'C',false);
    Fpdf::Ln();
    Fpdf::MultiCell(0,0,utf8_decode('Asesor Inmobiliario'),0,'C',false);
    Fpdf::Output('F',storage_path('app/public/informes').'/InformeCliente'.$id.'.pdf');
  }

  public function nuevoInforme(){
    $inmuebleId=Request::get('propiedad');
    $informe=Informe::where('propiedad_id',$inmuebleId)->orderBy('id', 'desc')->first();
    if (count($informe)==0) {
      $informe=(object)[
        'nombre_cliente'=>'',
        'correoCliente'=>'',
        'fechaExclusiva'=>'',
        'promocionRotulo'=>'',
        'promocionVolanteo'=>'',
        'publicacionVenezuela'=>'',
        'publicacionCaracas'=>'',
        'publicacionTuInmueble'=>'',
        'publicacionLlave'=>'',
        'visitasDigitalesTotales'=>'',
        'existeCompradores'=>'',
        'cantidadCompradoresInteresados'=>'',
        'primerInteresado'=>'',
        'segundoInteresado'=>'',
        'tercerInteresado'=>'',
        'cuartoInteresado'=>'',
        'quintoInteresado'=>'',
        'existeVisitasFisicas'=>'',
        'cantidadVisitasFisicas'=>'',
        'evaluacionCaro'=>'',
        'evaluacionMalaCondicion'=>'',
        'evaluacionMalUbicado'=>'',
        'evaluacionFormaPago'=>'',
        'evaluacionEnEspera'=>'',
        'evaluacionVolverVisita'=>'',
        'evaluacionOtro'=>'',
        'observaciones'=>'',
        'recomendaciones'=>'',
        'propiedad_id'=>'',
        'estatusEnviado'=>'',
        'fechaCreado'=>'',
        'fechaEnviado'=>''
      ];
      $valores=[1,$informe];
    }
    else{
      if ($informe->estatusEnviado==0) {
        $valores=[2];
      }
      else{
        $valores=[3,$informe];
      }
    }
    return Response::json($valores);
  }
  public function guardarInforme(){
    $nombreCliente                      = ucwords(mb_strtolower(Request::get('nombreCliente')));
    $correoCliente                      = mb_strtolower(Request::get('correoCliente'));
    $fechaExclusiva                     = Request::get('contratoExclusiva');
    $promocionRotulo                    = ucfirst(mb_strtolower(Request::get('rotuloComercial')));
    $promocionVolanteo                  = ucfirst(mb_strtolower(Request::get('volanteoDigital')));
    $publicacionVenezuela               = ucfirst(mb_strtolower(Request::get('codigoVenezuela')));
    $publicacionCaracas                 = ucfirst(mb_strtolower(Request::get('codigoCaracas')));
    $publicacionTuInmueble              = ucfirst(mb_strtolower(Request::get('codigoTuInmueble')));
    $publicacionLlave                   = ucfirst(mb_strtolower(Request::get('codigoConLaLlave')));
    $visitasDigitalesTotales            = Request::get('visitasDigitales');
    $existeCompradores                  = Request::get('compradorInteresado');
    $cantidadCompradoresInteresados     = Request::get('cantidadCInteresados');
    $primerInteresado                   = ucwords(mb_strtolower(Request::get('interesado1')));
    $segundoInteresado                  = ucwords(mb_strtolower(Request::get('interesado2')));
    $tercerInteresado                   = ucwords(mb_strtolower(Request::get('interesado3')));
    $cuartoInteresado                   = ucwords(mb_strtolower(Request::get('interesado4')));
    $quintoInteresado                   = ucwords(mb_strtolower(Request::get('interesado5')));
    $existeVisitasFisicas               = Request::get('visitasFisicas');
    $cantidadVisitasFisicas             = Request::get('cantidadVisitasFisicas');
    $evaluacionCaro                     = Request::get('caro');
    $evaluacionMalaCondicion            = Request::get('malasCondiciones');
    $evaluacionMalUbicado               = Request::get('malUbicado');
    $evaluacionFormaPago                = Request::get('formaPago');
    $evaluacionEnEspera                 = Request::get('enEspera');
    $evaluacionVolverVisita             = Request::get('volverVisitar');
    $evaluacionOtro                     = Request::get('otro');
    $observaciones                      = ucfirst(mb_strtolower(Request::get('observacion')));
    $recomendaciones                    = ucfirst(mb_strtolower(Request::get('recomendacion')));
    $propiedad_id                       = Request::get('idPropietyModal');


    $nuevoInforme = new Informe;
    $nuevoInforme->nombre_cliente                     =$nombreCliente;
    $nuevoInforme->correoCliente                      =$correoCliente;
    $nuevoInforme->fechaExclusiva                     =$fechaExclusiva;
    $nuevoInforme->promocionRotulo                    =$promocionRotulo;
    $nuevoInforme->promocionVolanteo                  =$promocionVolanteo;
    $nuevoInforme->publicacionVenezuela               =$publicacionVenezuela;
    $nuevoInforme->publicacionCaracas                 =$publicacionCaracas;
    $nuevoInforme->publicacionTuInmueble              =$publicacionTuInmueble;
    $nuevoInforme->publicacionLlave                   =$publicacionLlave;
    $nuevoInforme->visitasDigitalesTotales            =$visitasDigitalesTotales;
    $nuevoInforme->existeCompradores                  =$existeCompradores;
    if ($existeCompradores!=0) {
      $nuevoInforme->cantidadCompradoresInteresados   =$cantidadCompradoresInteresados;
    }
    $nuevoInforme->primerInteresado                   =$primerInteresado;
    $nuevoInforme->segundoInteresado                  =$segundoInteresado;
    $nuevoInforme->tercerInteresado                   =$tercerInteresado;
    $nuevoInforme->cuartoInteresado                   =$cuartoInteresado;
    $nuevoInforme->quintoInteresado                   =$quintoInteresado;
    $nuevoInforme->existeVisitasFisicas               =$existeVisitasFisicas;
    if ($existeVisitasFisicas!=0) {
      $nuevoInforme->cantidadVisitasFisicas           =$cantidadVisitasFisicas;
    }
    if ($evaluacionCaro!='') {
      $nuevoInforme->evaluacionCaro                   =$evaluacionCaro;
    }
    if ($evaluacionMalaCondicion!='') {
      $nuevoInforme->evaluacionMalaCondicion          =$evaluacionMalaCondicion;
    }
    if ($evaluacionMalUbicado!='') {
      $nuevoInforme->evaluacionMalUbicado             =$evaluacionCaro;
    }
    if($evaluacionFormaPago!=''){
      $nuevoInforme->evaluacionFormaPago              =$evaluacionFormaPago;
    }
    if($evaluacionEnEspera!=''){
      $nuevoInforme->evaluacionEnEspera               =$evaluacionEnEspera;
    }
    if($evaluacionVolverVisita!=''){
      $nuevoInforme->evaluacionVolverVisita           =$evaluacionVolverVisita;
    }
    if ($evaluacionOtro!='') {
      $nuevoInforme->evaluacionOtro                   =$evaluacionOtro;
    }
    $nuevoInforme->observaciones                      =$observaciones;
    $nuevoInforme->recomendaciones                    =$recomendaciones;
    $nuevoInforme->propiedad_id                       =$propiedad_id;
    $nuevoInforme->fechaCreado                        = date('Y-m-d');
    $nuevoInforme->save();
    $respuesta=1;
    return Response::json($respuesta);
  }

  public function previewInforme($id){
    $idInforme=$id;
    $consulta=Informe::where('id',$idInforme)->first();
    $propiedad=Propiedad::join('estados','propiedades.estado_id','estados.id')
                        ->join('ciudades','propiedades.ciudad_id','ciudades.id')
                        ->join('urbanizaciones','propiedades.urbanizacion','urbanizaciones.id')
                        ->join('agentes','propiedades.agente_id','agentes.id')
                        ->where('propiedades.id',$consulta->propiedad_id)
                        ->select('propiedades.*','estados.nombre as nombreEstado','ciudades.nombre as nombreCiudad','agentes.fullname','urbanizaciones.nombre as nombreUrbanizacion')
                        ->first();
    $datetime1 = date_create($propiedad->fechaCreado);
    $datetime2 = date_create();
    $diaTranscurrido= date_diff($datetime1, $datetime2);
    $dia=date("j", strtotime($propiedad->fechaCreado));
    $ano=date("Y", strtotime($propiedad->fechaCreado));
    $mes=self::traductor(date("n", strtotime($propiedad->fechaCreado)));
    Fpdf::SetTextColor(78,84,82);
    Fpdf::AddPage();
    self::Header($dia,$mes,$ano);
    Fpdf::Ln(30);
    Fpdf::Cell(0,12, utf8_decode('Estimado Sr(a).'.$consulta->nombre_cliente));
    Fpdf::Ln();
    Fpdf::MultiCell(0,7,utf8_decode("Me es grato dirigirme a usted en esta oportunidad para informarle las actividades que han ocurrido en relación a la comercialización de su inmueble ubicado en : ".$propiedad->direccion.", de la urbanización ".$propiedad->nombreUrbanizacion.", en la ciudad de " .$propiedad->nombreCiudad. " del estado ".$propiedad->nombreEstado."."),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(10);
    Fpdf::Cell(0,7, "Fecha de inicio de los Contratos de Exclusiva: ".date("d-m-Y", strtotime($consulta->fechaExclusiva)));
    Fpdf::Ln();
    Fpdf::Cell(10);
    Fpdf::Cell(0,7, utf8_decode('Promoción del inmueble'));
    Fpdf::Ln();
    Fpdf::Cell(15);
    Fpdf::MultiCell(0,7,utf8_decode('Colocación de rótulo comercial: '.$consulta->promocionRotulo.'.'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(15);
    Fpdf::MultiCell(0,7,utf8_decode('Volanteo digital a base de datos del sistema: '.$consulta->promocionVolanteo.'.'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(15);
    Fpdf::MultiCell(0,7,utf8_decode('Se han realizado actividades de canvaseo (búsqueda de potenciales compradores persona a persona) a través de la red de relaciones de la oficina y de Century 21 Venezuela.'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(15);
    Fpdf::MultiCell(0,7,utf8_decode('Publicación en portales de Internet'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(20);
    Fpdf::MultiCell(0,7,utf8_decode('century21.com.ve código: '.$consulta->publicacionVenezuela.'.'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(20);
    Fpdf::MultiCell(0,7,utf8_decode('century21caracas.com código: '.$consulta->publicacionCaracas.'.'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(20);
    Fpdf::MultiCell(0,7,utf8_decode('tuinmueble.com código: '.$consulta->publicacionTuInmueble.'.'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(20);
    Fpdf::MultiCell(0,7,utf8_decode('conlallave.com código: '.$consulta->publicacionLlave.'.'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(15);
    Fpdf::MultiCell(0,7,utf8_decode('Mediante este informe le referimos los datos estadísticos que nos arrojan las páginas web desde el '.date("d-m-Y", strtotime($propiedad->fechaCreado)).' al '.date("d-m-Y").' contabilizando '.$consulta->visitasDigitalesTotales.' visitas en '.$diaTranscurrido->format('%a').' días de gestión.'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(15);
    Fpdf::MultiCell(0,7,utf8_decode('La exposición del inmueble desde la ultima comunicación a generado '.$consulta->cantidadCompradoresInteresados.' nuevos compradores interesados.'),0,'J',false);
    if ($consulta->existeCompradores!=0) {
      Fpdf::Ln(1);
      Fpdf::Cell(15);
      Fpdf::MultiCell(0,7,utf8_decode('A continuación se presenta una lista de las ultimas personas interesadas en su inmueble:'),0,'J',false);
      Fpdf::Ln(1);
      Fpdf::Cell(20);
      Fpdf::MultiCell(0,7,utf8_decode($consulta->primerInteresado),0,'J',false);
      if ($consulta->segundoInteresado!='') {
        Fpdf::Ln(1);
        Fpdf::Cell(20);
        Fpdf::MultiCell(0,7,utf8_decode($consulta->segundoInteresado),0,'J',false);
      }
      if ($consulta->tercerInteresado!='') {
        Fpdf::Ln(1);
        Fpdf::Cell(20);
        Fpdf::MultiCell(0,7,utf8_decode($consulta->tercerInteresado),0,'J',false);
      }
      if ($consulta->cuartoInteresado!='') {
        Fpdf::Ln(1);
        Fpdf::Cell(20);
        Fpdf::MultiCell(0,7,utf8_decode($consulta->cuartoInteresado),0,'J',false);
      }
      if ($consulta->quintoInteresado!='') {
        Fpdf::Ln(1);
        Fpdf::Cell(20);
        Fpdf::MultiCell(0,7,utf8_decode($consulta->quintoInteresado),0,'J',false);
      }
      Fpdf::Ln(1);
      Fpdf::Cell(15);
      Fpdf::MultiCell(0,7,utf8_decode('A los cuales se les suministró la información a través de nuestras oficinas en caracas, produciéndose finalmente, '.$consulta->cantidadVisitasFisicas.' visitas de clientes potenciales al mismo, generando el siguiente resultado:'),0,'J',false);
      Fpdf::Ln(1);
      Fpdf::Cell(20);
      Fpdf::MultiCell(0,7,utf8_decode('Muy caro: '.$consulta->evaluacionCaro),0,'J',false);
      Fpdf::Ln(1);
      Fpdf::Cell(20);
      Fpdf::MultiCell(0,7,utf8_decode('En malas condiciones: '.$consulta->evaluacionMalaCondicion),0,'J',false);
      Fpdf::Ln(1);
      Fpdf::Cell(20);
      Fpdf::MultiCell(0,7,utf8_decode('Mal ubicado: '.$consulta->evaluacionMalUbicado),0,'J',false);
      Fpdf::Ln(1);
      Fpdf::Cell(20);
      Fpdf::MultiCell(0,7,utf8_decode('Forma de pago N/A: '.$consulta->evaluacionFormaPago),0,'J',false);
      Fpdf::Ln(1);
      Fpdf::Cell(20);
      Fpdf::MultiCell(0,7,utf8_decode('En espera: '.$consulta->evaluacionEnEspera),0,'J',false);
      Fpdf::Ln(1);
      Fpdf::Cell(20);
      Fpdf::MultiCell(0,7,utf8_decode('Quiero volver a visitar: '.$consulta->evaluacionVolverVisita),0,'J',false);
      Fpdf::Ln(1);
      Fpdf::Cell(20);
      Fpdf::MultiCell(0,7,utf8_decode('Otro: '.$consulta->evaluacionOtro),0,'J',false);
    }
    Fpdf::Ln();
    Fpdf::Cell(10);
    Fpdf::Cell(0,7, utf8_decode('Observaciones:'));
    Fpdf::Ln();
    Fpdf::Cell(15);
    Fpdf::MultiCell(0,7,utf8_decode($consulta->observaciones),0,'J',false);
    Fpdf::Ln();
    Fpdf::Cell(10);
    Fpdf::Cell(0,7, utf8_decode('Recomendaciones:'));
    Fpdf::Ln();
    Fpdf::Cell(15);
    Fpdf::MultiCell(0,7,utf8_decode($consulta->recomendaciones),0,'J',false);
    Fpdf::Ln();
    Fpdf::MultiCell(0,7,utf8_decode('Espero que esta información pueda ser de su utilidad y consideración y que contribuya al logro de los objetivos que nos hemos propuesto.'),0,'J',false);
    Fpdf::Ln();
    Fpdf::MultiCell(0,7,utf8_decode('Sin otro particular al que referirme, quedo de Ud. muy atentamente,'),0,'J',false);
    Fpdf::Ln();
    Fpdf::MultiCell(0,7,utf8_decode('Por Inmobiliaria CENTURY 21 INMUEBLES CARACAS'),0,'J',false);
    Fpdf::Ln();
    Fpdf::MultiCell(0,7,utf8_decode($propiedad->fullname),0,'C',false);
    Fpdf::Ln();
    Fpdf::MultiCell(0,0,utf8_decode('Asesor Inmobiliario'),0,'C',false);
    Fpdf::Output('I','Informecliente');
    exit;
  }

  public function editarInforme(){
    $idInforme=Request::get('id');
    $informe=Informe::where('id',$idInforme)->first();
    return $informe;
  }

  public function actualizarInforme(){
    $idInforme                          = Request::get('idInformeModal');
    $nombreCliente                      = ucwords(mb_strtolower(Request::get('nombreCliente')));
    $correoCliente                      = mb_strtolower(Request::get('correoCliente'));
    $fechaExclusiva                     = Request::get('contratoExclusiva');
    $promocionRotulo                    = ucfirst(mb_strtolower(Request::get('rotuloComercial')));
    $promocionVolanteo                  = ucfirst(mb_strtolower(Request::get('volanteoDigital')));
    $publicacionVenezuela               = ucfirst(mb_strtolower(Request::get('codigoVenezuela')));
    $publicacionCaracas                 = ucfirst(mb_strtolower(Request::get('codigoCaracas')));
    $publicacionTuInmueble              = ucfirst(mb_strtolower(Request::get('codigoTuInmueble')));
    $publicacionLlave                   = ucfirst(mb_strtolower(Request::get('codigoConLaLlave')));
    $visitasDigitalesTotales            = Request::get('visitasDigitales');
    $existeCompradores                  = Request::get('compradorInteresadoM');
    $cantidadCompradoresInteresados     = Request::get('cantidadCInteresados');
    $primerInteresado                   = ucwords(mb_strtolower(Request::get('interesado1')));
    $segundoInteresado                  = ucwords(mb_strtolower(Request::get('interesado2')));
    $tercerInteresado                   = ucwords(mb_strtolower(Request::get('interesado3')));
    $cuartoInteresado                   = ucwords(mb_strtolower(Request::get('interesado4')));
    $quintoInteresado                   = ucwords(mb_strtolower(Request::get('interesado5')));
    $existeVisitasFisicas               = Request::get('visitasFisicasM');
    $cantidadVisitasFisicas             = Request::get('cantidadVisitasFisicas');
    $evaluacionCaro                     = Request::get('caro');
    $evaluacionMalaCondicion            = Request::get('malasCondiciones');
    $evaluacionMalUbicado               = Request::get('malUbicado');
    $evaluacionFormaPago                = Request::get('formaPago');
    $evaluacionEnEspera                 = Request::get('enEspera');
    $evaluacionVolverVisita             = Request::get('volverVisitar');
    $evaluacionOtro                     = Request::get('otro');
    $observaciones                      = ucfirst(mb_strtolower(Request::get('observacion')));
    $recomendaciones                    = ucfirst(mb_strtolower(Request::get('recomendacion')));
    $propiedad_id                       = Request::get('idPropietyModal');

    $nuevoInforme = Informe::find($idInforme);
    $nuevoInforme->nombre_cliente                     =$nombreCliente;
    $nuevoInforme->correoCliente                      =$correoCliente;
    $nuevoInforme->fechaExclusiva                     =$fechaExclusiva;
    $nuevoInforme->promocionRotulo                    =$promocionRotulo;
    $nuevoInforme->promocionVolanteo                  =$promocionVolanteo;
    $nuevoInforme->publicacionVenezuela               =$publicacionVenezuela;
    $nuevoInforme->publicacionCaracas                 =$publicacionCaracas;
    $nuevoInforme->publicacionTuInmueble              =$publicacionTuInmueble;
    $nuevoInforme->publicacionLlave                   =$publicacionLlave;
    $nuevoInforme->visitasDigitalesTotales            =$visitasDigitalesTotales;
    $nuevoInforme->existeCompradores                  =$existeCompradores;
    if ($existeCompradores==0) {
      $nuevoInforme->cantidadCompradoresInteresados   =0;
    }
    else {
      $nuevoInforme->cantidadCompradoresInteresados   =$cantidadCompradoresInteresados;
    }
    $nuevoInforme->primerInteresado                   =$primerInteresado;
    $nuevoInforme->segundoInteresado                  =$segundoInteresado;
    $nuevoInforme->tercerInteresado                   =$tercerInteresado;
    $nuevoInforme->cuartoInteresado                   =$cuartoInteresado;
    $nuevoInforme->quintoInteresado                   =$quintoInteresado;
    $nuevoInforme->existeVisitasFisicas               =$existeVisitasFisicas;
    if ($existeVisitasFisicas==0) {
      $nuevoInforme->cantidadVisitasFisicas           =0;
    }
    else {
      $nuevoInforme->cantidadVisitasFisicas           =$cantidadVisitasFisicas;
    }
    if ($evaluacionCaro!='') {
      $nuevoInforme->evaluacionCaro                   =$evaluacionCaro;
    }
    else {
      $nuevoInforme->evaluacionCaro                   =0;
    }
    if ($evaluacionMalUbicado!='') {
      $nuevoInforme->evaluacionMalUbicado             =$evaluacionMalUbicado;
    }
    else {
      $nuevoInforme->evaluacionMalUbicado             =0;
    }
    if ($evaluacionMalaCondicion!='') {
      $nuevoInforme->evaluacionMalaCondicion          =$evaluacionMalaCondicion;
    }
    else {
      $nuevoInforme->evaluacionMalaCondicion          =0;
    }
    if($evaluacionFormaPago!=''){
      $nuevoInforme->evaluacionFormaPago              =$evaluacionFormaPago;
    }
    else {
      $nuevoInforme->evaluacionFormaPago              =0;
    }
    if($evaluacionEnEspera!=''){
      $nuevoInforme->evaluacionEnEspera               =$evaluacionEnEspera;
    }
    else {
      $nuevoInforme->evaluacionEnEspera               =0;
    }
    if($evaluacionVolverVisita!=''){
      $nuevoInforme->evaluacionVolverVisita           =$evaluacionVolverVisita;
    }
    else {
      $nuevoInforme->evaluacionVolverVisita           =0;
    }
    if ($evaluacionOtro!='') {
      $nuevoInforme->evaluacionOtro                   =$evaluacionOtro;
    }
    else {
      $nuevoInforme->evaluacionOtro                   =0;
    }
    $nuevoInforme->observaciones                      =$observaciones;
    $nuevoInforme->recomendaciones                    =$recomendaciones;
    $nuevoInforme->propiedad_id                       =$propiedad_id;
    $nuevoInforme->save();
    $respuesta=1;
    return $respuesta;
  }
  public function correo($idInforme,$correoCliente,$nombreCliente){
    $enviado=0;
    $ruta=storage_path('app/public/informes')."/InformeCliente".$idInforme.".pdf";
    Mail::send('emails.informe',['name'=>'Vincen Santaella'],function($message)use($ruta,$correoCliente,$nombreCliente){
      $message->to($correoCliente,$nombreCliente)
              ->subject('Informe de gestión de inmueble')
              ->attach($ruta);
    });
    $enviado=1;
    return $enviado;
  }

  public function enviarCorreo(){
    $idInforme=Request::get('id');
    $informe=Informe::where('id',$idInforme)->first();
    $correo=(string)$informe->correoCliente;
    $nombre=(string)$informe->nombre_Cliente;
    self::informe($idInforme);
    $enviado=self::correo($idInforme,$correo,$nombre);
    $informeEnviado=Informe::find($idInforme);
    $informeEnviado->estatusEnviado=1;
    $informeEnviado->fechaEnviado=date('Y-m-d');
    $informeEnviado->save();
    $propiedad=Propiedad::find($informe->propiedad_id);
    $propiedad->proximoInforme=date('Y-m-d', strtotime('+1 month'));
    $propiedad->save();
    return $enviado;
  }
  public function prueba(){
    $datetime1 = date_create("2018-04-1");
    $datetime2 = date_create();
    $diaTranscurrido= date_diff($datetime1, $datetime2);
    $dia=$diaTranscurrido->format('%R%a días');

  }


}
