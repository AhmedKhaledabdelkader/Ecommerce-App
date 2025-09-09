<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;

class OrderController extends Controller
{
    

    public function store(Request $request){


        $cart=Cart::where("id",$request->cart_id)->first();

        if (!$cart) {
            
            return response()->json([


           "message"=>"cart with id $request->cart_id not found "



            ],404);

        }


        $items=$cart->items;

        $totalPrice=0; 

       

        foreach($items as $index=>$item){

        
        $product_quantity=Product::where("id",$item["product"]["id"])->first();

        if ($product_quantity->quantity<$item["quantity"]) {
            
            return response()->json(["message"=>"quantity over stock"],400);
            
        }

        
          $totalPrice+=$item["product"]["price"]*$item["quantity"];
          

          


        }




        $order=Order::create([


            "cart_id"=>$cart->id,
            "user_id"=>$cart->user_id,
            "shipping"=>$request->shipping,
            "total_price"=>$totalPrice
           



        ]);



        return response()->json([

            "message"=>"order created successfully",
            "order"=>$order




        ],201);




    }


    public function cancelOrder($id)
{
    $order = Order::find($id);

    if (!$order) {
        return response()->json([
            "message" => "Order with id $id not found"
        ], 404);
    }

 
    if ($order->status === "processing" || $order->status === "shipped") {
        $cart = Cart::where("id", $order->cart_id)->first();
        $items = $cart->items;

        foreach ($items as $item) {
            $product = Product::find($item["product"]["id"]);
            if ($product) {
                $product->quantity += $item["quantity"];
                $product->sold_count -= $item["quantity"];
                $product->save();
            }
        }
    }

    $order->status = "cancelled";
    $order->save();

    return response()->json([
        "message" => "Order cancelled successfully"
    ], 200);
}


public function processOrder($id)
{
    $order = Order::find($id);

    if (!$order) {
        return response()->json([
            "message" => "Order with id $id not found"
        ], 404);
    }

    
    if ($order->status !== "pending") {
        return response()->json([
            "message" => "Order already processed"
        ], 400);
    }

    $cart = Cart::find($order->cart_id);
    $items = $cart->items;

    foreach ($items as $item) {
        $product = Product::find($item["product"]["id"]);

        if ($product) {
            
            if ($product->quantity < $item["quantity"]) {
                return response()->json([
                    "message" => "Not enough stock for product {$product->name}"
                ], 400);
            }

            $product->quantity -= $item["quantity"];   
            $product->sold_count += $item["quantity"]; 
            $product->save();
        }
    }

    $order->status = "processing";
    $order->save();

    return response()->json([
        "message" => "Order processed successfully, stock updated"
    ], 200);
}




public function shippedOrder($id)
{
    $order = Order::find($id);

    if (!$order) {
        return response()->json([
            "message" => "Order with id $id not found"
        ], 404);
    }

   
    $order->status = "shipped";
    $order->save();

    return response()->json([
        "message" => "Order shipped successfully"
    ], 200);
}





}
