<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    

public function store(Request $request){

$user_id=$request->user()->id ;


$user=Cart::where("user_id",$user_id)->first();

if ($user) {
    
    return response()->json(["message"=>"this user is existed before"],400);
}


$cart=Cart::create([

    "user_id"=>$user_id,
    "status"=>"active",
    "items"=>[]



]);


return response()->json([

    "message"=>"creating cart successfully",
    "cart"=>$cart


]);  



}



public function add(Request $request,$cartId){

    
    $user_id=$request->user()->id ;




    $validator=Validator::make($request->all(),[

        "product_id"=>["required","exists:products,id"],
        "quantity"=>["required","integer","min:1"]

    ]);


  
    if ($validator->fails()) {
        
        return response()->json([
            "status"=>"error",
            "message"=>"validation failed",
            "errors"=>$validator->errors()

        ],422);

    }



    $my_cart=Cart::where("id",$cartId)->first();

    if (! $my_cart) {
        
        return response()->json([

            "message"=>"cart not found"

        ],404);
    }




    $cart=Cart::where("id",$cartId)->where("user_id",$user_id)->first();


    $items=$cart->items ??[];

    $product = Product::findOrFail($request->product_id);
    $productData = $product->only(['id', 'productName','productDescription', 'price']);


    $found=false;

    foreach($items as $index=>$item){

      if ($item["product"]["id"]==$request->product_id) {
    
        $items[$index]["quantity"]=$item["quantity"]+$request->quantity;
          
        $found=true;
        break;

      }


    }

    if (!$found) {
        
        $items[] = [
            'product'  => $productData,
            'quantity' => $request->quantity
        ];


    }

$cart->items = $items;
$cart->save();


return response()->json(['message' => 'Item added successfully', 'cart' => $cart]);


}




// remove product


public function remove($cartId,$productId){


  
 //   $user_id=$request->user()->id ;


 


    $cart=Cart::where("id",$cartId)->first();


    $product=Product::where("id",$productId)->first();

    if (!$cart) {
    
        return response()->json([
            "message"=>"cart with id $cartId not found"
        ],404);
    }

    if (!$product) {
    
        return response()->json([
            "message"=>"product with id $productId not found"
        ],404);
    }




    $items=$cart->items??[];

    foreach($items as $index=>$item){

        if ($item["product"]["id"]==$productId) {
        
          unset($items[$index]);

        }

    }

    $cart->items=$items;
    $cart->save();


    return response()->json([


        "message"=>"the item with product id $productId is deleted successfully"


    ],200);







}


public function index(Request $request){



    return response()->json([

        "message"=>"retreiving carts successfully",
         "carts"=>Cart::all()


    ]);




}


public function show($cartId){


    $cart=Cart::where("id",$cartId)->first();

    if (!$cart) {
        
        return response()->json([


            "message"=>"cart with id $cartId not found",


        ],404);

    }

    return response()->json([

        "message"=>"returning cart successfully",
        "cart"=>$cart


    ]);





}



public function clear($cartId){


    $cart=Cart::where("id",$cartId)->first();

    if (!$cart) {
        
        return response()->json([

            "message"=>"cart with id $cartId not found"

        ],404);

    }


    $cart->items=[] ;

    $cart->save();


return response()->json([

    "message"=>"cart is cleared successfully"



],200);


}







}
