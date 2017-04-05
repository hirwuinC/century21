<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    public function permisos(){
      return $this->belongsToMany('App\User')->using('App\Models\RolePermiso');
    }

    public $timestamps = false;

}
