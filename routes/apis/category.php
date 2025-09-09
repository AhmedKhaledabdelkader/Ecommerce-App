<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;




Route::middleware(["auth.user"])->group(function(){

Route::get('/', [CategoryController::class, 'index']);
Route::get('/{slug}', [CategoryController::class, 'show']);  
Route::post('/', [CategoryController::class, 'store'])
 ->middleware(['validate.category']);
Route::post('/{slug}', [CategoryController::class, 'update'])
->middleware(['validate.category']); 
Route::delete('/{slug}', [CategoryController::class, 'destroy']); 





});


