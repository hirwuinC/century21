<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\Propiedad;

class Script extends Controller
{
    public function imagenesName()
    {
    	ini_set('max_execution_time', 6400); 
    	$ruta='http://img.century21.com.ve/getmedia.asp?id=';
    	$fotos=Media::where('id','>',44)->where('vista','=',0)->get();

    	foreach ($fotos as $foto) 
    	{
    		$imagen=Media::find($foto->id);
    			$nombre=$ruta.$imagen->nombre;
    			$imagen->nombre=$nombre;
    		$imagen->save();
    	}

    	
    }

    public function setMapa()
    {
    	ini_set('max_execution_time', 6400); 
    	$coordenadas='[{"lat":10.47716930106114,"lng":-66.85339290098875}]';
    	$propiedades=Propiedad::where('id','>',5)->get();
    	foreach ($propiedades as $propiedad) 
    	{
    		$inmueble=Propiedad::find($propiedad->id);
    			$inmueble->posicionMapa=$coordenadas;
    		$inmueble->save();
    	}

    }

    /////////////////////Prueba curl //////////////////////////
}
