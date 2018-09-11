<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table='medias';
    public $timestamps = false;
    protected $fillable=['id','nombre','propiedad_id','vista','alias'];
}
