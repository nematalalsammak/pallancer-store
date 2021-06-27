<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next,...$types)
    {
        $user=$request->user();
        //OR
       // $user=Auth::user();

       if(! in_array($user->type,$types))
       //if($user->type!= 'admin')
       {
           abort(403,'You are not allowed');
       }
        return $next($request);

    }
}
