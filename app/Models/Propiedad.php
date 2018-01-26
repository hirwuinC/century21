<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Propiedad extends Model
{
    protected $table='propiedades';
    
    public function agente(){
      return $this->belongsTo('App\Models\Agente');
    }

    public function status(){
      return $this->hasOne('App\Models\Status');
    }

    public function media(){
      return $this->hasMany('App\Modles\Media');
    }

    public $timestamps = false;
}
