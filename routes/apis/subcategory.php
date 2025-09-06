

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SubcategoryController;





Route::middleware(["auth.user"])->group(function () {


    Route::get('/', [SubcategoryController::class, 'index']);
    Route::get('/{slug}', [SubcategoryController::class, 'show']);  
    Route::post('/', [SubcategoryController::class, 'store'])
    ->middleware(['validate.subcategory']);
    Route::post('/{slug}', [SubcategoryController::class, 'update'])
    ->middleware(['validate.subcategory']); 
    Route::delete('/{slug}', [subcategoryController::class, 'destroy']); 



});

