<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ValidateReview
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response

    {



    
        $rules = [

            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['nullable', 'string'],
            'product_id' => ['required', 'exists:products,id']
         
        ];


        $validator = Validator::make($request->all(), $rules);




        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }


        return $next($request);
    }
}
