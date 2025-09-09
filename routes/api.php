<?php


use Illuminate\Support\Facades\Route;






Route::prefix('user')->group(base_path('routes/apis/user.php'));

Route::prefix('categories')->group(base_path('routes/apis/category.php'));

Route::prefix('subcategories')->group(base_path('routes/apis/subcategory.php'));

Route::prefix('products')->group(base_path('routes/apis/product.php'));

Route::prefix('reviews')->group(base_path('routes/apis/review.php'));

Route::prefix('cart')->group(base_path('routes/apis/cart.php'));