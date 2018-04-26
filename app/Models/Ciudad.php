<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    protected $table='ciudades';
    public $timestamps = false;
    protected $fillable=['id','nombre','estado_id','codigo_id'];
}
