<?php

namespace App\Http\Controllers\Admin;
//use Illuminate\Http\Request;
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
use Codedge\Fpdf\Facades\Fpdf;

class InformeController extends Controller{

  public function Header($dia,$mes,$ano){
    // Logo
    Fpdf::Image('images\logo-header.png',10,8,50);
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
  public function pruebaInforme(){
    $dia=date('j');
    $ano=date('Y');
    $mes=self::traductor(date('n'));
    Fpdf::AddPage();
    self::Header($dia,$mes,$ano);
    Fpdf::Ln(30);
    Fpdf::Cell(0,12, utf8_decode('Estimado Sr(a). [Nombre de Vendedor]'));
    Fpdf::Ln();
    Fpdf::MultiCell(0,7,utf8_decode('Me es grato dirigirme a usted en esta oportunidad para informarle las actividades que han ocurrido en relación a la comercialización de su inmueble ubicado en : [direccion], de la urbanización [urbanizacion], en la ciudad de [ciudad] del estado [estado].'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(10);
    Fpdf::Cell(0,7, 'Fecha de inicio de los Contratos de Exclusiva: [Fecha contrato exclusiva]');
    Fpdf::Ln();
    Fpdf::Cell(10);
    Fpdf::Cell(0,7, utf8_decode('Promoción del inmueble'));
    Fpdf::Ln();
    Fpdf::Cell(15);
    Fpdf::MultiCell(0,7,utf8_decode('Colocación de rótulo comercial:[exposición de motivos].'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(15);
    Fpdf::MultiCell(0,7,utf8_decode('Volanteo digital a base de datos del sistema: [exposición de motivos].'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(15);
    Fpdf::MultiCell(0,7,utf8_decode('Se han realizado actividades de canvaseo (búsqueda de potenciales compradores persona a persona) a través de la red de relaciones de la oficina y de Century 21 Venezuela.'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(15);
    Fpdf::MultiCell(0,7,utf8_decode('Publicación en portales de Internet'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(20);
    Fpdf::MultiCell(0,7,utf8_decode('century21.com.ve: [exposición de motivos]'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(20);
    Fpdf::MultiCell(0,7,utf8_decode('century21caracas.com: [exposición de motivos]'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(20);
    Fpdf::MultiCell(0,7,utf8_decode('tuinmueble.com: [exposición de motivos]'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(20);
    Fpdf::MultiCell(0,7,utf8_decode('conlallave.com: [exposición de motivos]'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(15);
    Fpdf::MultiCell(0,7,utf8_decode('Mediante este informe le referimos los datos estadísticos que nos arrojan las páginas web desde el [fecha_inicio] al [fecha_actual]- contabilizando [cantidad_visitas] visitas en [numero_dias] días de gestión'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(15);
    Fpdf::MultiCell(0,7,utf8_decode('Desde su comercialización, su inmueble ha generado los siguientes interesados:'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(20);
    Fpdf::MultiCell(0,7,utf8_decode('[Interesado]'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(15);
    Fpdf::MultiCell(0,7,utf8_decode('A los cuales se les suministró la información a través de nuestras oficinas en caracas, produciéndose finalmente, [cantidad_visitas_físicas] visita de clientes potenciales al mismo, generando el siguiente resultado:'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(20);
    Fpdf::MultiCell(0,7,utf8_decode('Muy caro: [evaluacion]'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(20);
    Fpdf::MultiCell(0,7,utf8_decode('En malas condiciones: [evaluacion]'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(20);
    Fpdf::MultiCell(0,7,utf8_decode('Mal ubicado: [evaluacion]'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(20);
    Fpdf::MultiCell(0,7,utf8_decode('Forma de pago N/A: [evaluacion]'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(20);
    Fpdf::MultiCell(0,7,utf8_decode('En espera: [evaluacion]'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(20);
    Fpdf::MultiCell(0,7,utf8_decode('Quiero volver a visitar: [evaluacion]'),0,'J',false);
    Fpdf::Ln(1);
    Fpdf::Cell(20);
    Fpdf::MultiCell(0,7,utf8_decode('Otro: [evaluacion]'),0,'J',false);
    Fpdf::Output();
    exit;
  }

}
