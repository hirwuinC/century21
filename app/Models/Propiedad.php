<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Propiedad extends Model
{
    protected $table='propiedades';
    public $timestamps = false;

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
