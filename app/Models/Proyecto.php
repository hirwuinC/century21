<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $table='proyectos';
    public $timestamps = false;
    protected $fillable=['id','tipoNegocio','nombreProyecto','metrosConstruccion','fechaEntrega','estado_id','ciudad_id','direccionProyecto','descripcionProyecto','posicionMapa','visitas','compradorInteresado','cargado','cargadoPor','destacado'];


  public function scopeSearchProyecto($query,$proyecto){
    return $query->where('nombreProyecto','like','%'.$proyecto.'%')
                 ->orwhere('id','like','%'.$proyecto.'%');
  }
}
