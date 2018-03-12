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

class NegociacionController extends Controller{
  public function llenarModalNegociacion(){

    $idInmueble=Request::get('parametro');
    /*$negociaciones=DB::table('negociaciones')
                    ->join('estatus','estatus.id','negociaciones.estatus')
                    ->select('estatus.id as estatusId','estatus.descripcionEstatus as descripcionEstatus','negociaciones.*')
                    ->where('negociaciones.propiedad_id',$idInmueble)
                    ->get();
    if (count($negociaciones)==0) {
      $negociaciones=(object)["estatusId"=>"","descripcionEstatus"=>"vincen"];
    }
    $pasosNegociaciones=DB::table('negociacion_estatus')
                          ->join('negociaciones','negociaciones.id','negociacion_estatus.negociacion_id')
                          ->join('estatus','estatus.id','negociacion_estatus.estatus_id')
                          ->where('negociaciones.propiedad_id',$idInmueble)
                          ->get();*/
    $consulta=Negociacion::where('propiedad_id',$idInmueble)->where('estatus',8)->first();
    if(count($consulta)!=0){
      $comun=(object)["negociacion_id"=>"","estatus_id"=>"","fechaEstatus"=>""];
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
      $valores= [ $respuesta,
                  $propuesta,
                  $deposito,
                  $promesa,
                  $protocolo,
                  $reporte,
                  $consulta,
                  $propiedad
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
    $nuevoPaso=new NegociacionEstatus;
    $nuevoPaso->negociacion_id=$idNegociacion;
    $nuevoPaso->estatus_id=3;
    $nuevoPaso->fechaEstatus=$fechaPaso;
    $nuevoPaso->save();
    $respuesta=1;
    return $respuesta;
  }

  public function guardarDeposito(){
    $fechaPaso=Request::get('dateGarantia');
    $idNegociacion=Request::get('idNegociacionGarantia');
    $nuevoPaso=new NegociacionEstatus;
    $nuevoPaso->negociacion_id=$idNegociacion;
    $nuevoPaso->estatus_id=4;
    $nuevoPaso->fechaEstatus=$fechaPaso;
    $nuevoPaso->save();
    $respuesta=1;
    return $respuesta;
  }

  public function guardarBilateral(){
    $fechaPaso=Request::get('dateBilateral');
    $idNegociacion=Request::get('idNegociacionBilateral');
    $nuevoPaso=new NegociacionEstatus;
    $nuevoPaso->negociacion_id=$idNegociacion;
    $nuevoPaso->estatus_id=5;
    $nuevoPaso->fechaEstatus=$fechaPaso;
    $nuevoPaso->save();
    $propiedad=Negociacion::where('id',$idNegociacion)->first();
    Propiedad::where('id',$propiedad->id)->update([
                "estatus"         =>  12,
              ]);
    $respuesta=1;
    return $respuesta;
  }

}
