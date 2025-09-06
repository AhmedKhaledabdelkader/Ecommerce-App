<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subcategory extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'subcategoryName',
        'subcategoryDescription',
        'subcategorySlug',
        'subcategoryImage'
    ];

 
    public static function boot()
    {
        parent::boot();

        static::creating(function ($subcategory) {
            if (empty($subcategory->subcategorySlug)) {
                $subcategory->subcategorySlug = Str::slug($subcategory->subcategoryName);
            }
        });

        static::updating(function ($subcategory) {
            if (empty($subcategory->subcategorySlug)) {
                $subcategory->subcategorySlug = Str::slug($subcategory->subcategoryName);
            }
        });
    }






    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_subcategory');
    }





}
