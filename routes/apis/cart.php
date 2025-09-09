



<?php

use App\Http\Controllers\Api\CartController;
use Illuminate\Support\Facades\Route;




Route::middleware(["auth.user"])->group(function(){

Route::post('/', [CartController::class, 'store']);  

Route::post('/add/{cartId}', [CartController::class, 'add']);

Route::delete("/remove/{cartId}/{productId}",[CartController::class,'remove']);

Route::get('/',[CartController::class,'index']);

Route::get("/{cartId}",[CartController::class,"show"]);

Route::delete("/clear/{cartId}",[CartController::class,"clear"]);
 

});

