<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    

    public function store(Request $request){



     $userId=$request->user()->id ;


     $existing=Review::where("product_id",$request->product_id)->
        where("user_id",$userId)->first();


        if ($existing) {


            return response()->json([
                "status" => "error",
                "message" => "You have already reviewed this product"
            ], 400);


            
        }
     

     
        $review=Review::create([
    
            'user_id'=>$userId,
            'product_id'=>$request->product_id,
            'rating'=>$request->rating,
            'comment'=>$request->comment
    
        ]);


        $product=$review->product ;

        $ratingCount=$product->reviews->count();

        $ratingAverage=$product->reviews->avg('rating');

        $product->rating_count=$ratingCount;

        $product->rating_average=$ratingAverage;


        $product->save(); // to listen update in database





      
        return response()->json([
    
            "status"=>"success",
            "message"=>"review added successfully",
            "data"=>$review
    
        ],201);




    }


    public function index($productId)
    {


        $reviews = Review::where('product_id', $productId)
                         ->with('user:id,username,email,phone')
                         ->get();

        
                         if (!$reviews) {
            return response()->json([

                'status' => 'error',
                'message' => 'No reviews found for this product'
            ], 404
        );
                            
                         }

    
        return response()->json([
            'status' => 'success',
            'reviews' => $reviews
        ]);
    }
    


    public function destroy($reviewId){


        $review=Review::find($reviewId);

        if ($review) {
            
            $review->delete();

            return response()->json([

                "status"=>"success",
                "message"=>"review deleted successfully"

            ],200);

        }
       else{

        return response()->json([

            "status"=>"error",
            "message"=>"review not found"

        ],404);

       }





    }








}
