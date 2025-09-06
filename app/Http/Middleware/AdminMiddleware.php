<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use function Symfony\Component\VarDumper\Dumper\esc;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        $user=$request->user();



        if ($user) {
            

            if($user->role !='admin'){


                return response()->json([
                    "status"=>"error",
                    "message"=>"user is not authorized to access this resource"
                ],403);
             

            }

         
        
            return $next($request);


        }
      
        else{


            return response()->json([
                "status"=>"error",
                "message"=>"user is unauthenticated"
            ],401);


        }







    }
}
