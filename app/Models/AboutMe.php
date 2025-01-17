<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutMe extends BaseModel
{
    use HasFactory;
    protected $table = 'about_me';

    protected $fillable = [
        'title',
        'tags',
        'image_path',
        'description',
        'published',
    ];
}
