<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Agente;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController{

  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function cargarSidebar(){
    $userall=Session::get('asesor');
    $permisos=Session::get('permisos');
    $submodulos=Session::get('submodulos');
    return compact('permisos','submodulos','userall');
  }

}
