<?php

namespace App\Http\Controllers\Admin;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use App\Models\Agente;
use App\Models\Propiedad;
use App\Models\Negociacion;
use App\Models\NegociacionEstatus;
use App\Models\Estatus;

class NegociacionController extends Controller{
  public function llenarModalNegociacion(){
    $idInmueble=Request::get('parametro');
    $consulta=Negociacion::where('propiedad_id',$idInmueble)->where('estatus','<>',9)->first();
    if(count($consulta)!=0){
      $comun=(object)["negociacion_id"=>"","estatus_id"=>"","fechaEstatus"=>"","comisionPagada"=>""];
      $propuesta=NegociacionEstatus::where('negociacion_id',$consulta->id)->where('estatus_id',3)->first();
      $deposito=NegociacionEstatus::where('negociacion_id',$consulta->id)->where('estatus_id',4)->first();
      $promesa=NegociacionEstatus::where('negociacion_id',$consulta->id)->where('estatus_id',5)->first();
      $protocolo=NegociacionEstatus::where('negociacion_id',$consulta->id)->where('estatus_id',6)->first();
      $reporte=NegociacionEstatus::where('negociacion_id',$consulta->id)->where('estatus_id',7)->first();
      $propiedad=Propiedad::where('id',$idInmueble)->first();
      $respuesta=1;
      if (count($propuesta)==0) {
        $propuesta=$comun;
      }
      if (count($promesa)==0) {
        $promesa=$comun;
      }
      if (count($protocolo)==0) {
        $protocolo=$comun;
      }
      if (count($deposito)==0) {
        $deposito=$comun;
      }
      if (count($reporte)==0) {
        $reporte=$comun;
      }
      $estatus=Estatus::where('estatus.id','<>',12)
                      ->where('estatus.familia',1)
                      ->where('estatus.id','<>',11)
                      ->get();
      $pago=NegociacionEstatus::where('negociacion_id',$consulta->id)->where('estatus_id',5)->where('comisionPagada',1)->first();
      $promesaPagada=count($pago);
      $valores= [ $respuesta,
                  $propuesta,
                  $deposito,
                  $promesa,
                  $protocolo,
                  $reporte,
                  $consulta,
                  $propiedad,
                  $estatus,
                  $promesaPagada
                ];
      return Response::json($valores);
    }
    else{
      $propiedad=Propiedad::where('id',$idInmueble)->first();
      $listaAsesores=Agente::all();
      $respuesta=2;
      $valores= [ $respuesta,
                  $propiedad,
                  $listaAsesores
                ];
      return Response::json($valores);
    }
  }

  public function guardarNegociacion(){
    $propiedad=Request::get('propiedad');
    $idCaptador=Request::get('asesorCaptador');
    $idCerrador=Request::get('asesorCerrador');
    $nombreCaptador=Agente::where('id',$idCaptador)->first();
    $nombreCerrador=Agente::where('id',$idCerrador)->first();
    $precioFinal=Request::get('montoFinal');
    $porcentajeCaptacion=Request::get('comisionCaptacion');
    $porcentajeCierre=Request::get('comisionCierre');
    $porcentajeCompartido=Request::get('comisionCompartida');
    $personaComparte=Request::get('personaComparte');
    $comisionBruta=$precioFinal*$porcentajeCierre/100;
    $comisionCompartida=$comisionBruta*$porcentajeCompartido/100;
    $pagoCasaNacional=$comisionCompartida*0.10;
    $ingresoNeto= abs($pagoCasaNacional-$comisionCompartida);
    $fechaActual=date('Y-m-d');
    $id=DB::table('negociaciones')->insertGetId([
                 "asesorCaptador"      =>  $nombreCaptador->fullName,
                 "asesorCerrador"      =>  $nombreCerrador->fullName,
                 "precioFinal"         =>  $precioFinal,
                 "porcentajeCaptacion" =>  $porcentajeCaptacion,
                 "porcentajeCierre"    =>  $porcentajeCierre,
                 "porcentajeCompartido"=>  $porcentajeCompartido,
                 "compartidoCon"       =>  $personaComparte,
                 "comisionBruta"       =>  $comisionBruta,
                 "pagoCasaMatriz"      =>  $pagoCasaNacional,
                 "ingresoNeto"         =>  $ingresoNeto,
                 "propiedad_id"        =>  $propiedad,
                 "estatus"             =>  8,
                 "fechaCreacion"       =>  $fechaActual
    ]);
    $respuesta=1;
    return $respuesta;

  }

  public function guardarPaso(){
    $fechaPaso=Request::get('datePropuesta');
    $idNegociacion=Request::get('idNegociacion');
    $consultaFinalizada=Negociacion::where('id',$idNegociacion)->where('estatus',10)->first();
    if (count($consultaFinalizada)==0) {
      $consultaPasoSuperior=NegociacionEstatus::where('negociacion_id',$idNegociacion)->first();
      if (count($consultaPasoSuperior)==0) {
        $nuevoPaso=new NegociacionEstatus;
        $nuevoPaso->negociacion_id=$idNegociacion;
        $nuevoPaso->estatus_id=3;
        $nuevoPaso->fechaEstatus=$fechaPaso;
        $nuevoPaso->save();
        $respuesta=1;
      }
      else {
        $respuesta=2;
      }
    }
    else{
      $respuesta=3;
    }

    return $respuesta;
  }

  public function guardarDeposito(){
    $fechaPaso=Request::get('dateGarantia');
    $idNegociacion=Request::get('idNegociacionGarantia');
    $consultaFinalizada=Negociacion::where('id',$idNegociacion)->where('estatus',10)->first();
    if (count($consultaFinalizada)==0) {
      $consultaPasoSuperior=NegociacionEstatus::where('negociacion_id',$idNegociacion)->where('estatus_id','>',4)->first();
      if (count($consultaPasoSuperior)==0) {
        $nuevoPaso=new NegociacionEstatus;
        $nuevoPaso->negociacion_id=$idNegociacion;
        $nuevoPaso->estatus_id=4;
        $nuevoPaso->fechaEstatus=$fechaPaso;
        $nuevoPaso->save();
        $respuesta=1;
      }
      else {
        $respuesta=2;
      }
    }
    else{
      $respuesta=3;
    }

    return $respuesta;
  }

  public function guardarBilateral(){
    $fechaPaso=Request::get('dateBilateral');
    $idNegociacion=Request::get('idNegociacionBilateral');
    $pagoComision=(int)Request::get('pagoComision');

    $consultaFinalizada=Negociacion::where('id',$idNegociacion)->where('estatus',10)->first();
    if (count($consultaFinalizada)==0) {
      $consultaPasoSuperior=NegociacionEstatus::where('negociacion_id',$idNegociacion)
                                              ->where('estatus_id','>',5)
                                              ->first();
      if (count($consultaPasoSuperior)==0) {

        $nuevoPaso=new NegociacionEstatus;
        $nuevoPaso->negociacion_id=$idNegociacion;
        $nuevoPaso->estatus_id=5;
        $nuevoPaso->fechaEstatus=$fechaPaso;
        $nuevoPaso->comisionPagada=$pagoComision;
        $nuevoPaso->save();
        if ($pagoComision==1) {
          $propiedad=Negociacion::where('id',$idNegociacion)->first();
          Propiedad::where('id',$propiedad->propiedad_id)->update([
                      "estatus"         =>  12
                    ]);
        }
        $valores=[1,$pagoComision];
        $respuesta=$valores;
      }
      else {
        $respuesta=[2];
      }
    }
    else{
      $respuesta=[3];
    }

    return $respuesta;
  }

  public function guardarRegistro(){
    $fechaPaso=Request::get('dateRegistro');
    $idNegociacion=Request::get('idNegociacionRegistro');
    $pagoComision=(int)Request::get('pagoComision');

    $consultaFinalizada=Negociacion::where('id',$idNegociacion)->where('estatus',10)->first();
    if (count($consultaFinalizada)==0) {
        $nuevoPaso=new NegociacionEstatus;
        $nuevoPaso->negociacion_id=$idNegociacion;
        $nuevoPaso->estatus_id=6;
        $nuevoPaso->fechaEstatus=$fechaPaso;
        $nuevoPaso->comisionPagada=$pagoComision;
        $nuevoPaso->save();
        if ($pagoComision==1) {
          $propiedad=Negociacion::where('id',$idNegociacion)->first();
          Propiedad::where('id',$propiedad->propiedad_id)->update([
                      "estatus"         =>  12
                    ]);
        }
        $valores=[1,$pagoComision];
        $respuesta=$valores;
    }
    else{
      $respuesta=[2];
    }
    return $respuesta;
  }

  public function guardarReporte(){
    $fechaPaso=Request::get('dateReporte');
    $idNegociacion=Request::get('idNegociacionReporte');
    $nuevoPaso=new NegociacionEstatus;
    $nuevoPaso->negociacion_id=$idNegociacion;
    $nuevoPaso->estatus_id=7;
    $nuevoPaso->fechaEstatus=$fechaPaso;
    $nuevoPaso->save();
    $propiedad=Negociacion::where('id',$idNegociacion)->first();
    Negociacion::where('propiedad_id',$propiedad->propiedad_id)->update([
                "estatus"         =>  10,
              ]);
    Propiedad::where('id',$propiedad->propiedad_id)->update([
                "estatus"         =>  11,
              ]);
    $respuesta=1;
    return $idNegociacion;
  }

  public function historialNegociaciones(){
    $idpropiedad=Request::get('id');
    $negociaciones=DB::table('negociaciones')
                    ->join('estatus','estatus.id','negociaciones.estatus')
                    ->select('estatus.id as estatusId','estatus.descripcionEstatus as descripcionEstatus','negociaciones.*')
                    ->where('negociaciones.propiedad_id',$idpropiedad)
                    ->orderByRaw('id DESC')
                    ->get();
    $pasosNegociaciones=DB::table('negociacion_estatus')
                          ->join('negociaciones','negociaciones.id','negociacion_estatus.negociacion_id')
                          ->join('estatus','estatus.id','negociacion_estatus.estatus_id')
                          ->select('estatus.descripcionEstatus as descripcionEstatus','negociacion_estatus.*')
                          ->where('negociaciones.propiedad_id',$idpropiedad)
                          ->get();
    return view('.admin.partials.negociaciones',compact('negociaciones','pasosNegociaciones'));
  }

  public function cancelarNegociacion(){
    $respuesta=0;
    $idpropiedad=Request::get('idPropiedad');
    $idNegociacion=Request::get('idNegociacion');
    $consultaFinalizada=Negociacion::where('id',$idNegociacion)->where('estatus',10)->first();
    if (count($consultaFinalizada)!=0) {
      $respuesta=[2];
    }
    else{
      Negociacion::where('id',$idNegociacion)->update([
        "estatus"=>  9
      ]);
      Propiedad::where('id',$idpropiedad)->update([
        "estatus"=>  1
      ]);
      $consultaPago=NegociacionEstatus::where('negociacion_id',$idNegociacion)->where('comisionPagada',1)->first();
      $pago=count($consultaPago);
      $respuesta=[1,$pago];
    }
    return  $respuesta;
  }

}
