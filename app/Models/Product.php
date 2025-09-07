<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasFactory,HasTranslations;


    protected $fillable = [
        'productName',
        'productSlug',
        'productDescription',
        'price',
        'sku',
        'quantity',
        'productImage',
        'rating_count',
        'rating_average',
        'sold_count'
    ];

    public $translatable = ['productName', 'productDescription'];

  

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    public function subcategories()
    {
        return $this->belongsToMany(Subcategory::class, 'product_subcategory');
    }


    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


}
