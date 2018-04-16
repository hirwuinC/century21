<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comprador extends Model
{
    protected $table="compradores";
    public $timestamps = false;
    protected $fillable = ['cedula',"fullNameComprador","email","edad","sexo","ocupacion","grupoFamilia"];
    public function scopeSearchComprador($query,$comprador){
    	return $query->where('fullNameComprador','like','%'.$comprador.'%')
    			         ->orwhere('cedula','like','%'.$comprador.'%');
    }
}
