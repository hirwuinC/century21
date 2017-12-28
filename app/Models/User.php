<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table="users";

    public function scopeSearchUser($query,$argumento){
    	return $query->where('name',$argumento[0])
    			         ->orwhere('email',$argumento[1])
                   ->orwhere('rif_user',$argumento[2]);
    }
}
