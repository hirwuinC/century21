<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Urbanizacion extends Model
{
    protected $table="urbanizaciones";
    public $timestamps = false;
    protected $fillable=['id','nombre','ciudad_id','codigo_id'];
}
