<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Models\Propiedad;
use App\Models\Proyecto;
use App\Models\Estado;
use App\Models\Ciudad;
use App\Models\Urbanizacion;
use App\Models\InmuebleProyecto;
use App\Models\MediaProyecto;
use App\Models\TipoInmueble;
use App\Models\Media;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
class WebController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $inmuebles=DB::table('medias')->Join('propiedades','medias.propiedad_id','propiedades.id')
                                   ->join('tipoinmueble','propiedades.tipo_inmueble','tipoinmueble.id')
                                   ->join('ciudades','propiedades.ciudad_id','ciudades.id')
                                   ->select('medias.nombre as nombre_imagen','medias.propiedad_id','medias.id as id_imagen','propiedades.*','ciudades.nombre as nombreCiudad','tipoinmueble.nombre as nombreInmueble')
                                   ->where('medias.vista',1)
                                   ->where('destacado',1)
                                   ->where('propiedades.estatus',1)
                                   ->inRandomOrder()
                                   ->get()
                                   ->take(30);

     $proyectos=DB::table('proyectos')->Join('mediaproyectos','proyectos.id','mediaproyectos.proyecto_id')
                                           ->join('ciudades','proyectos.ciudad_id','ciudades.id')
                                           ->select('mediaproyectos.nombre as nombre_imagen','mediaproyectos.proyecto_id','mediaproyectos.id as id_imagen','proyectos.*','ciudades.nombre as nombre_ciudad')
                                           ->where('mediaproyectos.vista',1)
                                           ->where('destacado',1)
                                           ->inRandomOrder()
                                           ->get()
                                           ->take(3);
      $tipoInmuebles=TipoInmueble::all();
     return view('home',compact('inmuebles','proyectos','tipoInmuebles'));

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function buscador()
    {
      $a=Request::get('propiedad');
      $modeloNegocio=["Venta","Alquiler"];
      $propiedad[]=$a;
      $tipoNegocio[]="Venta";
      $inmuebles=DB::table('medias')->Join('propiedades','medias.propiedad_id','propiedades.id')
                                   ->join('tipoinmueble','propiedades.tipo_inmueble','tipoinmueble.id')
                                   ->join('ciudades','propiedades.ciudad_id','ciudades.id')
                                   ->select('medias.nombre as nombre_imagen','medias.propiedad_id','medias.id as id_imagen','propiedades.*','ciudades.nombre as nombreCiudad','tipoinmueble.nombre as nombreInmueble')
                                   ->where('medias.vista',1)
                                   ->where('destacado',1)
                                   ->where('propiedades.estatus',1)
                                   ->where(['tipo_inmueble'=>$a,'tipoNegocio'=>'Venta'])
                                   ->inRandomOrder()
                                   ->paginate(30);
      $inmuebles->withPath('?type=Venta&propiedad='.$a);
      $tipos=TipoInmueble::all();
      $estados=Estado::join('propiedades','estados.id','propiedades.estado_id')
                      ->select('estados.*')
                      ->whereNotNull('propiedades.estado_id')
                      ->distinct()
                      ->orderBy('estados.nombre','asc')
                      ->get();
      //dd($tipos);
      return view('buscador',compact('proyectos','inmuebles','estados','tipos','propiedad','modeloNegocio','tipoNegocio'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function lista_proyectos()
    {
      $proyectos=DB::table('proyectos')->Join('mediaproyectos','proyectos.id','mediaproyectos.proyecto_id')
                                            ->join('ciudades','proyectos.ciudad_id','ciudades.id')
                                            ->select('mediaproyectos.nombre as nombre_imagen','mediaproyectos.proyecto_id','mediaproyectos.id as id_imagen','proyectos.*','ciudades.nombre as nombre_ciudad')
                                            ->where('mediaproyectos.vista',1)
                                            ->where('destacado',1)
                                            ->paginate(10);
        return view('lista_proyectos',compact('proyectos'));
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function detalle_inmueble($id)
    {
      $contVisita = Propiedad::find($id);
      $contVisita->visitas =$contVisita->visitas+1;
      $contVisita->save();
      $inmueble=DB::table('propiedades')->join('tipoinmueble','propiedades.tipo_inmueble','tipoinmueble.id')
                                         ->join('urbanizaciones','propiedades.urbanizacion','urbanizaciones.id')
                                         ->join('estados','propiedades.estado_id','estados.id')
                                         ->join('ciudades','propiedades.ciudad_id','ciudades.id')
                                         ->select('propiedades.*','urbanizaciones.nombre as nombre_urbanizacion','estados.nombre as nombre_estado','ciudades.nombre as nombre_ciudad','tipoinmueble.nombre as nombre_tipo')
                                         ->where('propiedades.id',$id)
                                         ->first();
      $imagenes=Media::where('propiedad_id',$id)->get();
      $inmuebles=DB::table('medias')->Join('propiedades','medias.propiedad_id','propiedades.id')
                                     ->join('tipoinmueble','propiedades.tipo_inmueble','tipoinmueble.id')
                                     ->join('ciudades','propiedades.ciudad_id','ciudades.id')
                                     ->select('medias.nombre as nombre_imagen','medias.propiedad_id','medias.id as id_imagen','propiedades.*','ciudades.nombre as nombreCiudad','tipoinmueble.nombre as nombreInmueble')
                                     ->where('medias.vista',1)
                                     ->where('propiedades.estatus',1)
                                     ->inRandomOrder()
                                     ->get()
                                     ->take(3);
      //return $destacados;
      return view('detalle_inmueble',compact('inmueble','imagenes','inmuebles'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function detalle_proyecto($id){
      $contVisita = Proyecto::find($id);
      $contVisita->visitas =$contVisita->visitas+1;
      $contVisita->save();
      $proyecto=DB::table('proyectos')->join('estados','proyectos.estado_id','estados.id')
                                      ->join('ciudades','proyectos.ciudad_id','ciudades.id')
                                      ->select('proyectos.*','estados.nombre as nombre_estado','ciudades.nombre as nombre_ciudad')
                                      ->where('proyectos.id',$id)
                                      ->first();

      $imagenes=MediaProyecto::where('proyecto_id',$id)->get();
      $inmueblesProyectos=InmuebleProyecto::join('tipoinmuebleproyectos','inmuebleProyectos.tipoinmueble_id','tipoinmuebleproyectos.id')
                                  ->where('proyecto_id',$id)
                                  ->select('inmuebleproyectos.*','tipoinmuebleproyectos.nombre')
                                  ->get();
      $proyectos=DB::table('proyectos')->Join('mediaproyectos','proyectos.id','mediaproyectos.proyecto_id')
                                            ->join('ciudades','proyectos.ciudad_id','ciudades.id')
                                            ->select('mediaproyectos.nombre as nombre_imagen','mediaproyectos.proyecto_id','mediaproyectos.id as id_imagen','proyectos.*','ciudades.nombre as nombre_ciudad')
                                            ->where('mediaproyectos.vista',1)
                                            ->where('destacado',1)
                                            ->inRandomOrder()
                                            ->get()
                                            ->take(3);
      $inmuebles=DB::table('medias')->Join('propiedades','medias.propiedad_id','propiedades.id')
                                     ->join('tipoinmueble','propiedades.tipo_inmueble','tipoinmueble.id')
                                     ->join('ciudades','propiedades.ciudad_id','ciudades.id')
                                     ->select('medias.nombre as nombre_imagen','medias.propiedad_id','medias.id as id_imagen','propiedades.*','ciudades.nombre as nombreCiudad','tipoinmueble.nombre as nombreInmueble')
                                     ->where('medias.vista',1)
                                     ->where('propiedades.estatus',1)
                                     ->inRandomOrder()
                                     ->get()
                                     ->take(3);
      return view('detalle_proyecto',compact('proyectos','inmuebles','proyecto','imagenes','inmueblesProyectos'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function contacto()
    {
      $proyectos=DB::table('proyectos')->Join('mediaproyectos','proyectos.id','mediaproyectos.proyecto_id')
                                            ->join('ciudades','proyectos.ciudad_id','ciudades.id')
                                            ->select('mediaproyectos.nombre as nombre_imagen','mediaproyectos.proyecto_id','mediaproyectos.id as id_imagen','proyectos.*','ciudades.nombre as nombre_ciudad')
                                            ->where('mediaproyectos.vista',1)
                                            ->where('destacado',1)
                                            ->inRandomOrder()
                                            ->get()
                                            ->take(3);
      $inmuebles=DB::table('medias')->Join('propiedades','medias.propiedad_id','propiedades.id')
                                     ->join('tipoinmueble','propiedades.tipo_inmueble','tipoinmueble.id')
                                     ->join('ciudades','propiedades.ciudad_id','ciudades.id')
                                     ->select('medias.nombre as nombre_imagen','medias.propiedad_id','medias.id as id_imagen','propiedades.*','ciudades.nombre as nombreCiudad','tipoinmueble.nombre as nombreInmueble')
                                     ->where('medias.vista',1)
                                     ->where('propiedades.estatus',1)
                                     ->inRandomOrder()
                                     ->get()
                                     ->take(3);
        return view('contacto',compact('proyectos','inmuebles'));
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function nuestra_historia()
    {
      $proyectos=DB::table('proyectos')->Join('mediaproyectos','proyectos.id','mediaproyectos.proyecto_id')
                                            ->join('ciudades','proyectos.ciudad_id','ciudades.id')
                                            ->select('mediaproyectos.nombre as nombre_imagen','mediaproyectos.proyecto_id','mediaproyectos.id as id_imagen','proyectos.*','ciudades.nombre as nombre_ciudad')
                                            ->where('mediaproyectos.vista',1)
                                            ->where('destacado',1)
                                            ->inRandomOrder()
                                            ->get()
                                            ->take(3);
      $inmuebles=DB::table('medias')->Join('propiedades','medias.propiedad_id','propiedades.id')
                                     ->join('tipoinmueble','propiedades.tipo_inmueble','tipoinmueble.id')
                                     ->join('ciudades','propiedades.ciudad_id','ciudades.id')
                                     ->select('medias.nombre as nombre_imagen','medias.propiedad_id','medias.id as id_imagen','propiedades.*','ciudades.nombre as nombreCiudad','tipoinmueble.nombre as nombreInmueble')
                                     ->where('medias.vista',1)
                                     ->where('propiedades.estatus',1)
                                     ->inRandomOrder()
                                     ->get()
                                     ->take(3);
        return view('nuestra_historia',compact('proyectos','inmuebles'));
    }

    public function enviarCurriculum(){
      $file = Request::file('adjuntarCv');
      $nombres = ucfirst(mb_strtolower(Request::get('nombreInteresado')));
      $apellidos = ucfirst(mb_strtolower(Request::get('apellidoInteresado')));
      $email = mb_strtolower(Request::get('emailInteresado'));
      $telefono =Request::get('phoneInteresado');
      $comentario= ucfirst(mb_strtolower(Request::get('comentario')));
      if($file) {
        $extension = strtolower($file->getClientOriginalExtension());
        $fileRename = uniqid().'.'.$extension;
        $path = "curriculum";
        $file->move($path,$fileRename);
        }
      $ruta=public_path('curriculum/').$fileRename;
      $texto='Se ha comunicado con nosotros un nuevo interesado en pertenecer a nuestro equipo de trabajo, adjunto se encuentra su hoja de vida y a continuación sus datos:';
      //dd($ruta);
      Mail::send('emails.nuevoInteresado',['nombres'=>$nombres,'apellidos'=>$apellidos,'email'=>$email,'telefono'=>$telefono,'comentario'=>$comentario,'texto'=>$texto],function($message)use($ruta){
        $message->to('gerencia@century21caracas.com','Iraida Caballero')
                ->subject('Nuevo Interesado en pertenecer al equipo de trabajo')
                ->attach($ruta);
      });
        File::delete(public_path('curriculum/'.$fileRename));
      $respuesta=1;
      return $respuesta;
    }

    public function nuevoContacto(){
      $nombres = ucfirst(mb_strtolower(Request::get('nombreInteresado')));
      $apellidos = ucfirst(mb_strtolower(Request::get('apellidoInteresado')));
      $email = mb_strtolower(Request::get('emailInteresado'));
      $telefono =Request::get('phoneInteresado');
      $comentario= ucfirst(mb_strtolower(Request::get('comentario')));
      $texto='Un nuevo interesado en nuestros servicios se ha comunicado con nosotros, a continuación sus datos:';
      //dd($ruta);
      Mail::send('emails.nuevoInteresado',['nombres'=>$nombres,'apellidos'=>$apellidos,'email'=>$email,'telefono'=>$telefono,'comentario'=>$comentario,'texto'=>$texto],function($message){
        $message->to('gerencia@century21caracas.com','Iraida Caballero')
                ->subject('Nuevo Contacto!!');
      });
      $respuesta=1;
      return $respuesta;
    }

    public function interesadoPublicar(){
      $ubicacion= Request::get('positionPropiety');
      $nombres = ucfirst(mb_strtolower(Request::get('nombreVendedor')));
      $apellidos = ucfirst(mb_strtolower(Request::get('apellidoVendedor')));
      $email = mb_strtolower(Request::get('emailVendedor'));
      $telefono =Request::get('phoneVendedor');
      $comentario= ucfirst(mb_strtolower(Request::get('comentarioVendedor')));
      $direccion= ucfirst(mb_strtolower(Request::get('direccion')));
      $tipoInmueble= Request::get('tipoInmueble');
      $tipoNegocio= Request::get('tipoNegocio');
      $nombreInmueble=TipoInmueble::find($tipoInmueble);
      $texto='Un nuevo interesado en publicar su inmueble con nosotros se ha comunicado mediante nuestra página web, a continuación sus datos:';
      //dd($ruta);
      Mail::send('emails.nuevoInteresadoVender',['nombres'=>$nombres,'apellidos'=>$apellidos,'email'=>$email,'telefono'=>$telefono,'comentario'=>$comentario,'texto'=>$texto,'ubicacion'=>$ubicacion,'nombreInmueble'=>$nombreInmueble,'tipoNegocio'=>$tipoNegocio,'direccion'=>$direccion],function($message){
        $message->to('gerencia@century21caracas.com','Iraida Caballero')
                ->subject('Nuevo interesado en vender su propiedad!!');
      });
      $respuesta=1;
      return $respuesta;
    }

    public function compradorInteresado(){
      $registro=Request::get('registro');
      $mls=Request::get('mls');
      $nombres = ucfirst(mb_strtolower(Request::get('nombreInteresado')));
      $apellidos = ucfirst(mb_strtolower(Request::get('apellidoInteresado')));
      $email = mb_strtolower(Request::get('emailInteresado'));
      $telefono =Request::get('phoneInteresado');
      $comentario= ucfirst(mb_strtolower(Request::get('comentario')));
      $contVisita = Propiedad::find($registro);
      $contVisita->compradorInteresado = $contVisita->compradorInteresado+1;
      $contVisita->save();
      $correoAsesor=Propiedad::join('agentes','propiedades.agente_id','agentes.id')
                               ->where('propiedades.id',$registro)
                               ->select('agentes.email')
                               ->first();
      $correoAsesor=(string)$correoAsesor->email;
      $texto='Un nuevo interesado en la propiedad id #'.$registro.', código mls #'.$mls.', se ha comunicado con nosotros, a continuación sus datos:';
      //dd($ruta);
      Mail::send('emails.nuevoInteresado',['nombres'=>$nombres,'apellidos'=>$apellidos,'email'=>$email,'telefono'=>$telefono,'comentario'=>$comentario,'texto'=>$texto],function($message)use($registro,$correoAsesor){
        $message->to(['gerencia@century21caracas.com',$correoAsesor])
                ->subject('Nuevo interesado en el inmueble id #'.$registro.'!!');
      });
      $respuesta=1;
      return $respuesta;
    }

    public function compradorInteresadoProyecto(){
      $registro=Request::get('registro');
      $nombres = ucfirst(mb_strtolower(Request::get('nombreInteresado')));
      $apellidos = ucfirst(mb_strtolower(Request::get('apellidoInteresado')));
      $email = mb_strtolower(Request::get('emailInteresado'));
      $telefono =Request::get('phoneInteresado');
      $comentario= ucfirst(mb_strtolower(Request::get('comentario')));
      $contVisita = Proyecto::find($registro);
      $contVisita->compradorInteresado = $contVisita->compradorInteresado+1;
      $contVisita->save();
      $texto='Un nuevo interesado en el proyecto id #'.$registro.' se ha comunicado con nosotros, a continuación sus datos:';
      //dd($ruta);
      Mail::send('emails.nuevoInteresado',['nombres'=>$nombres,'apellidos'=>$apellidos,'email'=>$email,'telefono'=>$telefono,'comentario'=>$comentario,'texto'=>$texto],function($message)use($registro){
        $message->to('gerencia@century21caracas.com','Iraida Caballero')
                ->subject('Nuevo interesado en el proyecto id #'.$registro.'!!');
      });
      $respuesta=1;
      return $respuesta;
    }

    public function listarCiudadesPublico(){
      $estados=Request::get('estado');
      for ($i=0; $i <count($estados) ; $i++) {
        $ciudades[]=Ciudad::where('estado_id',$estados[$i])->orderBy('nombre','asc')->get();
      }
      return compact('ciudades');
    }
    public function listarUrbanizacionesPublico(){
      $ciudades=Request::get('ciudad');
      for ($i=0; $i <count($ciudades) ; $i++) {
        $urbanizaciones[]=Urbanizacion::where('ciudad_id',$ciudades[$i])->orderBy('nombre','asc')->get();
      }
      return compact('urbanizaciones');
    }


    public function buscarInmueblesPublico(){
       $modeloNegocio=["Venta","Alquiler"];
       $arregloTipo=[];
       $arregloTipoNegocio=[];
       $arregloEstados=[];
       $arregloCiudades=[];
       $arregloUrbanizaciones=[];
       $arregloHabitaciones=[];
       $arregloBanos=[];
       $arregloEstacionamientos=[];
       $ciudadPorEstado=(object)[
         "id"=>"",
         "nombre"=>"",
         "estado_id"=>""
       ];
       $urbanizacionPorCiudad=(object)[
         "id"=>"",
         "nombre"=>"",
         "ciudad_id"=>""
       ];
       $codigo=Request::get('codigo');
       $a=Request::get('tipo');
       $b=Request::get('tipoNegocio');
       $c=Request::get('estados');
       $d=Request::get('ciudades');
       $e=Request::get('urbanizaciones');
       $f=Request::get('habitaciones');
       $g=Request::get('banos');
       $h=Request::get('estacionamientos');
    	 $tipoP=explode(",",$a);
    	 $tipoNegocio=explode(",",$b);
    	 $estados=explode(",",$c);
    	 $ciudades=explode(",",$d);
    	 $urbanizaciones=explode(",",$e);
    	 $habitaciones=explode(",",$f);
    	 $banos=explode(",",$g);
       $estacionamientos=explode(",",$h);
    	 $precioMin=Request::get('precioMin');
    	 $precioMax=Request::get('precioMax');

       foreach ($tipoP as $key => $value) {
         if ($tipoP[$key]!='') {
           $arregloTipo[]=(int)$value;
         }
       }
       foreach ($tipoNegocio as $key => $value) {
         if ($tipoNegocio[$key]!='') {
           $arregloTipoNegocio[]=$value;
         }
       }
       foreach ($estados as $key => $value) {
           if ($estados[$key]!='') {
             $arregloEstados[]=(int)$value;
         }
       }
       foreach ($ciudades as $key => $value) {
         if ($ciudades[$key]!='') {
           $arregloCiudades[]=(int)$value;
         }
       }
       foreach ($urbanizaciones as $key => $value) {
         if ($urbanizaciones[$key]!='') {
           $arregloUrbanizaciones[]=(int)$value;
         }
       }
       foreach ($habitaciones as $key => $value) {
         if ($habitaciones[$key]!='') {
           if ($habitaciones[$key]!='4') {
              $arregloHabitaciones[]=(int)$value;
           }
           else{
             $contHabitaciones=(int)$habitaciones[$key];
           }
         }
       }
       foreach ($banos as $key => $value) {
         if ($banos[$key]!='') {
           if ($banos[$key]!='3') {
              $arregloBanos[]=(int)$value;
           }
           else{
             $contBanos=(int)$banos[$key];
           }
         }
       }
       foreach ($estacionamientos as $key => $value) {
         if ($estacionamientos[$key]!='') {
           if ($estacionamientos[$key]!='3') {
              $arregloEstacionamientos[]=(int)$value;
           }
           else{
             $contEstacionamientos=(int)$estacionamientos[$key];
           }
         }
       }


       $inmuebles=Media::Join('propiedades','medias.propiedad_id','propiedades.id')
                                    ->join('tipoinmueble','propiedades.tipo_inmueble','tipoinmueble.id')
                                    ->join('ciudades','propiedades.ciudad_id','ciudades.id')
                                    ->newQuery();
       $inmuebles->select('medias.nombre as nombre_imagen','medias.propiedad_id','medias.id as id_imagen','propiedades.*','ciudades.nombre as nombreCiudad','tipoinmueble.nombre as nombreInmueble');
       $inmuebles->where('medias.vista',1);
       $inmuebles->where('propiedades.estatus',1);
       if ($codigo!='') {
         $inmuebles->where('propiedades.id',$codigo);
       }
       if (count($arregloTipo)!=0) {
         $inmuebles->whereIn('tipo_inmueble',$arregloTipo);
       }
       if (count($arregloTipoNegocio)!=0) {
         $inmuebles->whereIn('tipoNegocio',$arregloTipoNegocio);
       }
       if (count($arregloEstados)!=0) {
         $inmuebles->whereIn('propiedades.estado_id',$arregloEstados);
       }
       if (count($arregloCiudades)!=0) {
         $inmuebles->whereIn('propiedades.ciudad_id',$arregloCiudades);
       }
       if (count($arregloUrbanizaciones)!=0) {
         $inmuebles->whereIn('propiedades.urbanizacion',$arregloUrbanizaciones);
       }
       if (count($arregloHabitaciones)!=0) {
         $inmuebles->whereIn('habitaciones',$arregloHabitaciones);
       }
       if (isset($contHabitaciones)) {
         $inmuebles->where('habitaciones','>=',$contHabitaciones);
       }
       if (count($arregloBanos)!=0) {
         $inmuebles->whereIn('banos',$arregloBanos);
       }
       if (isset($contBanos)) {
         $inmuebles->where('banos','>=',$contBanos);
       }
       if (count($arregloEstacionamientos)!=0) {
         $inmuebles->whereIn('estacionamientos',$arregloEstacionamientos);
       }
       if (isset($contEstacionamientos)) {
         $inmuebles->where('estacionamientos','>=',$contEstacionamientos);
       }
       if ($precioMin!='' && $precioMax!='') {
         $inmuebles->whereBetween('propiedades.precio', [$precioMin,$precioMax]);
       }
       elseif ($precioMax=='' && $precioMin!='') {
         $inmuebles->where('propiedades.precio','>=',$precioMin);
       }
       elseif ($precioMax!='' && $precioMin=='') {
         $inmuebles->where('propiedades.precio','<=',$precioMax);
       }
       $inmuebles=$inmuebles->paginate(30);
       //dd($inmuebles);
       $inmuebles->setPath('?codigo='.$codigo.'&tipo='.$a.'&tipoNegocio='.$b.'&estados='.$c.'&ciudades='.$d.'&urbanizaciones='.$e.'&habitaciones='.$f.'&banos='.$g.'&estacionamientos='.$h.'&precioMin='.$precioMin.'&precioMax='.$precioMax);
       //dd($prueba);
                                    //->select('medias.nombre as nombre_imagen','medias.propiedad_id','medias.id as id_imagen','propiedades.*','ciudades.nombre as nombreCiudad','tipoinmueble.nombre as nombreInmueble')
                                    /*->where('medias.vista',1)
                                    ->where('propiedades.estatus',1)
                                    ->whereIn(['tipo_inmueble'=>[1,2,3],'tipoNegocio'=>['venta']])
                                    //->where(['tipo_inmueble'=>$propiedad,'tipoNegocio'=>'venta'])
                                    //->inRandomOrder()
                                    ->paginate(10);*/

                                    //$inmuebles=Propiedad::whereIn('tipo_inmueble', $tipo)->paginate(10);
                                  // dd($inmuebles);
        $tipos=TipoInmueble::all();
        $estadosLista=Estado::join('propiedades','estados.id','propiedades.estado_id')
                        ->select('estados.*')
                        ->whereNotNull('propiedades.estado_id')
                        ->distinct()
                        ->orderBy('estados.nombre','asc')
                        ->get();
        if(!empty($estados)){
          $ciudadPorEstado=Ciudad::whereIn('estado_id',$estados)->get();
        }
        if(!empty($ciudades)){
          $urbanizacionPorCiudad=Urbanizacion::whereIn('ciudad_id',$ciudades)->get();
        }
        //dd($ciudadPorEstado);
        return view('buscador2',compact('inmuebles','tipos','tipoP','tipoNegocio',"modeloNegocio","estadosLista","estados","ciudadPorEstado","ciudades","urbanizacionPorCiudad","urbanizaciones","habitaciones","banos","estacionamientos","precioMin","precioMax"));
    }
}
