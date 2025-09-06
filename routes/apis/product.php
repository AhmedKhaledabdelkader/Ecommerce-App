

<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;




Route::middleware(["auth.user"])->group(function(){


Route::get('/', [ProductController::class, 'index']);

Route::get('/search', [ProductController::class, 'search']); 

Route::get('/{slug}', [ProductController::class, 'show']);  

Route::post('/', [ProductController::class, 'store'])
 ->middleware(['validate.product']);

Route::post('/{slug}', [ProductController::class, 'update'])
->middleware(['validate.product']); 

Route::delete('/{slug}', [ProductController::class, 'destroy']); 








});


