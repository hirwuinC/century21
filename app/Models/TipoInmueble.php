<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoInmueble extends Model
{
    protected $table='tipoinmueble';
    protected $fillable=['id','nombre'];

    public $timestamps = false;
}
