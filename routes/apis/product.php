

<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;




Route::middleware(["auth.user"])->group(function(){


Route::get('/', [ProductController::class, 'index'])->middleware(['localize']);

Route::get('/search', [ProductController::class, 'search'])->middleware(['localize']); 

Route::get('/{slug}', [ProductController::class, 'show'])->middleware(['localize']);  

Route::post('/', [ProductController::class, 'store'])
 ->middleware(['validate.product']);

Route::post('/{slug}', [ProductController::class, 'update'])
->middleware(['validate.product']); 

Route::delete('/{slug}', [ProductController::class, 'destroy']); 


});


