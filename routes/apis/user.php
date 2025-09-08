

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SubcategoryController;






Route::post('/register', [AuthController::class, 'register'])->middleware(["validate.user","localize"]);
Route::post('/login', [AuthController::class, 'login']);


Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])
    ->middleware('signed')
    ->name('verification.verify');


Route::post('/email/resend', [AuthController::class, 'resend']);


Route::middleware(['auth.user'])->group(function(){


Route::post('/logout', [AuthController::class, 'logout']);

Route::post('/logoutAll', [AuthController::class, 'logoutAll']);

});
