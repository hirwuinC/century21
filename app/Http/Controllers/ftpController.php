<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Zipper;
use Excel;
use DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\Estado;
use App\Models\Ciudad;
use App\Models\Urbanizacion;
use App\Models\Agente;
use App\Models\Propiedad;
use App\Models\Media;
use Anchu\Ftp\Facades\FTP;

class ftpController extends Controller
{
   
    /////////////////////////////Metodos de consulta e insercion de registros////////////////////
    public function transformarEstado($nombreEstado)//datos[10]-> nombre de estado
    {
        if($nombreEstado=='DISTRITO FEDERAL')
        {
            $estado=ucwords(mb_strtolower(utf8_encode('DISTRITO CAPITAL')));
        }
        else
        {
            $estado=ucwords(mb_strtolower(utf8_encode($nombreEstado)));
        }

        return $estado;
    }

    public function consultarEstado($nombreEstado)
    {
        $estados=[];
        $estado=Estado::where('nombre',$nombreEstado)->first();
        if($estado==null)
        {
            $estado=new Estado();
                $estado->nombre=$nombreEstado;
            $estado->save();
            
            $estados=['id'=>$estado->id,'nombre'=>$estado->nombre];
           
        }

        return [$estado,$estados];
    }
    public function transformarCiudad($nombreCiudad)
    {

        $ciudad=ucwords(mb_strtolower(utf8_encode($nombreCiudad)));
        return $ciudad;
    }

    public function consultarCiudad($nombreCiudad,$estadoId,$codigoCiudad)
    {
         $ciudades=[];
         $ciudad=Ciudad::where('nombre',$nombreCiudad)->first();
         if($ciudad==null)
         {
            $ciudad=new Ciudad();
                $ciudad->nombre=$nombreCiudad;
                $ciudad->codigo_id=(string)$codigoCiudad;
                $ciudad->estado_id=$estadoId;
            $ciudad->save();
            $ciudades=['id'=>$ciudad->id,'nombre'=>$ciudad->nombre];
         }

         return [$ciudad,$ciudades];
    }

    public function transformarUrbanizacion($nombreUrbanizacion)
    {
            $urbanizacion=ucwords(mb_strtoupper(utf8_encode($nombreUrbanizacion)));
            return $urbanizacion;
    }

    public function consultarUrbanizacion($nombreUrbanizacion,$ciudadId,$codigoUrbanizacion)
    {
        $urbanizaciones=[];
        $urbanizacion=Urbanizacion::where('nombre',$nombreUrbanizacion)->first();
        if($urbanizacion==null)
        {
            $urbanizacion=new Urbanizacion();
                   $urbanizacion->nombre=$nombreUrbanizacion;
                   $urbanizacion->ciudad_id=$ciudadId;
                   $urbanizacion->codigo_id=(string)$codigoUrbanizacion;
            $urbanizacion->save();
            $urbanizaciones=['id'=>$urbanizacion->id,'nombre'=>$urbanizacion->nombre];
        }
        
        return [$urbanizacion,$urbanizaciones];
    }

    public function consultarAsesor($codigoAsesor,$nombreAsesor,$telefonoAsesor,$celularAsesor,$emailAsesor,$inmueblesCaracasId,$oficinaId)
    {
          $asesor=Agente::where('codigo_id',$codigoAsesor)->first();
          $asesores=[];
          if($asesor==null && $oficinaId==$inmueblesCaracasId)
          {
            $asesor=new Agente();
                 $asesor->fullName=ucwords(mb_strtolower(utf8_encode($nombreAsesor)));
                 $asesor->telefono=(string)$telefonoAsesor;
                 $asesor->celular=(string)$celularAsesor;
                 $asesor->email=(string)$emailAsesor;
                 $asesor->codigo_id=(string)$codigoAsesor;
            $asesor->save();
            $asesores=['id'=>$asesor->id,'codigoId'=>$asesor->codigo_id,'nombre'=>$asesor->fullName,'colorFondo'=>null];
          }
          else if($asesor==null && $oficinaId!=$inmueblesCaracasId)
          {
            $asesor=(object)['id'=>5,];
            $asesores=null;
          }

          return ['asesor'=>$asesor,'insercion'=>$asesores];
    }

    public function insertarPropiedad($datos,$nombreAgente,$inmueblesCaracasId)
    {
         $tipoInmueble=[
                            'A'=>1,'B'=>2,'C'=>2,'D'=>3,'E'=>1,'F'=>4,'G'=>1,'H'=>1,
                            'I'=>4,'J'=>4,'L'=>4,'O'=>2,'P'=>2,'Q'=>1,'R'=>3,'S'=>5,
                            'T'=>1,'W'=>5,'X'=>3,'Y'=>4,'Z'=>3
                        ];
        $propiedad=new Propiedad();
            $propiedad->id_mls=(integer)$datos['id_mls'];
            $propiedad->tipo_inmueble=$tipoInmueble[$datos['idTipoInmueble']];
            $propiedad->tipoNegocio=ucwords(mb_strtolower(utf8_encode($datos['tipoNegocio'])));
            $propiedad->urbanizacion=$datos['urbanizacionId'];
            $propiedad->precio=(integer)$datos['precio'];
            $propiedad->habitaciones=number_format((integer)$datos['habitaciones'],2,'.','');
            $propiedad->banos=number_format((integer)$datos['banos'],2,'.','');
            $propiedad->estacionamientos=number_format((integer)$datos['estacionamientos'],2,'.','');
            $propiedad->metros_construccion=number_format((float) $datos['construccion'],2,'.','');
            $propiedad->metros_terreno=number_format((float) $datos['terreno'],2,'.','');
            $propiedad->comentario=utf8_encode($datos['comentario']);
            $propiedad->agente_id=$datos['asesorId'];
            $propiedad->estado_id=$datos['estadoId'];
            $propiedad->ciudad_id=$datos['ciudadId'];
            $propiedad->oficina_id=(integer)$datos['oficina_id'];
            $propiedad->posicionMapa='[{"lat":10.47716930106114,"lng":-66.85339290098875}]';
            $propiedad->fechaCreado=Carbon::now();
            $propiedad->proximoInforme=Carbon::now()->addMonth();
        $propiedad->save();
        if ((string)$datos['oficina_id']!=(string)$inmueblesCaracasId) 
        {
            $agente='Asesor Generico';
            $color='#000000';
        }
        else
        {
            $agente=ucwords(mb_strtolower(utf8_encode($nombreAgente)));
            $color='#DE4009';
        }
        $propiedades=['id'=>$propiedad->id,'mls'=>$propiedad->id_mls,'agente'=>$agente,'colorFondo'=>null,'colorTexto'=>$color];

        return ['propiedad'=>$propiedad,'insercion'=>$propiedades];
    }

    //"C:/Users/Jose Tayupo/Desktop/Descargas/Century21/media.csv"
    public function buscarFotos($codigoMls,$rutaImagenes,$fotoPortada)
    {
         $prefijoImagenes="http://img.century21.com.ve/getmedia.asp?id=";
         $fotos=[$prefijoImagenes.$fotoPortada];//añade al arreglo la foto portada
         if (($imagenes = fopen($rutaImagenes, "r")) !== FALSE) 
         {
                while (($imagen = fgetcsv($imagenes, 1000, ",",'"')) !== FALSE) 
                    {
                                                    
                        if(($imagen[1]==$codigoMls && count($fotos)<8)&&($imagen[0]!=$fotoPortada))
                            {
                                if(count($fotos<8))
                                {
                                    array_push($fotos,$prefijoImagenes.$imagen[0]);
                                }    
                            }

                    }//while imagenes
        }//if imagenes

        return $fotos;
    }

    public function insertarFotos($fotos,$propiedadId)
    {
           for ($j=0; $j < count($fotos); $j++) 
                { 
                    $portada=0;
                    if($j==0)
                        {
                             $portada=1;
                        }

                        $foto=new Media();
                             $foto->nombre=$fotos[$j];
                             $foto->propiedad_id=$propiedadId;
                             $foto->vista=$portada;
                        $foto->save();    
                }

        return 0;

    }

    public function obtenerOficina($oficinaId,$inmueblesCaracasId)
    {
        $oficina_id=$inmueblesCaracasId;
        if ((string)$oficinaId!=$inmueblesCaracasId) 
        {
            $oficina_id=$oficinaId;
        }
        return (string)$oficina_id;
    }

    public function direccionesPropiedad($nombreEstado,$nombreCiudad,$nombreUrbanizacion,$codigoCiudad,$codigoUrbanizacion)
    {
        /////////////Buscar/Insertar Estados //////////////////////////////////////////////////////////////
        $estado=$this->transformarEstado($nombreEstado);
        $resultado=$this->consultarEstado($estado);//array
        $estado=$resultado[0];//objeto
        $estadosInsercion=$resultado[1];//inserciones realizadas
        ////////////Buscar/Insertar Direcciones////////////////////////////////////////////////////////////
        $ciudad=$this->transformarCiudad($nombreCiudad);
        $resultado=$this->consultarCiudad($ciudad,$estado->id,$codigoCiudad);//objeto
        $ciudad=$resultado[0];//objeto
        $ciudadesInsercion=$resultado[1];
        ///////////Buscar/Insertar Urbanizacion////////////////////////////////////////////////////////////
        $urbanizacion=$this->transformarUrbanizacion($nombreUrbanizacion);
        $resultado=$this->consultarUrbanizacion($urbanizacion,$ciudad->id,$codigoUrbanizacion);//objeto
        $urbanizacion=$resultado[0];//objeto
        $urbanizacionesInsercion=$resultado[1];
      
        ///////////////////////////////////////////////////////////////////////////////////////////////////
        $direccion=(object)['estadoId'=>$estado->id,'ciudadId'=>$ciudad->id,'urbanizacionId'=>$urbanizacion->id];
        $inserciones=(object)['estado'=>$estadosInsercion,'ciudad'=>$ciudadesInsercion,'urbanizacion'=>$urbanizacionesInsercion];


        return ['direccion'=>$direccion,'inserciones'=>$inserciones];

    }

    public function contabilizarResultados($arrayGeneral,$arrayInsercion)
    {
        
        $arrayGeneral=$arrayGeneral;
        if (count($arrayInsercion)>0) 
        {
            array_push($arrayGeneral,$arrayInsercion);
        }
        return $arrayGeneral;
    }
    public function cargarColores($array)
    {
        $colores=['#FFFFFF','#F5F3F3'];
        $color=0;
        $registros=[];
        foreach ($array as $registro) 
        {
            $registro['colorFondo']=$colores[$color];
            array_push($registros,$registro);
            if ($color==0) 
            {
                $color=1;
            }
            else
            {
                $color=0;
            }
        }

        return $registros;

    }

    public function borrarArchivos($directorioSin)
    {
        $archivos=[$directorioSin.'/Century21/propiedades.csv',
                   $directorioSin.'/Century21/media.csv',
                   $directorioSin.'/Century21/ciudades.csv',
                   $directorioSin.'/Century21/urbanizaciones.csv',
                   $directorioSin.'/Century21.zip'];
                   
        for ($i=0; $i <count($archivos) ; $i++) 
        { 
            if (file_exists($archivos[$i])) 
            {
                
                unlink($archivos[$i]);
            }
            
        }

           if (file_exists($directorioSin.'/Century21'))
            {
                
                rmdir($directorioSin.'/Century21');
            }

        return 0;
    }

    public function detectarCambios($directorioSin,$inmueblesCaracasId)
    {

        $listaCambios=[];
        
        
        ///traer todas las propiedades que fueron sincroniadas, es decir que tienen codigo mls
        $propiedades=DB::table('propiedades')->select('id_mls as mls','tipoNegocio as negocio','precio as precio','agente_id as agente','oficina_id as oficina')->where('id_mls','<>',0)->get();
        
        if ($propiedades) 
        {
                    
                $archivo=[];//se debe cargar maximo la misma cantidad de propiedades
                 //recorrer archivo
                 if (($gestor = fopen($directorioSin.'/Century21/propiedades.csv', "r")) !== FALSE) 
                 {
                                while (($datos = fgetcsv($gestor, 1000, ",",'"')) !== FALSE) 
                                {
                               
                                     $longitud=count($datos);
                                                                                             
                                     if (($longitud==25||$longitud==26)) //cantidad de campos del registro
                                        {
                                            if (($datos[10]=='VARGAS'||$datos[10]=='MIRANDA'||$datos[10]=='DISTRITO FEDERAL'))
                                                {
                                                    //crear el arreglo
                                                    $archivo[(string)$datos[1]]=['negocio'=>ucwords(mb_strtolower(utf8_encode($datos[3]))),'precio'=>(integer)$datos[4],'agente'=>(string)$datos[24],'oficina'=>ucwords(mb_strtolower(utf8_encode($datos[17]))),'oficina_id'=>(string)$datos[16]];
                                                }
                                        }
                                }
                }
                

                        //recorrer array de propiedades
                foreach ($propiedades as $propiedad) 
                {
                    
                    $aux=[];
                    $clave=array_key_exists($propiedad->mls,$archivo);
                    if ($clave==false) 
                    {
                       $listaCambios[$propiedad->mls]=['Eliminado'=>'No existe en el sistema de casa matriz'];
                    }
                    else if ($clave==true) 
                    {
                        if ($propiedad->negocio!=$archivo[$propiedad->mls]['negocio']) 
                        {
                            $aux['Cambio tipo negocio']='De: '.$propiedad->negocio.' -> '.$archivo[$propiedad->mls]['negocio'];
                        }
                        if ($propiedad->precio!=$archivo[$propiedad->mls]['precio']) 
                        {
                            $aux['Cambio de precio']='De: '.$propiedad->precio.' -> '.$archivo[$propiedad->mls]['precio'];
                        }
                        $agente=DB::table('agentes')->where('id',$propiedad->agente)->first();
                        if ($inmueblesCaracasId==(string)$archivo[$propiedad->mls]['oficina_id']) 
                        {
                           if ($agente->codigo_id!=$archivo[$propiedad->mls]['agente']) 
                           {
                              
                              $aux['Cambio de agente']='De: '.$agente->codigo_id.' -> '.$archivo[$propiedad->mls]['agente'].' - '.$archivo[$propiedad->mls]['oficina'];
                           }
                           
                        }

                        if(count($aux)>0)
                        {
                            $listaCambios[$propiedad->mls]=$aux;
                        }
                    }
                }

        }

        return $listaCambios;
    }

     public function conectarDescargar($ftp_server,$ftp_user, $ftp_password,$local_file, $ftp_file)
    {
        
        
                $retorno=false;
                $ftp_connect=ftp_connect($ftp_server);
                if ($ftp_connect) 
                {
                     $ftp_login=ftp_login($ftp_connect, $ftp_user, $ftp_password);
                     if ($ftp_login) 
                     {
                         ftp_pasv($ftp_connect, true);
                         
                         $ftp_download=ftp_get($ftp_connect, $local_file, $ftp_file, FTP_BINARY);
                         if ($ftp_download) 
                         {
                             $retorno=1;//descarga completa
                             ftp_close($ftp_connect);
                         }
                         else
                          {
                            $retorno=4;//fallo al descargar
                          }
                     }
                     else
                    {
                        $retorno=3;//fallo al loguear
                    }
                    
                }
                else
                {
                    $retorno=2;//Fallo al establecer cpnexion al servidor
                }
           

        
        return $retorno;
    }
    ///////////////////Fin de metodos de insercion y consultas ////////////////////////////////////////////


    public function conectar()
    {
                                  
            
            $ciudades=[];   
            $urbanizaciones=[];
            $estados=[];
            $agentes=[];
            $propiedades=[];
            $cantidadImagenes=0;
            $horaSinc=Carbon::now();
            $modificaciones=[];
            $exception=true;
            ////////////////////////////////////////////////////////////////////////////
            ini_set('max_execution_time',12000 ); //tiempo maximo de ejecucion del script
            

            $directorioSin=storage_path('app/public/sincronizar');
            $ftp_server="216.155.132.149";
            $ftp_user="inmueblescaracas";
            $ftp_password="sdkjsa$$";
            $local_file=$directorioSin.'/Century21.zip';//'C:/Users/Jose Tayupo/Desktop/Descargas/Century21.zip';
            $ftp_file='/FTP-TXT/Century21.zip';
            $ftp_download=false;
            $c=0;

            
            try{
                 $descarga=$this->conectarDescargar($ftp_server,$ftp_user, $ftp_password,$local_file, $ftp_file);
                 if ($descarga==1) 
                 {
                         $exception=false;
                         $extract=Zipper::make($local_file)->extractTo($directorioSin.'/Century21/');
                         $inmueblesCaracasId='23646';
                         $modificaciones=$this->detectarCambios($directorioSin,$inmueblesCaracasId);

                          if (($gestor = fopen($directorioSin.'/Century21/propiedades.csv', "r")) !== FALSE) {
                                while (($datos = fgetcsv($gestor, 1000, ",",'"')) !== FALSE) 
                                {
                                           
                                          
                                          
                                           $longitud=count($datos);
                                         
                                                                                             
                                           if (($longitud==25||$longitud==26)) //cantidad de campos del registro
                                           {
                                                

                                                                                      //filtrar estado
                                                if (($datos[10]=='VARGAS'||$datos[10]=='MIRANDA'||$datos[10]=='DISTRITO FEDERAL')&&($c<50) )
                                                {
                                                   
                                                    
                                                    $c=$c+1;
                                                    ////verificar existencia de la propiedad ///obtener propiedad si esxiste
                                                    $propiedadCon=Propiedad::where('id_mls',(int)$datos[1])->first();
                                                    if ($propiedadCon==null) //SI NO EXISTE LA PROPIEDAD EN EL SISTEMA
                                                    {
                                                       

                                                       //insertamos/consultamos las direcciones
                                                       $aux=$this->direccionesPropiedad($datos[10],$datos[12],$datos[14],$datos[11],$datos[13]);
                                                      ///contabilizar estados
                                                       $estados=$this->contabilizarResultados($estados,$aux['inserciones']->estado);
                                                       //obtener id del estado
                                                       $estadoId=$aux['direccion']->estadoId;

                                                       ///contabilizar ciudades
                                                       $ciudades=$this->contabilizarResultados($ciudades,$aux['inserciones']->ciudad);
                                                       //obtener id de la ciudad
                                                       $ciudadId=$aux['direccion']->ciudadId;
                                                       //contabilizar las urbanizaciones
                                                       $urbanizaciones=$this->contabilizarResultados($urbanizaciones,$aux['inserciones']->urbanizacion);
                                                       //obtener id de la urbanizacion
                                                       $urbanizacionId=$aux['direccion']->urbanizacionId;
                                                       $oficina_id=$this->obtenerOficina($datos[16],$inmueblesCaracasId);
                                                       

                                                       //insertamos/consultamos el asesor
                                                       $aux=$this->consultarAsesor($datos[24],$datos[19],$datos[22],$datos[20],$datos[21],$inmueblesCaracasId,$oficina_id);
                                                    
                                                       if ($aux['insercion']) 
                                                       {
                                                            $agentes=$this->contabilizarResultados($agentes,$aux['insercion']);                                              
                                                       }
                                                      
                                                       $agenteId=$aux['asesor']->id;
                                                       //insertamos/ consultamos propiedad
                                                       
                                                       
                                                       $data=
                                                       [
                                                         'id_mls'=>$datos[1],'idTipoInmueble'=>$datos[0],'tipoNegocio'=>$datos[3],'urbanizacionId'=>$urbanizacionId,
                                                         'precio'=>$datos[4],'habitaciones'=>$datos[5],'banos'=>$datos[6],'estacionamientos'=>$datos[7],
                                                         'construccion'=>$datos[8],'terreno'=>$datos[9],'comentario'=>$datos[15],'asesorId'=>$agenteId,
                                                         'estadoId'=>$estadoId,'ciudadId'=>$ciudadId,'oficina_id'=>$oficina_id
                                                       ];
                                                      $aux=$this->insertarPropiedad($data,$datos[19],$inmueblesCaracasId);
                                                      $propiedadId=$aux['propiedad']->id;
                                                      $propiedadMls=$aux['propiedad']->id_mls;
                                                      $propiedades=$this->contabilizarResultados($propiedades,$aux['insercion']);

                                                    //buscamos e insertamos las imagenes correspondientes a la propiedad cargada

                                                    $fotos=$this->buscarFotos($propiedadMls,$directorioSin.'/Century21/media.csv',$datos[23]);
                                                    $fotosEn=$this->insertarFotos($fotos,$propiedadId);
                                                    $cantidadImagenes=$cantidadImagenes+count($fotos);
                                                
                                               


                                                        
                                                    }//filtro propiedades
                                                                                        
                                                }//filtro por estado
                                           }//filtro longitud
                                           


                                          
                                               
                                            }//fin del while del archivo
                                        }//fin del if del archivo
                                        
                                        

                       }
          
                                       
                                      
                                    
                                  
                             $longitud=[];
                             $longitud['estados']=count($estados);$longitud['ciudades']=count($ciudades);$longitud['urbanizaciones']=count($urbanizaciones);$longitud['agentes']=count($agentes);$longitud['propiedades']=count($propiedades);$longitud['imagenes']=$cantidadImagenes;
                             $agentes=$this->cargarColores($agentes);
                             $propiedades=$this->cargarColores($propiedades);
                             $cambios=array_sum($longitud);
                             $horaFin=Carbon::now();
                             //$this->borrarArchivos($directorioSin); 

                            $correo='josetayupo@gmail.com';
                            Mail::send('emails.informeSincronizacion',['cambios'=>$cambios,'longitud'=>$longitud,'agentes'=>$agentes,'propiedades'=>$propiedades,'tiempoIn'=>$horaSinc->toDateTimeString(),'tiempoFin'=>$horaFin->toDateTimeString(),'modificaciones'=>$modificaciones,'descarga'=>$descarga],function($message)use($correo)
                                 {
                                        $message->to($correo)->subject('Resultados de sincronizacion');
                                });
                       }
                   finally
                      {
                            if ($exception) 
                            {
                                # code...
                                   $horaFin=Carbon::now();
                                    $correo='josetayupo@gmail.com';
                                    Mail::send('emails.informeError',['tiempoIn'=>$horaSinc->toDateTimeString(),'tiempoFin'=>$horaFin->toDateTimeString()],
                                        function($message)use($correo)
                                     {
                                            $message->to($correo)->subject('Sincronizacion Fallida');
                                    });
                            }
                      }
                               
                     
                             
           

            
    }
}
