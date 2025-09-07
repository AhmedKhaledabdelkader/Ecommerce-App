<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->json('productName')->unique();
            $table->string('sku')->nullable()->unique();
            $table->json('productDescription');
            $table->string('productSlug')->unique();
            $table->string('productImage');
            $table->decimal('price', 10, 2);
            $table->unsignedInteger('rating_count')->default(0);     
            $table->decimal('rating_average', 3, 2)->default(0);     
            $table->unsignedInteger('sold_count')->default(0);       
            $table->unsignedInteger('quantity')->default(0);  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
