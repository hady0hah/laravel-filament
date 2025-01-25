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
}
