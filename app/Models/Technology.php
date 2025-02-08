<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technology extends BaseModel
{
    use HasFactory;

    protected $table = 'technologies';

    protected $fillable = [
        'name',
        'image_path',
        'published',
    ];


    public function products()
    {
        return $this->belongsToMany(Products::class, 'product_technology', 'technology_id', 'product_id')->withTimestamps();
    }


}
