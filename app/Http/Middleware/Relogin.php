<?php
namespace App\Http\Middleware;
use Closure;
use Session;
class Relogin
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
        
         if (Session::has('usuario')) 
        {
            return redirect('/admin/index');
            
        }
        else{
            return $next($request);
        }
       
    }
}