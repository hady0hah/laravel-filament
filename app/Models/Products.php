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
        return $this->belongsToMany(Technology::class, 'product_technology', 'product_id', 'technology_id')->withTimestamps();
    }



}
