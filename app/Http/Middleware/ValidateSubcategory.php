<?php

namespace App\Http\Middleware;

use App\Models\Subcategory;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ValidateSubcategory
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $slug = $request->route('slug');

        if ($slug) {


            $subcategory = Subcategory::where('subcategorySlug', $slug)->first();

            if (!$subcategory) {
                
                return response()->json([
                    "status" => "error",
                    "message" => "Subcategory not found"
                ], 404);
            }
    
            $rules=[
    
    
                'subcategoryName'=>['required','string','max:255','unique:subcategories,subcategoryName,' . $subcategory->id],
                'subcategoryDescription'=>['required','string'],
                'subcategoryImage'=>['required','image','mimes:jpeg,png,webp,jpg,gif,svg','max:2048'],
                'categories' => ['required','array'],          
                'categories.*' => ['exists:categories,id'], 
    
            ];
            
        }


        else{
    
            $rules=[
    
    
                'subcategoryName'=>['required','string','max:255','unique:subcategories,subcategoryName'],
                'subcategoryDescription'=>['required','string'],
                'subcategoryImage'=>['required','image','mimes:jpeg,png,webp,jpg,gif,svg','max:2048'],
                'categories' => ['required','array'],          
                'categories.*' => ['exists:categories,id'], 
            ];
    
        }
      

        
        $validator=Validator::make($request->all(),$rules);


        if($validator->fails()){


            return response()->json([
                "status"=>"error",
                "message"=>"validation failed",
                "errors"=>$validator->errors()

            ],422);
 



        }









        return $next($request);
    }
}
