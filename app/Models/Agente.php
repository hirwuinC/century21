<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agente extends Model
{
    protected $table='agentes';
    public $timestamps = false;
    protected $fillable=['id','fullName','cedula','telefono','celular','email','certified_asesor','codigo_id','imagen_id'];

    public function propiedades(){
    	return $this->hasMany('App\Models\Propiedad');
    }
    public function scopeSearchAsesor($query,$asesor){
    	return $query->where('fullName','like','%'.$asesor.'%')
                   ->orwhere('codigo_id','like','%'.$asesor.'%')
                   ->where('id','<>','5');
    }


}
