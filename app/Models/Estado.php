<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    //
    protected $table="estados";
    public $timestamps = false;
    protected $fillable=['id','nombre','ref_if'];
}
