

<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrderController;




Route::middleware(["auth.user"])->group(function(){


Route::post('/',[OrderController::class,"store"]);

Route::put('/cancel/{id}',[OrderController::class,"cancelOrder"]);
Route::put('/process/{id}',[OrderController::class,"processOrder"]);
Route::put('/ship/{id}',[OrderController::class,"shippedOrder"]);



});
