<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Propiedad extends Model
{
    protected $table='propiedades';
    public $timestamps = false;
    protected $fillable=
    ['id','id_mls','tipo_inmueble','tipoNegocio','urbanizacion','precio','visible','habitaciones','banos',
     'estacionamientos','metros_construcccion','metros_terreno','comentario','agente_id','estado_id',
     'ciudad_id','direccion','oficina_id','posicionMapa','visitas','compradorInteresado','cargado','cargadoPor',
     'proximoInforme','destacado','estatus','referenciaDolares','fechaCeado','mostrarMapa','porcentajeCaptacion'];

    public function agente(){
      return $this->belongsTo('App\Models\Agente');
    }

    public function status(){
      return $this->hasOne('App\Models\Status');
    }

    public function media(){
      return $this->hasMany('App\Models\Media');
    }
    public function scopeSearchPropiedad($query,$inmueble){
    	return $query->where('id','like','%'.$inmueble.'%')
                   ->orwhere('id_mls','like','%'.$inmueble.'%');
    }

}
