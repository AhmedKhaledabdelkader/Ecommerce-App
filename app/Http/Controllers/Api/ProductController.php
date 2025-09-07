<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class ProductController extends Controller
{
   
    public function index()
    {
        

      
    
        $products = Product::with(['categories','subcategories'])->get()->map(function ($product) {
            return [
                "id" => $product->id,
                "productName" =>$product->productName,
                "productDescription" => $product->productDescription,
                "price" => $product->price,
                "quantity" => $product->quantity,
                "productImage" =>$product->productImage,
                "rating_count" => $product->rating_count,
                "rating_average" => $product->rating_average,
                "sold_count" => $product->sold_count,
                "categories" => $product->categories,
                "subcategories" => $product->subcategories,
            ];
        });

       

        return response()->json([

            "status"=>"success",
            "message"=>"products retrieved successfully",
            "data"=>$products

        ],200);




    }

  
    public function store(Request $request)
    {
     

      try{



        $image = $request->file('productImage');
        $imagePath= $image->store('products', 'public'); 



        $product=Product::create([

           "productName"        => $request->productName,         
           "productSlug"        => Str::slug($request->input("productName.en")), 
           "productDescription" => $request->productDescription,  
            "price"=>$request->price,
            "sku"=>$request->sku??null,
            "quantity"=>$request->quantity,
            "productImage"=>$imagePath,
            "rating_count"=>0,
            "rating_average"=>0,
            "sold_count"=>0

        ]);

        
    
        


        $product->categories()->attach($request->categories);

        $product->subcategories()->attach($request->subcategories);


        return response()->json([

            "status"=>"success",
            "message"=>"product created successfully",
           'subcategory' => $product->load(['categories','subcategories'])

        ],201);






      }catch(Exception $e){


        return response()->json([

            "status"=>"error",
            "message"=>"an error occurred while creating the product",
            "error"=>$e->getMessage()

        ],500);

      }


    }

   
    public function show(string $slug)
    {
        $product=Product::where('productSlug',$slug)->with(['categories','subcategories'])->first();

        if(!$product){

            return response()->json([

                "status"=>"error",
                "message"=>"product not found"

            ],404);
    

    }

   
    $mappedProduct=[
        "id" => $product->id,
        "productName" =>$product->productName,
        "productDescription" => $product->productDescription,
        "price" => $product->price,
        "quantity" => $product->quantity,
        "productImage" =>$product->productImage,
        "rating_count" => $product->rating_count,
        "rating_average" => $product->rating_average,
        "sold_count" => $product->sold_count,
        "categories" => $product->categories,
        "subcategories" => $product->subcategories,
    ];

    

        return response()->json([

            "status"=>"success",
            "message"=>"product retrieved successfully",
            "data"=>$mappedProduct

        ],200);

}

   
    public function update(Request $request, string $slug)
    {

        $product=Product::where("productSlug",$slug)->first();
        


        $product->productName=$request->productName;
        $product->productSlug=Str::slug($request->productName['en']);
        $product->productDescription=$request->productDescription;
        $product->price=$request->price;
        $product->sku=$request->sku??$product->sku;
        $product->quantity=$request->quantity;
        

        if ($product->productImage) {
            Storage::disk('public')->delete($product->productImage);
        }

        $image = $request->file('productImage');
        $imagePath= $image->store('products', 'public'); 
        $product->productImage=$imagePath;

        $product->save();


        $product->categories()->sync($request->categories);
        $product->subcategories()->sync($request->subcategories);


        return response()->json([

            "status"=>"success",
            "message"=>"product updated successfully",
           'product' => $product->load(['categories','subcategories'])

        ],200);
        

    

}
   
    public function destroy(string $slug)
    {
    

        $product=Product::where("productSlug",$slug)->first();

        if($product){

          
            Storage::disk('public')->delete($product->productImage);
            

            $product->categories()->detach();
            $product->subcategories()->detach();

            $product->delete();

            return response()->json([

                "status"=>"success",
                "message"=>"product deleted successfully"

            ],200);

        }
       else{

        return response()->json([

            "status"=>"error",
            "message"=>"product not found"

        ],404);

       }


    }



    public function search(Request $request){


        $query = $request->input('q');

        $products = Product::where('productName', 'LIKE', '%' . $query . '%')
            ->orWhere('productDescription', 'LIKE', '%' . $query . '%')
            ->with(['categories','subcategories'])
            ->get()->map(function ($product) {
                return [
                    "id" => $product->id,
                    "productName" =>$product->productName,
                    "productDescription" => $product->productDescription,
                    "price" => $product->price,
                    "quantity" => $product->quantity,
                  //  "productImage" => asset('storage/'.$product->productImage),
                  "productImage" => $product->productImage,
                    "rating_count" => $product->rating_count,
                    "rating_average" => $product->rating_average,
                    "sold_count" => $product->sold_count,
                    "categories" => $product->categories,
                    "subcategories" => $product->subcategories,
                ];
            });
    

        return response()->json([
            "status" => "success",
            "message" => "search results",
            "data" => $products
        ], 200);





    }







}
