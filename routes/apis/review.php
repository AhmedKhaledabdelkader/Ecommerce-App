

<?php

use App\Http\Controllers\Api\ReviewController;
use Illuminate\Support\Facades\Route;





Route::middleware(["auth.user"])->group(function(){




Route::post('/', [ReviewController::class, 'store'])->middleware(["validate.review"]);  
 

Route::get('/product-reviews/{productId}', [ReviewController::class, 'index']);  


Route::delete('/{reviewId}',[ReviewController::class,'destroy']);

 





});


