<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agente extends Model
{
    protected $table='agentes';
    public $timestamps = false;

    public function propiedades(){
    	return $this->hasMany('App\Models\Propiedad');
    }
    public function scopeSearchAsesor($query,$asesor){
    	return $query->where('fullName','like','%'.$asesor.'%')
    			         ->orwhere('cedula','like','%'.$asesor.'%')
                   ->orwhere('ref_id','like','%'.$asesor.'%');
    }


}
