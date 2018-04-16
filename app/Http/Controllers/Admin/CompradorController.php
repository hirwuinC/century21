<?php

namespace App\Http\Controllers\Admin;

//use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comprador;
use App\Models\CompradorPropiedades;
use Illuminate\Support\Facades\Request;

class CompradorController extends Controller
{
    public function listarCompradores(){
      $data=\Request::get('data');
      if ($data) {
        $compradores=Comprador::where('id',$data)->paginate(20);
      }
      else{
        $compradores= Comprador::orderBy('fullNameComprador','asc')->paginate(20);
      }
    return view('admin.lista_compradores',$this->cargarSidebar(),compact('compradores'));
    }

    public function modificarComprador($id){
      $comprador=Comprador::where('id',$id)->first();
      $propiedades=CompradorPropiedades::join('propiedades','compradorPropiedades.propiedad_id','propiedades.id')
                                        ->join('tipoinmueble','propiedades.tipo_inmueble','tipoinmueble.id')
                                        ->join('estados','propiedades.estado_id','estados.id')
                                        ->join('ciudades','propiedades.ciudad_id','ciudades.id')
                                        ->join('urbanizaciones','propiedades.urbanizacion','urbanizaciones.id')
                                        ->where('compradorPropiedades.comprador_id',$id)
                                        ->select('propiedades.*','tipoinmueble.nombre as nombreTipoInmueble','estados.nombre as nombreEstado','ciudades.nombre as nombreCiudad','urbanizaciones.nombre as nombreUrbanizacion')
                                        ->get();
      return view('admin.modificar_comprador',$this->cargarSidebar(),compact('comprador','propiedades'));


    }
    public function actualizarComprador(){
      $respuesta=0;
      $id=Request::get('idComprador');
      $cedula=mb_strtolower(Request::get('cedulaComprador'));
      $nombre=ucwords(mb_strtolower(Request::get('nombreComprador')));
      $email=mb_strtolower(Request::get('correoComprador'));
      $edad=Request::get('edad');
      $sexo=Request::get('sexoComprador');
      $ocupacion=ucfirst(mb_strtolower(Request::get('ocupacion')));
      $grupoFamiliar=Request::get('grupoFamiliar');

      $consulta=Comprador::where('cedula',$cedula)->where('id','<>',$id)->first();
      if (count($consulta)==0) {
        Comprador::where('id',$id)->update([
          "cedula"            =>  $cedula,
          "fullNameComprador" =>  $nombre,
          "email"             =>  $email,
          "edad"              =>  $edad,
          "sexo"              =>  $sexo,
          "ocupacion"         =>  $ocupacion,
          "grupoFamilia"      =>  $grupoFamiliar
        ]);
        $respuesta=1;
      }
      else {
        $respuesta=2;
      }
      return $respuesta;
    }
   	public function searchComprador(){
    	$var =Request::get('data');
    	$result=Comprador::searchComprador($var)->get();
    	return response()->json($result);
    }
}
