<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends BaseModel
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'about',
        'description',
        'link',
        'image_path',
        'show_in_homepage',
        'published',
    ];

    public function technologies()
    {
//        $allProducts = Products::withoutGlobalScope('published')->get(); without global scope without published
//        $allProducts = Product::withoutGlobalScopes()->get(); without all global scope queries
//        $allProducts = Products::get(); with global scope with published


        return $this->belongsToMany(Technology::class, 'product_technology', 'product_id', 'technology_id')->withTimestamps();
    }



}
