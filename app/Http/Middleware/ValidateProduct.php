<?php

namespace App\Http\Middleware;

use App\Models\Product;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
class ValidateProduct
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
       
        $product=Product::where("productSlug",$slug)->first();

        if (!$product) {

            return response()->json([
                "status" => "error",
                "message" => "product not found"
            ], 404);
            
        }

        $rules=[

            'productName'=>['required','string','max:255','unique:products,productName,' . $product->id],
            'sku'         => 'nullable|string|max:255|unique:products,sku,' . $product->id,
            'productDescription'=>['required','string'],
            'price'=>['required','numeric','min:0'],
            'quantity'=>['required','integer','min:0'],
            'productImage'=>['required','image','mimes:jpeg,png,webp,jpg,gif,svg','max:2048'],
            'categories' => ['required','array'],          
            'categories.*' => ['exists:categories,id'], 
            'subcategories' => ['required','array'],          
            'subcategories.*' => ['exists:subcategories,id'], 
            'rating_count'   => ['nullable','integer','min:0'],
            'rating_average'  => ['nullable','numeric','min:0','max:5'],
            'sold_count'     => ['nullable','integer','min:0'],
          
       

        ];





    }

    else{



        $rules=[

            'productName'=>['required','string','max:255','unique:products,productName'],
            'sku'         => 'nullable|string|max:255|unique:products,sku',
            'productDescription'=>['required','string'],
            'price'=>['required','numeric','min:0'],
            'quantity'=>['required','integer','min:0'],
            'productImage'=>['required','image','mimes:jpeg,png,webp,jpg,gif,svg','max:2048'],
            'categories' => ['required','array'],          
            'categories.*' => ['exists:categories,id'], 
            'subcategories' => ['required','array'],          
            'subcategories.*' => ['exists:subcategories,id'], 
            'rating_count'   => ['nullable','integer','min:0'],
            'rating_average'  => ['nullable','numeric','min:0','max:5'],
            'sold_count'     => ['nullable','integer','min:0'],
          
       

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
