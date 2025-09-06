<?php

namespace App\Http\Middleware;

use App\Models\Category;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ValidateCategory
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
            
            $category = Category::where('categorySlug', $slug)->first();

        
        if (!$category) {
            
            return response()->json([
                "status" => "error",
                "message" => "category not found"
            ], 404);
        }

        $rules=[


            'categoryName'=>['required','string','max:255','unique:categories,categoryName,' . $category->id],
            'categoryDescription'=>['required','string'],
            'categoryImage'=>['required','image','mimes:jpeg,png,jpg,gif,svg','max:2048']



        ];

        }

        else{

            $rules=[


                'categoryName'=>['required','string','max:255','unique:categories,categoryName'],
                'categoryDescription'=>['required','string'],
                'categoryImage'=>['required','image','mimes:jpeg,png,jpg,gif,svg','max:2048']
    
    
    
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
