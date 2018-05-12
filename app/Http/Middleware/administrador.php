<?php
namespace App\Http\Middleware;
use Closure;
use Session;
class administrador
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Session::has('usuario') && Session::get('asesor')->rol_id==1) 
        {
            return $next($request);
        }
        else{
            Session::flash('status','Error');
            return redirect('/admin/index');
        }
       
    }
}