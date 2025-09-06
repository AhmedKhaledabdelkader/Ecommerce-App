<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
class Category extends Model
{

    use HasFactory;


    protected $fillable = [
        'categoryName',
        'categoryDescription',
        'categorySlug',
        'categoryImage'
    ];


    public static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->categorySlug)) {
                $category->categorySlug = Str::slug($category->categoryName);
            }
        });

        static::updating(function ($category) {
            if (empty($category->categorySlug)) {
                $category->categorySlug = Str::slug($category->categoryName);
            }
        });
    }


    public function subcategories()
    {
        return $this->belongsToMany(Subcategory::class, 'category_subcategory');
    }





}
