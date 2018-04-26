<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Zipper;
use Excel;
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

    public function consultarAsesor($codigoAsesor,$nombreAsesor,$telefonoAsesor,$celularAsesor,$emailAsesor)
    {
          $asesor=Agente::where('codigo_id',$codigoAsesor)->first();
          if($asesor==null)
          {
            $asesor=new Asesor();
                 $asesor->fullName=ucwords(mb_strtolower(utf8_encode($nombreAsesor)));
                 $asesor->telefono=(string)$telefonoAsesor;
                 $asesor->celular=(string)$celularAsesor;
                 $asesor->email=(string)$emailAsesor;
                 $asesor->codigo_id=(string)$codigoAsesor;
            $asesor->save();
          }
    }

    public function insertarPropiedad($datos)
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

        return $propiedad;
    }

    //"C:/Users/Jose Tayupo/Desktop/Descargas/Century21/media.csv"
    public function buscarFotos($codigoMls,$rutaImagenes,$fotoPortada)
    {
         $fotos=[$rutaImagenes.$fotoPortada];//añade al arreglo la foto portada
         if (($imagenes = fopen($rutaImagenes, "r")) !== FALSE) 
         {
                while (($imagen = fgetcsv($imagenes, 1000, ",",'"')) !== FALSE) 
                    {
                                                    
                        if(($imagen[1]==$codigoMls && count($fotos)<8)&&($imagen[0]!=$fotoPortada))
                            {
                                if(count($fotos<8))
                                {
                                    array_push($fotos,$rutaImagenes.$imagen[0]);
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

    public function contabilizarResultados($array,$valor)
    {

    }
    ///////////////////Fin de metodos de insercion y consultas ////////////////////////////////////////////


    public function conectar()
    {
           //La letra representa el id de tipo de inmueble que se carga de los datos sincronizados, el valor numerico
           //representa el id del tipo de inmueble en el sistema de inmueblescaracas...
           $tipoInmueble=[
                            'A'=>1,'B'=>2,'C'=>2,'D'=>3,'E'=>1,'F'=>4,'G'=>1,'H'=>1,
                            'I'=>4,'J'=>4,'L'=>4,'O'=>2,'P'=>2,'Q'=>1,'R'=>3,'S'=>5,
                            'T'=>1,'W'=>5,'X'=>3,'Y'=>4,'Z'=>3
                        ];
            $ciudades=[];
            $urbanizaciones=[];
            $estados=[];
            ////////////////////////////////////////////////////////////////////////////
            ini_set('max_execution_time', 6400); 
            $rutaImagenes="http://img.century21.com.ve/getmedia.asp?id=";


            $ftp_server="216.155.132.149";
            $ftp_user="inmueblescaracas";
            $ftp_password="sdkjsa$$";
            $local_file='C:/Users/Jose Tayupo/Desktop/Descargas/Century21.zip';
            $ftp_file='/FTP-TXT/Century21.zip';
            $ftp_download=false;

            /////////// Conectarme al ftp //////////////
            // $ftp_connect = ftp_connect($ftp_server) or die("No se pudo conectar a $ftp_server"); 
            
            // if($ftp_connect)
            // {
            //  echo "Conexion Establecida a: $ftp_server <br>";

            //  $ftp_login=ftp_login($ftp_connect, $ftp_user, $ftp_password) or die("No se pudo realizar la coneccion usado las credenciales indicadas");
            //  if($ftp_login)
            //  {
            //      echo "Usted esta conectado con el usuario: $ftp_user <br>";
            //      echo "Iniciando descarga del archivo.....<br>";
            //      ftp_pasv($ftp_connect, true);
            //      $ftp_download=ftp_get($ftp_connect, $local_file, $ftp_file, FTP_BINARY) or die("no se pudo realizar la descarga");

            //      if($ftp_connect)
            //      {
            //          echo "La descarga del archivo: $ftp_file , se hizo correctamente <br>";
            //      }
            //      else
            //      {
            //          echo $ftp_download;
            //      }
            //      ftp_close($ftp_connect);
            //      echo "Conexion FTP cerrada <br>";
            //      echo "Descomprimiendo el archivo: $local_file <br>";
            //      //$file= new ZipArchive();
            //      //$file->open($local_file);
            //      $extract=Zipper::make($local_file)->extractTo('C:/Users/Jose Tayupo/Desktop/Descargas/Century21');
            //      // Excel::load('C:/Users/Jose Tayupo/Desktop/Descargas/Century21/ciudades.csv',function($reader)
            //      //  {
            //      //      foreach ($reader->get() as $archivo) 
            //      //      {
            //      //          echo "$archivo";//dd($archivo); //'Id: '.$archivo[0]s.'<br>';
            //      //      }
            //      //  });
      //               echo "el archivo se descomprimio correctamente";
                    $i=0;
                    
                    $oficina_id='23646';
                   
                    $estados=[];
                    $ciudades=[];
                    $urbanizaciones=[];

                    $c=0;
                    if (($gestor = fopen("C:/Users/Jose Tayupo/Desktop/Descargas/Century21/propiedades.csv", "r")) !== FALSE) {
                        while (($datos = fgetcsv($gestor, 1000, ",",'"')) !== FALSE) 
                        {
                                   
                                  
                                  
                                   $longitud=count($datos);
                                 
                                                                                     
                                   if (($longitud==25||$longitud==26)) 
                                   {
                                        

                                                                              //filtrar estado
                                        if (($datos[10]=='VARGAS'||$datos[10]=='MIRANDA'||$datos[10]=='DISTRITO FEDERAL')&&($c<3)) 
                                        {
                                           
                                            
                                            $c=$c+1;
                                            ////verificar existencia de la propiedad ///obtener propiedad si esxiste
                                            $propiedadCon=Propiedad::where('id_mls',(int)$datos[1])->first();
                                            if ($propiedadCon==null) //SI NO EXISTE LA PROPIEDAD EN EL SISTEMA
                                            {
                                               

                                               //insertamos/consultamos las direcciones
                                               

                                               $aux=$this->direccionesPropiedad($datos[10],$datos[12],$datos[14],$datos[11],$datos[13]);
                                               
                                               $logitudEstados=$aux['inserciones']
                                               echo "$longitud";

                                              dd($aux);


                                                
                                            }//filtro propiedades
                                                                                
                                        }//filtro por estado
                                   }//filtro longitud
                                   $i=$i+1;


                                  
                                        
                                    }//fin del while del archivo
                                }//fin del if del archivo
                               
                                //echo"\n Oficina_id: $oficina_id \n\n";
                            
                            
                                return 0;

            
    }
}
