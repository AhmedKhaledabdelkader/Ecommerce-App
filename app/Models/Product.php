<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
class Product extends Model
{
    use HasFactory;


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


    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    public function subcategories()
    {
        return $this->belongsToMany(Subcategory::class, 'product_subcategory');
    }


}
