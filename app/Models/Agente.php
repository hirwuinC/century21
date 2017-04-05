<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agente extends Model
{
    //
    public function propiedades(){
      return $this->hasMany('App\Models\Propiedad')
    }

    public $timestamps = false;

}
